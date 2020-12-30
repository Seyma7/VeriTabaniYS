<?php

Class ControllerLocation Extends Controller {

	public function index() {

		$this->load->model('category');
		$this->load->model('post');
		$this->load->model('location');
		$this->load->model('image');


		if ( !$this->request->get('slug') ||  !$this->model_location->hasLocationSlug($this->request->get('slug')) ) {
				return $this->forward('error');
		}

		$location_list 		=		 $this->model_location->getLocationList();

		$this->document->setTitle($location_list[$this->model_location->getLocationID($this->request->get('slug'))]['name']);
		$this->document->setKeywords($location_list[$this->model_location->getLocationID($this->request->get('slug'))]['name']);
		$this->document->setDescription($location_list[$this->model_location->getLocationID($this->request->get('slug'))]['name']);

		$this->data['headLine']	=	$this->document->getTitle();


		$this->data['offsets'] 	= array(18, 36, 54, 72, 90);
		$this->data['offset'] 	= (in_array((int)$this->request->get('offset'), $this->data['offsets']) ? (int)$this->request->get('offset') : reset($this->data['offsets']));


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
				LEFT JOIN post_location pl ON pl.post_id = p.id
				LEFT JOIN post_category pc ON p.id = pc.post_id
				LEFT JOIN category_mirror cm ON p.category_id = cm.id ";

		$sql_where ="
			WHERE
					pl.location_id = '".(int)$this->model_location->getLocationID($this->request->get('slug'))."'
 				  AND pc.category_id IN (".$this->config->get('post_parent_id').")
					AND p.status = '1'
			";
		//, ".$this->config->get('video_parent_id')."

		$sql = $sql_select . $sql_from . $sql_where;
		$sql .= " ORDER BY date_added DESC ";

		//$cache_name = 'post_search_sql.' . md5($sql);

		$query_num_rows = $this->db->query($sql);
		$query_num_rows	= $query_num_rows->num_rows;

		$this->data['total_results'] = $this->model_post->total_results($query_num_rows);

		$page 	= (!$this->request->has('page') || (int)$this->request->get('page') < 1 ? 1 : (int)$this->request->get('page'));
		$limit 	= $this->data['offset'];
		$start	= ($page - 1 ) * $limit;

		$sql 	.= " LIMIT {$start}, {$limit}";
		$query 	= $this->db->query($sql);




		$this->data['items'] = array();

	    if ( $query->rows ) {

				 $i = 0; $j = 0;

		   	 foreach ( $query->rows as $row ) {

					 $category			=		$this->model_category->get_category_details($row['category']);

		   		 $data = array(

		   			 'name' 					=> $row['name'],
						 'name_cut'				=> $this->model_post->cutPostName($row['name']),
		   			 'image'					=> $this->model_image->resize($row['image'], 136, 90),
		   			 'video'					=> ($category->parent['id'] == $this->config->get('video_parent_id') ? 1 : 0 ),
		   			 'date_added'			=> $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_added']),
		   			 'date_updated'		=> ( !empty($row['date_updated']) ?  $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_updated']) : false ),
		   			 'url'						=> $this->url->link(($category->parent['id'] == $this->config->get('video_parent_id') ? 'video' : 'post' ), false, array('category' => $row['category'], 'post_slug' => $row['slug'], 'post_id' => $row['id']))

		   		 );

					 $this->data['items'][$i][] = $data;
					 $j++;
					 $i   += ($j%6 == 0 ? 1 : 0);
		   	 }


		   	 $request_uri = $_SERVER['REQUEST_URI'];

		   	 if ( preg_match('/page=[0-9]+$/', $request_uri) ) {

		   		 $request_uri = preg_replace('/page=[0-9]+$/', 'page={page}', $request_uri);

		   	 } else {

		   		 $request_uri = $request_uri . (preg_match('/\?/', $request_uri) ? '&' : '?') . 'page={page}';

		   	 }


		   	 $pagination 								= new Pagination();
		   	 $pagination->total 				= $query_num_rows;
		   	 $pagination->page 					= $page;
		   	 $pagination->limit 				= $limit;
		   	 $pagination->text 					= false;
		   	 $pagination->text_next 		= false;
		   	 $pagination->text_prev 		= false;
		   	 $pagination->text_first 		= false;
		   	 $pagination->text_last 		= false;
		   	 $pagination->url 					= $request_uri;
		   	 $this->data['pagination'] 	= $pagination->render();


	    }

		$this->template = 'post.html';

		$this->children = array(
			'header',
			'menu',
			'footer'
		);

		$this->response->set($this->render());

	}


}

?>
