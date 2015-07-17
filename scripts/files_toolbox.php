<?php 
	//Get toolbar values
	$TOOLBOX_FILE = 'files';
	
	$TOOLBAR_ORDER_BY = 'title-asc';
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	
	$ft = "photos";
	if(!empty($_REQUEST['ft'])){
		$ft = $_REQUEST['ft'];
		$TOOLBOX_SELECTED_OPTIONS .= '&ft='.$_REQUEST['ft'];
	}
	
	if (!empty($_REQUEST['tob'])){
		$TOOLBAR_ORDER_BY = $_REQUEST['tob'];
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
			
	$img_arr = "('.jpeg','.jpg','.png','.gif')";
	$text_arr = "('.odt','.odf','.txt','.pdf','.xls','.doc','.docx','.xlsx')";
	$audio_arr = "('.mp3','.wav','.mpeg','.mpg')";
	$current_arr = $img_arr;
	switch ($ft){
		case "photos":
			$current_arr = $img_arr;
			break;
		case "text";
			$current_arr = $text_arr;
			break;
		case "audio";
			$current_arr = $audio_arr;
			break;
		default:
	}
	
	//Set mysql query options
	switch ($TOOLBAR_ORDER_BY){
		case 'title-asc':
			$mysql_order_by = 'F_NAME ASC';
			break;
		case 'title-desc':
			$mysql_order_by = 'F_NAME DESC';
			break;
		case 'rank-asc':
			$mysql_order_by = 'F_RANK ASC';
			break;
		case 'rank-desc':
			$mysql_order_by = 'F_RANK DESC';
			break;
		default:
			$mysql_order_by = 'F_NAME ASC';
	}
?>
<div id = "toolbar">
	<select id = "files_type" title = "Επιλογή τύπου αρχείων" onchange = "javascript:refreshListF('<?php echo $TOOLBOX_FILE; ?>', this.value, '<?php echo $TOOLBAR_ORDER_BY; ?>');">
		<option value = "photos" <?php if ($ft == 'photos') echo 'SELECTED'; ?>>Εικόνας</option>
		<option value = "text" <?php if ($ft == 'text') echo 'SELECTED'; ?>>Κειμένου</option>
		<option value = "audio" <?php if ($ft == 'audio') echo 'SELECTED'; ?>>Ήχου</option>
	</select>
	
	<select id = "order-by" title = "Ταξινόμηση αποτελεσμάτων" onchange = "javascript:refreshListF('<?php echo $TOOLBOX_FILE; ?>', '<?php echo $ft; ?>', this.value);">
		<option value = "title-asc" <?php if ($TOOLBAR_ORDER_BY == 'title-asc') echo 'SELECTED'; ?>>Τίτλος (αύξουσα)</option>
		<option value = "title-desc" <?php if ($TOOLBAR_ORDER_BY == 'title-desc') echo 'SELECTED'; ?>>Τίτλος (φθίνουσα)</option>
		<option value = "rank-asc" <?php if ($TOOLBAR_ORDER_BY == 'rank-asc') echo 'SELECTED'; ?>>Κατάταξη (αύξουσα)</option>
		<option value = "rank-desc" <?php if ($TOOLBAR_ORDER_BY == 'rank-desc') echo 'SELECTED'; ?>>Κατάταξη (φθίνουσα)</option>
	</select>
	
	<div class = "clear"></div>
</div>
<div class="clear"></div>