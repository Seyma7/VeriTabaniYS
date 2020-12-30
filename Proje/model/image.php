<?php

Class ModelImage extends Controller{

	public function resize ( $filename = false, $width = 0 , $height = 0, $ratioFill = 0) { 

		if ( !$filename || !file_exists(DIR_IMAGE . $filename) ) $filename = 'preview/no_preview.png';

		$dirfile = DIR_IMAGE.pathinfo($filename,PATHINFO_DIRNAME).'/';

		if ( !file_exists(DIR_IMAGE . $filename) ) {

			return;
		}

		$this->load->library('upload');

		$file		= str_replace(strtolower(strrchr($filename, '.')), '', basename($filename));

		$image 		= str_replace($file, $file . '-' . $this->_resized_name($width, $height), $filename);
		$image_cut 	= str_replace(strtolower(strrchr($image, '.')), '', basename($image));


		if ( file_exists(DIR_IMAGE . $image) ) {

			return HTTP_IMAGE . $image;
		}


		if($width == 0 || $height == 0){

			return HTTP_IMAGE.$filename;
		}




		// GÖRSEL, GİRİLEN W-H DEĞERLERİNDEN KÜÇÜK İSE ORJ. KENARLARDAN GENİŞLETEREK GÖNDER
		if($ratioFill){

				list($iwidth,$iheight,$itype) = getimagesize(DIR_IMAGE . $filename);
				//if($iwidth < $width || $iheight < $height){}

				$cropH							= ($iheight <  $height ? -ceil(($height-$iheight)/2) : 0);
				$foo 								= new Upload(DIR_IMAGE . $filename);
				$foo->image_background_color 	= '#000';
				$foo->image_resize          	= true;
				$foo->image_ratio_fill       	= true;
				$foo->image_x               	= $width;
				$foo->file_new_name_body 			= $image_cut;

				if($iheight <  $height){

					$foo->image_y            	= $iheight;
					$foo->image_crop        	= "{$cropH}px 0px";

				}else{

					$foo->image_y           	= $height;
				}

				$foo->Process($dirfile);

				if ($foo->processed) {

					return HTTP_IMAGE.$image;

				} else {

					return HTTP_IMAGE.$filename;
				}
		}




		$foo = new Upload(DIR_IMAGE . $filename);
		$foo->image_resize 						= true;
		//$foo->image_ratio_fill       	= true;
		//$foo->image_background_color 	= '#FFF';
		$foo->image_x 							= (int)$width;
		$foo->image_y 							= (int)$height;
		$foo->file_new_name_body 		= $image_cut;
		$foo->Process($dirfile);

      if ($foo->processed) {

          return HTTP_IMAGE.$image;

      } else {

          return HTTP_IMAGE.$filename;
      }

      //$foo->Clean();
	}


	private function _resized_name($width = 0, $height = 0){

		return ((int)$width && (int)$width > 0 ? (int)$width : 'autowidth') . 'X' . ((int)$height && (int)$height > 0 ? (int)$height : 'autoheight');

	}

}

?>
