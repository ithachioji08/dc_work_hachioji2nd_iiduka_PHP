<?php
require_once 'ECsight_common_model.php';

function get_user_list($pdo,$user_name,$password){
	$sql    = 'SELECT user_id, user_name,password from ec_user where user_name =:user_name and password =:password';
	$stmt   = $pdo->prepare($sql);
	$stmt   -> bindParam(':user_name',$user_name, PDO::PARAM_STR);
	$stmt   -> bindParam(':password',$password, PDO::PARAM_STR);
	$stmt   -> execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	if ($stmt->rowCount() ==0){
    	return 'none';
	}else if($result[0]['user_id']==1){
    	return "admin";
  	}else{
    	return $result[0]['user_id'];
  	}
}