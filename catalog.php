<?php
// Model（model.php）を読み込む
require_once '../../include/model/ECsight_catalog_model.php';
require_once '../../include/config/const.php';

$pdo         = get_connection();

$catalogData = getCatalog($pdo);

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId'])) {
	$message = setCart($pdo,$_POST['productId'],$_COOKIE['userid']);

	if($message=='OK'){
		header("Location: catalog.php?insert=success");
	}else{
		header("Location: catalog.php?insert=".$message);
	}
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['insert'])) {
	$insert = $_GET['insert'];
	if($insert=='success'){
		$insertMessage = 'カートに加えました';
		$insertClass   = 'success';
	}else{
		$insertMessage = 'カートに加えるのに失敗しました';
		$insertClass   = 'failed';
	}
}else{
	$insertMessage = '';
}

// View(view.php）読み込み
include_once '../../include/view/ECsight_catalog_view.php';