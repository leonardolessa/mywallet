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
				'required' => 'create',
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'This e-mail is already being used',
				'required' => 'create',
			)
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Password cannot be blank',
				'required' => 'create',
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
			->from('appmywallet@gmail.com')
			->viewVars(
				array(
					'token' => $token
				)
			)
			->send();
	}

/**
 * sendResetLink method
 * send a link to the user to a action to reset the password
 * @return [boolean] [sent or not]
 */
	public function sendResetLink() {
		$Email = new CakeEmail('default');
		$Email->template('reset')
			->emailFormat('html')
			->to($this->field('email'))
			->from('appmywallet@gmail.com')
			->viewVars(
				array(
					'token' => $this->field('token')
				)
			)
			->send();

		return true;

	}
}
