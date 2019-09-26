<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Team $team
 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Tops', 'action' => 'index']); ?>">Home</a></li>
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Teams', 'action' => 'index']); ?>">チーム一覧</a></li>
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Teams', 'action' => 'view', $team->id]); ?>">チーム情報詳細</a>
		</li>
		<li class="breadcrumb-item active">チーム情報編集</li>
	</ol>
</div>

<div class="users form large-9 medium-8 columns content">
	<?php
	$form_template = array('error' => '<div class="col-sm-12 error-message alert alert-danger mt-2 mb-0 py-1">{{content}}</div>', 'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>', 'formGroup' => '<div class="col-sm-2">{{label}}</div><div class="col-sm-10">{{input}}</div>', 'dateWidget' => '{{year}} 年 {{month}} 月 {{day}} 日  {{hour}}時{{minute}}分', 'select' => '<select name="{{name}}"{{attrs}} data-toggle="{{select_toggle}}">{{content}}</select>', 'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}</div>', 'inputContainerError' => '<div class="input {{type}}{{required}} error {{div_class}}" data-toggle="{{div_tooltip}}" data-placement="{{div_tooltip_placement}}" data-original-title="{{div_tooltip_title}}">{{content}}{{error}}</div>',);
	?>

	<?= $this->Form->create($team, array('templates' => $form_template, 'type' => 'file')); ?>
	<fieldset>
		<legend><?= __('チーム情報編集') ?></legend>
		<?php
		echo $this->Form->control('team_name', array('label' => array('text' => 'チーム名',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'text', 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'チーム名を入力してください'), 'class' => 'form-control'      // inputタグのクラス名
		));

		echo $this->Form->control('introduction', array('label' => array('text' => '一言紹介文',       // labelで出力するテキスト
			'class' => 'col-form-label' // labelタグのクラス名
		), 'type' => 'text', 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => '他のユーザーに公開する自己紹介分を、一言お願いしいます。'), 'class' => 'form-control'      // inputタグのクラス名
		));
		$cover_image_path = $team->cover_image_path;
		if ($cover_image_path) {
			echo '
        	<div class="input form-group row">
        	  <div class="col-sm-2">
        	    <label class="col-form-label" for="cover_image_path">カバー画像</label>
        	  </div>
        	  <div class="col-sm-8">
        	    <img src="'.$cover_image_path.'" width="100%">  
						</div>
						<div class="col-sm-2">
        	    '.$this->Form->postLink(__('削除'), ['action' => 'deleteCoverImage', $team->id], ['block' => true, 'confirm' => __('本当にカバー画像を削除してもよろしいでしょうか?'), 'class' => 'btn btn-danger']).'
        	  </div>
        	</div>
        	';
		} else {
			echo $this->Form->control('cover_image_path', array('label' => array('text' => 'カバー画像',       // labelで出力するテキスト
				'class' => 'col-form-label' // labelタグのクラス名
			), 'type' => 'file', 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'カバー画像をアップロードしてください。'), 'id' => 'cover_image_path', 'class' => 'form-control'      // inputタグのクラス名
			));
		}
		$icon_image_path = $team->icon_image_path;
		if ($icon_image_path) {
			echo '
        	<div class="input form-group row">
        	  <div class="col-sm-2">
        	    <label class="col-form-label" for="cover_image_path">アイコン</label>
        	  </div>
        	  <div class="col-sm-8">
        	    <img src="'.$icon_image_path.'" width="100%">  
						</div>
						<div class="col-sm-2">
        	    '.$this->Form->postLink(__('削除'), ['action' => 'deleteIcon', $team->id], ['block' => true, 'confirm' => __('本当にアイコンを削除してもよろしいでしょうか?'), 'class' => 'btn btn-danger']).'
        	  </div>
        	</div>
        	';
		} else {
			echo $this->Form->control('icon_image_path', array('label' => array('text' => 'アイコン',       // labelで出力するテキスト
				'class' => 'col-form-label' // labelタグのクラス名
			), 'type' => 'file', 'templateVars' => array('div_class' => 'form-group row', 'div_tooltip' => 'tooltip', 'div_tooltip_placement' => 'top', 'div_tooltip_title' => 'チームアイコンをアップロードしてください。'), 'id' => 'icon_image_path', 'class' => 'form-control'      // inputタグのクラス名
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
			<a href="<?= $this->Url->build(['controller' => 'Teams', 'action' => 'index']); ?>" class="btn btn-info">
				<i class="fe-skip-back"></i>
				<span>一覧に戻る</span>
			</a>
		</div>
	</div>
	<?= $this->Form->end() ?>
	<?= $this->fetch('postLink') ?>
</div>
