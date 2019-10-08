<?php

use App\Utils\FileUtil;
use Cake\ORM\TableRegistry;

echo 'Start';

$id = $_POST['id'];
$table_name = $_POST['table_name'];
$column_name = $_POST['column_name'];
$image_table_name = $_POST['image_table_name'];
$limit_size = isset($_POST['limit_size']) ? $_POST['limit_size'] : 1024 * 1024;

echo 'Start2';

// 必要な項目が存在しない場合は
if (!isset($_POST['id']) || !isset($_POST['table_name']) || !isset($_POST['column_name']) || !isset($_POST['image_table_name'])) {
	echo 'ERROR_000';
	return;
}

echo 'Start3<br>';

echo $id.'<br>'.$table_name.'<br>'.$column_name.'<br>'.$image_table_name.'<br>';

echo 'Start4<br>';

try {
	$dir = 'upload_img';
	$move_dir = realpath(WWW_ROOT."/upload_img");
	$imagePath = FileUtil::file_upload($_FILES, $move_dir, $limit_size);

	echo 'start5<br>';

	$imageEntity = TableRegistry::get($image_table_name)->newEntity();

	echo 'Start6<br>';

	$imageEntity->store_id = $id;
	$imageEntity->image_path = $dir.'/'.$imagePath;

	echo 'Start7<br>';

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
} catch (\Exception $exception) {
	echo 'ERROR_002_1';
	if (file_exists($dir.'/'.$imagePath)) {
		unlink(WWW_ROOT.$dir.'/'.$imagePath);
	}
	echo 'ERROR_002_2';
	return;
}

