<?php
final class User {
		var $data       = array();
  	var $permission = array();
  	var $expire 		= 0; // Kullanıcının oturum zaman sınırı

  	function __construct($registry) {

				$this->db 			= $registry->get('db');  // db veritabanı baglantı kodunu çeker
				$this->request  = $registry->get('request');
				$this->session  = $registry->get('session');
				$this->tools  	= $registry->get('tools');
				$this->expire		=	( (int)$this->expire ? $this->expire : $this->session->expire );

	    	if ($this->session->has('user_id')) {

						$query = $this->db->query("SELECT * FROM user WHERE user_id = '" . (int)$this->session->get('user_id') . "' AND status = 1 ");

						if ($query->rows) {

								$this->data 			= 	$query->row;
								$this->permission =		$this->getUserPerm();

						} else {

								$this->logout();

						}
	    	}
  	}

  	public function login($username, $password) {

		$query = $this->db->query("SELECT * FROM user WHERE username = '".$this->db->escape($username)."' AND password = '".$this->db->escape($password)."' AND status = 1 ");

    	if ( $query->rows ) {

		  		$this->session->set('user_id', $query->row['user_id']);
					$this->session->set('login_time', time());
		  		$this->db->query("UPDATE user SET last_ip = '".$this->tools->getIP()."' WHERE user_id = '".(int)$query->row['user_id']."'");
      		$this->data 			= 	$query->row;
					$this->permission =		$this->getUserPerm();
      		return TRUE;

    	} else {
      		return FALSE;
    	}
  	}


  	public function logout() {
				$this->session->delete('user_id');
				$this->session->delete('login_time');
				$this->data 			= array();
				$this->permission = array();
  	}


  	public function isLogged() {

			if( isset($this->data['user_id'])  &&  ( time() - $this->session->get('login_time') <= $this->expire ) ) {
					$this->session->set('login_time', time());
					return true;
			}

			$this->session->delete('user_id');
			$this->session->delete('login_time');
			$this->data 			= array();
			$this->permission = array();
    	return false;
  	}

  	public function getId() {
    	return (isset($this->data['user_id']) ? $this->data['user_id'] : NULL);
  	}


  	public function getUserName() {
    	return (isset($this->data['username']) ? $this->data['username'] : NULL);
  	}

		private function getUserPerm(){

			$queryPerm = $this->db->query("SELECT u.*, p.code, p.name FROM user_perm u LEFT JOIN perms p ON p.id = u.perm_id WHERE u.user_id = '".(int)$this->data['user_id']."' ");
			if ($queryPerm->rows) {

				foreach($queryPerm->rows as $row){
					$perm[$row['code']] 		=		array();

					((int)$row['p_view'] ? $perm[$row['code']][] = "view" : false);
					((int)$row['p_insert'] ? $perm[$row['code']][] = "insert" : false);
					((int)$row['p_edit'] ? $perm[$row['code']][] = "edit" : false);
					((int)$row['p_delete'] ? $perm[$row['code']][] = "delete" : false);

				}

				return $perm;
			}
		}

		public function hasUserPerm($key, $value) {

    	if($this->data['type'] == 0){ // editör hesaplarının kontrolü
				if (isset($this->permission[$key])) {
			  		return in_array($value, $this->permission[$key]);
				} else {
			  		return false;
				}
			}else{
				return true;
			}

  	}


		public function hasPermission($key, $value) {
    	if (isset($this->permission[$key])) {
		  		return in_array($value, $this->permission[$key]);
			} else {
		  		return false;
			}
  	}
}
?>
