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
	$sql_edit_eu = "SELECT * FROM `electro_users` WHERE EU_ID = '$edit_id'";
	if(!$query_edit_eu = mysql_query($sql_edit_eu))
		header('Location: ../electro/');
	while ($eu_row = mysql_fetch_array($query_edit_eu))
	{
		$eu_username = stripslashes($eu_row['EU_USERNAME']);
		$eu_email = stripslashes($eu_row['EU_EMAIL']);
		$eu_level = $eu_row['EU_LEVEL'];
	}
	require("db_disconnect.php");
	
	$HELP_ELECTRO_USERS_EDIT_USERNAME = 'Υποχρεωτικό πεδίο που αντιστοιχεί στο όνομα χρήστη. Αλφαριθμητικό μέχρι 255 χαρακτήρες. Το όνομα χρήστη πρέπει να είναι μοναδικό.';
	$HELP_ELECTRO_USERS_EDIT_EMAIL = 'Μη υποχρεωτικό πεδίο. Διεύθυνση ηλεκτρονικού ταχυδρομίου. Το e-mail πρέπει να είναι μοναδικό.';
	$HELP_ELECTRO_USERS_EDIT_LEVEL = 'Υποχρεωτικό πεδίο. Επίπεδο πρόσβασης χρήστη.';
	$HELP_ELECTRO_USERS_EDIT_PASSWORD = 'Υποχρεωτικό πεδίο. Το συνθηματικό θα πρέπει να αποτελείται το λιγότερο από 4 χαρακτήρες και δεν πρέπει να περιέχει κενά.';
	$HELP_ELECTRO_USERS_EDIT_RETYPE_PASSWORD = 'Υποχρεωτικό πεδίο. Το συνθηματικό θα πρέπει να αποτελείται το λιγότερο από 4 χαρακτήρες και δεν πρέπει να περιέχει κενά.';
?>
<div class="breadcrumb">Διαχείριση electro &raquo; Χρήστες electro &raquo; Επεξεργασία χρήστη</div>
<?php echo $validation_message; ?>
<form id="eu_edit_valform" name="eu_add" method="post" action="scripts/electro_users_update.php?<?php echo $TOOLBOX_SELECTED_OPTIONS; ?>">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ELECTRO_USERS_EDIT_USERNAME; ?>">[?]</span>username<span class="mandatory_field">*</span></div><div class="form_right"><input name="eu_username" class="required long" type="text"  maxlength="100" value="<?php echo $eu_username; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ELECTRO_USERS_EDIT_EMAIL; ?>">[?]</span>e-mail</div><div class="form_right"><input name="eu_email" class="email long" type="text"  maxlength="255" value="<?php echo $eu_email; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ELECTRO_USERS_EDIT_LEVEL; ?>">[?]</span>Επίπεδο<span class="mandatory_field">*</span></div>
	<div class="form_right">
		<?php 
			if ($eu_level == '2')
			{
		?>
			<select name="eu_level" class="required short">
				<optgroup label="Παρακαλώ επιλέξτε">
					<option value="2" SELECTED READONLY>Διαχειριστής</option>
				</optgroup>
			</select>
		<?php
			}else{
		?>
		<select name="eu_level" class="required short">
			<optgroup label="Παρακαλώ επιλέξτε">
				<option value="0" <?php if ($eu_level == '0') echo 'SELECTED'; ?>>Χρήστης</option>
				<option value="1" <?php if ($eu_level == '1') echo 'SELECTED'; ?>>Διαχειριστής</option>
			</optgroup>
		</select>
		<?php
			}
		?>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ELECTRO_USERS_EDIT_PASSWORD; ?>">[?]</span>Συνθηματικό</div><div class="form_right"><input id="eu_pwd" name="eu_pwd" class="long" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ELECTRO_USERS_EDIT_RETYPE_PASSWORD; ?>">[?]</span>Επανάληψη</div><div class="form_right"><input name="eu_pwd_re" class="long" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input id = "toggle-pwd" class = "toggle-pwd" name="toggle-pwd" type="checkbox"  value="0" /><label class = "toggle-pwd-label toggle-pwd" for = "toggle-pwd">Εμφάνιση χαρακτήρων</label></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αλλαγή" /></div>
	<div class="clear"></div>
</form>