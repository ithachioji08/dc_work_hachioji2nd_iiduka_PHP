<?php
// Model（model.php）を読み込む
//require_once '../../include/model/ECsight_management_model.php';
require_once '../../include/config/const.php';
 
//$pdo = get_connection();

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['product_name'])) {
	$name   = $_POST['user_name'];
	$price  = $_POST['price'];
	$count  = $_POST['count'];
	$image  = $_FILES['image'];
	$status = getStatus($_POST['status']);
	brankCheck($name,$price,$image);
	switch(insert_product($pdo,$name,$price,$count,$image,$status)){
		case 'none';
			header("Location: index.php?message=mismatch");
			break;
		case 'admin':
			header("Location: management.php");
			break;
		case 'user':
			header("Location: product_list.php");
			break;
	}
}

if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['message'])) {
	switch($_GET['message']) {
		case 'blank':
			$message = 'ユーザー名またはパスワードが入力されていません';
			break;
	}
}else{
	$message = '';
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
		header("Location: index.php?message=blank");
		exit();
	}
}