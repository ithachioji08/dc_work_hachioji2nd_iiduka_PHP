<?php
// Model（model.php）を読み込む
//require_once '../../include/model/ECsight_index_model.php';
require_once '../../include/config/const.php';
 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_name']) && isset($_POST['password'])) {
	$name = $_POST['user_name'];
	$password = $_FILES['password'];
	brankCheck($name,$password);
	
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['message'])) {
	switch($_GET['message']) {
		case 'blank':
			$message = 'ユーザー名またはパスワードが入力されていません';
			break;
	}
}else{
	$message = '';
}

 
// View(view.php）読み込み
include_once '../../include/view/ECsight_index_view.php';

function brankCheck($name,$password){
	if($name=='' || $password==''){
		header("Location: index.php?message=blank");
		exit();
	}
}