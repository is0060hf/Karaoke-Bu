<?php
	/**
	 * @var \App\View\AppView $this
	 * @var \App\Model\Entity\Event $event
	 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Users', 'action'=>'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a href="<?php echo $this->Url->build(['controller'=>'Events', 'action'=>'index']); ?>">イベント情報一覧</a></li>
		<li class="breadcrumb-item active">イベント情報詳細</li>
	</ol>
</div>

<div class="users view large-9 medium-8 columns content">
	<legend>イベント情報詳細</legend>
	<table class="table mb-4">
		<tr>
			<th scope="row"><?= __('タイトル') ?></th>
			<td><?= h($event->title) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('イベント詳細') ?></th>
			<td><?= nl2br(h($event->body)) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('登録用テンプレート') ?></th>
			<td><?= nl2br(h($event->entry_template)) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('ドリンクメニュー') ?></th>
			<td><?= h($event->drink) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('フードメニュー') ?></th>
			<td><?= h($event->food) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('イベント日程') ?></th>
			<td><?= h($event->start_time) ?>から<?= h($event->end_time) ?>まで</td>
		</tr>
		<tr>
			<th scope="row"><?= __('予算') ?></th>
			<td><?= h($event->budget) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('募集時期') ?></th>
			<td><?= h($event->entry_date) ?>から<?= h($event->deadline) ?>まで</td>
		</tr>
		<tr>
			<th scope="row"><?= __('募集範囲') ?></th>
			<td><?= h($event->limited_range) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('募集人数') ?></th>
			<td><?= h($event->number_of_people) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('開催場所') ?></th>
			<td><?= h($event->region) ?>　<?= h($event->prefecture) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('緊急連絡先') ?></th>
			<td><?= h($event->phone_number) ?></td>
		</tr>
	</table>
	<div class="row">
		<div class="col-12 text-center">
			<a href="<?= $this->Url->build(['controller'=>'Events','action'=>'edit',$event->id]); ?>" class="btn btn-success mr-3">
				<i class="fe-edit"></i>
				<span>編集する</span>
			</a>
			<a href="<?= $this->Url->build(['controller'=>'Events','action'=>'index']); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
</div>
