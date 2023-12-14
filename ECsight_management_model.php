<?php
require_once 'ECsight_common_model.php';

function sameName($pdo,$name){
    $sql = 'select user_name from ec_user where user_name="'.$name.'"';
    return count(get_sql_result($pdo,$sql)) >0;
}

function insert_product($pdo,$name,$price,$count,$image,$status){
	$pdo->beginTransaction();
    $productSql = "INSERT into ec_product(product_id,product_name,price,product_image,public_flg,create_date,update_date) values(0,'".$name."',".$price.",'".$image['name']."',".$status.",CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
    if(change_sql($pdo,$productSql)){
		$productId = $pdo->lastInsertId();
	}else{
		$pdo->rollback();
        return 'product';
	}

	$imageSql   = "INSERT into ec_image(image_id,image_name,public_flg,create_date,update_date) values(0,'".$image['name']."',".$status.",CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
	if(change_sql($pdo,$imageSql)){
		$imageId = $pdo->lastInsertId();
    }else{
		$pdo->rollback();
        return 'image';
	}

	$stockSql = "INSERT into ec_stock(stock_id,product_id,stock_qty,create_date,update_date) values(0,".$productId.",".$count.",CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
	if(!change_sql($pdo,$stockSql)){
		$pdo->rollback();
        return 'stock';
    }

	$save = '../../htdocs/ec_sight/img/' . $imageId;
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
	$flgSql     = "SELECT public_flg from ec_product where product_id = ".$id;
	$sql_result = get_sql_result($pdo,$flgSql);
	try{
		if($sql_result[0]['public_flg']==1){
			$flg = 0;
		}else{
			$flg = 1;
		}
	}catch(Exception $e){
		return 'not found';
	}
	

	$pdo->beginTransaction();
	$updateSql = "UPDATE ec_product set public_flg =".$flg.",update_date=CURRENT_TIMESTAMP where product_id = ".$id;
	if(change_sql($pdo, $updateSql)){
		$pdo->commit();
		return 'OK';
	}else{
		$pdo->rollback();
		return 'update';
	}
}

function changeStk($pdo,$id,$stock){
	$pdo->beginTransaction();
	$updateSql = "UPDATE ec_stock set stock_qty =".$stock.",update_date=CURRENT_TIMESTAMP where product_id = ".$id;
	if(change_sql($pdo, $updateSql)){
		$pdo->commit();
		return 'OK';
	}else{
		$pdo->rollback();
		return 'failed';
	}
}

function deletePdt($pdo,$id){
	$selectSql  = "SELECT image_id FROM ec_image INNER JOIN ec_product ON ec_product.product_image = ec_image.image_name where ec_product.product_id =".$id;
	if($result = get_sql_result($pdo,$selectSql)){
		$imageId = $result[0]['image_id'];
	}else{
		return 'not_found';
	}

	$pdo->beginTransaction();
	$stockSql   = "DELETE from ec_stock where product_id = ".$id;
	$productSql = "DELETE from ec_product where product_id = ".$id;
	$imageSql   = "DELETE from ec_image where image_id = ".$imageId;
	if(!change_sql($pdo, $stockSql)){
		$pdo->rollback();
		return 'stock';
	}else if(!change_sql($pdo, $productSql)){
		$pdo->rollback();
		return 'product';
	}else if(!change_sql($pdo, $imageSql)){
		$pdo->rollback();
		return 'image';
	}

	$file = '../../htdocs/ec_sight/img/' . $imageId;
	if (unlink($file)){
		$pdo->commit();
		return 'OK';
	}else{
		return 'file';
	}
}