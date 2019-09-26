<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Event $event
 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Tops', 'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Events', 'action' => 'index']); ?>">イベント情報一覧</a></li>
		<li class="breadcrumb-item active">新規イベント情報登録</li>
	</ol>
</div>

<div class="users form large-9 medium-8 columns content">
	<?php
	$form_template = array('error' => '<div class="col-sm-12 error-message alert alert-danger mt-2 mb-0 py-1">{{content}}</div>', 'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>', 'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10">{{input}}</div>', 'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分', 'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>', 'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>', 'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>',);
	?>

	<?= $this->Form->create($event, array('templates' => $form_template, 'type' => 'file')); ?>
	<fieldset>
		<legend><?= __('新規イベント情報登録') ?></legend>
		<?php
		echo $this->Form->control('title', array('label' => array('text' => 'タイトル',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'text', 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => '簡潔に募集内容を記述してください。'), 'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('body', array('label' => array('text' => '詳細',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'textarea', 'templateVars' => array('div_class' => 'form-group row'), 'required' => true, 'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('entry_template', array('label' => array('text' => '登録フォーマット',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'textarea', 'templateVars' => array('div_class' => 'form-group row'), 'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('drink', array('label' => array('text' => 'ドリンクメニュー',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'select', 'options' => DRINK_MENU_ARRAY, 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'ドリンクメニューが決まっていたら選択してください。'), 'id' => 'drink', 'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('food', array('label' => array('text' => 'フードメニュー',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'select', 'options' => FOOD_MENU_ARRAY, 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'フードメニューが決まっていたら選択してください。'), 'id' => 'food', 'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('start_time', array('label' => array('text' => '開始日時',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'datetime', 'dateFormat' => 'YMD', 'monthNames' => false, 'timeFormat' => '24', 'templateVars' => array('div_class' => 'form-group row', 'class' => 'custom-select', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'イベントの開始日時を入力してください。'), 'year' => array('class' => 'custom-select datetime-picker'), 'month' => array('class' => 'custom-select datetime-picker'), 'day' => array('class' => 'custom-select datetime-picker'), 'hour' => array('class' => 'custom-select datetime-picker'), 'minute' => array('class' => 'custom-select datetime-picker'), 'default' => date('Y-m-d H:i'),  //初期値指定
		));
		echo $this->Form->control('end_time', array('label' => array('text' => '終了日時',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'datetime', 'dateFormat' => 'YMD', 'monthNames' => false, 'timeFormat' => '24', 'templateVars' => array('div_class' => 'form-group row', 'class' => 'custom-select', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'イベントの終了日時を入力してください。'), 'year' => array('class' => 'custom-select datetime-picker'), 'month' => array('class' => 'custom-select datetime-picker'), 'day' => array('class' => 'custom-select datetime-picker'), 'hour' => array('class' => 'custom-select datetime-picker'), 'minute' => array('class' => 'custom-select datetime-picker'), 'default' => date('Y-m-d H:i'),  //初期値指定
		));
		echo $this->Form->control('budget', array('label' => array('text' => '予算',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'text', 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => '一人当たりのおおよその予算を入力してください。'), 'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('deadline', array('label' => array('text' => '募集終了日',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'datetime', 'dateFormat' => 'YMD', 'monthNames' => false, 'timeFormat' => '24', 'templateVars' => array('div_class' => 'form-group row', 'class' => 'custom-select', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => '応募締め切り日時を入力してください。'), 'year' => array('class' => 'custom-select datetime-picker'), 'month' => array('class' => 'custom-select datetime-picker'), 'day' => array('class' => 'custom-select datetime-picker'), 'hour' => array('class' => 'custom-select datetime-picker'), 'minute' => array('class' => 'custom-select datetime-picker'), 'default' => date('Y-m-d H:i'),  //初期値指定
		));
		echo $this->Form->control('entry_date', array('label' => array('text' => '募集開始日時',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'datetime', 'dateFormat' => 'YMD', 'monthNames' => false, 'timeFormat' => '24', 'templateVars' => array('div_class' => 'form-group row', 'class' => 'custom-select', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => '参加者を募集開始する日時を入力してください。'), 'year' => array('class' => 'custom-select datetime-picker'), 'month' => array('class' => 'custom-select datetime-picker'), 'day' => array('class' => 'custom-select datetime-picker'), 'hour' => array('class' => 'custom-select datetime-picker'), 'minute' => array('class' => 'custom-select datetime-picker'), 'default' => date('Y-m-d H:i'),  //初期値指定
		));
		echo $this->Form->control('limited_range', array('label' => array('text' => '応募制限',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'select', 'options' => LIMITED_RANGE_ARRAY, 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'このイベントに応募できる人を制限できます。'), 'id' => 'limited_range', 'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('number_of_people', array('label' => array('text' => '募集人数',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'text', 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'このイベントの募集人数を入力してください。'), 'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('region', array('label' => array('text' => '開催地域',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'select', 'options' => REGION_ARRAY, 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'イベントの開催地域を選択してください。'), 'id' => 'region', 'class' => 'form-control'      // inputタグのクラス名
		));
		echo $this->Form->control('prefecture', array('label' => array('text' => '都道府県',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'select', 'options' => PREFECTURE_ARRAY, 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'イベントの開催都道府県を選択してください。'), 'id' => 'prefecture', 'class' => 'form-control',      // inputタグのクラス名
			'disabled' => true));
		echo $this->Form->control('phone_number', array('label' => array('text' => '電話番号',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'text', 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => '緊急連絡先を登録したい場合は入力してください。'), 'class' => 'form-control'      // inputタグのクラス名
		));
		?>
	</fieldset>
	<div class="row mt-4">
		<div class="col-12 text-center">
			<button class="btn btn-success mr-3" type="submit">
				<i class="fe-check-circle"></i>
				<span>登録する</span>
			</button>
			<a href="<?= $this->Url->build(['controller' => 'Events', 'action' => 'index']); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
</div>
