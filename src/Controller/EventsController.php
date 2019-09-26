<?php

namespace App\Controller;

use App\Util\ModelUtil;
use Cake\Event\Event;
use PhpOffice\PhpSpreadsheet\Settings;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


/**
 * Users Controller
 *
 * @property \App\Model\Table\EventsTable $Events
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class EventsController extends AppController
{
	/**
	 * ログインしていなくてもアクセスできるページを定義する
	 * 基本的に、ログアウトのみ
	 * ユーザーに関しては権限エラーも
	 * @param Event $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow(['index']);
	}

	public function isAuthorized($user)
	{
		//ログアウトと権限エラー時はスルー
		if (in_array($this->request->getParam('action'), ['index'])) {
			return true;
		}

		// システム管理者以外はドライバー情報に関して全アクション拒否
		if (isset($user) && $user['role'] == ROLE_SYSTEM) {
			return true;
		}

		return parent::isAuthorized($user);
	}

	/**
	 * Index method
	 *
	 * @return \Cake\Http\Response|void
	 */
	public function index()
	{
		$this->viewBuilder()->setLayout('editor_layout');

		$conditions = [];
		$sort = ['created' => 'desc'];

		if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
			$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
		}

		//検索条件のクリアが選択された場合は全件検索をする
		if ($this->request->getQuery('submit_btn') == 'clear') {
			$events = $this->paginate($this->Events->find('all', ['order' => $sort]));
		} else {
			if ($this->request->getQuery('mail_address') != '') {
				$conditions['mail_address like'] = '%'.$this->request->getQuery('mail_address').'%';
			}
			if ($this->request->getQuery('role') != '' && $this->request->getQuery('role') != '-1') {
				$conditions['role'] = $this->request->getQuery('role');
			}
			$events = $this->paginate($this->Events->find('all', ['order' => $sort, 'conditions' => $conditions]));
		}

		$this->set(compact('events'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null)
	{
		$this->viewBuilder()->setLayout('my_layout');
		$event = $this->Events->get($id, ['contain' => []]);

		$this->set(compact('event'));
	}

	/**
	 * 会員情報を追加するメソッド
	 * 権限：だれでも
	 * 画面遷移：ログイン画面へ遷移
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add()
	{
		$this->viewBuilder()->setLayout('editor_layout');
		$event = $this->Events->newEntity();
		$event->user_id = $this->request->session()->read('Auth.User.id');
		if ($this->request->is('post')) {
			$event = $this->Events->patchEntity($event, $this->request->getData());
			if ($this->Events->save($event)) {
				$this->Flash->success(__('ご登録ありがとうございました。'));
				return $this->redirect(['action' => 'index']);
			}
			$this->Flash->error(__('サーバーエラーにより登録ができませんでした。'));
		}
		$this->set(compact('event'));
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function edit($id = null)
	{
		$this->viewBuilder()->setLayout('editor_layout');
		$event = $this->Events->get($id, ['contain' => []]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$event = $this->Events->patchEntity($event, $this->request->getData());
			if ($this->Events->save($event)) {
				$this->Flash->success(__('イベント情報を正常に更新致しました。'));
				return $this->redirect(['action' => 'view', $event->id]);
			}
			$this->Flash->error(__('イベント情報を更新できませんでした。'));
		}
		$this->set(compact('event'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$event = $this->Events->get($id);
		if ($this->Events->delete($event)) {
			$this->Flash->success(__('イベント情報を削除いたしました。'));
		} else {
			$this->Flash->error(__('イベント情報を削除できませんでした。'));
		}

		return $this->redirect(['action' => 'index']);
	}
}
