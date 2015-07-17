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
	if (!empty($_REQUEST['ft'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&ft='.$_REQUEST['ft'];
	}
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	require("db_connect.php");
	$sql_edit_f = "SELECT * FROM `files` WHERE F_ID = '$edit_id'";
	if(!$query_edit_f = mysql_query($sql_edit_f))
		header('Location: ../electro/');
	$f_mi = '';
	while ($f_row = mysql_fetch_array($query_edit_f))
	{
		$f_rank = $f_row['F_RANK'];
		$f_mi = $f_row['MI_ID'];
		$f_name = stripslashes($f_row['F_NAME']);
	}
	$mi_list = "mi_list";
	$mi_img = "images/electro_expand.png";
	if ($f_mi){
		$mi_list = "mi_list_edit";
		$mi_img = "images/electro_collapse.png";
	}
	require("db_disconnect.php");
	
	$HELP_FILES_EDIT_NAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_FILES_EDIT_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του αρχείου στην ιστοσελίδα.';
	$HELP_FILES_EDIT_MENU = 'Μη υποχρωτικό πεδίο. Αντιστοίχιση του αρχείου με Στοιχείο Μενού.';
?>
<div class="breadcrumb">Δημιουργία Περιεχομένου &raquo; Αρχεία &raquo; Επεξεργασία</div>
<?php echo $validation_message; ?>
<form id="valform" name="files_edit" method="post" action="scripts/files_update.php?<?php echo $TOOLBOX_SELECTED_OPTIONS; ?>">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_FILES_EDIT_NAME; ?>">[?]</span>Όνομα<span class="mandatory_field">*</span></div><div class="form_right"><input name="f_name" class="required long" type="text"  maxlength="255" value="<?php echo $f_name; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_FILES_EDIT_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="f_rank" class="digits short" type="text"  maxlength="4" value="<?php echo $f_rank; ?>" /></div>
	<div class="clear"></div>
	<div class="form_unified_file"><span class = "electro-tooltip" title = "<?php echo $HELP_FILES_EDIT_MENU; ?>">[?]</span><img src="<?php echo $mi_img; ?>" class="expand_collapse_attributes expand_collapse" />Αντιστοίχιση Με Στοιχείο Μενού</div>
	<div class="clear"></div>
	<!-- START: MENU -->
	<div id="<?php echo $mi_list; ?>">
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
					echo '<div class="form_left">Επιλέξτε:</div><div class="form_right">';
					echo '<select name="f_mi" class="long">';
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
							if($result_mi_mother['MT_ID'] != 'ZS4z2y9E5F'){
								$is_disabled = "DISABLED";
							}
							$is_selected = "";
							if($result_mi_mother['MI_ID'] == $f_mi){
								$is_selected = "SELECTED";
							}
							echo '<option value="'.$result_mi_mother['MI_ID'].'" '.$is_disabled.' '.$is_selected.'>'.$pcs.stripslashes($result_mi_mother['MIL_ALIAS']).'</option>';
							print_structure_gallery($result_mi_mother['MI_ID'], $pcs.' - - - ', $f_mi);
						}
						//END: MENU ITEMS
						echo '</optgroup>';
					}
					echo '</select>';
				}else{
					echo '<div class="form_left"></div><div class="form_right">Δεν υπάρχουν διαθέσιμα Στοιχεία Μενού προς αντιστοίχιση.';
				}
				require("db_disconnect.php");
			?>
			</div>
		<div class="clear"></div>
	</div>
	<!-- END: MENU -->
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αλλαγή" /></div>
	<div class="clear"></div>
</form>