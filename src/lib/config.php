<?php

class Config
{
	// do I even want to keep this????????????????????
	public static function GetConfig($configName) {
		$file = file_get_contents((__DIR__) . "/../../config/" . $configName . ".json");
		if (!$file)
			return false;
		$config = json_decode($file, true); // "true" here will make it output an array instead of an object
		return $config;
	}

	public static function GetVariable($configName, $variable) {
		$file = file_get_contents((__DIR__) . "/../../config/" . $configName . ".json");
		if (!$file)
			return false;
		$config = json_decode($file);
		return $config->$variable;
	}

	public static function SetVariable($configName, $variable, $data) {
		$file = file_get_contents((__DIR__) . "/../../config/" . $configName . ".json");
		if (!$file)
			return false;
		$config = json_decode($file);
		$config->$variable = $data;
		$newJson = json_encode($config);
		$newFile = fopen((__DIR__) . "/../../config/" . $configName . ".json", "w");
		if (!fwrite($newFile, $newJson))
			return false;
		fclose($newFile);
		return true;
	}

	// todo: bulk setting variables

}
