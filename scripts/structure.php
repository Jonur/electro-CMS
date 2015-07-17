<?php
	require("session_isset.php");
	$view_mg = '0';
	if (!empty($_REQUEST['mg'])){
		$view_mg = $_REQUEST['mg'];
	}else{
		echo '<span class="">---Παρακαλώ επιλέξτε Ομάδα Μενού---</span>';
		return;
	}
	$mi_mother = '0';
	if (!empty($_REQUEST['mother'])){
		$mi_mother = $_REQUEST['mother'];
	}
	$current_mi = '0';
	if (!empty($_REQUEST['mi'])){
		$current_mi = $_REQUEST['mi'];
	}
?>
<select name="mi_mother" class="long">
	<option value="0" SELECTED>Κανένα</option>
	<optgroup label="Παρακαλώ επιλέξτε">
	<?php 
		//Listing the available menu items
		include("functions.php");
		require("db_connect.php");
		$sql_mi_mother = "SELECT * FROM `menu_items` 
							INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID
							INNER JOIN `menu_groups-menu_items` ON `menu_items`.MI_ID=`menu_groups-menu_items`.MI_ID
							WHERE `menu_groups-menu_items`.MG_ID = '$view_mg' 
							AND `menu_items`.MI_DELETED = 0 
							AND `menu_items-languages`.L_ID = '$DLTL' 
							AND (`menu_items`.MI_MOTHER IS NULL OR `menu_items`.MI_MOTHER = '0') 
							ORDER BY `menu_items`.MI_RANK, `menu_items-languages`.MIL_ALIAS";
		$query_mi_mother = mysql_query($sql_mi_mother) or die(mysql_error());
		$pcs = ''; //dashes
		while ($result_mi_mother = mysql_fetch_array($query_mi_mother))
		{
			$mi_selected = "";
			if($result_mi_mother['MI_ID']== $mi_mother){
				$mi_selected = "SELECTED";
			}
			$mi_disabled = "";
			if($current_mi == $result_mi_mother['MI_ID']){
				$mi_disabled = "DISABLED";
			}
			echo '<option value="'.$result_mi_mother['MI_ID'].'" '.$mi_selected.' '.$mi_disabled.'>'.stripslashes($result_mi_mother['MIL_ALIAS']).'</option>';
			print_children($result_mi_mother['MI_ID'],$pcs.' - - - ', $mi_mother, $mi_disabled, $current_mi);
		}
		require("db_disconnect.php");
	  ?>
	</optgroup>
</select>