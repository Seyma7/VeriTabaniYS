<?php

Class ModuleHeader Extends Controller{


	public function fetch () {

		$this->data['title'] 										= $this->document->getTitle();

		$this->data['isLogged']									= ($this->user->isLogged() ? true : false);
		$this->data['login_username']						= $this->user->getUserName();
		$this->data['system_time']							= strftime('%H:%M - %d.%m.%Y');

		$this->data['logout_url']								= $this->url->link('logout');
		$this->data['category_url']							= $this->url->link('category');
		$this->data['category_post_url']				= $this->url->link('category',false,array('parent'=> $this->config->get('post_parent_id')));

		$this->data['post_url']									= $this->url->link('post');
		$this->data['post_video_url']						= $this->url->link('post_video');
		$this->data['user_url']									= $this->url->link('user');
		$this->data['editor_url']								= $this->url->link('editor');

		$this->data['cache_url']								= $this->url->link('cache');
		$this->data['setting_url']							= $this->url->link('setting');


		if ($this->session->has('success')) {

			$this->data['success'] = $this->session->get('success');

			$this->session->delete('success');

		}

		if ($this->session->has('error')) {

			$this->data['error'] = $this->session->get('error');

			$this->session->delete('error');

		}

		$this->template = 'header.html';

		$this->render();

	}

}

?>
