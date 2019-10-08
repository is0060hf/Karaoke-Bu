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
	<link href="/css/vendor/toastr.min.css" rel="stylesheet" type="text/css"/>

	<!-- Sweet Alert-->
	<link href="/css/vendor/sweetalert2.min.css" rel="stylesheet" type="text/css"/>

	<link href="/css/vendor/dropzone.min.css" rel="stylesheet" type="text/css">

	<link href="/css/vendor/swiper.min.css" rel="stylesheet" type="text/css">

	<!-- App css -->
	<link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/icons.min.css" rel="stylesheet" type="text/css"/>
	<link href="/css/app.css" rel="stylesheet" type="text/css"/>
	<link href="/css/styles.css" rel="stylesheet" type="text/css"/>
	<link href="/css/my_dropzone_style.css" rel="stylesheet" type="text/css"/>
	<link href="/css/my_swiper_style.css" rel="stylesheet" type="text/css"/>
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
<script src="/js/vendor/swiper.min.js"></script>

<script type="text/javascript">
	// Prevent Dropzone from auto discovering this element:
	Dropzone.options.myAwesomeDropzone = false;
	// This is useful when you want to create the
	// Dropzone programmatically later

	// Disable auto discover for all elements:
	Dropzone.autoDiscover = false;

	$(document).ready(function () {
		$('form#image-drop-upload-zone').dropzone({
			paramName: 'file',
			maxFilesize: 10, //MB
			maxFiles: 8,
			addRemoveLinks: true,
			previewsContainer: '#preview_area',
			dictRemoveFile: '[削除]',
			dictCancelUpload: 'キャンセル',
			dictCancelUploadConfirmation: 'アップロードをキャンセルします。よろしいですか？',
			init: function () {
				const thisDropzone = this;
				$.ajax({
					url: "<?= $this->Url->build(['controller' => 'Stores',
						'action' => 'ajaxGetStoreImages']); ?>",
					type: "POST",
					data: {
						'store_id': $('#id').val()
					},
					beforeSend: function (xhr) {
						xhr.setRequestHeader('X-CSRF-Token', <?= json_encode($this->request->param('_csrfToken')); ?>);
					},
				}).done((data) => {
					for (const element in data.result) {
						const mockFile = {
							name: data.result[element]['image_name'],
							size: data.result[element]['image_size'],
							type: data.result[element]['image_type'],
							url: data.result[element]['image_path'],
							status: Dropzone.ADDED,
						};
						thisDropzone.emit('addedfile', mockFile);
						thisDropzone.emit('thumbnail', mockFile, data.result[element]['image_path']);
						thisDropzone.emit('uploadprogress', mockFile, 100, data.result[element]['image_size']);
						thisDropzone.emit('success', mockFile, null, null);
						thisDropzone.files.push(mockFile);
					}
				}).fail((data) => {
					// console.log(data);
				});
			},
			uploadprogress: function (file, progress, size) {
				if (progress === 100) {
					file.previewElement.querySelector(".dz-progress").style.display = "none";
				} else {
					file.previewElement.querySelector("[data-dz-uploadprogress]").style.width = "" + progress + "%";
				}
			},
			success: function (file, rt, xml) {
				// それぞれのファイルアップロードが完了した時の処理（※要追加）
				file.previewElement.classList.add("dz-success");
				$(file.previewElement).find('.dz-success-mark').show();
			},
			processing: function () {
				// ファイルアップロード中の処理（※要追加）
			},
			queuecomplete: function () {
				// 全てのファイルアップロードが完了した時の処理（※要追加）
			},
			dragover: function (arg) {
				if (arg.srcElement.id !== 'image-drop-upload-zone') {
					$('#image-drop-upload-zone').addClass('dragover');
				}
			},
			dragleave: function (arg) {
				if (arg.srcElement.id !== 'image-drop-upload-zone') {
					$('#image-drop-upload-zone').removeClass('dragover');
				}
			},
			drop: function (arg) {
				if (arg.srcElement.id !== 'image-drop-upload-zone') {
					$('#image-drop-upload-zone').removeClass('dragover');
				}
			},
			error: function (file, _error_msg) {
				var ref;
				(ref = file.previewElement) != null ? ref.parentNode.removeChild(file.previewElement) : void 0;
			},
			removedfile: function (file) {
				const thisDropzone = this;
				$.ajax({
					url: "<?= $this->Url->build(['controller' => 'Stores',
						'action' => 'ajaxDeleteStoreImage']); ?>",
					type: "POST",
					data: {
						'image_path': file.url,
					},
					beforeSend: function (xhr) {
						xhr.setRequestHeader('X-CSRF-Token', <?= json_encode($this->request->param('_csrfToken')); ?>);
					},
				}).done((data) => {
					if (data.result) {
						var ref;
						(ref = file.previewElement) != null ? ref.parentNode.removeChild(file.previewElement) : void 0;
					} else {
						console.log('削除失敗');
						console.log(data.error);
					}
				}).fail((data) => {
					// console.log(data);
				});
			},
			canceled: function (arg) {
			},
			previewTemplate: `<div class="col-sm-6 col-md-4 col-lg-3">
													<div class="dz-preview dz-file-preview">
														<div class="clearfix">
															<img class="dz-thumbnail" data-dz-thumbnail>
															<div class="dz-success-mark" style="display:none;"><i class="fa fa-2x fa-check-circle"></i></div>
														</div>
														<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
														<div class="text-center">
															<div class="dz-filename"><span data-dz-name></span></div>
															<div class="dz-my-separator"> / </div>
															<div class="dz-size" data-dz-size></div>
															<div class="dz-error-message"><span data-dz-errormessage></span></div>
														</div>
													</div>
												</div>`
		});
	});
</script>

<script src="/js/rellax.min.js"></script>

<script type="text/javascript">
	var rellax = new Rellax('.rellax_icon');
	var rellax2 = new Rellax('.user_info_div');
	var rellax3 = new Rellax('.user_cover_div_wrapper');
</script>

<script>
	var swiper = new Swiper('.swiper-container', {
		slidesPerView: 3,
		spaceBetween: 30,
		pagination: {
			el: '.swiper-pagination',
			clickable: true,
		},
		observer: true,
	});
</script>
</body>
</html>
