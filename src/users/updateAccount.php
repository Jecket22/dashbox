<?php
require (__DIR__) . "/../lib/constants.php";
require (__DIR__) . "/../lib/config.php";
require (__DIR__) . "/../lib/utils.php";
require (__DIR__) . "/../lib/database.php";

$userID = (isset($_POST["uuid"])) ? $_POST["uuid"] : $_POST["accountID"];
if (empty($userID) || $_POST['secret'] != Secrets::$commonSecret) exit(GenericResponse::$Error);

$usercheck = $db->prepare("INSERT IGNORE INTO userdata (id) VALUES (:id)");
$usercheck->execute([':id' => $userID]);

$userdata = $db->prepare("UPDATE userdata SET stars = :stars, diamonds = :diamonds, starCoins = :starCoins, demons = :demons, orbs = :orbs, IP = :IP, mainIcon = :mainIcon, player = :player, ship = :ship, ball = :ball, ufo = :ufo, wave = :wave, robot = :robot, spider = :spider, glow = :glow, explosion = :explosion, trail = :trail, colour1 = :colour1, colour2 = :colour2, lastLogOn = :lastLogOn WHERE id = :userID");
$userdata->execute([':stars' => $_POST['stars'], ':diamonds' => $_POST['diamonds'], ':starCoins' => $_POST['coins'], ':demons' => $_POST['demons'], ':orbs' => $_POST['orbs'], ':IP' => Utils::getIP(), ':mainIcon' => $_POST['iconType'], ':player' => $_POST['accIcon'], ':ship' => $_POST['accShip'], ':ball' => $_POST['accBall'], ':ufo' => $_POST['accBird'], ':wave' => $_POST['accDart'], ':robot' => $_POST['accRobot'], ':spider' => $_POST['accSpider'], ':glow' => $_POST['accGlow'], ':explosion' => $_POST['accExplosion'], ':trail' => $_POST['special'], ':colour1' => $_POST['color1'], ':colour2' => $_POST['color2'], ':lastLogOn' => time(), ':userID' => $userID]);

echo $userID;