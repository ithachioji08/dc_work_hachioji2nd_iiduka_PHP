<?php
// Model（model.php）を読み込む
require_once '../../include/model/ECsight_catalog_model.php';
require_once '../../include/config/const.php';
require_once 'ECsight_get_cart.php';
require_once 'session_after_login.php';

$pdo         = get_connection();

$catalogData = getCatalog($pdo);

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
	$resultMessage = setCart($pdo,$_POST['productId'],$_COOKIE['userid']);

	if($resultMessage=='OK'){
		header("Location: catalog.php?insert=success");
	}else{
		header("Location: catalog.php?insert=".$resultMessage);
	}
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['insert'])) {
	$insert = $_GET['insert'];
	if($insert=='success'){
		$resultMessage = 'カートに加えました';
		$class   = 'success';
	}else{
		$resultMessage = 'カートに加えるのに失敗しました';
		$class   = 'failed';
	}
}else{
	$resultMessage = '';
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['back'])) {
	$cartData = json_encode(getCart($pdo));

}else{
	$cartData = [];
}

// View(view.php）読み込み
include_once '../../include/view/ECsight_catalog_view.php';