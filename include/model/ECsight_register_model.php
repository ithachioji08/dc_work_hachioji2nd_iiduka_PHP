<?php
require_once 'ECsight_common_model.php';

function sameName($pdo,$name){
    $sql = 'select user_name from ec_user where user_name="'.$name.'"';
    return count(get_sql_result($pdo,$sql)) >0;
}

function insert_user($pdo,$name,$password){
	$pdo->beginTransaction();
    $sql = "INSERT into ec_user(user_id,user_name,password,create_date,update_date) values(0,'".$name."','".$password."',CURRENT_TIMESTAMP,CURRENT_TIMESTAMP)";
    if(change_sql($pdo,$sql)){
        $pdo->commit();
        return true;
    }else{
        $pdo->rollback();
        return false;
    }
}