<?php
require_once 'ECsite_common_model.php';
require_once 'ECsite_get_cart.php';

function deleteCart($pdo,$userid){
	$pdo->beginTransaction();
	try{
		$sql  = "DELETE from ec_cart where user_id=:userId";
		$stmt = $pdo->prepare($sql);
		$stmt -> bindParam(':userId',$userid, PDO::PARAM_INT);
		$stmt -> execute();
		$pdo->commit();
	}catch(PDOException $e){
		$pdo->rollback();
	}

}

function reduceStock($pdo,$cartData){
	$pdo->beginTransaction();
	try{
		foreach($cartData as $row){
			$sql = "UPDATE ec_stock set stock_qty = stock_qty-:qty,update_date=CURRENT_TIMESTAMP where product_id = :productId";
			$stmt = $pdo->prepare($sql);
			$stmt -> bindParam(':qty',$row['product_qty'], PDO::PARAM_INT);
			$stmt -> bindParam(':productId',$row['product_id'], PDO::PARAM_INT);
			$stmt -> execute();
		}
		$pdo->commit();
	}catch(PDOException $e){
		$pdo->rollback();
	}

}