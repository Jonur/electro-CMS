<?php 
	//Get toolbar values
	$TOOLBOX_FILE = 'contestants';
	
	$TOOLBAR_ORDER_BY = 'title-asc';
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['tob'])){
		$TOOLBAR_ORDER_BY = $_REQUEST['tob'];
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	//Set mysql query options
	switch ($TOOLBAR_ORDER_BY){
		case 'title-asc':
			$mysql_order_by = 'C_NAME ASC';
			break;
		case 'title-desc':
			$mysql_order_by = 'C_NAME DESC';
			break;
		case 'c-asc':
			$mysql_order_by = 'P_TITLE ASC';
			break;
		case 'c-desc':
			$mysql_order_by = 'P_TITLE DESC';
			break;
		default:
			$mysql_order_by = 'C_NAME ASC';
	}
?>
<div id = "toolbar">
	<select id = "order-by" title = "Ταξινόμηση αποτελεσμάτων" onchange = "javascript:refreshListC('<?php echo $TOOLBOX_FILE; ?>', this.value);">
		<option value = "title-asc" <?php if ($TOOLBAR_ORDER_BY == 'title-asc') echo 'SELECTED'; ?>>Τίτλος (αύξουσα)</option>
		<option value = "title-desc" <?php if ($TOOLBAR_ORDER_BY == 'title-desc') echo 'SELECTED'; ?>>Τίτλος (φθίνουσα)</option>
		<option value = "c-asc" <?php if ($TOOLBAR_ORDER_BY == 'c-asc') echo 'SELECTED'; ?>>Διαγωνισμός (αύξουσα)</option>
		<option value = "c-desc" <?php if ($TOOLBAR_ORDER_BY == 'c-desc') echo 'SELECTED'; ?>>Διαγωνισμός (φθίνουσα)</option>
	</select>
	
	<div class = "clear"></div>
</div>
<div class="clear"></div>