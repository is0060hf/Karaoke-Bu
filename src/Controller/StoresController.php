<?php

namespace App\Controller;

use App\Utils\FileUtil;
use Cake\Event\Event;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Settings;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use RuntimeException;


/**
 * Teams Controller
 *
 * @property \App\Model\Table\StoresTable $Stores
 *
 * @method \App\Model\Entity\Team[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StoresController extends AppController {

	/**
	 * 店舗画像の一覧を取得する
	 * @throws \Exception
	 */
	public function ajaxGetStoreImages() {
		$this->autoRender = FALSE;
		$this->response->type('json');

		if (!$this->request->is('ajax')) {
			throw new \Exception();
		}

		$id = $this->request->getData('store_id');
		$result = [];
		$error = [];
		$storeImages = TableRegistry::get('StoreImages')->find('All')->where(['store_id' => $id]);

		foreach ($storeImages as $storeImage) {
			$imageInfo = ['store_image_id' => $storeImage->id,
				'image_path' => $storeImage->image_path,
				'image_full_path' => WWW_ROOT.$storeImage->image_path,
				'image_size' => $storeImage->image_size,
				'image_type' => $storeImage->image_type,
				'image_ext' => $storeImage->image_ext,
				'image_name' => $storeImage->image_name,];
			array_push($result, $imageInfo);
		}

		// json_encodeを使用してJSON形式で返却
		echo json_encode(compact('status', 'result', 'error'));
	}

	/**
	 * 店舗画像を削除する
	 * @throws \Exception
	 */
	public function ajaxDeleteStoreImage() {
		$this->autoRender = FALSE;
		$this->response->type('json');

		if (!$this->request->is('ajax')) {
			throw new \Exception();
		}

		$imagePath = $this->request->getData('image_path');
		$result = false;
		$error = [];
		$storeImagesTable = TableRegistry::get('StoreImages');
		$storeImage = $storeImagesTable->find('All')->where(['image_path' => $imagePath])->first();

		if ($storeImage) {
			if (FileUtil::deleteImageOnEdit($storeImage, $storeImagesTable)) {
				$result = true;
			} else {
				$error['message'] = '削除に失敗しました。';
			}
		} else {
			$error['message'] = '削除対象が存在しません。';
		}

		// json_encodeを使用してJSON形式で返却
		echo json_encode(compact('status', 'result', 'error'));
	}

	/**
	 * ログインしていなくてもアクセスできるページを定義する
	 * 一覧画面と詳細画面はログイン不要とする
	 * @param Event $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow(['index',
			'view',
			'ajaxGetStoreImages']);
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
			'ajaxGetStoreImages',
			'ajaxDeleteStoreImage',
			'view',
			'add',
			'edit',
			'delete',
			'deleteStoreImage',
			'uploadStoreImage'])) {
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
	 * 店舗画像をアップロードする
	 *
	 * @return \Cake\Http\Response|null
	 */
	public function uploadStoreImage() {
		if ($this->request->is(['patch',
			'post',
			'put'])) {
			$id = $this->request->getData('id');
			$table_name = $this->request->getData('table_name');
			$column_name = $this->request->getData('column_name');
			$image_table_name = $this->request->getData('image_table_name');
			$limit_size = $this->request->getData('limit_size');
			$limit_size = isset($limit_size) ? $limit_size : 1024 * 1024;

			// 必要な項目が存在しない場合は
			if (!isset($id) || !isset($table_name) || !isset($column_name) || !isset($image_table_name)) {
				$this->Flash->error(__('店舗画像のアップロードに失敗しました。ERROR_001'));
			}

			try {
				$move_dir = realpath(WWW_ROOT."/upload_img");
				$uploadResult = FileUtil::file_upload($this->request->getData('file'), $move_dir, $limit_size);
				$storeImagesTable = TableRegistry::get($image_table_name);

				$imageEntity = $storeImagesTable->newEntity();
				$imageEntity->store_id = $id;
				$imageEntity->image_path = '/upload_img/'.$uploadResult['path'];
				$imageEntity->image_type = $uploadResult['type'];
				$imageEntity->image_ext = $uploadResult['ext'];
				$imageEntity->image_name = $uploadResult['name'];
				$imageEntity->image_size = $uploadResult['size'];

				if ($storeImagesTable->save($imageEntity)) {
					$this->Flash->success(__('店舗画像をアップロードしました。'));
				} else {
					FileUtil::deleteImageOnEdit($imageEntity, $storeImagesTable);
					$this->Flash->error(__('店舗画像のアップロードに失敗しました。ERROR_002'));
				}
			} catch (RuntimeException $exception) {
				$this->Flash->error(__('店舗画像のアップロードに失敗しました。ERROR_003'));
			}
		}

		return $this->redirect($this->referer());
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
	 * 店舗画像を削除するメソッド
	 *
	 * @param null $id
	 * @return mixed
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：なし
	 */
	public function deleteStoreImage($id = null) {
		if ($this->request->is('post')) {
			$storeImagesTable = TableRegistry::get('StoreImages');
			$storeImage = $storeImagesTable->find('All')->where(['id' => $id])->first();

			if (FileUtil::deleteImageOnEdit($storeImage, $storeImagesTable)) {
				$this->Flash->success(__('店舗画像を削除しました。'));
			} else {
				$this->Flash->error(__('店舗画像の削除に失敗しました。'));
			}
		}
		return $this->redirect($this->referer());
	}
}
