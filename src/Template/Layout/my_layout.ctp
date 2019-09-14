<!DOCTYPE html>
<html lang="ja">
<head>
	<?= $this->Html->charset() ?>
	<title><?= $this->fetch('title') ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="会員管理システム" name="description"/>
	<meta content="SoLA2" name="author"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

	<!-- App favicon -->
	<link rel="shortcut icon" href="/assets/images/favicon.ico">

	<!-- Notification css (Toastr) -->
	<link href="/css/vendor/toastr.min.css" rel="stylesheet" type="text/css" />

	<!-- Sweet Alert-->
	<link href="/css/vendor/sweetalert2.min.css" rel="stylesheet" type="text/css" />

	<link href="/css/vendor/dropzone.min.css" rel="stylesheet" type="text/css">

	<!-- App css -->
	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/icons.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/app.css" rel="stylesheet" type="text/css"/>
	<link href="/css/styles.css" rel="stylesheet" type="text/css"/>
</head>

<body>

<!-- Begin page -->
<div id="wrapper">

	<?= $this->element('sidebar') ?>

	<div class="content-page">

		<div class="content">

			<?= $this->element('header') ?>
			<?= $this->Flash->render() ?>

			<?= $this->fetch('content') ?>

		</div> <!-- content -->

	</div>
</div>
<!-- END wrapper -->


<!-- App js -->
<script src="/js/vendor.min.js"></script>
<script src="/js/app.min.js"></script>

<!-- Toaster js -->
<script src="/js/vendor/toastr.min.js"></script>
<script src="/js/pages/toastr.init.js"></script>

<!-- App js -->
<script src="/js/vendor/sweetalert2.min.js"></script>
<script src="/js/pages/sweet-alerts.init.js"></script>

<!-- Plugins js -->
<script src="/js/vendor/Chart.bundle.js"></script>
<script src="/js/vendor/jquery.sparkline.min.js"></script>
<script src="/js/vendor/jquery.knob.min.js"></script>
<script src="/js/vendor/dropzone.min.js"></script>

</body>
</html>
