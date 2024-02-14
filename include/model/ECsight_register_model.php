<?php
require_once 'ECsight_common_model.php';

function sameName($pdo,$name){
    $sql  = 'SELECT count(1) from ec_user where user_name=:name';
	$stmt = $pdo->prepare($sql);
	$stmt -> bindParam(':name',$name, PDO::PARAM_STR);
	$stmt -> execute();
	$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result[0]['count(1)'] >0;
}

function insert_user($pdo,$name,$password){
	$pdo->beginTransaction();
	try{
		$sql  = "INSERT into ec_user(user_id,user_name,password,create_date,update_date) values(0,:name,:password,CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
		$stmt = $pdo->prepare($sql);
		$stmt -> bindParam(':name',$name, PDO::PARAM_STR);
		$stmt -> bindParam(':password', password_hash($password, PASSWORD_DEFAULT), PDO::PARAM_STR);
		$stmt -> execute();
		$pdo->commit();
        return true;
	}catch(PDOException $e){
		$pdo->rollback();
		return false;
	}
}