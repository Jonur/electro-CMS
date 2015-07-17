<?php 
	require("access_isset.php"); 
	
	require("db_connect.php");
	$sql_bs = "SELECT * FROM `basic_settings` WHERE BS_ID = 'KNQJBHCHMI' LIMIT 1";
	$query_bs = mysql_query($sql_bs) or die(mysql_error());
	$rows_bs = mysql_num_rows($query_bs);
	if ($rows_bs){
		$result_bs = mysql_fetch_array($query_bs);
		
		$bs_title = stripslashes($result_bs['BS_TITLE']);
		$bs_basepath = stripslashes($result_bs['BS_BASEPATH']);
		$bs_favico = '<img id = "favico-preview" src = "'.$local_favico.stripslashes($result_bs['BS_FAVICO']).'" />';
		$bs_description = stripslashes($result_bs['BS_DESCRIPTION']);
		$bs_keywords = stripslashes($result_bs['BS_KEYWORDS']);
		$bs_revisit_after = stripslashes($result_bs['BS_REVISIT_AFTER']);
		$bs_author = stripslashes($result_bs['BS_AUTHOR']);
		$bs_dcterms_abstract = stripslashes($result_bs['BS_DCTERMS_ABSTRACT']);
		$bs_rating = stripslashes($result_bs['BS_RATING']);
		$bs_ms_validate = stripslashes($result_bs['BS_MS_VALIDATE']);
	}else{
		$bs_title = '';
		$bs_basepath = '';
		$bs_favico = '<img id = "favico-preview" src = "#" class = "no-icon" />';
		$bs_description = '';
		$bs_keywords = '';
		$bs_revisit_after = '';
		$bs_author = '';
		$bs_dcterms_abstract = '';
		$bs_rating = '';
		$bs_ms_validate = '';
	}
	
	if (!$bs_revisit_after){
		$bs_revisit_after = '7 days';
	}
	
	if (!$bs_rating){
		$bs_rating = 'general';
	}
	
	require("db_disconnect.php");
	
	$HELP_BASIC_SETTINGS_TITLE = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό 10 - 70 χαρακτήρες.';
	$HELP_BASIC_SETTINGS_BASEPATH = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο μέχρι 255 χαρακτήρες.';
	$HELP_BASIC_SETTINGS_FAVICO = 'Μη υποχρωτικό πεδίο. Αντίστοιχιση favico στην ιστοσελίδα. Επιτρέπονται μόνο αρχεία τύπου εικονίδιου (ico). Μέγιστο επιτρεπτό μέγεθος αρχείου: 100KΒ.';
	$HELP_BASIC_SETTINGS_DESCRIPTION = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο 70 - 160 χαρακτήρες.';
	$HELP_BASIC_SETTINGS_KEYWORDS = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο μέχρι 255 χαρακτήρες.';
	$HELP_BASIC_SETTINGS_REVISIT_AFTER = 'Μη υποχρωτικό πεδίο. Επιλογή από τη λίστα.';
	$HELP_BASIC_SETTINGS_AUTHOR = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο μέχρι 255 χαρακτήρες.';
	$HELP_BASIC_SETTINGS_DCTERMS_ABSTRACT = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο μέχρι 255 χαρακτήρες.';
	$HELP_BASIC_SETTINGS_RATING = 'Μη υποχρωτικό πεδίο. Επιλογή από τη λίστα.';
	$HELP_BASIC_SETTINGS_MSVALIDATE_01 = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο μέχρι 255 χαρακτήρες.';
