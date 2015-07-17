<?php 
	//Get toolbar values
	$TOOLBOX_FILE = 'menu_groups';
	
	$TOOLBAR_LANG = $DLTL;
	$TOOLBAR_ORDER_BY = 'rank-asc';
	
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
	
	//Set mysql query options
	switch ($TOOLBAR_ORDER_BY){
		case 'title-asc':
			$mysql_order_by = 'MGL_ALIAS ASC';
			break;
		case 'title-desc':
			$mysql_order_by = 'MGL_ALIAS DESC';
			break;
		case 'rank-asc':
			$mysql_order_by = 'MG_RANK ASC';
			break;
		case 'rank-desc':
			$mysql_order_by = 'MG_RANK DESC';
			break;
		case 'visible-asc':
			$mysql_order_by = 'MG_VISIBLE ASC';
			break;
		case 'visible-desc':
			$mysql_order_by = 'MG_VISIBLE DESC';
			break;
		default:
			$mysql_order_by = 'MGL_ALIAS ASC';
	}
?>
<div id = "toolbar">
	<select id = "lang" title = "Επιλογή γλώσσας αποτελεσμάτων" onchange = "javascript:refreshListMG('<?php echo $TOOLBOX_FILE; ?>', this.value, '<?php echo $TOOLBAR_ORDER_BY; ?>');">
		<?php
			require_once("db_connect.php"); 
			$sql_l = "SELECT * FROM `languages` WHERE L_VISIBLE = 1 ORDER BY L_RANK";
			$query_l = mysql_query($sql_l) or die(mysql_error());
			while($result_l = mysql_fetch_array($query_l)){
				$lang_selected = '';
				if ($TOOLBAR_LANG == $result_l['L_ID']){
					$lang_selected = 'SELECTED';
				}
				echo '<option value = "'.$result_l['L_ID'].'" '.$lang_selected.'>'.stripslashes($result_l['L_NAME']).'</option>';
			}
			require_once("db_disconnect.php");
		?>
	</select>
	
	<select id = "order-by" title = "Ταξινόμηση αποτελεσμάτων" onchange = "javascript:refreshListMG('<?php echo $TOOLBOX_FILE; ?>', '<?php echo $TOOLBAR_LANG; ?>', this.value);">
		<option value = "title-asc" <?php if ($TOOLBAR_ORDER_BY == 'title-asc') echo 'SELECTED'; ?>>Τίτλος (αύξουσα)</option>
		<option value = "title-desc" <?php if ($TOOLBAR_ORDER_BY == 'title-desc') echo 'SELECTED'; ?>>Τίτλος (φθίνουσα)</option>
		<option value = "rank-asc" <?php if ($TOOLBAR_ORDER_BY == 'rank-asc') echo 'SELECTED'; ?>>Κατάταξη (αύξουσα)</option>
		<option value = "rank-desc" <?php if ($TOOLBAR_ORDER_BY == 'rank-desc') echo 'SELECTED'; ?>>Κατάταξη (φθίνουσα)</option>
		<option value = "visible-asc" <?php if ($TOOLBAR_ORDER_BY == 'visible-asc') echo 'SELECTED'; ?>>Ορατή (αύξουσα)</option>
		<option value = "visible-desc" <?php if ($TOOLBAR_ORDER_BY == 'visible-desc') echo 'SELECTED'; ?>>Ορατή (φθίνουσα)</option>
	</select>
	
	<div class = "clear"></div>
</div>
<div class="clear"></div>