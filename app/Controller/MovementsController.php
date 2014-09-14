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
		$this->Movement->recursive = 0;
		$this->set('movements', $this->Paginator->paginate());
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
			if ($this->Movement->save($this->request->data)) {
				$this->Session->setFlash(__('The movement has been saved.'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The movement could not be saved. Please, try again.'));
			}
		}
		$users = $this->Movement->User->find('list');
		$categories = $this->Movement->Category->find('list');
		$savings = $this->Movement->Saving->find('list');
		$goals = $this->Movement->Goal->find('list');
		$this->set(compact('users', 'categories', 'savings', 'goals'));
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
