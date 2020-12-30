<?php
Class ModelPost extends Controller{

	private $ratio_list = array('view','like','dislike');

	public function isPost($post_id = false, $slug = false){

			if(!(int)$post_id || !$slug) return false;

	}

	public function mobileElementsFix($text = false){
			if(!$text) return false;
			$postDescription = preg_replace('@<table(.*?)>(.*?)</table>@si', "<div class='table-responsive'><table class='table table-bordered'>$2</table></div>", $text);
			return $postDescription;
	}


	public function getPost ( $post_id, $category_id ) {

		if ( !(int)$post_id || !(int)$category_id ) return false;

	 	$query = $this->db->query("
		SELECT p.*, pv.video_name, pv.video_url, pw.post_like, pw.post_dislike, pw.post_view, vl.base_url, cm.path AS category_path
		FROM post p
		LEFT JOIN post_category pc ON p.id = pc.post_id
		LEFT JOIN post_video pv ON p.id = pv.post_id
		LEFT JOIN post_view pw ON p.id = pw.post_id
		LEFT JOIN video_list vl ON pv.video_id = vl.id
		LEFT JOIN category_mirror cm ON p.category_id = cm.id
		WHERE
			p.id = '".(int)$post_id."'
			AND pc.category_id IN (".(int)$category_id.")
		");

		if ( $query->rows ) {
			return $query->row;
		}

		return false;
	}



		public function getTv ( $post_id = false ) {

		 	$sql = "
			SELECT p.*, ptv.*, cm.path AS category_path,
			(SELECT image FROM post_image WHERE post_id = p.id ORDER BY preview, sort_order ASC LIMIT 1) AS image
			FROM post p
			LEFT JOIN post_category pc ON p.id = pc.post_id
			LEFT JOIN post_tv ptv ON p.id = ptv.post_id
			LEFT JOIN category_mirror cm ON p.category_id = cm.id
			WHERE
			 	p.status = 1
				AND pc.category_id = (".$this->config->get('tv_parent_id').")
				AND ptv.url_rtmp != ''
				AND ptv.url_http != ''
			";

			$sql .=  ( (int)$post_id ? " AND p.id = '".(int)$post_id."' " : " ORDER BY sort_order ASC LIMIT 1 ");

			$query = $this->db->query($sql);

			if ( $query->rows ) {
				return $query->row;
			}

			return false;
		}


		public function getRadio ( $post_id = false ) {

		 	$sql = "
			SELECT p.*, pr.stream, pr.playlist, cm.path AS category_path,
			(SELECT image FROM post_image WHERE post_id = p.id ORDER BY preview, sort_order ASC LIMIT 1) AS image
			FROM post p
			LEFT JOIN post_category pc ON p.id = pc.post_id
			LEFT JOIN post_radio pr ON p.id = pr.post_id
			LEFT JOIN category_mirror cm ON p.category_id = cm.id
			WHERE
			 	p.status = 1
				AND pc.category_id = (".$this->config->get('radio_parent_id').")
				AND pr.stream != ''
				AND pr.playlist != ''
			";

			$sql .=  ( (int)$post_id ? " AND p.id = '".(int)$post_id."' " : " ORDER BY sort_order ASC LIMIT 1 ");

			$query = $this->db->query($sql);

			if ( $query->rows ) {
				return $query->row;
			}

			return false;
		}

	public function getPostImages ( $post_id = false  ) {

		$query = $this->db->query("SELECT * FROM post_image 	WHERE post_id = '".(int)$post_id."' ORDER BY preview, sort_order ASC");
		$data = array();

		if ( $query->rows ) {
				$data = $query->rows;
		}

		return $data;

	}


	public function cutPostName($name, $character = 65, $word = 10 ){

			if(!$name) return false;
			if(!(int)$character || strlen($name) < (int)$character) return $name;

			$data				=		array();

			$item 			= 	explode(' ',$name);
			$countItem 	= 	0;

			for(	$i=0; $i < ( $word <= count($item) ? $word : count($item) ); $i++){

				$countItem	+=	strlen($item[$i])+1;

				if ($countItem <= $character){

						$data[]		= 	$item[$i];
				}
			}

			$data = implode(' ', $data);
			$data = (strlen($data) < strlen($name) ? $data . ' ...' : $data);

			return $data;

	}




  /**
    * Get News
    * @param $cacheName      =   Cache kayıt ismi. 'news'.$cacheName.$start.$lmit ekleri ile oluşturulur. (Girilmez ise cache kayıtı oluşturmaz.) (False|String)
    * @param $category    		=   Haberin Kategori Bilgisi  (INT) Default: post_parent_id,video_parent_id
    * @param $location    		=   Haberin kayıtlı olduğu lokasyon (world|china|turkiye) Default: false
    * @param $preserves 			=   Girilen özelliklere ait haberleri listele (False|String) Default: false
 	 * @param $attrs 					=   Ek Özellikleri Belirtme aracı(array)
 	 *
 	 * $attrs Parametreleri
    * @param $notCategory 		=   Haberi çekerken bu kategoriye ait kayıtlar gelmesin. (False|Array|INT) Default: false
    * @param originalImg 		=   Haberi çekerken orijinal resimi de kullan. (True|False) Default: false
    * @param $start       		=   Haber Limit başlangıç değeri Default: 0
    * @param $limit			 		=   Haber çekme limiti Default: 10
    * @param $group   				=   Haberleri gruplama sayısı.(Girilmez ise limit ile aynı değeri alır.) (INT) Default: 10
    * @param $random         =   Rastgele Haber Çekme(True|False)  Default: false
    * @param $thumb          =   Haberin thumbnail hallerini oluştur.(True|False)  116x50  Default: false
    * @param $imgW  					=   Haber Resim Genişlik (INT) Default: 136
    * @param $imgH 					=   Haber Resim Yükseklik (INT) Default: 123
    * @return array|bool
 	 *
    */
 	 /*
 			$itemNews_attrs 	= array(
 			"notCategory"			=>		false,
 			"originalImg"			=>		false,
 			 "start"					=>		0,
 			 "limit"					=>		10,
 			 "group"					=>		10,
 			 "random"					=>		0,
 			 "thumb"					=>		0,
 			 "imgW"						=>		136,
 			 "imgH"						=>		123,
 			);
 	 */

 	public function newws($cacheName = false, $category = false, $location = false, $preserves = false, $attrs = array()){

 			$this->load->model('image');
 			$this->load->model('location');
 			$this->load->model('category');

 			$category     =  ( !$category ?  $this->config->get('post_parent_id').', '.$this->config->get('video_parent_id') : ( is_array($category) ? implode(", ",$category) : $category ) );
 			$location  		=  ( $location && $this->model_location->hasLocationSlug($location) ? (int)$this->model_location->getLocationID($location) : false );
 			$preserves 		=  ( $preserves ?  "'{$preserves}'"  : false );
 			$notCategory 	=  ( isset($attrs['notCategory']) ? ( is_array($attrs['notCategory']) ? implode(", ",$attrs['notCategory']) : (int)$attrs['notCategory'] ) : false );
			$originalImg  =  ( isset($attrs['originalImg']) && (int)$attrs['originalImg'] ? true : false );
			$start  			=  ( isset($attrs['start']) && (int)$attrs['start'] ? (int)$attrs['start'] : 0 );
 			$limit  			=  ( isset($attrs['limit']) && (int)$attrs['limit'] ? (int)$attrs['limit'] : 10 );
 			$group  			=  ( isset($attrs['group']) && (int)$attrs['group'] <= $limit ? (int)$attrs['group'] : $limit );
 			$random 			=  ( isset($attrs['random']) && (int)$attrs['random'] ? true : false );
 			$thumb 				=  ( isset($attrs['thumb']) && (int)$attrs['thumb'] ? true : false );
 			$imgW 				=  ( isset($attrs['imgW']) && (int)$attrs['imgW'] > 0 ?  (int)$attrs['imgW']  : 136 );
 			$imgH 				=  ( isset($attrs['imgH']) && (int)$attrs['imgH'] > 0  ?  (int)$attrs['imgH']  : 123 );
 			$cacheName  	=  ( !$cacheName ? false : 'news.' . $cacheName . '.' . (int)$start . '.' . (int)$limit );

 			$data = ($cacheName ? $this->cache->get($cacheName) : false );
 			//$data = false;


 		 if ( !$data ) {

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
 							 LEFT JOIN post_preserve pp ON p.id = pp.post_id
 							 LEFT JOIN preserve prev ON prev.id = pp.preserve_id
 							 LEFT JOIN category_mirror cm ON p.category_id = cm.id ";

 					 $sql_where ="
 						 WHERE p.status = '1'
 						 AND pc.category_id IN (".$category.") ";


 					if($preserves)  { $sql_where .= " AND prev.code IN (".$preserves.")  "; }
					if($location)   { $sql_where .=" AND pl.location_id = '".(int)$location."' "; }

 					$sql_where  .= " ORDER BY ".($random ? " RAND() " : " p.date_added DESC, p.sort_order ASC " )." LIMIT ".(int)$start.", ".(int)$limit." "; //ORDER BY date_added DESC

 				 	$sql = $sql_select . $sql_from . $sql_where;
 				 	$query 	= $this->db->query($sql);


 					if ( $query->rows ) {

 	 					$i = 0; $j = 0;

 	 					foreach ( $query->rows as $row ) {

 	 						$category			=		$this->model_category->get_category_details($row['category']);

 	 						$datas = array(

								'post_id'					=> $row['id'],
 	 							'name' 						=> $this->db->escapeText($row['name']),
 	 							'name_cut'				=> $this->db->escapeText($this->cutPostName($row['name'])),
 	 							'image'						=> $this->model_image->resize($row['image'], (int)$imgW, (int)$imgH),
 	 							'image_thumb'			=> ($thumb ? $this->model_image->resize($row['image'], 116, 50) : false),
 	 							'image_org'				=> ($originalImg ? $row['image'] : false),
 	  		   			'video'						=> ($category->parent['id'] == $this->config->get('video_parent_id') ? 1 : 0 ),
 	 							'date_added'			=> $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_added']),
 	 							'date_added_h'		=> $this->datetimes->convertDatetime('%H.%S', $row['date_added']),
 	 							'date_updated'		=> ( !empty($row['date_updated']) ?  $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_updated']) : false ),
 	 							'url'							=> $this->url->link(($category->parent['id'] == $this->config->get('video_parent_id') ? 'video' : 'post' ), false, array('category' => $row['category'], 'post_slug' => $row['slug'], 'post_id' => $row['id']))

 	 						);

 	 						$data[$i][] = $datas;
 	 						$j++;
 	 						$i   += ($j % (int)$group == 0 ? 1 : 0);

 	 					}


 	 					if($limit == 1 && !empty($data)){ $data  =  $data[0][0]; }
 	 			 }



				if($cacheName){

		 				//$this->cache->setExpire(3600 * 3);
		 			 	$this->cache->set($cacheName, $data);
				}

 		 }

 		 return $data;
 	}









	public function news ($type = 'post', $category = false, $location = false, $start = 0, $limit = 10, $imageWidth = 136, $imageHeight = 123, $getLimit = 6, $random = false, $thumb = false) {

		$this->load->model('image');
		$this->load->model('location');
		$this->load->model('category');

		if(!$category) $category = $this->config->get('post_parent_id').', '.$this->config->get('video_parent_id');


		$data = $this->cache->get('news.' . $type . '.' . (int)$start . '.' . (int)$limit);
		//$data = false;

		 if ( !$data ) {

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
				 WHERE p.status = '1'
				 AND pc.category_id IN (".$category.")";

				if($location)   $sql_where .=" AND pl.location_id = '".(int)$this->model_location->getLocationID($location)."' ";


			$sql_where  .= " ORDER BY ".($random ? " RAND() " : " p.date_added DESC, p.sort_order ASC " )." LIMIT ".(int)$start.", ".(int)$limit." "; //ORDER BY date_added DESC


			 $sql = $sql_select . $sql_from . $sql_where;
			 $query 	= $this->db->query($sql);


			 if ( $query->rows ) {

					$i = 0; $j = 0;

					foreach ( $query->rows as $row ) {

						$category			=		$this->model_category->get_category_details($row['category']);

						$datas = array(

							'name' 						=> $this->db->escapeText($row['name']),
							'name_cut'				=> $this->db->escapeText($this->cutPostName($row['name'])),
							'image'						=> $this->model_image->resize($row['image'], (int)$imageWidth, (int)$imageHeight),
							'image_thumb'			=> ($thumb ? $this->model_image->resize($row['image'], 116, 50) : false),
 		   			 	'video'						=> ($category->parent['id'] == $this->config->get('video_parent_id') ? 1 : 0 ),
							'date_added'			=> $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_added']),
							'date_added_h'		=> $this->datetimes->convertDatetime('%H.%S', $row['date_added']),
							'date_updated'		=> ( !empty($row['date_updated']) ?  $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_updated']) : false ),
							'url'							=> $this->url->link(($category->parent['id'] == $this->config->get('video_parent_id') ? 'video' : 'post' ), false, array('category' => $row['category'], 'post_slug' => $row['slug'], 'post_id' => $row['id']))

						);

						$data[$i][] = $datas;
						$j++;
						$i   += ($j % (int)$getLimit == 0 ? 1 : 0);

					}

					if($limit == 1 && !empty($data)){ $data  =  $data[0][0]; }
			 }

					//$this->cache->setExpire(3600 * 3);
				 	$this->cache->set('news.' . $type . '.' . (int)$start . '.' . (int)$limit, $data);

		 }

		 return $data;

	 }



	public function getMostRead($limit = 5){

				$this->load->model('image');
				$this->load->model('category');

				$data = $this->cache->get('news.post.most_read_post');

				if ( !$data ) {

					$sql_select = "
					SELECT
						p.id,
						p.name,
						p.date_added,
						p.date_updated,
						pw.post_view,
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
							LEFT JOIN post_view pw ON p.id = pw.post_id
							LEFT JOIN category_mirror cm ON p.category_id = cm.id ";

					$sql_where ="
						WHERE p.status = '1'
						AND pc.category_id IN (".$this->config->get('post_parent_id').") 
						ORDER BY pw.post_view DESC LIMIT ".$limit;

					$sql = $sql_select . $sql_from . $sql_where;
					$query 	= $this->db->query($sql);


					if ( $query->rows ) {

						 //$i = 0; $j = 0;

						 foreach ( $query->rows as $row ) {

							 $category			=		$this->model_category->get_category_details($row['category']);

							 $datas = array(

								 'name' 						=> $row['name'],
								 'name_cut'					=> $this->cutPostName($row['name']),
								 'image'						=> $this->model_image->resize($row['image'], 146, 90),
								 'post_view'				=> $row['post_view'],
								 'video'						=> ($category->parent['id'] == $this->config->get('video_parent_id') ? 1 : 0 ),
								 'date_added'				=> $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_added']),
								 'date_updated'			=> ( !empty($row['date_updated']) ?  $this->datetimes->convertDatetime('%d.%m.%Y', $row['date_updated']) : false ),
								 'url'							=> $this->url->link(($category->parent['id'] == $this->config->get('video_parent_id') ? 'video' : 'post' ), false, array('category' => $row['category'], 'post_slug' => $row['slug'], 'post_id' => $row['id']))

							 );

							 $data[] = $datas;
							 /*$data[$i][] = $datas;
							 $j++;
							 $i   += ($j % (int)$getLimit == 0 ? 1 : 0);*/

						 }

						 if($limit == 1 && !empty($data)){ $data  =  $data[0][0]; }
					}

						 $this->cache->set('news.post.most_read_post',$data);

				}

				return $data;
	}


  // view, like ve dislike alanı için session'da değer tutularak yapılmıştır.
 	public function addPostRatio($post_id = false, $ratio_type = false){

 			if(!(int)$post_id || !$ratio_type || !in_array($ratio_type, $this->ratio_list) ) return false;

  		$postRatios 		 	=   array('viewList' => array(), 'likeList' => array());
 			$postRatios  			=		($this->session->has('postRatios') ? $this->session->get('postRatios') : $postRatios);

 			$query 						=		$this->db->query(" SELECT pw.*  FROM post_view pw  WHERE pw.post_id = '".(int)$post_id."' LIMIT 1");

 			$view  = $like = $dislike = 1;

 			if(!$query->rows){

 					$this->db->query(" INSERT INTO post_view SET post_id = '".(int)$post_id."'");

 			}else{

 					$view 				=	(int)(++$query->row['post_view']);
 					$like 				=	(int)(++$query->row['post_like']);
 					$dislike 			=	(int)(++$query->row['post_dislike']);
 			}


 			if( $ratio_type == "view"  &&  !in_array((int)$post_id, $postRatios['viewList']) ){

 					$this->db->query(" UPDATE post_view SET post_view = '".(int)$view."' WHERE post_id = '".(int)$post_id."' ");
 					//$postRatios['viewList'][]   =  (int)$post_id; // Sayfayı her yenilediğinde view artmasın

 			}else if($ratio_type == "like"  &&  !in_array((int)$post_id, $postRatios['likeList']) ){

 					$this->db->query(" UPDATE post_view SET post_like = '".(int)$like."' WHERE post_id = '".(int)$post_id."' ");
 					$postRatios['likeList'][]   =  (int)$post_id;

 			}else if($ratio_type == "dislike"  &&  !in_array((int)$post_id, $postRatios['likeList']) ){

 					$this->db->query(" UPDATE post_view SET post_dislike = '".(int)$dislike."' WHERE post_id = '".(int)$post_id."' ");
 					$postRatios['likeList'][]   =  (int)$post_id;

 			}else{
				return false;
			}

 			$this->session->delete('postRatios');
 			$this->session->set('postRatios',$postRatios);

 			return ( $ratio_type == "view" ? $view : ( $ratio_type == "like" ? $like : $dislike ) );
 	}


 	public function total_results ( $num_rows = 0 ) {

 		$num_rows = (int)$num_rows;

 		if ( $num_rows == 0 ) {

 			$result = "uygun haber bulunamadı.";

 		} else if ( $num_rows > 0 && $num_rows < 1001 ) {

 			$result = "Toplam {$num_rows} haber bulundu";

 		} else if ( $num_rows > 1000 ) {

 			$result = "1000'den fazla haber bulundu";

 		}

 		return $result;

 	}

}

?>
