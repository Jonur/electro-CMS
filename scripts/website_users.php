<?php require("access_isset.php"); ?>
<div class="breadcrumb">Διαχείριση website &raquo; Χρήστες Ιστότοπου</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=website_users_create'">Προσθήκη</button>
<?php
	echo $validation_message;
	require_once("website_users_toolbox.php");
	
	//Newsletter members listing
	require("db_connect.php");
	$sql_wu = "SELECT * FROM `website_users` WHERE WU_DELETED = 0 ORDER BY $mysql_order_by ";
	$query_wu = mysql_query($sql_wu) or die(mysql_error());
	$rows_wu = mysql_num_rows($query_wu);
	if ($rows_wu){
		echo '<ul id = "record-listing">';
		while($result_wu = mysql_fetch_array($query_wu)){
			//START:Create the links
			$edit_link = '?action=website_users_edit&id='.$result_wu['WU_ID'].$TOOLBOX_SELECTED_OPTIONS;
			$delete_link = '<a href="scripts/website_users_delete.php?id='.$result_wu['WU_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete" title="Διαγραφή"></a>';
			//END:Create the links
			
			echo '<li>
					<a href = "'.$edit_link.'" title = "Επεξεργασία">'.stripslashes($result_wu['WU_USERNAME']).'</a>
					<span class = "details">e-mail: '.stripslashes($result_wu['WU_EMAIL']).'</span>
					'.$delete_link.'
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>