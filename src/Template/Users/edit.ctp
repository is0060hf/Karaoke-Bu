<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Tops', 'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'index']); ?>">会員情報一覧</a></li>
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Users', 'action' => 'view', $user->id]); ?>">会員情報詳細</a>
		</li>
		<li class="breadcrumb-item active">会員情報編集</li>
	</ol>
</div>

<div class="users form large-9 medium-8 columns content">
	<?php
	$form_template = array(
		'error' => '<div class="col-sm-12 error-message alert alert-danger mt-2 mb-0 py-1">{{content}}</div>',
		'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>',
		'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10">{{input}}</div>',
		'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分',
		'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>',
		'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>',
		'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>',
	);
	?>

	<?= $this->Form->create($user, array(
		'templates' => $form_template
	)); ?>
	<fieldset>
		<legend><?= __('会員情報編集') ?></legend>
		<?php
		echo $this->Form->control('login_name', array(
			'label' => array(
				'text' => 'ログイン名',       // labelで出力するテキスト
				'class' => 'col-form-label' // labelタグのクラス名
			),
			'type' => 'text',
			'templateVars' => array(
				'div_class' => 'form-group row',
				'div_tooltip' => 'tooltip',
				'div_tooltip_placement' => 'top',
				'div_tooltip_title' => 'ログイン用のユーザー名を入力してください'
			),
			'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('nick_name', array(
			'label' => array(
				'text' => 'ユーザー名（表示用）',       // labelで出力するテキスト
				'class' => 'col-form-label' // labelタグのクラス名
			),
			'type' => 'text',
			'templateVars' => array(
				'div_class' => 'form-group row',
				'div_tooltip' => 'tooltip',
				'div_tooltip_placement' => 'top',
				'div_tooltip_title' => '他のユーザーに公開する名前を入力してください。'
			),
			'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('mail_address', array(
			'label' => array(
				'text' => 'メールアドレス',       // labelで出力するテキスト
				'class' => 'col-form-label' // labelタグのクラス名
			),
			'type' => 'text',
			'templateVars' => array(
				'div_class' => 'form-group row',
				'div_tooltip' => 'tooltip',
				'div_tooltip_placement' => 'top',
				'div_tooltip_title' => 'ユーザーのメールアドレスを入力してください。'
			),
			'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('introduction', array(
			'label' => array(
				'text' => '一言紹介文',       // labelで出力するテキスト
				'class' => 'col-form-label' // labelタグのクラス名
			),
			'type' => 'text',
			'templateVars' => array(
				'div_class' => 'form-group row',
				'div_tooltip' => 'tooltip',
				'div_tooltip_placement' => 'top',
				'div_tooltip_title' => '他のユーザーに公開する自己紹介分を、一言お願いしいます。'
			),
			'class' => 'form-control'      // inputタグのクラス名
		));
		?>
	</fieldset>
	<div class="row mt-4">
		<div class="col-12 text-center">
			<button class="btn btn-success mr-3" type="submit">
				<i class="fe-check-circle"></i>
				<span>更新する</span>
			</button>
			<a href="<?= $this->Url->build(['controller' => 'Users', 'action' => 'view', $user->id]); ?>"
				 class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>詳細に戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
