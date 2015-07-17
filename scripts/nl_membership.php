<?php require("access_isset.php"); ?>
<div class="breadcrumb">Newsletter &raquo; Αρχείο Μελών</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=nl_membership_create'">Προσθήκη</button>
<?php
	echo $validation_message;
	require_once("nl_membership_toolbox.php");
	
	//Newsletter members listing
	require("db_connect.php");
	$sql_nl = "SELECT *, CONCAT(NM_SURNAME,SPACE(1),NM_NAME) AS NAME FROM `newsletter_members` ORDER BY NAME, NM_EMAIL";
	$query_nl = mysql_query($sql_nl) or die(mysql_error());
	$rows_nl = mysql_num_rows($query_nl);
	if ($rows_nl){
		echo '<ul id = "record-listing">';
		while($result_nl = mysql_fetch_array($query_nl)){
			//START:Create the links
			$edit_link = '?action=nl_membership_edit&id='.$result_nl['NM_ID'];
			$delete_link = '<a href="scripts/nl_membership_delete.php?id='.$result_nl['NM_ID'].'" onclick="return checkfields(this);" class = "delete" title="Διαγραφή"></a>';
			//END:Create the links
			
			$contact_display = '';
			if (strlen($result_nl['NAME']) > 2){
				$contact_display = stripslashes($result_nl['NAME']);
			}else{
				$contact_display = stripslashes($result_nl['NM_EMAIL']);
			}
			echo '<li class = "single-line">
					<a href = "'.$edit_link.'" title = "Επεξεργασία">'.$contact_display.'</a>
					'.$delete_link.'
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>