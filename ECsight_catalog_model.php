<?php
require_once 'ECsight_common_model.php';

function getCatalog($pdo){
	$sql = "SELECT ec_image.image_id,ec_product.product_id, ec_product.product_name,ec_product.price ,ec_stock.stock_qty FROM ec_product INNER JOIN ec_image ON ec_product.product_image = ec_image.image_name INNER JOIN ec_stock ON ec_product.product_id = ec_stock.product_id where ec_product.public_flg = 1";
	return get_sql_result($pdo,$sql);
}

function getCart($pdo,$id){
	$cartData = [];
	$sql    = "SELECT product_id FROM ec_cart where user_id=".$id;
	if(!$result = get_sql_result($pdo,$sql)){
		return $cartData;
	}
	foreach($result as $row){
		array_push($cartData,$row['product_id']);
	}
	return $cartData;
}

function setCart($pdo,$productId,$userId){
	$countSql = "SELECT count(1) from ec_cart where user_id=".$userId." and product_id=".$productId;
	if(!$count = get_sql_result($pdo,$countSql)){
		return 'select';
	}

	$pdo->beginTransaction();
	if($count[0]['count(1)'] ==0){
		$sql          = "INSERT into ec_cart(cart_id,user_id,product_id,product_qty,create_date,update_date) values(0,".$userId.",".$productId.",1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		$errorMessage = 'insert';
	}else{
		$sql          = "UPDATE ec_cart set product_qty = product_qty+1,update_date=CURRENT_TIMESTAMP where product_id = ".$productId." and user_id=".$userId;
		$errorMessage = 'update';
	}

	if(change_sql($pdo, $sql)){
		$pdo->commit();
		return 'OK';
	}else{
		$pdo->rollback();
		return $errorMessage;
	}

}