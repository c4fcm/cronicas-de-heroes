<?php
/* TagCategory Test cases generated on: 2011-03-14 16:14:21 : 1300133661*/
App::import('Model', 'TagCategory');

class TagCategoryTestCase extends CakeTestCase {
	var $fixtures = array('app.tag_category', 'app.tag', 'app.report', 'app.reports_tag');

	function startTest() {
		$this->TagCategory =& ClassRegistry::init('TagCategory');
	}

	function endTest() {
		unset($this->TagCategory);
		ClassRegistry::flush();
	}

}
?>