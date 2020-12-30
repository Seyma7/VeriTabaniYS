<?php
final class Encryption {
	private $key;

	function __construct($key) {
        $this->key = $key; // veriyi özel değişkene ata.
	}

	function encrypt($value) { // VERİ SİFRELEME

		if (!$this->key) { // değişkende veri yoksa, gelen veriyi aynen yolla
			return $value;
		}

		$output = '';
		$output = $value;
    return base64_encode($output); //base64 şifreleyerek gönder.

	}




	function decrypt($value) { // SIFRELI VERIYI AÇMA

		if (!$this->key) {
			return $value;
		}

		$output = '';
		$output = base64_decode($value); //base64 şifrelemeyi çöz.


		return $output;

	}
}
?>
