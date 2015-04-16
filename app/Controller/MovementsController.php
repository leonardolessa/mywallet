<?php
App::uses('AppController', 'Controller');
/**
 * Movements Controller
 *
 * @property Movement $Movement
 * @property PaginatorComponent $Paginator
 */
class MovementsController extends AppController {
/**
 * isAuthorized callback method
 * @param  object  $user
 * @return boolean
 */
	public function isAuthorized($user) {
		if (in_array($this->action, array('edit', 'delete'))) {
			$movementId = (int) $this->request->params['pass'][0];
			if(!$this->Movement->isOwnedBy($movementId, $user['id'])) {
				$this->Session->setFlash(
					'Você não está autorizado a realizar esta ação.',
					'alert/alert_warning'
				);
				$this->redirect(array(
					'controller' => 'pages',
					'action' => 'display',
					'home'
				));
			}
		}
		return parent::isAuthorized($user);
	}


/**
 * index method
 *
 * @return void
 */
	public function index() {
		$payments = $this->Movement->getPayments();

		$this->set(array(
			'payments' => $payments,
			'date' => date('m/d/Y'),
			'_serialize' => array('payments', 'date')
		));
	}

/**
 * date method
 *
 * get the movements by date (year and month)
 * @return void
 */
	public function date() {
		if($this->request->is('post')) {
			$payments = $this->Movement->getPayments($this->request->data);

			$this->set(array(
				'payments' => $payments,
				'_serialize' => array('payments')
			));
		}
	}

/**
 * pay method
 *
 * method that switch the paid field of the movement
 * @param  integer $id [movement id]
 * @return void
 */
	public function pay($id = null) {
		$this->Movement->id = $id;
		$current = $this->Movement->field('paid');

		if($this->Movement->saveField('paid', ($current ? false : true))) {
			$message = array(
				'text' => 'A movimentação foi alterada com sucesso',
				'type' => 'success'
			);
		} else {
			$message = array(
				'text' => 'A movimentação não pode ser alterada',
				'type' => 'error'
			);
		}

		$this->set(array(
			'message' => $message,
			'_serialize' => array('message')
		));
	}


/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Movement->exists($id)) {
			throw new NotFoundException(__('Invalid movement'));
		}
		$options = array('conditions' => array('Movement.' . $this->Movement->primaryKey => $id));
		$this->set('movement', $this->Movement->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->Movement->create();

			$requestData = $this->Movement->filterData($this->request->data);
			unset($this->Movement->Payment->validate['movement_id']);

			if ($this->Movement->saveAssociated($requestData)) {
				$message = array(
					'text' => 'A movimentação foi adicionada com sucesso.',
					'type' => 'success'
				);
			} else {
				$message = array(
					'text' => 'Não foi possível adicionar a movimentação.',
					'type' => 'error',
					'errors' => $this->Movement->validationErrors
				);
			}

			return $this->set(array(
				'message' => $message,
				'_serialize' => array('message')
			));
		}

		$categories = $this->Movement->Category->find(
			'list',
			array(
				'conditions' => array(
					'user_id' => $this->Auth->user('id')
				)
			)
		);

		$this->set(compact('categories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {

			if ($this->Movement->save($this->request->data)) {
				$message = array(
					'text' => 'A movimentação foi editada com sucesso.',
					'type' => 'success'
				);
			} else {
				$message = array(
					'text' => 'Não foi possível editar a movimentação.',
					'type' => 'error',
						'errors' => $this->Movement->validationErrors
				);
			}

			return $this->set(array(
				'message' => $message,
				'_serialize' => array('message')
			));

		}

		$this->request->data = $this->Movement->find(
			'first',
			array(
				'conditions' => array(
					'Movement.' . $this->Movement->primaryKey => $id
				)
			)
		);

		$categories = $this->Movement->Category->find(
			'list',
			array(
				'conditions' => array(
					'user_id' => $this->Auth->user('id')
				)
			)
		);

		$this->set(compact('categories'));
	}

/**
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Movement->id = $id;

		if($this->request->is('delete')) {
			if ($this->Movement->delete()) {
				$message = array(
					'text' => 'A movimentação foi excluída com sucesso.',
					'type' => 'success'
				);
			} else {
				$message = array(
					'text' => 'A movimentação não pode ser excluída.',
					'type' => 'error',
					'errors' => $this->Movement->validationErrors
				);
			}

			return $this->set(array(
				'message' => $message,
				'_serialize' => array('message')
			));
		}
	}
}
