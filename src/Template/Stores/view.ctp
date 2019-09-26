<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Store $store
 */
?>
<div class="breadcrumb_div">
	<ol class="breadcrumb m-b-20">
		<li class="breadcrumb-item"><a
				href="<?php echo $this->Url->build(['controller' => 'Users',
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
					<form action="/" method="post" class="dropzone dz-clickable" id="myAwesomeDropzone">
						<div class="dz-message needsclick">
							<i class="h1 text-muted dripicons-cloud-upload"></i>
							<h3>Drop files here or click to upload.</h3>
							<span class="text-muted font-13">アップロードできる容量は10MBまでです。</span>
						</div>
					</form>
					<div class="clearfix text-right mt-3">
						<?= $this->Form->postLink(__('画像をアップロード'), ['action' => 'addImage',
							$store->id], ['confirm' => __('本当に削除してもよろしいでしょうか # {0}?', $store->id)]) ?>
					</div>
				</div> <!-- end card-body -->
			</div>
		</div> <!-- end col-->
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
<input type="file" multiple="multiple" class="dz-hidden-input"
			 style="visibility: hidden; position: absolute; top: 0px; left: 0px; height: 0px; width: 0px;">
