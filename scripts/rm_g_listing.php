<?php require("session_isset.php"); ?>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_g','scripts/rm_g.php?action=prune&ctsn=entity_tabs&ctin=4');">Διαγραφή</button>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_g','scripts/rm_g.php?action=restore&ctsn=entity_tabs&ctin=4');">Ανάκτηση</button>
<form id="rm_g" name="rm_g" action="" method="post">
<?php
	//Restore Manager - Galleries listing
	require("db_connect.php");
	$sql_g = "SELECT * FROM `galleries` INNER JOIN `galleries-languages` ON `galleries`.G_ID = `galleries-languages`.G_ID 
			   WHERE `galleries-languages`.L_ID = '$DLTL' 
			   AND `galleries`.G_DELETED = 1
			   ORDER BY `galleries-languages`.L_ID, `galleries`.G_RANK";
	$query_g = mysql_query($sql_g) or die (mysql_error());
	$rows_g = mysql_num_rows($query_g);
	if ($rows_g){
		//START: Select All / Unselect All
		echo '<div class="clear"></div>';
		echo'
			<div class="select_unselect">
				<span class="select_all" onclick="javascript:select_unselect(true);">Επιλογή Όλων</span>
				&nbsp;&#124;&nbsp;
				<span class="unselect_all" onclick="javascript:select_unselect(false);">Επιλογή Κανενός</span>
			</div>
		';
		echo '<div class="clear"></div>';
		//END: Select All / Unselect All
		
		echo '<ul id = "record-listing">';
		while($result_g = mysql_fetch_array($query_g)){
			$checkbox='<input type="checkbox" name="item[]" value="'.$result_g['G_ID'].'" />';
			echo '<li class = "single-line restore-manager" title = "Επιλογή">
					'.$checkbox.'<a href = "javascript:;">'.stripslashes($result_g['GL_ALIAS']).'</a>
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>
</form>