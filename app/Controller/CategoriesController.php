<?php 

App::uses('AppController', 'Controller');

/**
 * Categories Controller
 *
 * @property $Category Category
 */
class CategoriesController extends AppController {
/**
 * isAuthorized callback method
 * @param  object  $user
 * @return boolean
 */
	public function isAuthorized($user) {
		if (in_array($this->action, array('edit', 'delete'))) {
			$categoryId = (int) $this->request->params['pass'][0];
			if(!$this->Category->isOwnedBy($categoryId, $user['id'])) {
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
		$categories = $this->Category->find(
			'all', 
			array(
				'recursive' => -1,
				'conditions' => array(
					'Category.user_id' => $this->Auth->user('id'),
				)
			)
		);
		$this->set(array(
			'categories' => $categories,
			'_serialize' => array('categories')
		));
	}

/**
 * view method
 * @param  integer $id category
 * @return void
 */
	public function view($id) {
		$category = $this->Category->findById($id);

		$this->set(array(
			'category' => $category,
			'_serialize' => array('category')
		));
	}

/**
 * add method
 * 
 * @return void
 */
	public function add() {
		if($this->request->is('post')) {
			$this->Category->create();
			$this->Category->data['Category']['user_id'] = $this->Auth->user('id');
			if($this->Category->save($this->request->data)) {
				$message = array(
					'text' => __('Category added successfully'),
					'type' => 'info'
				);
			} else {
				$message = array(
					'text' => __('Category could not be saved, please try again'),
					'type' => 'error'
				);
			}
			$this->set(array(
				'message' => $message,
				'_serialize' => array('message')
			));
		}
	}

/**
 * edit method
 *
 * return @void
 */

	public function edit($id) {
		$this->Category->id = $id;
		if($this->Category->save($this->request->data)) {
			$message = array(
				'text' => __('Category edited successfully'),
				'type' => 'info'
			);
		} else {
			$message = array(
				'text' => __('Category cannot be edited, please try again later'),
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
 * @param  integer $id category
 * @return @void
 */
	public function delete($id) {
		if($this->Category->delete($id)) {
			$message = array(
				'text' => 'Category deleted successfully',
				'type' => 'info'
			);
		} else {
			$message = array(
				'text' => 'Category cannot be deleted, please try again',
				'type' => 'error'
			);
		}
		$this->set(array(
			'message' => $message,
			'_serialize' => array('message')
		));
	}
}
