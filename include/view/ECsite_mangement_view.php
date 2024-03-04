<?php 
$title = 'ECサイト_商品管理';
$is_home = true; //トップページの判定用の変数
include "ECsite_header.php"
?>
	<div>
		<form method="post">
			<p>商品名　:<input type="text" name="product_name"></p>
			<p>価格　　:<input type="text" name="price"></p>
			<p>
				<label for="counter">個数　　:</label>
				<input type="number" id="counter" name="count" step="1">
			</p>
			<p>商品画像:<input type="file" name="image"></p>
			<p>ステータス:<input type="text" name="status"></p>
			<input type="submit" value= "商品を登録"/>
		</form>
		<div class="link"><a href="register.php">新規登録ページへ</a></div>
	</div>
</body>
</html>