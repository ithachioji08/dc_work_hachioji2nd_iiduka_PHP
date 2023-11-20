<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ECサイト</title>
	<link rel="stylesheet" href="../include/view/ECsight.css" />
</head>
<body>
	<?php include "ECsight_header.html" ?>
	<h1>ログイン</h1>
	<?php  if($message!='')?><p class="error"><?php print $message;?></p>
	<form method="post">
		<p>ユーザー名:<input type="text" name="user_name"></p>
		<p>パスワード:<input type="text" name="password"></p>
		<input class="" type="submit" value= "登録"/>
	</form>
	<div class="link"><a href="register.php">新規登録ページへ</a></div>
</body>
</html>