<div class="center links">
	<?php if($toCart){?>
		<form class="twoLinksForm cartForm" action ="<?php print $action;?>">
			<input class="hrefButton cartButton" type="submit" value="<?php print $value;?>" >
		</form>
	<?php
		$class = 'twoLinksForm logoutForm';
	}else{
		$class = 'linkForm center';
	}?>
	<form class=" <?php print $class?>" method="post" action ="index.php">
		<input type="hidden" name="logout">
		<input class="hrefButton logoutButton" type="submit" value="ログアウト">
	</form>
</div>