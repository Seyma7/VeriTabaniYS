<?php

Class ModelLocation extends Controller{

		protected $data = array();


		public function getLocationList(){

			if( empty($this->data)  ){
				$query 	= $this->db->query("SELECT l.id, l.name, l.slug FROM location l ORDER BY l.sort_order ASC, l.name ASC");

				if ( $query->rows ) {

					foreach ( $query->rows as $value ) {
							$this->data[$value['id']]	=		array(
									'id' 			=> $value['id'],
									'name'	 	=> $value['name'],
									'slug'	 	=> $value['slug']
							);
					}

				}
			}

			return 	$this->data;
		}


		public function hasLocationSlug( $location_slug = false ){

			if(empty($this->data))	$this->data 	=	$this->getLocationList();

			if($location_slug && !empty($this->data)){

				foreach ( $this->data as $row ) {

						if( $row['slug'] == $location_slug) return true;

				}

			}

			return false;
		}


		public function hasLocationID( $location_id = false ){

			if(empty($this->data))	$this->data 	=	$this->getLocationList();
			if((int)$location_id && isset($this->data[(int)$location_id]) ) return true;
			return false;
		}



		public function getLocationID ( $location_slug = false ){

			if(empty($this->data))	$this->data 	=	$this->getLocationList();

			if($location_slug && !empty($this->data)){

				foreach ( $this->data as $row ) {

						if( $row['slug'] == $location_slug) return $row['id'];

				}

			}

			return false;  
		}
}

?>
