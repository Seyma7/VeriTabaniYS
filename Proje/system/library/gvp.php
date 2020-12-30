<?php
Class GVP{
	/*
	var $okUrl;
	var $failUrl;
	
	function fields($amount = 0, $order_id = ''){
		$clientId 	= "91720101";
		$amount 	= $amount;
		$oid 		= $order_id;		
		$okUrl   	= $this->okUrl; 
	    $failUrl 	= $this->failUrl; 
		$rnd 		= microtime();
		$storekey 	= "72F3421Ak1084";           
		$storetype 	= "3d";
		$hashstr 	= $clientId . $oid . $amount . $okUrl . $failUrl . $rnd  . $storekey;
		$hash 		= base64_encode(pack('H*',sha1($hashstr)));
		
		$fields = array(
			"clientid"	=>	$clientId, 
			"amount"	=>	$amount, 
			"oid"		=>	$oid, 
			"okUrl"		=>	$okUrl, 
			"failUrl"	=>	$failUrl,
			"rnd"		=>	$rnd, 
			"hash"		=>	$hash, 
			"storetype"	=>	"3d", 
			"lang"		=>	"tr"
		);
		return $fields;
	}
	*/
	
	protected $mode 			= 'PROD';
	protected $api_version 		= 'v0.01';
	public $security_level		= '';
	public $type				= 'sales';
	public $currenyc_code		= 949;
	public $prov_user_id		= '';
	public $terminal_user_id	= '';
	public $amount				= 0;
	public $installment			= '';
	public $order_id			= '';
	public $customer_ip			= '';
	public $customer_email		= '';
	public $terminal_id			= '';
	public $terminal_id_		= '';
	public $merchant_id			= '';
	public $key					= '';
	public $provision_password	= '';
	public $success_url			= '';
	public $error_url			= '';
	public $action_url			= 'https://sanalposprov.garanti.com.tr/servlet/gt3dengine';
	public $prov_url			= 'https://sanalposprov.garanti.com.tr/VPServlet';
	public $error_code			= '';
	public $error_str			= '';
	public $data				= array();
	
	public function GVP(){
		$this->set_security_level('3D_FULL');
		$this->set_prov_user('PROVAUT');
		$this->set_terminal_user('PROVAUT');
		$this->set_amount(1, true);
		$this->set_order_id(rand());
		$this->set_customer_ip(@$_SERVER['REMOTE_ADDR']);
	}

	
	public function months(){
		$month 		= array();
		
		$montheng	= array('January','February','March','April','May','June','July','August','September','October','November','December');
		$monthtr	= array('Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık');
			
		
		for($i = 1; $i <= 12; $i++){
			$name = ($i < 10 ? "0$i" : $i);
			
			$month[] = array(
				'name' 	=> $name . ' ' . str_replace($montheng,$monthtr,date("F", mktime(0, 0, 0, 1 + $i, 0, 0))),
				'value'	=> $name		
			);
		}
		return $month;
	}	
	
	public function years(){  
		$year = array(); 
		for($i = date('Y'); $i <= date('Y', strtotime(date('Y') . ' + 20 years')); $i++){
			array_push($year, $i);
		}
		return $year;
	}
	
	
	public function set_security_level($security_level){
		$this->security_level = $security_level;
	}
	
	public function get_security_level(){
		return $this->security_level;
	}
	
	public function set_prov_user($user){
		$this->prov_user_id = $user;
	}
	
	public function get_prov_user(){
		return $this->prov_user_id;
	}	
	
	public function set_terminal_user($user){
		$this->terminal_user_id = $user;
	}
	
	public function get_terminal_user(){
		return $this->terminal_user_id;
	}

	public function set_amount($amount, $decimal = false){
		$this->amount = ($decimal ? $amount * 100 : $amount);
	}
	
	public function get_amount(){
		return $this->amount;
	}

	public function set_installment($installment){
		$this->installment = $installment;
	}
	
	public function get_installment(){
		return $this->installment;
	}
	
	public function set_order_id($order_id){
		$this->order_id = $order_id;
	}
	
	public function get_order_id(){
		return $this->order_id;
	}	
	
	public function set_customer_ip($customer_ip){
		$this->customer_ip = $customer_ip;
	}
	
	public function get_customer_ip(){
		return $this->customer_ip;
	}	
	
	public function set_customer_email($customer_email){
		$this->customer_email = $customer_email;
	}
	
	public function get_customer_email(){
		return $this->customer_email;
	}

	public function set_terminal_id($terminal_id){
		$this->terminal_id = $terminal_id;
		$this->set_terminal_id_($terminal_id);
	}
	
	public function get_terminal_id(){
		return $this->terminal_id;
	}	

	public function set_terminal_id_($terminal_id){
		$strlen = strlen($terminal_id);
		if($strlen < 9){
			for($i = $strlen; $i < 9; $i++){
				$terminal_id = '0' . $terminal_id;
			}
		}
		$this->terminal_id_ = $terminal_id;
	}	
	
	public function get_terminal_id_(){
		return $this->terminal_id_;
	}

	public function set_merchant_id($merchant_id){
		$this->merchant_id = $merchant_id;
	}
	
	public function get_merchant_id(){
		return $this->merchant_id;
	}	

	public function set_key($key){
		$this->key = $key;
	}
	
	public function get_key(){
		return $this->key;
	}

	public function set_provision_password($provision_password){
		$this->provision_password = $provision_password;
	}
	
	public function get_provision_password(){
		return $this->provision_password;
	}	
	
	public function set_success_url($success_url){
		$this->success_url = $success_url;
	}
	
	public function get_success_url(){
		return $this->success_url;
	}	
	
	public function set_error_url($error_url){
		$this->error_url = $error_url;
	}
	
	public function get_error_url(){
		return $this->error_url;
	}

	public function set_action_url($action_url){
		$this->action_url = $action_url;
	}
	
	public function get_action_url(){
		return $this->action_url;
	}	

	public function set_prov_url($prov_url){
		$this->prov_url = $prov_url;
	}
	
	public function get_prov_url(){
		return $this->prov_url;
	}

	public function get_variables(){
		return array(
			'apiversion'			=> $this->api_version,
			'secure3dsecuritylevel'	=> $this->get_security_level(),
			'mode'					=> $this->mode,
			'terminalprovuserid'	=> $this->get_prov_user(),
			'terminaluserid'		=> $this->get_terminal_user(),
			'terminalmerchantid'	=> $this->get_merchant_id(),
			'txntype'				=> $this->type,
			'txnamount'				=> $this->get_amount(),
			'txncurrencycode'		=> $this->currenyc_code,
			'txninstallmentcount'	=> $this->installment,
			'orderid'				=> $this->get_order_id(),
			'terminalid'			=> $this->get_terminal_id(),
			'successurl'			=> $this->get_success_url(),
			'errorurl'				=> $this->get_error_url(),
			'customeremailaddress'	=> $this->customer_email,
			'customeripaddress'		=> $this->customer_ip,
			'secure3dhash'			=> $this->hash()
		);		
	}
	
	private function hash(){
		return strtoupper(
			sha1(
				$this->get_terminal_id() .
				$this->get_order_id() .
				$this->get_amount() .
				$this->get_success_url() .
				$this->get_error_url() .
				$this->type .
				$this->installment .
				$this->get_key() .
				strtoupper(
					sha1(
						$this->get_provision_password() .
						$this->get_terminal_id_()
					)
				)
			)
		);
	}
	
	public function set_error_code($error_code){
		$this->error_code = $error_code;
	}
	
	public function get_error_code(){
		return $this->error_code;
	}	

	public function set_error_str($error_str){
		$this->error_str = $error_str;
	}
	
	public function get_error_str(){
		return $this->error_str;
	}		
	
	public function process($root = false){
		if($root){
			if(ROOT_MODE) return true;
		}
		$confirm = false;
		if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){
			  
			switch($_POST['mdstatus']){
				case 0: 
					$this->set_error_str('Kart sahibi doğrulaması yapılamadı.');
					break;				
				case 1:
					switch($_POST['response']){
						case 'Approved':
							$confirm = true;
							break;
						case 'Declined':
						default:
							if($_POST['procreturncode'] == 51){
								$this->set_error_str('Hesabınızın bakiyesi yeterli değil.');
							}
							else{
								$this->set_error_str($_POST['hostmsg']);
							}
							break;
					}
					break;
				case 2:
					$this->set_error_str('Kart sahibi veya bankası sisteme kayıtlı değil');
					break;
				case 3:
					$this->set_error_str('Kartın bankası sisteme kayıtlı değil');
					break;
				case 4:
					$this->set_error_str('Doğrulama denemesi, kart sahibi sisteme daha sonra kayır olmayı seçmiş');
					break;
				case 5:
					$this->set_error_str('Doğrulama yapılamıyor');
					break;
				case 6:
					$this->set_error_str('3-D Secure Hatası');
					break;
				case 7:
					switch($_POST['mderrormessage']){
						case 'Invalid input data: Digest checking failed':
							$this->set_error_str('Hatalı tutar. Lütfen sistem yöneticisine başvurunuz.');
							break;
						case 'PAN yok veya isyeri odeme sayfasi degil':
						default:
							$this->set_error_str('Kart bilgileri hatalı yada banka onay vermiyor.');
							//$this->set_error_str($_POST['mderrormessage']); 
							break;
					}
					break;
				case 8:
					$this->set_error_str('Bilinmeyen kart no');
					break;
			}
		}
		return ($confirm ? true : false);
	}
	 

	 
}
?>