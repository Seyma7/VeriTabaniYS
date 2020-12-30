<?php
final class Weather {

		private $data 						=		array();
		private $weatherCodes			=		array("istanbul","ankara");
		private $weatherNames			=		array("İstanbul","Ankara");
		private $weatherApiKey 		=		'd84ce5f42120f38f394bf9ec5be07893'; // http://openweathermap.org/ Api
		private $cache;

		public function __construct($registry){

				$this->cache 					= 	$registry->get('cache');

			}

			public function getWeather(){

				$weatherData 					= 	$this->cache->get('weather');

				if (!$weatherData) {

					$weatherData 				=		$this->setWeather();

					$this->cache->setExpire(900);
					$this->cache->set('weather', $weatherData);

				}

				$this->data				=		$weatherData;
				return ( isset($this->data) ? $this->data : false);

			}


			public function setWeather(){

				$weatherData = false;

				foreach ($this->weatherCodes as $value) {

						$weatherData[$value]			=		$this->getCurlWeather($value);
				}

				return $weatherData;

			}

		private function getCurlWeather($location = false){

				$data 			= array();
				if(!$location) return false;

				//http://api.openweathermap.org/data/2.5/forecast/weather?q=istanbul&units=metric&APPID=d84ce5f42120f38f394bf9ec5be07893
				$url 				= "http://api.openweathermap.org/data/2.5/forecast/weather?q=".$location."&units=metric&APPID=".$this->weatherApiKey;

				// Make call with cURL
				$session = curl_init($url);
				curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
				$json = curl_exec($session);
				// Convert JSON to PHP object
				$phpObj =  json_decode($json);

				if($phpObj->cod != 200) return false;

				// SSL ' DEN DOLAYI FARKLI URL DEN RESİM ÇEKMEK YERİNE SUNUCUYA UPLOAD YAP.'
				$imageName  =    $phpObj->list[0]->weather[0]->icon . ".png";
				$imageUrl 	=	   "http://openweathermap.org/img/w/" . $imageName;

				if(!file_exists( DIR_IMAGE. 'weather/'. $imageName )){
					copy($imageUrl, DIR_IMAGE. 'weather/'. $imageName);
				}

				$data		=	array(
							'name'		=>	  str_replace($this->weatherCodes, $this->weatherNames,$location),
							'pubDate'	=>		$phpObj->list[0]->dt_txt,
							'imgCode'	=>		$phpObj->list[0]->weather[0]->icon,
							'image'		=>		HTTP_IMAGE.'weather/'.$imageName,
							'tempF'		=>		round(($phpObj->list[0]->main->temp)*9/5+32),
							'tempC'		=>		$phpObj->list[0]->main->temp,

				);

				return $data;

		}


/*
		private function _getCurlWeather($location = false){

				$data 	= array();
				if(!$location) return false;

				$BASE_URL 				= "https://query.yahooapis.com/v1/public/yql";
				$yql_query 				=	'select * from weather.forecast where woeid in (select woeid from geo.places(1) where text="'.$location.'")';
				$yql_query_url 		= $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";

				// Make call with cURL
				$session = curl_init($yql_query_url);
				curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
				$json = curl_exec($session);
				// Convert JSON to PHP object
			  $phpObj =  json_decode($json);

				if(!$phpObj->query->results) return false;

					// SSL ' DEN DOLAYI FARKLI URL DEN RESİM ÇEKMEK YERİNE SUNUCUYA UPLOAD YAP.'
					$imageName  =    $phpObj->query->results->channel->item->condition->code . ".gif";
					$imageUrl 	=	   "http://l.yimg.com/a/i/us/we/52/" . $imageName;
					copy($imageUrl, DIR_IMAGE. 'weather/'. $imageName);

					$data		=	array(
								'name'		=>	  str_replace($this->weatherCodes, $this->weatherNames,$location),
								'pubDate'	=>		$phpObj->query->results->channel->item->pubDate,
								'imgCode'	=>		$phpObj->query->results->channel->item->condition->code,
								'image'		=>		HTTP_IMAGE.'weather/'.$imageName,
								'tempF'		=>		$phpObj->query->results->channel->item->condition->temp,
								'tempC'		=>		round(($phpObj->query->results->channel->item->condition->temp - 32)*5/9),

					);

					return $data;


		}
*/
}
?>
