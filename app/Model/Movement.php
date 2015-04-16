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
class Movement extends AppModel {

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
		'type' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'O tipo deve ser um número.',
				'required' => true
			)
		),
		'user_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'A movimentação deve ter um usuário.',
				'required' => true
			),
		),
		'category_id' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'A movimentação deve ter uma categoria',
				'required' => true
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Saving' => array(
			'className' => 'Saving',
			'foreignKey' => 'saving_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

/**
 * hasMany associations
 *
 * @var array
 */
	public $hasMany = array(
		'Payment' => array(
			'className' => 'Payment',
			'foreignKey' => 'movement_id',
			'dependent' => true,
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);



// /**
//  * hasAndBelongsToMany associations
//  *
//  * @var array
//  */
// 	public $hasAndBelongsToMany = array(
// 		'Goal' => array(
// 			'className' => 'Goal',
// 			'joinTable' => 'goals_movements',
// 			'foreignKey' => 'movement_id',
// 			'associationForeignKey' => 'goal_id',
// 			'unique' => 'keepExisting',
// 			'conditions' => '',
// 			'fields' => '',
// 			'order' => '',
// 			'limit' => '',
// 			'offset' => '',
// 			'finderQuery' => '',
// 		)
// 	);

// /**
//  * beforeSave callback
//  * CakePHP callback function
//  * @param  array  $options []
//  * @return void
//  */
// 	public function beforeValidate($options = array()) {
// 		$this->fixDataToSave();
// 		$this->fixAmountToSave();
// 	}
//

/**
 * getPayments
 *
 * generic method to get the payments according to the date or sending the current month and year
 * @param  array $request the request received in the controller
 * @return array  return the data retrieving
 */
	public function getPayments($request = null) {
		$date = $this->getDate($request);

		return $this->Payment->find(
			'all',
			array(
				'conditions' => array(
					'Movement.user_id' => CakeSession::read("Auth.User.id"),
					'MONTH(Payment.date)' => $date['month'],
					'YEAR(Payment.date)' => $date['year']
				),
				'order' => array(
					'Payment.date' => 'asc'
				),
				'contain' => array(
					'Movement' => array(
						'fields' => array('description', 'type'),
						'Category' => array(
							'fields' => array('name', 'color')
						)
					),
				)
			)
		);
	}


/**
 * fixAmount
 *
 * remove the amount mask to save in database
 * @param string $[amount] the masked amount
 * @return string amount
 */
	private function fixAmount($amount) {
		return str_replace(
			array(
				'R$',
				',',
				' '
			),
			'',
			$amount
		);
	}


/**
 * fixDate
 *
 * get the BRL date and format to save
 * @param  string $date date coming from datepicker
 * @return string date
 */
	private function fixDate($date) {
		list($d, $m, $y) = preg_split('/\//', $date);
		$newDate = date(sprintf('%4d/%02d/%02d', $y, $m, $d));

		return $newDate;
	}

/**
 * getDate method
 *
 * if receives a date, return the received date, if not, send the current date
 * @param  array $request request from date action controller
 * @return array          return the date that is gonna be used
 */
	public function getDate($request) {
		if(!empty($request)){
			return array(
				'month' => $request['Movement']['month'],
				'year' => $request['Movement']['year'],
			);
		}

		return array(
			'month' => date('m'),
			'year' => date('Y')
		);
	}

/**
 * isOwnedBy method
 * @param  integer  $movement movement id
 * @param  integer  $user     user id
 * @return boolean
 */
	public function isOwnedBy($movement, $user) {
		return $this->field('id', array('id' => $movement, 'user_id' => $user)) == $movement;
	}


/**
 * filterData
 * @param  array $data data received in the add controller
 * @return array $newData treated data to add the payments
 */
	public function filterData($data) {
		$newData = $data;
		$newData['Payment'] = $this->mountPaymentsArray($data['Payment']);
		return $newData;
	}

/**
 * addMonths
 * add the months according to the received parameters
 *
 * @param string $date
 * @param integer $months number of months to add
 */
	private function addMonths($date, $months) {
		return date('Y/m/d', strtotime("+". $months . " months", strtotime($this->fixDate($date))));

	}

/**
 * mountPaymentsArray
 * method responsible for mount the correct array to add multiple payments for a single movement
 * @param  array $paymentData payment data received in the add request
 * @return array $newData
 */
	private function mountPaymentsArray($paymentData) {
		$times = $paymentData['times'];
		unset($paymentData['times'], $paymentData['repeat']);

		$newData = array();

		for ($i = 0; $i <= $times; $i++) {
			$newPayment = $paymentData;
			$newPayment['date'] = $this->addMonths($paymentData['date'], $i);
			$newPayment['amount'] = $this->fixAmount($paymentData['amount']);
			array_push($newData, $newPayment);
		}

		return $newData;
	}

}


