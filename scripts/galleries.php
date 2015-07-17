<?php require("access_isset.php"); ?>
<div class="breadcrumb">Δημιουργία Περιεχομένου &raquo; Γκαλερί</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=galleries_create'">Δημιουργία</button>
<?php
	echo $validation_message;
	require_once("galleries_toolbox.php");
	
	//Galleries listing
	require("db_connect.php");
	include("functions.php");
	$sql_g = "SELECT * FROM `galleries` INNER JOIN `galleries-languages` ON `galleries`.G_ID = `galleries-languages`.G_ID 
			   WHERE `galleries-languages`.L_ID = '$TOOLBAR_LANG' 
			   AND `galleries`.G_DELETED = 0 
			   ORDER BY $mysql_order_by ";
	$query_g = mysql_query($sql_g);
	$rows_g = @mysql_num_rows($query_g);
	if ($rows_g){
		echo '<ul id = "record-listing">';
		while($result_g = mysql_fetch_array($query_g)){
			//START:Create the links
			$edit_link = '?action=galleries_edit&id='.$result_g['G_ID'].$TOOLBOX_SELECTED_OPTIONS;
			$append_link = '<a href = "?action=galleries_append&id='.$result_g['G_ID'].$TOOLBOX_SELECTED_OPTIONS.'" class = "append" title = "Προσθαφαίρεση Εικόνων"></a>';
			$delete_link = '<a href="scripts/galleries_delete.php?id='.$result_g['G_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete" title="Διαγραφή"></a>';
			//END:Create the links
			
			//START:Echo visibility
			$visibility_caption = "Όχι";
			if ($result_g['G_VISIBLE']) 
				$visibility_caption = "Ναι";
			//END:Echo visibility
			
			echo '<li>
					<a href = "'.$edit_link.'" title = "Επεξεργασία">'.stripslashes($result_g['GL_ALIAS']).'</a>
					<span class = "details">Κατάταξη: '.$result_g['G_RANK'].', Ορατό: '.$visibility_caption.'</span>
					'.$append_link.$delete_link.'
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>