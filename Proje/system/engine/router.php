<?php
final class Router {
	var $path;
	var $routes = array();
	
	function __construct($registry) {
        $this->db = $registry->get('db'); 
		$this->path=$this->getPath();
		#_print('route => ' . $this->path);
	}

	function getPath() {
		if(isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0){
			return $_SERVER['QUERY_STRING'];
		}
		
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
			$path = trim($path,'?');
        }	
		
		//remastered URLs in
		if (strstr($path,'/') && strlen($path) > 1) {
			$path = trim($path, '/');
			$path = str_replace('index.php','',$path);
			$query = explode('/', $path);
			$path = sprintf('controller=%s',array_shift($query));
			if (!empty($query)) {
				foreach ($query as $q) {
					$node=(isset($node) && $node == '&')?'=':'&';
					$path .= $node.$q;
				}
			}
		}

		$path = trim($path, '/');

		return $path;
	}
	
	function setRoutes($routes) {
		$this->routes = $routes;
	}
	
	function route(&$request) {
		if ($this->path) {
			$path = $this->path;
			$path = explode('&', $path);
			$pathsize=sizeof($path);
			for($i=0;$i < $pathsize;$i++) 
			{
				$route = explode('=',$path[$i]);
				if (!empty($route[0]) && !empty($route[1])) $request->set($route[0], $route[1]);
			}
		}
	}
}
?>
