<?php  
class ControllerError extends Controller {

	public function index() {
		
		$this->template = 'error.html';
		$this->children = array(
			'header',
			'footer',
		);		
						
		$this->response->set($this->render());		
	}
	
}
?>