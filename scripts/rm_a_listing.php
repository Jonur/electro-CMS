<?php require("session_isset.php"); ?>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_a','scripts/rm_a.php?action=prune&ctsn=entity_tabs&ctin=3');">Διαγραφή</button>
<button type="button" class="create_button" onclick="javascript:edit_and_submit('rm_a','scripts/rm_a.php?action=restore&ctsn=entity_tabs&ctin=3');">Ανάκτηση</button>
<form id="rm_a" name="rm_a" action="" method="post">
<?php
	//Restore Manager - `articles` listing
	require("db_connect.php");
	$sql_a = " SELECT * FROM `articles`  
			   INNER JOIN `articles-languages` ON `articles`.A_ID = `articles-languages`.A_ID 
			   INNER JOIN `menu_items-languages` ON `articles`.MI_ID = `menu_items-languages`.MI_ID 
			   WHERE `articles-languages`.L_ID = '$DLTL' 
			   AND `articles`.A_DELETED = 1 
			   AND `menu_items-languages`.L_ID = '$DLTL' 
			   ORDER BY `articles`.A_TITLE, `articles`.A_RANK";
	$query_a = mysql_query($sql_a) or die(mysql_error());
	$rows_a = mysql_num_rows($query_a);
	if ($rows_a){
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
		while($result_a = mysql_fetch_array($query_a)){
			$checkbox='<input type="checkbox" name="item[]" value="'.$result_a['A_ID'].'" />';
			echo '<li class = "single-line restore-manager" title = "Επιλογή">
					'.$checkbox.'<a href = "javascript:;">'.stripslashes($result_a['A_TITLE']).'</a>
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>
</form>