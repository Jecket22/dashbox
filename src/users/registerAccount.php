<?php
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
$userCheck = $db->prepare("SELECT COUNT(*) FROM accounts WHERE userName = (?)");
$isTaken = Utils::QuickFetch($userCheck, "s", ...$takenValues); // ["COUNT(*)"];
if ($isTaken)
	exit(AccountError::$TakenUsername);

$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$insertValues = array($userName, $hashedPassword);
$addAccount = $db->prepare("INSERT INTO accounts (`userName`, `password`) VALUES (?, ?)");
$addAccount->bind_param("ss", ...$insertValues);
$addAccount->execute();

exit(GenericResponse::$Success);
