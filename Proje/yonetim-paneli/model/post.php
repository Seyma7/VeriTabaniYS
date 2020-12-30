<?php
Class ModelPost extends Controller {

	// ADD CODES
	public function addPostImage ( $post_id, $image, $preview = 2, $sort_order = 0, $image_description = false  ) {

		$this->db->query("
							INSERT INTO post_image
							SET post_id 				= '".(int)$post_id."',
							image 							= '".$this->db->escape($image)."',
							preview 						= '".(int)$preview."',
							sort_order 					= '".(int)$sort_order."',
							image_description 	= '".$image_description."'
						");

	}
	// CLEAR CODES
	public function clearPost ( $post_id = false ) {
		$this->db->query("DELETE FROM post WHERE id = '".(int)$post_id."'");
	}
	public function clearPostCategory ( $post_id ) {
		$this->db->query("DELETE FROM post_category WHERE post_id = '".(int)$post_id."'");
	}
	public function clearPostImages ( $post_id ) {
		$this->db->query("DELETE FROM post_image WHERE post_id = '".(int)$post_id."'");
	}
	public function clearPostRadio ( $post_id ) {
		$this->db->query("DELETE FROM post_radio WHERE post_id = '".(int)$post_id."'");
	}
	public function clearPostVideo ( $post_id ) {
		$this->db->query("DELETE FROM post_video WHERE post_id = '".(int)$post_id."'");
	}
	public function clearPostTv ( $post_id ) {
		$this->db->query("DELETE FROM post_tv WHERE post_id = '".(int)$post_id."'");
	}
	public function clearPostView ( $post_id ) {
		$this->db->query("DELETE FROM post_view WHERE post_id = '".(int)$post_id."'");
	}
	public function clearPostRatio ( $post_id ) {
		$this->db->query("DELETE FROM post_ratio WHERE post_id = '".(int)$post_id."'");
	}
	public function clearPostLocation ( $post_id ) {
		$this->db->query("DELETE FROM post_location WHERE post_id = '".(int)$post_id."'");
	}
	public function clearPostPreserve ( $post_id ) {
		$this->db->query("DELETE FROM post_preserve WHERE post_id = '".(int)$post_id."'");
	}



	// GET CODES
	public function getPostImages ( $post_id = false ) {

		$query = $this->db->query("
		SELECT * FROM post_image
		WHERE post_id = '".(int)$post_id."'
		ORDER BY preview,
		sort_order ASC");

		$data = array();

		if ( $query->rows ) {

			$data = $query->rows;

		}

		return $data;
	}

}
?>
