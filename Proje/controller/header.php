<?php
Class ModuleHeader extends Controller{
	protected function fetch(){

		$this->data['title'] 				= $this->document->getTitle();
		$this->data['keywords']			= ($this->document->getKeywords() ? $this->document->getKeywords() : $this->config->get('keywords'));
		$this->data['description']	= ($this->document->getDescription() ? $this->document->getDescription() : $this->config->get('description'));

		$this->data['exchange'] 		= $this->exchange->getExchange();
		$this->data['weather'] 			= $this->weather->getWeather();
		
		$this->data['video_url']		=	$this->url->link('category','video');

		$this->data['file_version']	=	time();

		$this->data['social_urls']	=	 social_urls();

		if ($this->session->has('success')) {

			$this->data['success'] = $this->session->get('success');

			$this->session->delete('success');

		}

		if ($this->session->has('error')) {

			$this->data['error'] = $this->session->get('error');

			$this->session->delete('error');

		}

		if ($this->session->has('attention')) {

			$this->data['attention'] = $this->session->get('attention');

			$this->session->delete('attention');

		}

		$this->template = 'header.html';

		$this->render();
	}






}
?>
