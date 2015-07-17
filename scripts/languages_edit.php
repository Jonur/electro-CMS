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
	$sql_edit_l = "SELECT * FROM `languages` WHERE L_ID = '$edit_id'";
	if(!$query_edit_l = mysql_query($sql_edit_l))
		header('Location: ../electro/');
	while ($l_row = mysql_fetch_array($query_edit_l))
	{
		$l_name = stripslashes($l_row['L_NAME']);
		$l_abbreviation = stripslashes($l_row['L_ABBREVIATION']);
		$l_rank = $l_row['L_RANK'];
		$l_visible = $l_row['L_VISIBLE'];
	}
	require("db_disconnect.php");
	
	$is_visible = "";
	if ($l_visible == 1){
		$is_visible = "CHECKED";
	}
	
	$HELP_LANGUAGES_EDIT_NAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_LANGUAGES_EDIT_ABBREVIATION = 'Υποχρωτικό πεδίο. Αλφαριθμητικό μέχρι 4 χαρακτήρες.';
	$HELP_LANGUAGES_EDIT_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του στοιχείου στην ιστοσελίδα.';
	$HELP_LANGUAGES_EDIT_ACTIVE = 'Πεδίο ελέγχου. Εμφάνιση ή απόκρυψη του στοιχείου στην ιστοσελίδα.';
?>
<div class="breadcrumb">Πρόσθετα &raquo; Γλώσσες &raquo; Επεξεργασία</div>
<?php echo $validation_message; ?>
<form id="valform" name="languages_edit" method="post" action="scripts/languages_update.php?<?php echo $TOOLBOX_SELECTED_OPTIONS; ?>">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_LANGUAGES_EDIT_NAME; ?>">[?]</span>Όνομα<span class="mandatory_field">*</span></div><div class="form_right"><input name="l_name" class="required long" type="text"  maxlength="255" value="<?php echo $l_name; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_LANGUAGES_EDIT_ABBREVIATION; ?>">[?]</span>Συντομογραφία<span class="mandatory_field">*</span></div><div class="form_right"><input name="l_abbreviation" class="required short" type="text"  maxlength="4" value="<?php echo $l_abbreviation; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_LANGUAGES_EDIT_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="l_rank" class="digits short" type="text"  maxlength="4" value="<?php echo $l_rank; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_LANGUAGES_EDIT_ACTIVE; ?>">[?]</span>Ενεργή</div><div class="form_right"><input name="l_visible" type="checkbox"  value="1" <?php echo $is_visible; ?> /></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αλλαγή" /></div>
	<div class="clear"></div>
</form>