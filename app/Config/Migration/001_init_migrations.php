<?php
App::uses('BaseMigration', 'Lib/Migrations');

class InitMigration extends BaseMigration {

/**
 * Migration description
 *
 * @var string
 */
	public $description = '';

/**
 * Actions to be performed
 *
 * @var array $migration
 */
	public $migration = array(
		'up' => array(
			'create_table' => array(
				'users' => array(
					'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => null,
						'key' => 'primary',
						'collate' => null,
					),
					'email' => array(
						'type' => 'string',
						'length' => 50,
						'null' => false
					),
					'name' => array(
						'type' => 'string',
						'length' => 50,
						'null' => false
					),
					'password' => array(
						'type' => 'string',
						'length' => 40,
						'null' => false
					),
					'token'	=> array(
						'type' => 'string',
						'length' => 32,
						'null' => true,
						'default' => null
					),
					'status' => array(
						'type' => 'integer',
						'length' => 4,
						'null' => true,
						'default' => null
					),
					'image' => array(
						'type' => 'string',
						'length' => 255,
						'null' => true,
						'default' => null
					),
					'created' => array(
						'type' => 'datetime',
						'null' => true,
						'default' => null,
					),
					'updated' => array(
						'type' => 'datetime',
						'null' => true,
						'default' => null,
					),
				),
				'categories' => array(
					'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => null,
						'key' => 'primary',
						'collate' => null,
					),
					'name' => array(
						'type' => 'string',
						'length' => 30,
						'null' => false
					),
					'color' => array(
						'type' => 'string',
						'length' => 6,
						'null' => false
					),
					'user_id' => array(
						'type' => 'integer',
						'null' => false,
					),
					'indexes' => array(
						 'PRIMARY' => array('column' => 'id', 'unique' => 1)
					)
				),
				'savings' => array(
					'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => null,
						'key' => 'primary',
						'collate' => null,
					),
					'description' => array(
						'type' => 'string',
						'length' => 100,
						'null' => true,
						'default' => null,
					),
					'amount' => array(
						'type' => 'decimal',
						'length' => '10,2',
						'null' => true,
						'default' => null,
					),
					'date' => array(
						'type' => 'datetime',
						'null' => true,
						'default' => null,
					),
					'user_id' => array(
						'type' => 'integer',
						'null' => false,
					),
				),
				'goals' => array(
					'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => null,
						'key' => 'primary',
						'collate' => null,
					),
					'description' => array(
						'type' => 'string',
						'length' => 100,
						'null' => true,
						'default' => null,
					),
					'date' => array(
						'type' => 'datetime',
						'null' => true,
						'default' => null,
					),
					'type' => array(
						'type' => 'integer',
						'length' => 1,
						'null' => true,
						'default' => '0'
					),
					'amount' => array(
						'type' => 'decimal',
						'length' => '10,2',
						'null' => true,
						'default' => null,
					),
					'user_id' => array(
						'type' => 'integer',
						'null' => false,
					),
				),
				'movements' => array(
					'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => null,
						'key' => 'primary',
						'collate' => null,
					),
					'description' => array(
						'type' => 'string',
						'length' => 100,
						'null' => true,
						'default' => null,
					),
					'amount' => array(
						'type' => 'decimal',
						'length' => '10,2',
						'null' => true,
						'default' => null,
					),
					'type' => array(
						'type' => 'integer',
						'length' => 1,
						'null' => true,
						'default' => '0'
					),
					'date' => array(
						'type' => 'datetime',
						'null' => true,
						'default' => null,
					),
					'paid' => array(
						'type' => 'integer',
						'length' => 1,
						'null' => true,
						'default' => null
					),
					'user_id' => array(
						'type' => 'integer',
						'null' => false,
					),
					'category_id' => array(
						'type' => 'integer',
						'null' => false,
					),
					'saving_id' => array(
						'type' => 'integer',
						'null' => true,
						'default' => null,
					),
				),
				'goals_movements' => array(
					'id' => array(
						'type' => 'integer',
						'null' => false,
						'default' => null,
						'key' => 'primary',
						'collate' => null,
					),
					'goal_id' => array(
						'type' => 'integer',
						'null' => false
					),
					'movement_id' => array(
						'type' => 'integer',
						'null' => false
					)
				)
			)
		),
		'down' => array(
			'drop_table' => array(
				'categories',
				'users',
				'savings',
				'goals',
				'movements',
				'goals_movements',
			)
		),
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function before($direction) {
		parent::before($direction);

		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function after($direction) {
		parent::after($direction);

		return true;
	}
}
