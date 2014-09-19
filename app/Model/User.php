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
		'name' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Por favor, preencha seu nome.',
				'required' => true
			)
		)
		'email' => array(
			'email' => array(
				'rule' => array('email'),
				'message' => 'Esse não é um e-mail válido.',
				'required' => 'create',
			),
			'unique' => array(
				'rule' => 'isUnique',
				'message' => 'Esse e-mail já está sendo usado.',
				'required' => 'create',
			)
		),
		'password' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				'message' => 'Por favor, preencha o campo de senha.',
				'required' => 'create',
			),
		),
		'oldPassword' => array(
			'rule' => 'matchPassword',
			'message' => 'A senha atual está errada.'
		),
		'newPassword' => array(
			'rule' => array('checkOldPassword', 'oldPassword'),
			'message' => 'Preencha a senha antiga para alterá-la.'
		)
	);
/**
 * matchPassword validation
 * @param  [array] $data [data from request]
 * @return [boolean] [if matches or not]
 */
	public function matchPassword($oldPassword) {
		$this->id = AuthComponent::user('id');
		if(!empty($oldPassword['oldPassword'])) {
			return (AuthComponent::password($oldPassword['oldPassword']) == $this->field('password'));	
		}
		return true;
	}

/**
 * checkOldPassword
 * @param  [array] $data [data from request]
 * @return [boolean] [if the old password isset]
 */
	public function checkOldPassword($newPassword, $check) {
		if(!empty($newPassword['newPassword'])) {
			return !empty($this->data[$this->alias][$check]);
		}
		return true;
	}

/**
 * beforeSave method
 * @param  array  $options
 * @return void
 */
	public function beforeSave($options = array()) {
		$this->setPassword();
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
 * setPassword method
 * set the new password to the password to change in edit action
 * @return void
 */
	private function setPassword() {
		if(isset($this->data[$this->alias]['newPassword'])) {
			$this->data[$this->alias]['password'] = $this->data[$this->alias]['newPassword'];
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

		return true;
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
