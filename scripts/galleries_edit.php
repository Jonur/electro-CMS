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
	$sql_edit_g = "SELECT * FROM `galleries` INNER JOIN `galleries-languages` ON `galleries`.G_ID = `galleries-languages`.G_ID 
			   WHERE `galleries`.G_ID = '$edit_id' AND `galleries-languages`.L_ID = '$DLTL'";
	if(!$query_edit_g = mysql_query($sql_edit_g))
		header('Location: ../electro/');
	while ($g_row = mysql_fetch_array($query_edit_g))
	{
		$g_mi = $g_row['MI_ID'];
		$g_rank = $g_row['G_RANK'];
		$g_visible = $g_row['G_VISIBLE'];
		$g_alias = stripslashes($g_row['GL_ALIAS']);
	}
	
	//Get languages
	$sql_l = "SELECT * FROM `galleries-languages` WHERE G_ID = '$edit_id' AND L_ID <> '$DLTL'";
	$query_l = mysql_query($sql_l) or die(mysql_error());
	$lang_id = "lang_list";
	$lang_img = "images/electro_expand.png";
	if (mysql_num_rows($query_l)){
		$lang_id = "lang_list_edit";
		$lang_img = "images/electro_collapse.png";
	}
	require("db_disconnect.php");

	$is_visible = "";
	if ($g_visible == 1){
		$is_visible = "CHECKED";
	}
	
	$HELP_GALLERIES_EDIT_NAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_GALLERIES_EDIT_MENU = 'Μη υποχρωτικό πεδίο. Αντιστοίχιση της Γκαλερί με Στοιχείο Μενού στο οποία ανήκει.';
	$HELP_GALLERIES_EDIT_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του στοιχείου στην ιστοσελίδα.';
	$HELP_GALLERIES_EDIT_VISIBLE = 'Πεδίο ελέγχου. Εμφάνιση ή απόκρυψη του στοιχείου στην ιστοσελίδα.';
	$HELP_GALLERIES_EDIT_ALIAS = 'Μη υποχρωτικά πεδία. Αλφαριθμητικά μέχρι 255 χαρακτήρες. Αντίστοιχοι τίτλοι του ίδιου στοιχείου στις υπόλοιπες γλώσσες της ιστοσελίδας.';
