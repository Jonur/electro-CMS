<?php 
	require("access_isset.php");

	//Print arrows only when there are more than 9 non related photos to this gallery
	require("db_connect.php");
	$sql_img = "SELECT *, `files`.F_ID ID FROM `files` 
				LEFT JOIN `galleries-files` ON `files`.F_ID = `galleries-files`.F_ID AND `galleries-files`.G_ID = '$edit_id' 
				WHERE `files`.F_FILETYPE IN ('.jpg','.jpeg','.gif','.png')
				AND `files`.F_DELETED = 0
				AND `galleries-files`.G_ID IS NULL 
				ORDER BY `galleries-files`.GF_RANK";
	$query_img = mysql_query($sql_img);
	$rows_img = mysql_num_rows($query_img);
	$left_arrow = '';
	$right_arrow = '';
	if ($rows_img > 9)
	{
		$left_arrow = '<img id="arrow_l" class="arrows" src="images/arrow_l.png" />';
		$right_arrow = '<img id="arrow_r" class="arrows" src="images/arrow_r.png" />';
	}
	require("db_disconnect.php");
?>
<div class="breadcrumb">Από Διακομιστή</div>
<form name="form_from_server" method="post" action="scripts/galleries_append_from_server.php">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div id="nav_left"><?php echo $left_arrow; ?></div>
	<div id="server_photo_listing"> 
		<?php
			//server photo listing			
			if($rows_img){
				$counter = 1;
				$divopenned = false;
				$is_displayed = '';
				while($result_img = mysql_fetch_array($query_img))
				{
					if($counter !=1){
						$is_displayed = 'nodisplay';
					}
					if($counter % 9 == 1){
						$divopenned = true;
						echo '<div class="photoBlock '.$is_displayed.'">';
					}
					
					echo '
					<div class="photocell">
						<div class="photocell_left">
							<input name="photocell_item[]" class="photocell_check" type="checkbox" value="'.$result_img['ID'].'" />
						</div>
						<div class="photocell_right photocell_img_frame">
							<a href="'.$local_image_path.$result_img['F_FILENAME'].'" rel="shadowbox">
								<img class="photocell_img" src="'.$local_image_path.'thumbs/thumb_'.$result_img['F_FILENAME'].'" />
							</a>
						</div>
						<div class="clear"></div>
					</div>
					';
					
					if ($counter % 3 == 0)
						echo '<div class="clear"></div>';
					
					if($counter % 9 == 0){
						$divopenned = false;
						echo '</div>';
					}
					$counter++;
				}
				if ($divopenned){
					echo '</div>';
				}
			}else{
				echo '<div class="validation_message_false">Δεν υπάρχουν διαθέσιμες εικόνες στη βάση.</div>';
			}
		?>
	</div>
	<div id="nav_right"><?php echo $right_arrow; ?></div>
	<div class="clear"></div>
	<?php 
		if($rows_img){
			echo '<div class="form_unified_pc"><input class="form_button" type="submit" value="Προσθήκη" onclick = " javascript: return enable_form();" /></div>';
		}
	?>
</form>
