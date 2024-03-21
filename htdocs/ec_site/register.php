<?php
// Model（model.php）を読み込む
require_once '../../include/utility/session_management.php';
require_once '../../include/model/ECsite_register_model.php';
require_once '../../include/config/const.php';



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

require_once '../../include/view/ECsite_register_view.php';
