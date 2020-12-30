<?php
Class ModelCategory extends Controller {

	public function getCategories ( $parent_id ) {

		$category_data = false;//$this->cache->get('category.' . $parent_id);

		if (!$category_data) {

			$category_data = array();

			$query = $this->db->query("SELECT * FROM category WHERE parent = '" . (int)$parent_id . "' ORDER BY sort_order, name ASC");

			foreach ( $query->rows as $row ) {

				$category_data[] = array(

					'id' 		  		=> $row['id'],
					'name'        => $this->getPath($row['id']),
					'status'  	  => $row['status'],
					'parent'  	  => $row['parent'],
					'sort_order'  => $row['sort_order']

				);

				$category_data = array_merge($category_data, $this->getCategories($row['id']));

			}

			//$this->cache->set('category.' . $parent_id, $category_data);

		}

		return $category_data;

	}


	public function updateCategoryPath ( $parent_id ) {

		$query = $this->db->query("SELECT * FROM category WHERE parent = '" . (int)$parent_id . "' ORDER BY sort_order, name ASC");

		foreach ( $query->rows as $row ) {

			$this->db->query("UPDATE category_mirror SET path = '".$this->db->escape($this->getPath($row['id']))."' WHERE id = '".(int)$row['id']."'");

			$this->updateCategoryPath($row['id']);

		}

	}


	public function getCategoriesFromPath () {
		
		$query = $this->db->query("SELECT cm.id, cm.path FROM category_mirror cm LEFT JOIN category c ON cm.id = c.id ORDER BY cm.path ASC");

		$category_data = array();

		if ( $query->rows ) {

			$category_data	= $query->rows;

		}

		return $category_data;

	}


	public function getPath ( $category_id = 0, $url = false, $imp = true ) {

		$query = $this->db->query("SELECT id, name, parent FROM category WHERE id = '" . (int)$category_id . "' ORDER BY sort_order, name ASC");

		if ( !$query->rows ) return;

		$name = ($url ? "<a href='".vsprintf($url, $query->row['id'])."'>".$query->row['name']."</a>" : $query->row['name']);

		if ($query->row['parent']) {

			if($imp){
				return $this->getPath($query->row['parent'], $url) . ' &#187; ' . $name;
			}

			if(!$imp){
				return $this->getPath($query->row['parent'], $url) . ', ' . $name;
			}

		} else {

			return $name;

		}
	}



	public function parentCategories ($id, $list = array()) {

		$query = $this->db->query("SELECT id, name, parent FROM category WHERE id = '" . $id . "'");

		if ( $query->rows ) {

			$list[] = $query->row;

			if ( $query->row['parent'] != 0 ) {

				$list = $this->parentCategories($query->row['parent'], $list);

			}

		}

		return $list;
	}


	public function subCategories ($id, $list = array()) {

		$query = $this->db->query("SELECT * FROM category WHERE parent = '" . $id . "'");

		if ( $query->rows ) {

			foreach($query->rows as $row){

				$list[]			=	array(
					"id"		=>	$row["id"],
					"parent"	=>	$row["parent"],
					"name"		=>	$row["name"],
				);
				$list 		= 	$this->subCategories($row["id"], $list);
			}

		}

		return $list;
	}



	public function get_sub_categories ($parent, $parent_id = false) {

		$data		 = array();

		if ( (int)$parent_id ) {

			$query = $this->db->query("SELECT id, name, parent FROM category WHERE id = '".(int)$parent_id."' AND status = '1' ");

			if ( $query->row ) {
				$data[] 	= array(
					'id' 		=> $query->row['id'],
					'name'		=> $query->row['name'],
					'parent'	=> $query->row['parent'],
				);
				return $data;
			}
		}


		$query = $this->db->query("SELECT id, name, parent FROM category WHERE parent = '".(int)$parent."' AND status = '1' ORDER BY sort_order ASC, name ASC");

		if ( $query->rows ) {

			$data = array();

			foreach ( $query->rows as $row ) {

				$data[] = array(

					'id' 		=> $row['id'],
					'name'		=> $row['name'],
					'parent'	=> $row['parent'],
				);

			}

			return $data;
		}

		return false;
	}




		// CLEAR CODES
		public function clearCategory ( $category_id = false ) {
			$this->db->query("DELETE FROM category WHERE id = '".(int)$category_id."'");
		}

		public function clearCategoryMirror ( $category_id ) {
			$this->db->query("DELETE FROM category_mirror WHERE id = '".(int)$category_id."'");
		}

}
?>
