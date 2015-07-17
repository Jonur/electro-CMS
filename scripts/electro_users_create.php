<?php 
	require("access_isset.php"); 
	$HELP_ELECTRO_USERS_CREATE_USERNAME = 'Υποχρεωτικό πεδίο που αντιστοιχεί στο όνομα χρήστη. Αλφαριθμητικό μέχρι 255 χαρακτήρες. Το όνομα χρήστη πρέπει να είναι μοναδικό.';
	$HELP_ELECTRO_USERS_CREATE_EMAIL = 'Μη υποχρεωτικό πεδίο. Διεύθυνση ηλεκτρονικού ταχυδρομίου. Το e-mail πρέπει να είναι μοναδικό.';
	$HELP_ELECTRO_USERS_CREATE_LEVEL = 'Υποχρεωτικό πεδίο. Επίπεδο πρόσβασης χρήστη.';
	$HELP_ELECTRO_USERS_CREATE_PASSWORD = 'Υποχρεωτικό πεδίο. Το συνθηματικό θα πρέπει να αποτελείται το λιγότερο από 4 χαρακτήρες και δεν πρέπει να περιέχει κενά.';
	$HELP_ELECTRO_USERS_CREATE_RETYPE_PASSWORD = 'Υποχρεωτικό πεδίο. Το συνθηματικό θα πρέπει να αποτελείται το λιγότερο από 4 χαρακτήρες και δεν πρέπει να περιέχει κενά.';
?>
<div class="breadcrumb">Διαχείριση electro &raquo; Χρήστες electro &raquo; Προσθήκη χρήστη</div>
<?php echo $validation_message; ?>
<form id="eu_valform" name="eu_add" method="post" action="scripts/electro_users_insert.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ELECTRO_USERS_CREATE_USERNAME; ?>">[?]</span>username<span class="mandatory_field">*</span></div><div class="form_right"><input name="eu_username" class="required long" type="text"  maxlength="100" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ELECTRO_USERS_CREATE_EMAIL; ?>">[?]</span>e-mail</div><div class="form_right"><input name="eu_email" class="email long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ELECTRO_USERS_CREATE_LEVEL; ?>">[?]</span>Επίπεδο<span class="mandatory_field">*</span></div>
	<div class="form_right">
		<select name="eu_level" class="required short">
			<optgroup label="Παρακαλώ επιλέξτε">
				<option value="0">Χρήστης</option>
				<option value="1">Διαχειριστής</option>
			</optgroup>
		</select>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ELECTRO_USERS_CREATE_PASSWORD; ?>">[?]</span>Συνθηματικό<span class="mandatory_field">*</span></div><div class="form_right"><input id="eu_pwd" name="eu_pwd" class="required long" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ELECTRO_USERS_CREATE_RETYPE_PASSWORD; ?>">[?]</span>Επανάληψη<span class="mandatory_field">*</span></div><div class="form_right"><input name="eu_pwd_re" class="required long" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input id = "toggle-pwd" class = "toggle-pwd" name="toggle-pwd" type="checkbox"  value="0" /><label class = "toggle-pwd-label toggle-pwd" for = "toggle-pwd">Εμφάνιση χαρακτήρων</label></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>