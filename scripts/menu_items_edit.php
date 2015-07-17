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
	if (!empty($_REQUEST['tl'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tl='.$_REQUEST['tl'];
	}
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	if (!empty($_REQUEST['tmg'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tmg='.$_REQUEST['tmg'];
	}
	
	require("db_connect.php");
	$sql_edit_mi = "SELECT * FROM `menu_items` 
					INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID
					INNER JOIN `menu_groups-menu_items` ON `menu_items`.MI_ID=`menu_groups-menu_items`.MI_ID 
					WHERE `menu_items`.MI_ID = '$edit_id' 
					AND `menu_items-languages`.L_ID = '$DLTL'";
	if(!$query_edit_mi = mysql_query($sql_edit_mi))
		header('Location: ../electro/');
	while ($mi_row = mysql_fetch_array($query_edit_mi))
	{	
		$mi_mg = $mi_row['MG_ID'];
		$mi_mother = $mi_row['MI_MOTHER'];
		$mi_type = $mi_row['MT_ID'];
		$mi_rank = $mi_row['MI_RANK'];
		$mi_visible = $mi_row['MI_VISIBLE'];
		$mi_alias = stripslashes($mi_row['MIL_ALIAS']);
		$mi_extrainfo = stripslashes($mi_row['MI_EXTRAINFO']);
		$mi_photo = '';
		if ($mi_row['MI_PHOTO'])
		{
			$mi_photo = '
				<a href="'.$local_menu_item_path.$mi_row['MI_PHOTO'].'" rel="shadowbox">	
					<img class="preview_mi_img" src="'.$local_menu_item_path.$mi_row['MI_PHOTO'].'" />
				</a>
				';
			if (!file_exists($local_menu_item_path.$mi_row['MI_PHOTO']))
				$mi_photo = '<span class="mandatory_field">Παρουσιάστηκε σφάλμα στην τοποθεσία του αρχείου.</span>';
		}
		$mi_meta_description = stripslashes($mi_row['MI_META_DESCRIPTION']);
		$mi_meta_keywords = stripslashes($mi_row['MI_META_KEYWORDS']);
	}
	require("db_disconnect.php");

	//Check if seo-serp attributes are set
	$seoSerp_id = "seo-serp";
	$seoSerp_img = "images/electro_expand.png";
	if (!empty($mi_meta_description) || !empty($mi_meta_keywords)){
		$seoSerp_id = "seo-serp_edit";
		$seoSerp_img = "images/electro_collapse.png";
	}
	
	$is_visible = "";
	if ($mi_visible == 1){
		$is_visible = "CHECKED";
	}
	
	$HELP_MENU_ITEMS_EDIT_TITLE = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες. Επίσης, δεν μπορεί να υπάρχει Στοιχείο Μενού με ίδιο τίτλο στο ίδιο επίπεδο Υπομενού.';
	$HELP_MENU_ITEMS_EDIT_MENU_GROUPS = 'Υποχρωτικό πεδίο. Αντιστοίχιση του στοιχείου με ομάδα μενού στην οποία ανήκει.';
	$HELP_MENU_ITEMS_EDIT_SUBMENU = 'Μη υποχρωτικό πεδίο. Σχήμα δένδρου μένου. Αντιστοίχιση του στοιχείου με Στοιχείο Μενού στο οποία ανήκει.';
	$HELP_MENU_ITEMS_EDIT_TYPE = 'Υποχρεωτικό πεδίο. Δηλώνει τον τύπο περιεχομένου του Στοιχείου Μενού.';
	$HELP_MENU_ITEMS_EDIT_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του στοιχείου στην ιστοσελίδα.';
	$HELP_MENU_ITEMS_EDIT_VISIBLE = 'Πεδίο ελέγχου. Εμφάνιση ή απόκρυψη του στοιχείου στην ιστοσελίδα.';
	$HELP_MENU_ITEMS_EDIT_INFORMATION = 'Μη υποχρεωτικό πεδίο. Σχετικές πληροφορίες ή περιγραφή του Στοιχείου Μενού.';
	$HELP_MENU_ITEMS_EDIT_IMAGE = 'Μη υποχρεωτικό πεδίο. Αντιστοίχιση του Στοιχείου Μενού με εικόνα. Επιτρέπονται μόνο αρχεία τύπου εικόνας (jpg, jpeg, gif, png). Μέγιστο επιτρεπτό μέγεθος αρχείου: 10ΜΒ.';
	$HELP_MENU_ITEMS_EDIT_ALIAS = 'Μη υποχρωτικά πεδία. Αλφαριθμητικά μέχρι 255 χαρακτήρες. Αντίστοιχοι τίτλοι του ίδιου στοιχείου στις υπόλοιπες γλώσσες της ιστοσελίδας.';
	$HELP_MENU_ITEMS_EDIT_SEO_SERP = 'Μη υποχρωτικά πεδία. Καταχώρηση SEO - SERP για το συγκεκριμένο Στοιχείο Μενού.';
	$HELP_MENU_ITEMS_EDIT_DESCRIPTION = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο 70 - 160 χαρακτήρες.';
	$HELP_MENU_ITEMS_EDIT_KEYWORDS = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο μέχρι 255 χαρακτήρες.';
?>
<div class="breadcrumb">Δημιουργία Μενού &raquo; Στοιχεία Μενού  &raquo; Επεξεργασία</div>
<?php echo $validation_message; ?>
<form id="valform" name="menu_items_edit" method="post" enctype="multipart/form-data" action="scripts/menu_items_update.php?<?php echo $TOOLBOX_SELECTED_OPTIONS; ?>">
	<input type="hidden" id="edit_id" name="edit_id" value="<?php echo $edit_id; ?>" />
	<input class="mother_id" type="hidden" name="mother_id" value="<?php echo $mi_mother; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_TITLE; ?>">[?]</span>Τίτλος<span class="mandatory_field">*</span></div><div class="form_right"><input name="mi_title[<?php echo $DLTL; ?>]" class="required long" type="text"  maxlength="255"  value="<?php echo $mi_alias; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_MENU_GROUPS; ?>">[?]</span>Ομάδα Μενού<span class="mandatory_field">*</span></div>
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
					$mg_selected = "";
					if($result_mg['MG_ID']== $mi_mg){
						$mg_selected = "SELECTED";
					}
					echo '<option value="'.$result_mg['MG_ID'].'" '.$mg_selected.'>'.stripslashes($result_mg['MGL_ALIAS']).'</option>';
				}
				require("db_disconnect.php");
			  ?>
			</optgroup>
		</select>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_SUBMENU; ?>">[?]</span>Υπομενού του:</div>
	<div class="form_right" id="items_structure" >
		<!-- Ajax content -->
		<span class="">---Παρακαλώ επιλέξτε Ομάδα Μενού---</span>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_TYPE; ?>">[?]</span>Τύπος<span class="mandatory_field">*</span></div>
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
					$mi_type_selected = "";
					if($result_mt['MT_ID']== $mi_type){
						$mi_type_selected = "SELECTED";
					}
					
					echo ' <option value="'.$result_mt['MT_ID'].'" '.$mi_type_selected.'>'.stripslashes($result_mt['MT_TYPE']).'</option>';
				}
				require("db_disconnect.php");
			  ?>
			</optgroup>
		</select>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="mi_rank" class="digits short" type="text"  maxlength="4"  value="<?php echo $mi_rank; ?>"/></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_VISIBLE; ?>">[?]</span>Ορατό</div><div class="form_right"><input name="mi_visible" type="checkbox"  value="1" <?php echo $is_visible; ?> /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_INFORMATION; ?>">[?]</span>Πληροφορίες</div><div class="form_right"><input name="mi_extrainfo" class="long" type="text"  maxlength="255"  value="<?php echo $mi_extrainfo; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_IMAGE; ?>">[?]</span>Εικόνα<span class="mandatory_field">**</span></div><div class="form_right">
		<input class="form_button_choose_file" type="button" value="Επιλέξτε" onclick="javascript:trigger_from_pc();" />
		<input id="my_file_element" name="file_from_pc" type="file" class="choose_file" onchange="javascript:update_file_list(this);" />
	</div>
	<div class="clear"></div>
	<div class="form_left">Αρχείο</div><div class="form_right">
		<div id="files_list"><?php echo $mi_photo; ?></div>
	</div>
	<div class="clear"></div>
	<!-- START: LANGUAGES -->
	<?php
		//Get the `languages` from the databases except from the default language
		include("db_connect.php");
		$sql_languages = "SELECT * FROM `languages` WHERE `languages`.L_ID<>'$DLTL' AND L_VISIBLE = 1 ORDER BY L_RANK";
		$query_languages = mysql_query($sql_languages) or die(mysql_error());
		$rows_languages = mysql_num_rows($query_languages);
		if ($rows_languages)
		{
			//Getting if any records in other languages
			$sql_mil_exist = "SELECT * FROM `menu_items-languages` WHERE L_ID<>'$DLTL' AND MI_ID='$edit_id'";
			$query_mil_exist = mysql_query($sql_mil_exist); 
			$rows_mil_exist = mysql_num_rows($query_mil_exist);
			if ($rows_mil_exist)
			{
				echo '
				<div class="form_unified fill_alias"><span class = "electro-tooltip" title = "'.$HELP_MENU_ITEMS_EDIT_ALIAS.'">[?]</span><img src="images/electro_collapse.png" class="expand_collapse_attributes expand_collapse" />Γλωσσική Αντιστοίχιση</div>
				<div class="clear"></div>
				<div id="lang_list_edit">';
			}else{
				echo '
				<div class="form_unified fill_alias"><span class = "electro-tooltip" title = "'.$HELP_MENU_ITEMS_EDIT_ALIAS.'>">[?]</span><img src="images/electro_expand.png" class="expand_collapse_attributes expand_collapse" />Γλωσσική Αντιστοίχιση</div>
				<div class="clear"></div>
				<div id="lang_list">';
			}
			
			//Presenting all languages
			while($result_languages = mysql_fetch_array($query_languages))
			{
				$current_l_id = $result_languages['L_ID'];
				$current_l_name = stripslashes($result_languages['L_NAME']);
				$current_alias = '';
				
				//Adding values if any records in the current language
				$sql_mil = "SELECT * FROM `menu_items-languages` WHERE L_ID='$current_l_id' AND MI_ID='$edit_id'";
				$query_mil = mysql_query($sql_mil); 
				$rows_mil = mysql_num_rows($query_mil);
				if ($rows_mil)
				{
					while($result_mil=mysql_fetch_array($query_mil))
					{
						$current_alias = stripslashes($result_mil['MIL_ALIAS']);
					}
				}
				echo '
				<div class="form_left">'.$current_l_name.'</div><div class="form_right"><input name="mi_title['.$current_l_id.']" class="long" type="text"  maxlength="255" value="'.$current_alias.'" /></div>
				<div class="clear"></div>
				';
			}
			
			echo '</div>';
		}
		include("db_disconnect.php");	
	?>
	<!-- END: LANGUAGES -->
	
	<div class="form_unified fill_seo-serp"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_SEO_SERP; ?>">[?]</span><img src="<?php echo $seoSerp_img; ?>" class="expand_collapse_attributes expand_collapse_seo-serp" />SEO - SERP</div>
	<div class="clear"></div>
	<div id = "<?php echo $seoSerp_id; ?>">
		<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_DESCRIPTION; ?>">[?]</span>description</div><div class="form_right"><input name="mi_meta_description" class="long" type="text" maxlength = "160" value = "<?php echo $mi_meta_description; ?>" /></div>
		<div class="clear"></div>
		<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_ITEMS_EDIT_KEYWORDS; ?>">[?]</span>keywords</div><div class="form_right"><textarea name="mi_meta_keywords" class="long"><?php echo $mi_meta_keywords; ?></textarea></div>
		<div class="clear"></div>
	</div>
	
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αλλαγή" /></div>
	<div class="clear"></div>
</form>