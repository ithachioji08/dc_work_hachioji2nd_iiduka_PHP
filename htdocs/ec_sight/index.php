<?php
// Model（model.php）を読み込む
require_once '../../include/model/ECsight_index_model.php';
require_once '../../include/config/const.php';
require_once 'session_before_login.php';
 
$pdo = get_connection();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_name']) && isset($_POST['password'])) {
	$name     = $_POST['user_name'];
	$password = $_POST['password'];
	blankCheck($name,$password);
	$listCheck = get_user_list($pdo,$name,$password);
	switch($listCheck){
		case 'none';
			header("Location: index.php?message=mismatch");
			break;
		case 'admin':
			$_SESSION['login_id'] =  $listCheck;
			setcookie('userid', $listCheck,time()+60*60*24);
			header("Location: management.php");
			break;
		default:
			$_SESSION['login_id'] =  $listCheck;
			setcookie('userid', $listCheck,time()+60*60*24);
			header("Location: catalog.php");
			break;
	}
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['message'])) {
	switch($_GET['message']) {
		case 'blank':
			$resultMessage = 'ユーザー名またはパスワードが入力されていません';
			break;
		case 'mismatch':
			$resultMessage = 'ユーザー名またはパスワードが間違っています';
			break;
	}
}else{
	$resultMessage = '';
}

 
// View(view.php）読み込み
include_once '../../include/view/ECsight_index_view.php';

function blankCheck($name,$password){
	if($name=='' || $password==''){
		header("Location: index.php?message=blank");
		exit();
	}
}