<?php
require_once (__DIR__) . "/config.php";
$info = Config::GetConfig("connection");
try {
	$db = new PDO("mysql:host=" . $info["server"] .";port=" . $info["port"] .";dbname=" . $info["database"],$info["user"], $info["password"], array(PDO::ATTR_PERSISTENT => true));
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	exit("Connection failed: " . $e->getMessage());
}