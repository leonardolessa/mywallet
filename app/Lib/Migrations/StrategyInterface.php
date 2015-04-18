<?php

interface StrategyInterface {
	public function getAlterTableSql($table, $column, $options);
}
