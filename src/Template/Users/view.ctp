<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>">会員情報一覧</a></li>
		<li class="breadcrumb-item active">ユーザー詳細</li>
	</ol>
</div>

<div class="users view large-9 medium-8 columns content">
	<div class="row mb-2">
		<div class="col-12">
			<div class="user_cover_div_wrapper">
				<?php if (isset($user->cover_image_path)) { ?>
					<div class="user_cover_div" style="background-image: url(<?= $user->cover_image_path ?>)"></div>
				<?php } else { ?>
					<div class="user_cover_div" style="background-image: url('/assets/images/cover.png')"></div>
				<?php } ?>
			</div>
			<div class="rellax_icon" data-rellax-speed="1">
				<?php if (isset($user->icon_image_path)) { ?>
					<img src="<?= $user->icon_image_path ?>" alt="user-icon" class="rounded-circle">
				<?php } else { ?>
					<img src="/assets/images/users/avatar.png" alt="user-icon" class="rounded-circle">
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="row user_info_div pt-4" data-rellax-speed="1">
		<div class="col-12">
			<legend>会員情報詳細</legend>
			<table class="table mb-4">
				<tr>
					<th scope="row"><?= __('ログイン名') ?></th>
					<td><?= h($user->login_name) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('パスワード') ?></th>
					<td>セキュリティの関係で非表示</td>
				</tr>
				<tr>
					<th scope="row"><?= __('メールアドレス') ?></th>
					<td><?= h($user->mail_address) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('表示名') ?></th>
					<td><?= h($user->nick_name) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('アカウント種別') ?></th>
					<td><?= ROLE_NAME_ARRAY[$user->role] ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('一言自己紹介文') ?></th>
					<td><?= h($user->introduction) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('作成日') ?></th>
					<td><?= h($user->created) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('更新日') ?></th>
					<td><?= h($user->modified) ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-12 text-center">
			<?php
			if ($this->request->session()->read('Auth.User.role') == ROLE_SYSTEM || $this->request->session()
					->read('Auth.User.id') == $user->id) {
				?>
				<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'edit', $user->id]); ?>"
					 class="btn btn-success mr-3">
					<i class="fe-edit"></i>
					<span>編集する</span>
				</a>
				<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'password_update', $user->id]); ?>"
					 class="btn btn-outline-success mr-3">
					<i class="fe-edit"></i>
					<span>パスワード変更</span>
				</a>
				<?php
				if ($this->request->session()->read('Auth.User.id') == $user->id) {
					?>
					<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'unsubscribe', $user->id]); ?>"
						 class="btn btn-danger mr-3">
						<i class="fe-trash"></i>
						<span>退会する</span>
					</a>
					<?php
				}
			}
			?>
			<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
</div>
