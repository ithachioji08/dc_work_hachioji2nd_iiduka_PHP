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
	$stockSql = "SELECT stock_id from ec_cart where product_id=".$productId;
	if(!$stock = get_sql_result($pdo,$stockSql)[0]['stock_id']){
		return 'select';
	}

	$pdo->beginTransaction();
	if (count($stock) ==0){
		$sql = "INSERT into ec_cart(cart_id,user_id,product_id,product_qty,create_date,update_date) values(0,".$userId.",".$productId.",1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
	}else{
		$sql = "UPDATE ec_cart set product_qty = product_qty+1 where stock_id = ".$stock;
	}
	
	if(change_sql($pdo, $sql)){
		$pdo->commit();
		return 'OK';
	}else{
		$pdo->rollback();
		return 'insert';
	}
}