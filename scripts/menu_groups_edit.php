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
	
	require("db_connect.php");
	$sql_edit_mg = "SELECT * FROM `menu_groups` INNER JOIN `menu_groups-languages` ON `menu_groups`.MG_ID=`menu_groups-languages`.MG_ID 
			   WHERE `menu_groups`.MG_ID = '$edit_id' AND `menu_groups-languages`.L_ID = '$DLTL'";
	if(!$query_edit_mg = mysql_query($sql_edit_mg))
		header('Location: ../electro/');
	while ($mg_row = mysql_fetch_array($query_edit_mg))
	{
		$mg_rank = $mg_row['MG_RANK'];
		$mg_visible = $mg_row['MG_VISIBLE'];
		$mg_alias = stripslashes($mg_row['MGL_ALIAS']);
	}
	require("db_disconnect.php");

	$is_visible = "";
	if ($mg_visible == 1){
		$is_visible = "CHECKED";
	}
	
	$HELP_MENU_GROUPS_EDIT_TITLE = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_MENU_GROUPS_EDIT_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του στοιχείου στην ιστοσελίδα.';
	$HELP_MENU_GROUPS_EDIT_VISIBLE = 'Πεδίο ελέγχου. Εμφάνιση ή απόκρυψη του στοιχείου στην ιστοσελίδα.';
	$HELP_MENU_GROUPS_EDIT_ALIAS = 'Μη υποχρωτικά πεδία. Αλφαριθμητικά μέχρι 255 χαρακτήρες. Αντίστοιχοι τίτλοι του ίδιου στοιχείου στις υπόλοιπες γλώσσες της ιστοσελίδας.';
?>
<div class="breadcrumb">Δημιουργία Μενού &raquo; Ομάδες Μενού  &raquo; Επεξεργασία</div>
<?php echo $validation_message; ?>
<form id="valform" name="menu_groups_edit" method="post" action="scripts/menu_groups_update.php?<?php echo $TOOLBOX_SELECTED_OPTIONS; ?>">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_GROUPS_EDIT_TITLE; ?>">[?]</span>Τίτλος<span class="mandatory_field">*</span></div><div class="form_right"><input name="mg_title[<?php echo $DLTL; ?>]" class="required long" type="text"  maxlength="255" value="<?php echo $mg_alias; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_GROUPS_EDIT_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="mg_rank" class=" digits short" type="text"  maxlength="4" value="<?php echo $mg_rank; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_MENU_GROUPS_EDIT_VISIBLE; ?>">[?]</span>Ορατό</div><div class="form_right"><input name="mg_visible" type="checkbox"  value="1" <?php echo $is_visible; ?> /></div>
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
			$sql_mgl_exist = "SELECT * FROM `menu_groups-languages` WHERE L_ID<>'$DLTL' AND MG_ID='$edit_id'";
			$query_mgl_exist = mysql_query($sql_mgl_exist); 
			$rows_mgl_exist = mysql_num_rows($query_mgl_exist);
			if ($rows_mgl_exist)
			{
				echo '
				<div class="form_unified fill_alias"><span class = "electro-tooltip" title = "'.$HELP_MENU_GROUPS_EDIT_ALIAS.'">[?]</span><img src="images/electro_collapse.png" class="expand_collapse_attributes expand_collapse" />Γλωσσική Αντιστοίχιση</div>
				<div class="clear"></div>
				<div id="lang_list_edit">';
			}else{
				echo '
				<div class="form_unified fill_alias"><span class = "electro-tooltip" title = "'.$HELP_MENU_GROUPS_EDIT_ALIAS.'">[?]</span><img src="images/electro_expand.png" class="expand_collapse_attributes expand_collapse" />Γλωσσική Αντιστοίχιση</div>
				<div class="clear"></div>
				<div id="lang_list">';
			}
			
			//Presenting all languages
			while($result_languages = mysql_fetch_array($query_languages))
			{
				$current_l_id = $result_languages['L_ID'];
				$current_l_name = $result_languages['L_NAME'];
				$current_alias = '';
				
				//Adding values if any records in the current language
				$sql_mgl = "SELECT * FROM `menu_groups-languages` WHERE L_ID='$current_l_id' AND MG_ID='$edit_id'";
				$query_mgl = mysql_query($sql_mgl); 
				$rows_mgl = mysql_num_rows($query_mgl);
				if ($rows_mgl)
				{
					while($result_mgl=mysql_fetch_array($query_mgl))
					{
						$current_alias = stripslashes($result_mgl['MGL_ALIAS']);
					}
				}
				echo '
				<div class="form_left">'.$current_l_name.'</div><div class="form_right"><input name="mg_title['.$current_l_id.']" class="long" type="text"  maxlength="255" value="'.$current_alias.'" /></div>
				<div class="clear"></div>
				';
			}
			
			echo '</div>';
		}
		include("db_disconnect.php");	
	?>
	<!-- END: LANGUAGES -->
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αλλαγή" /></div>
	<div class="clear"></div>
</form>