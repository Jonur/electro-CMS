<?php 
	require("access_isset.php");
	
	$HELP_LANGUAGES_CREATE_NAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_LANGUAGES_CREATE_ABBREVIATION = 'Υποχρωτικό πεδίο. Αλφαριθμητικό μέχρι 4 χαρακτήρες.';
	$HELP_LANGUAGES_CREATE_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του στοιχείου στην ιστοσελίδα.';
	$HELP_LANGUAGES_CREATE_ACTIVE = 'Πεδίο ελέγχου. Εμφάνιση ή απόκρυψη του στοιχείου στην ιστοσελίδα.';
?>
<div class="breadcrumb">Πρόσθετα &raquo; Γλώσσες &raquo; Δημιουργία</div>
<?php echo $validation_message; ?>
<form id="valform" name="languages_create" method="post" action="scripts/languages_insert.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_LANGUAGES_CREATE_NAME; ?>">[?]</span>Όνομα<span class="mandatory_field">*</span></div><div class="form_right"><input name="l_name" class="required long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_LANGUAGES_CREATE_ABBREVIATION; ?>">[?]</span>Συντομογραφία<span class="mandatory_field">*</span></div><div class="form_right"><input name="l_abbreviation" class="required short" type="text"  maxlength="4" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_LANGUAGES_CREATE_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="l_rank" class="digits short" type="text"  maxlength="4" value="0" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_LANGUAGES_CREATE_ACTIVE; ?>">[?]</span>Ενεργή</div><div class="form_right"><input name="l_visible" type="checkbox"  value="1" CHECKED /></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>