<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Team[]|\Cake\Collection\CollectionInterface $teams
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
			<li class="breadcrumb-item active">チーム情報一覧</li>
		</ol>
	</div>
	<div class="col-6 text-right">
		<a href="<?= $this->Url->build(['controller' => 'Teams',
			'action' => 'add']); ?>" class="btn btn-success mt-2">
			<i class="fe-git-pull-request"></i>
			<span>新規登録する</span>
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

	<legend><?= __('チーム情報一覧') ?></legend>

	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body pt-4">
					<?php
					echo $this->Form->control('mail_address', array('label' => array('text' => 'メールアドレス',
						// labelで出力するテキスト
						'class' => 'col-form-label'
						// labelタグのクラス名
					),
						'type' => 'text',
						'options' => $usersNameList,
						'templateVars' => array('div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '絞り込みたい配達員の名前を入力してください。',),
						'value' => $this->request->getQuery('mail_address'),
						'id' => 'mail_address',
						'class' => 'form-control'
						// inputタグのクラス名
					));
					echo $this->Form->control('role', array('label' => array('text' => 'ユーザー種別',
						// labelで出力するテキスト
						'class' => 'col-form-label'
						// labelタグのクラス名
					),
						'type' => 'select',
						'options' => ROLE_NAME_ARRAY,
						'templateVars' => array('div_class' => 'form-group row',
							'div_tooltip' => 'tooltip',
							'div_tooltip_placement' => 'top',
							'div_tooltip_title' => '絞り込みたい配達員の名前を入力してください。',
							'select_toggle' => 'select2'),
						'value' => $this->request->getQuery('role'),
						'id' => 'role',
						'class' => 'form-control select2'
						// inputタグのクラス名
					));

					?>

					<div class="row my-2">
						<div class="col-12 text-center">
							<button class="btn btn-outline-dark mr-3" type="button" name="submit_btn" value="clear"
											onclick="clearSearchElementsInUser();document.search_form.submit();">
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
			<th scope="col"><?= $this->Paginator->sort('team_name', 'チーム名') ?></th>
			<th scope="col"><?= $this->Paginator->sort('introduction', 'ひとこと') ?></th>
			<th scope="col"><?= $this->Paginator->sort('created', '作成日') ?></th>
			<th scope="col"><?= $this->Paginator->sort('modified', '最終更新日') ?></th>
			<th scope="col" class="actions"><?= __('操作') ?></th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($teams as $team): ?>
			<tr>
				<td class="align-middle"><a
						href="<?php echo $this->Url->build(['controller' => 'Teams',
							'action' => 'view',
							$team->id]); ?>"
						class="btn btn-info"><?= h($team->team_name) ?></a></td>
				<td class="align-middle"><?= h($team->introduction) ?></td>
				<td class="align-middle"><?= h($team->created) ?></td>
				<td class="align-middle"><?= h($team->modified) ?></td>
				<td class="align-middle actions">
					<?= $this->Html->link(__('編集'), ['action' => 'edit',
						$team->id]) ?>
					<?= $this->Form->postLink(__('削除'), ['action' => 'delete',
						$team->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $team->id)]) ?>
				</td>
			</tr>
		<?php endforeach; ?>
		</tbody>
	</table>
	<?= $this->element('pagenate'); ?>
</div>
