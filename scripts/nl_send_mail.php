<?php 
	require("access_isset.php"); 
	
	$HELP_NL_SEND_EMAIL_SUBJECT = 'Υποχρεωτικό πεδίο. Τίτλος του μηνύματος.';
	$HELP_NL_SEND_EMAIL_ATTACH_ARTICLE = 'Μη υποχρωτικό πεδίο. Επισύναψη άρθρου στο μήνυμα.';
	$HELP_NL_SEND_EMAIL_BODY = 'Υποχρωτικό πεδίο. Το κείμενο του μηνύματος.';
?>
<div class="breadcrumb">Newsletter &raquo; Αποστολή</div>
<?php echo $validation_message; ?>
<form id="valform" name="nl_send_email" method="post" action="scripts/nl_send.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_SEND_EMAIL_SUBJECT; ?>">[?]</span>Θέμα<span class="mandatory_field">*</span></div><div class="form_right"><input name="mail_subject" class="required long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_SEND_EMAIL_ATTACH_ARTICLE; ?>">[?]</span>Επισύναψη</div><div class="form_right">
	<?php
		//Select Article to attach with the e-mail
		require("db_connect.php");
		
		$sql_a = " SELECT * FROM `articles` 
					WHERE A_DELETED = 0 
				    ORDER BY A_TITLE,A_RANK";
		$query_a = mysql_query($sql_a) or die(mysql_error());
		$rows_a = mysql_num_rows($query_a);
		if ($rows_a)
		{
			echo '<select name="a_id" class="long">';
			echo '<option value="0" SELECTED>Κανένα</option>';
			while($result_a = mysql_fetch_array($query_a))
			{
				echo '<option value="'.$result_a['A_ID'].'" >'.stripslashes($result_a['A_TITLE']).'</option>';
			}
			echo '</select>';
		}
		require("db_disconnect.php");
	?>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_NL_SEND_EMAIL_BODY; ?>">[?]</span>Κείμενο<span class="mandatory_field">*</span></div><div class="form_right"><textarea name="mail_body" class="required jquery_ckeditor" width="500"></textarea></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αποστολή" /></div>
	<div class="clear"></div>
</form>