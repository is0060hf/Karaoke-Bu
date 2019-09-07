<?php
	use Cake\ORM\TableRegistry;

	header('Content-type: text/plain; charset= UTF-8');
	if (isset($_POST['userid'])) {
		$id = $_POST['userid'];
		$user = TableRegistry::get('Users')->find()->first()->username;
		/*if ($user) {
			$result = [
					'username' => $user->username,
					'car_numb' => $user->car_numb
			];
			echo json_encode($result);
		} else {
			echo "ユーザ情報が見つかりませんでした。".$id;
		}*/
		echo $id;
		exit;
	}else{
		echo "サーバエラー";
	}
?>