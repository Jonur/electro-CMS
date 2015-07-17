<?php 
	//Get toolbar values
	$TOOLBOX_FILE = 'languages';
	
	$TOOLBAR_ORDER_BY = 'rank-asc';
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['tob'])){
		$TOOLBAR_ORDER_BY = $_REQUEST['tob'];
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	//Set mysql query options
	switch ($TOOLBAR_ORDER_BY){
		case 'title-asc':
			$mysql_order_by = 'L_NAME ASC';
			break;
		case 'title-desc':
			$mysql_order_by = 'L_NAME DESC';
			break;
		case 'rank-asc':
			$mysql_order_by = 'L_RANK ASC, L_NAME ASC';
			break;
		case 'rank-desc':
			$mysql_order_by = 'L_RANK DESC, L_NAME ASC';
			break;
		default:
			$mysql_order_by = 'L_RANK ASC, L_NAME ASC';
	}
?>
<div id = "toolbar">
	<select id = "order-by" title = "Ταξινόμηση αποτελεσμάτων" onchange = "javascript:refreshListL('<?php echo $TOOLBOX_FILE; ?>', this.value);">
		<option value = "title-asc" <?php if ($TOOLBAR_ORDER_BY == 'title-asc') echo 'SELECTED'; ?>>Τίτλος (αύξουσα)</option>
		<option value = "title-desc" <?php if ($TOOLBAR_ORDER_BY == 'title-desc') echo 'SELECTED'; ?>>Τίτλος (φθίνουσα)</option>
		<option value = "rank-asc" <?php if ($TOOLBAR_ORDER_BY == 'rank-asc') echo 'SELECTED'; ?>>Κατάταξη (αύξουσα)</option>
		<option value = "rank-desc" <?php if ($TOOLBAR_ORDER_BY == 'rank-desc') echo 'SELECTED'; ?>>Κατάταξη (φθίνουσα)</option>
	</select>
	
	<div class = "clear"></div>
</div>
<div class="clear"></div>