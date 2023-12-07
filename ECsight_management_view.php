<?php 
$title = 'ECサイト_商品管理';
$is_home = true; //トップページの判定用の変数
include "ECsight_header.php"
?>
	<div class="regist">
		<?php  if($regist_success!=''){?>
			<p class="sucess">
				<?php print $regist_success;?>
			</p>
		<?php }?>
		<form method="post" enctype="multipart/form-data">
			<p>商品名　　:<input type="text" name="product_name"></p>
			<p>価格　　　:<input type="number" name="price"></p>
			<p>
				<label for="counter">個数　　　:</label>
				<input type="number" id="counter" name="count" step="1" min="1" value="1">
			</p>
			<p>商品画像　:<input type="file" name="image"></p>
			<p>ステータス:
				<select name="status">
					<option>公開</option>
					<option>非公開</option>
				</select>
			</p>
			<?php if($regist_failed!=''){?>
				<p class="failed">
					<?php print $regist_failed;?>
				</p>
			<?php }?>
			<input type="submit" value= "商品を登録"/>
		</form>
		<div class="link"><a href="index.php">ログアウト</a></div>
	</div>
	<?php print_r($tableData) ?>
	<table id="product_table">
		<thead>
			<tr>
				<td>商品画像</td>
				<td>商品名</td>
				<td>価格</td>
				<td>在庫数</td>
				<td>公開フラグ</td>
				<td>削除</td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($tableData as $row) {
			?>
				<tr>
					<td>
						<?php $src = "../../htdocs/ec_sight/img/".$row['image_id'];
						if (file_exists($src)) {?>
							<img src='/hachioji2/0001/ec_sight/img/<?php print $row['image_id']?>'>
						<?php }else{?>
							<div class="noimage"><p>no image</p></div>
						<?php }?>
					</td>
					<td><?php print $row['product_name']?></td>
					<td><?php print $row['price']?></td>
					<td><?php print $row['stock_qty']?></td>
					<td><?php print $row['public_flg']?></td>
				</tr>	
			<?php
			}
			?>
		</tbody>
	</table>
</body>
</html>