<?php
Class Cart{

	var $data 			= array();
	var $type			= '';
	var $description	= '';
	var $total			= 0;
	var $items			= array();

	public function __construct($registry){
		$this->session 	= $registry->get('session');
		$this->load		= $registry->get('load');
		$this->config	= $registry->get('config');
		
		if(!$this->session->has('cart') || !is_array($this->session->get('cart'))){
			$this->session->set('cart_description', '');
			$this->session->set('cart_type', '');
			$this->session->set('cart_total', '');
			$this->session->set('cart', array());
		}
		
		$this->items 		= $this->session->get('cart');
/*		
		if($this->items){
		
			foreach($this->items as $key => $item){
			
				$this->items[$key]['name'] = urldecode($item['name']);
			
			}
		
		}
*/		
		$this->type 		= $this->session->get('cart_type');
		$this->description 	= urldecode($this->session->get('cart_description'));
		$this->total 		= $this->session->get('cart_total');
	}
	
	public function isEmpty(){
		return ($this->items ? false : true);
	}	
	
	public function getType(){
		return $this->type;
	}	
	
	public function isType($type = false){
		return ($this->type == $type ? true : false);
	}	
	
	public function getTotalCredit(){
		return count($this->items);
	}
	
	public function getTotalItems(){
		return count($this->items);
	}
	
	public function clear(){
		$this->description 	= '';
		$this->type 		= '';
		$this->items 		= array();
		$this->total 		= 0;
	}	
	
	public function setItem($song_id = 0, $album_id = 0, $name = '', $price = 0){
		
		$this->items[] = array(
			'song_id' 	=> $song_id ,
			'album_id'	=> $album_id ,
			'name'		=> str_replace('&', '', $name),
			'price'		=> $price 		
		);
		
	}
	
	public function save(){
		$this->session->set('cart', $this->items);
		$this->session->set('cart_type', $this->type);
		$this->session->set('cart_description', $this->description);
		$this->session->set('cart_total', $this->total);
	}	
}
?>