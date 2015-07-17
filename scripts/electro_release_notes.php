<?php require("access_isset.php"); ?>
<div class="breadcrumb">Διαχείριση electro &raquo; Πληροφορίες έκδοσης</div>
<?php
	//Newsletter members listing
	require("db_connect.php");
	$sql_el = "SELECT * FROM `electro_release_notes` ORDER BY RN_DATE DESC";
	$query_el = mysql_query($sql_el) or die(mysql_error());
	$rows_el = mysql_num_rows($query_el);
	if ($rows_el){
		echo '<ul id = "record-listing">';
		while($result_el = mysql_fetch_array($query_el)){
			$release_date = date('d F Y', strtotime($result_el['RN_DATE']));
			echo '<li>
					<a href = "javascript:;">'.stripslashes($result_el['RN_VERSION']).' - '.$release_date.'</a>
					<span class = "details">'.stripslashes($result_el['RN_INFO']).'</span>
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>