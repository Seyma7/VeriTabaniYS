<?php
final class Front {
	protected $registry;
	public $pre_action = array();
	public $error;
	public $default;
	public $directory;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function addPreAction($class, $method) {
		$this->pre_action[] = array('class' => $class, 'method' => $method);
	}
	
	function setDirectory($directory) {
		$this->directory = $directory;
	}	
	
	public function setDefault($class, $method) {
		$this->default = $this->forward($class, $method);
	}
	
	public function setError($class, $method) {
		$this->error = $this->forward($class, $method);
	}	

	function forward($class, $method) {
		$action = array(
			'class'  => $class,
			'method' => $method
		);
		
		return $action;
  	}	
	
  	public function dispatch($request) {
	
		$action = $this->requestHandler($request);
		
		$i = 0;
		
		while ($action) {
			if ($i > 4) {
				exit('Error: Maximum number of forwards has been exceeded!');
			}
			$i++;
			foreach ($this->pre_action as $pre_action) {
				$result = $this->execute($pre_action);						
				if ($result) {
					$action = $result; 
					break;
				}
			}
			$action = $this->execute($action);
		}
  	}
    
	private function execute($action) {

		$file 	= $this->directory . basename($action['class']) . '.php';
		$class 	= 'Controller' . preg_replace('/[^a-zZ-Z0-9]/', NULL, $action['class']);
		$method = $action['method'];
		
		$action = '';

		if (file_exists($file)) {
			require_once($file);

			$controller = new $class($this->registry);
			
			if (is_callable(array($controller, $method))) {
				$action = $controller->$method();
			} else {
				return $this->error;
			}
		} else {			
			return $this->error;
		}
		
		return $action;
	}
	
	public function requestHandler(&$request) {
	    if ($request->has('controller')) {
			$class = $request->get('controller');
			
			if ($request->has('method')) {
				$method = $request->get('method');
			} else {
				$method = 'index';
			}

			return $this->forward($class, $method);
	    } else {
	        return $this->default;
	    }
	}	
}
?>