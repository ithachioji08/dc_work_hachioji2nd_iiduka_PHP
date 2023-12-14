<?php 
$title = 'ECサイト_商品一覧';
$is_home = true; //トップページの判定用の変数
include "ECsight_header.php"
?>
<div class="message">
	<?php if($insertMessage != ''){?>
		<div class="messageBox">
			<p class=<?php print "$insertClass";?>>
				<?php print $insertMessage;?>
			</p>
		</div>
	<?php
	}?>
</div>
<div id="catalog">
	<?php foreach ($catalogData as $row) {?>
		<div class="catalogBox">
			<div class="catalogProduct">
				<?php $src = "../../htdocs/ec_sight/img/".$row['image_id'];
				if (file_exists($src)) {?>
					<img class="catalogImage" src='/hachioji2/0001/ec_sight/img/<?php print $row['image_id']?>'>
				<?php }else{?>
					<div class="noimage"><p>no image</p></div>
				<?php }?>
				<p>
					<span class="left"><?php print $row['product_name']?></span>
					<span class="right"><?php print $row['price']?>円</span>
				</p>
				<form  method ="post">
					<input type="hidden" name="productId" value="<?php print $row['product_id']?>">
					<?php if($row['stock_qty'] < 1){
						$inputData = 'disabled="disabled" value="売り切れ"';
					}else{
						$inputData = 'value="カートに入れる"';
					}?>
					<input type="submit" class="inCart" <?php print $inputData;?> >
				</form>
			</div>
			
		</div>
	<?php }?>
</div>

<div class="center links">
	<form class="linkForm cartForm" action ="cart.php">
		<input class="hrefButton cartButton" type="submit" value="カートへ" >
	</form>
	<form class="linkForm logoutForm" action ="index.php">
		<input class="hrefButton logoutButton" type="submit" value="ログアウト">
	</form>
</div>
</body>
</html>