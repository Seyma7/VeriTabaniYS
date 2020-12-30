<?php

Class ControllerLogin Extends Controller{


	public function index () {

		if ($this->user->isLogged()) {
				$this->redirect($this->url->get_server());
		}
 

		if ($this->request->isPOST()) {

			if ($this->user->login($this->replaceSpace($this->request->post('username')), $this->encryption->encrypt($this->request->post('password')))) {

				$next = ($this->request->has('redirect', 'post') ? $this->request->post('redirect') : $this->url->get_server());

				$this->redirect($next);

			} else {

				$this->data['error'] = 'Kullanıcı adı veya şifre hatalı!';

			}
		}

		if ($this->request->has('redirect', 'post')) {

			$this->data['redirect'] = $this->request->post('redirect', 'post');

		} else {

			if ($this->request->get('controller') != 'login') {

				if (isset($_SERVER['REQUEST_URI'])) {

					$path = str_replace(str_replace('index.php', '', $_SERVER['SCRIPT_NAME']), '', $_SERVER['REQUEST_URI']);

				} else {

					$path = '';

				}

				$this->data['redirect'] = $this->url->get_server() . $path;

			}

		}

		$this->data['action'] 			= $this->url->link('login');
		$this->data['captcha_url'] 	= str_replace('&amp;','&',$this->url->link('_ajax_services','captcha'));

		$this->template = 'login.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());

	}


	public function replaceSpace($string)
	{
		$badString		=	array(" ","&nbsp;","&#x20;","&#32;");
		$string			=	str_replace($badString,"",htmlspecialchars_decode(urldecode($string)));

	    return $string;
	}

}

?>
