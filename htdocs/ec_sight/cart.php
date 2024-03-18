<?php
// Model（model.php）を読み込む
require_once '../../include/utility/session_management.php';
require_once '../../include/model/ECsite_cart_model.php';
require_once '../../include/config/const.php';

$pdo      = get_connection();

$cartData = getCart($pdo,$_COOKIE['userid']);

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productId']) && isset($_POST['stock'])) {
	$message = updateQty($pdo,$_POST['productId'],$_POST['stock'],$_COOKIE['userid']);

	if($message=='OK'){
		header("Location: cart.php?message=update");
		exit();
	}else{
		header("Location: cart.php?message=".$message);
		exit();
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delId']) ) {
	$message = oneDelete($pdo,$_POST['delId'],$_COOKIE['userid']);

	if($message=='OK'){
		header("Location: cart.php?message=delete");
		exit();
	}else{
		header("Location: cart.php?message=".$message);
		exit();
	}
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['message'])) {
	switch($_GET['message']){
		case 'update':
			$resultMessage = 'カートの数量を変更しました';
			$class   = 'success';
			break;
		case 'over':
			$resultMessage = 'カートの数量が在庫数を超えています';
			$class   = 'failed';
			break;
		case 'updateFailed':
			$resultMessage = '更新に失敗しました';
			$class   = 'failed';
			break;
		case "delete":
			$resultMessage = 'カートから削除しました';
			$class   = 'success';
			break;
		case "deleteFailed":
			$resultMessage = 'カートからの削除に失敗しました';
			$class   = 'failed';
			break;
	}
}else{
	$resultMessage = '';
}


require_once '../../include/view/ECsite_cart_view.php';