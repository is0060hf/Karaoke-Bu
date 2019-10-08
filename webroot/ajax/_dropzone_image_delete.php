<?php

use App\Utils\FileUtil;
use Cake\ORM\TableRegistry;

$id = $_POST['id'];
$table_name = $_POST['table_name'];
$column_name = $_POST['column_name'];
$image_table_name = $_POST['image_table_name'];
$limit_size = isset($_POST['limit_size']) ? $_POST['limit_size'] : 1024 * 1024;

// 必要な項目が存在しない場合は
if (!isset($_POST['id']) || !isset($_POST['table_name']) || !isset($_POST['column_name']) || !isset($_POST['image_table_name'])) {
	echo 'ERROR_000';
	return;
}

$additionalTgt = TableRegistry::get($table_name)->find('All')->where([$column_name => $id])->first();

if (!is_null($additionalTgt)) {
	$dir_name = "/upload_img/".date("ymdhis");
	try {
		$dir = 'upload_img';
		$move_dir = realpath(WWW_ROOT."/upload_img");
		$imagePath = FileUtil::file_upload($_FILES, $move_dir, $limit_size);
		$imageEntity = TableRegistry::get($image_table_name)->newEntity();
		$imageEntity->store_id = $id;
		$imageEntity->image_path = $dir.'/'.$imagePath;
		if (TableRegistry::get($image_table_name)->save($imageEntity)) {
			echo $dir.'/'.$imagePath;
			return;
		} else {
			if (file_exists($dir.'/'.$imagePath)) {
				unlink(WWW_ROOT.$dir.'/'.$imagePath);
			}
			echo 'ERROR_001';
			return;
		}
	} catch (Exception $exception) {
		if (file_exists($dir.'/'.$imagePath)) {
			unlink(WWW_ROOT.$dir.'/'.$imagePath);
		}
		echo 'ERROR_002';
		return;
	}
} else {
	echo 'ERROR_003';
	return;
}
