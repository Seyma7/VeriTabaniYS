<?php

Class ModuleFooter Extends Controller{


	public function fetch () {
	
		$this->template = 'footer.html';
		
		$this->render();		
	
	}

}

?>