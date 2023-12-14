<?php
// Model（model.php）を読み込む
require_once '../../include/model/ECsight_management_model.php';
require_once '../../include/config/const.php';
 
$pdo       = get_connection();

$tableData = getTable($pdo);

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_name'])) {
	$name    = $_POST['product_name'];
	$price   = $_POST['price'];
	$count   = $_POST['count'];
	$image   = $_FILES['image'];
	$status  = getStatus($_POST['status']);
	brankCheck($name,$price,$image);
	$message = insert_product($pdo,$name,$price,$count,$image,$status);

	if($message=='OK'){
		header("Location: management.php?regist=success");
	}else{
		header("Location: management.php?regist=".$message);
	}
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['regist'])) {
	switch($_GET['regist']) {
		case 'success':
			$regist_success = '商品登録に成功しました';
			$regist_failed  = '';
			break;
		case 'blank':
			$regist_success = '';
			$regist_failed  = '空白の入力欄があります';
			break;
		default:
			$regist_success = '';
			$regist_failed  = '商品登録に失敗しました';
			break;
	}
}else{
	$regist_success = '';
	$regist_failed  = '';
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['flgChange'])) {
	$message = changeFlg($pdo,$_POST['flgChange']);
	if($message=='OK'){
		header("Location: management.php?update=flgSuccess");
	}else{
		header("Location: management.php?update=".$message);
	}
}
 
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['stkId']) && isset($_POST['stock'])) {
	$message = changeStk($pdo,$_POST['stkId'],$_POST['stock']);
	if($message=='OK'){
		header("Location: management.php?update=stkSuccess");
	}else{
		header("Location: management.php?update=".$message);
	}
}

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delId'])) {
	$message = deletePdt($pdo,$_POST['delId']);
	if($message=='OK'){
		header("Location: management.php?update=delSuccess");
	}else{
		header("Location: management.php?update=".$message);
	}
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['update'])) {
	$update = $_GET['update'];
	switch($update){
		case 'flgSuccess':
			$updateMessage = '公開フラグを変更しました';
			break;
		case 'stkSuccess':
			$updateMessage = '在庫数を変更しました';
			break;
		case 'delSuccess':
			$updateMessage = '商品を削除しました';
			break;
		default :
			$updateMessage = '更新に失敗しました';
	}

	if(strpos($update,'Success')){
		$updateResult = 'success';
	}else{
		$updateResult = 'failed';
	}
}else{
	$updateMessage = '';
	$updateResult  = '';
}

// View(view.php）読み込み
include_once '../../include/view/ECsight_management_view.php';

function getStatus($status){
	if ($status == '公開'){
		return 1;
	}else{
		return 0;
	}
}

function brankCheck($name,$price,$image){
	if($name=='' || $price=='' || $image = ''){
		header("Location: management.php?regist=blank");
		exit();
	}
}