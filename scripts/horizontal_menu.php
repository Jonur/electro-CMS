<?php
	require("access_isset.php");
?>
<div class="horizontal_menu_owner horizontal_menu_item">
	<?php echo $owner_title; ?>
</div>
<div class="horizontal_menu_content">
<?php 
	//Kataskeyazoume to orizontio menu
	if(!empty($_SESSION['EU_ID']) && !empty($_SESSION['EU_USERNAME']))
	{
		echo '<div class="horizontal_menu_item">';
			echo $_SESSION['EU_USERNAME'];
			echo '&nbsp;&nbsp;&#124;&nbsp;&nbsp;';
			echo '<a href="?action=electro_users_profile">Το προφίλ μου</a>';
			echo '&nbsp;&nbsp;&#124;&nbsp;&nbsp;';
			echo '<a href="scripts/logout.php">Αποσύνδεση</a>';
		echo '</div>';
	}else{
		echo '<div class="horizontal_menu_item">';
			echo 'Παρακαλώ εισέλθετε στο σύστημα.';
		echo '</div>';
	}
?>
</div>