<?php
class hashLib
{
	public static function IsChkValid($chk, $chkArray, $XorKey, $salt) {
		require_once (__DIR__) . "/crypto.php";

		$itemString = "";
		foreach ($chkArray as $item) {
			$itemString .= $item;
		}
		$itemString .= $salt;

		$sha1String = sha1($itemString);
		return $chk == base64_encode(Crypto::XorCipher($sha1String, $XorKey));
	}
	
	public static function GenSolo3($str) { // What's a better way to name this...?
		return sha1($str . "oC36fpYaPtdg");
	}
}
