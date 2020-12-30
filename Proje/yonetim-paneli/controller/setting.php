<?php

Class ControllerSetting Extends Controller{

	public function index () {

 		if(!$this->user->hasUserPerm($this->request->get('controller'), "view")){
 			return $this->forward('error','denied');
 		}


		$this->document->setTitle('Ayarlar');

		if ( $this->request->isPOST() ) {

			if(!$this->user->hasUserPerm($this->request->get('controller'), "edit")){
	 			return $this->forward('error','denied');
	 		}

			$error = false;

			foreach ( $_POST as $key => $value ) {

				$this->db->query("UPDATE setting SET value = '".$this->db->escape($value)."' WHERE name = '".$this->db->escape($key)."' && status = 0 ");

			}

			$this->session->set('success', 'Ayarlar güncellendi');

			$this->redirect($this->url->link('setting'));

		}

		$query = $this->db->query("SELECT * FROM setting WHERE status = 0 ORDER BY id ASC");

		$this->data['settings'] = array();

		if ( $query->rows ) {

			$this->data['settings'] = $query->rows;

		}

		$this->data['action'] = $this->url->link('setting');

		$this->template = 'setting.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());

	}

}

?>
