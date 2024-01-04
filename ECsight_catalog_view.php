<?php 
$title = 'ECサイト_商品一覧';
$is_home = true; //トップページの判定用の変数
include "ECsight_header.php"
?>
<div class="message">
	<?php if($resultMessage != ''){?>
		<div class="messageBox">
			<p class=<?php print "$class";?>>
				<?php print $resultMessage;?>
			</p>
		</div>
	<?php
	}?>
</div>
<div id="catalog">
	<?php
	 foreach ($catalogData as $row) {?>
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


<div id="modalOverlay"  onclick="modalClose()">
	<div id="modal">
		<p>現在のカート内の商品はこちらです。</p>
		<p>画面のどこかをクリックすることで閉じます</p>
		<div class="modalData">
			<?php 
			$totalprice = 0;
			foreach ($cartData as $row) {?>
				<p>
					<span class="modalName"><?php print $row['product_name'];?></span>
					<span class="modalPrice"> ￥<?php print $row['price'];?></span>
					<span class="modalCount">  <?php print $row['product_qty']?>個</span>
				</p>
			<?php 
				$totalprice += $row['price'] * $row['product_qty'];
			}
			?>
		</div>
		<p class="cartForm">合計  ￥<?php print $totalprice;?></p>
	</div>
</div>
<?php 
$toCart = true;
$action = "cart.php";
$value  = "カートへ";
include "ECsight_links.php"
?>

<script>
	console.log(<?php echo $backed; ?>);
	if(Boolean(<?php echo $backed; ?>)){
		document.getElementById("modal").style.display        = "block";
		document.getElementById("modalOverlay").style.display = "block";
	}

	function modalClose(){
		document.getElementById("modal").style.display        = "none";
		document.getElementById("modalOverlay").style.display = "none";
	}
</script>

</body>
</html>