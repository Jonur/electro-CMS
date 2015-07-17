<?php 
	require("access_isset.php"); 
	$HELP_MENU_ITEMS_CREATE_TITLE = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες. Επίσης, δεν μπορεί να υπάρχει Στοιχείο Μενού με ίδιο τίτλο στο ίδιο επίπεδο Υπομενού.';
	$HELP_MENU_ITEMS_CREATE_MENU_GROUPS = 'Υποχρωτικό πεδίο. Αντιστοίχιση του στοιχείου με ομάδα μενού στην οποία ανήκει.';
	$HELP_MENU_ITEMS_CREATE_SUBMENU = 'Μη υποχρωτικό πεδίο. Σχήμα δένδρου μένου. Αντιστοίχιση του στοιχείου με Στοιχείο Μενού στο οποία ανήκει.';
	$HELP_MENU_ITEMS_CREATE_TYPE = 'Υποχρεωτικό πεδίο. Δηλώνει τον τύπο περιεχομένου του Στοιχείου Μενού.';
	$HELP_MENU_ITEMS_CREATE_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του στοιχείου στην ιστοσελίδα.';
	$HELP_MENU_ITEMS_CREATE_VISIBLE = 'Πεδίο ελέγχου. Εμφάνιση ή απόκρυψη του στοιχείου στην ιστοσελίδα.';
	$HELP_MENU_ITEMS_CREATE_INFORMATION = 'Μη υποχρεωτικό πεδίο. Σχετικές πληροφορίες ή περιγραφή του Στοιχείου Μενού.';
	$HELP_MENU_ITEMS_CREATE_IMAGE = 'Μη υποχρεωτικό πεδίο. Αντιστοίχιση του Στοιχείου Μενού με εικόνα. Επιτρέπονται μόνο αρχεία τύπου εικόνας (jpg, jpeg, gif, png). Μέγιστο επιτρεπτό μέγεθος αρχείου: 10ΜΒ.';
	$HELP_MENU_ITEMS_CREATE_ALIAS = 'Μη υποχρωτικά πεδία. Αλφαριθμητικά μέχρι 255 χαρακτήρες. Αντίστοιχοι τίτλοι του ίδιου στοιχείου στις υπόλοιπες γλώσσες της ιστοσελίδας.';
	$HELP_MENU_ITEMS_CREATE_SEO_SERP = 'Μη υποχρωτικά πεδία. Καταχώρηση SEO - SERP για το συγκεκριμένο Στοιχείο Μενού.';
	$HELP_MENU_ITEMS_CREATE_DESCRIPTION = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο 70 - 160 χαρακτήρες.';
	$HELP_MENU_ITEMS_CREATE_KEYWORDS = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο μέχρι 255 χαρακτήρες.';
?>
<div class="breadcrumb">Δημιουργία Μενού &raquo; Στοιχεία Μενού  &raquo; Δημιουργία</div>
<?php echo $validation_message; ?>
<form id="valform" name="menu_items_create" method="post" enctype="multipart/form-data" action="scripts/menu_items_insert.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_TITLE; ?>">[?]</span>Τίτλος<span class="mandatory_field">*</span></div><div class="form_right"><input name="mi_title[<?php echo $DLTL; ?>]" class="required long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_MENU_GROUPS; ?>">[?]</span>Ομάδα Μενού<span class="mandatory_field">*</span></div>
	<div class="form_right">
		<select name="mi_mg" class="required long mg_change">
			<option value="0" SELECTED>Καμία</option>
			<optgroup label="Παρακαλώ επιλέξτε">
			<?php 
				//Listing the available menu groups
				require("db_connect.php");
				$sql_mg = " SELECT * FROM `menu_groups` INNER JOIN `menu_groups-languages` ON `menu_groups`.MG_ID=`menu_groups-languages`.MG_ID 
								   WHERE `menu_groups-languages`.L_ID = '$DLTL' 
								   AND `menu_groups`.MG_DELETED = 0
								   ORDER BY `menu_groups`.MG_RANK, `menu_groups-languages`.MGL_ALIAS";
				$query_mg = mysql_query($sql_mg) or die(mysql_error());
				while ($result_mg = mysql_fetch_array($query_mg))
				{
					echo '<option value="'.$result_mg['MG_ID'].'">'.stripslashes($result_mg['MGL_ALIAS']).'</option>';
				}
				require("db_disconnect.php");
			  ?>
			</optgroup>
		</select>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_SUBMENU; ?>">[?]</span>Υπομενού του:</div>
	<div class="form_right" id="items_structure" >
		<!-- Ajax content -->
		<span class="">--- Παρακαλώ επιλέξτε Ομάδα Μενού ---</span>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_TYPE; ?>">[?]</span>Τύπος<span class="mandatory_field">*</span></div>
	<div class="form_right">
		<select name="mi_type" class="required short">
			<optgroup label="Παρακαλώ επιλέξτε">
			<?php 
			  	//Listing the available menu types
				require("db_connect.php");
				$sql_mt = "SELECT * FROM `menu_types` ORDER BY MT_TYPE";
				$query_mt = mysql_query($sql_mt) or die(mysql_error());
				while ($result_mt = mysql_fetch_array($query_mt))
				{
					echo ' <option value="'.$result_mt['MT_ID'].'">'.stripslashes($result_mt['MT_TYPE']).'</option>';
				}
				require("db_disconnect.php");
			  ?>
			</optgroup>
		</select>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="mi_rank" class="digits short" type="text"  maxlength="4" value="0" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_VISIBLE; ?>">[?]</span>Ορατό</div><div class="form_right"><input name="mi_visible" type="checkbox"  value="1" CHECKED /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_INFORMATION; ?>">[?]</span>Πληροφορίες</div><div class="form_right"><input name="mi_extrainfo" class="long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_IMAGE; ?>">[?]</span>Εικόνα<span class="mandatory_field">**</span></div><div class="form_right">
		<input class="form_button_choose_file" type="button" value="Επιλέξτε" onclick="javascript:trigger_from_pc();" />
		<input id="my_file_element" name="file_from_pc" type="file" class="choose_file" onchange="javascript:update_file_list(this);" />
	</div>
	<div class="clear"></div>
	<div class="form_left">Αρχείο</div><div class="form_right"><div id="files_list"><img id = "image-preview" src = "#" class = "no-icon" /></div></div>
	<div class="clear"></div>
	<div class="form_unified fill_alias"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_ALIAS; ?>">[?]</span><img src="images/electro_expand.png" class="expand_collapse_attributes expand_collapse" />Γλωσσική Αντιστοίχιση</div>
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
				<div class="form_left">'.stripslashes($result_languages['L_NAME']).'</div><div class="form_right"><input name="mi_title['.$result_languages['L_ID'].']" class="long" type="text"  maxlength="255" /></div>
				<div class="clear"></div>
				';
			}
		}
		include("db_disconnect.php");
	?>
	</div>
	<!-- END: LANGUAGES -->

	<div class="form_unified fill_seo-serp"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_SEO_SERP; ?>">[?]</span><img src="images/electro_expand.png" class="expand_collapse_attributes expand_collapse_seo-serp" />SEO - SERP</div>
	<div class="clear"></div>
	<div id = "seo-serp">
		<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_DESCRIPTION; ?>">[?]</span>description</div><div class="form_right"><input name="mi_meta_description" class="long" type="text" maxlength = "160" /></div>
		<div class="clear"></div>
		<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_CREATE_KEYWORDS; ?>">[?]</span>keywords</div><div class="form_right"><textarea name="mi_meta_keywords" class="long"></textarea></div>
		<div class="clear"></div>
	</div>
	
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>