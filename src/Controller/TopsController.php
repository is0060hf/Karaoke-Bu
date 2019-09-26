<?php

namespace App\Controller;

use Cake\Event\Event;
use Cake\ORM\TableRegistry;

/**
 * Users Controller
 *
 * @property \App\Model\Table\EventsTable $Events
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TopsController extends AppController {
	/**
	 * ログインしていなくてもアクセスできるページを定義する
	 * 基本的に、ログアウトのみ
	 * ユーザーに関しては権限エラーも
	 * @param Event $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow(['index',
			'event']);
	}

	public function isAuthorized($user) {
		return true;
	}

	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function index() {
		$this->viewBuilder()->setLayout('editor_layout');

		$conditions = [];
		$sort = ['created' => 'desc'];

		if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
			$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
		}

		//検索条件のクリアが選択された場合は全件検索をする
		if ($this->request->getQuery('submit_btn') == 'clear') {
			$events = $this->paginate(TableRegistry::get('Events')->find('all', ['order' => $sort]));
			//				$events = $this->paginate($this->Events->find('all', ['order' => $sort]));
		} else {
			if ($this->request->getQuery('mail_address') != '') {
				$conditions['mail_address like'] = '%'.$this->request->getQuery('mail_address').'%';
			}
			// 地域で絞り込み
			if ($this->request->getQuery('region') != '' && $this->request->getQuery('region') != '-1') {
				$conditions['region'] = $this->request->getQuery('region');
			}
			// 都道府県で絞り込み
			if ($this->request->getQuery('prefecture') != '' && $this->request->getQuery('prefecture') != '-1') {
				$conditions['prefecture'] = $this->request->getQuery('prefecture');
			}
			$events = $this->paginate(TableRegistry::get('Events')->find('all', ['order' => $sort,
				'conditions' => $conditions]));
			//				$events = $this->paginate($this->Events->find('all', ['order' => $sort, 'conditions' => $conditions]));
		}

		$this->set(compact('events'));
	}

	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function event() {
		$this->viewBuilder()->setLayout('editor_layout');

		$conditions = [];
		$sort = ['created' => 'desc'];

		if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
			$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
		}

		//検索条件のクリアが選択された場合は全件検索をする
		if ($this->request->getQuery('submit_btn') == 'clear') {
			$events = $this->paginate(TableRegistry::get('Events')->find('all', ['order' => $sort]));
			//				$events = $this->paginate($this->Events->find('all', ['order' => $sort]));
		} else {
			if ($this->request->getQuery('mail_address') != '') {
				$conditions['mail_address like'] = '%'.$this->request->getQuery('mail_address').'%';
			}
			// 地域で絞り込み
			if ($this->request->getQuery('region') != '' && $this->request->getQuery('region') != '-1') {
				$conditions['region'] = $this->request->getQuery('region');
			}
			// 都道府県で絞り込み
			if ($this->request->getQuery('prefecture') != '' && $this->request->getQuery('prefecture') != '-1') {
				$conditions['prefecture'] = $this->request->getQuery('prefecture');
			}
			$events = $this->paginate(TableRegistry::get('Events')->find('all', ['order' => $sort,
				'conditions' => $conditions]));
			//				$events = $this->paginate($this->Events->find('all', ['order' => $sort, 'conditions' => $conditions]));
		}

		$this->set(compact('events'));
	}

}
