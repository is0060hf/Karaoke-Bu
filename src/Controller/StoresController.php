<?php

namespace App\Controller;

use App\Util\ModelUtil;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Settings;
use RuntimeException;


/**
 * Teams Controller
 *
 * @property \App\Model\Table\StoresTable $Stores
 *
 * @method \App\Model\Entity\Team[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StoresController extends AppController
{

	/**
	 * ログインしていなくてもアクセスできるページを定義する
	 * 一覧画面と詳細画面はログイン不要とする
	 * @param Event $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
		$this->Auth->allow(['index','view']);
	}

	/**
	 * ロールによってアクセスできるページを定義する
	 * 新規店舗登録、店舗情報編集、店舗情報削除に関してはロールに関係なくアクセス可能とする
	 * 一部情報は店舗管理者以上の権限が必要になるが、同一画面にて条件分岐で処理をする
	 * @param $user
	 * @return bool
	 */
	public function isAuthorized($user)
	{
		if (in_array($this->request->getParam('action'), ['index','view','add','edit','delete'])) {
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
			$stores = $this->paginate($this->Stores->find('all', ['order' => $sort]));
		} else {
			if ($this->request->getQuery('mail_address') != '') {
				$conditions['mail_address like'] = '%' . $this->request->getQuery('mail_address') . '%';
			}
			if ($this->request->getQuery('role') != '' && $this->request->getQuery('role') != '-1') {
				$conditions['role'] = $this->request->getQuery('role');
			}
			$stores = $this->paginate($this->Stores->find('all', ['order' => $sort, 'conditions' => $conditions]));
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
	public function view($id = null)
	{
		$this->viewBuilder()->setLayout('my_layout');
		$store = $this->Stores->get($id, [
			'contain' => []
		]);

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
	public function add()
	{
		$this->viewBuilder()->setLayout('editor_layout');
		$team = $this->Teams->newEntity();
		if ($this->request->is('post')) {
			$team = $this->Teams->patchEntity($team, $this->request->getData());

			// ファイルのアップロード処理
			$dir = realpath(WWW_ROOT . "/upload_img");
			$limitFileSize = 1024 * 1024;  //	画像の容量制限は1MBとする

			try {
				//カバーイメージの物理ファイルを保存フォルダへ移動し、データベースへそのパスを登録する。
				if ($this->request->getData('cover_image_path')) {
					$uploadedFileName = $this->file_upload($this->request->getData('cover_image_path'), $dir, $limitFileSize);
					$team->cover_image_path = '/upload_img/' . $uploadedFileName;
				}

				//アイコンイメージの物理ファイルを保存フォルダへ移動し、データベースへそのパスを登録する。
				if ($this->request->getData('icon_image_path')) {
					$uploadedFileName = $this->file_upload($this->request->getData('icon_image_path'), $dir, $limitFileSize);
					$team->icon_image_path = '/upload_img/' . $uploadedFileName;
				}

				// トランザクション開始
				$connection = ConnectionManager::get('default');
				$connection->begin();

				// トピックスの投稿処理
				if ($this->Teams->save($team)) {
					$teamUserLinkData['user_id'] = $this->request->session()->read('Auth.User.id');
					$teamUserLinkData['team_id'] = $team->id;
					$teamUserLinkData['status'] = TEAM_MEMBER_STATUS_APPROVAL;
					$teamUserLinkData['role'] = TEAM_MEMBER_ROLE_MANAGER;

					//チーム登録者自身を管理者として登録する
					$teamUserLinksTable = TableRegistry::get('TeamUserLinks');
					$newTeamUserLink = $teamUserLinksTable->newEntity($teamUserLinkData);
					$teamUserLinksTable->save($newTeamUserLink);

					// コミット
					$connection->commit();

					$this->Flash->success(__('チームを登録しました。'));
					return $this->redirect(array('action' => 'index'));
				} else {
					// ロールバック
					$connection->rollback();

					$this->Flash->error(__('入力エラーが発生しました'));
					$this->set(compact('team'));
					$this->render("add");
				}
			} catch (RuntimeException $e) {
				$this->Flash->error(__('ファイルのアップロードができませんでした.'));
				$this->Flash->error(__($e->getMessage()));
			}
		}
		$this->set(compact('team'));
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
		$team = $this->Teams->get($id, [
			'contain' => []
		]);
		if ($this->request->is(['patch', 'post', 'put'])) {
			$team = $this->Teams->patchEntity($team, $this->request->getData());

			// ファイルのアップロード処理
			$dir = realpath(WWW_ROOT . "/upload_img");
			$limitFileSize = 1024 * 1024;  //	画像の容量制限は1MBとする

			try {
				//カバーイメージの物理ファイルを保存フォルダへ移動し、データベースへそのパスを登録する。
				if ($this->request->getData('cover_image_path')) {
					$uploadedFileName = $this->file_upload($this->request->getData('cover_image_path'), $dir, $limitFileSize);
					$team->cover_image_path = '/upload_img/' . $uploadedFileName;
				}

				//アイコンイメージの物理ファイルを保存フォルダへ移動し、データベースへそのパスを登録する。
				if ($this->request->getData('icon_image_path')) {
					$uploadedFileName = $this->file_upload($this->request->getData('icon_image_path'), $dir, $limitFileSize);
					$team->icon_image_path = '/upload_img/' . $uploadedFileName;
				}

				if ($this->Teams->save($team)) {
					$this->Flash->success(__('チームを登録しました。'));
					return $this->redirect(array('action' => 'view', $id));
				} else {
					$this->Flash->error(__('入力エラーが発生しました'));
					$this->set(compact('post'));
					$this->render("edit");
				}

			} catch (RuntimeException $e) {
				$this->Flash->error(__('ファイルのアップロードができませんでした.'));
				$this->Flash->error(__($e->getMessage()));
			}
		}
		$this->set(compact('team'));
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
		$team = $this->Teams->get($id);
		if ($this->Teams->delete($team)) {
			$this->Flash->success(__('チーム情報を削除いたしました。'));
		} else {
			$this->Flash->error(__('チーム情報を削除できませんでした。'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * ファイルをアップロードする処理
	 * @param null $file
	 * @param null $dir
	 * @param float|int $limitFileSize
	 * @return string
	 */
	public function file_upload($file = null, $dir = null, $limitFileSize = 1024 * 1024)
	{
		try {
			// ファイルを保存するフォルダ $dirの値のチェック
			if ($dir) {
				if (!file_exists($dir)) {
					throw new RuntimeException('指定のディレクトリがありません。');
				}
			} else {
				throw new RuntimeException('ディレクトリの指定がありません。');
			}

			// 未定義、複数ファイル、破損攻撃のいずれかの場合は無効処理
			if (!isset($file['error']) || is_array($file['error'])) {
				throw new RuntimeException('Invalid parameters.');
			}

			// エラーのチェック
			switch ($file['error']) {
				case 0:
					break;
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('No file sent.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('Exceeded filesize limit.');
				default:
					throw new RuntimeException('Unknown errors.');
			}

			// ファイル情報取得
			$fileInfo = new File($file["tmp_name"]);

			// ファイルサイズのチェック
			if ($fileInfo->size() > $limitFileSize) {
				throw new RuntimeException('ファイル容量の制限を超えています。');
			}

			// ファイルタイプのチェックし、拡張子を取得
			if (false === $ext = array_search($fileInfo->mime(),
					['jpg' => 'image/jpeg',
						'png' => 'image/png',
						'gif' => 'image/gif',],
					true)) {
				throw new RuntimeException('画像ファイル以外がアップロードされました。');
			}

			// ファイル名の生成
			$uploadFile = sha1_file($file["tmp_name"]) . "." . $ext;

			// ファイルの移動
			if (!move_uploaded_file($file["tmp_name"], $dir . "/" . $uploadFile)) {
				throw new RuntimeException('Failed to move uploaded file.');
			}
		} catch (RuntimeException $e) {
			throw $e;
		}
		return $uploadFile;
	}

	/**
	 * 編集画面にてカバー画像を削除するためのメソッド
	 * @param null $id
	 * @return mixed
	 */
	public function deleteCoverImage($id = null) {
		$team = $this->Teams->get($id, [
			'contain' => []
		]);

		if ($team->cover_image_path != '') {
			if (file_exists ( WWW_ROOT . $team->cover_image_path )) {
				unlink(WWW_ROOT . $team->cover_image_path);
			}
		}

		$team->cover_image_path = null;
		if ($this->Teams->save($team)) {
			$this->Flash->success(__('カバー画像を削除しました。'));
		} else {
			$this->Flash->error(__('カバー画像の削除に失敗しました。'));
		}

		$this->set(compact('team'));
		return $this->redirect($this->referer());
	}

	/**
	 * 編集画面にてアイコンを削除するためのメソッド
	 * @param null $id
	 * @return mixed
	 */
	public function deleteIcon($id = null) {
		$team = $this->Teams->get($id, [
			'contain' => []
		]);

		if ($team->icon_image_path != '') {
			if (file_exists ( WWW_ROOT . $team->icon_image_path )) {
				unlink(WWW_ROOT . $team->icon_image_path);
			}
		}

		$team->icon_image_path = null;
		if ($this->Teams->save($team)) {
			$this->Flash->success(__('アイコンを削除しました。'));
		} else {
			$this->Flash->error(__('アイコンの削除に失敗しました。'));
		}

		$this->set(compact('team'));
		return $this->redirect($this->referer());
	}
}
