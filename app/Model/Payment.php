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
}
