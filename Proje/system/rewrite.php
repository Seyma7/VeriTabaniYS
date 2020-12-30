<?php

$_rewrite_uris = array();

function seo_url_pattern ( $pattern, $uri, $rewrite = false ) {
	global $_rewrite_uris;

	$pattern = str_replace(':num', '[0-9]+', $pattern);
	$pattern = str_replace(':any', '[a-zA-Z-0-9-.]+', $pattern);
	$pattern = str_replace(':all', '.*', $pattern);

	$_rewrite_uris[$pattern] = array('source' => $uri, 'rewrite' => ( $rewrite ? $rewrite : preg_replace('/\((.*?)\)/i', '%s', $pattern) ));

		_print($_rewrite_uris);
}

function seo_url_check () {

	global $_rewrite_uris;

	if ( (isset($_SERVER['PATH_INFO'])) && ($_SERVER['PATH_INFO']) ) {

		$path = urldecode($_SERVER['PATH_INFO']);

	} else {

		$path = urldecode($_SERVER['REQUEST_URI']);

		if (strpos($path, '.php') !== FALSE) {

			$base = $_SERVER['SCRIPT_NAME'];

		} else {

			$base = dirname($_SERVER['SCRIPT_NAME']);

		}

		if ($base != '/') {

			$length = strlen($base);
			$path   = substr($path, $length);

		}

		$path = trim(trim($path,'?'), "/");

	}

	if ( $path && !preg_match("/controller=/i", $path) ) {

		$queries = false;

		if ( strpos($path, '?') !== FALSE ) {

			list($path, $queries) = explode('?', $path);

		}

		foreach($_rewrite_uris as $pattern => $value){

			if(preg_match('#^'.$pattern.'$#', $path, $uris)){

				if($uris[0] ==  $path){

					array_shift($uris);

					$query_string = vsprintf($value['source'], $uris);

					$_SERVER['QUERY_STRING'] = $query_string . ($queries ? '&' . $queries : false);

					break;

				}
			}

		}

	}

}

function is_seo_url ( $link, $query = false ) { //controller=post&id=20214&method=edit

	global $_rewrite_uris;

	if($query){

		$link_params = explode('&', $link);

		if ( count($link_params) > 1 ) {

			foreach ( $link_params as $link_param_key => $link_param ) {

				if ( preg_match('/=/', $link_param) && list($param_key, $param_value) = explode('=', $link_param) ) {

					if ( isset($query[$param_key]) ) {

						$link_params[$link_param_key] = $param_key . '=%s';

					}

				}

			}

			$link = array('plain' => $link, 'matched' => implode('&', $link_params));

		}

	} else {

		$link = array('plain' => $link, 'matched' => $link);

		// link['plain'] = controller=post&id=20214&method=edit
		// link['matched'] = controller=post&id=20214&method=edit
	}


	foreach($_rewrite_uris as $pattern => $value){

		if( $value['source'] == $link['matched'] ){

			return vsprintf($value['rewrite'], $query);

		} else if( $value['source'] == $link['plain'] ){

			return $value['rewrite'];

		}

	}

	return false;

}

