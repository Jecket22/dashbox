<?php
class Crypto
{
	public static function XorCipher($plaintext, $key) {
		$key = array_map('ord', str_split($key));
		$plaintext = array_map('ord', str_split($plaintext));

		$keysize = count($key);
		$input_size = count($plaintext);

		$cipher = "";

		for ($i = 0; $i < $input_size; $i++)
			$cipher .= chr($plaintext[$i] ^ $key[$i % $keysize]);

		return $cipher;
	}
	
	/*public function crack($cipher, $keysize) { // not sure if this is needed at all so I commented this out for now
		$cipher = array_map('ord', str_split($cipher));
		$occurences = $key = array();
		$input_size = count($cipher);

		for ($i = 0; $i < $input_size; $i++) {
			$j = $i % $keysize;
			if (++$occurences[$j][$cipher[$i]] > $occurences[$j][$key[$j]])
				$key[$j] = $cipher[$i];
		}
		
		$cipheredText = "";
		foreach (array_map(function($v) { return $v ^ 32; }, $key) as $char)
			$cipheredText .= chr($char);

		return $cipheredText;
	}*/
}
