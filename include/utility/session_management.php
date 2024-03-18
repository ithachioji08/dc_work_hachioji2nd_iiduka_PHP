<?php
// セッション開始
session_start();

$current_page = basename($_SERVER['PHP_SELF']);

// ログアウト処理
if (isset($_POST["logout"])) {
    // セッション変数を全て解除し、セッションを破壊
    $_SESSION = [];
    setcookie(session_name(), '', time() - 42000, '/');
    session_destroy();
    header('Location: index.php');
    exit();
}

// ログイン済みのユーザーのリダイレクト処理
if (isset($_SESSION['login_id'])) {
    // 管理者は管理ページへ
    if ($_SESSION['login_id'] == "admin" && $current_page != 'management.php') {
        header('Location: management.php');
        exit;
    }
    // 一般ユーザーはカタログなど指定のページへ（ログイン済みであればユーザー登録ページにはアクセス不要）
    elseif ($_SESSION['login_id'] != "admin" && !in_array($current_page, ['catalog.php', 'cart.php', 'purchase_complete.php', 'register.php'])) {
        header('Location: catalog.php');
        exit;
    }
}
// 未ログイン状態でログインページやユーザー登録ページ以外にアクセスしようとした場合
elseif (!isset($_SESSION['login_id']) && !in_array($current_page, ['index.php', 'register.php'])) {
    header('Location: index.php');
    exit;
}