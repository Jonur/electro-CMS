<?php 
	require("access_isset.php");
	if (!empty($_REQUEST['id']))
	{
		$edit_id = $_REQUEST['id'];
	}else{
		//Redirection
		header('Location: ../electro/');
	}
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	require("db_connect.php");
	$sqp_edit_p = "SELECT * FROM `polls` WHERE P_ID = '$edit_id'";
	if(!$query_edit_p = mysql_query($sqp_edit_p))
		header('Location: ../electro/');
	while ($p_row = mysql_fetch_array($query_edit_p))
	{
		$p_title = stripslashes($p_row['P_TITLE']);
		$p_info = stripslashes($p_row['P_INFO']);
		$p_startdate = $p_row['P_STARTDATE'];
		$p_enddate = $p_row['P_ENDDATE'];
	}
	require("db_disconnect.php");
	
	$HELP_POLLS_EDIT_TITLE = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_POLLS_EDIT_INFO = 'Μη υποχρεωτικό πεδίο. Λεπτομέρειες του διαγωνισμού.';
?>
<div class="breadcrumb">Διαγωνισμοί &raquo; Διαγωνισμοί &raquo; Επεξεργασία</div>
<?php echo $validation_message; ?>
<form id="valform" name="polls_edit" method="post" action="scripts/polls_update.php?<?php echo $TOOLBOX_SELECTED_OPTIONS; ?>">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_POLLS_EDIT_TITLE; ?>">[?]</span>Τίτλος<span class="mandatory_field">*</span></div><div class="form_right"><input name="p_title" class="required long" type="text"  maxlength="255" value="<?php echo $p_title; ?>" /></div>
	<div class="clear"></div>
	<div class="form_unified_date">
		<span class="date_caption">Από: </span><input id="datepicker_from" name="p_startdate" class="tiny formDate" type="text"  maxlength="10" value="<?php echo $p_startdate; ?>" readonly />
		<span class="date_caption">Μέχρι: </span><input id="datepicker_to" name="p_enddate" class="tiny formDate" type="text"  maxlength="10" value="<?php echo $p_enddate; ?>" readonly />
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_POLLS_EDIT_INFO; ?>">[?]</span>Λεπτομέρειες</div><div class="form_right"><textarea name="p_info" class="required jquery_ckeditor" width="500"><?php echo $p_info; ?></textarea></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>