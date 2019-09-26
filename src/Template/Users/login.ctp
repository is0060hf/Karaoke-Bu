<?php
$this->assign('title', 'ログイン画面');

$form_template = array('error' => '<div class="error-message alert alert-danger">{{content}}</div>', 'nestingLabel' => '{{hidden}}{{input}}<label{{attrs}}>{{text}}</label>', 'formGroup' => '<div class="col-sm-12">{{label}}</div><div class="col-sm-12">{{input}}</div>', 'inputContainer' => '<div class="input {{type}}{{required}} {{div_class}}">{{content}}</div>');

$this->Form->templates($form_template);
?>

<?= $this->Form->create(); ?>

<?= $this->Form->input('login_name', array('label' => array('text' => 'ログイン名',       // labelで出力するテキスト
	'class' => 'col-form-label' // labelタグのクラス名
), 'type' => 'text', 'templateVars' => array('div_class' => 'form-group row'), 'class' => 'form-control'      // inputタグのクラス名
)); ?>

<?= $this->Form->input('password', array('label' => array('text' => 'パスワード',       // labelで出力するテキスト
	'class' => 'col-form-label' // labelタグのクラス名
), 'type' => 'password', 'templateVars' => array('div_class' => 'form-group row'), 'class' => 'form-control'      // inputタグのクラス名
)); ?>

<?= $this->Form->button('ログイン', array('class' => 'btn btn-info')); ?>

<?= $this->Form->end(); ?>
