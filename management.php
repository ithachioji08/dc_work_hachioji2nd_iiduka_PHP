<?php
// Model（model.php）を読み込む
//require_once '../../include/model/ECsight_management_model.php';
require_once '../../include/config/const.php';
 
//$pdo = get_connection();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_name']) && isset($_POST['password'])) {
	$name = $_POST['user_name'];
	$password = $_FILES['password'];
	brankCheck($name,$password);
	switch(get_user_list($pdo,$_POST['user_name'],$_POST['password'])){
		case 'none';
			header("Location: index.php?message=mismatch");
			break;
		case 'admin':
			header("Location: management.php");
			break;
		case 'user':
			header("Location: product_list.php");
			break;
	}
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
include_once '../../include/view/ECsight_management_view.php';

function brankCheck($name,$password){
	if($name=='' || $password==''){
		header("Location: index.php?message=blank");
		exit();
	}
}