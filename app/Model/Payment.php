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
 * Normalize date flag, to use on afterFind callback
 * @var boolean
 */
	public $normalizeDate = true;

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
		if ($this->normalizeDate) {
			foreach ($results as $key => $value) {
				if(isset($value[$this->alias]['date'])) {
					$results[$key][$this->alias]['date'] = $this->changeDateToShow($results[$key][$this->alias]['date']);
				}
			}
			return $results;
		}
	}


/**
 * changeDateToShow method
 * @param  string $date date that comes from afterFind callback
 * @return string formated date
 */
	public function changeDateToShow($date) {
		return date("d/m/Y", strtotime($date));
	}



	/**
	 * method ugly as my face
	 * IGNORE IT
	 */
	public function getReport($id = null) {
		$date = new DateTime('now');
		$data = array();

		$c = 0;

		for ($months = 0; $months < 12; $months++) {
			if ($id != null) {
				$expensesConditions = array(
					'MONTH(Payment.date)' => $date->format('m'),
					'YEAR(Payment.date)' => $date->format('Y'),
					'Payment.paid' => true,
					'Movement.type' => 0,
					'Movement.category_id' => $id,
				);

				$incomingConditions = array(
					'MONTH(Payment.date)' => $date->format('m'),
					'YEAR(Payment.date)' => $date->format('Y'),
					'Payment.paid' => true,
					'Movement.type' => 1,
					'Movement.category_id' => $id,
				);
			} else {
				$expensesConditions = array(
					'MONTH(Payment.date)' => $date->format('m'),
					'YEAR(Payment.date)' => $date->format('Y'),
					'Payment.paid' => true,
					'Movement.type' => 0
				);

				$incomingConditions = array(
					'MONTH(Payment.date)' => $date->format('m'),
					'YEAR(Payment.date)' => $date->format('Y'),
					'Payment.paid' => true,
					'Movement.type' => 1
				);
			}

			$expenses = $this->find(
				'first',
				array(
					'conditions' =>$expensesConditions,
					'fields' => array(
						'SUM(Payment.amount) as expenses'
					),
					'recursive' => 1
				)
			);

			$incoming = $this->find(
				'first',
				array(
					'conditions' => $incomingConditions,
					'fields' => array(
						'SUM(Payment.amount) as incoming'
					),
					'recursive' => 1
				)
			);

			if ($expenses[0]['expenses'] != null || $incoming[0]['incoming'] != null) {
				$data[$c] = array(
					'expenses' => $expenses[0]['expenses'] ? $expenses[0]['expenses'] : 0,
					'incoming' => $incoming[0]['incoming'] ? $incoming[0]['incoming'] : 0,
					'balance' => number_format($incoming[0]['incoming'] - $expenses[0]['expenses'], 2),
 					'date' => $date->format('Y-m')
				);
				$c++;
			}

			$date->modify('-1 month');
		}

		return $data;
	}
}
