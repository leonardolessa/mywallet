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
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$movements = $this->Movement->find(
			'all',
			array(
				'recursive' => 0,
				'conditions' => array(
					'Movement.user_id' => $this->Auth->user('id')
				),
				'fields' => array(
					'Movement.*',
					'Category.*'
				)
			)
		);

		$this->set(array(
			'movements' => $movements,
			'_serialize' => array('movements')
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
		if ($this->request->is('post') && $this->request->isAjax()) {
			$this->Movement->create();
			if ($this->Movement->save($this->request->data)) {
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
		
		$users = $this->Movement->User->find('list');

		$categories = $this->Movement->Category->find(
			'list',
			array(
				'conditions' => array(
					'user_id' => $this->Auth->user('id')
				)
			)
		);
		$this->set(compact('users', 'categories'));
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Movement->exists($id)) {
			throw new NotFoundException(__('Invalid movement'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Movement->save($this->request->data)) {
				$this->Session->setFlash(__('The movement has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The movement could not be saved. Please, try again.'));
			}
		} else {
			$options = array('conditions' => array('Movement.' . $this->Movement->primaryKey => $id));
			$this->request->data = $this->Movement->find('first', $options);
		}
		$users = $this->Movement->User->find('list');
		$categories = $this->Movement->Category->find('list');
		$savings = $this->Movement->Saving->find('list');
		$goals = $this->Movement->Goal->find('list');
		$this->set(compact('users', 'categories', 'savings', 'goals'));
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Movement->id = $id;
		if (!$this->Movement->exists()) {
			throw new NotFoundException(__('Invalid movement'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->Movement->delete()) {
			$this->Session->setFlash(__('The movement has been deleted.'));
		} else {
			$this->Session->setFlash(__('The movement could not be deleted. Please, try again.'));
		}
		return $this->redirect(array('action' => 'index'));
	}
}
