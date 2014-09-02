<?php
App::uses('AppModel', 'Model');
App::uses('CakeEmail', 'Network/Email');
/**
 * User Model
 *
 */
class User extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * hasMany associations
 * 
 * @var array
 */
	public $hasMany = array(
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'user_id',
			'dependent' => 'false'
		)
	);


/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'This is not a valid e-mail',
				'required' => true,
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'This e-mail is already being used',
				'required' => true,
			)
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Password cannot be blank',
				'required' => true,
			),
		)
	);

/**
 * beforeSave method
 * @param  array  $options
 * @return void
 */
	public function beforeSave($options = array()) {
		$this->hashPassword();
	}

/**
 * hashPassword method
 * hashes the password to sha1
 * @return void
 */
	private function hashPassword() {
		if(isset($this->data[$this->alias]['password'])) {
			$this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
		}
	}

/**
 * generateToken method
 * @return void
 */
	public function generateToken() {
		return md5(uniqid(rand(), true));
	}

/**
 * sendActivationLink method
 * send an activation link to the user email
 * @return void
 */
	public function sendActivationLink($token) {
		$Email = new CakeEmail('default');
		$Email->template('activation')
			->emailFormat('html')
			->to($this->field('email'))
			->from('appmywallet@gmail.com');

		$Email->viewVars(
			array(
				'token' => $token
			)
		);

		$Email->send();
	}
}
