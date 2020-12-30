<?php

// configuration
require_once('../config.php');

set_time_limit(0);

// init
require_once(DIR_SYSTEM . 'startup.php');


// registry
$registry = new Registry();

// loader
$loader = new loader($registry);
$registry->set('load', $loader);

// config
$config = new config();
$registry->set('config', $config);

// cache
$cache = new Cache();
$registry->set('cache', $cache);

// tools
$tools = new Tools();
$registry->set('tools', $tools);

// database
$db = new Db(DB_HOSTNAME, DB_USERNAME, DB_PASSWORD, DB_DATABASE); //system/library/db.php
$registry->set('db', $db);  // db adinda nesneye  veritabanı bağlantısını atıyor.

$query = $db->query("SELECT * FROM setting");

if ($query->rows) {

	foreach ($query->rows as $row) {

		$config->set($row['name'], $row['value']);

	}

}

// Template
$template = new Template();
$registry->set('template', $template);	// template nesnesine template classının tümünü atıyor.

// Document
$document = new Document();
$registry->set('document', $document); // document nesnesine document classının tümünü atıyor.

// Datetime
$datetimes = new Datetimes();
$registry->set('datetimes', $datetimes);

// url
$url = new Url;
$registry->set('url', $url); // Url nesnesine Url classının tümünü atıyor.

// Encryption
$encryption = new Encryption($config->get('site_key'));
$registry->set('encryption', $encryption); // encryption nesnesine encryption classının tümünü atıyor.

// log
$log = new Log(DIR_LOGS . 'error.log');
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

	$log->write('PHP ' . $error . ':  ' . $errstr . ' in ' . $errfile . ' on line ' . $errline);

	#if ($errno == E_ERROR || $errno == E_USER_ERROR) {
		_show_error("PHP {$error}:", $errstr . ' in <b>' . $errfile . '</b> on line <b>' . $errline . '</b>');
	#}
	return true;
}

// error handler
set_error_handler('error_handler');

// Base URL 
$template->assign('base', HTTP_SERVER);

// Session
$registry->set('session', new Session);

// User
$registry->set('user', new User($registry));

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
$registry->set('router', $router);

// Controller Directory
$controller->setDirectory(DIR_CONTROLLER);

$controller->addPreAction('home', 'login');

// Default Controller
$controller->setDefault('home', 'index');

// Error Controller
$controller->setError('error', 'index');

// Route Request
$router->route($request);

// Dispatch
$controller->dispatch($request);

// Output
$response->output();
