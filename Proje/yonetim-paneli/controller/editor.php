<?php
Class ControllerEditor Extends Controller{

	private $error 				= false;
	private $post_info 		= array();

	public function index () {

		if(!$this->user->hasUserPerm($this->request->get('controller'), "view")){
			return $this->forward('error','denied');
		}

		$this->document->setTitle('Editörler');
		$this->data['description']	= "Editör ekleyebilir, varolanları düzeltip silebilirsiniz. Yeni bir editör hesabı eklemek için aşağıdaki <i>Ekle</i> butonunu tıklayınız.";

		$this->data['search_query'] = ($this->request->has('search_query') ? urldecode($this->request->get('search_query')) : $this->request->post('search_query'));


		$page 	= (!$this->request->has('page') || (int)$this->request->get('page') < 1 ? 1 : (int)$this->request->get('page'));
		$limit 	= 20;
		$start	= ($page - 1) * $limit;


		$sql 	=
						"
							SELECT u.*
							FROM user u
							WHERE u.status NOT IN (6)
										AND u.type NOT IN (1,2,3)
										AND user_id != '".(int)$this->user->getId()."'
						 ";


		if ( $this->request->has('search_query') ) {

			$sql .= " AND LCASE(u.username) LIKE '%".$this->db->escape(mb_strtolower(urldecode($this->request->get('search_query')), 'UTF-8'))."%' ";
		}


		switch ($this->request->get('sort')) {
			case 'username':
				$sql .= ' ORDER BY u.username ' . (strtoupper($this->request->get('type')) == 'ASC' ? 'ASC' : 'DESC');
				break;
			case 'status':
				$sql .= ' ORDER BY u.status ' . (strtoupper($this->request->get('type')) == 'ASC' ? 'ASC' : 'DESC');
				break;
			default:
				$sql .= ' ORDER BY u.user_id ';
				break;
		}


		$total 	= $this->db->query($sql);

		$link  = array('username','status');
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
					))
				)
			);

		}

		$this->data['link'] = $links;

		$query 	= $this->db->query($sql . " LIMIT {$start}, {$limit}");

		$this->data['posts'] = array();

		if ( $query->rows ) {

			foreach ( $query->rows as $row ) {

				$this->data['posts'][] = array(

					'id'						=> $row['user_id'],
					'username'			=> $row['username'],
					'status'				=> $row['status'],
					'last_ip'				=> $row['last_ip'],
					'edit'					=> $this->url->link($this->request->get('controller'), 'edit', array('id' => $row['user_id'])),
				);
			}
		}

		$this->data['insert'] 				= $this->url->link($this->request->get('controller'), 'insert');
		$this->data['action'] 				= $this->url->link($this->request->get('controller'), 'delete');
		$this->data['search_action']	= $this->request->get('controller');

		$url = $this->url->link($this->request->get('controller'), false, array('sort' => $this->request->get('sort'), 'type' => $this->request->get('type'), 'page' => '{page}'));

		$pagination 								= new Pagination();
		$pagination->total 					= $total->num_rows;
		$pagination->page 					= $page;
		$pagination->limit 					= $limit;
		$pagination->url 						= $url;
		$this->data['pagination'] 	= $pagination->render();

		if ($this->error) {

			$this->data['error'] = $this->error;
		}

		$this->template = 'editor.html';
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

		$this->document->setTitle('Editörler Düzenle');

		$query = $this->db->query("

					SELECT u.user_id, u.username, u.status, u.password
					FROM user u
					WHERE u.status NOT IN (6)
								AND u.type NOT IN (1,2)
								AND u.user_id = '".(int)$this->request->get('id')."' AND user_id != '".(int)$this->user->getId()."'
		");

		if ($query->rows) {

			$this->post_info 	=	$query->row;

			$queryPerm = $this->db->query("SELECT * FROM user_perm WHERE user_id = '".(int)$this->request->get('id')."' ");
			if ($queryPerm->rows) {

				foreach($queryPerm->rows as $row){

					$this->post_info['user_perm'][] = array(
						"id"		=>	$row['perm_id'],
						"perms" =>  array(
									"v"   =>  (int)$row['p_view'],
									"i"   =>  (int)$row['p_insert'],
									"e"   =>  (int)$row['p_edit'],
									"d"   =>  (int)$row['p_delete'],
								)
					);

				}
			}

		} else {

			$this->redirect($this->url->link($this->request->get('controller')));

		}


		if ($this->request->isPOST() && $this->validateForm()) {

			$user_id 			=	(int)$this->request->get('id');

			//username 				= '".$this->db->escape(trim($this->request->post('username')))."',
			//password 				= '".$this->encryption->encrypt($this->request->post('password'))."',
		 	$this->db->query(
				"
				UPDATE user SET
				status					= '".(int)$this->request->post('status')."'
				WHERE  	user_id	= '".$user_id."'
				"
			);

			// PERMISSIONS
			if( $this->request->has('user_perm', 'post') ){

				$this->db->query(" DELETE FROM user_perm WHERE user_id = '".(int)$user_id."' ");
				$user_perm 			= 	$this->permList($this->request->post('user_perm'));

				foreach( $user_perm as $up ){

					if( isset($up['perms']) ){

						$this->db->query(

							"
							INSERT INTO user_perm SET
							perm_id					=	'".(int)$up['id']."',
							user_id					=	'".(int)$user_id."',
							p_view					=	'".(isset($up['perms']['v']) ? $up['perms']['v'] : '')."',
							p_insert				=	'".(isset($up['perms']['i']) ? $up['perms']['i'] : '')."',
							p_edit					=	'".(isset($up['perms']['e']) ? $up['perms']['e'] : '')."',
							p_delete				=	'".(isset($up['perms']['d']) ? $up['perms']['d'] : '')."'
							"
						);

					}

				}

			}


			$this->session->set('success', ' Editör hesabı başarıyla güncellendi.');


			if ( $this->request->post('stayOnPage') == 'new' ) {

				$redirect_url = $this->url->link($this->request->get('controller'), 'insert');

			} else if ( $this->request->post('stayOnPage') == 'edit' ) {

				$redirect_url = $this->url->link($this->request->get('controller'), 'edit', array('id' => (int)$user_id));

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


		$this->document->setTitle('Editör Ekle');

		if ($this->request->isPOST() && $this->validateForm()) {


		 	$this->db->query(

				"
				INSERT INTO user SET
				username 				= '".$this->db->escape(trim($this->request->post('username')))."',
				password 				= '".$this->encryption->encrypt($this->request->post('password'))."',
				status					= '".(int)$this->request->post('status')."'
				"
			);

			$user_id 			=		$this->db->getLastId();

			// PERMISSIONS
			if( $this->request->has('user_perm', 'post') ){

				$this->db->query(" DELETE FROM user_perm WHERE user_id = '".(int)$user_id."' ");
				$user_perm 			= 	$this->permList($this->request->post('user_perm'));

				foreach( $user_perm as $up ){

					if( isset($up['perms']) ){

						$this->db->query(

							"
							INSERT INTO user_perm SET
							perm_id					=	'".(int)$up['id']."',
							user_id					=	'".(int)$user_id."',
							p_view					=	'".(isset($up['perms']['v']) ? $up['perms']['v'] : '')."',
							p_insert				=	'".(isset($up['perms']['i']) ? $up['perms']['i'] : '')."',
							p_edit					=	'".(isset($up['perms']['e']) ? $up['perms']['e'] : '')."',
							p_delete				=	'".(isset($up['perms']['d']) ? $up['perms']['d'] : '')."'
							"
						);

					}

				}

			}


			$this->session->set('success', ' Editör hesabı başarıyla eklendi.');

			if ( $this->request->post('stayOnPage') == 'new' ) {

				$redirect_url = $this->url->link($this->request->get('controller'), 'insert');

			} else if ( $this->request->post('stayOnPage') == 'edit' ) {

				$redirect_url = $this->url->link($this->request->get('controller'), 'edit', array('id' => (int)$user_id));

			} else {

				$redirect_url = $this->url->link($this->request->get('controller'));

			}

			$this->redirect($redirect_url);
		}

		$this->data['cancel'] = $this->url->link($this->request->get('controller'));
		$this->data['action'] = $this->url->link($this->request->get('controller'), 'insert');

		return $this->form();
	}


	public function form () {

		$this->data['username'] 				= $this->db->escapeText($this->request->has('username', 'post') ? trim($this->request->post('username')) : (isset($this->post_info['username']) ? $this->post_info['username'] : ""));
		$this->data['password'] 				= $this->db->escapeText($this->request->has('password', 'post') ? $this->request->post('password') : (isset($this->post_info['password']) ? $this->encryption->decrypt($this->post_info['password']) : ""));
	 	$this->data['status'] 					= ($this->request->has('status', 'post') ? $this->request->post('status') : (isset($this->post_info['status']) ? $this->post_info['status'] : 1));
		$this->data['user_perm']				= ($this->request->has('user_perm', 'post') ? $this->permList($this->request->post('user_perm')) : (isset($this->post_info['user_perm']) ? $this->permList($this->post_info['user_perm']) : $this->permList()));

		$this->data['statuses'][]				= array('id' => 1, 'name' => 'Aktif');
		$this->data['statuses'][]				= array('id' => 2, 'name' => 'Pasif');

		$this->data['method'] 					=	$this->request->get('method');

		if ($this->error) {

			$this->data['error'] = $this->error;
		}

		$this->template = 'editor_form.html';
		$this->children = array(
			'header',
			'footer'
		);

		$this->response->set($this->render());
	}


	private function permList($user_perm = false){

		$perm_list 		= array();

		$query 				= $this->db->query("SELECT * FROM perms ORDER BY sort_order ASC, id ASC "); 
		if ($query->rows) {

				foreach($query->rows as $row){

						$perm 	=  array(
							"id"		=>	$row['id'],
							"name"	=>	$row['name'],
							"code"	=>	$row['code'],
							"perms" =>  array(
										"v"   =>  0,
										"i"   =>  0,
										"e"   =>  0,
										"d"   =>  0,
									)
						);

						if($user_perm){
							foreach($user_perm as $up){

								if( isset($up['perms']) ){

									foreach($up['perms'] as $k => $v){

										if(isset($perm['perms'][$k]) && $v && $up['id'] == $row['id']){

											$perm['perms'][$k] = $v;
										}
									}

								}

							}
						}

						$perm_list[]  = $perm;
				}
		}

		return $perm_list;
	}

	private function validateForm () {


		if ( !in_array($this->request->post('status'), array(1, 2)) ) {

			$this->error = 'Hesap durumu girilmelidir.';
		}

		if($this->request->get('method') == "insert"){

				if(!$this->request->post('password')){

						$this->error = "Parola alanını boş bırakamazsınız.";

				}else if(strlen($this->request->post('password')) < 6 || strlen($this->request->post('password')) > 20){

						$this->error = "Parola 6 ile 20 karakter arasında olmalıdır.";
				}

				if (strlen($this->request->post('username')) < 5 || strlen($this->request->post('username')) > 30) {

					$this->error = 'Kullanıcı adı 5 ile 30 karakter arasında olmalıdır.';

				}else{

					$sql = " SELECT * FROM user WHERE username = '".$this->db->escape(trim($this->request->post('username')))."' ";

					if($this->request->get('method') == "edit"){
							$sql .= " AND user_id != '".(int)$this->request->get('id')."' ";
					}

					$query = $this->db->query($sql);

					if ( $query->rows ) {

						$this->error = 'Kullanıcı adına ait bir kayıt bulunmaktadır.';

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
				$this->db->query("DELETE FROM user WHERE user_id = '".(int)$id."'");
			}

			$this->session->set("success", "Editör(ler) başarıyla silindi.");


		}else if((int)$this->request->get('id')){

			$id 	= (int)$this->request->get('id');
			$this->db->query("DELETE FROM user WHERE user_id = '".(int)$id."'");
			$this->session->set("success", "Editör(ler) başarıyla silindi.");
		}

		$this->redirect($this->url->link($this->request->get('controller')));

	 }




}
?>
