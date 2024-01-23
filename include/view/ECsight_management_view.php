<?php 
$title = 'ECサイト_商品管理';
$is_home = true; //トップページの判定用の変数
include "ECsight_header.php"
?>
	<div class="regist">
		<?php  if($regist_success!=''){?>
			<p class="success">
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
		<form method="post" action ="index.php">
			<input type="hidden" name="logout">
			<input type="submit" value="ログアウト">
		</form>
		<?php if($resultMessage!=''){?>
			<p class=<?php print $updateResult; ?>>
				<?php print $resultMessage;?>
			</p>
		<?php }?>
	</div>
	
	<table id="product_table">
		<thead>
			<tr>
				<td class="tableCell theadImage">商品画像</td>
				<td class="tableCell theadProduct">商品名</td>
				<td class="tableCell theadPrice">価格</td>
				<td class="tableCell theadStock">在庫数</td>
				<td class="tableCell theadFlg">公開フラグ</td>
				<td class="tableCell theadDel">削除</td>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($tableData as $row) {
				if($row['public_flg'] == 0){
					$pubClass = 'unpublic';
					$value    = '表示する';
				}else{
					$pubClass = '';
					$value    = '非表示にする';
				}
			?>
				<tr>
					<td class="tableCell tableImage <?php print $pubClass?>">
						<?php $src = "../../htdocs/ec_sight/img/".$row['image_id'];
						if (file_exists($src)) {?>
							<img src='/hachioji2/0001/ec_sight/img/<?php print $row['image_id']?>'>
						<?php }else{?>
							<div class="noimage"><p>no image</p></div>
						<?php }?>
					</td>
					<td class="tableCell <?php print $pubClass?>">
						<?php print $row['product_name']?>
					</td>
					<td class="tableCell <?php print $pubClass?>">
						￥<?php print $row['price']?>
					</td>
					<td class="tableCell <?php print $pubClass?>">
						<form method ="post">
							<input type="hidden" name="stkId" value="<?php print $row['product_id'];?>">
							<input type="number" class='stkNum' name="stock" value="<?php print $row['stock_qty']?>">
							<input type='submit' value="変更する">
						</form>
					</td>
					<td class="tableCell <?php print $pubClass?>">
						<form method ="post">
							<input type="hidden" name="flgChange" value="<?php print $row['product_id'];?>">
							<input type='submit' value="<?php print $value;?>">
						</form>
					</td>
					<td class="tableCell <?php print $pubClass?>">
						<form method ="post">
							<input type="hidden" name="delId" value="<?php print $row['product_id'];?>">
							<input type='submit' value="削除する" href="management.php?delete=<?php print $row['product_id']?>">
						</form>
					</td>
				</tr>	
			<?php
			}
			?>
		</tbody>
	</table>
</body>
</html>