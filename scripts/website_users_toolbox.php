<?php 
	//Get toolbar values
	$TOOLBOX_FILE = 'website_users';
	
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
			$mysql_order_by = 'WU_USERNAME ASC';
			break;
		case 'un-desc':
			$mysql_order_by = 'WU_USERNAME DESC';
			break;
		case 'email-asc':
			$mysql_order_by = 'WU_EMAIL ASC';
			break;
		case 'email-desc':
			$mysql_order_by = 'WU_EMAIL DESC';
			break;
		default:
			$mysql_order_by = 'WU_USERNAME ASC';
	}
?>
<div id = "toolbar">
	<select id = "order-by" title = "Ταξινόμηση αποτελεσμάτων" onchange = "javascript:refreshListWU('<?php echo $TOOLBOX_FILE; ?>', this.value);">
		<option value = "un-asc" <?php if ($TOOLBAR_ORDER_BY == 'un-asc') echo 'SELECTED'; ?>>Username (αύξουσα)</option>
		<option value = "un-desc" <?php if ($TOOLBAR_ORDER_BY == 'un-desc') echo 'SELECTED'; ?>>Username (φθίνουσα)</option>
		<option value = "email-asc" <?php if ($TOOLBAR_ORDER_BY == 'email-asc') echo 'SELECTED'; ?>>E-mail (αύξουσα)</option>
		<option value = "email-desc" <?php if ($TOOLBAR_ORDER_BY == 'email-desc') echo 'SELECTED'; ?>>E-mail (φθίνουσα)</option>
	</select>
	
	<div class = "clear"></div>
</div>
<div class="clear"></div>