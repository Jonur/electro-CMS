<?php require("access_isset.php"); ?>
<div class="breadcrumb">Διαχείριση electro &raquo; Αρχείο συμβάντων</div>
<button type="button" class="create_button" onclick="javascript:return clear_log_confirm(this);">Εκκαθάριση</button>
<?php
	echo $validation_message;	
	//Newsletter members listing
	require("db_connect.php");
	$sql_el = "SELECT * FROM `electro_log` 
			   INNER JOIN `electro_users` ON `electro_log`.EU_ID = `electro_users`.EU_ID 
			   ORDER BY ELOG_DATE DESC";
	$query_el = mysql_query($sql_el) or die(mysql_error());
	$rows_el = mysql_num_rows($query_el);
	if ($rows_el){
		echo '<ul id = "record-listing">';
		while($result_el = mysql_fetch_array($query_el)){
			$event_date = date('d F Y, H:i', strtotime($result_el['ELOG_DATE']));
			echo '<li>
					<a href = "javascript:;">'.$event_date.' - Από: '.stripslashes($result_el['EU_USERNAME']).'</a>
					<span class = "details">'.stripslashes($result_el['ELOG_ACTION']).'</span>
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>