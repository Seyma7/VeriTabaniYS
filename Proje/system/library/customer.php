<?php
final class Customer {
	
	private $data = array();
	
  	public function __construct($registry) {
	
		$this->db 			= $registry->get('db'); //db classını $this->db  ye ata.
		$this->request 		= $registry->get('request'); //request classını $this->request e ata.
		$this->session 		= $registry->get('session'); //session classını $this->session a ata.
		$this->encryption 	= $registry->get('encryption'); //encryption classını $this->encryption a ata.
				
		if ($this->session->has('customer_id')) { // customer_id session olarak açıldı mı kontrol et.
			
			$query = $this->db->query("SELECT * FROM customer WHERE id = '".(int)$this->session->get('customer_id')."'"); //customer_id aciksa o idye ait tüm bilgileri al.
			
			if ($query->rows) {
			
				$this->data = $query->row;
				
			} else { 
			
				$this->logout(); // session acik değilse oturumdan çık
			
			}
  		}
	} 
	
	
  	public function login($username, $password) {
		
		$username = $this->db->escape($username); // sql injection ayikla
		$password = $this->db->escape($password); // sql injection ayikla
		
		$query = $this->db->query($sql = "SELECT * FROM customer WHERE (username = '{$username}' OR email = '{$username}') AND password = '{$password}' AND status = '1'");

		if ($query->rows) {
		
			$this->session->set('customer_id', $query->row['id']); 
			
			$this->db->query("UPDATE customer SET ip = '".@$_SERVER['REMOTE_ADDR']."' WHERE id = '".(int)$query->row['id']."'"); // idye ait kullanıcının girdiği pcdeki ip adresini dbde güncelle
				
			return true;
		
		} else{
		
			return false;
		
		}
  	}
  
  	public function logout() {  

		$this->session->delete('customer_id');	// oturumu kapat, session sil	 
		$this->data = array();  
  	}
  
  	public function isLogged() { //aktif ise id yi al
    	return $this->get('id');
  	}

  	public function get($val) {
    	return (isset($this->data[$val]) ? $this->data[$val] : false);
  	}

}
?>