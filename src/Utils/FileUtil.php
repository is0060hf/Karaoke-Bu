<?php
/**
 * Created by PhpStorm.
 * User: SOLA2
 * Date: 2019/09/29
 * Time: 17:24
 */

namespace App\Utils;

use RuntimeException;
use Cake\Filesystem\File;

class FileUtil {
	static public function file_upload($file = null, $dir = null, $limitFileSize = 1024 * 1024) {
		try {
			// ファイルを保存するフォルダ $dirの値のチェック
			if ($dir) {
				if (!file_exists($dir)) {
					throw new RuntimeException('指定のディレクトリがありません。');
				}
			} else {
				throw new RuntimeException('ディレクトリの指定がありません。');
			}

			// 未定義、複数ファイル、破損攻撃のいずれかの場合は無効処理
			if (!isset($file['error']) || is_array($file['error'])) {
				throw new RuntimeException('Invalid parameters.');
			}

			// エラーのチェック
			switch ($file['error']) {
				case 0:
					break;
				case UPLOAD_ERR_OK:
					break;
				case UPLOAD_ERR_NO_FILE:
					throw new RuntimeException('No file sent.');
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					throw new RuntimeException('Exceeded filesize limit.');
				default:
					throw new RuntimeException('Unknown errors.');
			}

			// ファイル情報取得
			$fileInfo = new File($file["tmp_name"]);

			// ファイルサイズのチェック
			if ($fileInfo->size() > $limitFileSize) {
				throw new RuntimeException('Exceeded filesize limit.');
			}

			// ファイルタイプのチェックし、拡張子を取得
			if (false === $ext = array_search($fileInfo->mime(), ['jpg' => 'image/jpeg',
					'jpeg' => 'image/jpeg',
					'png' => 'image/png',
					'gif' => 'image/gif',], true)) {
				throw new RuntimeException('画像ファイル以外がアップロードされました。');
			}

			// ファイル名の生成
			//            $uploadFile = $file["name"] . "." . $ext;
			$uploadFile = sha1_file($file["tmp_name"]).".".$ext;

			// ファイルの移動
			if (!move_uploaded_file($file["tmp_name"], $dir."/".$uploadFile)) {
				throw new RuntimeException('Failed to move uploaded file.');
			}

			// 処理を抜けたら正常終了
			//            echo 'File is uploaded successfully.';

		} catch (RuntimeException $e) {
			throw $e;
		}
		return $uploadFile;
	}

	/**
	 * 編集画面にてアイコン画像を削除するためのメソッド
	 *
	 * @param $entity
	 * @param $table
	 * @return mixed
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：なし
	 */
	static public function deleteIconImageOnEdit($entity, $table) {
		if ($entity->icon_image_path != '') {
			if (file_exists($entity->icon_image_path)) {
				unlink(WWW_ROOT.$entity->icon_image_path);
			}
		}

		$entity->icon_image_path = null;
		return $table->save($entity);
	}

	/**
	 * 編集画面にてカバー画像を削除するためのメソッド
	 *
	 * @param $entity
	 * @param $table
	 * @return mixed
	 *
	 * 権限：誰でも
	 * ログイン要否：要
	 * 画面遷移：なし
	 */
	static public function deleteCoverImageOnEdit($entity, $table) {
		if ($entity->cover_image_path != '') {
			if (file_exists($entity->cover_image_path)) {
				unlink(WWW_ROOT.$entity->cover_image_path);
			}
		}

		$entity->cover_image_path = null;
		return $table->save($entity);
	}
}
