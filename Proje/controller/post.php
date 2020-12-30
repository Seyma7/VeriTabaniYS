<?php

Class ControllerPost Extends Controller {

	public $error 	= array();
	public $data		= array();

	public function index() {

		$this->load->model('category');
		$this->load->model('post');
		$this->load->model('image');

		$category = $this->model_category->get_category_details($this->request->get('category'));

		if ( !$category->current ) {

			return $this->forward('error');
		}

		$post 	= 	$this->model_post->getPost((int)$this->request->get('post_id'), (int)$this->config->get('post_parent_id'));

		if ( !$post ||  $post['category_id'] != $category->current['id'] || $post['slug'] != $this->request->get('post_slug')) {

			return $this->forward('error');

		} 

		$this->document->setTitle($this->db->escapeText($post['name']));
		//$this->document->setKeywords($this->db->escapeText($category->current['meta_keyword']));
		$this->document->setDescription($this->db->escapeText($post['name']));

		$post_view 	= 	$this->model_post->addPostRatio((int)$post['id'], 'view');



		$this->data['post_id'] 								= $post['id'];
		$this->data['post_title'] 						= $this->db->escapeText($post['name']);
		$this->data['post_description'] 			= $this->model_post->mobileElementsFix($post['description']);
		$this->data['post_like'] 							= (int)$post['post_like'];
		$this->data['post_dislike'] 					= (int)$post['post_dislike'];
		$this->data['post_view'] 							= ( (int)$post_view ? (int)$post_view : (int)$post['post_view'] );
		$this->data['post_video'] 						= (!empty($post['base_url']) ? $post['base_url'] : '').$post['video_url'];
		$this->data['post_video_name'] 				= (!empty($post['video_name']) ? $post['video_name'] : '');
		$this->data['post_date_added'] 				= $this->datetimes->convertDatetime('%d.%m.%Y, %H:%M', $post['date_added']);
		$this->data['post_date_updated'] 			= ($post['date_updated'] ?  $this->datetimes->convertDatetime('%d.%m.%Y, %H:%M', $post['date_updated']) : false);
		$this->data['post_share'] 						= social_share_urls($this->url->link('post', false, array('category' => $category->current['tag'], 'post_slug' => $post['slug'], 'post_id' => $post['id'])), $post['name']);


		$this->data['ratio_url'] 							=	htmlspecialchars_decode($this->url->link('_ajax_services','addRatio'));


		// post images
		$images = $this->model_post->getPostImages($post['id']);

		$this->data['post_images'] = array();

		if ( $images ) {

			foreach ( $images as $image ) {

				$this->data['post_images'][] = array(

					'big' => $this->model_image->resize($image['image'], 627, 268)
				);
			}

		} else {

			$this->data['post_images'][] = array(
				'big' => $this->model_image->resize(false, 627, 268)
			);
		}


		$this->data['most_read'] 		=		$this->model_post->getMostRead(5);


		// OTHER POST
		$sql_select = "
		SELECT
			p.id,
			p.name,
			p.date_added,
			p.date_updated,
			(SELECT image FROM post_image WHERE post_id = p.id ORDER BY preview, sort_order ASC LIMIT 1) AS image,";

		$sql_select .= "
				p.slug,
				c.slug AS category,
				cm.path
		";

		$sql_from = "
			FROM
				post p
				LEFT JOIN category c ON p.category_id = c.id
				LEFT JOIN post_category pc ON p.id = pc.post_id
				LEFT JOIN category_mirror cm ON p.category_id = cm.id ";

		$sql_where ="
			WHERE
				p.id != '".$post['id']."'
				AND pc.category_id = '".$this->db->escape($category->current['id'])."'
				AND p.status = '1'
			";


		$sql = $sql_select . $sql_from . $sql_where;
		$sql .= " ORDER BY p.date_added DESC LIMIT 6";

		$query 	= $this->db->query($sql);

		$this->data['items'] = array();

	    if ( $query->rows ) {

				 $i = 0; $j = 0;

		   	 foreach ( $query->rows as $row ) {

		   		 $data = array(

		   			 'name' 				=> $this->db->escapeText($row['name']),
						 'name_cut'			=> $this->db->escapeText($this->model_post->cutPostName($row['name'])),
		   			 'image'				=> $this->model_image->resize($row['image'], 136, 90),
		   			 'video'				=> 0,
		   			 'date_added'		=> $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_added']),
		   			 'date_updated'	=> ( !empty($row['date_updated']) ?  $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_updated']) : false ),
		   			 'url'					=> $this->url->link('post', false, array('category' => $row['category'], 'post_slug' => $row['slug'], 'post_id' => $row['id']))

		   		 );


					 $this->data['items'][$i][] = $data;
					 $j++;
					 $i   += ($j%6 == 0 ? 1 : 0);

		   	 }
	    }




		$this->template = 'post_detail.html';
		$this->children = array(
			'header',
			'menu',
			'footer'
		);

		$this->response->set($this->render());
	}


}
?>
