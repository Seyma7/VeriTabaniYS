<?php

Class ModelPreserve extends Controller{

		protected $data = array();


		public function getPreserveList(){

			if( empty($this->data)  ){
				$query 	= $this->db->query("SELECT * FROM preserve WHERE status = 1 ORDER BY  sort_order ASC, id ASC");

				if ( $query->rows ) {

					foreach ( $query->rows as $value ) {
							$this->data[$value['id']]	=		array(
									'id' 						=> $value['id'],
									'name'	 				=> $value['name'],
									'code'	 				=> $value['code'],
									'description'	 	=> $value['description'],
									'selected'			=> 0 
							);
					}

				}
			}

			return 	$this->data;
		}

		public function hasPreserveID( $preserve_id = false ){

			if(empty($this->data))	$this->data 	=	$this->getPreserveList();
			if((int)$preserve_id && isset($this->data[(int)$preserve_id]) ) return true;
			return false;
		}


		public function getPreserveID ( $code = false ){

			if(empty($this->data))	$this->data 	=	$this->getPreserveList();

			if($code && !empty($this->data)){

				foreach ( $this->data as $row ) {

						if( $row['code'] == $code ) return $row['id'];

				}

			}

			return false;
		}

}

?>
