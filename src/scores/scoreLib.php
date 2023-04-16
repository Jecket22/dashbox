<?php
class scoreLib
{
	public static function genLevelSeed($clicks, $percentage, $attemptTime, $attemptCount) {
		return 1482 * (($attemptCount > 0) + 1) + ($clicks + 3991) * ($percentage + 8354) + (($attemptTime + 4085) ** 2) - 50028039;
	}
}
