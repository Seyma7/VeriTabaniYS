<?php
class ModuleFooter extends Controller {
	protected function fetch() {

		$this->data['about_url']				=	$this->url->link('home','about');
		$this->data['privacy_url']			=	$this->url->link('home','privacy');
		$this->data['conditions_url']		=	$this->url->link('home','conditions');
		$this->data['tag_url']					=	$this->url->link('home','tag');
		$this->data['adv_url']					=	$this->url->link('home','adv');
		$this->data['contact_url']			=	$this->url->link('home','contact');
		$this->data['contact_us_url']		=	$this->url->link('home','contact_us');

		$this->template = 'footer.html';

		$this->render();
	}
}
?>
