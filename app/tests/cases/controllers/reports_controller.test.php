<?php
/* Reports Test cases generated on: 2011-02-07 16:17:14 : 1297113434*/
App::import('Controller', 'Reports');

class TestReportsController extends ReportsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ReportsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.report', 'app.user');

	function startTest() {
		$this->Reports =& new TestReportsController();
		$this->Reports->constructClasses();
	}

	function endTest() {
		unset($this->Reports);
		ClassRegistry::flush();
	}

}
?>