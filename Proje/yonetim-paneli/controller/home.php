<?php

Class ControllerHome Extends Controller{

	public function index () {
	
		$this->document->setTitle('Anasayfa');  

		$this->template = 'home.html';
		$this->children = array( 
			'header',
			'footer'
		);
		
		$this->response->set($this->render());		
	
	}
	
	public function permission () {
		
		if ($this->request->has('controller')) {
		
			$controller = $this->request->get('controller');
		
			$ignore = array(
			
				'login',
				'logout',
				'home'
			
			);
			
			if (!in_array($controller, $ignore) && !$this->user->hasPermission('access', $controller)) {
				
				return $this->forward('error', 'denied');
			
			}	
			
		}		
		
	}


	public function login () {
	
		if (!$this->user->isLogged()) {
		
			return $this->forward('login');
			
		}			
	
	}

}

?>