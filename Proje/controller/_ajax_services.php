<?php

Class ControllerAjaxServices Extends Controller {

  public function addRatio(){

		if ( !$this->protectExternalQuery() ) {
			return $this->die_connection();
		}

    if ( $this->request->isPost() ) {

      $this->load->model('post');

      $post_id      =  (int)$this->request->post('post');
      $ratio_type   =  $this->request->post('ratio');

      $ratio        =  (int)$this->model_post->addPostRatio((int)$post_id, $ratio_type);
      if( (int)$ratio ){

        $json['success']  = "Başarılı";
        $json['ratio']    = (int)$ratio;

      }else{

        $json['error']	=	"Hata oluştu. Lütfen tekrar deneyin.";
      }

    }else{

      $json['error']	=	"Hata oluştu. Lütfen tekrar deneyin.";
    }

    $this->load->library('json');
    exit(Json::encode($json));

  }


  public function getRadioSongName(){

		if ( !$this->protectExternalQuery() ) {
			return $this->die_connection();
		}

    if ( $this->request->isPost() ) {

      $url          =   $this->request->post('radio');
      $content 			= 	$this->curl_grab_page($url);
      $pattern 			= 	'/Current Song: <\/font><\/td><td><font class=default><b>(.+)<\/b><\/td>/i';
      preg_match_all($pattern, $content, $results);
      $songName			=		$results[1][0];

      if( strlen($songName) > 3 ){

          $json['success']      = "Başarılı";
          $json['itemName']     =  $songName;

      }else{

          $json['error']	=	"Hata oluştu. Lütfen tekrar deneyin.";
      }


    }else{
      $json['error']	=	"Hata oluştu. Lütfen tekrar deneyin.";
    }

    $this->load->library('json');
    exit(Json::encode($json));

  }



	public function captcha () {

		if ( !$this->protectExternalQuery() ) {

			return $this->die_connection();

		}

		$this->load->library('captcha');

		$captcha = new Captcha;

		$this->session->set('captcha', $captcha->getCode());

		$captcha->showImage();

	}


	private function protectExternalQuery () {

		$error = false;

		if ( !isset($_SERVER['HTTP_REFERER']) ) {
			$error = true;
		} else {
		}

		return (!$error ? true : false);

	}

	private function die_connection () {

		$this->load->library('json');

		exit(Json::encode(array('error' => 'Unexpected method!')));

	}

	private function karakter_duzeltme($gelen){

		$karakterler = array("ç","ğ","ı","i","ö","ş","ü");
		$degistir = array("Ç","Ğ","I","İ","Ö","Ş","Ü");
		return str_replace($karakterler, $degistir, $gelen);

	}



	private function curl_grab_page($url){

		$ch = curl_init();

		curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
		curl_setopt($ch, CURLOPT_TIMEOUT, 40);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

		curl_setopt($ch, CURLOPT_URL, $url);

		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

		ob_start();
		return curl_exec ($ch); // execute the curl command
		ob_end_clean();
		curl_close ($ch);
		unset($ch);

	}

}

?>
