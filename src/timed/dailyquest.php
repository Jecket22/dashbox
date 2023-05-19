<?php
require (__DIR__) . "/../lib/constants.php";
if (empty($_POST["chk"]) || empty($_POST["udid"]) || $_POST["secret"] != Secrets::$commonSecret)
    exit(GenericResponse::$Error);

$userID = (isset($_POST["uuid"])) ? $_POST["uuid"] : $_POST["accountID"];
if ($userID == 0) $userID = 1;

require (__DIR__) . "/../lib/database.php";

$dailyquests = $db->query("SELECT * FROM dailyquests");
$dailyquests = $dailyquests->fetchAll();

$time = strtotime($dailyquests[0]['expire']);

if ($time < strtotime("tomorrow 00:00:00")) {
    $time = strtotime("tomorrow 00:00:00") - time();
    $quests = $db->query("SELECT id, type, requirement, reward, name FROM quests ORDER BY RAND() LIMIT 3");
    $quests = $quests->fetchAll();

    if (count($quests) < 3) exit('-1 | Not enough quests created');

    for ($i = 0; $i < 3; $i++) {
        $dailyquests = $db->prepare("UPDATE dailyquests SET questID = :id, expire = :expire WHERE id = :id");
        $dailyquests->execute(array(':questID' => $quests[$i]['id'], ':expire' => date('Y-m-d H:i:s', $time), ':id' => $i + 1));
    }
} else {
    $quests = $db->prepare("SELECT type, requirement, reward, name FROM quests WHERE id = :first OR id = :second OR id = :third");
    $quests->execute(array( ':first' => $dailyquests[0]['id'], ':second' => $dailyquests[1]['id'], ':third' => $dailyquests[2]['id']));
    $quests = $quests->fetchAll();
};

$questID = floor((time() - strtotime('2020-4-6')) / 28800);

$q = array();
for ($i = 0; $i < 3; $i++) {
    $q[] = $questID + $i . ',' . $quests[$i]['type'] . ',' . $quests[$i]['requirement'] . ',' . $quests[$i]['reward'] . ',' . $quests[$i]['name'];
}

require (__DIR__) . "/../lib/crypto.php";
$chk = Crypto::XorCipher(base64_decode(substr($_POST["chk"], 5)), 19847);
$final = "dshbx:" . $userID . ":" . $chk . ":" . $_POST["udid"] . ":" . $_POST["accountID"] . ":" . $time . ":" . $q[0] . ":" . $q[1] . ":" . $q[2];
$output = base64_encode(Crypto::XorCipher($final, 19847));

require (__DIR__) . "/../lib/hashLib.php";
exit("dshbx" . $output . "|" . hashLib::GenSolo3($output));