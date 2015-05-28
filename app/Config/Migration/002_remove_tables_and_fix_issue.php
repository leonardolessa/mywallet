<?php
class RemoveTablesAndFixIssue extends CakeMigration {

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
			'drop_table' => array(
				'savings',
				'goals',
				'goals_movements',
			),
			'alter_field' => array(
				'payments' => array(
					'paid' => array(
						'type' => 'boolean'
					)
				),
				'movements' => array(
					'type' => array(
						'type' => 'boolean'
					)
				)
			)
		)
	);

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function before($direction) {
		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function after($direction) {
		return true;
	}
}
