<?php 
$title = 'ECサイト_ユーザー登録';
$is_home = true; //トップページの判定用の変数
include "ECsite_header.php"
?>
	<div class="center">
		<h1>ユーザー登録</h1>
		<?php if($resultMessage!=''){?>
			<p class="error">
				<?php print htmlspecialchars($resultMessage, ENT_QUOTES, 'UTF-8');?>
			</p>
		<?php }?>
		<form method="post">
			<p>ユーザー名:<input type="text" name="user_name"></p>
			<p>パスワード:<input type="password" name="password"></p>
			<input class="btn" type="submit" value= "登録"/>
		</form>
		<div class="link"><a href="index.php">ログインページへ</a></div>
	</div>
</body>