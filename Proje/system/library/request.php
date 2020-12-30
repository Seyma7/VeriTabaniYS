<?php

final class Request {

	public $server;
	
  	function __construct() {	
		if (get_magic_quotes_gpc()) $this->stripslashes_gpc();
		$this->server = $_SERVER;
	}
						        
  	function _get($key, $type = 'GET', $default = NULL) { // siteye gönderilen verinin tipini bul ve tipi $dataya aktar.
		switch (strtoupper($type)) {
			case 'GET':
				$data = $_GET;
				break;
			case 'POST':
				$data = $_POST;
				break;
			case 'COOKIE':
				$data = $_COOKIE;
				break;
		}
		
		return (isset($data[$key]) ? $data[$key] : $default); //  Veriyi $_POST["isim"] gibi $data["isim"] şeklinde geri gönder.
	}
	
	public function get($key){ // get ile gelen veriyi al
		return $this->_get($key, 'GET');  
	}
	
	public function post($key){// post ile gelen veriyi al
		return $this->_get($key, 'POST');
	}
    
	function has($key, $type = 'GET') { 
		switch (strtoupper($type)) { // gelen verinin tip yazısı büyüt ve kontrol et.
			case 'GET':
				return isset($_GET[$key]); // tip get ise veriyi get metodu ile al ve gönder.
				break;
			case 'POST':
				return isset($_POST[$key]); // tip post ise veriyi post metodu ile al ve gönder.
				break;
			case 'COOKIE':
				return isset($_COOKIE[$key]); // tip cookie ise veriyi cookie metodu ile al ve gönder.
				break;
		}	
	}
	
	public function geth($key){
		return $this->has($key, 'GET');
	}
	
	public function posth($key){
		return $this->has($key, 'POST');
	}	
	
	function set($key, $value, $type = 'GET') {
		switch (strtoupper($type)) { // gelen verinin tip yazısı büyüt ve kontrol et.
			case 'GET':
				return $_GET[$key] = $value; // tip get ise veriyi get metodu ile al ve değeri ona aktarıp gönder.
				break;
			case 'POST':
				return $_POST[$key] = $value; // tip post ise veriyi post metodu ile al ve değeri ona aktarıp gönder.
				break;
		}	
	}
	
	function isPost() { 
		return (strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'); 
	}
	 
	function isSecure() {
		return (@$_SERVER['HTTPS'] == 'on');
	}

	//previously stripSlashes
	function stripslashes_deep (&$data) {
		if (is_array($data)) {
			foreach ($data as $key => $value) {
				$data[$key] = $this->stripslashes_deep($value);
			}
		}
		else { $data = stripslashes($data); } // ters \ i kaldir
		return $data;
	}

	
	function stripslashes_gpc () {
		$_GET		= $this->stripslashes_deep($_GET);
		$_POST		= $this->stripslashes_deep($_POST);
		$_COOKIE	= $this->stripslashes_deep($_COOKIE);
		$_REQUEST	= $this->stripslashes_deep($_REQUEST);
	}
}

?>