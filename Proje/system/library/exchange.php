<?php
final class Exchange {

		private $data 						=		array();
		private $currencyCodes		=		array("xu100","kusd","keur","cumhr");
		private $currencyNames		=		array("BİST","DOLAR","EURO","ALTIN");
		private $cache;

		public function __construct($registry){

			$this->cache 					= $registry->get('cache');
		}

		public function getExchange(){

			$exchangeData 					= 	$this->cache->get('exchange');

			if (!$exchangeData) {

				$exchangeData 				=		$this->setExchange(); 

				$this->cache->setExpire(1800);
				$this->cache->set('exchange', $exchangeData);

			}

			$this->data				=		$exchangeData;
			return ( isset($this->data) ? $this->data : false);

		}


		public function getCurrency( $currencyCode = false ){

				$currencyCode		=		( isset($currencyCode) ? mb_strtolower($currencyCode, 'UTF-8') : false	);
				return ( ($currencyCode && isset($this->data[$currencyCode]) ) ? $this->data[$currencyCode] : false );
		}


		public function setExchange(){

			$open 								= 	simplexml_load_file('http://realtime.paragaranti.com/asp/xml/icpiyasa.asp');

			foreach($open->STOCK as $exc){

				 $currencyCode			=		mb_strtolower($exc->SYMBOL, 'UTF-8');

				 if( in_array( $currencyCode , $this->currencyCodes)  ){

							 $exchangeData[$currencyCode]	=	array(
										 'name'										=>    str_replace($this->currencyCodes,$this->currencyNames,$currencyCode),
										 'desc'										=>		(string)($exc->DESC),  // xml ile gelen datayı noktalı sayıya çevir
										 'last'										=>		(string)($exc->LAST),	// aksi takdirde json'a kayıt yapılmıyor.
										 'pernc'									=>		(string)($exc->PERNC_NUMBER),
										 'last_mod'								=>		(string)($exc->LAST_MOD)
							 );
				 }
			}

			return $exchangeData;
	}


		/*
		private function setExchange(){

			$open 								= 	simplexml_load_file('http://www.tcmb.gov.tr/kurlar/today.xml');

			foreach($open->Currency as $exc){

				 $currencyCode			=		mb_strtolower($exc[0]['CurrencyCode'], 'UTF-8');

				 if( in_array( $currencyCode , $this->currencyCodes)  ){

							 $this->data[$currencyCode]	=	array(
										 'name'										=>    str_replace($this->currencyCodes,$this->currencyNames,$currencyCode),
										 'forexBuying'						=>		(string)($exc->ForexBuying),  // xml ile gelen datayı noktalı sayıya çevir
										 'forexSelling'						=>		(string)($exc->ForexSelling),	// aksi takdirde json'a kayıt yapılmıyor.
										 //'BanknoteBuying'					=>		(string)($exc->BanknoteBuying),
										 //'BanknoteSelling'				=>		(string)($exc->BanknoteSelling)
							 );
				 }
			}

			if( isset($this->data) ) $this->data['date']	=		(string)($open[0]['Date']);
			return $this->data;
	}*/
}
?>
