<?php require("access_isset.php"); ?>
<?php echo $error_state_msg; ?>
<form id="valform" name="login_form" method="post" action="scripts/login_chkpwd.php">
	<div class="login_form_left">Όνομα Χρήστη</div><div class="login_form_right"><input id="electro_un" name="electro_un" class="required medium" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="login_form_left">Συνθηματικό</div><div class="login_form_right"><input name="electro_pw" class="required medium" type="password"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="login_form_left">&nbsp;</div><div class="login_form_right"><input type="submit" class="form_button" value="Είσοδος" /></div>
	<div class="clear"></div>
</form>