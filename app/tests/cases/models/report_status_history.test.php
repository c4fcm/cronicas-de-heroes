<?php
/* ReportStatusHistory Test cases generated on: 2011-02-08 16:42:34 : 1297201354*/
App::import('Model', 'ReportStatusHistory');

class ReportStatusHistoryTestCase extends CakeTestCase {
	var $fixtures = array('app.report_status_history', 'app.report', 'app.user');

	function startTest() {
		$this->ReportStatusHistory =& ClassRegistry::init('ReportStatusHistory');
	}

	function endTest() {
		unset($this->ReportStatusHistory);
		ClassRegistry::flush();
	}

}
?>