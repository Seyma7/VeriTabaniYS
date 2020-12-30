<?php
final class Cache {
	public $expire 		= 3600; 
	private $old_expire	= 0;

  	public function __construct() {
		$files = glob(DIR_CACHE . 'cache.*');

		if ($files) {
			foreach ($files as $file) {
				$time = substr(strrchr($file, '.'), 1);

      			if ($time < time()) {
					if (file_exists($file)) {
						unlink($file);
					}
      			}
    		}
		}
  	}

	public function setExpire ( $time = 0) {

		$this->old_expire = $this->expire;

		$this->expire =(int)$time;

	}

	public function get($key) {
		$files = glob(DIR_CACHE . 'cache.' . $key . '.*');

		if ($files) {
			$cache = file_get_contents($files[0]);
			return unserialize($cache);
		}
	}



  	public function set($key, $value) {
    	$this->delete($key);

		$file = DIR_CACHE . 'cache.' . $key . '.' . (time() + $this->expire);

		$handle = fopen($file, 'w');

    	fwrite($handle, serialize($value));

    	fclose($handle);

		if ( $this->old_expire != 0 ) $this->expire = $this->old_expire;
  	}

  	public function delete($key) {
		$files = glob(DIR_CACHE . 'cache.' . $key . '.*');

		if ($files) {
    		foreach ($files as $file) {
      			if (file_exists($file)) {
					unlink($file);
					clearstatcache();
				}
    		}
		}
  	}
}
?>
