<?php 
$title = 'ECサイト_購入完了';
$is_home = true; //トップページの判定用の変数
include "ECsight_header.php"
?>
<div class="message">
	<div class="messageBox">
		<p class="success">
			購入完了しました。ありがとうございます。
		</p>
	</div>
</div>
<div id="cart">
	<?php 
	$totalprice = 0;
	foreach ($cartData as $row) {?>
		<div class="cartProduct">
			<?php $src = "../../htdocs/ec_sight/img/".$row['image_id'];
			if (file_exists($src)) {?>
				<img class="cartImage" src='/hachioji2/0001/ec_sight/img/<?php print $row['image_id']?>'>
			<?php }else{?>
				<div class="noimage"><p>no image</p></div>
			<?php }?>
			
			<p class="cartName"><?php print $row['product_name'];?></p>
			<p class="cartPrice">価格:￥<?php print $row['price'];?></p>
			<p class="cartCount">数量:<?php print $row['product_qty'];?></p>
		</div>
	<?php 
		$totalprice += $row['price'] * $row['product_qty'];
	}
	?>
</div>
<div class="total">
	<p class="rightMiddle bigFont">
		小計:<?php print $totalprice;?>円
	</p>
</div>
<?php 
$toCart = true;
$action = "catalog.php";
$value  = "商品一覧へ";
include "ECsight_links.php"
?>

</body>
</html>