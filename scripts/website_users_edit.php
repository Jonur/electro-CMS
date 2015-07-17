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
	$sql_edit_wu = "SELECT * FROM `website_users` WHERE WU_ID = '$edit_id'";
	if(!$query_edit_wu = mysql_query($sql_edit_wu))
		header('Location: ../electro/');
	while ($wu_row = mysql_fetch_array($query_edit_wu))
	{
		$wu_username = stripslashes($wu_row['WU_USERNAME']);
		$wu_brandname = stripslashes($wu_row['WU_BRANDNAME']);
		$wu_fname = stripslashes($wu_row['WU_FNAME']);
		$wu_lname = stripslashes($wu_row['WU_LNAME']);
		$wu_address = stripslashes($wu_row['WU_ADDRESS']);
		$wu_zipcode = stripslashes($wu_row['WU_ZIPCODE']);
		$wu_city = stripslashes($wu_row['WU_CITY']);
		$wu_country = stripslashes($wu_row['WU_COUNTRY']);
		$wu_tel = stripslashes($wu_row['WU_TEL']);
		$wu_cel = stripslashes($wu_row['WU_CEL']);
		$wu_fax = stripslashes($wu_row['WU_FAX']);
		$wu_email = stripslashes($wu_row['WU_EMAIL']);
		$wu_afm = stripslashes($wu_row['WU_AFM']);
		$wu_comments = stripslashes($wu_row['WU_COMMENTS']);
		$wu_date_start = $wu_row['WU_DATESTART'];
		$wu_date_expire = $wu_row['WU_DATEEXPIRE'];
		$wu_active = $wu_row['WU_ACTIVE'];
	}
	
	$is_active = "";
	if ($wu_active == 1){
		$is_active = "CHECKED";
	}
	require("db_disconnect.php");
	
	$HELP_WEBSITE_USERS_EDIT_COMPANY = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_NAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_SURNAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_ADDRESS = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_ZIPCODE = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_CITY = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_COUNTRY = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_TEL = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_CEL = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_FAX = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_TAX_NUMBER = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_ACCOUNT_ACTIVATION = 'Μη υποχρεωτικό πεδίο. Ημερομηνία έναρξης λογαριασμού.';
	$HELP_WEBSITE_USERS_EDIT_ACCOUNT_EXPIRATION = 'Μη υποχρεωτικό πεδίο. Ημερομηνία λήξης λογαριασμού.';
	$HELP_WEBSITE_USERS_EDIT_ACTIVE = 'Πεδίου ελέγχου. Ενεργοποίηση/Απενεργοποίηση λογαριασμού.';
	$HELP_WEBSITE_USERS_EDIT_EMAIL = 'Υποχρεωτικό πεδίο. Διεύθυνση ηλεκτρονικού ταχυδρομίου.';
	$HELP_WEBSITE_USERS_EDIT_USERNAME = 'Υποχρεωτικό πεδίο που αντιστοιχεί στο όνομα χρήστη. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_WEBSITE_USERS_EDIT_PASSWORD = 'Το συνθηματικό θα πρέπει να αποτελείται το λιγότερο από 4 χαρακτήρες και δεν πρέπει να περιέχει κενά.';
	$HELP_WEBSITE_USERS_EDIT_RETYPE_PASSWORD = 'Το συνθηματικό θα πρέπει να αποτελείται το λιγότερο από 4 χαρακτήρες και δεν πρέπει να περιέχει κενά.';
	$HELP_WEBSITE_USERS_EDIT_COMMENTS = 'Μη υποχρεωτικό πεδίο. Επιπρόσθετες πληροφορίες.';
