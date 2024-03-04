<?php
require_once 'ECsite_common_model.php';
require_once 'ECsite_get_cart.php';

function updateQty($pdo,$id,$stock,$userId){
	$selectSql  = "SELECT stock_qty from ec_stock where product_id=:id";
	$stmt       = $pdo->prepare($selectSql);
	$stmt       -> bindParam(':id',$id, PDO::PARAM_INT);
	$stmt       -> execute();
	$result     = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if(!$count = $result[0]['stock_qty']){
		return 'updateFailed';
	}

	if($count < $stock){
		return 'over';
	}
	try{
		$pdo->beginTransaction();
		$updateSql = "UPDATE ec_cart SET product_qty=:stock,update_date=CURRENT_TIMESTAMP WHERE product_id = :id and user_id = :userid";
		$stmt      = $pdo->prepare($updateSql);
		$stmt      -> bindParam(':id',$id, PDO::PARAM_INT);
		$stmt      -> bindParam(':stock',$stock,PDO::PARAM_INT);
		$stmt      -> bindParam(':userid',$userId,PDO::PARAM_INT);
		$stmt -> execute();
		$pdo->commit();
		return 'update';
	}catch(PDOException $e){
		$pdo->rollback();
		return 'updateFailed';
	}
}

function oneDelete($pdo,$id,$userId){
	try{
		$pdo->beginTransaction();
		$sql  = "DELETE from ec_cart where product_id =:id and user_id=:user_id";
		$stmt = $pdo->prepare($sql);
		$stmt -> bindParam(':id',$id, PDO::PARAM_INT);
		$stmt -> bindParam(':user_id',$userId, PDO::PARAM_INT);
		$stmt -> execute();
		$pdo->commit();
		return 'OK';
	}catch(PDOException $e){
		$pdo->rollback();
		return 'deleteFailed';
	}
}