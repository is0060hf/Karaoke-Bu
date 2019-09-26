<!DOCTYPE html>
<html lang="ja">
<head>
	<?= $this->Html->charset() ?>
	<title><?= $this->fetch('title') ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description"/>
	<meta content="Coderthemes" name="author"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge"/>

	<!-- App favicon -->
	<link rel="shortcut icon" href="/assets/images/favicon.ico">

	<!-- Sweet Alert-->
	<link href="/css/vendor/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

	<!-- Notification css (Toastr) -->
	<link href="/css/vendor/toastr.min.css" rel="stylesheet" type="text/css"/>

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
<script src="/js/search.js"></script>
<script src="/js/vendor.min.js"></script>
<script src="/js/app.min.js"></script>

<!-- Toaster js -->
<script src="/js/vendor/toastr.min.js"></script>
<script src="/js/pages/toastr.init.js"></script>

<!-- third party js -->
<script src="/js/vendor/jquery.dataTables.js"></script>
<script src="/js/vendor/dataTables.bootstrap4.js"></script>
<script src="/js/vendor/dataTables.responsive.min.js"></script>
<script src="/js/vendor/responsive.bootstrap4.min.js"></script>
<script src="/js/vendor/dataTables.buttons.min.js"></script>
<script src="/js/vendor/buttons.bootstrap4.min.js"></script>
<script src="/js/vendor/buttons.html5.min.js"></script>
<script src="/js/vendor/buttons.flash.min.js"></script>
<script src="/js/vendor/buttons.print.min.js"></script>
<script src="/js/vendor/dataTables.keyTable.min.js"></script>
<script src="/js/vendor/dataTables.select.min.js"></script>
<!-- third party js ends -->

<!-- App js -->
<script src="/js/vendor/sweetalert2.min.js"></script>
<script src="/js/pages/sweet-alerts.init.js"></script>

<!-- demo app -->
<script src="/js/pages/datatables.init.js"></script>
<!-- end demo js-->

</body>
</html>
