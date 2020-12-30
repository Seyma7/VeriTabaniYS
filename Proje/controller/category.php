<?php

Class ControllerCategory Extends Controller {

	public function index() {

		$this->load->model('category');
		$this->load->model('post');
		$this->load->model('image');


		$category = $this->model_category->get_category_details($this->request->get('slug'));

		if ( !$category->current ) {
			return $this->forward('error');
		}

		$this->document->setTitle($this->db->escapeText(($category->current['page_title'] ? $category->current['page_title'] : $category->current['name'])));
		//$this->document->setKeywords($this->db->escapeText($category->current['meta_keyword']));
		//$this->document->setDescription($this->db->escapeText($category->current['meta_description']));


		$this->data['headLine']	=	$this->document->getTitle();

		// Category Data
		$this->data['category_data'] = array();

		$query = $this->db->query("SELECT * FROM category WHERE parent = '".(int)$category->current['id']."' AND status = '1'");

		if ( $query->rows ) {

			foreach ( $query->rows as $row ) {

				$this->data['category_data'][] = array(

					'name' 	=> $row['name'],
					'url'	=> $this->url->link('category', false, array('slug' => $row['slug']))

				);

			}

		}

		$this->data['category'] 				= $category->current;
		$this->data['category_parent'] 			= $category->parent;
		$this->data['breakcrumbs'] 				= $category->fields;

		$parentCategory							= $this->model_category->parentCategories((int)$category->current['id']);


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
				LEFT JOIN post_category pc ON p.id = pc.post_id
				LEFT JOIN category_mirror cm ON p.category_id = cm.id ";

		$sql_where ="
			WHERE
				pc.category_id = '".$this->db->escape($category->current['id'])."'
				AND p.status = '1'";


		$sql = $sql_select . $sql_from . $sql_where;
		$sql .= " ORDER BY p.date_added DESC ";

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


		   		 $data = array(

		   			 'name' 				=> $this->db->escapeText($row['name']),
						 'name_cut'			=> $this->db->escapeText($this->model_post->cutPostName($row['name'])),
		   			 'image'				=> $this->model_image->resize($row['image'], 136, 100),
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


			$this->data['headLine'] 					=		"GÜNCEL VİDEOLAR";
			$this->data['videoBigList'] 			=		$this->model_post->news('video.videoBigList', $this->config->get('video_parent_id'), false, 0, 3, 312, 200, 3);
			$this->data['videoSmallList'] 		= 	$this->model_post->news('video.videoSmallList', $this->config->get('video_parent_id'), false, 3, 3, 146, 90, 3);
			$this->data['videoVideos']				= 	$this->model_post->news('video.videoVideos', $this->config->get('video_parent_id'), false, 6, 10, 637, 317, 10);
			$this->data['videoList2'] 				= 	$this->model_post->news('video.videoList2', $this->config->get('video_parent_id'), false, 16, 2, 146, 110, 2);
			$this->data['videoSmallList2'] 		= 	$this->model_post->news('video.videoSmallList2', $this->config->get('video_parent_id'), false, 18, 2, 121, 85, 2);
			$this->data['videoBigList2'] 			=		$this->model_post->news('video.videoBigList2', $this->config->get('video_parent_id'), false, 20, 2, 312, 200, 2);

			$this->data['videoWorld'] 				= 	$this->model_post->news('video.videoWorld',$this->config->get('video_parent_id'), 'world', false, 6, 136, 90, 6);
			$this->data['videoTurkey'] 				= 	$this->model_post->news('video.videoTurkey',$this->config->get('video_parent_id'), 'turkiye', false, 6, 136, 90, 6);
			$this->data['videoChina'] 				= 	$this->model_post->news('video.videoChina',$this->config->get('video_parent_id'), 'china', false, 6, 136, 90, 6);


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


			if((int)$this->request->get('post_id') &&  $this->request->get('post_slug')){

					$post 	= 	$this->model_post->getRadio( (int)$this->request->get('post_id') );

					if ( !$post ||  $post['slug'] != $this->request->get('post_slug')) {

						return $this->forward('error');
					}

			}else{ $post 		=		$this->model_post->getRadio();	}


			if($post){

				$post_view 	= 	$this->model_post->addPostRatio((int)$post['id'], 'view');
				$host 			= 	parse_url( ( !empty($post['stream']) ? $post['stream'] : (!empty($post['playlist']) ? $post['playlist'] : false) ) );

				$this->data['item'] 		= 		array(
					'post_id'						=>	$post['id'],
					'post_title'				=>	$post['name'],
					'post_description'	=>	$this->model_post->mobileElementsFix($post['description']),
					'image'							=>	$this->model_image->resize($post['image'], 200, 100),
					'stream'						=>	$post['stream'],
					'playlist'					=>	$post['playlist'],
					'radio_url'					=>  ( !empty($host['scheme']) ? $host['scheme']."://" : "" ).( !empty($host['host']) ? $host['host'] : "" ).( !empty($host['port']) ? ":".$host['port'] : "" ),
					'url'								=>  $this->url->href('category', 'radio', array('post_slug' => $post['slug'], 'post_id' => $post['id']))
				);



				$this->document->setTitle($this->db->escapeText($post['name']));
				$this->document->setKeywords($this->db->escapeText($post['name']));
				$this->document->setDescription($this->db->escapeText($post['name']));
			}


			$this->data['getRadioSongUrl']  =  $this->url->link('_ajax_services','getRadioSongName');

			$sql_select = "
			SELECT
				p.id,
				p.name,
				p.date_added,
				p.date_updated,
				pr.stream,
				pr.playlist,
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
					LEFT JOIN post_radio pr ON p.id = pr.post_id
					LEFT JOIN category_mirror cm ON p.category_id = cm.id ";

			$sql_where ="
				WHERE
					pc.category_id IN (".$this->config->get('radio_parent_id').")
					/*AND p.id NOT IN (".(int)$post['id'].")*/
					AND p.slug != 'cri-turk-fm'
					AND p.status = '1'";


			$sql = $sql_select . $sql_from . $sql_where;
			$sql .= " ORDER BY p.sort_order ASC ";

			$query 	= $this->db->query($sql);

			$this->data['other'] = array();

			if ( $query->rows ) {

					$i = 0; $j = 0; $z = 1;
				 foreach ( $query->rows as $row ) {

					 $image  =  ( file_exists( DIR_IMAGE."radio/".$row['slug'].".jpg" ) ? HTTP_IMAGE."radio/".$row['slug'].".jpg" : $this->model_image->resize($row['image'], 200, 100) );

					 $datas = array(
						 'image'				=> $image ,
						 'name'					=> $row['name'],
						 'stream'				=> $row['stream'],
						 'playlist'			=> $row['playlist'],
						 'url'					=> $this->url->link('category', 'radio', array('post_slug' => $row['slug'], 'post_id' => $row['id']))
					 );

					 $data[$i]['items'][] = $datas;
					 $j++;
					 $i   += ($j % 3 == 0 ? 1 : 0);
					 $z   = ($j % 3 == 0 ? 0 : ($z+1));
					 $data[$i]['total'] 	= $z;
				 }

				 $this->data['other'] = $data;
			}



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


			if((int)$this->request->get('post_id') &&  $this->request->get('post_slug')){

					$post 	= 	$this->model_post->getTv( (int)$this->request->get('post_id') );

					if ( !$post ||  $post['slug'] != $this->request->get('post_slug')) {

						return $this->forward('error');
					}

			}else{ $post 		=		$this->model_post->getTv();	}

			if($post){
				$this->data['item'] 		= 		array(
					'post_id'						=>	$post['id'],
					'post_title'				=>	$post['name'],
					'post_description'	=>	$this->model_post->mobileElementsFix($post['description']),
					'image'							=>	$this->model_image->resize($post['image'], 90, 80),
					'post_rtmp'					=>	$post['url_rtmp'],
					'post_http'					=>	$post['url_http'],
					'url'								=> 	$this->url->href('category', 'tv', array('post_slug' => $post['slug'], 'post_id' => $post['id']))
				);

				$this->document->setTitle($this->db->escapeText($post['name']));
				$this->document->setKeywords($this->db->escapeText($post['name']));
				$this->document->setDescription($this->db->escapeText($post['name']));
			}


			$sql_select = "
			SELECT
				p.id,
				p.name,
				p.date_added,
				p.date_updated,
				ptv.*,
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
					LEFT JOIN post_tv ptv ON p.id = ptv.post_id
					LEFT JOIN category_mirror cm ON p.category_id = cm.id ";

			$sql_where ="
				WHERE
					pc.category_id IN (".$this->config->get('tv_parent_id').")
					AND p.id NOT IN (".(int)$post['id'].")
					AND p.status = '1'";


			$sql = $sql_select . $sql_from . $sql_where;
			$sql .= " ORDER BY p.sort_order ASC ";

			$query 	= $this->db->query($sql);

			$this->data['other'] = array();

		    if ( $query->rows ) {

			   	 foreach ( $query->rows as $row ) {

			   		 $data = array(
			   			 'image'				=> $this->model_image->resize($row['image'], 90, 80),
							 'name'					=> $row['name'],
							 'rtmp'					=> $row['url_rtmp'],
							 'http'					=> $row['url_http'],
			   			 'url'					=> $this->url->link('category', 'tv', array('post_slug' => $row['slug'], 'post_id' => $row['id']))
			   		 );

						 $this->data['other'][] = $data;
			   	 }

		    }


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
