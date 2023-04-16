<?php
class GenericResponse
{
	public static $Unknown = "0";
	public static $Error = "-1";
	public static $Success = "1";
};

class Secrets
{
	public static $commonSecret = "Wmfd2893gb7";
	public static $accountSecret = "Wmfv3899gc9";
	public static $levelSecret = "Wmfv2898gc9";
	public static $modSecret = "Wmfp3879gc3";
}

class Salts
{
	public static $levelSalt = "xI25fpAapCQg";
	public static $commentSalt = "xPT6iUrtws0J";
	public static $rateSalt = "ysg6pUrtjn0J";
	public static $userSalt = "xI35fsAapCRg";
	public static $leaderboardSalt = "yPg6pUrtWn0J";
	public static $vaultSalt = "ask2fpcaqCQ2";
};

class XorKeys
{
	public static $saveDataKey = 11;
	public static $messageKey = 14251;
	public static $vaultKey = 19283;
	public static $challengeKey = 19847;
	public static $levelPassKey = 26364;
	public static $commentKey = 29481;
	public static $passwordKey = 37526;
	public static $leaderboardKey = 39673;
	public static $levelSeedKey = 41274;
	public static $loadDataKey = 48291;
	public static $rewardKey = 59182;
	public static $rateKey = 58281;
	public static $userScoreKey = 85271;
};

class AccountError
{
	public static $TakenUsername = "-2";
	public static $TakenEmail = "-3";
	public static $InvalidUsername = "-4";
	public static $InvalidPassword = "-5";
	public static $InvalidEmail = "-6";
	// public static $PasswordsDontMatch = "-7";
	public static $PasswordTooShort = "-8";
	public static $UsernameTooShort = "-9";
	public static $LinkedToDifferentAccount = "-10";
	public static $LoginFailed = "-11"; // Same as an unrecognized error, keeping this in case RobTop changes the "Login Failed" message
	public static $AccountDisabled = "-12";
	// public static $LinkedToDifferentSteamAccount = "-13";
	// public static $EmailsDontMatch = "-99";
}; // Some of the error codes are commented out due to being technically unusable
