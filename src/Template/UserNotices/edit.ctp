<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\UserNotice $userNotice
 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Tops',
					'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'UserNotices',
					'action' => 'index']); ?>">通知情報一覧</a></li>
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'UserNotices',
					'action' => 'view',
					$userNotice->id]); ?>">通知詳細情報</a>
		</li>
		<li class="breadcrumb-item active">通知情報編集</li>
	</ol>
</div>

<div class="users form large-9 medium-8 columns content">
	<?php
	$form_template = array('error' => '<div class="col-sm-12 error-message alert alert-danger mt-2 mb-0 py-1">{{content}}</div>',
		'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
		'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10">{{input}}</div>',
		'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
		'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
		'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
		'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>',);
	?>

	<?= $this->Form->create($userNotice, array('templates' => $form_template,
		'type' => 'file')); ?>
	<fieldset>
		<legend><?= __('通知情報編集') ?></legend>
		<?php
		echo $this->Form->control('title', array('label' => array('text' => 'タイトル',
			// labelで出力するテキスト
			'class' => 'col-form-label'
			// labelタグのクラス名
		),
			'type' => 'text',
			'templateVars' => array('div_class' => 'form-group row',
				'div_tooltip' => 'tooltip',
				'div_tooltip_placement' => 'top',
				'div_tooltip_title' => '通知のタイトルを入力してください'),
			'class' => 'form-control'
			// inputタグのクラス名
		));

		echo $this->Form->control('context', array('label' => array('text' => '通知内容',
			// labelで出力するテキスト
			'class' => 'col-form-label'
			// labelタグのクラス名
		),
			'type' => 'textarea',
			'templateVars' => array('div_class' => 'form-group row',
				'div_tooltip' => 'tooltip',
				'div_tooltip_placement' => 'top',
				'div_tooltip_title' => '通知の内容を入力してください'),
			'required' => true,
			'class' => 'form-control'
			// inputタグのクラス名
		));

		echo $this->Form->control('send_date', array('label' => array('text' => '通知日',
			// labelで出力するテキスト
			'class' => 'col-form-label'
			// labelタグのクラス名
		),
			'type' => 'datetime',
			'dateFormat' => 'YMD',
			'monthNames' => false,
			'timeFormat' => '24',
			'templateVars' => array('div_class' => 'form-group row',
				'class' => 'custom-select',
				'div_tooltip' => 'tooltip',
				'div_tooltip_placement' => 'top',
				'div_tooltip_title' => '通知日を入力してください。'),
			'year' => array('class' => 'custom-select datetime-picker'),
			'month' => array('class' => 'custom-select datetime-picker'),
			'day' => array('class' => 'custom-select datetime-picker'),
			'hour' => array('class' => 'custom-select datetime-picker'),
			'minute' => array('class' => 'custom-select datetime-picker'),
			'default' => date('Y-m-d H:i'),));

		$icon_image_path = $userNotice->icon_image_path;
		if (isset($icon_image_path)) {
			echo '
        	<div class="input form-group row">
        	  <div class="col-sm-2">
        	    <label class="col-form-label" for="featured_image">アイコン</label>
        	  </div>
        	  <div class="col-sm-8">
        	    <img src="'.$icon_image_path.'" width="100%">  
						</div>
						<div class="col-sm-2">
        	    '.$this->Form->postLink(__('削除'), ['action' => 'deleteIconImageOnEdit',
					$userNotice->id], ['block' => true,
					'confirm' => __('本当に画像を削除してもよろしいでしょうか?'),
					'class' => 'btn btn-danger']).'
        	  </div>
        	</div>
        	';
		} else {
			echo $this->Form->control('icon_image_path', array('label' => array('text' => 'アイコン',
				// labelで出力するテキスト
				'class' => 'col-form-label'
				// labelタグのクラス名
			),
				'type' => 'file',
				'templateVars' => array('div_class' => 'form-group row',
					'div_tooltip' => 'tooltip',
					'div_tooltip_placement' => 'top',
					'div_tooltip_title' => '通知アイコンをアップロードしてください。'),
				'id' => 'icon_image_path',
				'class' => 'form-control'
				// inputタグのクラス名
			));
		}
		?>
	</fieldset>
	<div class="row mt-4">
		<div class="col-12 text-center">
			<button class="btn btn-success mr-3" type="submit">
				<i class="fe-check-circle"></i>
				<span>登録する</span>
			</button>
			<a href="<?= $this->Url->build(['controller' => 'UserNotices',
				'action' => 'index']); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
