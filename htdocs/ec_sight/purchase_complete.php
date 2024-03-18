<?php
// Model（model.php）を読み込む
require_once '../../include/utility/session_management.php';
require_once '../../include/model/ECsite_purchase_complete_model.php';
require_once '../../include/config/const.php';

$pdo      = get_connection();

$cartData = getCart($pdo,$_COOKIE['userid']);

if(count($cartData) > 0){
	deleteCart($pdo,$_COOKIE['userid']);
	reduceStock($pdo,$cartData);
	$cartStrings = convertString($cartData);
}else{
	$cartData = convertArray($_COOKIE['id'],$_COOKIE['name'],$_COOKIE['price'],$_COOKIE['qty'],$_COOKIE['img']);
}

function convertString($cartArray){
	$idString    = '';
	$nameString  = '';
	$priceString = '';
	$qtyString   = '';
	$imgString   = '';
	foreach($cartArray as $row){
		$idString    .= strval($row['product_id']) . ',';
		$nameString  .= $row['product_name'] . ',';
		$priceString .= strval($row['price']) . ',';
		$qtyString   .= strval($row['product_qty']) . ',';
		$imgString   .= strval($row['image_id']) . ',';
	}
	return ['id'=>$idString,'name'=>$nameString,'price'=>$priceString,'qty'=>$qtyString,'img'=>$imgString];
}

function convertArray($id,$name,$price,$qty,$img){
	$convertedArray = [];
	$pattern        = "[,]";
	$idArray        = preg_split($pattern,$id);
	$nameArray      = preg_split($pattern,$name);
	$priceArray     = preg_split($pattern,$price);
	$qtyArray       = preg_split($pattern,$qty);
	$imgArray       = preg_split($pattern,$img);
	for($i=0;$i+1<count($idArray);$i++){
		array_push(
			$convertedArray,
			['product_id'=>intval($idArray[$i]),'product_name'=>$nameArray[$i],'price'=>intval($priceArray[$i]),'product_qty'=>intval($qtyArray[$i]),'image_id'=>intval($imgArray[$i])]);
	}
	return $convertedArray;
}

// View(view.php）読み込み
include_once '../../include/view/ECsite_purchase_complete_view.php';