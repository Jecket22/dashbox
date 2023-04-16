<?php
class GJPUtil
{
	public static function decodeGJP($gjp) {
		require_once (__DIR__) . "/crypto.php";
		$gjpdecode = preg_replace(["/_/", "/-/"], ["/", "+"], $gjp);
		$gjpdecode = Crypto::XorCipher(base64_decode($gjpdecode), 37526);
		return $gjpdecode;
	}
	
	public static function encodeGJP($password) {
		require_once (__DIR__) . "/crypto.php";
		$gjp = base64_encode(Crypto::XorCipher($password, 37526));
		$gjp = preg_replace(["/\//", "/\+/"], ["_", "-"], $gjp);
		return $gjp;
	}
	
	public static function verifyPassword($gjp, $accountID, $isPlain = false, $session = false) {
		if (!is_numeric($accountID) || $accountID <= 0) // handle non-registered users
			return false;
		if ($session) // TODO: implement sessions
			return false;

		$password = $gjp;
		if (!$isPlain) // Since passwords are not stored in GJP, we'll decode it first before hashing it
			$password = self::decodeGJP($gjp);
		
		require_once (__DIR__) . "/config.php";
		$requireVerified = strval((Config::GetVariable("accounts", "verifyLevel") != 0) ? 1 : 0);

		require_once (__DIR__) . "/database.php";
		$insertValues = array($accountID, $requireVerified);
		$hashQuery = $db->prepare("SELECT password FROM accounts WHERE id = (?) AND verified >= (?)");
		$hash = Utils::QuickFetch($hashQuery, "si", ...$insertValues);
		if (empty($hash) || !password_verify($password, $hash))
			return false;
		
		return true;
	}
}
