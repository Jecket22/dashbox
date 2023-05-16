<?php
require (__DIR__) . "/../lib/constants.php";
require (__DIR__) . "/../lib/config.php";
require (__DIR__) . "/../lib/utils.php";
require (__DIR__) . "/../lib/database.php";
require (__DIR__) . "/../lib/GJPUtil.php";

if (empty($_POST['accountID']) || empty($_POST['toAccountID']) || empty($_POST['gjp']) || $_POST['secret'] != Secrets::$commonSecret) exit(GenericResponse::$Error);

$gjp = GJPUtil::decodeGJP($_POST['gjp']);

$password = $db->prepare("SELECT password FROM accounts WHERE id = :accountID");
$password->execute(array( ':accountID' => $_POST['accountID']));
$password = $password->fetchColumn();
if (empty($password) || !password_verify($gjp, $password)) exit(GenericResponse::$Error);

$blocked = $db->prepare("SELECT COUNT(*) FROM blocks WHERE (blocked = :toAccountID AND blockee = :accountID) OR (blocked = :accountID AND blockee = :toAccountID)");
$blocked->execute(array(':toAccountID' => $_POST['toAccountID'], ':accountID' => $_POST['accountID']));
$blocked = $blocked->fetchColumn();
if ($blocked > 0) exit(GenericResponse::$Error);

$status = $db->prepare("SELECT COUNT(*) FROM userdata WHERE id = :toAccountID AND friendRequests = 1");
$status->execute([':toAccountID' => $_POST['toAccountID']]);
$status = $status->fetchColumn();
if ($status > 0) exit(GenericResponse::$Error);

$sending = $db->prepare("SELECT COUNT(*) FROM friendrequests WHERE (sender = :toAccountID AND recipient = :accountID) OR (sender = :accountID AND recipient = :toAccountID)");
$sending->execute([':accountID' => $_POST['accountID'], ':toAccountID' => $_POST['toAccountID']]);
$sending = $sending->fetchColumn();
if ($sending > 0) {
    http_response_code(500);
    exit(GenericResponse::$Error);
}

$alreadyFriends = $db->prepare("SELECT COUNT(*) FROM friends WHERE (user = :toAccountID AND friend = :accountID) OR (user = :accountID AND friend = :toAccountID)");
$alreadyFriends->execute([':accountID' => $_POST['accountID'], ':toAccountID' => $_POST['toAccountID']]);
$alreadyFriends = $alreadyFriends->fetchColumn();
if ($alreadyFriends > 0) {
    http_response_code(500);
    exit(GenericResponse::$Error);
}

$comment = '';
if (isset($_POST['comment'])) $comment = $_POST['comment'];

$friendRequest = $db->prepare("INSERT INTO friendrequests (sender, recipient, comment, date) VALUES (:accountID, :toAccountID, :comment, :time)");
$friendRequest->execute([':accountID' => $_POST['accountID'], ':toAccountID' => $_POST['toAccountID'], ':comment' => $comment, ':time' => time()]);

echo '1';