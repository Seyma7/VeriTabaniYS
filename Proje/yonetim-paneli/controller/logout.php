<?php

Class ControllerLogout Extends Controller{


	public function index () {

		$this->user->logout();
		$this->redirect($this->url->get_server());

	}

}

?>
