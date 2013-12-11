<?php
/* ReportsTag Fixture generated on: 2011-03-14 14:07:18 : 1300126038 */
class ReportsTagFixture extends CakeTestFixture {
	var $name = 'ReportsTag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'tag_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'report_id' => 1,
			'tag_id' => 1,
			'created' => '2011-03-14 14:07:18',
			'modified' => '2011-03-14 14:07:18'
		),
	);
}
?>