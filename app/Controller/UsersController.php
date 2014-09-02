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
		if($this->Session->read('Auth.User')) {
			return $this->set(array(
				'message' => array(
					'text' => __('You are logged in!'),
					'type' => 'error'
				),
				'_serialize' => array('message')
			));
		}

		if($this->request->is('post')) {
			if($this->Auth->login()) {
				if($this->Auth->user('status')) {
					$this->set(array(
						'user' => $this->Session->read('Auth.User'),
						'_serialize' => array('user')
					));
				} else {
					if($this->Auth->logout()) {
						$this->set(array(
							'message' => array(
								'text' => __('Your account isn\'t activated, please look your e-mail.'),
								'type' => 'error'
							),
							'_serialize' => array('message')
						));
					}
				}
			} else {
				$this->set(array(
					'message' => array(
						'text' => __('Invalid username or password, try again'),
						'type' => 'error'
					),
					'_serialize' => array('message')
				));
				$this->response->statusCode(401);
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
			$this->set(array(
				'message' => array(
					'text' => __('Logout successfully'),
					'type' => 'info'
				),
				'_serialize' => array('message')
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
		if ($this->request->is('post')) {
			$token = $this->User->generateToken();

			$this->User->create();
			$this->User->data['User']['token'] = $token;
			$this->User->data['User']['status'] = 0;
			if ($this->User->save($this->request->data)) {
				$this->User->sendActivationLink($token);
				$this->set(array(
					'message' => array(
						'text' => __('Registred successfully'),
						'type' => 'info'
					),
					'_serialize' => array('message')
				));
			} else {
				$this->set(array(
					'message' => array(
						'text' => __('The user could not be saved. Please, try again'),
						'type' => 'error'
					),
					'_serialize' => array('message')
				));
				$this->response->statusCode(400);
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
				pr('activated');
				die;
			} else {
				pr('iuahsue');
			}
		} else {
			pr('the user is already active');
			die;
		}
	}
}
