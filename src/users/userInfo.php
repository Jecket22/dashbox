<?php
if (!empty($_GET)) $_POST = $_GET;
require (__DIR__) . "/../lib/constants.php";
require (__DIR__) . "/../lib/config.php";
require (__DIR__) . "/../lib/utils.php";
require (__DIR__) . "/../lib/database.php";

//TODO: add a blocklist

if (empty($_POST['targetAccountID'])) exit(GenericResponse::$Error);

$user = $db->prepare("SELECT * FROM accounts, userdata WHERE accounts.id = :id AND userdata.id = :id ORDER BY stars");
$user->execute([':id' => $_POST['targetAccountID']]);
$user = $user->fetchAll()[0];

$rank = $db->prepare("SELECT count(*) FROM userdata WHERE stars > :stars ORDER BY stars");
$rank->execute([':stars' => $user['stars']]);
$rank = $rank->fetchColumn() + 1;

if ($user['stars'] < 0) $rank = 0;

//these are all temp values before i get everything in place
$friend = 0;
$mod = 0;
$messages = 0;
$friendRequests = 0;
$friends = 0;

$verified = $user['verified'];
if (Config::GetVariable('accounts', 'verifyLevel') == 0) $verified = 1;

echo '1:'  . $user['userName'] .
    ':2:'  . $user['id'] .
    ':13:' . $user['starCoins'] .
    ':17:' . $user['userCoins'] .
    ':10:' . $user['colour1'] .
    ':11:' . $user['colour2'] .
    ':3:'  . $user['stars'] .
    ':46:' . $user['diamonds'] .
    ':4:'  . $user['demons'] .
    ':8:'  . $user['creatorPoints'] .
    ':18:' . $user['messages'] .
    ':19:' . $user['friendRequests'] .
    ':50:' . $user['comments'] .
    ':20:' . $user['youtube'] .
    ':21:' . $user['player'] .
    ':22:' . $user['ship'] .
    ':23:' . $user['ball'] .
    ':24:' . $user['ufo'] .
    ':25:' . $user['wave'] .
    ':26:' . $user['robot'] .
    ':28:' . $user['glow'] .
    ':43:' . $user['spider'] .
    ':48:' . $user['explosion'] .
    ':30:' . $rank .
    ':16:' . $user['id'] .
    ':31:' . $friend .
    ':44:' . $user['twitter'] .
    ':45:' . $user['twitch'] .
    ':49:' . $mod .
    ':38:' . $messages .
    ':39:' . $friendRequests .
    ':40:' . $friends .
    ':29:' . $verified;
