<?php
class Utils
{
	// thank you stack overflow for this awesome piece of code 
	// https://stackoverflow.com/a/36297417
	public static function GetTime($time) {
		$time = time() - $time; // to get the time since that moment
		$time = ($time < 1) ? 1 : $time;
		$tokens = array(
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
		}
	}
	
	// Taken from Cvolton's source because, well, I don't have a better method tbh
	public static function IsCloudFlareIP($ip) {
		$cf_ips = array(
			'173.245.48.0/20',
			'103.21.244.0/22',
			'103.22.200.0/22',
			'103.31.4.0/22',
			'141.101.64.0/18',
			'108.162.192.0/18',
			'190.93.240.0/20',
			'188.114.96.0/20',
			'197.234.240.0/22',
			'198.41.128.0/17',
			'162.158.0.0/15',
			'104.16.0.0/13',
			'104.24.0.0/14',
			'172.64.0.0/13',
			'131.0.72.0/22'
		);
		foreach ($cf_ips as $cf_ip) {
			if (ipInRange::ipv4InRange($ip, $cf_ip)) {
				return true;
			}
		}
		return false;
	}
	
	public static function getIP() {
		if (isset($_SERVER['HTTP_CF_CONNECTING_IP']) && self::IsCloudFlareIP($_SERVER['REMOTE_ADDR'])) // CLOUDFLARE REVERSE PROXY SUPPORT
  			return $_SERVER['HTTP_CF_CONNECTING_IP'];
		
		require (__DIR__) . "/ipInRange.php";
		if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && ipInRange::ipv4InRange($_SERVER['REMOTE_ADDR'], '127.0.0.0/8')) // LOCALHOST REVERSE PROXY SUPPORT (7m.pl)
			return $_SERVER['HTTP_X_FORWARDED_FOR'];
		
		return $_SERVER['REMOTE_ADDR'];
	}
	
	// Cleaning/Escaping functions
	
	public static function RemoveDelimiterChars($string) {
		return preg_replace('/[~\|#:\0]/', '', $string);
	}

	public static function Base64url_decode($data) {
		return base64_decode(str_replace(array('-', '_'), array('+', '/'), $data));
	}

	public static function Base64url_encode($data) {
		return base64_encode(str_replace(array('+', '/'), array('-', '_'), $data));
	}

	public static function CleanNumbers($string) {
		return preg_replace("/[^0-9-,.]/", '', $string);
	}

	public static function CleanString($string) {
		return preg_replace("/[^a-zA-Z0-9-_ ,.!+\/]/", "", $string);
	}
	
	// Database Utils
	
	public static function QuickFetch($query, $type, ...$values) {
		$query->bind_param($type, ...$values);
		$query->execute();
		$result = array();
		$meta = $query->result_metadata();
		if ($meta) {
			$fields = $meta->fetch_fields();
			$params = array();
			foreach ($fields as $field) {
				$params[] = &$result[$field->name];
			}
			call_user_func_array(array($query, 'bind_result'), $params);
			$query->fetch();
			$query->free_result();
			if (count($result) == 1) {
				return reset($result);
			} else {
				return $result;
			}
		} else {
			$query->free_result();
			return null;
		}
	}
}
