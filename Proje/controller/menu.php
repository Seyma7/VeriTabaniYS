<?php

Class ModuleMenu extends Controller {

	protected function fetch() {

		$this->load->model('location');

		$menu_category = $this->cache->get('menu_category');

		if (!$menu_category) {

			$menu_category = array();

			$menu_category[] = array(

				'name' 					=> 'ANASAYFA',
				'nameCapit' 		=> 'Anasayfa',
				'slug' 					=> '',
				'special_menu'	=> 1,
				'active' 				=> 0,
				'url'						=> $this->url->link('home'),
				'data'					=> false
			);

			$location_list 		=	$this->model_location->getLocationList();

			if($location_list){

					foreach($location_list as $row){
						$menu_category[] = array(

							'name' 					=> $row['name'],
							'nameCapit' 		=> mb_convert_case($row['name'], MB_CASE_TITLE, "UTF-8"),
							'slug' 					=> $row['slug'],
							'special_menu'	=> 0,
							'active' 				=> 0,
							'url'						=> $this->url->link( 'location',false,array( 'slug' => $row['slug'] ) ),
							'data'					=> false
						);
					}
			}

			$query = $this->db->query("SELECT * FROM category WHERE menu_status = '1' ORDER BY sort_order ASC");
			if ( $query->rows ) {

				foreach ( $query->rows as $row ) {

					$category_data = array();

					$category_query = $this->db->query("SELECT * FROM category WHERE parent = '".(int)$row['id']."' ORDER BY sort_order ASC LIMIT 6");

					if ( $category_query->rows ) {

						foreach ( $category_query->rows as $category_row ) {

							$category_data[] = array(

								'name' 					=> $category_row['name'],
								'nameCapit' 		=> mb_convert_case($category_row['name'], MB_CASE_TITLE, "UTF-8"),
								'slug' 					=> $category_row['slug'],
								'url'						=> $this->url->link('category', false, array('slug' => $category_row['slug']))

							);

						}

					}

					$menu_category[] = array(

						'name' 					=> $row['name'],
						'nameCapit' 		=> mb_convert_case($row['name'], MB_CASE_TITLE, "UTF-8"),
						'slug' 					=> $row['slug'],
						'active' 				=> 0,
						'url'						=> $this->url->link('category', false, array('slug' => $row['slug'])),
						'data'					=> $category_data

					);

				}

				$this->cache->set('menu_category', $menu_category);

			}

		}

		$this->data['menu_slug'] 				= ($this->request->has('slug','get') ? $this->request->get('slug') : ($this->request->has('category','get') ? $this->request->get('category') : false));
		$this->data['menu_category']		= $menu_category;
		$this->data['search_url']				= $this->url->link('search');


		$this->template = 'menu.html';

		$this->render();
	}
}
?>
