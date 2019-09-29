<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserNotice $userNotice
 */

use Cake\I18n\Time; ?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Tops',
					'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'UserNotices',
					'action' => 'index']); ?>">通知情報一覧</a></li>
		<li class="breadcrumb-item active">通知情報詳細</li>
	</ol>
</div>

<div class="users view large-9 medium-8 columns content">
	<div class="row mb-2">
		<div class="col-12">
			<div class="user_cover_div_wrapper">
				<div class="user_cover_div" style="background-image: url('/assets/images/cover.png')"></div>
			</div>
			<div class="rellax_icon" data-rellax-speed="1">
				<?php if (isset($userNotice->icon_image_path)) { ?>
					<img src="<?= $userNotice->icon_image_path ?>" alt="user-icon" class="rounded-circle">
				<?php } else { ?>
					<img src="/assets/images/users/avatar.png" alt="user-icon" class="rounded-circle">
				<?php } ?>
			</div>
		</div>
	</div>
	<div class="row user_info_div pt-4" data-rellax-speed="1">
		<div class="col-12">
			<legend>通知情報詳細</legend>
			<table class="table mb-4">
				<tr>
					<th scope="row"><?= __('タイトル') ?></th>
					<td><?= h($userNotice->title) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('通知内容') ?></th>
					<td><?= nl2br(h($userNotice->context)) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('通知日') ?></th>
					<td><?= h($userNotice->send_date) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('作成日') ?></th>
					<td><?= h($userNotice->created) ?></td>
				</tr>
				<tr>
					<th scope="row"><?= __('更新日') ?></th>
					<td><?= h($userNotice->modified) ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="row">
		<div class="col-12 text-center">
			<?php
			if ($this->request->session()->read('Auth.User.role') == ROLE_SYSTEM || $this->request->session()
					->read('Auth.User.id') == $userNotice->user_id) {
				if ($userNotice->send_date > Time::now()) {
					?>
					<a href="<?= $this->Url->build(['controller' => 'UserNotices',
						'action' => 'edit',
						$userNotice->id]); ?>"
						 class="btn btn-success mr-3">
						<i class="fe-edit"></i>
						<span>編集する</span>
					</a>
					<?php
				}
			}
			?>
			<a href="<?= $this->Url->build(['controller' => 'UserNotices',
				'action' => 'index']); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
</div>
