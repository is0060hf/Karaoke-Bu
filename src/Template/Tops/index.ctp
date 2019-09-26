<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event[]|\Cake\Collection\CollectionInterface $events
 */

use Cake\ORM\TableRegistry;

$userList = TableRegistry::get('Users')->find()->all();
$usersNameList = [];
$usersNameList[''] = '未選択';
foreach ($userList as $usr) {
	if ($usr->username != '') {
		$usersNameList[$usr->username] = $usr->username;
	}
}
?>
<div class="row">
	<div class="col-6 breadcrumb_div">
		<ol class="breadcrumb m-b-20">
			<li class="breadcrumb-item"><a
					href="<?php echo $this->Url->build(['controller' => 'Tops',
						'action' => 'index']); ?>">Home</a></li>
		</ol>
	</div>
	<div class="col-6 text-right">
		<a href="<?= $this->Url->build(['controller' => 'Events',
			'action' => 'add']); ?>" class="btn btn-success mt-2">
			<i class="fe-file"></i>
			<span>ピックアップイベント</span>
		</a>
	</div>
</div>

<div class="users index large-9 medium-8 columns content">
	<?php
	$form_template = array('error' => '<div class="col-sm-12 error-message alert alert-danger mt-1 mb-2 py-1">{{content}}</div>',
		'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
		'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10 d-flex align-items-center">{{input}}</div>',
		'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
		'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
		'input' => '<input class="form-control" type="{{type}}" name="{{name}}" {{attrs}} data-toggle="{{data_toggle}}" maxlength="{{max_length}}" data-mask-format="{{data_mask_format}}">',
		'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
		'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>');
	?>

	<?= $this->Form->create(null, array('templates' => $form_template,
		'type' => 'get',
		'idPrefix' => 'search_form',
		'name' => 'search_form')); ?>

	<legend><?= __('ピックアップイベント') ?></legend>
	<?= $this->Form->end(); ?>
	<table cellpadding="0" cellspacing="0" class="table table-hover mb-0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('title', 'タイトル') ?></th>
			<th scope="col"><?= $this->Paginator->sort('start_time', 'イベント開始日') ?></th>
			<th scope="col"><?= $this->Paginator->sort('budget', '予算') ?></th>
			<th scope="col"><?= $this->Paginator->sort('prefecture', '開催地') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($events as $event): ?>
			<tr>
				<td class="align-middle"><a
						href="<?php echo $this->Url->build(['controller' => 'Events',
							'action' => 'view',
							$event->id]); ?>"><?= h($event->title) ?></a>
				</td>
				<td class="align-middle"><?= h($event->start_time) ?></td>
				<td class="align-middle"><?= h($event->budget) ?></td>
				<td class="align-middle"><?= h(PREFECTURE_ARRAY[$event->prefecture]) ?></td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?= $this->element('pagenate'); ?>
</div>
