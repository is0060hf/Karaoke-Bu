<?php

namespace App\Controller;

use Cake\Auth\DefaultPasswordHasher;
use Cake\Datasource\ConnectionManager;
use Cake\Event\Event;
use Cake\Filesystem\File;
use Cake\Mailer\Email;
use Cake\Mailer\TransportFactory;
use RuntimeException;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 *
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UsersController extends AppController {

	/**
	 * パスワード用のハッシュ関数
	 * @param $password
	 * @return mixed
	 */
	public function hash($password) {
		if (strlen($password) > 0) {
			return (new DefaultPasswordHasher)->hash($password);
		}
		return '';
	}

	/**
	 * ログインしていなくてもアクセスできるページを定義する
	 * 基本的に、ログアウトのみ
	 * ユーザーに関しては権限エラーも
	 * @param Event $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(Event $event) {
		parent::beforeFilter($event);
		$this->Auth->allow(['logout',
			'forbidden',
			'add',
			'ajaxGetPrefecture',
			'auth',
			'view',
			'index']);
	}

	public function isAuthorized($user) {
		// 誰でも許可するアクション
		if (in_array($this->request->getParam('action'), ['forbidden',
			'logout',
			'add',
			'ajaxGetPrefecture',
			'auth',
			'view',
			'index'])) {
			return true;
		}

		// 本人のみ許可するアクション(各アクションで処理)
		if (in_array($this->request->getParam('action'), ['passwordUpdate',
			'unsubscribe',
			'edit'])) {
			return true;
		}

		// システム管理者のみ許可するアクション
		if (isset($user) && $user['role'] == ROLE_SYSTEM) {
			return true;
		}

		return parent::isAuthorized($user);
	}

	/**
	 * 伝票入力欄にて配達員の情報が変更されたときに呼び出される関数
	 * @throws \Exception
	 */
	function ajaxGetPrefecture() {
		$this->autoRender = FALSE;
		$this->response->type('json');

		if (!$this->request->is('ajax')) {
			throw new \Exception();
		}

		$region = $this->request->getQuery('region');
		$result = [];
		if ($region != -1) {
			$prefectures = REGION_PREFECTURE_MAPPING[$region];

			foreach ($prefectures as $prefecture) {
				$prefectureResult = ['prefectureCode' => $prefecture,
					'prefectureValue' => PREFECTURE_ARRAY[$prefecture]];
				array_push($result, $prefectureResult);
			}
		}

		$error = [];

		// json_encodeを使用してJSON形式で返却
		echo json_encode(compact('status', 'result', 'error'));
	}

	/**
	 * 権限エラーが発生した際の遷移策
	 */
	public function forbidden() {
		$this->viewBuilder()->setLayout('my_error_layout');
	}

	/**
	 * IDとパスワードでログイン処理をする
	 * 成功した場合は、親クラスに設定したパスへ遷移する
	 * @return \Cake\Http\Response|null
	 */
	public function login() {
		$this->viewBuilder()->setLayout('my_login_layout');
		if ($this->request->is('post')) {
			$login_name = $this->request->getData('login_name');
			$user = $this->Users->find('All')->where(['login_name' => $login_name])->first();

			if ($user) {
				$password = $this->request->getData('password');
				if (password_verify($password, $user->password)) {
					$this->Auth->setUser($user);
					return $this->redirect($this->Auth->redirectUrl());
				}
			}
			$this->Flash->error(__('ログイン情報に誤りがあります。'));
		}
		$this->set(compact('user'));
		return null;
	}

	/**
	 * ログアウト処理を実施する
	 * @return \Cake\Http\Response|null
	 */
	public function logout() {
		$this->request->session()->destroy();
		return $this->redirect($this->Auth->logout());
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
			$users = $this->paginate($this->Users->find('all', ['order' => $sort]));
		} else {
			if ($this->request->getQuery('mail_address') != '') {
				$conditions['mail_address like'] = '%'.$this->request->getQuery('mail_address').'%';
			}
			if ($this->request->getQuery('role') != '' && $this->request->getQuery('role') != '-1') {
				$conditions['role'] = $this->request->getQuery('role');
			}
			$users = $this->paginate($this->Users->find('all', ['order' => $sort,
				'conditions' => $conditions]));
		}

		$this->set(compact('users'));
	}

	/**
	 * View method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|void
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function view($id = null) {
		$this->viewBuilder()->setLayout('my_layout');
		$user = $this->Users->get($id, ['contain' => []]);

		$this->set('user', $user);
	}

	/**
	 * メール認証要のメソッド
	 *
	 * 権限：だれでも
	 * ログイン要否：不要
	 * 画面遷移：なし
	 *
	 */
	public function auth() {
		$this->request->allowMethod(['get']);
		$query = $this->request->getQuery('query');

		if ($query) {
			$user = $this->Users->find('All')->where(['uuid' => $query])->first();

			if ($user) {

				if ($user->auth_flg) {
					$this->Flash->success(__('この認証URLは既に認証済みです。'));
					return $this->redirect(['controller' => 'tops',
						'action' => 'index']);
				} else {
					$user->auth_flg = true;
					$user->uuid = null;

					if ($this->Users->save($user)) {
						return $this->redirect(['controller' => 'pages',
							'action' => 'complete_user_authentication']);
					} else {
						return $this->redirect(['controller' => 'pages',
							'action' => 'error_user_authentication']);
					}
				}

			} else {
				$this->Flash->success(__('この認証URLは無効です。'));
				return $this->redirect(['controller' => 'tops',
					'action' => 'index']);
			}

		} else {
			$this->Flash->success(__('この認証URLのフォーマットは不正です。'));
			return $this->redirect(['controller' => 'tops',
				'action' => 'index']);
		}

	}

	/**
	 * 会員情報を追加するメソッド
	 * 権限：だれでも
	 * 画面遷移：ログイン画面へ遷移
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add() {
		$this->viewBuilder()->setLayout('editor_layout');
		$user = $this->Users->newEntity();
		if ($this->request->is('post')) {
			$user = $this->Users->patchEntity($user, $this->request->getData());

			// ファイルのアップロード処理
			$dir = realpath(WWW_ROOT."/upload_img");

			try {
				//カバーイメージの物理ファイルを保存フォルダへ移動し、データベースへそのパスを登録する。
				$cover_image_path = $this->request->getData('cover_image_path');
				// nullの場合は既に画像があってフォームが表示されていない場合なので何もしない
				if (!is_null($cover_image_path)) {
					// tmp_nameがセットされていない場合はフォームが表示されているがファイルがアップされていない状態
					if ($cover_image_path['tmp_name'] != '') {
						$uploadedFileName = $this->file_upload($this->request->getData('cover_image_path'), $dir,
							UPLOAD_COVER_IMAGE_CAPACITY);
						$user->cover_image_path = '/upload_img/'.$uploadedFileName;
					} else {
						$user->cover_image_path = null;
					}
				}

				// アイコンイメージの物理ファイルを保存フォルダへ移動し、データベースへそのパスを登録する。
				$icon_image_path = $this->request->getData('icon_image_path');
				if (!is_null($icon_image_path)) {
					if ($icon_image_path['tmp_name'] != '') {
						$uploadedFileName = $this->file_upload($this->request->getData('icon_image_path'), $dir,
							UPLOAD_ICON_IMAGE_CAPACITY);
						$user->icon_image_path = '/upload_img/'.$uploadedFileName;
					} else {
						$user->icon_image_path = null;
					}
				}

				$user->password = password_hash($user->password, PASSWORD_DEFAULT);
				$sha_query = sha1($user->mail_address.$user->password);
				$user->auth_flg = false;
				$user->uuid = $sha_query;

				if ($this->request->getData('password') === $this->request->getData('confirm_password')) {
					// トランザクション開始
					$connection = ConnectionManager::get('default');
					$connection->begin();

					if ($this->Users->save($user)) {
						TransportFactory::setConfig('mailtrap', ['host' => 'smtp.mailtrap.io',
							'port' => 2525,
							'username' => '294cde5d2866a3',
							'password' => '0553a77e71612a',
							'className' => 'Smtp']);
						$email = new Email('default');
						$email_body = AUTH_MAIL_BODY;
						$one_time_url = 'http://localhost:8000/users/auth?query='.$sha_query;
						$email_body = str_replace("{{_$1_}}", $user->nick_name, $email_body);
						$email_body = str_replace("{{_$2_}}", $one_time_url, $email_body);
						$email->from([MAIL_FROM_ADDRESS => MAIL_FROM_NAME])->to($user->mail_address)->subject(AUTH_MAIL_TITLE)
							->send($email_body);

						$connection->commit();

						$this->Flash->success(__('ご登録ありがとうございました。'));
						return $this->redirect(['controller' => 'pages',
							'action' => 'complete_user_registration']);
					} else {
						$connection->rollback();
						$this->Flash->error(__('ユーザー登録中に予期しないエラーが発生しました。'));
					}
				} else {
					$this->Flash->error(__('パスワードと確認用パスワードが一致しません。'));
				}
			} catch (RuntimeException $e) {
				$this->Flash->error(__('ファイルのアップロードができませんでした.'));
				$this->Flash->error(__($e->getMessage()));
			}
		}
		$this->set(compact('user'));
		return null;
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function edit($id = null) {
		if ($this->request->session()->read('Auth.User.role') != ROLE_SYSTEM && $this->request->session()
				->read('Auth.User.id') != $id) {
			$this->Flash->error(__('ご指定の操作は権限がありません。'));
			return $this->redirect(['controller' => 'pages',
				'action' => 'error_user_roll']);
		}

		$this->viewBuilder()->setLayout('editor_layout');
		$user = $this->Users->get($id, ['contain' => []]);

		if ($this->request->is(['patch',
			'post',
			'put'])) {
			$user = $this->Users->patchEntity($user, $this->request->getData());

			// ファイルのアップロード処理
			$dir = realpath(WWW_ROOT."/upload_img");

			try {
				//カバーイメージの物理ファイルを保存フォルダへ移動し、データベースへそのパスを登録する。
				$cover_image_path = $this->request->getData('cover_image_path');
				// nullの場合は既に画像があってフォームが表示されていない場合なので何もしない
				if (!is_null($cover_image_path)) {
					// tmp_nameがセットされていない場合はフォームが表示されているがファイルがアップされていない状態
					if ($cover_image_path['tmp_name'] != '') {
						$uploadedFileName = $this->file_upload($this->request->getData('cover_image_path'), $dir,
							UPLOAD_COVER_IMAGE_CAPACITY);
						$user->cover_image_path = '/upload_img/'.$uploadedFileName;
					} else {
						$user->cover_image_path = null;
					}
				}

				// アイコンイメージの物理ファイルを保存フォルダへ移動し、データベースへそのパスを登録する。
				$icon_image_path = $this->request->getData('icon_image_path');
				if (!is_null($icon_image_path)) {
					if ($icon_image_path['tmp_name'] != '') {
						$uploadedFileName = $this->file_upload($this->request->getData('icon_image_path'), $dir,
							UPLOAD_ICON_IMAGE_CAPACITY);
						$user->icon_image_path = '/upload_img/'.$uploadedFileName;
					} else {
						$user->icon_image_path = null;
					}
				}


				// トランザクション開始
				$connection = ConnectionManager::get('default');
				$connection->begin();

				if ($this->Users->save($user)) {
					$connection->commit();

					$this->Flash->success(__('会員情報を正常に更新致しました。'));
					return $this->redirect(['action' => 'view',
						$user->id]);
				} else {
					$connection->rollback();
					$this->Flash->error(__('ユーザー登録中に予期しないエラーが発生しました。'));
				}

			} catch (RuntimeException $e) {
				$this->Flash->error(__('ファイルのアップロードができませんでした.'));
				$this->Flash->error(__($e->getMessage()));
			}
		}
		$this->set(compact('user'));
		return null;
	}

	/**
	 * Edit method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function passwordUpdate($id = null) {
		if ($this->request->session()->read('Auth.User.role') != ROLE_SYSTEM && $this->request->session()
				->read('Auth.User.id') != $id) {
			$this->Flash->error(__('ご指定の操作は権限がありません。'));
			return $this->redirect(['controller' => 'pages',
				'action' => 'error_user_roll']);
		}

		$this->viewBuilder()->setLayout('editor_layout');

		$user = $this->Users->get($id, ['contain' => []]);
		if ($this->request->is(['patch',
			'post',
			'put'])) {
			$old_password = $this->request->getData('old_password');
			if (password_verify($old_password, $user->password)) {
				if ($this->request->getData('password') === $this->request->getData('confirm_password')) {
					$user->password = $this->request->getData('password');
					$user->password = password_hash($user->password, PASSWORD_DEFAULT);
					if ($this->Users->save($user)) {
						TransportFactory::setConfig('mailtrap', ['host' => 'smtp.mailtrap.io',
							'port' => 2525,
							'username' => '294cde5d2866a3',
							'password' => '0553a77e71612a',
							'className' => 'Smtp']);
						$email = new Email('default');
						$email_body = UPDATE_PASSWORD_MAIL_BODY;
						$email_body = str_replace("{{_$1_}}", $user->nick_name, $email_body);
						$email->from([MAIL_FROM_ADDRESS => MAIL_FROM_NAME])->to($user->mail_address)
							->subject(UPDATE_PASSWORD_MAIL_TITLE)->send($email_body);

						$this->Flash->success(__('パスワードを正常に更新しました'));
						return $this->redirect(['action' => 'view',
							$user->id]);
					} else {
						$this->Flash->error(__('システムエラーが発生致しました。'));
					}
				} else {
					$this->Flash->error(__('確認用パスワードと一致しません。'));
				}
			} else {
				$this->Flash->error(__('入力されたパスワードが異なります。'));
			}

		}
		$this->set(compact('user'));
		return null;
	}

	public function file_upload($file = null, $dir = null, $limitFileSize = 1024 * 1024) {
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
				throw new RuntimeException('Exceeded filesize limit.');
			}

			// ファイルタイプのチェックし、拡張子を取得
			if (false === $ext = array_search($fileInfo->mime(), ['jpg' => 'image/jpeg',
					'jpeg' => 'image/jpeg',
					'png' => 'image/png',
					'gif' => 'image/gif',], true)) {
				throw new RuntimeException('画像ファイル以外がアップロードされました。');
			}

			// ファイル名の生成
			//            $uploadFile = $file["name"] . "." . $ext;
			$uploadFile = sha1_file($file["tmp_name"]).".".$ext;

			// ファイルの移動
			if (!move_uploaded_file($file["tmp_name"], $dir."/".$uploadFile)) {
				throw new RuntimeException('Failed to move uploaded file.');
			}

			// 処理を抜けたら正常終了
			//            echo 'File is uploaded successfully.';

		} catch (RuntimeException $e) {
			throw $e;
		}
		return $uploadFile;
	}

	/**
	 * 退会処理を行う為のメソッド
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：
	 * @param null $id
	 * @return \Cake\Http\Response|null
	 */
	public function unsubscribe($id = null) {
		if ($this->request->session()->read('Auth.User.id') != $id) {
			$this->Flash->error(__('ご指定の操作は権限がありません。'));
			return $this->redirect(['controller' => 'pages',
				'action' => 'error_user_roll']);
		}

		$this->viewBuilder()->setLayout('editor_layout');
		$user = $this->Users->get($id);

		if ($this->request->is(['patch',
			'post',
			'put'])) {
			$password = $this->request->getData('password');
			if (password_verify($password, $user->password)) {
				if ($this->Users->delete($user)) {
					$this->Flash->success(__('退会処理が完了致しました。'));
					$this->Auth->logout();
					$this->request->session()->destroy();
					return $this->redirect(['controller' => 'pages',
						'action' => 'complete_user_unsubscribe']);
				} else {
					$this->Flash->error(__('退会処理中にエラーが発生しました。。'));
				}
			} else {
				$this->Flash->error(__('入力されたパスワードが異なります。'));
			}
		}
		$this->set(compact('user'));
	}

	/**
	 * Delete method
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null) {
		$this->request->allowMethod(['post',
			'delete']);
		$user = $this->Users->get($id);
		if ($this->Users->delete($user)) {
			$this->Flash->success(__('ドライバー情報を削除いたしました。'));
		} else {
			$this->Flash->error(__('ドライバー情報を削除できませんでした。'));
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
		$user = $this->Users->get($id);

		if ($user->icon_image_path != '') {
			if (file_exists($user->icon_image_path)) {
				unlink(WWW_ROOT.$user->icon_image_path);
			}
		}

		$user->icon_image_path = null;
		if ($this->Users->save($user)) {
			$this->Flash->success(__('アイコン画像を削除しました。'));
		} else {
			$this->Flash->error(__('アイコン画像の削除に失敗しました。'));
		}

		$this->set(compact('user'));
		return $this->redirect($this->referer());
	}

	/**
	 * 編集画面にてカバー画像を削除するためのメソッド
	 *
	 * @param null $id
	 * @return mixed
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：なし
	 */
	public function deleteCoverImageOnEdit($id = null) {
		$user = $this->Users->get($id);

		if ($user->cover_image_path != '') {
			if (file_exists($user->cover_image_path)) {
				unlink(WWW_ROOT.$user->cover_image_path);
			}
		}

		$user->cover_image_path = null;
		if ($this->Users->save($user)) {
			$this->Flash->success(__('カバー画像を削除しました。'));
		} else {
			$this->Flash->error(__('カバー画像の削除に失敗しました。'));
		}

		$this->set(compact('user'));
		return $this->redirect($this->referer());
	}
}
