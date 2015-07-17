<?php 
	require("access_isset.php");
	
	$HELP_WEBSITE_USERS_CREATE_COMPANY = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_NAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_SURNAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_ADDRESS = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_ZIPCODE = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_CITY = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_COUNTRY = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_TEL = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_CEL = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_FAX = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_TAX_NUMBER = 'Μη υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 100 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_ACCOUNT_ACTIVATION = 'Μη υποχρεωτικό πεδίο. Ημερομηνία έναρξης λογαριασμού.';
	$HELP_WEBSITE_USERS_CREATE_ACCOUNT_EXPIRATION = 'Μη υποχρεωτικό πεδίο. Ημερομηνία λήξης λογαριασμού.';
	$HELP_WEBSITE_USERS_CREATE_ACTIVE = 'Πεδίου ελέγχου. Ενεργοποίηση/Απενεργοποίηση λογαριασμού.';
	$HELP_WEBSITE_USERS_CREATE_EMAIL = 'Υποχρεωτικό πεδίο. Διεύθυνση ηλεκτρονικού ταχυδρομίου.';
	$HELP_WEBSITE_USERS_CREATE_USERNAME = 'Υποχρεωτικό πεδίο που αντιστοιχεί στο όνομα χρήστη. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_WEBSITE_USERS_CREATE_PASSWORD = 'Το συνθηματικό θα πρέπει να αποτελείται το λιγότερο από 4 χαρακτήρες και δεν πρέπει να περιέχει κενά.';
	$HELP_WEBSITE_USERS_CREATE_RETYPE_PASSWORD = 'Το συνθηματικό θα πρέπει να αποτελείται το λιγότερο από 4 χαρακτήρες και δεν πρέπει να περιέχει κενά.';
	$HELP_WEBSITE_USERS_CREATE_COMMENTS = 'Μη υποχρεωτικό πεδίο. Επιπρόσθετες πληροφορίες.';
?>
<div class="breadcrumb">Διαχείριση electro &raquo; Χρήστες Ιστότοπου &raquo; Προσθήκη χρήστη</div>
<?php echo $validation_message; ?>
<form id="wu_valform" name="wu_add" method="post" action="scripts/website_users_insert.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_COMPANY; ?>">[?]</span>Επιχείριση</div><div class="form_right"><input name="wu_brandname" class="long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_NAME; ?>">[?]</span>Όνομα</div><div class="form_right"><input name="wu_fname" class="long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_SURNAME; ?>">[?]</span>Επώνυμο</div><div class="form_right"><input name="wu_lname" class="long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_ADDRESS; ?>">[?]</span>Διεύθυνση</div><div class="form_right"><input name="wu_address" class="long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_ZIPCODE; ?>">[?]</span>Τ.Κ.</div><div class="form_right"><input name="wu_zipcode" class="medium" type="text"  maxlength="100" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_CITY; ?>">[?]</span>Πόλη</div><div class="form_right"><input name="wu_city" class="medium" type="text"  maxlength="255" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_COUNTRY; ?>">[?]</span>Χώρα</div><div class="form_right"><input name="wu_country" class="medium" type="text"  maxlength="255" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_TEL; ?>">[?]</span>Τηλέφωνο</div><div class="form_right"><input name="wu_tel" class="medium" type="text"  maxlength="100" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_CEL; ?>">[?]</span>Κινητό</div><div class="form_right"><input name="wu_cel" class="medium" type="text"  maxlength="100" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_FAX; ?>">[?]</span>FAX</div><div class="form_right"><input name="wu_fax" class="medium" type="text"  maxlength="100" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_TAX_NUMBER; ?>">[?]</span>Α.Φ.Μ.</div><div class="form_right"><input name="wu_afm" class="medium" type="text"  maxlength="255" /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_ACCOUNT_ACTIVATION; ?>">[?]</span>Έναρξη</div><div class="form_right"><input id="datepicker_start" name="wu_date_start" class="tiny formDate" type="text"  maxlength="10" readonly /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_ACCOUNT_EXPIRATION; ?>">[?]</span>Λήξη</div><div class="form_right"><input id="datepicker_expire" name="wu_date_expire" class="tiny formDate" type="text"  maxlength="10" readonly /></div>
	<div class="clear"></div>	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_ACTIVE; ?>">[?]</span>Σε ισχύ</div><div class="form_right"><input name="wu_active" type="checkbox"  value="1" CHECKED /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_EMAIL; ?>">[?]</span>e-mail<span class="mandatory_field">*</span></div><div class="form_right"><input name="wu_email" class="required email long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_USERNAME; ?>">[?]</span>Username<span class="mandatory_field">*</span></div><div class="form_right"><input name="wu_un" class="required long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_PASSWORD; ?>">[?]</span>Συνθηματικό<span class="mandatory_field">*</span></div><div class="form_right"><input id="wu_pwd" name="wu_pwd" class="required long" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_RETYPE_PASSWORD; ?>">[?]</span>Επανάληψη<span class="mandatory_field">*</span></div><div class="form_right"><input name="wu_pwd_re" class="required long" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input id = "toggle-pwd" class = "toggle-pwd" name="toggle-pwd" type="checkbox"  value="0" /><label class = "toggle-pwd-label toggle-pwd" for = "toggle-pwd">Εμφάνιση χαρακτήρων</label></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_WEBSITE_USERS_CREATE_COMMENTS; ?>">[?]</span>Σχόλια</div><div class="form_right"><textarea name="wu_comments" class="jquery_ckeditor" width="500"></textarea></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>