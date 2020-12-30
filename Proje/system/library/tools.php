<?php
Class Tools{

	public function strlen($value = false){ 
		if(!$value || empty(trim($value))) return 0;
		return mb_strlen($value, 'UTF-8');
	}

	public function getIP(){

		if(getenv("HTTP_CLIENT_IP")) {

			$ip = getenv("HTTP_CLIENT_IP");

		} else if(getenv("HTTP_X_FORWARDED_FOR")) {

			$ip = getenv("HTTP_X_FORWARDED_FOR");

				if (strstr($ip, ',')) {

				$tmp = explode (',', $ip);

				$ip = trim($tmp[0]);
			}
		} else {

			$ip = getenv("REMOTE_ADDR");
		}

		return $ip;
	}


	function randomstr($length) {
		$char="0123456789abcdefghijklmnopq_-rstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		$output="";
		while(strlen($output) < $length) {
			$output .= substr($char, (rand() % strlen($char)), 1);
		}
		return($output);
	}

	function apiSecure($decode = FALSE, $timestap = FALSE){
		if($decode){
			$string =  base64_decode($timestap);
			$output = '';
			for($i = 1; $i <= 10; $i++){
				$output .= substr($string, ((16 * $i) - 1), 1);
			}
			return $output;
		}
		else{
			return base64_encode(vsprintf(wordwrap($this->createString(151), 15, '%s', true), str_split(time())));
		}
	}

	function just_clean_chars($string)
	{
		// Replace other special chars
		$specialCharacters = array(
			'#' => '',
			'$' => '',
			'%' => '',
			'&' => '',
			'@' => '',
			'.' => '',
			'?' => '',
			'+' => '',
			'=' => '',
			'?' => '',
			'\/'=> '',
			'/' => '',
			'ğ'	=> 'g',
			'Ğ'	=> 'g',
			'ı'	=> 'i',
			'İ'	=> 'i',
			'ü'	=> 'u',
			'Ü'	=> 'u',
			'ş'	=> 's',
			'Ş'	=> 's',
			'ö'	=> 'o',
			'Ö'	=> 'o',
			'ç'	=> 'c',
			'Ç'	=> 'c'
		);

		while (list($character, $replacement) = each($specialCharacters)) {
		$string = str_replace($character, $replacement, $string);
		}

		$string = strtr($string,
		"??????? ??????????????????????????????????????????????",
		"AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn"
		);

		$string = preg_replace('/[^a-zA-Z0-9-]/', ' ', $string);
		$string = preg_replace('/^[-]+/', '', $string);
		$string = preg_replace('/[-]+$/', '', $string);
		$string = preg_replace('/[-]{2,}/', ' ', $string);

		return $string;
	}

	function pagination($url,$p,$num,$limit) {
		$nav = "";
		if($num > $limit){

	     	$p			= (int) $p;
	      	$total_page = ceil($num / $limit);
	        $tpl_on 	= "<li><a href=\"".$url."\">".$p."</a></li>";
			$tpl_off 	= "<li><a href=\"".$url."\">{t}</a></li> ";

			$pages 		= array ($p-3,$p-2,$p-1,$p,$p+1,$p+2,$p+3);
			$pages 		= array_unique($pages);
			//
			$nav .= "<div class=\"pagination\"><ul>";

			if($total_page > 1 && $p != 1)
				$nav .= str_replace("{t}", "İlk", str_replace("{s}", 1, $tpl_off));

			if($p > 1)
				$nav .= str_replace("{t}", "<", str_replace("{s}", ($p-1), $tpl_off));

			while(list($key,$val) = each($pages))
			{
				if($val >= 1 && $val <= $total_page)
				{
					if($p == $val)
						$nav .= str_replace(array("{s}", "{t}"), $val, $tpl_on);
					else
						$nav .= str_replace(array("{s}", "{t}"), $val, $tpl_off);
				}
			}

			if($p < $total_page)
				$nav .= str_replace("{t}", ">", str_replace("{s}", ($p+1), $tpl_off));

			if($total_page > 1 && $p != $total_page)
				$nav .= str_replace("{t}", "Son", str_replace("{s}", $total_page, $tpl_off));

			$nav	.= "</ul></div>";
 		}
   		return $nav;
	}

}
?>
