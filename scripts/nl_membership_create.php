<?php 
	require("access_isset.php"); 
	$HELP_NL_ADD_EMAIL = 'Υποχρεωτικό πεδίο. Διεύθυνση ηλεκτρονικού ταχυδρομίου.';
	$HELP_NL_ADD_NAME = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_NL_ADD_SURNAME = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_NL_ADD_TEL = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
?>
<div class="breadcrumb">Newsletter &raquo; Αρχείο Μελών &raquo; Προσθήκη Μέλους</div>
<?php echo $validation_message; ?>
<form id="valform" name="nl_add" method="post" action="scripts/nl_membership_insert.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_ADD_EMAIL; ?>">[?]</span>e-mail<span class="mandatory_field">*</span></div><div class="form_right"><input name="nm_email" class="required email long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_ADD_NAME; ?>">[?]</span>Όνομα</div><div class="form_right"><input name="nm_name" class="long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_ADD_SURNAME; ?>">[?]</span>Επίθετο</div><div class="form_right"><input name="nm_surname" class="long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_ADD_TEL; ?>">[?]</span>Τηλέφωνο</div><div class="form_right"><input name="nm_tel" class="long" type="text"  maxlength="20" /></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>