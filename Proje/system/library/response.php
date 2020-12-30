<?php
final class Response {
	var $headers = array();
	var $output;

	function __construct($registry) {
		$this->request = $registry->get('request');
	}

	function setHeader($key, $value) {
		$this->headers[$key] = $value;
	}

	function removeHeader($key) {
		if (isset($this->headers[$key])) {
			unset($this->headers[$key]);
		}
	}

	function redirect($url) {  
		$url=html_entity_decode($url);
		header('Location: ' . $url);
		exit;
	}

	function set($output) {
		$this->output = $output;
	}

	function compress($data, $level = 4) {
		if(isset($_SERVER['HTTP_ACCEPT_ENCODING'])){
			if (strpos(@$_SERVER['HTTP_ACCEPT_ENCODING'], 'gzip')) {
				$encoding = 'gzip';
			}
		}

		if(isset($_SERVER['HTTP_ACCEPT_ENCODING'])){
			if (strpos(@$_SERVER['HTTP_ACCEPT_ENCODING'], 'x-gzip')) {
				$encoding = 'x-gzip';
			}
		}

		if (!isset($encoding)) {
			return $data;
		}

		if (!extension_loaded('zlib') || ini_get('zlib.output_compression')) {
			return $data;
		}

		if (headers_sent()) {
			return $data;
		}

		if (connection_status()) {
			return $data;
		}

		$size = strlen($data);
		$crc = crc32($data);

		$gzdata = "\x1f\x8b\x08\x00\x00\x00\x00\x00";
		$gzdata .= gzcompress($data, (int)$level);

		$gzdata = substr($gzdata, 0, strlen($gzdata) - 4);
		$gzdata .= pack("V", $crc) . pack("V", $size);

		$gzdata = gzencode($data, (int)$level);

		$this->setHeader('Content-Encoding', $encoding);

		return $gzdata;
	}

	function output() {
		if (($this->output)) {
			$output = $this->compress($this->output, 4);
		} else {
			$output = $this->output;
		}

		foreach ($this->headers as $key => $value) {
			header($key. ': ' . $value);
		}

		echo($output);
	}
}
?>
