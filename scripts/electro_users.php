<?php require("access_isset.php"); ?>
<div class="breadcrumb">Διαχείριση electro &raquo; Χρήστες electro</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=electro_users_create'">Προσθήκη</button>
<?php
	echo $validation_message;
	require_once("electro_users_toolbox.php");
	
	//Newsletter members listing
	require("db_connect.php");
	$sql_eu = "SELECT * FROM `electro_users` ORDER BY $mysql_order_by ";
	$query_eu = mysql_query($sql_eu) or die(mysql_error());
	$rows_eu = mysql_num_rows($query_eu);
	if ($rows_eu){
		echo '<ul id = "record-listing">';
		while($result_eu = mysql_fetch_array($query_eu)){
			//START:Create the links
			$edit_link = '?action=electro_users_edit&id='.$result_eu['EU_ID'].$TOOLBOX_SELECTED_OPTIONS;
			$delete_link = '<a href="scripts/electro_users_delete.php?id='.$result_eu['EU_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete" title="Διαγραφή"></a>';
			if($result_eu['EU_LEVEL'] == '2'){
				$delete_link = '';
			}
			//END:Create the links
			
			//START: Create EU level string
			switch($result_eu['EU_LEVEL']){
				case '0':
					$eu_level = 'Χρήστης';
					break;
				case '1':
					$eu_level = 'Διαχειριστής';
					break;
				case '2':
					$eu_level = 'Κύριος Διαχειριστής';
					break;
				default:
					$eu_level = 'Χρήστης';
			}
			//END: Create EU level string
			
			echo '<li>
					<a href = "'.$edit_link.'" title = "Επεξεργασία">'.stripslashes($result_eu['EU_USERNAME']).'</a>
					<span class = "details">Επίπεδο: '.$eu_level.'</span>
					'.$delete_link.'
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>