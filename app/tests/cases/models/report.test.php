<?php
/* Report Test cases generated on: 2011-02-07 16:17:08 : 1297113428*/
App::import('Model', 'Report');

class ReportTestCase extends CakeTestCase {
	var $fixtures = array('app.report');

	function startTest() {
		$this->Report =& ClassRegistry::init('Report');
	}

	function endTest() {
		unset($this->Report);
		ClassRegistry::flush();
	}

}
?>