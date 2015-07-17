<?php 
	require("access_isset.php");

	if (!empty($_REQUEST['id']))
	{
		$edit_id = $_REQUEST['id'];
	}else{
		//Redirection
		header('Location: ../electro/');
	}
	
	require("db_connect.php");
	//START:Get the gallery's name
	$sql_edit_g = "SELECT * FROM `galleries` INNER JOIN `galleries-languages` ON `galleries`.G_ID = `galleries-languages`.G_ID 
			   WHERE `galleries`.G_ID = '$edit_id' AND `galleries-languages`.L_ID = '$DLTL'";
	if(!$query_edit_g = mysql_query($sql_edit_g))
		header('Location: ../electro/'); //Redirection
	while ($g_row = mysql_fetch_array($query_edit_g))
		$gallery_name = stripslashes($g_row['GL_ALIAS']);
	//END:Get the gallery's name
	
	//Print arrows only when there are more than 9 photos to this gallery
	$sql_img_g = "SELECT * FROM `files` 
						INNER JOIN `galleries-files` ON `files`.F_ID = `galleries-files`.F_ID 
						WHERE `files`.F_FILETYPE IN ('.jpg','.jpeg','.gif','.png') 
						AND `files`.F_DELETED = 0 
						AND `galleries-files`.G_ID = '$edit_id' 
						ORDER BY `galleries-files`.GF_RANK ";
	$query_img_g = mysql_query($sql_img_g);
	$rows_img_g = mysql_num_rows($query_img_g);
	$left_arrow_g = '';
	$right_arrow_g = '';
	if ($rows_img_g > 9)
	{
		$left_arrow_g = '<img id="arrow_l" class="arrows" src="images/arrow_l.png" />';
		$right_arrow_g = '<img id="arrow_r" class="arrows" src="images/arrow_r.png" />';
	}
	require("db_disconnect.php");
?>

<div class="breadcrumb">Δημιουργία Περιεχομένου &raquo; Γκαλερί &raquo; Προσθήκη Φωτογραφιών &raquo; <?php echo $gallery_name; ?></div>
<button type="button" class="append_button ab_medium slide_button_main">Προσθήκη</button>
<button type="button" class="append_button ab_medium slide_button_server button_show_server">Άκυρο</button>
<button type="button" class="append_button ab_medium slide_button_pc button_show_pc">Άκυρο</button>
<?php echo $validation_message; ?>
<div class="clear"></div>
<div id="from_pc">
	<?php include("from_pc.php"); ?>
</div>
<div id="from_server">
	<?php include("from_server.php"); ?>
</div>
<div id="form_selector">
	<button type="button" class="append_button ab_large slide_button_server">Από Διακομιστή</button>
	<br />
	<button type="button" class="append_button ab_large slide_button_pc">Από Υπολογιστή</button>
</div>
<div class="clear"></div>
<div id="photo_listing"> 
	<div id="nav_left"><?php echo $left_arrow_g; ?></div>
	<div id="gallery_photo_listing"> 
		<?php
			//server photo listing
			if($rows_img_g)
			{
				$counter = 1;
				$divopenned = false;
				$is_displayed = '';
				while($result_img_g = mysql_fetch_array($query_img_g))
				{
					if($counter !=1){
						$is_displayed = 'nodisplay';
					}
					if($counter % 9 == 1){
						$divopenned = true;
						echo '<div class="photoBlock '.$is_displayed.'">';
					}
					
					//Image rank in the current gallery - galleries_append_toolbox_showrank.php uses this variable
					$gid = $edit_id;
					$fid = $result_img_g['F_ID'];
					$gf_rank = $result_img_g['GF_RANK']; 
					//-//
					
					echo '
					<div class="photocell_gallery">
						<div class="photocell_toolbox">
							<img class="gallery_toolbox_img" src="images/electro_image_labels.png" onclick="popupGalleryCaptions(\''.$fid.'\')" title="Λεζάντες" />
							<img class="gallery_toolbox_img rank" src="images/electro_image_ranks.png" title="Κατάταξη" />
							<a href="scripts/galleries_append_toolbox_remove.php?gid='.$gid.'&fid='.$fid.'"><img class="gallery_toolbox_img" src="images/electro_delete.png" title="Αφαίρεση" /></a>
						</div>
						<div class="gf_rank">';
							include("scripts/galleries_append_toolbox_showrank.php");
						echo '</div>
						<div class="photocell_img_frame">
							<a href="'.$local_image_path.$result_img_g['F_FILENAME'].'" rel="shadowbox">
								<img class="photocell_img_gallery" src="'.$local_image_path.'thumbs/thumb_'.$result_img_g['F_FILENAME'].'" />
							</a>
						</div>
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
	<div id="nav_right"><?php echo $right_arrow_g; ?></div>
	<div class="clear"></div>
</div>