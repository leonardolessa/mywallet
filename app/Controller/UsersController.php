<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

/**
 * beforeFilter method
 *
 */
	public function beforeFilter() {
		$this->Auth->allow('add', 'login', 'activate');
	}


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$users = $this->User->find('all');
		$this->set(array(
			'users' => $users,
			'_serialize' => array('users')
		));
	}


/**
 * login method
 *
 * @return void
 */
	public function login() {
		$this->layout = 'page';	

		if($this->Session->read('Auth.User')) {
			$this->redirect(array(
				'controller' => 'pages',
				'action' => 'display',
				'home'
			));
		}

		if($this->request->is('post')) {
			if($this->Auth->login()) {
				if($this->Auth->user('status')) {
					$this->set('user', $this->Session->read('Auth.User'));
					$this->redirect(array(
						'controller' => 'pages',
						'action' => 'display',
						'home'
					));
				} else {
					if($this->Auth->logout()) {
						$this->Session->setFlash(
							'Sua conta não está ativada, cheque seu e-mail.', 
							'alert_warning'
						);
						$this->redirect($this->referer());
					}
				}
			} else {
				$this->Session->setFlash(
					'Ops! Usuário ou senha inválidos, tente novamente.', 
					'alert_error'
				);
				$this->redirect($this->referer());
			}
		}
	}

/**
 * logout method
 *
 * @return void
 */
	public function logout() {
		if($this->Auth->logout()) {
			$this->Session->setFlash(
				'Você deslogou com sucesso!', 
				'alert_success'
			);
			$this->redirect(array(
				'controller' => 'users',
				'action' => 'login'
			));
		}
	}



/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view() {
		$id = $this->Auth->user('id');
		$user = $this->User->findById($id);
		
		unset($user['User']['password']);

		$this->set(array(
			'user' => $user,
			'_serialize' => array('user')
		));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		$this->layout = 'page';

		if ($this->request->is('post')) {
			$token = $this->User->generateToken();

			$this->User->create();
			$this->User->data['User']['token'] = $token;
			$this->User->data['User']['status'] = 0;
			if ($this->User->save($this->request->data)) {
				$this->User->sendActivationLink($token);
				$this->Session->setFlash(
					'Sua conta foi cadastrada com sucesso, cheque seu e-mail para ativá-la!', 
					'alert_success'
				);
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(
					'O Usuário não pode ser cadastrado, tente novamente mais tarde.', 
					'alert_error'
				);
				$this->redirect($this->referer());
			}
		}
	}

/**
 * edit method
 *
 * @return void
 */
	public function edit() {
		$this->User->id = $this->Auth->user('id');
		if($this->User->save($this->request->data)) {
			$message = array(
				'text' => __('The user has been edited'),
				'type' => 'info'
			);
		} else {
			$message = array(
				'text' => __('The user could not been saved'),
				'type' => 'error'
			);
		}
		$this->set(array(
			'message' => $message,
			'_serialize' => array('message')
		));
	}

/**
 * delete method
 *
 * @return void
 */
	public function delete() {
		$id = $this->Auth->user('id');

		if($this->User->delete($id)) {
			$this->logout();
		} else {
			$this->set(array(
				'message' => array(
					'text' => __('The user could not been deleted'),
					'type' => 'error'
				),
				'_serialize' => array('message')
			));
		}
	}

/**
 * activate method
 * activate the user account using the token
 * @return void
 */
	public function activate($token) {
		$user = $this->User->findByToken($token);
		$this->User->id = $user['User']['id'];

		if($this->User->field('status') == 0) {
			if($this->User->saveField('status', 1)) {
				$this->Session->setFlash(
					'Sua conta foi ativada.',
					'alert_success'
				);
			}
		} else {
			$this->Session->setFlash(
				'Sua conta já está ativada',
				'alert_error'
			);
		}

		$this->redirect(array(
			'controller' => 'users',
			'action' => 'login'
		));
	}
}
