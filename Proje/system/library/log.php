<?php
final class Log {
	private $filename;
	
	public function __construct($filename, $registry = false) {
		$this->filename = $filename;
		$this->registry = $registry;

		if(!file_exists(DIR_LOGS . $this->filename)){
			$handle = @fopen(DIR_LOGS . $this->filename, 'a+');
			if($handle){
				fclose($handle);
			}
		}

		if(!is_writable(DIR_LOGS . $this->filename)){
			$this->write(DIR_LOGS . $this->filename . ' dosyasi yazilabilir degil.');
			_set_error(DIR_LOGS . $this->filename . ' dosyasi yazilabilir degil.');
		}
		
	}
	
	public function write($message) {
	
		$message = date('Y-m-d H:i:s') . ' - ' . $message . "\n";
	
		if(is_writable(DIR_LOGS . $this->filename)){
			$file = DIR_LOGS . $this->filename;
			
			$handle = fopen($file, 'a+'); 
			
			fwrite($handle, $message);
				
			fclose($handle); 
		}
		
	}
}
?>