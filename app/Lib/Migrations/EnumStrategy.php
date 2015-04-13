<?php
App::uses('StrategyInterface', 'Lib/Migrations');

class EnumStrategy implements StrategyInterface {
	public function getAlterTableSql($table, $column, $options) {
		$values = $options[$column]['length'];
		$values = implode("','", $values);
		$values = "'{$values}'";

		$sql = "ALTER TABLE {$table} ADD COLUMN `{$column}` ENUM({$values})";

		if (isset($options[$column]['default'])) {
			$defaultValue = $options[$column]['default'];
			$sql .= " DEFAULT '{$defaultValue}'";
		}

		return $sql;
	}
}
