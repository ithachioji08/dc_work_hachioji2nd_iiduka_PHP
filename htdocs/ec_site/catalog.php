<?php
// Model（model.php）を読み込む
require_once '../../include/utility/session_management.php';
require_once '../../include/model/ECsite_catalog_model.php';
require_once '../../include/config/const.php';

$pdo         = get_connection();

$catalogData = getCatalog($pdo);

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
	$resultMessage = setCart($pdo,$_POST['productId'],$_COOKIE['userid']);

	if($resultMessage=='OK'){
		header("Location: catalog.php?insert=success");
		exit();
	}else{
		header("Location: catalog.php?insert=".$resultMessage);
		exit();
	}
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['insert'])) {
	$insert = $_GET['insert'];
	if($insert=='success'){
		$resultMessage = 'カートに加えました';
		$class         = 'success';
	}else{
		$resultMessage = 'カートに加えるのに失敗しました';
		$class         = 'failed';
	}
}else{
	$resultMessage = '';
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['back'])) {
	$cartData = getCart($pdo,$_COOKIE['userid']);
	$backed   = true;
}else{
	$backed = false;
}


// View(view.php）読み込み
include_once '../../include/view/ECsite_catalog_view.php';