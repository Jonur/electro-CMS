<?php 
	require("access_isset.php");
	require("db_connect.php");
	$edit_id = $_SESSION['EU_ID'];
	$sql_edit_eu = "SELECT * FROM `electro_users` WHERE EU_ID = '".$edit_id."'";
	if(!$query_edit_eu = mysql_query($sql_edit_eu))
		header('Location: ../electro/');
	while ($eu_row = mysql_fetch_array($query_edit_eu))
	{
		$eu_username = stripslashes($eu_row['EU_USERNAME']);
		$eu_email = stripslashes($eu_row['EU_EMAIL']);
	}
	require("db_disconnect.php");
	
	$HELP_EU_PROFILE_USERNAME = 'Το όνομα χρήστη σας δεν μπορεί να αλλάξει. Αν επιθυμείτε να το αλλάξετε, επικοινωνήστε με το διαχειριστή του συστήματος.';
	$HELP_EU_PROFILE_EMAIL = 'Μη υποχρεωτικό πεδίο. Διεύθυνση ηλεκτρονικού ταχυδρομίου.';
	$HELP_EU_PROFILE_PASSWORD = 'Το συνθηματικό θα πρέπει να αποτελείται το λιγότερο από 4 χαρακτήρες και δεν πρέπει να περιέχει κενά. Αν δεν θέλετε να αλλάξετε το συνθηματικό σας, αφήστε τα αντίστοιχα πεδία κενά.';
	$HELP_EU_PROFILE_RETYPE_PASSWORD = 'Το συνθηματικό θα πρέπει να αποτελείται το λιγότερο από 4 χαρακτήρες και δεν πρέπει να περιέχει κενά. Αν δεν θέλετε να αλλάξετε το συνθηματικό σας, αφήστε τα αντίστοιχα πεδία κενά.';
?>
<div class="breadcrumb">electro &raquo; Το προφίλ μου</div>
<?php echo $validation_message; ?>
<form id="eu_edit_valform" name="eu_profile" method="post" action="scripts/electro_users_profile_update.php">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_EU_PROFILE_USERNAME; ?>">[?]</span>username</div><div class="form_right"><input name="eu_username" class="required long readonly" type="text"  maxlength="100" value="<?php echo $eu_username; ?>" READONLY /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_EU_PROFILE_EMAIL; ?>">[?]</span>e-mail</div><div class="form_right"><input name="eu_email" class="email long" type="text"  maxlength="255" value="<?php echo $eu_email; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_EU_PROFILE_PASSWORD; ?>">[?]</span>Συνθηματικό</div><div class="form_right"><input id="eu_pwd" name="eu_pwd" class="long" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_EU_PROFILE_RETYPE_PASSWORD; ?>">[?]</span>Επανάληψη</div><div class="form_right"><input name="eu_pwd_re" class="long" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input id = "toggle-pwd" class = "toggle-pwd" name="toggle-pwd" type="checkbox"  value="0" /><label class = "toggle-pwd-label toggle-pwd" for = "toggle-pwd">Εμφάνιση χαρακτήρων</label></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αλλαγή" /></div>
	<div class="clear"></div>
</form>