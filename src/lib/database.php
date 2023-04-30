<?php
require_once (__DIR__) . "/../../config/connection.php";
try {
	$db = new PDO("mysql:host=" . $server . ";port=" . $port . ";dbname=" . $database, $user, $password, array(PDO::ATTR_PERSISTENT => true));
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
	exit("Connection failed: <pre>" . $e->getMessage() . "</pre>");
}