?>
<div class="breadcrumb">Διαχείριση electro &raquo; Χρήστες Ιστότοπου &raquo; Επεξεργασία χρήστη</div>
<?php echo $validation_message; ?>
<form id="wu_edit_valform" name="wu_edit" method="post" action="scripts/website_users_update.php?<?php echo $TOOLBOX_SELECTED_OPTIONS; ?>">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_COMPANY; ?>">[?]</span>Επιχείριση</div><div class="form_right"><input name="wu_brandname" class="long" type="text"  maxlength="255" value="<?php echo $wu_username; ?>" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_NAME; ?>">[?]</span>Όνομα</div><div class="form_right"><input name="wu_fname" class="long" type="text"  maxlength="255" value="<?php echo $wu_lname; ?>" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_SURNAME; ?>">[?]</span>Επώνυμο</div><div class="form_right"><input name="wu_lname" class="long" type="text"  maxlength="255" value="<?php echo $wu_fname; ?>" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_ADDRESS; ?>">[?]</span>Διεύθυνση</div><div class="form_right"><input name="wu_address" class="long" type="text"  maxlength="255" value="<?php echo $wu_address; ?>" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_ZIPCODE; ?>">[?]</span>Τ.Κ.</div><div class="form_right"><input name="wu_zipcode" class="medium" type="text"  maxlength="100" value="<?php echo $wu_zipcode; ?>" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_CITY; ?>">[?]</span>Πόλη</div><div class="form_right"><input name="wu_city" class="medium" type="text"  maxlength="255" value="<?php echo $wu_city; ?>" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_COUNTRY; ?>">[?]</span>Χώρα</div><div class="form_right"><input name="wu_country" class="medium" type="text"  maxlength="255" value="<?php echo $wu_country; ?>" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_TEL; ?>">[?]</span>Τηλέφωνο</div><div class="form_right"><input name="wu_tel" class="medium" type="text"  maxlength="100" value="<?php echo $wu_tel; ?>" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_CEL; ?>">[?]</span>Κινητό</div><div class="form_right"><input name="wu_cel" class="medium" type="text"  maxlength="100" value="<?php echo $wu_cel; ?>" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_FAX; ?>">[?]</span>FAX</div><div class="form_right"><input name="wu_fax" class="medium" type="text"  maxlength="100"  value="<?php echo $wu_fax; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_TAX_NUMBER; ?>">[?]</span>Α.Φ.Μ.</div><div class="form_right"><input name="wu_afm" class="medium" type="text"  maxlength="255" value="<?php echo $wu_afm; ?>" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_ACCOUNT_ACTIVATION; ?>">[?]</span>Έναρξη</div><div class="form_right"><input id="datepicker_start" name="wu_date_start" class="tiny formDate" type="text"  maxlength="10" value="<?php echo $wu_date_start; ?>" readonly /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_ACCOUNT_EXPIRATION; ?>">[?]</span>Λήξη</div><div class="form_right"><input id="datepicker_expire" name="wu_date_expire" class="tiny formDate" type="text"  maxlength="10" value="<?php echo $wu_date_expire; ?>" readonly /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_ACTIVE; ?>">[?]</span>Σε ισχύ</div><div class="form_right"><input name="wu_active" type="checkbox"  value="1" <?php echo $is_active; ?> /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_EMAIL; ?>">[?]</span>e-mail<span class="mandatory_field">*</span></div><div class="form_right"><input name="wu_email" class="required email long" type="text"  maxlength="255" value="<?php echo $wu_email; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_USERNAME; ?>">[?]</span>Username<span class="mandatory_field">*</span></div><div class="form_right"><input name="wu_un" class="required long" type="text"  maxlength="255"  value="<?php echo $wu_username; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_PASSWORD; ?>">[?]</span>Συνθηματικό</div><div class="form_right"><input id="wu_pwd" name="wu_pwd" class="long" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_RETYPE_PASSWORD; ?>">[?]</span>Επανάληψη</div><div class="form_right"><input name="wu_pwd_re" class="long" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input id = "toggle-pwd" class = "toggle-pwd" name="toggle-pwd" type="checkbox"  value="0" /><label class = "toggle-pwd-label toggle-pwd" for = "toggle-pwd">Εμφάνιση χαρακτήρων</label></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_EDIT_COMMENTS; ?>">[?]</span>Σχόλια</div><div class="form_right"><textarea name="wu_comments" class="jquery_ckeditor" width="500"><?php echo $wu_comments; ?></textarea></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>