<?php
final class Datetimes {

	private $years 		= array();
	private $month 		= array();
	private $monthNo	= array();
	private $monthEng	= array('January','February','March','April','May','June','July','August','September','October','November','December');
	private $monthTr	= array('Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık');

	function __construct() {

		for($i = 1; $i <= 12; $i++){

			$name = ($i < 10 ? "$i" : $i);

			$this->month[$i] = array(
				'name' 	=> str_replace($this->monthEng,	$this->monthTr,	date("F", mktime(0, 0, 0, 1 + $i, 0, 0))),
				'value'	=> $name
			);

			$this->monthNo[]	=	$i;
		}
	}


	public function getMonth(){

		return $this->month;
	}

	public function getMonthName($postMonth = false, $changeLang = false){

		if( !$postMonth || $postMonth < 1 || $postMonth > 12 ) return false;
		return str_replace($this->monthNo, ( !$changeLang ? $this->monthTr : $this->monthEng) ,(int)$postMonth);
	}


	public function getMonthFull($changeLang = false){

		for($i = 1; $i<= 12; $i++){

			$this->month[$i]['name']	=	($i < 10 ? "0$i" : $i) . " " . ( !$changeLang ? $this->month[$i]['name'] : str_replace($this->monthTr, $this->monthEng, $this->month[$i]['name']));
		}

		return $this->month;
	}


	public function getYears($limit = 20, $type = false){

		if( !(int)$limit ) return false;


		if($type){	//	belirtilen limit kadar yıl ekle

			for($i 	=	date('Y',time());	$i <=	date('Y', strtotime(date('Y') . ' + '. (int)$limit .' years'));		$i++){

				$this->years[$i]	=	$i;
			}

		}else{

			for($i = date('Y', strtotime(date('Y') . ' - '. (int)$limit .' years')); 	$i >= 1940; 	$i--){

				$this->years[$i]	=	$i;
			}

		}

		return $this->years;
	}

	public function convertDatetime($dateSchema = false, $datetime = false){

		if(!$dateSchema && !$datetime) return $this->getDatetime();
		return strftime($dateSchema, strtotime( $datetime ));
	}

	public function getDatetime($dayNumbers = false) {

		if( !$dayNumbers )	return strftime('%Y-%m-%d %H:%M:%S');
		return strftime('%Y-%m-%d %A %H:%I');
	}
}
?>
