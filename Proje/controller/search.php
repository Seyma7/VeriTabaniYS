<?php

Class ControllerSearch Extends Controller {

	public function index() {

		$this->load->model('category');
		$this->load->model('post');
		$this->load->model('image');


		if ( !$this->request->get('search') ) {
				$this->response->redirect(HTTP_SERVER);
		}

		$search = urldecode($this->request->get('search'));
		$this->data['headLine'] = $search;

/*
		$this->document->setTitle(($category->current['page_title'] ? $category->current['page_title'] : $category->current['name']));
		$this->document->setKeywords($category->current['meta_keyword']);
		$this->document->setDescription($category->current['meta_description']);*/


		$this->data['offsets'] 	= array(18, 36, 54, 72, 90);
		$this->data['offset'] 	= (in_array((int)$this->request->get('offset'), $this->data['offsets']) ? (int)$this->request->get('offset') : reset($this->data['offsets']));


		$sql_select = "
		SELECT
			p.id,
			p.name,
			p.date_added,
			p.date_updated,
			(SELECT post_id FROM post_video WHERE post_id = p.id LIMIT 1) AS video,
			(SELECT image FROM post_image WHERE post_id = p.id ORDER BY preview, sort_order ASC LIMIT 1) AS image, ";

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
				 (p.name LIKE '%".$this->db->escape($search)."%' OR p.description LIKE '%".$this->db->escape($search)."%' )
				 AND pc.category_id IN (".$this->config->get('post_parent_id').", ".$this->config->get('video_parent_id').")
				 AND p.status = '1'";


		$sql = $sql_select . $sql_from . $sql_where;
		$sql .= " ORDER BY p.date_added DESC  ";

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

		   			 'name' 				=> $this->db->escapeText($row['name']),
						 'name_cut'			=> $this->db->escapeText($this->model_post->cutPostName($row['name'])), 
		   			 'image'				=> $this->model_image->resize($row['image'], 136, 90),
		   			 'video'				=> ($category->parent['id'] == $this->config->get('video_parent_id') ? 1 : 0 ),
		   			 'date_added'		=> $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_added']),
		   			 'date_updated'	=> ( !empty($row['date_updated']) ?  $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_updated']) : false ),
		   			 'url'					=> $this->url->link(($category->parent['id'] == $this->config->get('video_parent_id') ? 'video' : 'post' ), false, array('category' => $row['category'], 'post_slug' => $row['slug'], 'post_id' => $row['id']))

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


	    }else{
				 $this->data['resultInfo'] 	=	"Arama sonucu kayıt bulunamadı.";
			}

		$this->template = 'post.html';

		$this->children = array(
			'header',
			'menu',
			'footer'
		);

		$this->response->set($this->render());

	}

	public function video(){

			$this->load->model('category');
			$this->load->model('post');
			$this->load->model('image');


			$this->document->setTitle("Güncel Videolar");
			$this->document->setKeywords("Güncel Videolar");
			$this->document->setDescription("Güncel Videolar");

			$this->template = 'videos.html';

			$this->children = array(
			'header',
			'menu',
			'footer'
			);

			$this->response->set($this->render());
	}




	public function radio(){

			$this->load->model('category');
			$this->load->model('post');
			$this->load->model('image');


			$this->document->setTitle("Radyolar");
			$this->document->setKeywords("Radyolar");
			$this->document->setDescription("Radyolar");

			$this->template = 'radio.html';

			$this->children = array(
			'header',
			'menu',
			'footer'
			);

			$this->response->set($this->render());
	}


	public function tv(){

			$this->load->model('category');
			$this->load->model('post');
			$this->load->model('image');


			$this->document->setTitle("Televizyon");
			$this->document->setKeywords("Televizyon");
			$this->document->setDescription("Televizyon");

			$this->template = 'tv.html';

			$this->children = array(
			'header',
			'menu',
			'footer'
			);

			$this->response->set($this->render());
	}


}

?>
