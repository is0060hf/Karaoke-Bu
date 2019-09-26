<?php

namespace App\Controller;

use App\Util\ModelUtil;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Settings;
use PhpOffice\PhpSpreadsheet\Spreadsheet;


/**
 * Teams Controller
 *
 * @property \App\Model\Table\StoresTable $Stores
 *
 * @method \App\Model\Entity\Team[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StoresController extends AppController {

	/**
	 * ログインしていなくてもアクセスできるページを定義する
	 * 一覧画面と詳細画面はログイン不要とする
	 * @param Event $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow(['index',
			'view']);
	}

	/**
	 * ロールによってアクセスできるページを定義する
	 * 新規店舗登録、店舗情報編集、店舗情報削除に関してはロールに関係なくアクセス可能とする
	 * 一部情報は店舗管理者以上の権限が必要になるが、同一画面にて条件分岐で処理をする
	 * @param $user
	 * @return bool
	 */
	public function isAuthorized($user) {
		if (in_array($this->request->getParam('action'), ['index',
			'view',
			'add',
			'edit',
			'delete'])) {
			return true;
		}

		return parent::isAuthorized($user);
	}

	/**
	 * 店舗一覧を表示する機能
	 *
	 * 店舗一覧の検索項目は下記の通り
	 * ・地域
	 * ・都道府県
	 * ・店舗名
	 *
	 * 権限：だれでも
	 * ログイン要否：不要
	 * 画面遷移：一覧画面
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
			$stores = $this->paginate($this->Stores->find('all', ['order' => $sort]));
		} else {
			if ($this->request->getQuery('mail_address') != '') {
				$conditions['mail_address like'] = '%'.$this->request->getQuery('mail_address').'%';
			}
			if ($this->request->getQuery('role') != '' && $this->request->getQuery('role') != '-1') {
				$conditions['role'] = $this->request->getQuery('role');
			}
			$stores = $this->paginate($this->Stores->find('all', ['order' => $sort,
				'conditions' => $conditions]));
		}

		$this->set(compact('stores'));
	}

	/**
	 * 店舗詳細を表示する機能
	 *
	 * 権限：だれでも
	 * ログイン要否：不要
	 * 画面遷移：詳細画面
	 *
	 * @param string|null $id Store id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$this->viewBuilder()->setLayout('my_layout');
		$store = $this->Stores->get($id, ['contain' => []]);

		$this->set(compact('store'));
	}

	/**
	 * 店舗情報を新規追加する機能
	 *
	 * 権限：だれでも
	 * ログイン要否：要
	 * 画面遷移：店舗情報追加画面
	 *
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$this->viewBuilder()->setLayout('editor_layout');
		$store = $this->Stores->newEntity();

		if ($this->request->is('post')) {
			$store = $this->Stores->patchEntity($store, $this->request->getData());
			if ($this->Stores->save($store)) {
				$this->Flash->success(__('店舗登録が完了しました。'));

				return $this->redirect(['action' => 'index']);
			} else {
				$this->Flash->error(__('店舗登録に失敗しました。しばらくしてからやり直してください。'));
				$this->set(compact('store'));
			}
		} else {
			$this->set(compact('store'));
		}
	}

	/**
	 * 店舗情報を編集する機能
	 *
	 * 権限：だれでも
	 * ログイン要否：要
	 * 画面遷移：店舗情報編集画面
	 *
	 * @param string|null $id Store id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function edit($id = null) {
		$this->viewBuilder()->setLayout('editor_layout');
		$store = $this->Stores->get($id, ['contain' => []]);

		if ($this->request->is(['patch',
			'post',
			'put'])) {
			$store = $this->Stores->patchEntity($store, $this->request->getData());

			if ($this->Stores->save($store)) {
				$this->Flash->success(__('店舗を登録しました。'));
				return $this->redirect(array('action' => 'view',
					$id));
			} else {
				$this->Flash->error(__('入力エラーが発生しました'));
				$this->set(compact('store'));
				$this->render("edit");
			}
		}
		$this->set(compact('store'));
	}

	/**
	 * 店舗情報を削除する機能
	 *
	 * 権限：だれでも
	 * ログイン要否：要
	 * 画面遷移：なし
	 *
	 * @param string|null $id Store id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post',
			'delete']);
		$team = $this->Stores->get($id);
		if ($this->Stores->delete($team)) {
			$this->Flash->success(__('店舗情報を削除いたしました。'));
		} else {
			$this->Flash->error(__('店舗情報を削除できませんでした。'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * 店舗画像を追加する機能
	 *
	 * 権限：だれでも
	 * ログイン要否：要
	 * 画面遷移：なし
	 *
	 * @param null $storeId
	 */
	public function addImage($storeId = null) {
		$this->request->allowMethod(['post']);

		if ($storeId) {
			$storeImageEntity = TableRegistry::get('StoreImages');
			$storeImage = $storeImageEntity->newEntity();
			$storeImage = $storeImageEntity->patchEntity($storeImage, $this->request->getData());
			$storeImage->store_id = $storeId;

			if ($this->Friends->save($friend)) {
				$this->Flash->success(__('ともだち登録しました。'));

				$url = $this->referer(array('action' => 'index'));
				return $this->redirect($url);
			} else {
				$this->Flash->error(__('ともだち登録に失敗しました。しばらくしてからやり直してください。'));

				$url = $this->referer(array('action' => 'index'));
				return $this->redirect($url);
			}
		}
	}

}
