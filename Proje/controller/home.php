<?php  // index.php
class ControllerHome extends Controller {
	public function index() {

		//$this->document->setTitle('');
		//$this->document->setDescription('');
 		//$this->document->setKeywords('');

		$this->load->model('post');

		$slide_attrs 	= array(
		 "limit"					=>		8,
		 "thumb"					=>		true,
		 "imgW"						=>		963,
		 "imgH"						=>		412,
		);
		$this->data['slide'] 							= 		$this->model_post->newws( 'post.slide', false, false, 'headline', $slide_attrs );

		$newsAgenda_attrs 	= array(
		 "limit"					=>		1,
		 "imgW"						=>		482,
		 "imgH"						=>		266,
		);
		$this->data['newsAgenda'] 				= 		$this->model_post->newws( 'post.newsAgenda', $this->config->get('post_parent_id'), false, 'home', $newsAgenda_attrs );

		$breakingNews_attrs 	= array(
		 "start"					=>		1,
 		 "limit"					=>		5,
		);
		$this->data['breakingNews'] 			= 		$this->model_post->newws( 'post.breakingNews', $this->config->get('post_parent_id'), false, 'home', $breakingNews_attrs );

		$newsShowcase_attrs 	= array(
		 "start"					=>		6,
 		 "limit"					=>		8,
		 "group"					=>		4,
		 "imgW"						=>		235,
		 "imgH"						=>		130,
		);
		$this->data['newsShowcase'] 			= 		$this->model_post->newws( 'post.newsShowcase', $this->config->get('post_parent_id'), false, 'home', $newsShowcase_attrs );

		$otherNews_attrs 	= array(
		 "start"					=>		15,
		 "limit"					=>		8,
		 "group"					=>		4,
		 "imgW"						=>		232,
		 "imgH"						=>		135,
		);
		$this->data['otherNews'] 			= 		$this->model_post->newws( 'post.otherNews',  $this->config->get('post_parent_id'), false, 'home', $otherNews_attrs );

		$recentVideos_attrs 	= array(
		 "limit"					=>		12,
		 "imgW"						=>		210,
		 "imgH"						=>		140,
		);
		$this->data['recentVideos'] 			= 		$this->model_post->newws( 'video.recentVideos',  $this->config->get('video_parent_id'), false, false, $recentVideos_attrs );

		$latestEconomy_attrs 	= array(
		 "limit"					=>		4,
		 "imgW"						=>		132,
		 "imgH"						=>		82,
		);
		$this->data['latestEconomy'] 			= 		$this->model_post->newws( 'post.latestEconomy',  $this->config->get('economy_category_id'), false, 'home', $latestEconomy_attrs );

		$latestWorld_attrs 	= array(
		 "limit"					=>		4,
		 "imgW"						=>		279,
		 "imgH"						=>		190,
		);
		$this->data['latestWorld'] 			= 		$this->model_post->newws( 'post.latestWorld',  $this->config->get('post_parent_id'), 'world', 'home', $latestWorld_attrs );

		$latestSpor_attrs 	= array(
		 "limit"					=>		10,
		 "imgW"						=>		232,
		 "imgH"						=>		135,
		);
		$this->data['latestSpor'] 			= 		$this->model_post->newws( 'post.latestSpor',  $this->config->get('spor_category_id'), false, 'home', $latestSpor_attrs );


		$this->template = 'home.html';
		$this->children = array(
			'header',
			'menu',
			'report_bug',
			'footer'
		);

		$this->response->set($this->render());
	}

	public function about(){


			$this->document->setTitle("Hakkında");
			$this->document->setKeywords("Hakkında");
			$this->document->setDescription("Hakkında");

			$this->data['post_share'] 	= social_share_urls($this->url->link('home', 'about'), 'Hakkında');

			$this->template = 'about.html';
			$this->children = array(
				'header',
				'menu',
				'report_bug',
				'footer'
			);

			$this->response->set($this->render());
	}


	public function privacy(){

			$this->document->setTitle("Hukuki Şartlar & Gizlilik");
			$this->document->setKeywords("Hukuki Şartlar & Gizlilik");
			$this->document->setDescription("Hukuki Şartlar & Gizlilik");

			$this->data['post_share'] 	= social_share_urls($this->url->link('home', 'privacy'), 'Hukuki Şartlar & Gizlilik');

			$this->template = 'privacy.html';
			$this->children = array(
				'header',
				'menu',
				'footer'
			);

			$this->response->set($this->render());
	}



