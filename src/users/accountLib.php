<?php
class accountLib
{
	public static function isEmailValid($str) {
		return preg_match('/^[A-Za-z0-9@.]{5,50}$/', $str); // find a better regex or use filter_var with ternary operators
	}

	public static function isUsernameValid($str) {
		require_once (__DIR__) . "/../lib/config.php";
		foreach (Config::GetVariable("accounts", "userNameBlacklist") as $badname) {
			if (preg_match('/' . $badname . (str_contains($badname, '/') ? '' : '/') . 'ix', $str))
				return false;
		}
		return preg_match('/^[a-zA-Z0-9-_ ]{3,15}$/', $str);
	}

	public static function isPasswordValid($str) {
		return preg_match('/^[a-zA-Z0-9-_]{6,21}$/', $str);
	}

	public static function isTwoFactorValid($str) { // big maybe...
		return preg_match('/^[a-zA-Z0-9]{6}$/', $str);
	}
}
