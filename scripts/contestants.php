<div class="breadcrumb">Διαγωνισμοί &raquo; Συμμετέχοντες</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=contestants_create'">Δημιουργία</button>
<?php
	echo $validation_message;
	require_once("contestants_toolbox.php");
	
	//Newsletter members listing
	require("db_connect.php");
	$sql_c = "SELECT * FROM `contestants`  
			  INNER JOIN `polls-contestants` ON `contestants`.C_ID = `polls-contestants`.C_ID 
			  INNER JOIN `polls` ON `polls-contestants`.P_ID = `polls`.P_ID 
			  ORDER BY $mysql_order_by ";
	$query_c = mysql_query($sql_c) or die(mysql_error());
	$rows_c = mysql_num_rows($query_c);
	if ($rows_c){
		echo '<ul id = "record-listing">';
		while($result_c = mysql_fetch_array($query_c)){
			//START:Create the links
			$edit_link = '?action=contestants_edit&id='.$result_c['C_ID'].$TOOLBOX_SELECTED_OPTIONS;
			$delete_link = '<a href="scripts/contestants_delete.php?id='.$result_c['C_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete" title="Διαγραφή"></a>';
			//END:Create the links
			
			echo '<li>
					<a href = "'.$edit_link.'" title = "Επεξεργασία">'.stripslashes($result_c['C_NAME']).'</a>
					<span class = "details">Διαγωνισμός: '.$result_c['P_TITLE'].'</span>
					'.$delete_link.'
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>