	public function conditions(){

			$this->document->setTitle("İzinli İletişim Koşulları");
			$this->document->setKeywords("İzinli İletişim Koşulları");
			$this->document->setDescription("İzinli İletişim Koşulları");

			$this->data['post_share'] 	= social_share_urls($this->url->link('home', 'conditions'), 'İzinli İletişim Koşulları');

			$this->template = 'conditions.html';
			$this->children = array(
				'header',
				'menu',
				'footer'
			);

			$this->response->set($this->render());
	}
	public function tag(){

			$this->document->setTitle("Künye");
			$this->document->setKeywords("Künye");
			$this->document->setDescription("Künye");

			$this->data['post_share'] 	= social_share_urls($this->url->link('home', 'tag'), 'Künye');

			$this->template = 'tag.html';
			$this->children = array(
				'header',
				'menu',
				'footer'
			);

			$this->response->set($this->render());
	}
	public function adv(){

			$this->document->setTitle("Reklam");
			$this->document->setKeywords("Reklam");
			$this->document->setDescription("Reklam");

			$this->data['post_share'] 	= social_share_urls($this->url->link('home', 'adv'), 'Reklam');

			$this->template = 'adv.html';
			$this->children = array(
				'header',
				'menu',
				'footer'
			);

			$this->response->set($this->render());
	}

	public function contact(){

			$this->document->setTitle("İletişim");
			$this->document->setKeywords("İletişim");
			$this->document->setDescription("İletişim");

			$this->data['post_share'] 	= social_share_urls($this->url->link('home', 'contact'), 'İletişim');

			$message = array();

			$message['firstname'] 		=  ( $this->request->has('firstname', 'post') ? $this->request->post('firstname') : "" );
			$message['lastname'] 			=  ( $this->request->has('lastname', 'post') ? $this->request->post('lastname') : "" );
			$message['email'] 				=  ( $this->request->has('email', 'post') ? $this->request->post('email') : "" );
			$message['subject'] 			=  ( $this->request->has('subject', 'post') ? $this->request->post('subject') : "" );

			$this->data['message']		=	$message;

			if($this->request->isPOST() && $this->validateContact()){
			 $this->error =	"Mesajınızın iletimi sırasında hata oluştu. Lütfen gönderme işlemini tekrar deneyiniz.";
			}

			if ( $this->error ) {
				$this->data['error'] = $this->error;
			}

			if ( $this->session->has('success') ) {
				$this->data['success'] 	= $this->session->get('success');
				$this->session->delete('success');
			}


			$this->data['captcha_url'] 	=  htmlspecialchars_decode($this->url->link('_ajax_services', 'captcha'));

			$this->template = 'contact.html';
			$this->children = array(
				'header',
				'menu',
				'footer'
			);

			$this->response->set($this->render());
	}

	public function contact_us(){

			$this->document->setTitle("Bize Ulaşın");
			$this->document->setKeywords("Bize Ulaşın");
			$this->document->setDescription("Bize Ulaşın");

			$this->data['post_share'] 	= social_share_urls($this->url->link('home', 'contact_us'), 'Bize Ulaşın');

			$this->template = 'contact_us.html';
			$this->children = array(
				'header',
				'menu',
				'footer'
			);

			$this->response->set($this->render());
	}



	private function validateContact () {

		if (!$this->request->post('captcha')) {

			$this->error = 'Lütfen doğrulama kodunu giriniz.';

		}else if ( $this->request->post('captcha') != $this->session->get('captcha') ) {

			$this->error = 'Doğrulama kodunu kontrol ediniz.';

		}

		if (!$this->request->post('subject')) {

			$this->error = 'Lütfen konu alanını doldurunuz.';

		}

		if (!$this->request->post('email')) {

			$this->error = 'Lütfen eposta adresinizi giriniz.';

		}else if(!filter_var($this->request->post('email'), FILTER_VALIDATE_EMAIL)){

			$this->error = 'Lütfen eposta adresinizi kontrol ediniz.';
		}


		if (strlen($this->request->post('lastname')) < 3) {

			$this->error = 'Lütfen soyadınızı giriniz.';

		}

		if (strlen($this->request->post('firstname')) < 3) {

			$this->error = 'Lütfen adınızı giriniz.';

		}

		return ($this->error ? false : true);

	}
}
?>
