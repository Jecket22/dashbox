<?php
require (__DIR__) . "/../lib/constants.php";

if (empty($_POST["chk"]) || empty($_POST["udid"]) || $_POST["secret"] != Secrets::$commonSecret)
	exit(GenericResponse::$Error);

$userID = (isset($_POST["uuid"])) ? $_POST["uuid"] : $_POST["accountID"]; // thank you robtop.
// if for whatever reason $userID is 0, it then prevents quests from loading.
// setting that to 1 fixes it, despite it not matching it with the actual uuid/accountID. why
// I really hope this issue only applies to non-registered users
if ($userID == 0) $userID = 1; 

require (__DIR__) . "/../lib/database.php";

$count = $db->query("SELECT COUNT(*) FROM quests");
if ($count->fetchColumn() < 3)
	exit("-1 | Not enough quests created");

// needed for named keys
$quests = $db->query("SELECT type, requirement, reward, name FROM quests ORDER BY RAND() LIMIT 3");
$quests = $quests->fetchAll();

// it's unclear what the QuestID is supposed to be
// the docs says it's the amount of quests completed (with a questionmark left afterwards)
// gmdprivateserver just generates an ID with a tiny wack calculation
// "on real gd i think that new ones are generated every day you load the endpoint [...]" - cvolton
// I'll simply base it off of that then...
$questID = floor((time() - strtotime('2020-4-6')) / 28800);
// TODO: Rework this fuck

// TODO: Add timezone from metadata
$timeleft = strtotime("tomorrow 00:00:00") - time();

$q = array();
for ($i = 0; $i < 3; $i++) {
	$q[] = $questID + $i . "," . $quests[$i]["type"] . "," . $quests[$i]["requirement"] . "," . $quests[$i]["reward"] . "," . $quests[$i]["name"];
}

require (__DIR__) . "/../lib/crypto.php";
$chk = Crypto::XorCipher(base64_decode(substr($_POST["chk"], 5)), 19847);
$final = "dshbx:" . $userID . ":" . $chk . ":" . $_POST["udid"] . ":" . $_POST["accountID"] . ":" . $timeleft . ":" . $q[0] . ":" . $q[1] . ":" . $q[2];
$output = base64_encode(Crypto::XorCipher($final, 19847));

require (__DIR__) . "/../lib/hashLib.php";
exit("dshbx" . $output . "|" . hashLib::GenSolo3($output));
