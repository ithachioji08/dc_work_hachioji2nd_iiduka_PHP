<?php
require_once 'ECsight_common_model.php';
require_once 'ECsight_get_cart.php';

function deleteCart($pdo,$userid){
	$pdo->beginTransaction();
	$sql = "DELETE from ec_cart where user_id=".$userid;
	if(change_sql($pdo, $sql)){
		$pdo->commit();
	}else{
		$pdo->rollback();
	}
}

function reduceStock($pdo,$cartData){
	$pdo->beginTransaction();
	foreach($cartData as $row){
		$sql = "UPDATE ec_stock set stock_qty = stock_qty-".$row['product_qty'].",update_date=CURRENT_TIMESTAMP where product_id = ".$row['product_id'];
		if(!change_sql($pdo, $sql)){
			$pdo->rollback();
			return false;
		}
	}
	$pdo->commit();
}