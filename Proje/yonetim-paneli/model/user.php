<?php
Class ModelUser extends Controller {
	
	public function setSmtpServer ($user_id, $server, $username, $password, $port = 25) {
	
		$query = $this->db->query("SELECT * FROM user_smtp WHERE user_id = '".(int)$user_id."'");
		
		if ($query->rows) {
		
			$this->db->query("UPDATE user_smtp SET server = '".$this->db->escape($server)."', username = '".$this->db->escape($username)."', password = '".$this->db->escape($password)."', port = '".(int)$port."' WHERE user_id = '".(int)$user_id."'");
		
		} else {
		
			$this->db->query("INSERT INTO user_smtp SET user_id = '".(int)$user_id."', server = '".$this->db->escape($server)."', username = '".$this->db->escape($username)."', password = '".$this->db->escape($password)."', port = '".(int)$port."'");
		
		}
		
	}
	
	public function removeSmtpServer ($user_id) {
	
		$this->db->query("DELETE FROM user_smtp WHERE user_id = '".(int)$user_id."'");
		
	}
	
}
?>