<?php
// Version
define('SYSTEM_NAME', 'Latest News v1.0.0');
date_default_timezone_set('Etc/GMT-3'); // Zaman Dilimini Ayarla. TR saati

// general error
$_general_error = array();

setlocale(LC_TIME, 'tr_TR.UTF-8');

$last_path = explode('/', $_SERVER['SCRIPT_NAME']);		// (script_name = tarayıcıdaki açık olan sitenin betik yolu.) www.a.com/ornek.php  de    /ornek.php  yi alir. /'i silip, ornek.php geri döndürür
array_pop($last_path);
$host = $_SERVER['HTTP_HOST'] . implode('/', $last_path) . '/';  // $_SERVER['SERVER_NAME']
define('HTTP_SERVER', "http://$host");

if(isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == 443){
	define('HTTPS_SERVER', "https://$host");
}

define('HTTP_REFERER', (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "http://localhost:8081/proje"));
define('REQUEST_URI', $_SERVER['REQUEST_URI']);

define('DIR_ADMIN','yonetim-paneli/');

// HTTP_IMAGE
//define('HTTP_IMAGE', str_replace(DIR_ADMIN, '', ((defined('HTTPS_SERVER')) && (HTTPS_SERVER) ? HTTPS_SERVER : HTTP_SERVER)) . 'image/');
define('HTTP_IMAGE', str_replace(DIR_ADMIN, '', HTTP_SERVER) . 'image/');

$ips = array('46.254.48.217', '127.0.0.11', "31.200.14.79", "94.54.235.72",
			//'212.156.17.234'  //
	);

if(in_array(@$_SERVER['REMOTE_ADDR'], $ips)){
	define('ROOT_MODE', true);
} else {
	define('ROOT_MODE', false);
}

// dir settings / sabit tanımlamaları
define('DIR_ROOT', dirname(__FILE__) . '/');
if(preg_match('/'.DIR_ADMIN, $_SERVER['REQUEST_URI'])){
	define('DIR_CONTROLLER', DIR_ROOT . DIR_ADMIN .'controller/');
	define('DIR_VIEW', DIR_ROOT . DIR_ADMIN . 'view/');
	define('DIR_MODEL', DIR_ROOT . DIR_ADMIN . 'model/');
} else {
	define('DIR_CONTROLLER', DIR_ROOT . 'controller/');
	define('DIR_VIEW', DIR_ROOT . 'view/');
	define('DIR_MODEL', DIR_ROOT . 'model/');
}
define('DIR_SYSTEM', DIR_ROOT . 'system/');
define('DIR_IMAGE', DIR_ROOT . 'image/');
define('DIR_LOGS', DIR_SYSTEM . 'logs/');
define('DIR_ERROR_FILES', DIR_SYSTEM . 'error_files/');
define('DIR_CACHE', DIR_SYSTEM . 'cache/');


// db settings
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DATABASE', 'b191210029');

define('SITE_DEFAULT_KEYWORDS', 'Haber');
define('SITE_DEFAULT_DESCRIPTION', 'Haber');




function _print($value){
	print '<pre>'; print_r($value); print '</pre>';
}

function _set_error($err){
	global $_general_error;
	array_push($_general_error, $err);
}

function _send_error_mail(){
	global $_general_error, $loader, $config;

	if($config->get('error_notification') && $_general_error){
		$loader->library('phpmailer');

		$mail = new PHPMailer(true);
		$mail->CharSet = "UTF-8";
		$mail->IsSMTP();
		$mail->SMTPAuth   = $config->get('mail_smtpAuth');
		$mail->Port       = $config->get('mail_port');
		$mail->Host       = $config->get('mail_host');
		$mail->Username   = $config->get('mail_username');
		$mail->Password   = $config->get('mail_password');
		$mail->SetFrom($config->get('mail_username'), $config->get('mail_username'));
		$mail->Subject    = $config->get('business_name') . ' sitesinde hata olustu!';
		$mail->MsgHTML(implode('<br />', $_general_error));
		$mail->AddAddress($config->get('mail_address'), $config->get('mail_address'));
		@$mail->Send();
	}
}

function social_share_urls ( $url, $title ) {

		$url = array(
			'facebook' 		=> "http://www.facebook.com/share.php?v=4&src=bm&u=" . urlencode($url) . "&title=" . urlencode($title),
			'twitter' 		=> "http://twitter.com/home?status=" . urlencode($title . ' ' . $url),
			'gmail'				=> "https://mail.google.com/mail/?ui=2&view=cm&fs=1&tf=1&su=" . urlencode($title) . "&body=Link:" . urlencode($url),
			//'yahoo'				=> "http://compose.mail.yahoo.com/?Subject=" . urlencode($title) . ";body=Link:" . urlencode($url),
			//'myspace'			=> "http://www.myspace.com/Modules/PostTo/Pages/?u=" . urlencode($url) . ";t=" . urlencode($title),
			'linkedin'		=> "http://www.linkedin.com/shareArticle?mini=true&url=" . urlencode($url) . "&title=" . urlencode($title),
			'whatsapp'		=> "whatsapp://send?text=" . urlencode($title) . " " . urlencode($url),
			'pinterest'		=> "http://www.pinterest.com/pin/create/button/?url=" . urlencode($url) ."&description=" . urlencode($title)
		);

		return $url;
}


	function social_urls () {
		 $url = array(
			 'facebook' 		=> "https://www.facebook.com/erdemkriser",
			 'twitter' 			=> "https://twitter.com/",
			 'gmail'				=> "https://plus.google.com/",
			 'youtube'			=> "https://www.youtube.com/",
			 //'linkedin'			=> "https://www.linkedin.com/",
			 //'pinterest'		=> "https://pinterest.com/"
		 );

		 return $url;
	}
