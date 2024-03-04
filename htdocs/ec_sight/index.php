<?php
// Model（model.php）を読み込む
require_once '../../include/model/ECsite_index_model.php';
require_once '../../include/config/const.php';
require_once 'session_before_login.php';
 
$pdo = get_connection();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_name']) && isset($_POST['password'])) {
	$name     = $_POST['user_name'];
	$password = $_POST['password'];
	validation($name,$password);
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
		case 'username':
			$resultMessage = 'ユーザー名は、半角英数字かつ5文字以上です';
			break;
		case 'password':
			$resultMessage = 'パスワードは、半角英数字かつ8文字以上です';
			break;
		case 'mismatch':
			$resultMessage = 'ユーザー名またはパスワードが間違っています';
			break;
	}
}else{
	$resultMessage = '';
}

 
// View(view.php）読み込み
include_once '../../include/view/ECsite_index_view.php';

function validation($name,$password){
	if(empty($name) || empty($password)){
		header("Location: index.php?message=blank");
		exit();
	//ec_adminだけ例外処理
	}else if($name =='ec_admin' && $password == 'ec_admin'){
		return;
	}else if(strlen($name)<5 || !preg_match("/^[a-zA-Z0-9]+$/", $name)){
        header("Location: index.php?message=username");
        exit();
    }else if(strlen($password)<8 || !preg_match("/^[a-zA-Z0-9]+$/", $password)){
        header("Location: index.php?message=password");
        exit();
    }
}