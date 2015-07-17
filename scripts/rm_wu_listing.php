<?php require("session_isset.php"); ?>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_wu','scripts/rm_wu.php?action=prune&ctsn=entity_tabs&ctin=6');">Διαγραφή</button>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_wu','scripts/rm_wu.php?action=restore&ctsn=entity_tabs&ctin=6');">Ανάκτηση</button>
<form id="rm_wu" name="rm_wu" action="" method="post">
<?php
	//Restore Manager - Website Users listing
	require("db_connect.php");
	$sql_wu = " SELECT * FROM `website_users` 
				WHERE WU_DELETED = 1
				ORDER BY WU_USERNAME";
	$query_wu = mysql_query($sql_wu) or die(mysql_error());
	$rows_wu = mysql_num_rows($query_wu);
	if ($rows_wu){
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
		while($result_wu = mysql_fetch_array($query_wu)){
			$checkbox='<input type="checkbox" name="item[]" value="'.$result_wu['WU_ID'].'" />';
			echo '<li class = "single-line restore-manager" title = "Επιλογή">
					'.$checkbox.'<a href = "javascript:;">'.stripslashes($result_wu['WU_USERNAME']).'</a>
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>
</form>