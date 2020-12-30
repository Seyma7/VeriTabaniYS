<?php

Class ModuleReportBug extends Controller {

	private $report_list = array();

	protected function fetch() {  

		$this->template = 'report_bug.html';

		$this->render();
	}
}
?>
