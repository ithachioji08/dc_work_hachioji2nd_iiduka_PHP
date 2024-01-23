<?php
// Model（model.php）を読み込む
require_once '../../include/model/ECsight_register_model.php';
require_once '../../include/config/const.php';
require_once 'session_before_login.php';



if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['user_name']) && isset($_POST['password'])) {
	$name = $_POST['user_name'];
	$password = $_POST['password'];
	validation($name,$password);
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['message']) ) {
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
        case 'sameName':
            $resultMessage = 'すでにそのユーザー名は使われています';
            break;
        case 'success':
            $resultMessage = '新規ユーザーを登録しました';
            break;
        case 'failed':
            $resultMessage = '新規ユーザー登録に失敗しました';
            break;

    }
}else{
    $resultMessage = '';
}

require_once '../../include/view/ECsight_register_view.php';

function validation($name,$password){
    $pdo = get_connection();
    if($name=='' || $password==''){
		header("Location: register.php?message=blank");
		exit();
	}else if(strlen($name)<5 || !preg_match("/^[a-zA-Z0-9]+$/", $name)){
        header("Location: register.php?message=username");
        exit();
    }else if(strlen($password)<8 || !preg_match("/^[a-zA-Z0-9]+$/", $password)){
        header("Location: register.php?message=password");
        exit();
    }else if(sameName($pdo,$name)){
        header("Location: register.php?message=sameName");
        exit();
    }elseif(insert_user($pdo,$name,$password)){
        header("Location: register.php?message=success");
		exit();
    }else{
        header("Location: register.php?message=failed");
    }
}