<?php 
	//Get toolbar values
	$TOOLBOX_FILE = 'electro_users';
	
	$TOOLBAR_ORDER_BY = 'un-asc';
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['tob'])){
		$TOOLBAR_ORDER_BY = $_REQUEST['tob'];
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	//Set mysql query options
	switch ($TOOLBAR_ORDER_BY){
		case 'un-asc':
			$mysql_order_by = 'EU_USERNAME ASC';
			break;
		case 'un-desc':
			$mysql_order_by = 'EU_USERNAME DESC';
			break;
		case 'level-asc':
			$mysql_order_by = 'EU_LEVEL ASC, EU_USERNAME ASC';
			break;
		case 'level-desc':
			$mysql_order_by = 'EU_LEVEL DESC, EU_USERNAME ASC';
			break;
		default:
			$mysql_order_by = 'EU_USERNAME ASC';
	}
?>
<div id = "toolbar">
	<select id = "order-by" title = "Ταξινόμηση αποτελεσμάτων" onchange = "javascript:refreshListEU('<?php echo $TOOLBOX_FILE; ?>', this.value);">
		<option value = "un-asc" <?php if ($TOOLBAR_ORDER_BY == 'un-asc') echo 'SELECTED'; ?>>Username (αύξουσα)</option>
		<option value = "un-desc" <?php if ($TOOLBAR_ORDER_BY == 'un-desc') echo 'SELECTED'; ?>>Username (φθίνουσα)</option>
		<option value = "level-asc" <?php if ($TOOLBAR_ORDER_BY == 'level-asc') echo 'SELECTED'; ?>>Επίπεδο (αύξουσα)</option>
		<option value = "level-desc" <?php if ($TOOLBAR_ORDER_BY == 'level-desc') echo 'SELECTED'; ?>>Επίπεδο (φθίνουσα)</option>
	</select>
	
	<div class = "clear"></div>
</div>
<div class="clear"></div>