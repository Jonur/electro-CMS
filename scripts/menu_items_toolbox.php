<?php 
	//Get toolbar values
	$TOOLBOX_FILE = 'menu_items';
	
	$TOOLBAR_LANG = $DLTL;
	$TOOLBAR_ORDER_BY = 'rank-asc';
	$TOOLBAR_MG = '';
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	
	if (!empty($_REQUEST['tl'])){
		$TOOLBAR_LANG = $_REQUEST['tl'];
		$TOOLBOX_SELECTED_OPTIONS .= '&tl='.$_REQUEST['tl'];
	}
	if (!empty($_REQUEST['tob'])){
		$TOOLBAR_ORDER_BY = $_REQUEST['tob'];
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	if (!empty($_REQUEST['tmg'])){
		$TOOLBAR_MG = $_REQUEST['tmg'];
		$TOOLBOX_SELECTED_OPTIONS .= '&tmg='.$_REQUEST['tmg'];
	}else{
		//Get the first Menu Group
		require("db_connect.php"); 
		$sql_mg = "SELECT * FROM `menu_groups` INNER JOIN `menu_groups-languages` ON `menu_groups`.MG_ID=`menu_groups-languages`.MG_ID 
				   WHERE `menu_groups-languages`.L_ID = '$TOOLBAR_LANG' 
				   AND `menu_groups`.MG_DELETED = 0 
				   ORDER BY MG_RANK LIMIT 1";
		$query_mg = mysql_query($sql_mg);
		if($result_mg = mysql_fetch_array($query_mg)){
			$TOOLBAR_MG = $result_mg['MG_ID'];
		}
		require("db_disconnect.php");
		$TOOLBOX_SELECTED_OPTIONS .= '&tmg='.$TOOLBAR_MG;
	}
	
	//Set mysql query options
	switch ($TOOLBAR_ORDER_BY){
		case 'title-asc':
			$mysql_order_by = 'MIL_ALIAS ASC';
			break;
		case 'title-desc':
			$mysql_order_by = 'MIL_ALIAS DESC';
			break;
		case 'rank-asc':
			$mysql_order_by = 'MI_RANK ASC';
			break;
		case 'rank-desc':
			$mysql_order_by = 'MI_RANK DESC';
			break;
		case 'visible-asc':
			$mysql_order_by = 'MI_VISIBLE ASC';
			break;
		case 'visible-desc':
			$mysql_order_by = 'MI_VISIBLE DESC';
			break;
		default:
			$mysql_order_by = 'MIL_ALIAS ASC';
	}
?>
<div id = "toolbar">
	<select id = "lang" title = "Επιλογή γλώσσας αποτελεσμάτων" onchange = "javascript:refreshListMI('<?php echo $TOOLBOX_FILE; ?>', this.value, '<?php echo $TOOLBAR_ORDER_BY; ?>', '<?php echo $TOOLBAR_MG; ?>');">
		<?php
			require("db_connect.php"); 
			$sql_l = "SELECT * FROM `languages` WHERE L_VISIBLE = 1 ORDER BY L_RANK";
			$query_l = mysql_query($sql_l) or die(mysql_error());
			while($result_l = mysql_fetch_array($query_l)){
				$lang_selected = '';
				if ($TOOLBAR_LANG == $result_l['L_ID']){
					$lang_selected = 'SELECTED';
				}
				echo '<option value = "'.$result_l['L_ID'].'" '.$lang_selected.'>'.stripslashes($result_l['L_NAME']).'</option>';
			}
			require("db_disconnect.php");
		?>
	</select>
	
	<select id = "order-by" title = "Ταξινόμηση αποτελεσμάτων" onchange = "javascript:refreshListMI('<?php echo $TOOLBOX_FILE; ?>', '<?php echo $TOOLBAR_LANG; ?>', this.value, '<?php echo $TOOLBAR_MG; ?>');">
		<option value = "title-asc" <?php if ($TOOLBAR_ORDER_BY == 'title-asc') echo 'SELECTED'; ?>>Τίτλος (αύξουσα)</option>
		<option value = "title-desc" <?php if ($TOOLBAR_ORDER_BY == 'title-desc') echo 'SELECTED'; ?>>Τίτλος (φθίνουσα)</option>
		<option value = "rank-asc" <?php if ($TOOLBAR_ORDER_BY == 'rank-asc') echo 'SELECTED'; ?>>Κατάταξη (αύξουσα)</option>
		<option value = "rank-desc" <?php if ($TOOLBAR_ORDER_BY == 'rank-desc') echo 'SELECTED'; ?>>Κατάταξη (φθίνουσα)</option>
		<option value = "visible-asc" <?php if ($TOOLBAR_ORDER_BY == 'visible-asc') echo 'SELECTED'; ?>>Ορατό (αύξουσα)</option>
		<option value = "visible-desc" <?php if ($TOOLBAR_ORDER_BY == 'visible-desc') echo 'SELECTED'; ?>>Ορατό (φθίνουσα)</option>
	</select>
	
	<select id = "list-by-mg" title = "Όμάδα Μενού αποτελεσμάτων" onchange = "javascript:refreshListMI('<?php echo $TOOLBOX_FILE; ?>', '<?php echo $TOOLBAR_LANG; ?>', '<?php echo $TOOLBAR_ORDER_BY; ?>', this.value);">
		<?php
			require("db_connect.php"); 
			$sql_mg = "SELECT * FROM `menu_groups` INNER JOIN `menu_groups-languages` ON `menu_groups`.MG_ID=`menu_groups-languages`.MG_ID 
					   WHERE `menu_groups-languages`.L_ID = '$TOOLBAR_LANG' 
					   AND `menu_groups`.MG_DELETED = 0 
					   ORDER BY MG_RANK";
			$query_mg = mysql_query($sql_mg);
			while($result_mg = mysql_fetch_array($query_mg)){
				$mg_selected = '';
				if ($TOOLBAR_MG == $result_mg['MG_ID']){
					$mg_selected = 'SELECTED';
				}
				echo '<option value = "'.$result_mg['MG_ID'].'" '.$mg_selected.'>'.stripslashes($result_mg['MGL_ALIAS']).'</option>';
			}
			require("db_disconnect.php");
		?>
	</select>
	
	<div class = "clear"></div>
</div>
<div class="clear"></div>