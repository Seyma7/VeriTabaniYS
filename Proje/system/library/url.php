<?php
final class Url {

	function requested($controller, $action = NULL, $query = array()) {
		if (isset($_SERVER['REQUEST_URI'])) {
			return htmlspecialchars($_SERVER['REQUEST_URI']); // bozuk html özel karakterlerini düzelt ve sayfa erişim bilgisini gönder
		}
		else {
			return $this->ssl($controller, $action, $query);
		}
	}

	function referer($controller, $action = NULL, $query = array()) {
		if (isset($_SERVER['HTTP_REFERER'])) { // son açılan sayfaya gelmeden önceki sayfanın linki var mı kontrol et
			return htmlspecialchars($_SERVER['HTTP_REFERER']); // bozuk html özel karakterlerini düzelt ve linki gönder
		}
		else {
			return $this->ssl($controller, $action, $query);
		}
	}

  	function link($controller, $action = NULL, $query = array(), $sub_query = array(), $admin = false) {
	// controller	: açılacak olan sayfa ismi örn:POST => ilan sayfası
	// action		: sayfada yapabilecek işlem örn:edit => Kayıt Düzenleme
	// query		: veritabanından çekilen verinin sutun ismi ve veri değeri. Örn: $query["id"] = 123;

	// $server parametresi, panel üzerinden sayfa içi link yapımı için oluşturuldu.
	// Daha öncesin de linkler panel linkiymiş gibi oluşturuluyordu.
		return $this->create(($admin ? urldecode(str_replace(DIR_ADMIN,"",HTTP_SERVER)) : HTTP_SERVER), $controller, $action, $query, true, $sub_query);//
  	}

  	function href($controller, $action = NULL, $query = array()) {
		return $this->create(HTTP_SERVER, $controller, $action, $query, true);
  	}
/*
  	function href_($controller, $action = NULL, $query = array()) {
		return $this->create(HTTP_SERVER, $controller, $action, $query, false);
	}*/

  	function ssl($controller, $action = NULL, $query = array()) {
		$server = $this->get_server();
		return $this->create($server, $controller, $action, $query);
  	}

	function rewrite(){
		$args = func_get_args();
		$extension = reset($args);
		array_shift($args);
		if($args){
			$output = '';
			foreach($args as $arg){
				$output .= $arg . '/';
			}
			return HTTP_SERVER . substr($output, 0, -1) . $extension;
		}
		return false;
	}

	function img(){
		$args = func_get_args();
		$extension = reset($args);
		array_shift($args);
		if($args){
			$output = '';
			foreach($args as $arg){
				$output .= $arg . '/';
			}
			return HTTP_IMAGE . substr($output, 0, -1) . $extension;
		}
		return false;
	}

	function get_server() {
		if ((defined('HTTPS_SERVER')) && (HTTPS_SERVER)) {
	  		$server = HTTPS_SERVER;
		} else {
	  		$server = HTTP_SERVER;
		}
		return $server;
	}

	function create($server, $controller, $action = NULL, $query = array(), $alias = false, $sub_query = array()) {
	// seo url link oluşturma
	// controller	: açılacak olan sayfa ismi örn:POST => ilan sayfası
	// action		: sayfada yapabilecek işlem örn:edit => Kayıt Düzenleme
	// query		: veritabanından çekilen verinin sutun ismi ve veri değeri. Örn: $query["id"] = 123;
    	$link = 'controller=' . $controller;  // controller=post


		if($query){
			foreach ($query as $key => $value) {
	  		if ($value) {
	    		$link .= '&' . $key . '=' . $value; // controller=post&id=123
				}
			}
		}


    	if ($action) {
      		$link .= '&method=' . $action;  // controller=post&id=123&method=edit
    	}

		$seo = false;

		if($alias){

			if ( function_exists ( "is_seo_url" ) ) {

				$seo = is_seo_url($link, $query);

			}

		}

		if($seo){
			$link = $seo;
		} else {
			$link = 'index.php?' . $link;
		}

		//remastered URLs out
		/*
		if (!preg_match('/\/secure9584\//',$_SERVER['PHP_SELF']) && $alias) { // not admin area
			$link=str_replace('controller=','',$link);
			$link=str_replace('&','/',$link);
			$link=str_replace('=','/',$link);
			$link=str_replace('index.php?','',$link);
		}
		*/

		if ( $sub_query ) {

			foreach ($sub_query as $key => $value) {

				if ($value) {

					if ( preg_match('/\?/', $link) ) {

						$link .= '&' . $key . '=' . $value; //controller=post&id=20214&method=edit


					} else {

						$link .= '?' . $key . '=' . $value;	//controller=post&id=20214&method=edit

					}

				}

			}

		}

		return htmlspecialchars($server . $link);
	}
}
?>
