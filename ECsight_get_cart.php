<?php
function getCart($pdo){
	$sql = "SELECT ec_cart.product_id,ec_product.product_name,ec_product.price,ec_cart.product_qty,ec_image.image_id FROM ec_cart INNER JOIN ec_product ON ec_product.product_id = ec_cart.product_id INNER JOIN ec_image ON ec_product.product_image = ec_image.image_name";
	return get_sql_result($pdo,$sql);
}