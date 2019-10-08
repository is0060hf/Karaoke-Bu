<?php

use Cake\ORM\TableRegistry;

header('Content-type: text/plain; charset= UTF-8');
//	header('Content-type: application/json; charset= UTF-8');

try {
	if (isset($_POST['store_id'])) {
		$id = $_POST['store_id'];
		$storeImages = TableRegistry::get('StoreImages')->find('All')->where(['store_id' => $id]);
		$imagesInfo = [];

		foreach ($storeImages as $storeImage) {
			$imageInfo = ['store_image_id' => $storeImage->id,
				'image_path' => $storeImage->image_path,
				'image_full_path' => WWW_ROOT.$storeImage->image_path,
				'image_size' => filesize(WWW_ROOT.$storeImage->image_path)];
			$imagesInfo = array_merge($imagesInfo, $imageInfo);
		}

		$result = ['state' => 'success',
			'error' => '',
			'images' => $imagesInfo];
	} else {

		$result = ['state' => 'error',
			'error' => '必要な情報が揃っていません。',
			'images' => null];
		echo '引数不足<br><br>';
		echo $_POST;
	}
} catch (Exception $e) {
	$result = ['state' => 'error',
		'error' => 'サーバーエラーが発生しました。',
		'images' => null];
	echo 'サーバーエラー';
}

echo json_encode($result);

