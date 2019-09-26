<!DOCTYPE html>
<html lang="ja">
<head>
	<?= $this->Html->charset() ?>
	<title><?= $this->fetch('title') ?></title>
	<?= $this->element('load_css') ?>
</head>

<body>
<div id="wrapper">
	<?= $this->element('sidebar') ?>
	<div class="content-page">
		<div class="content">
			<?= $this->element('header') ?>
			<?= $this->Flash->render() ?>
			<?= $this->fetch('content') ?>
		</div>
	</div>
</div>
<?= $this->element('load_script') ?>
<?= $this->element('select2_init') ?>
<?= $this->element('report_list_selector_init') ?>
</body>
</html>
