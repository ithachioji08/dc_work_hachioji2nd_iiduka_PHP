<?php
require_once 'ECsight_common_model.php';

function get_user_list($pdo,$user_name,$password){
  $sql    = 'select user_id, user_name,password from ec_user where user_name ="'.$user_name.'" and password ="'.$password.'"';
  $result = get_sql_result($pdo,$sql);
  if (count($result) ==0){
    return 'none';
  }else if($result[0]['user_id']==1){
    return "admin";
  }else{
    return $result[0]['user_id'];
  }
}