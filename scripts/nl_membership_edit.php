<?php require("access_isset.php"); ?>
<?php
	if (!empty($_REQUEST['id']))
	{
		$edit_id = $_REQUEST['id'];
	}else{
		//Redirection
		header('Location: ../electro/');
	}
	
	require("db_connect.php");
	$sql_edit_nl = "SELECT * FROM `newsletter_members` WHERE NM_ID = '$edit_id'";
	if(!$query_edit_nl = mysql_query($sql_edit_nl))
		header('Location: ../electro/');
	while ($nl_row = mysql_fetch_array($query_edit_nl))
	{
		$nm_name = stripslashes($nl_row['NM_NAME']);
		$nm_surname = stripslashes($nl_row['NM_SURNAME']);
		$nm_email = stripslashes($nl_row['NM_EMAIL']);
		$nm_tel = stripslashes($nl_row['NM_TEL']);
	}
	require("db_disconnect.php");
	
	$HELP_NL_EDIT_EMAIL = 'Υποχρεωτικό πεδίο. Διεύθυνση ηλεκτρονικού ταχυδρομίου.';
	$HELP_NL_EDIT_NAME = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_NL_EDIT_SURNAME = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_NL_EDIT_TEL = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
?>
<div class="breadcrumb">Newsletter &raquo; Αρχείο Μελών &raquo; Επεξεργασία Μέλους</div>
<?php echo $validation_message; ?>
<form id="valform" name="nl_edit" method="post" action="scripts/nl_membership_update.php">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_EDIT_EMAIL; ?>">[?]</span>e-mail<span class="mandatory_field">*</span></div><div class="form_right"><input name="nm_email" class="required email long" type="text"  maxlength="255" value="<?php echo $nm_email; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_EDIT_NAME; ?>">[?]</span>Όνομα</div><div class="form_right"><input name="nm_name" class="long" type="text"  maxlength="255" value="<?php echo $nm_name; ?>"/></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_EDIT_SURNAME; ?>">[?]</span>Επίθετο</div><div class="form_right"><input name="nm_surname" class="long" type="text"  maxlength="255" value="<?php echo $nm_surname; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_EDIT_TEL; ?>">[?]</span>Τηλέφωνο</div><div class="form_right"><input name="nm_tel" class="long" type="text"  maxlength="20" value="<?php echo $nm_tel; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αλλαγή" /></div>
	<div class="clear"></div>
</form>