<?php

// A list of permitted file extensions
//	$allowed = array('png', 'jpg', 'gif');
//
//	if(isset($_FILES['file']) && $_FILES['file']['error'] == 0){
//
//		$extension = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
//
//		if(!in_array(strtolower($extension), $allowed)){
//			echo '{"status":"error"}';
//			exit;
//		}
//
//		if(move_uploaded_file($_FILES['file']['tmp_name'], 'uploads/'.$_FILES['file']['name'])){
//			$tmp='uploads/'.$_FILES['file']['name'];
//			echo 'uploads/'.$_FILES['file']['name'];
//			//echo '{"status":"success"}';
//			exit;
//		}
//	}
//
//	echo '{"status":"error"}';
$dir_name = "/upload_img/".date("ymdhis");
$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$file_name = sha1_file($_FILES['file']['tmp_name']);
move_uploaded_file($_FILES['file']['tmp_name'],'..'.$dir_name.'_'.$file_name.'.'.$ext);
echo $dir_name.'_'.$file_name.'.'.$ext;
	//exit;