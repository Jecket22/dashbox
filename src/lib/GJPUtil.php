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
		$requireVerified = Config::GetVariable('accounts', 'verifyLevel');

		require_once (__DIR__) . "/database.php";
		$hashQuery = $db->prepare("SELECT password FROM accounts WHERE id = :accountID AND verified >= :requireVerified");
		$hashQuery->execute(array( ':accountID' => $accountID, ':requireVerified' => $requireVerified ));
		$hash = $hashQuery->fetchColumn();
		if (empty($hash) || !password_verify($password, $hash))
			return false;
		
		return true;
	}
}
