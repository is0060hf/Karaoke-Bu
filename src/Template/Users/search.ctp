<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<div class="row">
	<div class="col-6 breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Users',
						'action' => 'index']); ?>">Home</a></li>
			<li class="breadcrumb-item active">会員情報一覧</li>
		</ol>
	</div>
	<div class="col-2 offset-4 text-right">
		<a href="<?= $this->Url->build(['controller' => 'Users',
			'action' => 'add']); ?>" class="btn btn-success mt-2">
			<i class="fe-git-pull-request"></i>
			<span>新規登録する</span>
		</a>
	</div>
</div>


<div class="users index large-9 medium-8 columns content">
	<legend><?= __('会員情報一覧') ?></legend>
	<table cellpadding="0" cellspacing="0" class="table table-hover mb-0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('username', '氏名') ?></th>
			<th scope="col"><?= $this->Paginator->sort('mail_address', 'メールアドレス') ?></th>
			<th scope="col"><?= $this->Paginator->sort('user_role', '役割') ?></th>
			<th scope="col"><?= $this->Paginator->sort('created', '作成日') ?></th>
			<th scope="col"><?= $this->Paginator->sort('modified', '更新日') ?></th>
			<th scope="col" class="actions"><?= __('操作') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($users as $user): ?>
			<tr>
				<td class="align-middle"><a
						href="<?php echo $this->Url->build(['controller' => 'Users',
							'action' => 'view',
							$user->id]); ?>"
						class="btn btn-info"><?= h($user->username) ?></a></td>
				<td class="align-middle"><?= h($user->mail_address) ?></td>
				<td class="align-middle"><?= h($user->user_role) ?></td>
				<td class="align-middle"><?= h($user->created) ?></td>
				<td class="align-middle"><?= h($user->modified) ?></td>
				<td class="align-middle actions">
					<?= $this->Html->link(__('編集'), ['action' => 'edit',
						$user->id]) ?>
					<?= $this->Form->postLink(__('削除'), ['action' => 'delete',
						$user->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $user->id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?= $this->element('pagenate'); ?>
</div>
