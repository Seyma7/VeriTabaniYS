<?php

Class ModelUpload extends Controller{

	public function upload ( $file = false, $filename = false, $directory = false, $max_file_size = 300000, $allowed_types = array(), $watermark = false, $FWidth = 260, $FHeight = 150 ) {

		$data = array();

		if ( !$file ) $data['error'] = 'Dosya seçilmedi.';

		$filename = $filename . strtolower(strrchr(basename(html_entity_decode($file['name'], ENT_QUOTES, 'UTF-8')), '.'));

		if ( !isset($data['error']) ) {


			if ((strlen($filename) < 3) || (strlen($filename) > 255)) {

				$data['error'] = 'Dosya adı 3 ile 255 karakter arasında olmalıdır.';

			}

			if (!is_dir(DIR_IMAGE . $directory)) {

				$data['error'] = 'Hedef klasör bulunamadı.';

			}

			if ($file['size'] > (int)$max_file_size) {

				$data['error'] = 'Dosya ' . (int)$max_file_size . ' B\' dan büyük olmamalıdır.';

			}

			if ( $allowed_types ) {

				if (!in_array($file['type'], $allowed_types)) {

					$data['error'] = 'Geçersiz dosya türü: ' . $file['type'];

				}

			}


			list($iwidth,$iheight,$itype) = getimagesize($file['tmp_name']);

			if ($iwidth < $FWidth || $iheight < $FHeight) {

				$data['error'] = 'Dosya  minimum ' . $FWidth . 'x' . $FHeight . ' ölçülerinde olmalıdır';

			}


			if ($file['error'] != UPLOAD_ERR_OK) {

				$data['error'] = 'Hata oluştu: ' . $file['error'];

			}


			if ( !$this->customer->isLogged() ) {

				$data['error'] = 'Erişim yetkiniz bulunmamaktadır.';

			}

		}

		if (!isset($data['error'])) {

			$this->load->library('upload');

			$foo = new Upload($file);

			if ($foo->uploaded) {

				$filebase		= str_replace(strtolower(strrchr($filename, '.')), '', basename($filename));

				$foo->file_new_name_body 			= $filebase;
				if($watermark){

					$foo->image_watermark    			= DIR_IMAGE.'watermark/criturk_watermark.png';
					$foo->image_watermark_no_zoom_in 	= false;
				}
				$foo->Process(DIR_IMAGE . $directory . '/');

				if ($foo->processed) {

					$data['file'] = $directory . '/' . $filename;

				} else {

					$data['error'] 	= 'Dosya yüklenemedi.';
				}
			}

		}

		return $data;

	}

}

?>
