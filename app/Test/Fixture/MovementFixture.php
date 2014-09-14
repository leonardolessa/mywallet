<?php
/**
 * MovementFixture
 *
 */
class MovementFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false, 'key' => 'primary'),
		'description' => array('type' => 'string', 'null' => true, 'default' => null, 'length' => 100, 'collate' => 'utf8_general_ci', 'charset' => 'utf8'),
		'amount' => array('type' => 'decimal', 'null' => false, 'default' => null, 'length' => '6,2', 'unsigned' => false),
		'type' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 4, 'unsigned' => false),
		'date' => array('type' => 'datetime', 'null' => false, 'default' => null),
		'paid' => array('type' => 'boolean', 'null' => false, 'default' => null),
		'user_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'category_id' => array('type' => 'integer', 'null' => false, 'default' => null, 'unsigned' => false),
		'saving_id' => array('type' => 'integer', 'null' => true, 'default' => null, 'unsigned' => false),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'description' => 'Lorem ipsum dolor sit amet',
			'amount' => '',
			'type' => 1,
			'date' => '2014-09-14 00:36:12',
			'paid' => 1,
			'user_id' => 1,
			'category_id' => 1,
			'saving_id' => 1
		),
	);

}
