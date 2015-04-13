<?php

class BaseMigration extends CakeMigration {

/**
 * Hold temporarily all columns that Cake do not give support to be created later.
 *
 * @var array
 */
	public $notSupportedColumns = array();

/**
 * Iterate in Lib/Migrations searching for all files ending into Strategy.php
 * and store the prefix of the file in an array.
 *
 * @return array
 */
	private function getAvailableStrategies() {
		$availableStrategies = array();
		$path = APP . 'Lib' . DS . 'Migrations' . DS;
		foreach (new \DirectoryIterator($path) as $info) {
 			if ($info->isDot()) {
 				continue;
 			}

 			if (preg_match('/Strategy\.php/', $info->getBasename())) {
 				$type = str_replace('Strategy.php', '', $info->getBasename());
 				$availableStrategies[] = strtolower($type);
 			}
		}

		return $availableStrategies;
	}

/**
 * Before migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function before($direction) {
		$strategies = $this->getAvailableStrategies();

		foreach ($this->migration['up']['create_table'] as $tableName => $tableInfo) {
			foreach ($tableInfo as $columnName => $columnInfo) {
				if (isset($columnInfo['type']) && in_array($columnInfo['type'], $strategies)) {
					$this->notSupportedColumns[$tableName][$columnName] = $columnInfo;
					unset($this->migration['up']['create_table'][$tableName][$columnName]);
				}
			}
		}

		return true;
	}

/**
 * After migration callback
 *
 * @param string $direction, up or down direction of migration process
 * @return boolean Should process continue
 */
	public function after($direction) {
		foreach ($this->notSupportedColumns as $tableName => $columnInfo) {
			$keys = array_keys($columnInfo);
			$columnName = $keys[0];

			$type = $columnInfo[$columnName]['type'];
			$strategyClass = ucfirst($type) . 'Strategy';

			App::uses($strategyClass, 'Lib/Migrations');
			if (!class_exists($strategyClass)) {
				throw new RuntimeException(
					sprintf('The strategy class %s was not found in Lib/Migrations', $strategyClass)
				);
			}

			$strategy = new $strategyClass;
			$sql = $strategy->getAlterTableSql($tableName, $columnName, $columnInfo);


			$this->db->execute($sql);
		}

		return true;
	}

}
