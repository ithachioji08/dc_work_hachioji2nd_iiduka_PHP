<?php
require_once 'ECsight_common_model.php';

function sameName($pdo,$name){
    $sql = 'select user_name from ec_user where user_name="'.$name.'"';
    return count(get_sql_result($pdo,$sql)) >0;
}

function insert_product($pdo,$name,$price,$count,$image,$status){
	$pdo->beginTransaction();
    $productSql = "INSERT into ec_product(product_id,product_name,price,product_image,public_flg,create_date,update_date) values(0,'".$name."',".$price.",'".$image['name']."',".$status.",CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
    if(!change_sql($pdo,$productSql)){
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
	$save = '../../htdocs/ec_sight/img/' . $imageId;
	if(!move_uploaded_file($image['tmp_name'], $save)){
		$pdo->rollback();
		return 'upload';
	}

	$stockSql = "INSERT into ec_stock(stock_id,product_id,stock_qty,create_date,update_date) values(0,".$productId.",".$count.",CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
	if(change_sql($pdo,$stockSql)){
		$pdo->commit();
		return 'OK';
    }else{
		$pdo->rollback();
        return 'stock';
	}
}

function getTable($pdo){
	$sql = "SELECT ec_image.image_id, ec_product.product_name,ec_product.price,ec_stock.stock_qty,ec_product.public_flg FROM ec_product INNER JOIN ec_image ON ec_product.product_image = ec_image.image_name INNER JOIN ec_stock ON ec_product.product_id = ec_stock.product_id";
	return get_sql_result($pdo,$sql);
}