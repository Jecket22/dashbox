<?php
$_POST = $_GET;
require (__DIR__) . "/../lib/constants.php";
require (__DIR__) . "/../lib/utils.php";

if (empty($_POST["userName"]) || empty($_POST["password"]) || empty($_POST["email"]) || $_POST["secret"] != Secrets::$accountSecret)
	exit(GenericResponse::$Error);

require (__DIR__) . "/accountLib.php";

$userName = $_POST["userName"];
$password = $_POST["password"];
$email = $_POST["email"];

/*
// This is not required as we'll note store them
if (!accountLib::isEmailValid($email))
	exit(AccountError::$InvalidEmail);
	*/
if (strlen($userName) < 3)
	exit(AccountError::$UsernameTooShort);
if (!accountLib::isUsernameValid($userName))
	exit(AccountError::$InvalidUsername);
if (strlen($password) < 6)
	exit(AccountError::$PasswordTooShort);
if (!accountLib::isPasswordValid($password))
	exit(AccountError::$InvalidPassword);

// -7 and -99 are only used by the client. The server can still return these AccountErrors and they'll show the error
// however they cant really be used during registration since each field is only sent once during the request.

require (__DIR__) . "/../lib/database.php";

$takenValues = array($userName);
$userCheck = $db->prepare("SELECT COUNT(*) FROM accounts WHERE userName = :userName");
$userCheck->execute(array(':userName' => $userName));
$isTaken = $userCheck->fetchColumn();
if ($isTaken > 0)
	exit(AccountError::$TakenUsername);

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$addAccount = $db->prepare("INSERT INTO accounts (userName, password) VALUES (:userName, :hashedPassword)");
$addAccount->execute(array( ':userName' => $userName, ':hashedPassword' => $hashedPassword ));

$account = $db->prepare("SELECT id FROM accounts WHERE userName = :userName");
$account->execute([':userName' => $userName]);
$accountid = $account->fetchColumn();

$addData = $db->prepare("INSERT INTO userdata (id, IP, creation) VALUES (:id, :IP, :creation)");
$addData->execute([':id' => $accountid, ':IP' => Utils::getIP(), ':creation' => time()]);

exit(GenericResponse::$Success);
