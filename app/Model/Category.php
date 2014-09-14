<?php 
App::uses('AppModel', 'Model');


/**
 * Category model
 * 
 */
class Category extends AppModel {

/**
 * Display field
 * 
 * @var string
 */
	public $displayField = 'name';

/**
 * belongsTo association
 * 
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id'
		)
	);

/**
 * hasMany association
 * 
 * @var array
 */
	public $hasMany = array(
		'Movement' => array(
			'className' => 'Movement',
			'foreignKey' => 'category_id',
			'dependent' => true
		)
	);


/**
 * Validate options
 * 
 * @var array
 */
	public $validate = array(
		'name' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Password field cannot be left blank',
				'required' => true
			)
		),
		'color' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'Color field cannot be left blank',
				'required' => true
			),
			'maxLength' => array(
				'rule' => array('maxLength', 6),
				'message' => 'This field\'s limit is 6 characters',
				'required' => true
			),
		),
		'user_id' => array(
			'notEmpty' => array(
				'rule' => 'notEmpty',
				'message' => 'The category must have an user'
			)
		)
	);

	public function isOwnedBy($category, $user) {
		return $this->field('id', array('id' => $category, 'user_id' => $user)) == $category;
	}
}