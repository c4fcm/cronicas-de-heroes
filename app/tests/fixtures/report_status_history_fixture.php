<?php
/* ReportStatusHistory Fixture generated on: 2011-02-08 16:42:34 : 1297201354 */
class ReportStatusHistoryFixture extends CakeTestFixture {
	var $name = 'ReportStatusHistory';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'report_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'status' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'time' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'report_id' => 1,
			'status' => 1,
			'user_id' => 1,
			'time' => '2011-02-08 16:42:34',
			'created' => '2011-02-08 16:42:34',
			'modified' => '2011-02-08 16:42:34'
		),
	);
}
?>