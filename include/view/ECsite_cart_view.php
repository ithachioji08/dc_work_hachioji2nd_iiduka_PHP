<?php 
$title = 'ECサイト_カート';
$is_home = true; //トップページの判定用の変数
include "ECsite_header.php"
?>
<div class="message">
	<?php if($resultMessage != ''){?>
		<div class="messageBox">
			<p class=<?php print $class;?>>
				<?php print $resultMessage;?>
			</p>
		</div>
	<?php
	}?>
</div>
<div id="cart">
	<?php 
	$totalprice = 0;
	foreach ($cartData as $row) {?>
		<div class="cartProduct">
			<?php $src = "../../htdocs/ec_site/img/".htmlspecialchars($row['image_id']);
			if (file_exists($src)) {?>
				<img class="cartImage" src='/hachioji2/0001/ec_site/img/<?php print htmlspecialchars($row['image_id']);?>'>
			<?php }else{?>
				<div class="noimage"><p>no image</p></div>
			<?php }?>
			
			<p class="cartName"><?php print htmlspecialchars($row['product_name']);?></p>
			<form method ="post" class="cartDelete">
				<input type="hidden" name="delId" value="<?php print htmlspecialchars($row['product_id']);?>">
				<input class="middle" type="submit" value="削除">
			</form>
			<p class="cartPrice">価格:￥<?php print htmlspecialchars($row['price']);?></p>
			<form  method ="post" class="rightMiddle">
				<input type="hidden" name="productId" value="<?php print htmlspecialchars($row['product_id']);?>">
				<input type="number" name="stock" step="1" min="1" value="<?php print htmlspecialchars($row['product_qty']);?>">
				<input type="submit" value="変更する">
			</form>
		</div>
	<?php 
		$totalprice += htmlspecialchars($row['price']) * htmlspecialchars($row['product_qty']);
	}
	?>
</div>
<div class="total">
	<p class="leftMiddle bigFont">
		小計:<?php print htmlspecialchars($totalprice);?>円
	</p>
	<form class="rightMiddle" action="catalog.php" method = "post">
		<input type="hidden" name="back">
		<input class="hrefButton cartButton" type="submit" value="購入一覧へ戻る" >
	</form>
</div>

<?php 
$toCart = true;
$action = "purchase_complete.php";
$value  = "購入する";
include "ECsite_links.php"
?>

</body>
</html>