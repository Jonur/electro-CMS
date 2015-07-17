<?php require("session_isset.php"); ?>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_mg','scripts/rm_mg.php?action=prune&ctsn=entity_tabs&ctin=1');">Διαγραφή</button>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_mg','scripts/rm_mg.php?action=restore&ctsn=entity_tabs&ctin=1');">Ανάκτηση</button>
<form id="rm_mg" name="rm_mg" action="" method="post">
<?php
	//Restore Manager - Menu Groups listing
	require("db_connect.php");
	$sql_mg = "SELECT * FROM `menu_groups` INNER JOIN `menu_groups-languages` ON `menu_groups`.MG_ID = `menu_groups-languages`.MG_ID 
			   WHERE `menu_groups-languages`.L_ID = '$DLTL' 
			   AND `menu_groups`.MG_DELETED = 1
			   ORDER BY `menu_groups`.MG_RANK";
	$query_mg = mysql_query($sql_mg);
	$rows_mg = @mysql_num_rows($query_mg);
	if ($rows_mg){
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
		while($result_mg = mysql_fetch_array($query_mg)){
			$checkbox='<input type="checkbox" name="item[]" value="'.$result_mg['MG_ID'].'" />';
			echo '<li class = "single-line restore-manager" title = "Επιλογή">
					'.$checkbox.'<a href = "javascript:;">'.stripslashes($result_mg['MGL_ALIAS']).'</a>
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>
</form>