<?php require("access_isset.php"); ?>
<div class="breadcrumb">Δημιουργία Μενού &raquo; Δομή Μενού</div>
<?php
	require_once("menu_structure_toolbox.php");
	
   //Structure listing
	require("db_connect.php");
	include("functions.php");
	
	$sql_mg = "SELECT * FROM `menu_groups` 
			   INNER JOIN `menu_groups-languages` ON `menu_groups`.MG_ID=`menu_groups-languages`.MG_ID 
			   WHERE `menu_groups-languages`.L_ID = '$TOOLBAR_LANG' 
			   AND `menu_groups`.MG_DELETED = 0 
			   ORDER BY `menu_groups`.MG_RANK, `menu_groups-languages`.MGL_ALIAS";
	$query_mg = mysql_query($sql_mg) or die(mysql_error());
	$rows_mg = mysql_num_rows($query_mg);
	if ($rows_mg){
		while($result_mg = mysql_fetch_array($query_mg)){
			echo '<ul class = "list_mg">';
			
			echo '<li>'.stripslashes($result_mg['MGL_ALIAS']).'</li>';
			//START: MENU ITEMS
			$sql_mi_mother = "SELECT * FROM `menu_items` 
							INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID
							INNER JOIN `menu_groups-menu_items` ON `menu_items`.MI_ID=`menu_groups-menu_items`.MI_ID
							WHERE `menu_groups-menu_items`.MG_ID='".$result_mg['MG_ID']."' 
							AND `menu_items`.MI_DELETED=0 
							AND `menu_items-languages`.L_ID = '$TOOLBAR_LANG'  
							AND (`menu_items`.MI_MOTHER IS NULL OR `menu_items`.MI_MOTHER='0') 
							ORDER BY `menu_items`.MI_RANK, `menu_items-languages`.MIL_ALIAS";
			$query_mi_mother = mysql_query($sql_mi_mother) or die(mysql_error());
			$ident = ''; //dashes
			while ($result_mi_mother = mysql_fetch_array($query_mi_mother)){
				$link = '<a href="?action=menu_items_edit&id='.$result_mi_mother['MI_ID'].'&tl='.$TOOLBAR_LANG.'">'.stripslashes($result_mi_mother['MIL_ALIAS']).'</a>';
				echo '<li>'.$ident.$link.'</li>';
				print_structure($result_mi_mother['MI_ID'], $ident.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ');
			}
			//END: MENU ITEMS
			echo '</ul>';
		}
	}else{
		echo '<div class="validation_message_false">Δεν έχει δημιουργηθεί μενού για αυτή την γλώσσα.</div>';
	}
	require("db_disconnect.php");
?>