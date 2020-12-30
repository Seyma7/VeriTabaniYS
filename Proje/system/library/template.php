<?php
require DIR_SYSTEM . 'library/external/smarty/Smarty.class.php';

Class template extends Smarty{
	var $data = array();
	function template(){
		$this->template_dir = DIR_VIEW;
		$this->compile_dir 	= DIR_VIEW . 'tmp/';
		$this->plugins_dir 	= DIR_SYSTEM . 'library/external/smarty/plugins/';
	}

  	function set($key, $value = NULL) {
    	if (!is_array($key)) {
      		$this->data[$key] = $value;
    	} else {
	  		$this->data = array_merge($this->data, $key);
		}
  	}
}

?>