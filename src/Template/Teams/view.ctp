<?php
	/**
	 * @var \App\View\AppView $this
	 * @var \App\Model\Entity\Team $team
	 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Users', 'action'=>'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Teams', 'action'=>'index']); ?>">チーム一覧</a></li>
		<li class="breadcrumb-item active">チーム情報詳細</li>
	</ol>
</div>

<div class="users view large-9 medium-8 columns content">
	<legend>チーム情報詳細</legend>
	<table class="table mb-4">
		<tr>
			<th scope="row"><?= __('チーム名') ?></th>
			<td><?= h($team->team_name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('一言紹介文') ?></th>
			<td><?= h($team->introduction) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('作成日') ?></th>
			<td><?= h($team->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('更新日') ?></th>
			<td><?= h($team->modified) ?></td>
		</tr>
	</table>
	<div class="row">
		<div class="col-12 text-center">
			<a href="<?= $this->Url->build(['controller'=>'Teams','action'=>'edit',$team->id]); ?>" class="btn btn-success mr-3">
				<i class="fe-edit"></i>
				<span>編集する</span>
			</a>
			<a href="<?= $this->Url->build(['controller'=>'Teams','action'=>'index']); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
</div>
