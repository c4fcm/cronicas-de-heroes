<?php
/* ReportsTag Test cases generated on: 2011-03-14 14:07:18 : 1300126038*/
App::import('Model', 'ReportsTag');

class ReportsTagTestCase extends CakeTestCase {
	var $fixtures = array('app.reports_tag', 'app.report', 'app.tag');

	function startTest() {
		$this->ReportsTag =& ClassRegistry::init('ReportsTag');
	}

	function endTest() {
		unset($this->ReportsTag);
		ClassRegistry::flush();
	}

}
?>