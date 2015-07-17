<?php require("session_isset.php"); ?>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_f','scripts/rm_f.php?action=prune&ctsn=entity_tabs&ctin=5');">Διαγραφή</button>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_f','scripts/rm_f.php?action=restore&ctsn=entity_tabs&ctin=5');">Ανάκτηση</button>
<form id="rm_f" name="rm_f" action="" method="post">
<?php
	//Restore Manager - Files listing
	require("db_connect.php");
	$sql_f = "  SELECT * FROM `files` 
				WHERE `files`.F_DELETED = 1
				ORDER BY F_FILETYPE, F_RANK";
	$query_f = mysql_query($sql_f) or die(mysql_error());
	$rows_f = mysql_num_rows($query_f);
	if ($rows_f){
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
		while($result_f = mysql_fetch_array($query_f)){
			$checkbox='<input type="checkbox" name="item[]" value="'.$result_f['F_ID'].'" />';
			echo '<li class = "single-line restore-manager" title = "Επιλογή">
					'.$checkbox.'<a href = "javascript:;">'.stripslashes($result_f['F_NAME']).'</a>
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>
</form>