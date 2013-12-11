<?php
/* Report Fixture generated on: 2011-02-07 16:17:08 : 1297113428 */
class ReportFixture extends CakeTestFixture {
	var $name = 'Report';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'body' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'picture' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'author' => array('type' => 'string', 'null' => false, 'default' => NULL, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'loc_name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'latitude' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'longitude' => array('type' => 'float', 'null' => true, 'default' => NULL),
		'status' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'body' => 'Lorem ipsum dolor sit amet',
			'picture' => 'Lorem ipsum dolor sit amet',
			'author' => 'Lorem ipsum dolor sit amet',
			'loc_name' => 'Lorem ipsum dolor sit amet',
			'latitude' => 1,
			'longitude' => 1,
			'status' => 1,
			'created' => '2011-02-07 16:17:08',
			'modified' => '2011-02-07 16:17:08'
		),
	);
}
?>