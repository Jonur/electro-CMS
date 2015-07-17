<?php 
	require("access_isset.php"); 
	$HELP_MENU_GROUPS_CREATE_TITLE = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_MENU_GROUPS_CREATE_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του στοιχείου στην ιστοσελίδα.';
	$HELP_MENU_GROUPS_CREATE_VISIBLE = 'Πεδίο ελέγχου. Εμφάνιση ή απόκρυψη του στοιχείου στην ιστοσελίδα.';
	$HELP_MENU_GROUPS_CREATE_ALIAS = 'Μη υποχρωτικά πεδία. Αλφαριθμητικά μέχρι 255 χαρακτήρες. Αντίστοιχοι τίτλοι του ίδιου στοιχείου στις υπόλοιπες γλώσσες της ιστοσελίδας.';
?>
<div class="breadcrumb">Δημιουργία Μενού &raquo; Ομάδες Μενού  &raquo; Δημιουργία</div>
<?php echo $validation_message; ?>
<form id="valform" name="menu_groups_create" method="post" action="scripts/menu_groups_insert.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_GROUPS_CREATE_TITLE; ?>">[?]</span>Τίτλος<span class="mandatory_field">*</span></div><div class="form_right"><input name="mg_title[<?php echo $DLTL; ?>]" class="required long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_GROUPS_CREATE_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="mg_rank" class="digits short" type="text"  maxlength="4" value="0" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_GROUPS_CREATE_VISIBLE; ?>">[?]</span>Ορατό</div><div class="form_right"><input name="mg_visible" type="checkbox"  value="1" CHECKED /></div>
	<div class="clear"></div>
	<div class="form_unified fill_alias"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_GROUPS_CREATE_ALIAS; ?>">[?]</span><img src="images/electro_expand.png" class="expand_collapse_attributes expand_collapse" />Γλωσσική Αντιστοίχιση</div>
	<div class="clear"></div>
	<!-- START: LANGUAGES -->
	<div id="lang_list">
	<?php
		//Get the `languages` from the databases except from the default language
		include("db_connect.php");
		$sql_languages = "SELECT * FROM `languages` WHERE L_ID<>'$DLTL' AND L_VISIBLE = 1 ORDER BY L_RANK";
		$query_languages = mysql_query($sql_languages) or die(mysql_error());
		$rows_languages = mysql_num_rows($query_languages);
		if ($rows_languages){
			while($result_languages = mysql_fetch_array($query_languages))
			{
				echo '
				<div class="form_left">'.stripslashes($result_languages['L_NAME']).'</div><div class="form_right"><input name="mg_title['.$result_languages['L_ID'].']" class="long" type="text"  maxlength="255" /></div>
				<div class="clear"></div>
				';
			}
		}
		include("db_disconnect.php");
	?>
	</div>
	<!-- END: LANGUAGES -->
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>