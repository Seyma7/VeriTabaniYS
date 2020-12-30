<?php

Class ControllerError Extends Controller{

	public function index () {

		$this->document->setTitle('404 - Aradığınız sayfa bulunamadı.');

		$this->data['error'] = 'Girmek istediğiniz sayfa bulunamadı. Silinmiş yada değiştirilmiş olabilir.';

		$this->template = 'error.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());

	}

	public function denied () {

		$this->document->setTitle('Yetki aşımı!');

		$this->data['error'] = 'Bu sayfaya / işleme erişim yetkiniz bulunmamaktadır.';

		$this->template = 'error.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());

	}

}

?>