/*


$routes['^projeler$'] = array(
	'source' 	=> 'controller=project',
	'seo'		=> 'projeler'
); // +

$routes['^tasinma-talepleri$'] = array(
	'source' 	=> 'controller=move&method=request',
	'seo'		=> 'tasinma-talepleri'
); // +

$routes['^tasinma-talepleri/(:any)-(:num)$'] = array(
	'source' 	=> 'controller=move&slug=%s&id=%s&method=detail',
	'seo'		=> 'tasinma-talepleri/%s-%s'
); // +

$routes['^tasiniyorum$'] = array(
	'source' 	=> 'controller=move',
	'seo'		=> 'tasiniyorum'
);


$routes['^uye-ol$'] = array(
	'source' 	=> 'controller=signup',
	'seo'		=> 'uye-ol'
);

$routes['^giris-yap$'] = array(
	'source' 	=> 'controller=login',
	'seo'		=> 'giris-yap'
);

$routes['^sifremi-unuttum$'] = array(
	'source' 	=> 'controller=forgotten_pwd',
	'seo'		=> 'sifremi-unuttum'
);

$routes['^kullanici-adimi-unuttum/tebrikler$'] = array(
	'source' 	=> 'controller=forgotten_pwd&method=success_username',
	'seo'		=> 'kullanici-adimi-unuttum/tebrikler'
);

$routes['^sifremi-unuttum/tebrikler$'] = array(
	'source' 	=> 'controller=forgotten_pwd&method=success_password',
	'seo'		=> 'sifremi-unuttum/tebrikler'
);

$routes['^ilan-ver/(:any)$'] = array(
	'source' 	=> 'controller=add_post&category=%s',
	'seo'		=> 'ilan-ver/%s'
);

$routes['^tasinma-talebi-ekle$'] = array(
	'source' 	=> 'controller=move_request',
	'seo'		=> 'tasinma-talebi-ekle'
);

$routes['^data/ajax/services/getCategories$'] = array(
	'source' 	=> 'controller=_ajax_services&method=getCategories',
	'seo'		=> 'data/ajax/services/getCategories'
);

$routes['^data/ajax/location/getTowns$'] = array(
	'source' 	=> 'controller=_ajax_services&method=getTowns',
	'seo'		=> 'data/ajax/location/getTowns'
);

$routes['^data/ajax/location/getDistricts$'] = array(
	'source' 	=> 'controller=_ajax_services&method=getDistricts',
	'seo'		=> 'data/ajax/location/getDistricts'
);

$routes['^data/ajax/location/getAddress$'] = array(
	'source' 	=> 'controller=_ajax_services&method=getAddress',
	'seo'		=> 'data/ajax/location/getAddress'
);

$routes['^data/ajax/location/getMapPost$'] = array(
	'source' 	=> 'controller=_ajax_services&method=getMapPost',
	'seo'		=> 'data/ajax/location/getMapPost'
);

$routes['^data/ajax/services/captcha$'] = array(
	'source' 	=> 'controller=_ajax_services&method=captcha',
	'seo'		=> 'data/ajax/services/captcha'
);

$routes['^data/ajax/services/uploadPostImage$'] = array(
	'source' 	=> 'controller=_ajax_services&method=uploadPostImage',
	'seo'		=> 'data/ajax/services/uploadPostImage'
);

$routes['^data/ajax/services/savePostImages$'] = array(
	'source' 	=> 'controller=_ajax_services&method=savePostImages',
	'seo'		=> 'data/ajax/services/savePostImages'
);

$routes['ilan/(:any)/(:any)-(:num)'] = array(
	'source' 	=> 'controller=post&category=%s&post_slug=%s&post_id=%s',
	'seo'		=> 'ilan/%s/%s-%s'
);

$routes['ara/(:all)'] = array(
	'source' 	=> 'controller=post_search&category=%s',
	'seo'		=> 'ara/%s'
);

$routes['^(:all)$'] = array(
	'source' 	=> 'controller=category&slug=%s',
	'seo'		=> '%s'
);

if ((isset($_SERVER['PATH_INFO'])) && ($_SERVER['PATH_INFO'])) {
	$path = urldecode($_SERVER['PATH_INFO']);
} else {
	$path = urldecode($_SERVER['REQUEST_URI']);
	if (strpos($path, '.php') !== FALSE) {
		$base = $_SERVER['SCRIPT_NAME'];
	} else {
		$base = dirname($_SERVER['SCRIPT_NAME']);
	}
	if ($base != '/') {
		$length = strlen($base);
		$path   = substr($path, $length);
	}
	$path = substr(trim($path,'?'), 1);
}

$queries = false;

if ( strpos($path, '?') !== FALSE ) {

	list($path, $queries) = explode('?', $path);

}

foreach($routes as $key => $route){

	$key = str_replace(':all', '[a-z-0-9-/.]+', str_replace(':any', '[a-z-0-9-.]+', str_replace(':num', '[0-9]+', $key)));

	if(preg_match('#^'.$key.'$#', $path, $uris)){

		if($uris[0] ==  $path){
			array_shift($uris);

			$query_string = vsprintf($route['source'], $uris);

			$_SERVER['QUERY_STRING'] = $query_string . ($queries ? '&' . $queries : false);

			break;
		}
	}

}


function is_seo($link, $query = false){

	global $routes;

	if($query){

		$link_params = explode('&', $link);

		if ( count($link_params) > 1 ) {

			foreach ( $link_params as $link_param_key => $link_param ) {

				if ( preg_match('/=/', $link_param) && list($param_key, $param_value) = explode('=', $link_param) ) {

					if ( isset($query[$param_key]) ) {

						$link_params[$link_param_key] = $param_key . '=%s';

					}

				}

			}

			$link = implode('&', $link_params);

		}

	}

	foreach($routes as $key => $route){

		if( $route['source'] == $link ){

			return vsprintf($route['seo'], $query);

		}

	}

	return false;
}
*/
?>
