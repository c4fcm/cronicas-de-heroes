<?php
/* Tag Test cases generated on: 2011-03-14 14:32:09 : 1300127529*/
App::import('Model', 'Tag');

class TagTestCase extends CakeTestCase {
	var $fixtures = array('app.tag', 'app.tag_category', 'app.report', 'app.reports_tag');

	function startTest() {
		$this->Tag =& ClassRegistry::init('Tag');
	}

	function endTest() {
		unset($this->Tag);
		ClassRegistry::flush();
	}

}
?>