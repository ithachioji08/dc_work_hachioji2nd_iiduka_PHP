<?php
require_once 'ECsight_common_model.php';
require_once 'ECsight_get_cart.php';


function updateQty($pdo,$id,$stock,$userId){
	$selectSql = "SELECT stock_qty from ec_stock where product_id=".$id." and user_id=".$userId;
	if(!$count = get_sql_result($pdo,$selectSql)[0]['stock_qty']){
		return 'updateFailed';
	}

	if($count < $stock){
		return 'over';
	}

	$pdo->beginTransaction();
	$updateSql = "UPDATE ec_cart SET product_qty=".$stock.",update_date=CURRENT_TIMESTAMP WHERE product_id = ".$id." and user_id=".$userId;
	if(change_sql($pdo, $updateSql)){
		$pdo->commit();
		return 'update';
	}else{
		$pdo->rollback();
		return 'updateFailed';
	}
}

function oneDelete($pdo,$id,$userId){
	$pdo->beginTransaction();
	$sql = "DELETE from ec_cart where product_id =".$id." and user_id=".$userId;
	if(change_sql($pdo, $sql)){
		$pdo->commit();
		return 'delete';
	}else{
		$pdo->rollback();
		return 'deleteFailed';
	}
}