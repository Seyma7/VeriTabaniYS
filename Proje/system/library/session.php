<?php
class Session {
	var $expire = 3600;

	function __construct() {
		@session_start();
	}

	function set($key, $value) { // gönderilen değişken ve değeri session olarak oluşturur.
		$_SESSION[$key] = $value;
	}

	function get($key) { // session değişkenini çeker ve gönderir.
		return (isset($_SESSION[$key]) ? $this->htmlspecialchars_deep($_SESSION[$key]) : NULL);
	}

	function has($key) { // Değişkenin session değerini gönderir.
		return isset($_SESSION[$key]);
	}

	function delete($key) { // session değiişkeni siler
		if (isset($_SESSION[$key])) {
			unset($_SESSION[$key]);
		}
	}

  	function open() {
    	return TRUE;
  	}

  	function close() {
		return TRUE;
  	}

	function htmlspecialchars_deep (&$data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$data[$key] = $this->htmlspecialchars_deep($value);
			}
		}
		else { $data = htmlspecialchars($data); }
		return $data;
	}
}
?>
