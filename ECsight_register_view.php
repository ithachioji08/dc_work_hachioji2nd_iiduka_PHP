<?php 
$title = 'ECサイト_ユーザー登録';
$is_home = true; //トップページの判定用の変数
include "ECsight_header.php"
?>
	<div class="center">
		<h1>ユーザー登録</h1>
		<?php  if($message!='')?><p class="error"><?php print $message;?></p>
		<form method="post">
			<p>ユーザー名:<input type="text" name="user_name"></p>
			<p>パスワード:<input type="text" name="password"></p>
			<input class="btn" type="submit" value= "登録"/>
		</form>
		<div class="link"><a href="index.php">ログインページへ</a></div>
	</div>
</body>