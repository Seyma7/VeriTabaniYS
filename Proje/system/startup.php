<?php

setlocale(LC_TIME,'tr_TR.UTF-8', 'tr_TR', 'tr', 'turkish');

// Error Reporting

if(ROOT_MODE){
	error_reporting(E_ALL);
} else {
	error_reporting(0);
}

// Check Version
if (version_compare(phpversion(), '5.1.0', '<') == TRUE) {
	exit('PHP5.1+ Required');
}

// Register Globals
if(ini_get('register_globals')){
	ini_set('session.use_cookies', 'On');
	ini_set('session.use_trans_sid', 'Off');

	session_set_cookie_params(0, '/');
	session_start();

	$globals = array($_REQUEST, $_SESSION, $_SERVER, $_FILES);

	foreach($globals as $global){
		foreach(array_keys($global) as $key){
			unset($$key);
		}
	}
}

// Magic Quotes Fix
if(ini_get('magic_quotes_gpc')){
	function clean($data){
   		if(is_array($data)){
  			foreach($data as $key => $value){
    			$data[clean($key)] = clean($value);
  			}
		}
		else{
  			$data = stripslashes($data);
		}
		return $data;
	}
	$_GET 		= clean($_GET);
	$_POST 		= clean($_POST);
	$_REQUEST 	= clean($_REQUEST);
	$_COOKIE 	= clean($_COOKIE);
}

if (!ini_get('date.timezone')) {
	//date_default_timezone_set('UTC');
}

// Windows IIS Compatibility
if (!isset($_SERVER['DOCUMENT_ROOT'])) {
	if (isset($_SERVER['SCRIPT_FILENAME'])) {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr($_SERVER['SCRIPT_FILENAME'], 0, 0 - strlen($_SERVER['PHP_SELF'])));
	}
}

if (!isset($_SERVER['DOCUMENT_ROOT'])) {
	if (isset($_SERVER['PATH_TRANSLATED'])) {
		$_SERVER['DOCUMENT_ROOT'] = str_replace('\\', '/', substr(str_replace('\\\\', '\\', $_SERVER['PATH_TRANSLATED']), 0, 0 - strlen($_SERVER['PHP_SELF'])));
	}
}

if (!isset($_SERVER['REQUEST_URI'])) {
	$_SERVER['REQUEST_URI'] = substr($_SERVER['PHP_SELF'], 1);

	if (isset($_SERVER['QUERY_STRING'])) {
		$_SERVER['REQUEST_URI'] .= '?' . $_SERVER['QUERY_STRING'];
	}
}


// Helper
require_once(DIR_SYSTEM . 'helper/json.php');
require_once(DIR_SYSTEM . 'helper/utf8.php');

// Engine
require_once(DIR_SYSTEM . 'engine/registry.php');
require_once(DIR_SYSTEM . 'engine/controller.php');
require_once(DIR_SYSTEM . 'engine/router.php');
require_once(DIR_SYSTEM . 'engine/front.php');
require_once(DIR_SYSTEM . 'engine/loader.php');

// Library
require_once(DIR_SYSTEM . 'library/config.php');
require_once(DIR_SYSTEM . 'library/db.php');
require_once(DIR_SYSTEM . 'library/template.php');
require_once(DIR_SYSTEM . 'library/request.php');
require_once(DIR_SYSTEM . 'library/response.php');
require_once(DIR_SYSTEM . 'library/document.php');
require_once(DIR_SYSTEM . 'library/exchange.php');
require_once(DIR_SYSTEM . 'library/weather.php');
require_once(DIR_SYSTEM . 'library/url.php');
require_once(DIR_SYSTEM . 'library/cache.php');
require_once(DIR_SYSTEM . 'library/user.php');
require_once(DIR_SYSTEM . 'library/session.php');
require_once(DIR_SYSTEM . 'library/slug.php');
require_once(DIR_SYSTEM . 'library/log.php');
require_once(DIR_SYSTEM . 'library/tools.php');
require_once(DIR_SYSTEM . 'library/encryption.php');
require_once(DIR_SYSTEM . 'library/pagination.php');
require_once(DIR_SYSTEM . 'library/functions.php');
require_once(DIR_SYSTEM . 'library/datetimes.php');



function _show_error($title, $description = array()){

	$content = @file_get_contents(DIR_ERROR_FILES . 'error.html');

	if ($content) {

		$html = '<ul>';

		if (is_array($description)) {

			foreach ($description as $desc) {

				$html .= "<li>{$desc}</li>";

			}

		} else {

			$html .= "<li>{$description}</li>";

		}


		$html .= '</ul>';

		exit(vsprintf($content, array($title, $html)));

	} else {

		exit(DIR_ERROR_FILES . ': wrong parameters!');

	}

}
?>
