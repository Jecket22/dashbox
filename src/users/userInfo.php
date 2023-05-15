<?php
require (__DIR__) . "/../lib/constants.php";
require (__DIR__) . "/../lib/config.php";
require (__DIR__) . "/../lib/utils.php";
require (__DIR__) . "/../lib/database.php";

//TODO: add a blocklist

if (empty($_POST['targetAccountID']) || empty($_POST['accountID'])) exit(GenericResponse::$Error);

$user = $db->prepare("SELECT * FROM accounts, userdata WHERE accounts.id = :id AND userdata.id = :id ORDER BY stars");
$user->execute([':id' => $_POST['targetAccountID']]);
$user = $user->fetchAll();

if (empty($user)) exit(GenericResponse::$Error);

$user = $user[0];

$rank = $db->prepare("SELECT count(*) FROM userdata WHERE stars > :stars ORDER BY stars");
$rank->execute([':stars' => $user['stars']]);
$rank = $rank->fetchColumn() + 1;

$friendRequests = $db->prepare("SELECT count(*) FROM friendrequests WHERE recipient = :recipient AND new = 1");
$friendRequests->execute([':recipient' => $_POST['accountID']]);
$friendRequests = $friendRequests->fetchColumn();

$newFriends = $db->prepare("SELECT count(*) FROM friends WHERE user = :user AND new = 1");
$newFriends->execute([':user' => $_POST['accountID']]);
$newFriends = $newFriends->fetchColumn();

$newMessages = $db->prepare("SELECT count(*) FROM messages WHERE recipient = :recipient AND new = 1");
$newMessages->execute([':recipient' => $_POST['accountID']]);
$newMessages = $newMessages->fetchColumn();

$friendStatus = 0;
$isFriend = $db->prepare("SELECT count(*) FROM friends WHERE user = :user AND friend = :friend");
$isFriend->execute([':user' => $_POST['accountID'], ':friend' => $_POST['targetAccountID']]);
if ($isFriend->fetchColumn() > 0) $friendStatus = 1;

$outgoingFriend = $db->prepare("SELECT count(*) FROM friendrequests WHERE sender = :sender AND recipient = :recipient");
$outgoingFriend->execute([':sender' => $_POST['accountID'], ':recipient' => $_POST['targetAccountID']]);
if ($outgoingFriend->fetchColumn() > 0) $friendStatus = 3;

$incomingFriend = $db->prepare("SELECT count(*) FROM friendrequests WHERE sender = :sender AND recipient = :recipient");
$incomingFriend->execute([':sender' => $_POST['targetAccountID'], ':recipient' => $_POST['accountID']]);
if ($incomingFriend->fetchColumn() > 0) $friendStatus = 4;

if ($user['stars'] <= 0) $rank = 0;

$modBadge = $db->prepare("SELECT modBadge FROM roles WHERE id = :id");
$modBadge->execute([':id' => $user['role']]);
$modBadge = $modBadge->fetchColumn();
if ($user['role'] <= 0) $modLevel = 0;
else $modLevel = $modBadge;

$verified = $user['verified'];
if (Config::GetVariable('accounts', 'verifyLevel') == 0) $verified = 1;

echo '1:'  . $user['userName'];
echo ':2:'  . $user['id'];
echo ':13:' . $user['starCoins'];
echo ':17:' . $user['userCoins'];
echo ':10:' . $user['colour1'];
echo ':11:' . $user['colour2'];
echo ':3:'  . $user['stars'];
echo ':46:' . $user['diamonds'];
echo ':4:'  . $user['demons'];
echo ':8:'  . $user['creatorPoints'];
echo ':18:' . $user['messages'];
echo ':19:' . $user['friendRequests'];
echo ':50:' . $user['comments'];
echo ':20:' . $user['youtube'];
echo ':21:' . $user['player'];
echo ':22:' . $user['ship'];
echo ':23:' . $user['ball'];
echo ':24:' . $user['ufo'];
echo ':25:' . $user['wave'];
echo ':26:' . $user['robot'];
echo ':28:' . $user['glow'];
echo ':43:' . $user['spider'];
echo ':48:' . $user['explosion'];
echo ':30:' . $rank;
echo ':16:' . $user['id'];
echo ':31:' . $friendStatus;
echo ':44:' . $user['twitter'];
echo ':45:' . $user['twitch'];
echo ':49:' . $modLevel;
if ($_POST['accountID'] == $_POST['targetAccountID']) echo ':38:' . $newMessages;
if ($_POST['accountID'] == $_POST['targetAccountID']) echo ':39:' . $friendRequests;
if ($_POST['accountID'] == $_POST['targetAccountID']) echo ':40:' . $newFriends;
echo ':29:' . $verified;
