<?php
Class ModelNews extends Controller{

	private $site 				= "http://silktrek.com/termnodes/1";
	private $oldSite 			= false;
	private $total_count 	= 0;
	private $page 				= 0;
	private $item					= false;
	private $limit 				= 50;
	private $oldLimit 		= 0;


	public function getNewsItem(){
		return $this->item;
	}


	public function getTotal(){
		return $this->total_count;
	}


	public function setSite($site = false){

		if(!$site) return false;
		$this->oldSite 	= $this->site;
		$this->site 		= $site;

	}

	public function setLimit($limit = false){

		if(!(int)$limit) return false;
		$this->oldLimit = $this->limit;
		$this->limit 		= $limit;

	}

	public function getSilkNews($pageText = "?page="){

		$cs 				=  $this->site.( $this->page ? $pageText.($this->page-1) : "" );
		$curlData 	=  $this->getCurl($cs);

		// Pagination Kontrolü
		if( !$this->page ){
				preg_match('@<ul class="pager">(.*?)</ul>@s',$curlData,$dataPagination);
				if( !empty($dataPagination[1]) ) {
						$this->page   += 1;
						$this->getSilkNews();
				}
		}


		preg_match('@<td class="multi-column-row">(.*)</td>@si',$curlData,$viewContents);

		if( !empty($viewContents[1]) ){

				$viewContent  =  strip_tags($viewContents[1],"<a>");
				preg_match_all('@<a href="(.*?)">(.*?)</a>@si', $viewContent, $elements);

				$element_link   =  $elements[1];
				$element   			=  $elements[2];

				for($i = 0; $i< count($elements[2]); $i++){

					if( $this->total_count < $this->limit ){

						$item = $this->getSilkNewsDetail($element_link[$i]);
						$this->item[]	=	array(
								'name'					=>	$element[$i],
								'url'						=>	$element_link[$i],
								'image'					=>	$item['image'],
								'description'		=>	$item['description']
						);

						$this->total_count += 1;
					}

				}

				if( $this->page && $this->total_count < $this->limit){

					$this->page += 1;
					$this->getSilkNews();

				}

			}

			$this->limit = ($this->oldLimit ? $this->oldLimit : $this->limit);
	}



	public function getSilkNewsDetail($itemLink = false){

			$item['image'] 				= false;
			$item['description'] 	= false;

			if(!$itemLink) return $item;

			$arr 				=	 parse_url($this->site);
			$site    	 	=  $arr['scheme']."://".$arr['host'];
			$cs 				=  $site.$itemLink;
			$curlData 	=  $this->getCurl($cs);

			preg_match('@<div class="field-items">(.*?)</div>@si',$curlData,$items);

			if( !empty($items[1]) ){

				preg_match('@<img([^>]*) src="([^"/]*/?[^".]*\.[^"]*)"([^>]*)>((?!</a>))@si', $items[1] ,$images);

				$item['image'] 											= 	(!empty($images[2]) ? $images[2] : false); 
				$item['description']  							=   strip_tags($items[1],'<i><b><span><strong><p>');
				//preg_replace('/<[p|P].*>\s*</[p|P]>/','',$item['description']);
				$item['description'] 								= preg_replace("/<([a-z][a-z0-9]*)[^>]*?(\/?)>/i",'<$1$2>', $item['description']);
			}

			return $item;
	}







	private function getCurl($cs){

		$ch 			= curl_init();
		$hc 			= "YahooSeeker-Testing/v3.9 (compatible; Mozilla 4.0; MSIE 5.5; Yahoo! Search - Web Search)";
		curl_setopt($ch, CURLOPT_REFERER, 'http://www.google.com');
		curl_setopt($ch, CURLOPT_URL, $cs);
		curl_setopt($ch, CURLOPT_USERAGENT, $hc);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$curlData = curl_exec($ch);
		curl_close($ch);

		return $curlData;

	}

}
?>
