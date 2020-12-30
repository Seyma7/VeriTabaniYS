<?php

Class ModelCategory extends Controller{

	public function get_category_details ( $slug = false ) {

		$categories = new stdClass();

		$categories->parent 	= array();
		$categories->current 	= array();
		$categories->fields		= array();

		$query = $this->db->query("SELECT * FROM category WHERE slug = '" . $slug . "'");

		$category_data = array();

		if ( $query->rows ) {
			$category_data = $this->get_category($query->row['id']);
		}

		if ( $category_data ) {

			foreach ( $category_data as $category ) {

				$categories->fields[] = array(

					'id' 								=> $category['id'],
					'name'							=> $category['name'],
					'page_title'				=> $category['page_title'],
					//'meta_description'	=> $category['meta_description'],
					//'meta_keyword'			=> $category['meta_keyword'],
					'tag'								=> $category['slug'],
					'url'								=> $this->url->link('category', false, array('slug' => $category['slug'])),

				);

			}

			$categories->parent 	= end($categories->fields);
			$categories->current 	= reset($categories->fields);

			asort($categories->fields);

		}

		return $categories;

	}


	public function get_category ($id, $list = array(), $first_category = false) {

		$query = $this->db->query("SELECT * FROM category WHERE id = '" . $id . "'");

		if ( $query->rows ) {

			$list[] = $query->row;

			if ( $query->row['parent'] != 0 ) {

				$list = $this->get_category($query->row['parent'], $list, ($first_category ? $first_category : false) );

			}

			if($first_category && $query->row['parent'] == 0){
				return $query->row['slug'];
			}

		}

		return $list;

	}


	public function parentCategories ($id, $list = array()) {

		$query = $this->db->query("SELECT * FROM category WHERE id = '" . $id . "'");

		if ( $query->rows ) {

			$list[] = $query->row;

			if ( $query->row['parent'] != 0 ) {

				$list = $this->parentCategories($query->row['parent'], $list);

			}

		}

		return $list;
	}


}

?>
