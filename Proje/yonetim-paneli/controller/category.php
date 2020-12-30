<?php

Class ControllerCategory Extends Controller{

	private $error 				= false;

	public function index () {

		if(!$this->user->hasUserPerm($this->request->get('controller'), "view")){
			return $this->forward('error','denied');
		}

		$this->document->setTitle('Kategoriler');
		$this->load->model('category');

		$this->data['search_query'] = ($this->request->has('search_query') ? urldecode($this->request->get('search_query')) : $this->request->post('search_query'));
		$this->data['parent'] 		= ($this->request->has('parent') ? (int)($this->request->get('parent')) : false);

		$page 	= (!$this->request->has('page') || (int)$this->request->get('page') < 1 ? 1 : (int)$this->request->get('page'));
		$limit 	= 20;
		$start	= ($page - 1) * $limit;


		$sql 	= "SELECT * FROM category WHERE parent = '".(int)$this->request->get('parent')."'";

		if ( $this->request->has('search_query') ) {

			$sql .= " AND LCASE(name) LIKE '%".$this->db->escape(mb_strtolower(urldecode($this->request->get('search_query')), 'UTF-8'))."%' ";

		}


		switch ($this->request->get('sort')) {
			case 'name':
				$sql .= ' ORDER BY name ' . (strtoupper($this->request->get('type')) == 'ASC' ? 'ASC' : 'DESC');
				break;
			case 'page_title':
				$sql .= ' ORDER BY page_title ' . (strtoupper($this->request->get('type')) == 'ASC' ? 'ASC' : 'DESC');
				break;
			case 'sort_order':
				$sql .= ' ORDER BY sort_order ' . (strtoupper($this->request->get('type')) == 'DESC' ? 'DESC' : 'ASC');
				break;
			case 'date_added':
				$sql .= ' ORDER BY date_added ' . (strtoupper($this->request->get('type')) == 'DESC' ? 'DESC' : 'ASC');
				break;
			case 'date_updated':
				$sql .= ' ORDER BY date_updated ' . (strtoupper($this->request->get('type')) == 'DESC' ? 'DESC' : 'ASC');
				break;
			default:
				$sql .= ' ORDER BY sort_order ASC';
				break;
		}

		$total 	= $this->db->query($sql);

		$link  = array('name', 'page_title', 'date_added', 'date_updated', 'sort_order', 'status');
		$links = array();

		foreach ( $link as $l ){

			$links[$l] = array(
				'class'	=> (
					$this->request->get('sort') == $l ? ($this->request->get('type') == 'asc' ? 'asc' : 'desc') : ''
				),
				'url'	=> (
					$this->url->link($this->request->get('controller'), false, array(
						'sort' 			=> $l,
						'type' 			=> ($this->request->get('type') == 'asc' ? 'desc' : 'asc'),
						'page' 			=> $this->request->get('page'),
						'parent' 		=> $this->request->get('parent'),
						'search_query' 	=> $this->request->get('search_query'),
					))
				)
			);

		}
		$this->data['link'] = $links;

		$query 	= $this->db->query($sql . " LIMIT {$start}, {$limit}");

		$this->data['categories'] = array();

		if ( $query->rows ) {

			foreach ( $query->rows as $row ) {

				$this->data['categories'][] = array(

					'id'			=> $row['id'],
					'name'			=> $row['name'],
					'page_title'	=> $row['page_title'],
					'date_added'	=> ($row['date_added'] ? date('d M Y, H:i', strtotime($row['date_added'])) : false),
					'date_updated'	=> ($row['date_updated'] ? date('d M Y, H:i', strtotime($row['date_updated'])) : false),
					'sort_order'	=> $row['sort_order'],
					'status'		=> $row['status'],
					'edit'			=> $this->url->link('category', 'edit', array('id' => $row['id'], 'parent' => (int)$this->request->get('parent'))),
					'url'			=> $this->url->link('category', false, array('parent' => $row['id']))

				);

			}

		}

		$this->data['current_category_path'] = $this->model_category->getPath((int)$this->request->get('parent'), $this->url->link('category', false, array('parent' => '%s')));


		$this->data['action'] = $this->url->link('category', 'delete');
		$this->data['insert'] = $this->url->link('category', 'insert', array('parent' => (int)$this->request->get('parent')));

		$url = $this->url->link('category', false, array('parent' => (int)$this->request->get('parent'), 'sort' => $this->request->get('sort'), 'type' => $this->request->get('type'), 'page' => '{page}'));

		$pagination = new Pagination();
		$pagination->total 			= $total->num_rows;
		$pagination->page 			= $page;
		$pagination->limit 			= $limit;
		$pagination->url 			= $url;
		$this->data['pagination'] 	= $pagination->render();

		if ($this->error) {

			$this->data['error'] = $this->error;

		}

		$this->template = 'category.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());

	}

	public function insert () {

		if(!$this->user->hasUserPerm($this->request->get('controller'), "insert")){
			return $this->forward('error','denied');
		}

		$this->document->setTitle('Kategori Ekle');

		$this->load->model('category');
		$this->load->library("slug");

		$slug		=	new Slug();

		if ($this->request->isPOST() && $this->validateForm()) {

			$this->db->query(

				"INSERT INTO category SET
				parent 				= '".(int)$this->request->post('parent')."',
				page_title 			= '".$this->db->escape($this->request->post('page_title'))."',
				name 				= '".$this->db->escape($this->request->post('name'))."',
				slug 				= '".$this->db->escape($slug->title($this->request->post('slug')))."',
				meta_description	= '".$this->db->escape($this->request->post('meta_description'))."',
				meta_keyword		= '".$this->db->escape($this->request->post('meta_keyword'))."',
				sort_order			= '".(int)$this->request->post('sort_order')."',
				status				= '".(int)$this->request->post('status')."',
				menu_status			= '".(int)$this->request->post('menu_status')."',
				date_added			= NOW(),
				date_updated		= NOW()"

			);

			$category_id = $this->db->getLastId();

			$path = $this->model_category->getPath($category_id);

			$this->db->query("INSERT INTO category_mirror SET id = '".(int)$category_id."', path = '".$this->db->escape($path)."'");

			$this->session->set('success', 'Kategori başarıyla eklendi.');

			if ( $this->request->post('stayOnPage') == 'new' ) {

				$redirect_url = $this->url->link('category', 'insert', array('parent' => (int)$this->request->get('parent')));

			} else if ( $this->request->post('stayOnPage') == 'edit' ) {

				$redirect_url = $this->url->link('category', 'edit', array('id' => $category_id, 'parent' => (int)$this->request->get('parent')));

			} else {

				$redirect_url = $this->url->link('category', false, array('parent' => (int)$this->request->get('parent')));

			}

			$this->redirect($redirect_url);

		}



		$query = $this->db->query($sql = "SELECT sort_order FROM category WHERE parent = '".(int)$this->request->get('parent')."' ORDER BY sort_order DESC LIMIT 1");

		if ( $query->rows ) {

			$this->data['sort_order_default'] = (int)$query->row['sort_order'] + 1;

		} else {

			$this->data['sort_order_default'] = 1;

		}

		$this->data['action'] = $this->url->link('category', 'insert', array('parent' => (int)$this->request->get('parent')));

		return $this->form();

	}


	public function delete(){

			if(!$this->user->hasUserPerm($this->request->get('controller'), "delete")){
				return $this->forward('error','denied');
			}

			$this->load->model('category');

		if($this->request->post('selected')){	//  category sayfasında seçili bir kategori silinmek istenirse onun id si gönderilecek ve alt kategorileri var mı kontrol edilecek
				foreach ($this->request->post('selected') as $id) {

					$category = $this->model_category->getCategories($id);

					if($category){

						foreach ($category as $row) {
							$this->model_category->clearCategory($row['id']);
							$this->model_category->clearCategoryMirror($row['id']);
						}

					}

					$this->model_category->clearCategory($id);
					$this->model_category->clearCategoryMirror($id);

				}

			}

		$this->redirect($this->url->link('category',false,array('parent' => (int)$this->request->get('parent'))));
	}




	public function edit () {

		if(!$this->user->hasUserPerm($this->request->get('controller'), "edit")){
			return $this->forward('error','denied');
		}

		$this->document->setTitle('Kategori Düzenle');

		$this->load->model('category');

		if ($this->request->isPOST() && $this->validateForm()) {


			$this->load->library("slug");
			$slug		=	new Slug();

			$this->db->query(

				"UPDATE category SET
				parent 				= '".(int)$this->request->post('parent')."',
				page_title 			= '".$this->db->escape($this->request->post('page_title'))."',
				name 				= '".$this->db->escape($this->request->post('name'))."',
				slug 				= '".$this->db->escape($slug->title($this->request->post('slug')))."',
				meta_description	= '".$this->db->escape($this->request->post('meta_description'))."',
				meta_keyword		= '".$this->db->escape($this->request->post('meta_keyword'))."',
				sort_order			= '".(int)$this->request->post('sort_order')."',
				status				= '".(int)$this->request->post('status')."',
				menu_status			= '".(int)$this->request->post('menu_status')."',
				date_updated		= NOW()
				WHERE id = '".(int)$this->request->get('id')."'"

			);


			$this->model_category->updateCategoryPath((int)$this->request->post('parent'));

			$this->session->set('success', 'Kategori başarıyla güncellendi.');

			if ( $this->request->post('stayOnPage') == 'new' ) {

				$redirect_url = $this->url->link('category', 'insert', array('parent' => (int)$this->request->get('parent')));

			} else if ( $this->request->post('stayOnPage') == 'edit' ) {

				$redirect_url = $this->url->link('category', 'edit', array('id' => (int)$this->request->get('id'), 'parent' => (int)$this->request->get('parent')));

			} else {

				$redirect_url = $this->url->link('category', false, array('parent' => (int)$this->request->get('parent')));

			}

			$this->redirect($redirect_url);

		}

		$this->data['action'] = $this->url->link('category', 'edit', array('id' => (int)$this->request->get('id'), 'parent' => (int)$this->request->get('parent')));

		return $this->form();

	}



	public function form () {

		$category_info = array();

		if ($this->request->get('method') == 'edit') {

			$query = $this->db->query(" SELECT c.* FROM category c WHERE c.id = '".(int)$this->request->get('id')."' ");

			if ($query->rows) {

				$category_info = $query->row;

			} else {

				$this->redirect($this->url->link('category'));

			}

		}


		$category_yol = str_replace(' &#187;',',',$this->model_category->getPath((int)$this->request->get('parent'), false, false));

		$category_yol = explode(',',$category_yol);

		$this->data['current_category_path333'] = count($category_yol);

		$category_count = count($category_yol);


		if($category_count == 10){
		if($category_count == 1){
			$category_seo_url2 = false;
			$category_page_title = false;
		}



		if($category_count == 2){
			$category_meta	=	$category_yol;
			krsort($category_meta);
			//$this->data['category_meta1']		= trim($category_meta[(count($category_meta)-1)]).' ';
			ksort($category_meta);
			krsort($category_meta);
			$category_meta[0] = ', '.$category_meta[0];
			//$this->data['category_meta2']		= implode('',$category_meta);
			$this->data['category_meta2']		= implode('',$category_meta);

			$category_seo_url	=	$category_yol;
			krsort($category_seo_url);
			array_pop($category_seo_url);
			ksort($category_seo_url);
			$category_seo_url2 = str_replace(' ','',implode('-',$category_seo_url)).'-';
			$this->data['category_seo_url'] = $category_seo_url2;

			$category_page_title = trim($category_yol[(count($category_yol)-1)]);
			$this->data['category_page_title']		= $category_page_title;
		}

		if($category_count == 3){

			$category_meta	=	$category_yol;
			krsort($category_meta);
			$this->data['category_meta1']		= trim($category_meta[(count($category_meta)-1)]).' ';
			ksort($category_meta);
			array_pop($category_meta);
			krsort($category_meta);
			$category_meta[0] = ', '.$category_meta[0];
			$this->data['category_meta2']		= implode('',$category_meta);

			$category_seo_url	=	$category_yol;
			krsort($category_seo_url);
			array_pop($category_seo_url);
			ksort($category_seo_url);
			$category_seo_url2 = str_replace(' ','',implode('-',$category_seo_url)).'-';
			$this->data['category_seo_url'] = $category_seo_url2;

			$category_page_title = trim($category_yol[(count($category_yol)-1)]);
			$this->data['category_page_title']		= $category_page_title;

		}

		 if($category_count == 4){

			$category_meta	=	$category_yol;		/*
			krsort($category_meta);
			//$this->data['category_meta1']		= trim($category_meta[(count($category_meta)-1)]).' ';
			ksort($category_meta);
			*/
			$this->data['category_meta1'] = implode(' ',$category_meta).' ';
			array_pop($category_meta);
			krsort($category_meta);
			$category_meta[0] = ', '.$category_meta[0];
			//$this->data['category_meta2']		= implode('',$category_meta);

			$category_seo_url	=	$category_yol;
			krsort($category_seo_url);
			array_pop($category_seo_url);
			ksort($category_seo_url);
			$category_seo_url2 = str_replace(' ','',implode('-',$category_seo_url)).'-';
			$this->data['category_seo_url'] = $category_seo_url2;


			$category_page_title = trim($category_yol[(count($category_yol)-1)]);
			$this->data['category_page_title']		= $category_page_title;

		}


		 if($category_count == 5){

			$category_meta	=	$category_yol;		/*
			krsort($category_meta);
			//$this->data['category_meta1']		= trim($category_meta[(count($category_meta)-1)]).' ';
			ksort($category_meta);
			*/
			$this->data['category_meta1'] = implode(' ',$category_meta).' ';
			array_pop($category_meta);
			krsort($category_meta);
			$category_meta[0] = ', '.$category_meta[0];
			//$this->data['category_meta2']		= implode('',$category_meta);

			$category_seo_url	=	$category_yol;
			krsort($category_seo_url);
			array_pop($category_seo_url);
			ksort($category_seo_url);
			$category_seo_url2 = str_replace(' ','',implode('-',$category_seo_url)).'-';
			$this->data['category_seo_url'] = $category_seo_url2;


			$category_page_title = trim($category_yol[(count($category_yol)-1)]);
			$this->data['category_page_title']		= $category_page_title;

		}


		}



		 if($category_count > 1){
			$category_meta	=	$category_yol;		/*
			krsort($category_meta);
			//$this->data['category_meta1']		= trim($category_meta[(count($category_meta)-1)]).' ';
			ksort($category_meta);
			*/
			$this->data['category_meta1'] = implode('',$category_meta).' ';
			array_pop($category_meta);
			krsort($category_meta);
			$category_meta[0] = ', '.$category_meta[0];
			//$this->data['category_meta2']		= implode('',$category_meta);

			$category_seo_url	=	$category_yol;
			krsort($category_seo_url);
			array_pop($category_seo_url);
			ksort($category_seo_url);
			$category_seo_url2 = str_replace(' ','',implode('-',$category_seo_url)).'-';
			$this->data['category_seo_url'] = $category_seo_url2;


			$category_page_title = trim($category_yol[(count($category_yol)-1)]);
			$this->data['category_page_title']		= $category_page_title.' ';
		}else{

			$category_seo_url2 = '';
			$category_page_title = '';

		}

		$this->data['page_title'] 			= ($this->request->has('page_title', 'post') ? $this->request->post('page_title') : (isset($category_info['page_title']) ? $category_info['page_title'] : $category_page_title));
		$this->data['name'] 						= ($this->request->has('name', 'post') ? $this->request->post('name') : (isset($category_info['name']) ? $category_info['name'] : ""));
		$this->data['parent']						= ($this->request->has('parent', 'post') ? $this->request->post('parent') : (isset($category_info['parent']) ? $category_info['parent'] : ($this->request->has('parent') ? $this->request->get('parent') : false)));
		$this->data['slug']							= ($this->request->has('slug', 'post') ? $this->request->post('slug') : (isset($category_info['slug']) ? $category_info['slug'] : $category_seo_url2));
		$this->data['meta_description']	= ($this->request->has('meta_description', 'post') ? $this->request->post('meta_description') : (isset($category_info['meta_description']) ? $category_info['meta_description'] : ""));
		$this->data['meta_keyword']			= ($this->request->has('meta_keyword', 'post') ? $this->request->post('meta_keyword') : (isset($category_info['meta_keyword']) ? $category_info['meta_keyword'] : ""));
		$this->data['sort_order']				= ($this->request->has('sort_order', 'post') ? $this->request->post('sort_order') : (isset($category_info['sort_order']) ? $category_info['sort_order'] : $this->data['sort_order_default']));
		$this->data['status']						= ($this->request->has('status', 'post') ? $this->request->post('status') : (isset($category_info['status']) ? $category_info['status'] : 1));
		$this->data['categories'] 			= $this->model_category->getCategoriesFromPath();

		$this->data['cancel'] = $this->url->link('category', false, array('parent' => (int)$this->request->get('parent')));
		$this->data['current_category_path'] = $this->model_category->getPath((int)$this->request->get('parent'), $this->url->link('category', false, array('parent' => '%s')));


		// Yalnızca İnternet Gazetesi kategorisine menü özelliğini sun.
		$parentCategories = array_reverse($this->model_category->parentCategories(($this->request->has('parent','get') ? (int)$this->request->get('parent') : 0)));
		if($parentCategories && $parentCategories[0]['id'] == (int)$this->config->get('post_parent_id')){

			$this->data['menu_status']			= ($this->request->has('menu_status', 'post') ? $this->request->post('menu_status') : (isset($category_info['menu_status']) ? $category_info['menu_status'] : 0));

		}

		if ($this->error) {

			$this->data['error'] = $this->error;
		}

		$this->template = 'category_form.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());

	}

  	private function validateForm () {

		$this->load->model('category');
		$this->load->model('location');

		if ( strlen(str_replace(' ', '', $this->request->post('slug'))) < 1 ) {

			$this->error = 'Geçerli bir SEO url giriniz.';

		} else {

			$this->load->library("slug");
			$slug		=	new Slug();

			if ( $this->request->get('method') == 'edit' ) {

				$query = $this->db->query("SELECT id FROM category WHERE slug = '".$this->db->escape($slug->title($this->request->post('slug')))."' AND id != '".(int)$this->request->get('id')."'");

			} else {

				$query = $this->db->query("SELECT id FROM category WHERE slug = '".$this->db->escape($slug->title($this->request->post('slug')))."'");

			}

			if ( $query->rows || $this->model_location->hasLocationSlug($slug->title($this->request->post('slug'))) ) {

				$this->error = 'SEO url diğer bir kategori için tanımlanmış. Lütfen farklı bi adres deneyiniz.';

			}

		}

		if (strlen($this->request->post('name')) < 1 || strlen($this->request->post('name')) > 100) {

			$this->error = 'Kategori adı 1 ile 100 karakter arasında olmalıdır.';

		}


		return (!$this->error ? true : false);

	}

}

?>
