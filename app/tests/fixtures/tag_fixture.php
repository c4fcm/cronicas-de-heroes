<?php
/* Tag Fixture generated on: 2011-03-14 14:32:09 : 1300127529 */
class TagFixture extends CakeTestFixture {
	var $name = 'Tag';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'length' => 10, 'key' => 'primary'),
		'tag_category_id' => array('type' => 'integer', 'null' => false, 'default' => NULL),
		'name' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 200, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array()
	);

	var $records = array(
		array(
			'id' => 1,
			'tag_category_id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'created' => '2011-03-14 14:32:09',
			'modified' => '2011-03-14 14:32:09'
		),
	);
}
?>