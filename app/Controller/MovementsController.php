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
 * index method
 *
 * @return void
 */
	public function index() {
		$payments = $this->Movement->getPayments();
		$balance = $this->Movement->getBalance();

		$this->set(array(
			'payments' => $payments,
			'balance' => $balance,
			'date' => date('m/d/Y'),
			'_serialize' => array('payments', 'date', 'balance')
		));
	}

/**
 * date method
 *
 * get the movements by date (year and month) received in the post request
 * @return void
 */
	public function date() {
		if($this->request->is('post')) {
			$payments = $this->Movement->getPayments($this->request->data);
			$balance = $this->Movement->getBalance();

			$this->set(array(
				'balance' => $balance,
				'payments' => $payments,
				'_serialize' => array('payments', 'balance')
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
		$this->Movement->Payment->id = $id;
		$current = $this->Movement->Payment->field('paid');

		if($this->Movement->Payment->saveField('paid', ($current ? false : true))) {
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
 * delete method
 *
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if($this->request->is('delete')) {
			if ($this->Movement->deletePayment($id)) {
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

/**
 * overview
 *
 * return the balance and the total information
 * @return void
 */
	public function overview() {
		$overview = $this->Movement->getBalance();

		return $this->set(array(
			'overview' => $overview,
			'_serialize' => array('overview')
		));
	}

/**
 * Reports action
 *
 * @return void
 */
	public function reports() {
		$payments = $this->Movement->getPayments();
		$balance = $this->Movement->getBalance();

		$this->set(array(
			'payments' => $payments,
			'balance' => $balance,
			'_serialize' => array('payments', 'balance')
		));
	}


	public function custom() {
		if ($this->request->is('post')) {
			$movements = $this->Movement->getCustom($this->request->data);

			$this->set(array(
				'movements' => $movements,
				'_serialize' => array('movements')
			));
		}
	}
}
