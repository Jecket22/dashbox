<?php
require (__DIR__) . "/../lib/constants.php";

if ($_POST["secret"] != Secrets::$commonSecret || !is_numeric($_POST["gameVersion"]) || empty($_POST["accountID"]) || empty($_POST["gjp"]) ||
empty($_POST["levelName"]) || !isset($_POST["levelString"]) || !isset($_POST["seed2"]))
	exit(GenericResponse::$Error);

require (__DIR__) . "/../lib/GJPUtil.php";
if (!GJPUtil::verifyPassword($_POST["gjp"], $_POST["accountID"], false))
	exit("-1 | Wrong GJP");

require (__DIR__) . "/../lib/utils.php";
// todo: check against chk/seed2
$levelName = Utils::CleanString($_POST["levelName"]);
//$levelDesc = (isset($_POST["levelName"])) ? base64_encode($_POST["levelName"]) : ""; // clearly this needs more code
$levelID = (isset($_POST["levelID"])) ? $_POST["levelID"] : 0;
$levelVersion = (isset($_POST["levelVersion"])) ? $_POST["levelVersion"] : 1;

if (!is_numeric($levelID))
	exit("-1 | Invalid Level ID");

//require (__DIR__) . "/../lib/database.php";
exit("-1");
