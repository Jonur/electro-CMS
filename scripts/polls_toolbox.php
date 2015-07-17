<?php 
	//Get toolbar values
	$TOOLBOX_FILE = 'polls';
	
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
			$mysql_order_by = 'P_TITLE ASC';
			break;
		case 'title-desc':
			$mysql_order_by = 'P_TITLE DESC';
			break;
		case 'st-asc':
			$mysql_order_by = 'P_STARTDATE ASC';
			break;
		case 'st-desc':
			$mysql_order_by = 'P_STARTDATE DESC';
			break;
		case 'ed-asc':
			$mysql_order_by = 'P_ENDDATE ASC';
			break;
		case 'ed-desc':
			$mysql_order_by = 'P_ENDDATE DESC';
			break;
		default:
			$mysql_order_by = 'P_TITLE ASC';
	}
?>
<div id = "toolbar">
	<select id = "order-by" title = "Ταξινόμηση αποτελεσμάτων" onchange = "javascript:refreshListP('<?php echo $TOOLBOX_FILE; ?>', this.value);">
		<option value = "title-asc" <?php if ($TOOLBAR_ORDER_BY == 'title-asc') echo 'SELECTED'; ?>>Τίτλος (αύξουσα)</option>
		<option value = "title-desc" <?php if ($TOOLBAR_ORDER_BY == 'title-desc') echo 'SELECTED'; ?>>Τίτλος (φθίνουσα)</option>
		<option value = "st-asc" <?php if ($TOOLBAR_ORDER_BY == 'st-asc') echo 'SELECTED'; ?>>Από (αύξουσα)</option>
		<option value = "st-desc" <?php if ($TOOLBAR_ORDER_BY == 'st-desc') echo 'SELECTED'; ?>>Από (φθίνουσα)</option>
		<option value = "ed-asc" <?php if ($TOOLBAR_ORDER_BY == 'ed-asc') echo 'SELECTED'; ?>>Μέχρι (αύξουσα)</option>
		<option value = "ed-desc" <?php if ($TOOLBAR_ORDER_BY == 'ed-desc') echo 'SELECTED'; ?>>Μέχρι (φθίνουσα)</option>
	</select>
	
	<div class = "clear"></div>
</div>
<div class="clear"></div>