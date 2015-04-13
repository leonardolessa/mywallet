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
			// pr($this->data[$this->alias]['amount']);
			// pr($amount);
			// die;
			$this->data[$this->alias]['amount'] = $amount;
		}
		return true;
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
		return true;
	}

/**
 * getDate method
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

}
