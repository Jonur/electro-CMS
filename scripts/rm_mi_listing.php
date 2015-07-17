<?php require("session_isset.php"); ?>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_mi','scripts/rm_mi.php?action=prune&ctsn=entity_tabs&ctin=2');">Διαγραφή</button>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_mi','scripts/rm_mi.php?action=restore&ctsn=entity_tabs&ctin=2');">Ανάκτηση</button>
<form id="rm_mi" name="rm_mi" action="" method="post">
<?php
	//Restore Manager - Menu Groups listing
	require("db_connect.php");
	$sql_mi = "SELECT * FROM `menu_items` 
			   INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID = `menu_items-languages`.MI_ID 
			   INNER JOIN `menu_groups-menu_items` ON `menu_items`.MI_ID = `menu_groups-menu_items`.MI_ID 
			   INNER JOIN `menu_groups-languages` ON `menu_groups-languages`.MG_ID = `menu_groups-menu_items`.MG_ID 
			   WHERE `menu_items-languages`.L_ID = '$DLTL'  
			   AND `menu_groups-languages`.L_ID = '$DLTL'   
			   AND `menu_items`.MI_DELETED = 1
			   ORDER BY `menu_groups-languages`.MGL_ALIAS, `menu_items`.MI_RANK";
	$query_mi = mysql_query($sql_mi) or die(mysql_error());
	$rows_mi = mysql_num_rows($query_mi);
	if ($rows_mi){
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
		while($result_mi = mysql_fetch_array($query_mi)){	
			$checkbox='<input type="checkbox" name="item[]" value="'.$result_mi['MI_ID'].'" />';
			echo '<li class = "single-line restore-manager" title = "Επιλογή">
					'.$checkbox.'<a href = "javascript:;">'.stripslashes($result_mi['MIL_ALIAS']).'</a>
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>
</form>