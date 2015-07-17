<?php require("access_isset.php"); ?>
<div class="breadcrumb">Διαγωνισμοί &raquo; Διαγωνισμοί</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=polls_create'">Δημιουργία</button>
<?php
	echo $validation_message;
	require_once("polls_toolbox.php");
	
	//Newsletter members listing
	require("db_connect.php");
	$sql_p = "SELECT * FROM `polls` ORDER BY $mysql_order_by";
	$query_p = mysql_query($sql_p) or die(mysql_error());
	$rows_p = mysql_num_rows($query_p);
	if ($rows_p){
		echo '<ul id = "record-listing">';
		while($result_p = mysql_fetch_array($query_p)){
			//START:Create the links
			$edit_link = '?action=polls_edit&id='.$result_p['P_ID'].$TOOLBOX_SELECTED_OPTIONS;
			$delete_link = '<a href="scripts/polls_delete.php?id='.$result_p['P_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete" title="Διαγραφή"></a>';
			//END:Create the links

			$start_date = '- ';
			if ($result_p['P_STARTDATE'] !== '0000-00-00'){
				$start_date = date('d F Y', strtotime($result_p['P_STARTDATE']));
			}
			$end_date = '- ';
			if ($result_p['P_ENDDATE'] !== '0000-00-00'){
				$end_date = date('d F Y', strtotime($result_p['P_ENDDATE']));
			}
			echo '<li>
				<a href = "'.$edit_link.'" title = "Επεξεργασία">'.stripslashes($result_p['P_TITLE']).'</a>
				<span class = "details">Από: '.$start_date.', Μέχρι: '.$end_date.'</span>
				'.$delete_link.'
			  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>