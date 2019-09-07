<?php

	namespace App\Controller;

	use App\Util\ModelUtil;
	use Cake\Event\Event;
	use Cake\ORM\TableRegistry;
	use PhpOffice\PhpSpreadsheet\Spreadsheet;
	use PhpOffice\PhpSpreadsheet\Settings;
	use Cake\Auth\DefaultPasswordHasher;


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
			$this->Auth->allow(['logout', 'forbidden', 'add']);
		}

		public function isAuthorized($user) {
			//ログアウトと権限エラー時はスルー
			if (in_array($this->request->getParam('action'), ['forbidden', 'logout', 'add'])) {
				return true;
			}

			// システム管理者以外はドライバー情報に関して全アクション拒否
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
			if($region != -1){
				$prefectures = REGION_PREFECTURE_MAPPING[$region];

				foreach ($prefectures as $prefecture) {
					$prefectureResult = [
						'prefectureCode' => $prefecture,
						'prefectureValue' => PREFECTURE_ARRAY[$prefecture]
					];
					array_push($result,$prefectureResult);
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
					error_log(print_r($password,true),"3",ROOT."/logs/debug.log");

					if(password_verify($password, $user->password)){
						$this->Auth->setUser($user);
						return $this->redirect($this->Auth->redirectUrl());
					}
				}
				$this->Flash->error(__('ログイン情報に誤りがあります。'));
			}
			$this->set(compact('user'));
		}

		/**
		 * ログアウト処理を実施する
		 * @return \Cake\Http\Response|null
		 */
		public function logout() {
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
				$users = $this->paginate($this->Users->find('all', ['order' => $sort, 'conditions' => $conditions]));
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
			$user = $this->Users->get($id, [
					'contain' => []
			]);

			$this->set('user', $user);
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
				$user->password = password_hash($user->password,PASSWORD_DEFAULT);
				if ($this->Users->save($user)) {
					$this->Flash->success(__('ご登録ありがとうございました。'));
					return $this->redirect(['action' => 'login']);
				}
				$this->Flash->error(__('サーバーエラーにより登録ができませんでした。'));
			}
			$this->set(compact('user'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id User id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function edit($id = null) {
			$this->viewBuilder()->setLayout('editor_layout');
			$user = $this->Users->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$user = $this->Users->patchEntity($user, $this->request->getData());
				if ($this->Users->save($user)) {
					$this->Flash->success(__('会員情報を正常に更新致しました。'));
					return $this->redirect(['action' => 'view', $user->id]);
				}
				$this->Flash->error(__('会員情報を更新できませんでした。'));
			}
			$this->set(compact('user'));
		}

		/**
		 * Edit method
		 *
		 * @param string|null $id User id.
		 * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
		 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
		 */
		public function passwordUpdate($id = null) {
			$user = $this->Users->get($id, [
					'contain' => []
			]);
			if ($this->request->is(['patch', 'post', 'put'])) {
				$user = $this->Users->patchEntity($user, $this->request->getData());
				if ($this->Users->save($user)) {
					$this->Flash->success(__('パスワードを正常に更新しました'));
					return $this->redirect(['action' => 'view', $user->id]);
				}
				$this->Flash->error(__('パスワードを更新できませんでした。'));
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
			$this->request->allowMethod(['post', 'delete']);
			$user = $this->Users->get($id);
			if ($this->Users->delete($user)) {
				$this->Flash->success(__('ドライバー情報を削除いたしました。'));
			} else {
				$this->Flash->error(__('ドライバー情報を削除できませんでした。'));
			}

			return $this->redirect(['action' => 'index']);
		}
	}
