<?php 
$title = 'ECサイト';
$is_home = true; //トップページの判定用の変数
include "ECsite_header.php"
?>
	<div class="center">
		<h1>ログイン</h1>
		<?php if($resultMessage!=''){?>
			<p class="error">
				<?php print $resultMessage;?>
			</p>
		<?php }?>
		<form method="post">
			<p>ユーザー名:<input type="text" name="user_name"></p>
			<p>パスワード:<input type="password" name="password"></p>
			<input class="btn" type="submit" value= "ログイン"/>
		</form>
		<div class="link"><a href="register.php">新規登録ページへ</a></div>
	</div>
</body>
</html>