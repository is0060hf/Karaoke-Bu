<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserNotice[]|\Cake\Collection\CollectionInterface $userNotices
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
			<li class="breadcrumb-item active">通知情報一覧</li>
		</ol>
	</div>
	<div class="col-6 text-right">
		<a href="<?= $this->Url->build(['controller' => 'UserNotices',
			'action' => 'add']); ?>" class="btn btn-success mt-2">
			<i class="fe-git-pull-request"></i>
			<span>新規通知発行</span>
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

	<legend><?= __('通知情報一覧') ?></legend>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body pt-4">
					<?php
					echo $this->Form->control('notice_level', array('label' => array('text' => '通知範囲',
						// labelで出力するテキスト
						'class' => 'col-form-label'
						// labelタグのクラス名
					),
						'type' => 'select',
						'options' => NOTICE_ARRAY,
						'templateVars' => array('div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '絞り込みたい通知範囲を入力してください。',
							'select_toggle' => 'select2'),
						'value' => $this->request->getQuery('notice_level'),
						'id' => 'notice_level',
						'class' => 'form-control select2'
						// inputタグのクラス名
					));

					?>

					<div class="row my-2">
						<div class="col-12 text-center">
							<button class="btn btn-outline-dark mr-3" type="button" name="submit_btn" value="clear"
											onclick="clearUserNoticeSearchElements();document.search_form.submit();">
								<i class="fe-edit"></i>
								<span>検索条件クリア</span>
							</button>
							<button class="btn btn-primary mr-3" type="submit" name="submit_btn" value="search">
								<i class="fe-edit"></i>
								<span>検索</span>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?= $this->Form->end(); ?>

	<table cellpadding="0" cellspacing="0" class="table table-hover mb-0">
		<thead>
		<tr>
			<th scope="col"><?= $this->Paginator->sort('id', 'ID') ?></th>
			<th scope="col"><?= $this->Paginator->sort('context', '通知内容') ?></th>
			<th scope="col"><?= $this->Paginator->sort('notice_level', '範囲') ?></th>
			<th scope="col"><?= $this->Paginator->sort('created', '作成日') ?></th>
			<th scope="col"><?= $this->Paginator->sort('send_date', '通知日') ?></th>
			<th scope="col" class="actions"><?= __('操作') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($userNotices as $userNotice): ?>
			<tr>
				<td class="align-middle"><a
						href="<?php echo $this->Url->build(['controller' => 'UserNotices',
							'action' => 'view',
							$userNotice->id]); ?>"
						class="btn btn-info"><?= h($userNotice->id) ?></a></td>
				<td class="align-middle"><?= h(mb_strimwidth($userNotice->context, 0, 30, '...', 'UTF-8')) ?></td>
				<td class="align-middle"><?= h(NOTICE_ARRAY[$userNotice->notice_level]) ?></td>
				<td class="align-middle"><?= h($userNotice->created) ?></td>
				<td class="align-middle"><?= h($userNotice->send_date) ?></td>
				<td class="align-middle actions">
					<?= $this->Html->link(__('編集'), ['action' => 'edit',
						$userNotice->id]) ?>
					<?= $this->Form->postLink(__('削除'), ['action' => 'delete',
						$userNotice->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $userNotice->id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?= $this->element('pagenate'); ?>
</div>
