<?php 
function create_dir($path){  
	if(!is_dir($path)){
		if(!mkdir($path, 0777)){
			return false;
		}
	}
	return true;
}


function upload_date_path_control($date = false){  
	
	if ( !$date ) $date = date('Y/m/d');
	
	$split_date = explode('/', $date);
	
	$date_path = '';

	foreach($split_date as $sp){
		$date_path .= "$sp/";
		if(!create_dir(DIR_IMAGE . 'upload/' . $date_path)){ 
			return false;
		}
	}	
	
	return true;
	
}


function htmlkarakter($string = false) { 
	
	$string = str_replace(array("&lt;", "&gt;", '&amp;', 'amp;', '&#039;', '&quot;'), array("<", ">",'&', '', '\'','"'), $string); 

	return $string;  
} 



function strUpToLow ($string = '', $upper = false, $ucword = false){   
	
	$lowStr			=	array("ç","ğ","ı","ö","ş","ü"); 		
	$upStr			=	array("Ç","Ğ","I","Ö","Ş","Ü");		
	
	if($upper){
		$string = strtoupper(str_replace($lowStr,$upStr,$string));		
	}else{
		$string = strtolower(str_replace($upStr,$lowStr,$string));		
	}
	return ($ucword ? ucwords($string) : $string);
} 

?>