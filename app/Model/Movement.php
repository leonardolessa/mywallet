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
		'type' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'O tipo deve ser um número.',
				'required' => true
			)
		),
		'date' => array(
			'datetime' => array(
				'rule' => array('datetime'),
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
		'user_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'O campo de relacionamento deverá ser numérico.',
				'required' => true
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'A movimentação deve ter um usuário.',
				'required' => true
			),
		),
		'category_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'O formato da categoria da movimentação está errado.',
				'required' => true
			),
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Toda movimentação deverá ter uma categoria',
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
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
		'Goal' => array(
			'className' => 'Goal',
			'joinTable' => 'goals_movements',
			'foreignKey' => 'movement_id',
			'associationForeignKey' => 'goal_id',
			'unique' => 'keepExisting',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'finderQuery' => '',
		)
	);

}