?>
<div class="breadcrumb">Ιστοσελίδα &raquo; Βασικές Ρυθμίσεις</div>
<?php echo $validation_message; ?>
<form id="bs_valform" name="basic_settings" method="post" enctype="multipart/form-data" action="scripts/basic_settings_update.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_BASIC_SETTINGS_TITLE; ?>">[?]</span>Title<span class="mandatory_field">*</span></div><div class="form_right"><input name="bs_title" class="long" type="text" maxlength = "70" value = "<?php echo $bs_title; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_BASIC_SETTINGS_BASEPATH; ?>">[?]</span>Basepath</div><div class="form_right"><input name="bs_basepath" class="long" type="text" maxlength = "255" value = "<?php echo $bs_basepath; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_BASIC_SETTINGS_FAVICO; ?>">[?]</span>favico</div><div class="form_right">
		<input class="form_button_choose_file" type="button" value="Επιλέξτε" onclick="javascript:trigger_from_pc();" />
		<input id="my_file_element" name="file_from_pc" type="file" class="choose_file" onchange="javascript:update_icon(this);" />
	</div>
	<div class="clear"></div>
	<div class="form_left">Αρχείο</div><div class="form_right"><div id="files_list"><?php echo $bs_favico; ?></div></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right">META tags</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_BASIC_SETTINGS_DESCRIPTION; ?>">[?]</span>description</div><div class="form_right"><input name="bs_description" class="long" type="text" maxlength = "160" value = "<?php echo $bs_description; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_BASIC_SETTINGS_KEYWORDS; ?>">[?]</span>keywords</div><div class="form_right"><textarea name="bs_keywords" class="long"><?php echo $bs_keywords; ?></textarea></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_BASIC_SETTINGS_REVISIT_AFTER; ?>">[?]</span>revisit-after</div>
	<div class="form_right">
		<select name="bs_revisit_after" class="short">
			<optgroup label="Παρακαλώ επιλέξτε">
				<option value="1 hour" <?php if ($bs_revisit_after == '1 hour') echo 'SELECTED'; ?>>1 ώρα</option>
				<option value="1 day" <?php if ($bs_revisit_after == '1 day') echo 'SELECTED'; ?>>1 μέρα</option>
				<option value="7 days" <?php if ($bs_revisit_after == '7 days') echo 'SELECTED'; ?>>1 εβδομάδα</option>
				<option value="1 month" <?php if ($bs_revisit_after == '1 month') echo 'SELECTED'; ?>>1 μήνας</option>
				<option value="1 year" <?php if ($bs_revisit_after == '1 year') echo 'SELECTED'; ?>>1 χρόνος</option>
			</optgroup>
		</select>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_BASIC_SETTINGS_AUTHOR; ?>">[?]</span>author</div><div class="form_right"><input name="bs_author" class="long" type="text" maxlength = "255" value = "<?php echo $bs_author; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_BASIC_SETTINGS_DCTERMS_ABSTRACT; ?>">[?]</span>dcterms.abstract</div><div class="form_right"><input name="bs_dcterms_abstract" class="long" type="text" maxlength = "255" value = "<?php echo $bs_dcterms_abstract; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_BASIC_SETTINGS_RATING; ?>">[?]</span>rating</div>
	<div class="form_right">
		<select name="bs_rating" class="short">
			<optgroup label="Παρακαλώ επιλέξτε">
				<option value="general" <?php if ($bs_rating == 'general') echo 'SELECTED'; ?>>general</option>
				<option value="mature" <?php if ($bs_rating == 'mature') echo 'SELECTED'; ?>>mature</option>
				<option value="restricted" <?php if ($bs_rating == 'restricted') echo 'SELECTED'; ?>>restricted</option>
				<option value="14 years" <?php if ($bs_rating == '14 years') echo 'SELECTED'; ?>>14 years</option>
				<option value="safe for kids" <?php if ($bs_rating == 'safe for kids') echo 'SELECTED'; ?>>safe for kids</option>
			</optgroup>
		</select>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_BASIC_SETTINGS_MSVALIDATE_01; ?>">[?]</span>msvalidate.01</div><div class="form_right"><input name="bs_ms_validate" class="long" type="text" maxlength = "255" value = "<?php echo $bs_ms_validate; ?>" /></div>
	<div class="clear"></div>

	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αλλαγή" /></div>
	<div class="clear"></div>
</form>