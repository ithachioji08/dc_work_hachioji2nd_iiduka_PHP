<?php
require_once 'ECsight_common_model.php';
require_once 'ECsight_get_cart.php';

function getCatalog($pdo){
	$sql = "SELECT ec_image.image_id,ec_product.product_id, ec_product.product_name,ec_product.price ,ec_stock.stock_qty FROM ec_product INNER JOIN ec_image ON ec_product.product_image = ec_image.image_name INNER JOIN ec_stock ON ec_product.product_id = ec_stock.product_id where ec_product.public_flg = 1";
	return get_sql_result($pdo,$sql);
}

function setCart($pdo,$productId,$userId){
	$countSql = "SELECT count(1) from ec_cart where user_id=:userId and product_id=:productId";
	$stmt     = $pdo->prepare($countSql);
	$stmt     -> bindParam(':productId',$productId,PDO::PARAM_INT);
	$stmt     -> bindParam(':userId',$userId,PDO::PARAM_INT);
	$stmt     -> execute();
	$result   = $stmt->fetchAll(PDO::FETCH_ASSOC);

	$pdo->beginTransaction();
	if($result[0]['count(1)'] ==0){
		$sql          = "INSERT into ec_cart(cart_id,user_id,product_id,product_qty,create_date,update_date) values(0,:userId,:productId,1,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		$errorMessage = 'insert';
	}else{
		$sql          = "UPDATE ec_cart set product_qty = product_qty+1,update_date=CURRENT_TIMESTAMP where product_id = :productId and user_id=:userId";
		$errorMessage = 'update';
	}

	try{
		$stmt =  $pdo->prepare($sql);
		$stmt -> bindParam(':productId',$productId,PDO::PARAM_INT);
		$stmt -> bindParam(':userId',$userId,PDO::PARAM_INT);
		$stmt -> execute();
		$pdo->commit();
		return 'OK';
	}catch(PDOException $e){
		$pdo->rollback();
		return $errorMessage;
	}
}