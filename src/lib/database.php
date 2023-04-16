<?php
require_once (__DIR__) . "/config.php";
$info = Config::GetConfig("connection");
$db = new mysqli($info["server"], $info["user"], $info["password"], $info["database"], $info["port"]);
if ($db -> connect_errno)
	exit("MySQLi Error: " . $db->connect_error);
