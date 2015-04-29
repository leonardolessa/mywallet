<?php
App::uses('AppController', 'Controller');


class PaymentsController extends AppController {

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if ($this->request->is(array('post', 'put'))) {
			if ($this->Payment->saveAll($this->request->data)) {
				$message = array(
					'text' => 'A movimentação foi editada com sucesso.',
					'type' => 'success'
				);
			} else {
				$message = array(
					'text' => 'Não foi possível editar a movimentação.',
					'type' => 'error',
						'errors' => $this->Payment->validationErrors
				);
			}

			return $this->set(array(
				'message' => $message,
				'_serialize' => array('message')
			));

		}

		$this->request->data = $this->Payment->find(
			'first',
			array(
				'conditions' => array(
					'Payment.' . $this->Payment->primaryKey => $id
				),
				'contain' => array(
					'Movement.Category'
				)
			)
		);

		$categories = $this->Payment->Movement->Category->find('list');

		$this->set(compact('categories'));
	}
}
