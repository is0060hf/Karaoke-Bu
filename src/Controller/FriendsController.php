<?php

namespace App\Controller;

use Cake\Event\Event;


/**
 * Users Controller
 *
 * @property \App\Model\Table\FriendsTable $Friends
 *
 * @method \App\Model\Entity\Team[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FriendsController extends AppController
{

	/**
	 * ログインしていなくてもアクセスできるページを定義する
	 * フレンド機能はログイン前提の機能なので未ログイン状態ではアクセスできない。
	 * @param Event $event
	 * @return \Cake\Http\Response|null|void
	 */
	public function beforeFilter(Event $event)
	{
		parent::beforeFilter($event);
	}

	/**
	 * ロールによってアクセスできるページを定義する
	 * フレンド機能はロールによってアクセスできない機能はない
	 * @param $user
	 * @return bool
	 */
	public function isAuthorized($user)
	{
		//基本的に全てのユーザーが全ての機能にアクセス可能
		return true;
	}

	/**
	 * ともだちの一覧を表示する機能
	 * ともだちが一人もいない場合は、友達登録する旨のメッセージを表示するように促す
	 * 　→これはView側で行う為こちら側で処理することはない
	 *
	 * ともだちの検索条件は下記の通り
	 * ・名前（部分一致）
	 * ・id（完全一致）
	 *
	 * ともだちは、一覧から検索して登録するほか、イベントから登録することも可能にする
	 *
	 * 権限：だれでも
	 * ログイン要否：要
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
			$friends = $this->paginate($this->Friends->find('all', ['order' => $sort]));
		} else {
			if ($this->request->getQuery('mail_address') != '') {
				$conditions['mail_address like'] = '%'.$this->request->getQuery('mail_address').'%';
			}
			if ($this->request->getQuery('role') != '' && $this->request->getQuery('role') != '-1') {
				$conditions['role'] = $this->request->getQuery('role');
			}
			$friends = $this->paginate($this->Friends->find('all', ['order' => $sort, 'conditions' => $conditions]));
		}

		$this->set(compact('friends'));
	}

	/**
	 * srcUserがdestUserのことをともだち登録しているかを判定するメソッド
	 * @param $srcUserId
	 * @param $destUserId
	 * @return bool
	 */
	public function isFriend($srcUserId, $destUserId)
	{
		$friend = $this->Friends->find('All')->where(['src_friend' => $srcUserId, 'dest_friend' => $destUserId])->first();

		if ($friend) {
			return true;
		} else {
			return false;
		}
	}

	/**
	 * srcUserとdestUserがお互いにともだち登録しているかを判定するメソッド
	 * @param $srcUserId
	 * @param $destUserId
	 * @return bool
	 */
	public function isFriendEachOther($srcUserId, $destUserId)
	{
		$isFriend = $this->isFriend($srcUserId, $destUserId);
		$isFriendBack = $this->isFriend($destUserId, $srcUserId);
		return $isFriend && $isFriendBack;
	}

	/**
	 * ともだちの登録処理をする
	 *
	 * 権限：だれでも
	 * ログイン要否：要
	 * 画面遷移：画面遷移なし
	 * @param null $destUserId
	 * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
	 */
	public function add($destUserId = null)
	{
		$this->request->allowMethod(['post']);
		$myUserId = $this->request->session()->read('Auth.User.id');

		if ($destUserId) {
			if ($myUserId == $destUserId) {
				$this->Flash->error(__('自分自身とはともだち登録できません。'));

				$url = $this->referer(array('action' => 'index'));
				return $this->redirect($url);
			}

			if ($this->isFriend($myUserId, $destUserId)) {
				$this->Flash->error(__('既にともだち登録されています。'));

				$url = $this->referer(array('action' => 'index'));
				return $this->redirect($url);
			} else {
				$friend = $this->Friends->newEntity();
				$friend->src_friend = $myUserId;
				$friend->dest_friend = $destUserId;

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

		$url = $this->referer(array('action' => 'index'));
		return $this->redirect($url);
	}

	/**
	 * ともだち登録を解除するメソッド
	 * 権限：だれでも
	 * ログイン要否：要
	 * 画面遷移：なし
	 *
	 * @param string|null $id User id.
	 * @return \Cake\Http\Response|null Redirects to index.
	 * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
	 */
	public function delete($id = null)
	{
		$this->request->allowMethod(['post', 'delete']);
		$friend = $this->Friends->get($id);

		if ($this->Friends->delete($friend)) {
			$this->Flash->success(__('ともだち登録を解除しました。。'));
		} else {
			$this->Flash->error(__('ともだち登録に失敗しました。もう一度お試しください。'));
		}

		$url = $this->referer(array('action' => 'index'));
		return $this->redirect($url);
	}
}
