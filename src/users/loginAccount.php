<?php
require (__DIR__) . "/../lib/constants.php";
require (__DIR__) . "/../lib/config.php";
require (__DIR__) . "/../lib/utils.php";

if (empty($_POST["userName"]) || empty($_POST["password"]) || $_POST["secret"] != Secrets::$accountSecret)
	exit(GenericResponse::$Error);

$userName = $_POST["userName"];
$password = $_POST["password"];

require (__DIR__) . "/accountLib.php";
if (!accountLib::isUsernameValid($userName))
	exit(AccountError::$InvalidUsername);

$requireVerified = strval((Config::GetVariable("accounts", "verifyLevel") != 0) ? 1 : 0);

require (__DIR__) . "/../lib/database.php";
$hashQuery = $db->prepare("SELECT password, id FROM accounts WHERE userName = :userName AND verified >= :requireVerified");
$hashQuery->execute(array(':userName' => $userName, ':requireVerified' => $requireVerified ));
$result = $hashQuery->fetch();
$hash = $result["password"];
$id = $result["id"];

if (empty($hash))
	exit(AccountError::$InvalidUsername);
if (!password_verify($password, $hash))
	exit(AccountError::$InvalidPassword);

exit("$id,$id");
