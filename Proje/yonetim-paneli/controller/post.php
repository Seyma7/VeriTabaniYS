<?php
Class ControllerPost Extends Controller{

	private $error 				= false;
	private $post_info 			= array();

	public function index () {

		if(!$this->user->hasUserPerm($this->request->get('controller'), "view")){
			return $this->forward('error','denied');
		}

		$this->load->model('preserve');

		$this->document->setTitle('Haberler');
		$this->data['description']	= " Haber ekleyebilir, varolanları düzeltip silebilirsiniz. Yeni bir haber eklemek için aşağıdaki <i>Ekle</i> butonunu tıklayınız.";

		$this->data['search_query'] = ($this->request->has('search_query') ? urldecode($this->request->get('search_query')) : $this->request->post('search_query'));


		$page 	= (!$this->request->has('page') || (int)$this->request->get('page') < 1 ? 1 : (int)$this->request->get('page'));
		$limit 	= 20;
		$start	= ($page - 1) * $limit;


		$sql 	= "
					SELECT p.*,
						(SELECT username FROM user WHERE user_id = p.last_update_user_id)  as last_update_username,
						(SELECT username FROM user WHERE user_id = p.user_id) as add_username
					FROM post p
					LEFT JOIN post_category pc ON pc.post_id = p.id
				 ";

		$sql_where = " WHERE p.status NOT IN (6) && pc.category_id = '".$this->config->get('post_parent_id')."' ";

		if ( $this->request->has('offset') && $this->model_preserve->hasPreserveID((int)$this->request->get('offset'))) {
				$sql .= " LEFT JOIN post_preserve pp ON pp.post_id = p.id   ";
	 			$sql_where .= " and pp.preserve_id = '".(int)$this->request->get('offset')."' ";
	 	}


		if ( $this->request->has('search_query') ) {
			$sql_where .= " and LCASE(p.name) LIKE '%".$this->db->escape(mb_strtolower(urldecode($this->request->get('search_query')), 'UTF-8'))."%' ";
		}

		$sql  =  $sql.$sql_where;


		switch ($this->request->get('sort')) {
			case 'name':
				$sql .= ' ORDER BY p.name ' . (strtoupper($this->request->get('type')) == 'ASC' ? 'ASC' : 'DESC');
				break;
			case 'sort_order':
				$sql .= ' ORDER BY p.sort_order ' . (strtoupper($this->request->get('type')) == 'DESC' ? 'DESC' : 'ASC');
				break;
			case 'user_id':
				$sql .= ' ORDER BY p.user_id ' . (strtoupper($this->request->get('type')) == 'DESC' ? 'DESC' : 'ASC');
				break;
			case 'date_added':
				$sql .= ' ORDER BY p.date_added ' . (strtoupper($this->request->get('type')) == 'DESC' ? 'DESC' : 'ASC');
				break;
			case 'date_updated':
				$sql .= ' ORDER BY p.date_updated ' . (strtoupper($this->request->get('type')) == 'DESC' ? 'DESC' : 'ASC');
				break;
			case 'last_update_user_id':
				$sql .= ' ORDER BY p.last_update_user_id ' . (strtoupper($this->request->get('type')) == 'DESC' ? 'DESC' : 'ASC');
				break;
			default:
				$sql .= ' ORDER BY p.date_added DESC, p.sort_order ASC ';
				break;
		}


		$total 	= $this->db->query($sql);

		$link  = array('name',  'date_added', 'date_updated', 'sort_order', 'status', 'user_id', 'last_update_user_id');
		$links = array();

		foreach ( $link as $l ){

			$links[$l] = array(
				'class'	=> (
					$this->request->get('sort') == $l ? ($this->request->get('type') == 'asc' ? 'asc' : 'desc') : ''
				),
				'url'	=> (
					$this->url->link($this->request->get('controller'), false, array(
						'sort' 					=> $l,
						'type' 					=> ($this->request->get('type') == 'asc' ? 'desc' : 'asc'),
						'page' 					=> $this->request->get('page'),
						'search_query' 	=> $this->request->get('search_query'),
						'offset' 				=> $this->request->get('offset'),
					))
				)
			);

		}

		$this->data['link'] = $links;

		$query 	= $this->db->query($sql . " LIMIT {$start}, {$limit}");

		$this->data['posts'] = array();

		if ( $query->rows ) {

			foreach ( $query->rows as $row ) {

				$data = array(

					'id'					=> $row['id'],
					'name'					=> $row['name'],
					'user_id'				=> $row['user_id'],
					'add_username'			=> $row['add_username'],
					'date_added'			=> ($row['date_added'] ? $this->datetimes->convertDatetime('%d.%m.%Y, %H:%M',$row['date_added']) : false),
					'date_updated'			=> ($row['date_updated'] ? $this->datetimes->convertDatetime('%d.%m.%Y, %H:%M',$row['date_updated']) : false),
					'last_update_username'	=> ($row['last_update_user_id'] ? $row['last_update_username'] : false),
					'sort_order'			=> $row['sort_order'],
					'status'				=> $row['status'],
					'edit'					=> $this->url->link($this->request->get('controller'), 'edit', array('id' => $row['id'])),
				);


				$queryPreserve = $this->db->query("
															SELECT pp.preserve_id, p.name, p.code
															FROM post_preserve pp
															LEFT JOIN preserve p ON p.id = pp.preserve_id
															WHERE pp.post_id = '".(int)$data['id']."' && p.status = 1 ORDER BY pp.preserve_id");

				if ($queryPreserve->rows) {
					$data['preserve']  =  $queryPreserve->rows;
				}

				$this->data['posts'][]  = $data;
			}
		}



		// Preserves Selected
		$preserves			= $this->model_preserve->getPreserveList();
		foreach($preserves as $key => $value){

			$preserves[$key]['url']		=		$this->url->link($this->request->get('controller'), false, array(
				'sort' 					=> $this->request->get('sort'),
				'type' 					=> ($this->request->has('sort') ? (in_array($this->request->get('type'), array('asc','desc')) ? $this->request->get('type') : 'desc')  : false ),
				//'page' 					=> $this->request->get('page'),
				'search_query' 	=> $this->request->get('search_query'),
				'offset' 				=> $key,
			));

		}
		if ( $this->request->has('offset') && $this->model_preserve->hasPreserveID((int)$this->request->get('offset'))) {
			 	$preserves[(int)$this->request->get('offset')]['selected'] = 1;
		}
		$this->data['preserve'] 							= 		$preserves;

		// Preserves Select Default Link
		$this->data['default_preserve_url'] 	= 		$this->url->link($this->request->get('controller'), false, array(
			'sort' 					=> $this->request->get('sort'),
			'type' 					=> ($this->request->has('sort') ? (in_array($this->request->get('type'), array('asc','desc')) ? $this->request->get('type') : 'desc')  : false ),
			//'page' 					=> $this->request->get('page'),
			'search_query' 	=> $this->request->get('search_query'),
		));



		$this->data['insert'] 			= $this->url->link($this->request->get('controller'), 'insert');
		$this->data['action'] 			= $this->url->link($this->request->get('controller'), 'delete');
		$this->data['search_action']	= $this->request->get('controller');

		$url = $this->url->link(
			$this->request->get('controller'), false,
			array('sort' => $this->request->get('sort'),
			'type' => $this->request->get('type'),
			'page' => '{page}',
			'search_query' 	=> $this->request->get('search_query'),
			'offset' 	=> $this->request->get('offset')
		));

		$pagination 								= new Pagination();
		$pagination->total 					= $total->num_rows;
		$pagination->page 					= $page;
		$pagination->limit 					= $limit;
		$pagination->url 						= $url;
		$this->data['pagination'] 	= $pagination->render();

		if ($this->error) {

			$this->data['error'] = $this->error;
		}

		$this->template = 'post.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());

	}


	////////////////////// DÜZENLE
	public function edit () {

		if(!$this->user->hasUserPerm($this->request->get('controller'), "edit")){
			return $this->forward('error','denied');
		}

		$this->load->model('image');
		$this->load->model('category');
		$this->load->model('preserve');
		$this->load->model('post');

		$this->document->setTitle('Haber Düzenle');

		$query = $this->db->query("

								SELECT p.*, pl.location_id
								FROM post p
								LEFT JOIN post_category pc ON pc.post_id = p.id
								LEFT JOIN post_location pl ON pl.post_id = p.id
								WHERE p.id = '".(int)$this->request->get('id')."' && pc.category_id = '".$this->config->get('post_parent_id')."'

								");

		if ($query->rows) {

			$this->post_info 	=	$query->row;

			$queryVideo = $this->db->query("SELECT * FROM post_video WHERE post_id = '".(int)$this->request->get('id')."' ");
			if ($queryVideo->row) {

				$this->post_info['video']	=	array(
					'status' => 1,
					'source' => $queryVideo->row['video_id'],
					'name' => $queryVideo->row['video_name'],
					'url' => $queryVideo->row['video_url']
				);
			}


			$queryPreserve = $this->db->query("SELECT preserve_id FROM post_preserve WHERE post_id = '".(int)$this->request->get('id')."' ORDER BY preserve_id");
			if ($queryPreserve->rows) {
				$this->post_info['preserve']  =  $queryPreserve->rows;
			}


		} else {

			$this->redirect($this->url->link($this->request->get('controller')));

		}


		if ( $this->request->isPOST() && $this->validateForm() ) {

			$post_id 			=	(int)$this->request->get('id');
			$this->load->library('slug');
			$slug = new Slug;

		 	$this->db->query(

				"
				UPDATE post SET
				category_id					= '".(int)$this->request->post('category')."',
				date_updated				= '".$this->datetimes->getDatetime()."',
				name 								= '".$this->db->escape($this->request->post('name'))."',
				slug 								= '".$this->db->escape( $slug->title( $this->request->post('name') ) )."',
				description 				= '".$this->db->escape($this->request->post('description'))."',
				last_update_user_id	= '".$this->session->get('user_id')."',
				sort_order					= '".(int)$this->request->post('sort_order')."',
				status							= '".(int)$this->request->post('status')."'
				WHERE  					id	= '".$post_id."'
				"
			);
			// Add Post Cateogry
			$this->model_post->clearPostCategory((int)$post_id);
			$category_list 		= array_reverse($this->model_category->parentCategories((int)$this->request->post('category') ));

			foreach ( $category_list as $value ) {
				$this->db->query(" INSERT INTO post_category SET post_id = '".(int)$post_id."', category_id = '".$value['id']."' ");
			}

			// Add Post Location
			$this->model_post->clearPostLocation((int)$post_id);
			$this->db->query(" INSERT INTO post_location SET post_id = '".(int)$post_id."', location_id = '".(int)$this->request->post('location')."' ");


			// Add Post Images
			$p_images 			= $this->request->post('image');
			$s_image		 		= $this->request->post('image_selected');

			if ( $p_images ) {

				$this->model_post->clearPostImages((int)$post_id);

				foreach ( $p_images as $key => $value ) {
					$preview = ($s_image == $value ? 1 : 2);
					$this->model_post->addPostImage($post_id, $value, (int)$preview, (int)$key);
				}
			}



			// Add Post Videos
			$this->model_post->clearPostVideo((int)$post_id);
			if ( $this->request->has('video','post') ) {

				$video 		=	$this->request->post('video');

				if((int)$video['status']){

					$this->db->query("
						INSERT INTO post_video SET
						post_id 		= '".(int)$post_id."',
						video_id 		= '".(int)$video['source']."',
						video_url 		= '".$this->db->escape($video['url'])."',
						video_name 		= '".$this->db->escape($video['name'])."'
					");
				}
			}


			// Add Post Preserve
			$this->model_post->clearPostPreserve((int)$post_id);
			if( $this->request->has('preserve', 'post') ){

				 foreach ($this->request->post('preserve') as $value) {

					 	if( $this->model_preserve->hasPreserveID($value['preserve_id']) ){

							$this->db->query("
								INSERT INTO post_preserve SET
								post_id 			= '".(int)$post_id."',
								preserve_id 	= '".(int)$value['preserve_id']."'
							");

						}
				 }
			}


			$this->cache->delete('news.post');
			$this->session->set('success', $this->request->post('name') . ' isimli haber başarıyla güncellendi.');


			if ( $this->request->post('stayOnPage') == 'new' ) {

				$redirect_url = $this->url->link($this->request->get('controller'), 'insert');

			} else if ( $this->request->post('stayOnPage') == 'edit' ) {

				$redirect_url = $this->url->link($this->request->get('controller'), 'edit', array('id' => (int)$post_id));

			} else {

				$redirect_url = $this->url->link($this->request->get('controller'));

			}

			$this->redirect($redirect_url);

		}


		$this->data['cancel'] = $this->url->link($this->request->get('controller'));
		$this->data['action'] = $this->url->link($this->request->get('controller'), 'edit', array('id' => (int)$this->request->get('id')));
		$this->data['delete'] = $this->url->link($this->request->get('controller'), 'delete', array('id' => (int)$this->request->get('id')));

		return $this->form();

	}


	public function insert(){

		if(!$this->user->hasUserPerm($this->request->get('controller'), "insert")){
			return $this->forward('error','denied');
		}

		$this->load->model('image');
		$this->load->model('category');
		$this->load->model('post');
		$this->load->model('preserve');

		$this->document->setTitle('Haber Ekle');

		if ($this->request->isPOST() && $this->validateForm() ) {

			$this->load->library('slug');
			$slug = new Slug;

			$this->db->query(

				"
				INSERT INTO post SET
				category_id			= '".(int)$this->request->post('category')."',
				user_id					= '".$this->session->get('user_id')."',
				name 						= '".$this->db->escape($this->request->post('name'))."',
				slug 						= '".$this->db->escape( $slug->title( $this->request->post('name') ) )."',
				description 		= '".$this->db->escape($this->request->post('description'))."',
				date_added			= '".$this->datetimes->getDatetime()."',
				sort_order			= '".(int)$this->request->post('sort_order')."',
				status					= '".(int)$this->request->post('status')."'
				"
			);

			$post_id 			= $this->db->getLastId();


			// Add Post Cateogry
			$this->model_post->clearPostCategory((int)$post_id);
			$category_list 		= array_reverse($this->model_category->parentCategories((int)$this->request->post('category') ));

			foreach ( $category_list as $value ) {
				$this->db->query(" INSERT INTO post_category SET post_id = '".(int)$post_id."', category_id = '".$value['id']."' ");
			}


			// Add Post Location
			$this->model_post->clearPostLocation((int)$post_id);
			$this->db->query(" INSERT INTO post_location SET post_id = '".(int)$post_id."', location_id = '".(int)$this->request->post('location')."' ");


			// Add Post Images
			$p_images 			= $this->request->post('image');
			$s_image		 	= $this->request->post('image_selected');

			if ( $p_images ) {

				$this->model_post->clearPostImages((int)$post_id);

				foreach ( $p_images as $key => $value ) {
					$preview = ($s_image == $value ? 1 : 2);
					$this->model_post->addPostImage($post_id, $value, (int)$preview, (int)$key);
				}
			}

			// Add Post Videos
			$this->model_post->clearPostVideo((int)$post_id);
			if ( $this->request->has('video','post') ) {

				$video 		=	$this->request->post('video');

				if((int)$video['status']){

					$this->db->query("
						INSERT INTO post_video SET
						post_id 		= '".(int)$post_id."',
						video_id 		= '".(int)$video['source']."',
						video_url 		= '".$this->db->escape($video['url'])."',
						video_name 		= '".$this->db->escape($video['name'])."'
					");
				}
			}



			// Add Post Preserve
			//$this->model_post->clearPostPreserve((int)$post_id);
			if( $this->request->has('preserve', 'post') ){

				 foreach ($this->request->post('preserve') as $value) {

					 	if( $this->model_preserve->hasPreserveID($value['preserve_id']) ){

							$this->db->query("
								INSERT INTO post_preserve SET
								post_id 			= '".(int)$post_id."',
								preserve_id 	= '".(int)$value['preserve_id']."'
							");

						}
				 }
			}


			$this->cache->delete('news.post');
			$this->session->set('success', $this->request->post('name') . ' isimli haber başarıyla eklendi.');

			if ( $this->request->post('stayOnPage') == 'new' ) {

				$redirect_url = $this->url->link($this->request->get('controller'), 'insert');

			} else if ( $this->request->post('stayOnPage') == 'edit' ) {

				$redirect_url = $this->url->link($this->request->get('controller'), 'edit', array('id' => (int)$post_id));

			} else {

				$redirect_url = $this->url->link($this->request->get('controller'));

			}

			$this->redirect($redirect_url);

		}



		$query = $this->db->query("SELECT sort_order FROM post ORDER BY sort_order DESC LIMIT 1");

		if ( $query->rows ) {

			$this->post_info['sort_order_default'] = (int)$query->row['sort_order'] + 1;

		} else {

			$this->post_info['sort_order_default'] = 1;

		}


		$this->data['cancel'] = $this->url->link($this->request->get('controller'));
		$this->data['action'] = $this->url->link($this->request->get('controller'), 'insert');

		return $this->form();
	}


	public function form () {

		$this->load->model('image');
		$this->load->model('category');
		$this->load->model('location');
		$this->load->model('preserve');
		$this->load->model('post');

		$category_list 									= array();
		$categories[] 									= $this->model_category->get_sub_categories(0, $this->config->get('post_parent_id'));

		$this->data['method'] 					= $this->request->get('method');
		$this->data['name'] 						= $this->db->escapeText($this->request->has('name', 'post') ? $this->request->post('name') : (isset($this->post_info['name']) ? $this->post_info['name'] : ""));
		$this->data['description'] 			= $this->db->escapeText($this->request->has('description', 'post') ? $this->request->post('description') : (isset($this->post_info['description']) ? $this->post_info['description'] : ""));
		$this->data['date_added'] 			= (isset($this->post_info['date_added']) ? $this->post_info['date_added'] : false);
		$this->data['date_published'] 	= (isset($this->post_info['date_published']) ? $this->post_info['date_published'] : false);
		$this->data['status'] 					= ($this->request->has('status', 'post') ? $this->request->post('status') : (isset($this->post_info['status']) ? $this->post_info['status'] : 1));
		$this->data['sort_order']				= ($this->request->has('sort_order', 'post') ? $this->request->post('sort_order') : (isset($this->post_info['sort_order']) ? $this->post_info['sort_order'] : $this->post_info['sort_order_default']));
		$this->data['video']						= ($this->request->has('video', 'post') ? $this->request->post('video') : (isset($this->post_info['video']) ? $this->post_info['video'] : false) );
		$preserve												= ($this->request->has('preserve', 'post') ? $this->request->post('preserve') : (isset($this->post_info['preserve']) ? $this->post_info['preserve'] : false) );
		$this->data['location']					=	($this->request->has('location', 'post') ? (int)$this->request->post('location') : (isset($this->post_info['location_id']) ? (int)$this->post_info['location_id'] : false));
		$lastCategoryID 								= ($this->request->has('category', 'post') ? (int)$this->request->post('category') : (isset($this->post_info['category_id']) ? (int)$this->post_info['category_id'] : false));

		// Kategori Seçim Alanı - Eksik kategori seçerse tüm kategori seçim bilgisini sıfırlar.
		if( $lastCategoryID ){

			$isCategories				= $this->model_category->get_sub_categories( $lastCategoryID );

			if(!$isCategories){

				$category_list			= array_reverse($this->model_category->parentCategories( $lastCategoryID ));

				foreach($category_list as $row){
					$categories[]		=	$this->model_category->get_sub_categories($row['id']);
				}
			}
		}


		// Preserves Selected
		$preserves = $this->model_preserve->getPreserveList();
		if($preserve){
			foreach ($preserve as $value) {
				 if( $this->model_preserve->hasPreserveID($value['preserve_id']) ){
						$preserves[$value['preserve_id']]['selected'] = 1;
				 }
			}
		}
		$this->data['preserves'] = $preserves;


		$this->data['category_list']			= $category_list;
		$this->data['categories']					= $categories;


		$this->data['statuses'][]					= array('id' => 1, 'name' => 'Aktif');
		$this->data['statuses'][]					= array('id' => 2, 'name' => 'Pasif');
		//$this->data['statuses'][]					= array('id' => 6, 'name' => 'Silinmiş');


		$this->data['categories_url']			=	str_replace('&amp;', '&', $this->url->link('_ajax_services', 'getCategories'));
		$this->data['upload_image_url'] 	=	str_replace("&amp;","&",$this->url->link('_ajax_services','uploadPostImage'));


		// PHOTO
		// Haber Yayınlarken Hata Alırsa Post Ettiği Resimler Geri Gelsin
		$this->data['images'] =  array();

		if ( $this->request->has('image','POST') ) {

			$p_images 	= 	$this->request->post('image');

			foreach ( $p_images as $key => $value ) {

				$this->data['images'][] = array(

					'image' 	=> $value,
					'preview'	=> $this->model_image->resize($value, 78, 66)
				);
			}
		}else if(!$this->request->isPost() && $this->request->has('id','GET')){

					$images = $this->model_post->getPostImages((int)$this->request->get('id'));

					if ( $images ) {

						foreach ( $images as $image ) {
							$this->data['images'][] = array(

								'image' 	=> $image['image'],
								'preview'	=> $this->model_image->resize($image['image'], 78, 66)

							);
						}
					}
				}
		// END PHOTO


		// VİDEO
		$query 						= $this->db->query($sql = "SELECT * FROM video_list WHERE status = 1 ORDER BY sort_order ASC, name ASC");
		$this->data['video_list']	= $query->rows;
		// END VİDEO


		// LOCATİON
		$this->data['location_list']	= $this->model_location->getLocationList();

		if ($this->error) {

			$this->data['error'] = $this->error;
		}


		$this->template = 'post_form.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());
	}



	private function validateForm () {

		$this->load->model('category');
		$this->load->model('location');


		if ( !$this->request->post('image') ) {

			$this->error = 'Haber için en az 1 adet resim yüklenmelidir.';
		}

		if ( !in_array($this->request->post('status'), array(1, 2)) ) {

			$this->error = 'Haber yayın durumu girilmelidir.';
		}

	  if ( empty($this->request->post('description')) ) {

			$this->error = 'Haber içeriği boş bırakılamaz.';
		}

		if ($this->tools->strlen($this->request->post('name')) < 10 || $this->tools->strlen($this->request->post('name')) > 100) {

			$this->error = 'Haber başlığı 10 ile 100 karakter arasında olmalıdır. ';
		}


		if ( !(int)$this->request->post('location') || !$this->model_location->hasLocationID((int)$this->request->post('location')) ) {
			$this->error = 'Haber lokasyonunu belirtiniz.';
		}

		$isCategories 	=	$this->model_category->get_sub_categories((int)$this->request->post('category'));

		if($isCategories){

			$this->error = 'Eksik kategori bırakamazsınız. Lütfen tümünü seçip yeniden deneyin.';
		}


		if($this->request->post('video')){
			$video 		=  $this->request->post('video');

			if((int)$video['status']){

				if ( !(int)$video['source'] ) {
					$this->error = 'Lütfen video kaynağını belirtiniz.';
				}

				if ( !$video['url'] ) {
					$this->error = 'Lütfen video url\'ini belirtiniz.';
				}

				if ( $video['name'] && $this->tools->strlen($video['name']) < 10 || $this->tools->strlen($video['name']) > 100 ) {
					$this->error = 'Video başlığı 10 ile 100 karakter arasında olmalıdır.';
				}
			}
		}

		return (!$this->error ? true : false);

	}






	public function delete(){

		if(!$this->user->hasUserPerm($this->request->get('controller'), "delete")){
			return $this->forward('error','denied');
		}

		 if($this->request->post('selected')){

			foreach ($this->request->post('selected') as $id) {

				$this->db->query("DELETE FROM post WHERE id = '".(int)$id."'"); 
			}

			$this->session->set("success", "Haber(ler) başarıyla silindi.");


		}else if((int)$this->request->get('id')){

			$id 	= (int)$this->request->get('id');
			$this->db->query("DELETE FROM post WHERE id = '".(int)$id."'");
			$this->session->set("success", "Haber(ler) başarıyla silindi.");
		}

		$this->redirect($this->url->link($this->request->get('controller')));

	 }




}
?>
