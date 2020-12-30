<?php
Class ControllerUser Extends Controller{

	private $error 				= false;
	private $post_info 		= array();

	public function index () {
	/*
	if(!$this->user->hasUserPerm($this->request->get('controller'), "view")){
		return $this->forward('error','denied');
	}*/

		$this->document->setTitle('Hesap');
		$this->data['description']	= "Yönetici bilgilerinizi güncelleyebilirsiniz.";

		if( $this->request->IsPost() && $this->validateForm() ){
				/*
				if(!$this->user->hasUserPerm($this->request->get('controller'), "edit")){ 
					return $this->forward('error','denied');
				}*/

				$query = $this->db->query("UPDATE user SET password = '". $this->encryption->encrypt($this->request->post('password')) ."' WHERE user_id = '".(int)$this->user->getId()."' ");
				$this->session->set("success", "Parolanız başarıyla değiştirildi.");
				$this->response->redirect($this->url->link('home'));

		}

		$this->data['oldPassword'] 		= "";
		$this->data['password'] 			= ($this->request->has('password', 'post') ? $this->request->post('password') : "");
		$this->data['rePassword'] 		= ($this->request->has('rePassword', 'post') ? $this->request->post('rePassword') : "");




		if ($this->error) {
			$this->data['error'] = $this->error;
		}

		$this->template = 'user_form.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());

	}




		private function validateForm () {


			if($this->request->post('oldPassword')  &&  $this->request->post('password')  &&  $this->request->post('rePassword')){


					$query = $this->db->query("SELECT * FROM user WHERE
																			user_id = '".(int)$this->user->getId()."'
																			&& password = '". $this->encryption->encrypt($this->request->post('oldPassword')) ."' LIMIT 1");
					if(!$query->rows){

							$this->error = "Girilen parola bilgisiyle kayıt bulunamadı. Lütfen tekrar deneyiniz";

					}


					if($this->encryption->encrypt($this->request->post('oldPassword')) == $this->encryption->encrypt($this->request->post('password'))){

						 $this->error = "Yeni parolanız eski parolanız ile aynı olamaz. Lütfen başka bir parola giriniz.";

					}


					if($this->request->post('password') != $this->request->post('rePassword')){

						 	$this->error = "Yeni Parola ve Yeni Parola (Tekrar) alanları eşit olmalıdır.";
					}

			}



			if(!$this->request->post('rePassword')){

					$this->error = "Yeni Parola (Tekrar) alanını boş bırakamazsınız.";

			}

			if(!$this->request->post('password')){

					$this->error = "Yeni Parola alanını boş bırakamazsınız.";

			}else if(strlen($this->request->post('password')) < 6 || strlen($this->request->post('password')) > 20){

					$this->error = "Yeni Parola 6 ile 20 karakter arasında olmalıdır.";
			}


			if(!$this->request->post('oldPassword')){

					$this->error = "Parola alanını boş bırakamazsınız.";

			}


			return (!$this->error ? true : false);

		}


}
?>