?>
<div class="breadcrumb">Δημιουργία Περιεχομένου &raquo; Γκαλερί &raquo; Επεξεργασία</div>
<?php echo $validation_message; ?>
<form id="valform" name="galleries_edit" method="post" action="scripts/galleries_update.php?<?php echo $TOOLBOX_SELECTED_OPTIONS; ?>">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_EDIT_NAME; ?>">[?]</span>Όνομα<span class="mandatory_field">*</span></div><div class="form_right"><input name="g_name[<?php echo $DLTL; ?>]" class="required long" type="text"  maxlength="255" value="<?php echo $g_alias; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_EDIT_MENU; ?>">[?]</span>Μενού</div>
	<div class="form_right">
		<?php
			require("db_connect.php");
			include("functions.php");
			
			$sql_mg = "SELECT * FROM `menu_groups` 
					   INNER JOIN `menu_groups-languages` ON `menu_groups`.MG_ID = `menu_groups-languages`.MG_ID 
					   WHERE `menu_groups-languages`.L_ID = '$DLTL' 
					   AND `menu_groups`.MG_DELETED = 0 
					   ORDER BY `menu_groups`.MG_RANK, `menu_groups-languages`.MGL_ALIAS";
			$query_mg = mysql_query($sql_mg) or die(mysql_error());
			$rows_mg = mysql_num_rows($query_mg);
			if ($rows_mg)
			{
				echo '<select name="g_mi" class="long">';
				echo '<option value="0" SELECTED>Κανένα</option>';
				while($result_mg = mysql_fetch_array($query_mg))
				{
					echo "ENTERED";
					echo '<optgroup label="'.stripslashes($result_mg['MGL_ALIAS']).'">';
					//START: MENU ITEMS
					$sql_mi_mother = "SELECT * FROM `menu_items` 
									INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID = `menu_items-languages`.MI_ID
									INNER JOIN `menu_groups-menu_items` ON `menu_items`.MI_ID = `menu_groups-menu_items`.MI_ID
									WHERE `menu_groups-menu_items`.MG_ID = '".$result_mg['MG_ID']."' 
									AND `menu_items`.MI_DELETED = 0 
									AND `menu_items-languages`.L_ID = '$DLTL' 
									AND (`menu_items`.MI_MOTHER IS NULL OR `menu_items`.MI_MOTHER = '0') 
									ORDER BY `menu_items`.MI_RANK, `menu_items-languages`.MIL_ALIAS";
					$query_mi_mother = mysql_query($sql_mi_mother) or die(mysql_error());
					$pcs = ''; //dashes
					while ($result_mi_mother = mysql_fetch_array($query_mi_mother))
					{	
						$is_disabled = "";
						if($result_mi_mother['MT_ID'] != 'EKatjWfxOt'){
							$is_disabled = "DISABLED";
						}
						$is_selected='';
						if($result_mi_mother['MI_ID'] == $g_mi){
							$is_selected = 'SELECTED';
						}
						
						echo '<option value="'.$result_mi_mother['MI_ID'].'" '.$is_selected.' '.$is_disabled.'>'.$pcs.stripslashes($result_mi_mother['MIL_ALIAS']).'</option>';
						print_structure_gallery($result_mi_mother['MI_ID'], $pcs.' - - - ', $g_mi);
					}
					//END: MENU ITEMS
					echo '</optgroup>';
				}
				echo '</select>';
			}
			require("db_disconnect.php");
		?>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_EDIT_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="g_rank" class="digits short" type="text"  maxlength="4" value="<?php echo $g_rank; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_EDIT_VISIBLE; ?>">[?]</span>Ορατό</div><div class="form_right"><input name="g_visible" type="checkbox"  value="1" <?php echo $is_visible; ?> /></div>
	<div class="clear"></div>
	<div class="form_unified fill_alias"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_EDIT_ALIAS; ?>">[?]</span><img src="<?php echo $lang_img; ?>" class="expand_collapse_attributes expand_collapse" />Γλωσσική Αντιστοίχιση</div>
	<div class="clear"></div>
	<!-- START: LANGUAGES -->
	<div id="<?php echo $lang_id; ?>">
	<?php
		//Get the `languages` from the databases except from the default language
		include("db_connect.php");
		$sql_languages = "SELECT * FROM `languages` WHERE L_ID <> '$DLTL' AND L_VISIBLE = 1 ORDER BY L_RANK";
		$query_languages = mysql_query($sql_languages) or die(mysql_error());
		$rows_languages = mysql_num_rows($query_languages);
		if ($rows_languages){
			while($result_languages = mysql_fetch_array($query_languages))
			{
				$current_l_id = $result_languages['L_ID'];
				$current_l_name = $result_languages['L_NAME'];
				$current_alias = '';
				
				//Adding values if any records in the current language
				$sql_gl = "SELECT * FROM `galleries-languages` WHERE L_ID = '$current_l_id' AND G_ID = '$edit_id'";
				$query_gl = mysql_query($sql_gl); 
				$rows_gl = mysql_num_rows($query_gl);
				if ($rows_gl)
				{
					while($result_gl=mysql_fetch_array($query_gl))
					{
						$current_alias = stripslashes($result_gl['GL_ALIAS']);
					}
				}
				echo '
				<div class="form_left">'.stripslashes($result_languages['L_NAME']).'</div><div class="form_right"><input name="g_name['.$result_languages['L_ID'].']" class="long" type="text"  maxlength="255" value="'.$current_alias.'" /></div>
				<div class="clear"></div>
				';
			}
		}
		include("db_disconnect.php");
	?>
	</div>
	<!-- END: LANGUAGES -->
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αλλαγή" /></div>
	<div class="clear"></div>
</form>