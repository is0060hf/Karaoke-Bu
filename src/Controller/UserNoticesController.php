<?php

namespace App\Controller;

use App\Utils\FileUtil;
use Cake\Core\App;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Http\Response;
use Cake\I18n\Time;
use Cake\ORM\TableRegistry;
use PhpOffice\PhpSpreadsheet\Settings;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use RuntimeException;

/**
 * Teams Controller
 *
 * @property \App\Model\Table\UserNoticesTable $UserNotices
 *
 * @method \App\Model\Entity\Team[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserNoticesController extends AppController {

	/**
	 * ログインしていなくてもアクセスできるページを定義する
	 * 通知は全ての操作でログインが必要
	 * @param Event $event
	 * @return Response|null|void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
	}

	/**
	 * 明示的に通知を発行するのはシステム管理者のみ可能
	 * 何かしらの操作をトリガーとして自動的に発行される通知は別途許可を設定
	 * @param $user
	 * @return bool
	 */
	public function isAuthorized($user) {
		// 誰でも許可するアクション
		if (in_array($this->request->getParam('action'), ['myNotice'])) {
			return true;
		}

		// システム管理者以外はドライバー情報に関して全アクション拒否
		if (isset($user) && $user['role'] == ROLE_SYSTEM) {
			return true;
		}

		return parent::isAuthorized($user);
	}

	/**
	 * 全ての通知一覧を表示する
	 *
	 * 権限：システム管理者
	 * ログイン要否：要
	 * 画面遷移：一覧画面
	 *
	 * @return Response|void
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
			$userNotices = $this->paginate($this->UserNotices->find('all', ['order' => $sort]));
		} else {
			if ($this->request->getQuery('user_id') != '') {
				$conditions['user_id'] = $this->request->getQuery('user_id');
			}
			if ($this->request->getQuery('from_user_id') != '') {
				$conditions['from_user_id'] = $this->request->getQuery('from_user_id');
			}
			if ($this->request->getQuery('notice_date_start') != '') {
				$conditions['notice_date >='] = $this->request->getQuery('notice_date_start');
			}
			if ($this->request->getQuery('notice_date_end') != '') {
				$conditions['notice_date <='] = $this->request->getQuery('notice_date_end');
			}
			$userNotices = $this->paginate($this->UserNotices->find('all', ['order' => $sort,
				'conditions' => $conditions]));
		}

		$this->set(compact('userNotices'));
	}

	/**
	 * 自身が出した通知の一覧を表示する
	 *
	 * 権限：システム管理者
	 * ログイン要否：要
	 * 画面遷移：一覧画面
	 *
	 * @return Response|void
	 */
	public function myNotice() {
		$this->viewBuilder()->setLayout('editor_layout');

		$conditions = [];
		$conditions['from_user_id'] = $this->request->session()->read('Auth.User.id');
		$sort = ['created' => 'desc'];

		if ($this->request->getQuery('sort') && $this->request->getQuery('direction')) {
			$sort = [$this->request->getQuery('sort') => $this->request->getQuery('direction')];
		}

		//検索条件のクリアが選択された場合は全件検索をする
		if ($this->request->getQuery('submit_btn') == 'clear') {
			$userNotices = $this->paginate($this->UserNotices->find('all', ['order' => $sort]));
		} else {
			if ($this->request->getQuery('user_id') != '') {
				$conditions['user_id'] = $this->request->getQuery('user_id');
			}
			if ($this->request->getQuery('from_user_id') != '') {
				$conditions['from_user_id'] = $this->request->getQuery('from_user_id');
			}
			if ($this->request->getQuery('notice_date_start') != '') {
				$conditions['notice_date >='] = $this->request->getQuery('notice_date_start');
			}
			if ($this->request->getQuery('notice_date_end') != '') {
				$conditions['notice_date <='] = $this->request->getQuery('notice_date_end');
			}
			$userNotices = $this->paginate($this->UserNotices->find('all', ['order' => $sort,
				'conditions' => $conditions]));
		}

		$this->set(compact('userNotices'));
	}

	/**
	 * 通知の詳細を表示するための画面
	 *
	 * 権限：だれでも
	 * ログイン要否：要
	 * 画面遷移：詳細画面
	 *
	 * @param string|null $id User id.
	 * @return Response|null
	 */
	public function view($id = null) {
		$this->viewBuilder()->setLayout('my_layout');
		$userNotice = $this->UserNotices->get($id, ['contain' => []]);

		if ($this->request->session()->read('Auth.User.role') != ROLE_SYSTEM && $this->request->session()
				->read('Auth.User.id') != $userNotice->from_user_id) {
			$this->Flash->error(__('ご指定の操作は権限がありません。'));
			return $this->redirect(['controller' => 'pages',
				'action' => 'error_user_roll']);
		}

		$this->set('team', $userNotice);
	}

	/**
	 * 通知を新たに発行するメソッド
	 *
	 * 権限：だれでも
	 * ログイン要否：要
	 * 画面遷移：ログイン画面へ遷移
	 */
	public function add() {
		$this->viewBuilder()->setLayout('editor_layout');
		$userNotice = $this->UserNotices->newEntity();

		if ($this->request->is('post')) {
			// 全ユーザーに対して通知する
			$userList = TableRegistry::get('Users')->find()->all();

			// 通知するデータを登録
			$userNotice = $this->UserNotices->patchEntity($userNotice, $this->request->getData());

			// トランザクション開始
			$connection = ConnectionManager::get('default');
			$connection->begin();

			// ファイルのアップロード処理
			$dir = realpath(WWW_ROOT."/upload_img");

			try {
				// アイコンイメージの物理ファイルを保存フォルダへ移動し、データベースへそのパスを登録する。
				$icon_image_path = $this->request->getData('icon_image_path');
				if (!is_null($icon_image_path)) {
					if ($icon_image_path['tmp_name'] != '') {
						$uploadedFileName = FileUtil::file_upload($this->request->getData('icon_image_path'), $dir,
							UPLOAD_ICON_IMAGE_CAPACITY);
						$userNotice->icon_image_path = '/upload_img/'.$uploadedFileName;
					} else {
						$userNotice->icon_image_path = null;
					}
				}

				$userNotice->user_id = $this->request->session()->read('Auth.User.id');
				$userNotice->notice_level = NOTICE_ALL;

				if ($this->UserNotices->save($userNotice)) {
					$registrationResult = true;
					$userNoticeFlagTable = TableRegistry::get('UserNoticeFlags');

					// 全ユーザーに対して通知する
					foreach ($userList as $user) {
						$userNoticeFlag = $userNoticeFlagTable->newEntity();
						$userNoticeFlag->user_id = $user->id;
						$userNoticeFlag->user_notice_id = $userNotice->id;
						$userNoticeFlag->open_flg = false;

						if (!$userNoticeFlagTable->save($userNoticeFlag)) {
							$registrationResult = false;
							break;
						}
					}

					if ($registrationResult) {
						// コミット
						$connection->commit();
						$this->Flash->success(__('正常に通知を発行できました。'));

						return $this->redirect(array('action' => 'index'));
					} else {
						$connection->rollback();
						$this->Flash->error(__('入力エラーが発生しました'));
					}
				} else {
					$connection->rollback();
					$this->Flash->error(__('入力エラーが発生しました'));
				}
			} catch (RuntimeException $e) {
				$connection->rollback();
				$this->Flash->error(__('ファイルのアップロードができませんでした.'));
				$this->Flash->error(__($e->getMessage()));
			}
		}

		$this->set(compact('userNotice'));
	}

	/**
	 * 発行した通知を編集するメソッド
	 * ※自身で発行した通知前のものに限り編集を可
	 *
	 * 権限：だれでも
	 * ログイン要否：要
	 * 画面遷移：編集画面
	 *
	 * @param string|null $id User id.
	 * @return Response|null
	 */
	public function edit($id = null) {
		$this->viewBuilder()->setLayout('editor_layout');
		$userNotice = $this->UserNotices->get($id, ['contain' => []]);

		if ($this->request->session()->read('Auth.User.role') != ROLE_SYSTEM && $this->request->session()
				->read('Auth.User.id') != $userNotice->user_id) {
			$this->Flash->error(__('ご指定の操作は権限がありません。'));
			return $this->redirect(['controller' => 'pages',
				'action' => 'error_user_roll']);
		}

		if ($this->request->is(['patch',
			'post',
			'put'])) {
			$userNotice = $this->UserNotices->patchEntity($userNotice, $this->request->getData());

			if ($userNotice->send_date < Time::now()) {
				$this->Flash->error(__('通知予定日を超えた通知は編集できません。'));
				return $this->redirect(['controller' => 'pages',
					'action' => 'error_user_roll']);
			}

			// トランザクション開始
			$connection = ConnectionManager::get('default');
			$connection->begin();

			// ファイルのアップロード処理
			$dir = realpath(WWW_ROOT."/upload_img");

			try {
				// アイコンイメージの物理ファイルを保存フォルダへ移動し、データベースへそのパスを登録する。
				$icon_image_path = $this->request->getData('icon_image_path');
				if (!is_null($icon_image_path)) {
					if ($icon_image_path['tmp_name'] != '') {
						$uploadedFileName = FileUtil::file_upload($this->request->getData('icon_image_path'), $dir,
							UPLOAD_ICON_IMAGE_CAPACITY);
						$userNotice->icon_image_path = '/upload_img/'.$uploadedFileName;
					} else {
						$userNotice->icon_image_path = null;
					}
				}

				if ($this->UserNotices->save($userNotice)) {
					// コミット
					$connection->commit();
					$this->Flash->success(__('正常に通知を更新できました。'));

					return $this->redirect(array('action' => 'index'));
				} else {
					$connection->rollback();
					$this->Flash->error(__('入力エラーが発生しました'));
				}
			} catch (RuntimeException $e) {
				$connection->rollback();
				$this->Flash->error(__('ファイルのアップロードができませんでした.'));
				$this->Flash->error(__($e->getMessage()));
			}
		}
		$this->set(compact('userNotice'));
	}

	/**
	 * 通知を削除する
	 *
	 * 権限：だれでも
	 * ログイン要否：要
	 * 画面遷移：なし
	 *
	 * @param string|null $id User id.
	 * @return Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post',
			'delete']);

		$userNotice = $this->UserNotices->get($id);

		if ($this->request->session()->read('Auth.User.role') != ROLE_SYSTEM && $this->request->session()
				->read('Auth.User.id') != $userNotice->from_user_id) {
			$this->Flash->error(__('ご指定の操作は権限がありません。'));
			return $this->redirect(['controller' => 'pages',
				'action' => 'error_user_roll']);
		}

		if ($this->UserNotices->delete($userNotice)) {
			$this->Flash->success(__('通知を削除いたしました。'));
		} else {
			$this->Flash->error(__('通知を削除できませんでした。'));
		}

		return $this->redirect(['action' => 'index']);
	}

	/**
	 * 編集画面にてアイコン画像を削除するためのメソッド
	 *
	 * @param null $id
	 * @return mixed
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：なし
	 */
	public function deleteIconImageOnEdit($id = null) {
		$userNotice = $this->UserNotices->get($id);

		if (FileUtil::deleteIconImageOnEdit($userNotice, $this->UserNotices)) {
			$this->Flash->success(__('アイコン画像を削除しました。'));
		} else {
			$this->Flash->error(__('アイコン画像の削除に失敗しました。'));
		}

		$this->set(compact('userNotice'));
		return $this->redirect($this->referer());
	}
}
