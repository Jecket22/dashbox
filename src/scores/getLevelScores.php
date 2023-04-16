<?php
require (__DIR__) . "../lib/constants.php";

if ((empty($_POST["accountID"]) && !is_numeric($_POST["accountID"])) || (empty($_POST["levelID"]) && !is_numeric($_POST["levelID"])) || $_POST["secret"] != Secrets::$commonSecret)
	exit(GenericResponse::$Error);

$accountID = $_POST["accountID"];
$levelID = $_POST["levelID"];
$chkCheck = 0;
if (isset($_POST["percent"]) && is_numeric($_POST["percent"])) {
	$percent = $_POST["percent"];
	$chkCheck++;
}
if (isset($_POST["s1"]) && is_numeric($_POST["s1"])) {
	$attempts = $_POST["s1"] - 8354;
	$chkCheck++;
}
if (isset($_POST["s8"]) && is_numeric($_POST["s8"]) && $attempts != $_POST["s8"]) {
	exit(GenericResponse::$Error);
}
if (isset($_POST["s2"]) && is_numeric($_POST["s2"])) {
	$clicks = $_POST["s2"] - 3991;
	$chkCheck++;
}
if (isset($_POST["s3"]) && is_numeric($_POST["s3"])) {
	$timeSpent = $_POST["s3"] - 4085;
	$chkCheck++;
}

require (__DIR__) . "/scoreLib.php";
if (isset($_POST["s4"])) {
	$levelSeed = $_POST["s4"];
	if ($levelSeed != scoreLib::genLevelSeed($clicks, $percent, $timeSpent, $attempts)) {
		exit(GenericResponse::$Error);
	}
	$chkCheck++;
}

if (empty($_POST["s6"]))
	$highscoreDifferences = "0";
else {
	require (__DIR__) . "../lib/crypto.php";
	$highscoreDifferences = Crypto::XorCipher(base64_decode($_POST["s6"]), 41274);
	// TODO: Add all of these together and compare with percentage
}

if (isset($_POST["s7"])) {
	$randomString = $_POST["s7"];
	$chkCheck++;
}
if (isset($_POST["s9"]) && is_numeric($_POST["s9"])) {
	$coins = $_POST["s9"] - 5819;
	$chkCheck++;
}
if (isset($_POST["s10"]) && is_numeric($_POST["s10"])) {
	$dailyID = $_POST["s10"];
	$chkCheck++;
}

if (isset($_POST["chk"]) && $chkCheck == 8) {
	$chkVars = [
		$accountID,
		$levelID,
		$percent,
		$timeSpent,
		$clicks,
		$attempts,
		$levelSeed,
		$highscoreDifferences,
		1, // This variable is unknown and is always set to 1
		$coins,
		$dailyID
	];
	
	require (__DIR__) . "/../lib/hashLib.php";
	if (hashLib::IsChkValid($_POST["chk"], $chkVars, 39673, "yPg6pUrtWn0J" . $randomString)) {
		exit("1:robtop:2:13320964:9:29:10:41:11:12:14:0:15:2:16:3893363:3:100:6:1:13:0:42:Success!");
	}	
}

exit("1:robtop:2:13320964:9:29:10:41:11:12:14:0:15:2:16:3893363:3:100:6:1:13:0:42:Failed!" . $randomString);
