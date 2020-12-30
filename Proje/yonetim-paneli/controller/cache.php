<?php

Class ControllerCache Extends Controller{

	public function index () {

		if(!$this->user->hasUserPerm($this->request->get('controller'), "view")){
			return $this->forward('error','denied');
		}

		$this->document->setTitle('Cache Yönetimi');

		if ( $this->request->isPOST() && $this->request->post('selected') ) {

			if(!$this->user->hasUserPerm($this->request->get('controller'), "delete")){
				return $this->forward('error','denied');
			}


			foreach ( $this->request->post('selected') as $items ) {

				foreach ( $items as $item ) {

					if ( file_exists(DIR_CACHE . $item) ) {

						unlink(DIR_CACHE . $item);

					}

				}

			}

			$this->session->set('success', 'Seçilen dosyalar silindi.');

			$this->redirect($this->url->link('cache'));

		}

		$caches = array();


		if( is_array(glob(DIR_CACHE . '*')) ){

			foreach ( glob(DIR_CACHE . '*') as $file ) {

			if ( file_exists($file) ) {

					$file = (basename($file));

					$parts = explode('.', $file);

					if ( count($parts) >= 3 ) {

						if ( !isset($caches[$parts[0] . '.' . $parts[1]]) ) {

							$caches[$parts[0] . '.' . $parts[1]] = array();

						}

						$create_date = date("Y-m-d H:i:s", filemtime(DIR_CACHE . $file));
						$expire_date = date('Y-m-d H:i:s', end($parts));

						$diff = abs(strtotime($expire_date) - strtotime($create_date));

						//_print($diff);

						$caches[$parts[0] . '.' . $parts[1]][] = array(
							'file' 		=> $file,
							'create'	=> $create_date,
							'expire' 	=> $expire_date,
							'duration'	=> ($diff >= 3600 ? ceil($diff / 60 / 60) . ' saat' : ceil($diff / 60) . ' dakika'),  
						);

					}

				}

			}
		}



		$this->data['caches'] = $caches;
		$this->data['action'] = $this->url->link('cache');

		$this->template = 'cache.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());

	}

}

?>
