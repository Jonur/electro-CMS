<?php require("access_isset.php"); ?>
<div class="breadcrumb">Δημιουργία Μενού &raquo; Στοιχεία Μενού</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=menu_items_create'">Δημιουργία</button>
<?php  ?>
<?php
	echo $validation_message;
	require_once("menu_items_toolbox.php");
	
	//Menu Groups listing
	require("db_connect.php");
	include("functions.php");
	$sql_mi = "SELECT * FROM `menu_items` 
			   INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID 
			   INNER JOIN `menu_groups-menu_items` ON `menu_items`.MI_ID=`menu_groups-menu_items`.MI_ID 
			   INNER JOIN `menu_groups-languages` ON `menu_groups-languages`.MG_ID=`menu_groups-menu_items`.MG_ID 
			   WHERE `menu_items-languages`.L_ID = '$TOOLBAR_LANG' 
			   AND `menu_groups-languages`.L_ID =  '$TOOLBAR_LANG' 
			   AND `menu_items`.MI_DELETED = 0 
			   AND `menu_groups-menu_items`.MG_ID = '$TOOLBAR_MG' 
			   AND (`menu_items`.MI_MOTHER = '0' OR `menu_items`.MI_MOTHER IS NULL) 
			   ORDER BY `menu_groups-languages`.MGL_ALIAS, $mysql_order_by ";
			   
	$query_mi = mysql_query($sql_mi) or die(mysql_error());
	$rows_mi = mysql_num_rows($query_mi);
	if ($rows_mi){
		//mother 
		$mother = "";
		echo '<ul id = "record-listing">';
		while($result_mi = mysql_fetch_array($query_mi)){	
			//START:Create the links
			$edit_link = '?action=menu_items_edit&id='.$result_mi['MI_ID'].$TOOLBOX_SELECTED_OPTIONS;
			$delete_link = '<a href="scripts/menu_items_delete.php?id='.$result_mi['MI_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete" title = "Διαγραφή"></a>';
			$isDefault = '<a href = "scripts/menu_items_default.php?id='.$result_mi['MI_ID'].$TOOLBOX_SELECTED_OPTIONS.'" class = "star" title = "Αλλαγή σε προεπιλεγμένο"><img src = "images/isDefaultGrey.png" /></a>';
			if ($result_mi['MI_DEFAULT']){
				$isDefault = '<a href = "javascript:;" class = "star no-link"><img src = "images/isDefaultGold.png" title = "Προεπιλεγμένο" /></a>';
			}
			//END:Create the links
			
			//START:Echo visibility
			$visibility_caption = "Όχι";
			if ($result_mi['MI_VISIBLE']) 
				$visibility_caption = "Ναι";
			//END:Echo visibility
			
			echo '<li class = "hasDefault">
					'.$isDefault.'
					<a href = "'.$edit_link.'" title = "Επεξεργασία">'.stripslashes($result_mi['MIL_ALIAS']).'</a>
					<span class = "details">Ομάδα Μενού: '.stripslashes($result_mi['MGL_ALIAS']).', Κατάταξη: '.$result_mi['MI_RANK'].', Ορατό: '.$visibility_caption.'</span>
					'.$delete_link.'
				  </li>';
			
			//START:Define mothers name/title
			$mi_mother = $result_mi['MIL_ALIAS'].' &raquo; ';
			//END:Define mothers name/title
			
			print_menu_row($result_mi['MI_ID'], $mi_mother, $TOOLBAR_LANG);
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>