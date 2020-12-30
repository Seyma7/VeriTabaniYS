<?php

Class ControllerAjaxServices Extends Controller {

	////
	public function uploadPostImage () {

		if ( !$this->protectExternalQuery() ) {

			return $this->die_connection();

		}

		$json = array();

		$date = date('Y/m/d');
		$path = 'upload/' . $date;

		if ( !upload_date_path_control ( $date ) ) {

			$json['error']	= "{$path} oluşturulamıyor. Lütfen sistem yöneticinize başvurun.";

		}


		if ( !isset($json['error']) ) {

			$this->load->model('upload');
			$this->load->model('image');

      $allowed = array(
        'image/jpeg',
        'image/pjpeg',
        'image/png',
        'image/gif'
      );

			//$image 		= (isset($_FILES['image']) && $_FILES['image']['tmp_name'] ? $_FILES['image'] : (isset($_FILES['image2']) && $_FILES['image2']['tmp_name'] ? $_FILES['image2'] : (isset($_FILES['imageY']) && $_FILES['imageY']['tmp_name'] ? $_FILES['imageY'] : false)));

      $image      = false;
      $result     = false;
      $hash       = md5(time().rand(0, 1000).uniqid());
			$filename	  = "news_".$hash;

      if( isset($_FILES['image']) && $_FILES['image']['tmp_name'] ){

          $image       = $_FILES['image'];
    			$result      = $this->model_upload->upload($image, $filename, $path, 2097152, $allowed);

      }else if( isset($_FILES['imagetv']) && $_FILES['imagetv']['tmp_name'] ){

          $image       = $_FILES['imagetv'];
    			$filename	   = "broad_".$hash;
    			$result      = $this->model_upload->upload($image, $filename, $path, 2097152, $allowed, false, 200, 100);

      }else if( isset($_FILES['imageradio']) && $_FILES['imageradio']['tmp_name'] ){

          $image       = $_FILES['imageradio'];
    			$filename	   = "radio_".$hash;
    			$result      = $this->model_upload->upload($image, $filename, $path, 2097152, $allowed, false, 200, 100);
      }

      //$image 		 = (isset($_FILES['image']) && $_FILES['image']['tmp_name'] ? $_FILES['image'] : false);

			if ( isset($result['error']) ) {

				$json['error'] 		= $result['error'];

			} else {

				$json['image'] 		= $result['file'];

				$json['preview']	= (isset($_FILES['image']) && $_FILES['image']['tmp_name'] ? $this->model_image->resize($result['file'], 78, 66) : $this->model_image->resize($result['file'], 40, 40));

			}


		}

		$this->load->library('json');

		exit(Json::encode($json));

	}




	public function getCategories () {

		if ( !$this->protectExternalQuery() ) {

			return $this->die_connection();

		}

		$json = array('status' => 0, 'path' => '', 'data' => array());

		if ( (int)$this->request->post('parent_id') ) {

				$this->load->model('category');
				
				$json['data']	= $this->model_category->get_sub_categories((int)$this->request->post('parent_id'));

				if($json['data']){
					$json['status'] = 1;
				}
		}

		$this->load->library('json');

		$this->response->set(Json::encode($json));

	}



	public function captcha () {

		if ( !$this->protectExternalQuery() ) {

			return $this->die_connection();

		}

		$this->load->library('captcha');

		$captcha = new Captcha;

		$this->session->set('adminCaptcha', $captcha->getCode());

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
}

?>
