<?php 
	require("access_isset.php"); 
	
	$HELP_POLLS_CREATE_TITLE = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_POLLS_CREATE_INFO = 'Μη υποχρεωτικό πεδίο. Λεπτομέρειες του διαγωνισμού.';
?>
<div class="breadcrumb">Διαγωνισμοί &raquo; Διαγωνισμοί &raquo; Δημιουργία</div>
<?php echo $validation_message; ?>
<form id="valform" name="polls_create" method="post" action="scripts/polls_insert.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_POLLS_CREATE_TITLE; ?>">[?]</span>Τίτλος<span class="mandatory_field">*</span></div><div class="form_right"><input name="p_title" class="required long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_unified_date">
		<span class="date_caption">Από: </span><input id="datepicker_from" name="p_startdate" class="tiny formDate" type="text"  maxlength="10" readonly />
		<span class="date_caption">Μέχρι: </span><input id="datepicker_to" name="p_enddate" class="tiny formDate" type="text"  maxlength="10" readonly />
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_POLLS_CREATE_INFO; ?>">[?]</span>Λεπτομέρειες</div><div class="form_right"><textarea name="p_info" class="required jquery_ckeditor" width="500"></textarea></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>