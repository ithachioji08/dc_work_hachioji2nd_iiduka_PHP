<?php
//セッション開始
session_start();
if (isset($_POST["logout"])) {

	// セッション名を取得する
	$session = session_name();
	// セッション変数を削除
	$_SESSION = [];

	// セッションID（ユーザ側のCookieに保存されている）を削除
	if (isset($_COOKIE[$session])) {
		// sessionに関連する設定を取得
		$params = session_get_cookie_params();

		// cookie削除
		setcookie($session, '', time() - 30, '/');
	}
// ログイン中のユーザーであるかを確認する
}elseif (isset($_SESSION['login_id'])) {
	// ログイン中の場合は、リダイレクト（転送）する
	if($_SESSION['login_id']=="admin"){
		header('Location: management.php');
		exit();
	}else{
		header('Location: catalog.php');
		exit();
	}
}
