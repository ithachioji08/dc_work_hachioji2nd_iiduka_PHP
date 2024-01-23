<?php
/**
* DB接続を行いPDOインスタンスを返す
* 
* @return object $pdo 
*/
function get_connection() {
  try{
    // PDOインスタンスの生成
   $pdo = new PDO(dsn, login_user, password);
  } catch (PDOException $e) {
    echo $e->getMessage();
    exit();
  }

  return $pdo;
}
 
/**
* SQL文を実行・結果を配列で取得する
*
* @param object $pdo
* @param string $sql 実行されるSQL文章
* @return array 結果セットの配列
*/
function get_sql_result($pdo, $sql) {
  $data = [];
  if ($result = $pdo->query($sql)) {
    if ($result->rowCount() > 0) {
      while ($row = $result->fetch()) {
        $data[] = $row;
      }
    }
  }
  return $data;
}

/**
* SQL文の挿入編集を実行。
*
* @param object $pdo
* @param string $sql 実行されるSQL文章
* @return boolean 結果セットの配列
*/
function change_sql($pdo, $sql) {
	
    if ($pdo->query($sql)) {
      return true;
    }else {
      return false;
    }
}