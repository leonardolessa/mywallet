<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {

	public function isAuthorized($user) {
		if (in_array($this->action, array('edit', 'delete'))) {
			$userId = (int) $this->request->params['pass'][0];

			if($userId != $user['id']) {
				$this->Session->setFlash(
					'Você não está autorizado a realizar esta ação.',
					'alerts/alert_warning'
				);
				$this->redirect(array(
					'action' => 'login'
				));

				return false;
			}
		}
		return parent::isAuthorized($user);
	}

/**
 * beforeFilter action
 *
 */
	public function beforeFilter() {
		$this->Auth->allow(
			'add', 
			'login', 
			'activate', 
			'reset', 
			'password'
		);
	}


/**
 * index action
 *
 * @return void
 */
	public function index() {
	
	}


/**
 * login action
 *
 * @return void
 */
	public function login() {
		$this->layout = 'external';	

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
							'alerts/alert_warning'
						);
						$this->redirect($this->referer());
					}
				}
			} else {
				$this->Session->setFlash(
					'Ops! Usuário ou senha inválidos, tente novamente.', 
					'alerts/alert_error'
				);
				$this->redirect($this->referer());
			}
		}
	}

/**
 * logout action
 *
 * @return void
 */
	public function logout() {
		if($this->Auth->logout()) {
			$this->Session->setFlash(
				'Você deslogou com sucesso!', 
				'alerts/alert_success'
			);
			$this->redirect(array(
				'controller' => 'users',
				'action' => 'login'
			));
		}
	}



/**
 * view action
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
 * add action
 *
 * @return void
 */
	public function add() {
		$this->layout = 'external';

		if ($this->request->is('post')) {
			$token = $this->User->generateToken();

			$this->User->create();
			$this->User->data['User']['token'] = $token;
			$this->User->data['User']['status'] = 0;
			if($this->User->save($this->request->data)) {
				$this->User->sendActivationLink($token);
				$this->Session->setFlash(
					'Sua conta foi cadastrada com sucesso, cheque seu e-mail para ativá-la!', 
					'alerts/alert_success'
				);
				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(
					'O Usuário não pode ser cadastrado, tente novamente mais tarde.', 
					'alerts/alert_error'
				);
			}
		}
	}

/**
 * edit action
 *
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;

		if($this->request->is(array('post', 'put'))) {
			if($this->User->save($this->request->data)) {
				$this->Session->setFlash(
					'Seu perfil foi editado com sucesso, para suas informações atualizarem você precisa deslogar.',
					'alerts/alert_success'
				);

				$this->redirect($this->referer());
			} else {
				$this->Session->setFlash(
					'O perfil não pode ser editado, tente novamente',
					'alerts/alert_error'
				);
			}
		} else {
			$this->request->data = $this->User->read();
		}
	}

/**
 * delete action
 *
 * @return void
 */
	public function delete() {
		$id = $this->Auth->user('id');

		if($this->request->is(array('post', 'delete'))) {
			if($this->User->delete()) {
				$this->Session->setFlash(
					'Sua conta foi excluída com sucesso.',
					'alerts/alert_success'
				);

				$this->Auth->logout();

				$this->redirect(array(
					'action' => 'login'
				));
			} else {
				$this->Session->setFlash(
					'Sua conta não pode ser excluída, tente novamente.',
				);
			}
		}
	}

/**
 * activate action
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
					'alerts/alert_success'
				);
			}
		} else {
			$this->Session->setFlash(
				'Sua conta já está ativada',
				'alerts/alert_error'
			);
		}

		$this->redirect(array(
			'controller' => 'users',
			'action' => 'login'
		));
	}


/**
 * reset action
 * send a link to the user to change the password
 * @return void
 */
	public function reset() {
		$this->layout = 'external';

		if($this->request->is('post')) {
			$user = $this->User->findByEmail($this->request->data['User']['email']);
			if($user) {
				$this->User->id = $user['User']['id'];

				$this->User->data['User']['token'] = $this->User->generateToken();
				$this->User->data['User']['status'] = 2;

				if($this->User->save()) {
					$this->User->sendResetLink();
					$this->Session->setFlash(
						'Um link foi enviado ao seu e-mail.',
						'alerts/alert_success'
					);	
				} else {
					pr($this->User->validationErrors);
					die;
					$this->Session->setFlash(
						'Não foi possível resetar sua senha, tente novamente.',
						'alerts/alert_error'
					);
				}
			} else {
				$this->Session->setFlash(
					'Este e-mail não está cadastrado no sistema.',
					'alerts/alert_error'
				);
			}
			$this->redirect($this->referer());
		}
	}

/**
 * password action
 * @param  [string] $token [token sent by e-mail]
 * @return void
 */
	public function password($token = null) {
		$this->layout = 'external';

		if($this->request->is('post')) {
			$user = $this->User->findByToken($this->request->data['User']['token']);

			if($user['User']['status'] == 2) {
				$this->User->id = $user['User']['id'];
				if($this->User->saveField('password', $this->request->data['User']['password'])) {
					$this->User->saveField('status', 1);
					$this->Session->setFlash(
						'Sua senha foi atualizada com sucesso',
						'alerts/alert_success'
					);
					$this->redirect(array(
						'controller' => 'users',
						'action' => 'login'
					));
				}

				$this->setFlash(
					'Ocorreu um erro, tente novamente',
					'alerts/alert_error'
				);
				$this->redirect($this->referer());
			}

			$this->setFlash(
				'O pedido de troca de senha já foi utilizado.',
				'alerts/alert_warning'
			);
			$this->redirect(array(
				'controller' => 'users',
				'action' => 'login'
			));
		}

		$user = $this->User->findByToken($token);

		if($user['User']['status'] != 2) {
			$this->Session->setFlash(
				'O link recebido não é válido ou já foi usado.',
				'alerts/alert_error'
			);
			$this->redirect(array(
				'controller' => 'users',
				'action' => 'login'
			));
		}

		$this->set(compact('token'));
	}
}
