<?php
abstract class Controller {
	protected $registry;	
	protected $id;
	protected $layout;
	protected $template;
	protected $children = array();
	protected $data = array();
	protected $output;
	
	public function __construct($registry) {
		$this->registry = $registry;
	}
	
	public function __get($key) {
		return $this->registry->get($key);
	}
	
	public function __set($key, $value) {
		$this->registry->set($key, $value);
	}
	
	protected function forward($class, $method = 'index') {
		$controller = $this->__get('controller');
		return $controller->forward($class, $method);
	}

	protected function redirect($url, $status = 302) {
		_send_error_mail();
		header('Status: ' . $status);
		header('Location: ' . str_replace('&amp;', '&', $url));
		exit();
	}
	
	protected function getChild($child) {
		$file 	= DIR_CONTROLLER . basename($child) . '.php';
		$class 	= 'Module' . preg_replace('/[^a-zZ-Z0-9]/', NULL, $child);
		$method = 'fetch';
	
		if (file_exists($file)) {
			require_once($file);
			$controller = new $class($this->registry);
			$controller->$method();
			return $controller->output;
		} else {
			exit('Error: Could not load controller ' . $child . '!');
		}		
	}
	
	protected function render() {
		foreach ($this->children as $child) {
			$this->data[basename($child)] = $this->getChild($child);
		}
		
		if (file_exists(DIR_VIEW . $this->template)) {
			$template = $this->__get('template');
			
			if($this->data){
				foreach($this->data as $key => $value){
					$template->assign($key, $value);
				}
			}
			
			$this->output = $template->fetch(DIR_VIEW . $this->template);
			
			return $this->output;
			
    	} else {
      		exit('Error: Could not load template ' . DIR_VIEW . $this->template . '!');
    	}
	}
}
?>