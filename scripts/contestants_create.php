<?php 
	require("access_isset.php"); 
	$HELP_CONTESTANTS_CREATE_NAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_CONTESTANTS_CREATE_POLLS = 'Υποχρεωτικό πεδίο. Επιλογή απο λίστα.';
	$HELP_CONTESTANTS_CREATE_URL = 'Μη υποχρεωτικό πεδίο. Σύνδεσμος του συμμετέχοντος.';
	$HELP_CONTESTANTS_CREATE_INFO = 'Μη υποχρετικό πεδίο. Λεπτομέρειες του συμμετέχοντος.';
?>
<div class="breadcrumb">Διαγωνισμοί &raquo; Συμμετέχοντες &raquo; Προσθήκη</div>
<?php echo $validation_message; ?>
<form id="valform" name="contestants_create" method="post" action="scripts/contestants_insert.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_CONTESTANTS_CREATE_NAME; ?>">[?]</span>Όνομα<span class="mandatory_field">*</span></div><div class="form_right"><input name="c_name" class="required long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_CONTESTANTS_CREATE_POLLS; ?>">[?]</span>Διαγωνισμός<span class="mandatory_field">*</span></div>
	<div class="form_right">
		<?php
			//Get the `polls`
			include("db_connect.php");
			$sql_p = "SELECT * FROM `polls` ORDER BY P_TITLE";
			$query_p = mysql_query($sql_p) or die(mysql_error());
			$rows_p = mysql_num_rows($query_p);
			if ($rows_p)
			{	
				echo '<select name="p_id" class="required long">';
				while($result_p = mysql_fetch_array($query_p))
				{
					echo '<option value="'.$result_p['P_ID'].'">'.stripslashes($result_p['P_TITLE']).'</option>';
				}
				echo '</select>';
			}
			include("db_disconnect.php");
		?>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_CONTESTANTS_CREATE_URL; ?>">[?]</span>URL</div><div class="form_right"><input name="c_url" class="url long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_CONTESTANTS_CREATE_INFO; ?>">[?]</span>Λεπτομέρειες</div><div class="form_right"><textarea name="c_info" class="required jquery_ckeditor" width="500"></textarea></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>