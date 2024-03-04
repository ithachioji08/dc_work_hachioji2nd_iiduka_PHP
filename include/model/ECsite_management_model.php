<?php
require_once 'ECsite_common_model.php';

function sameName($pdo,$name){
    $sql = 'select user_name from ec_user where user_name=:name';
	$stmt = $pdo->prepare($sql);
	$stmt -> bindParam(':name',$name, PDO::PARAM_STR);
	$stmt -> execute();
    return $stmt->rowCount() >0;
}

function insert_product($pdo,$name,$price,$count,$image,$status){
	$imageName = $image['name'];
	$pdo->beginTransaction();
	try{
		$productSql  = "INSERT into ec_product(product_id,product_name,price,product_image,public_flg,create_date,update_date) values(0,:name,:price,:imageName,:status,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		$stmt        = $pdo->prepare($productSql);
		$stmt        -> bindParam(':name',$name, PDO::PARAM_STR);
		$stmt        -> bindParam(':price',$price, PDO::PARAM_INT);
		$stmt        -> bindParam(':imageName',$imageName, PDO::PARAM_STR);
		$stmt        -> bindParam(':status',$status, PDO::PARAM_INT);
		$stmt -> execute();
		$productId   = $pdo->lastInsertId();
	}catch(PDOException $e){
		$pdo->rollback();
		return 'product';
	}

	try{
		$imageSql = "INSERT into ec_image(image_id,image_name,public_flg,create_date,update_date) values(0,:imageName,:status,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		$stmt     = $pdo->prepare($imageSql);
		$stmt     -> bindParam(':imageName',$imageName, PDO::PARAM_STR);
		$stmt     -> bindParam(':status',$status, PDO::PARAM_INT);
		$stmt     -> execute();
		$imageId  = $pdo->lastInsertId();
	}catch(PDOException $e){
		$pdo->rollback();
		return 'image';
	}

	try{	
		$stockSql = "INSERT into ec_stock(stock_id,product_id,stock_qty,create_date,update_date) values(0,:productId,:count,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		$stmt     =  $pdo->prepare($stockSql);
		$stmt     -> bindParam(':productId',$productId, PDO::PARAM_INT);
		$stmt     -> bindParam(':count',$count, PDO::PARAM_INT);
		$stmt     -> execute();
	}catch(PDOException $e){
		$pdo->rollback();
		return 'stock';
	}

	$allowedMimeTypes = ['image/jpeg', 'image/png'];
	
	$maxFileSize = 2 * 1024 * 1024; // 例: 2MB
	if (!in_array($_FILES['image']['type'], $allowedMimeTypes)) {
		$pdo->rollback();
		return 'type';
	}
	if ($_FILES['image']['size'] > $maxFileSize) {
		$pdo->rollback();
		return 'size';
	}
	$fileName = basename($_FILES['image']['name']);
	if (!preg_match('/^\w+\.(jpg|jpeg|png)$/', $fileName)) {
		$pdo->rollback();
		return 'name';
	}
	
	$save = '../../htdocs/ec_site/img/' . $imageId;
	if(move_uploaded_file($image['tmp_name'], $save)){
		$pdo->commit();
		return 'OK';
	}else{
		$pdo->rollback();
		return 'upload';
	}
}

function getTable($pdo){
	$sql = "SELECT ec_product.product_id, ec_image.image_id, ec_product.product_name,ec_product.price,ec_stock.stock_qty,ec_product.public_flg FROM ec_product INNER JOIN ec_image ON ec_product.product_image = ec_image.image_name INNER JOIN ec_stock ON ec_product.product_id = ec_stock.product_id";
	return get_sql_result($pdo,$sql);
}

function changeFlg($pdo,$id){
	$pdo->beginTransaction();
	try{
		$updateSql = "UPDATE ec_product set public_flg =if(public_flg = 1, 0, 1),update_date=CURRENT_TIMESTAMP where product_id = :id";
		$stmt      = $pdo->prepare($updateSql);
		$stmt      -> bindParam(':id',$id, PDO::PARAM_INT);
		$stmt      -> execute();
		$pdo->commit();
		return 'OK';
	}catch(PDOException $e){
		$pdo->rollback();
		return 'update';
	}
}

function changeStk($pdo,$id,$stock){
	$pdo->beginTransaction();
	try{
		$sql  = "UPDATE ec_stock set stock_qty =:stock,update_date=CURRENT_TIMESTAMP where product_id = :id";
		$stmt = $pdo->prepare($sql);
		$stmt -> bindParam(':stock',$stock, PDO::PARAM_INT);
		$stmt -> bindParam(':id',$id, PDO::PARAM_INT);
		$stmt -> execute();
		$pdo->commit();
		return 'OK';
	}catch(PDOException $e){
		$pdo->rollback();
		return 'failed';
	}
}

function deletePdt($pdo,$id){
	$selectSql = "SELECT image_id FROM ec_image INNER JOIN ec_product ON ec_product.product_image = ec_image.image_name where ec_product.product_id = :id";
	$stmt      =  $pdo->prepare($selectSql);
	$stmt      -> bindParam(':id',$id, PDO::PARAM_INT);
	$stmt -> execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if($stmt->rowCount()){
		$imageId = $result[0]['image_id'];
	}else{
		return 'not_found';
	}

	$pdo->beginTransaction();
	$stockSql   = "DELETE from ec_stock where product_id = :id";
	$productSql = "DELETE from ec_product where product_id = :id";
	$imageSql   = "DELETE from ec_image where image_id = :imageId";
	try{
		$stmt = $pdo->prepare($stockSql);
		$stmt -> bindParam(':id',$id, PDO::PARAM_INT);
		$stmt -> execute();
	}catch(PDOException $e){
		$pdo->rollback();
		return 'stock';
	}

	try{
		$stmt = $pdo->prepare($productSql);
		$stmt -> bindParam(':id',$id, PDO::PARAM_INT);
		$stmt -> execute();
	}catch(PDOException $e){
		$pdo->rollback();
		return 'product';
	}
	
	try{
		$stmt = $pdo->prepare($imageSql);
		$stmt -> bindParam(':imageId',$imageId, PDO::PARAM_INT);
		$stmt -> execute();
	}catch(PDOException $e){
		$pdo->rollback();
		return 'image';
	}

	$file = '../../htdocs/ec_site/img/' . $imageId;
	if (unlink($file)){
		$pdo->commit();
		return 'OK';
	}else{
		$pdo->rollback();
		return 'file';
	}
}

function getStatus($status){
	if ($status == '公開'){
		return 1;
	}else{
		return 0;
	}
}

function validation($name,$price,$image){
	if($name=='' || $price=='' || $image = ''){
		header("Location: management.php?regist=blank");
		exit();
	}
}