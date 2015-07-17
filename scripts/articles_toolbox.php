<?php 
	//Get toolbar values
	$TOOLBOX_FILE = 'articles';
	
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
			$mysql_order_by = 'A_TITLE ASC, A_DATEADDED DESC';
			break;
		case 'title-desc':
			$mysql_order_by = 'A_TITLE DESC, A_DATEADDED DESC';
			break;
		case 'date-asc':
			$mysql_order_by = 'A_DATEADDED ASC';
			break;
		case 'date-desc':
			$mysql_order_by = 'A_DATEADDED DESC';
			break;
		case 'rank-asc':
			$mysql_order_by = 'MIL_ALIAS ASC, A_RANK ASC';
			break;
		case 'rank-desc':
			$mysql_order_by = 'MIL_ALIAS ASC, A_RANK DESC';
			break;
		case 'visible-asc':
			$mysql_order_by = 'A_VISIBLE ASC, A_DATEADDED DESC';
			break;
		case 'visible-desc':
			$mysql_order_by = 'A_VISIBLE DESC, A_DATEADDED DESC';
			break;
		case 'direct-asc':
			$mysql_order_by = 'A_DIRECT ASC, A_DATEADDED DESC';
			break;
		case 'direct-desc':
			$mysql_order_by = 'A_DIRECT DESC, A_DATEADDED DESC';
			break;
		default:
			$mysql_order_by = 'A_DATEADDED DESC';
	}
?>
<div id = "toolbar">
	<select id = "lang" title = "Επιλογή γλώσσας αποτελεσμάτων" onchange = "javascript:refreshListA('<?php echo $TOOLBOX_FILE; ?>', this.value, '<?php echo $TOOLBAR_ORDER_BY; ?>');">
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
	
	<select id = "order-by" title = "Ταξινόμηση αποτελεσμάτων" onchange = "javascript:refreshListA('<?php echo $TOOLBOX_FILE; ?>', '<?php echo $TOOLBAR_LANG; ?>', this.value);">
		<option value = "title-asc" <?php if ($TOOLBAR_ORDER_BY == 'title-asc') echo 'SELECTED'; ?>>Τίτλος (αύξουσα)</option>
		<option value = "title-desc" <?php if ($TOOLBAR_ORDER_BY == 'title-desc') echo 'SELECTED'; ?>>Τίτλος (φθίνουσα)</option>
		<option value = "date-asc" <?php if ($TOOLBAR_ORDER_BY == 'date-asc') echo 'SELECTED'; ?>>Ημερομηνία (αύξουσα)</option>
		<option value = "date-desc" <?php if ($TOOLBAR_ORDER_BY == 'date-desc') echo 'SELECTED'; ?>>Ημερομηνία (φθίνουσα)</option>
		<option value = "rank-asc" <?php if ($TOOLBAR_ORDER_BY == 'rank-asc') echo 'SELECTED'; ?>>Κατάταξη (αύξουσα)</option>
		<option value = "rank-desc" <?php if ($TOOLBAR_ORDER_BY == 'rank-desc') echo 'SELECTED'; ?>>Κατάταξη (φθίνουσα)</option>
		<option value = "visible-asc" <?php if ($TOOLBAR_ORDER_BY == 'visible-asc') echo 'SELECTED'; ?>>Ορατό (αύξουσα)</option>
		<option value = "visible-desc" <?php if ($TOOLBAR_ORDER_BY == 'visible-desc') echo 'SELECTED'; ?>>Ορατό (φθίνουσα)</option>
		<option value = "direct-asc" <?php if ($TOOLBAR_ORDER_BY == 'direct-asc') echo 'SELECTED'; ?>>'Αμεσο (αύξουσα)</option>
		<option value = "direct-desc" <?php if ($TOOLBAR_ORDER_BY == 'direct-desc') echo 'SELECTED'; ?>>'Αμεσο (φθίνουσα)</option>
	</select>
	
	<div class = "clear"></div>
</div>
<div class="clear"></div>