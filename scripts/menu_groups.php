<?php require("access_isset.php"); ?>
<div class="breadcrumb">Δημιουργία Μενού &raquo; Ομάδες Μενού</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=menu_groups_create'">Δημιουργία</button>
<?php
	echo $validation_message;
	require_once("menu_groups_toolbox.php");
	
	//Menu Groups listing
	require("db_connect.php");
	$sql_mg = "SELECT * FROM `menu_groups` INNER JOIN `menu_groups-languages` ON `menu_groups`.MG_ID=`menu_groups-languages`.MG_ID 
			   WHERE `menu_groups-languages`.L_ID = '$TOOLBAR_LANG' 
			   AND `menu_groups`.MG_DELETED = 0 
			   ORDER BY $mysql_order_by "; 
	$query_mg = mysql_query($sql_mg);
	$rows_mg = @mysql_num_rows($query_mg);
	if ($rows_mg){
		echo '<ul id = "record-listing">';
		while($result_mg = mysql_fetch_array($query_mg)){
			//START:Create the links
			$edit_link = '?action=menu_groups_edit&id='.$result_mg['MG_ID'].$TOOLBOX_SELECTED_OPTIONS;
			$delete_link = '<a href="scripts/menu_groups_delete.php?id='.$result_mg['MG_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete" title="Διαγραφή"></a>';
			//END:Create the links
			
			//START:Echo visibility
			$visibility_caption = "Όχι";
			if ($result_mg['MG_VISIBLE']){
				$visibility_caption = "Ναι";
			}
			//END:Echo visibility
			
			echo '<li>
					<a href = "'.$edit_link.'" title = "Επεξεργασία">'.stripslashes($result_mg['MGL_ALIAS']).'</a>
					<span class = "details">Κατάταξη: '.$result_mg['MG_RANK'].', Ορατό: '.$visibility_caption.'</span>
					'.$delete_link.'
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>