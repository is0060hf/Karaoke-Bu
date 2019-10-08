<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Store $store
 */

use Cake\ORM\TableRegistry;

?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Tops',
					'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Stores',
					'action' => 'index']); ?>">店舗情報一覧</a></li>
		<li class="breadcrumb-item active">店舗詳細</li>
	</ol>
</div>

<div class="users view large-9 medium-8 columns content">
	<legend>店舗情報詳細</legend>
	<table class="table mb-4">
		<tr>
			<th scope="row"><?= __('店舗名') ?></th>
			<td><?= h($store->store_name) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('サイトURL') ?></th>
			<td><?= h($store->store_url) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('地方') ?></th>
			<td><?= REGION_ARRAY[$store->region] ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('都道府県') ?></th>
			<td><?= PREFECTURE_ARRAY[$store->prefecture] ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('作成日') ?></th>
			<td><?= h($store->created) ?></td>
		</tr>
		<tr>
			<th scope="row"><?= __('更新日') ?></th>
			<td><?= h($store->modified) ?></td>
		</tr>
	</table>
	<div class="row">
		<div class="col-12">
			<div class="card">
				<div class="card-body">
					<h4 class="header-title">店舗画像</h4>
					<p class="sub-header">
						以下の領域をクリックして店舗画像をアップロードしてください。ドラッグアンドドロップでもアップロード可能です。
					</p>
					<?php
					$form_template = array('formStart' => '<form class="dropzone dz-clickable" id="image-drop-upload-zone" {{attrs}}>',
						'error' => '<div class="col-sm-12 error-message alert alert-danger mt-1 mb-2 py-1">{{content}}</div>',
						'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
						'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10 d-flex align-items-center">{{input}}</div>',
						'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
						'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
						'input' => '<input class="form-control" type="{{type}}" name="{{name}}" {{attrs}} data-toggle="{{data_toggle}}" maxlength="{{max_length}}" data-mask-format="{{data_mask_format}}">',
						'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
						'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>');
					?>

					<?= $this->Form->create($store, array('templates' => $form_template,
						'type' => 'file',
						'url' => array('controller' => 'Stores',
							'action' => 'uploadStoreImage'))); ?>
					<div class="dz-message needsclick">
						<i class="h1 text-muted dripicons-cloud-upload"></i>
						<h3>Drop files here or click to upload.</h3>
						<span class="text-muted font-13">アップロードできる容量は10MBまでです。</span>
					</div>
					<input type="file" multiple="multiple" class="dz-hidden-input"
								 style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
					<div id="preview_area" class="row">
					</div>
					<?= $this->Form->control('id', ['type' => 'hidden',
						'value' => $store->id,
						'id' => 'id']); ?>
					<?= $this->Form->hidden('table_name', array('value' => 'Stores')); ?>
					<?= $this->Form->hidden('column_name', array('value' => 'id')); ?>
					<?= $this->Form->hidden('image_table_name', array('value' => 'StoreImages')); ?>
					<?= $this->Form->end(); ?>
				</div> <!-- end card-body -->
			</div>
		</div> <!-- end col-->
	</div>
	<div class="row">
		<div class="col-12">

		</div>
	</div>
	<div class="row">
		<div class="col-12 text-center">
			<a href="<?= $this->Url->build(['controller' => 'Stores',
				'action' => 'edit',
				$store->id]); ?>"
				 class="btn btn-success mr-3">
				<i class="fe-edit"></i>
				<span>編集する</span>
			</a>
			<a href="<?= $this->Url->build(['controller' => 'Stores',
				'action' => 'index']); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
</div>

