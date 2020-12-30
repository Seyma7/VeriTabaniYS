<?php
// Configuration
require_once('config.php');

// Page Time
@$time = (time() + microtime());

// rewrite rules
require_once(DIR_SYSTEM . 'rewrite.php');

// Startup
require_once(DIR_SYSTEM . 'startup.php');


// Registry
$registry = new Registry();

// Loader
$loader = new loader($registry);
$registry->set('load', $loader);

// Config
$config = new config();
$registry->set('config', $config);

// Cache
$cache = new Cache();
$registry->set('cache', $cache);

// Session
$session = new Session();
$registry->set('session', $session);

// Database
$db = new Db(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE);
$registry->set('db', $db);

$query = $db->query("SELECT * FROM setting");

if ($query->rows) {

	foreach ($query->rows as $result) {

		$config->set($result['name'], $result['value']);

	}

}

$config->set('keywords', SITE_DEFAULT_KEYWORDS);
$config->set('description', SITE_DEFAULT_DESCRIPTION);

// Log
$log = new log($config->get('error_log_file'), $registry);
$registry->set('log', $log);

function error_handler($errno, $errstr, $errfile, $errline) {
	global $log, $config;

	switch ($errno) {
		case E_NOTICE:
		case E_USER_NOTICE:
			$error = 'Notice';
			break;
		case E_WARNING:
		case E_USER_WARNING:
			$error = 'Warning';
			break;
		case E_ERROR:
		case E_USER_ERROR:
			$error = 'Fatal Error';
			break;
		default:
			$error = 'Unknown';
			break;
	}

	#if ($config->get('config_error_display')) {
		echo '<b>' . $error . '</b>: ' . $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>';
	#}

	$errMsg = 'PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline . (isset($_SERVER['REQUEST_URI']) ? ' - request uri - ' . $_SERVER['REQUEST_URI'] : false);

	$log->write($errMsg);

	_set_error($errMsg);

	return true;
}

// Error Handler
set_error_handler('error_handler');

// Template
$template = new Template();
$registry->set('template', $template);

// Document
$document = new Document();
$registry->set('document', $document);

// Datetime
$datetimes = new Datetimes();
$registry->set('datetimes', $datetimes);

// Exchange
$registry->set('exchange', new Exchange($registry));

// Weather
$registry->set('weather', new Weather($registry));

// Encryption
$encryption = new Encryption($config->get('site_key'));
$registry->set('encryption', $encryption);
 

// Url
$url = new Url($registry);
$registry->set('url', $url);

// dont remove
define('PP_CHECKOUT_URL', $url->ssl('checkout')); // paypal-digital-goods.class.php de hata zamaninda kullaniliyor.

// Base URL
$template->assign('base', HTTP_SERVER);

// Request
$request = new Request();
$registry->set('request', $request);


// Response
$response = new Response($registry);
$registry->set('response', $response);

// Controller
$controller = new Front($registry);
$registry->set('controller', $controller);

// Router
$router = new Router($registry);

// Controller Directory
$controller->setDirectory(DIR_CONTROLLER);

// Default Controller
$controller->setDefault('home', 'index');

// Error Controller
$controller->setError('error', 'index');

// Route Request
$router->route($request);

$template->assign('page_load_time', time() - $time);

// Dispatch
$controller->dispatch($request);
// Output
$response->output();

// error notification
_send_error_mail();
?>
