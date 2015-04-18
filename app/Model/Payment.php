<?php
App::uses('AppModel', 'Model');
/**
 * Movement Model
 *
 * @property User $User
 * @property Category $Category
 * @property Saving $Saving
 * @property Goal $Goal
 */
class Payment extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'description';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'amount' => array(
			'money' => array(
				'rule' => array('money'),
				'message' => 'O valor está no formato errado.',
				'required' => true
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Por favor, preencha o campo de valor.',
				'required' => true
			),
		),
		'date' => array(
			'date' => array(
				'rule' => array('date'),
				'message' => 'A data está no formato errado.',
				'required' => true
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'O campo data é obrigatório.',
				'required' => true
			),
		),
		'paid' => array(
			'boolean' => array(
				'rule' => array('boolean'),
				'message' => 'O formato do campo pago está errado.',
				'required' => true
			),
		),
		'movement_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'O pagamento faz parte de uma movimentação.',
				'required' => true
			),
		)
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'Movement' => array(
			'className' => 'Movement',
			'foreignKey' => 'movement_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * beforeSave callback
 * CakePHP callback function
 * @param  array  $options []
 * @return void
 */
	public function beforeValidate($options = array()) {
		$this->fixDataToSave();
		$this->fixAmountToSave();
	}

/**
 * fixAmountToSave method
 * fix the date that comes from client-side to save in database
 * @return void
 */
	public function fixAmountToSave() {
		if(isset($this->data[$this->alias]['amount'])) {
			$amount = $this->data[$this->alias]['amount'];
			$amount = str_replace(
				array(
					'R$',
					',',
					' '
				),
				'',
				$amount
			);
			$this->data[$this->alias]['amount'] = $amount;
		}
	}

/**
 * fixDataToSave method
 * fix BRL date to insert in the database
 * @return void
 */
	private function fixDataToSave() {
		if(isset($this->data[$this->alias]['date'])) {
			$originalDate = $this->data[$this->alias]['date'];
			list($d, $m, $y) = preg_split('/\//', $originalDate);
			$newDate = sprintf('%4d/%02d/%02d', $y, $m, $d);

			$this->data[$this->alias]['date'] = $newDate;
		}
	}

/**
 * afterFind callback
 * @param  array $results
 * @param  boolean $primary [if the query is from the origin model]
 * @return array results
 */
	public function afterFind($results, $primary = false) {
		foreach ($results as $key => $value) {
			if(isset($value[$this->alias]['date'])) {
				$results[$key][$this->alias]['date'] = $this->changeDateToShow($results[$key][$this->alias]['date']);
			}
		}
		return $results;
	}


/**
 * changeDateToShow method
 * @param  string $date date that comes from afterFind callback
 * @return string formated date
 */
	public function changeDateToShow($date) {
		return date("d/m/Y", strtotime($date));
	}
}
