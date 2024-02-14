<?php
require_once 'ECsight_common_model.php';

function get_user_list($pdo,$user_name,$password){
	$sql    = 'SELECT user_id, user_name,password from ec_user where user_name =:user_name';
	$stmt   = $pdo->prepare($sql);
	$stmt   -> bindParam(':user_name',$user_name, PDO::PARAM_STR);
	$stmt   -> execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$pass   = $result[0]['password'];
	if(!password_verify($password,$pass)){
		return 'none';
	}
	$userId = $result[0]['user_id'];
	if($userId==1){
    	return "admin";
  	}else{
    	return $userId;
  	}
}