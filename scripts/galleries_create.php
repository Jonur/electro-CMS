<?php 
	require("access_isset.php"); 
	$HELP_GALLERIES_CREATE_NAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_GALLERIES_CREATE_MENU = 'Μη υποχρωτικό πεδίο. Αντιστοίχιση της Γκαλερί με Στοιχείο Μενού στο οποία ανήκει.';
	$HELP_GALLERIES_CREATE_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του στοιχείου στην ιστοσελίδα.';
	$HELP_GALLERIES_CREATE_VISIBLE = 'Πεδίο ελέγχου. Εμφάνιση ή απόκρυψη του στοιχείου στην ιστοσελίδα.';
	$HELP_GALLERIES_CREATE_ALIAS = 'Μη υποχρωτικά πεδία. Αλφαριθμητικά μέχρι 255 χαρακτήρες. Αντίστοιχοι τίτλοι του ίδιου στοιχείου στις υπόλοιπες γλώσσες της ιστοσελίδας.';
?>
<div class="breadcrumb">Δημιουργία Περιεχομένου &raquo; Γκαλερί &raquo; Δημιουργία</div>
<?php echo $validation_message; ?>
<form id="valform" name="galleries_create" method="post" action="scripts/galleries_insert.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_CREATE_NAME; ?>">[?]</span>Όνομα<span class="mandatory_field">*</span></div><div class="form_right"><input name="g_name[<?php echo $DLTL; ?>]" class="required long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_CREATE_MENU; ?>">[?]</span>Μενού</div>
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
						echo '<option value="'.$result_mi_mother['MI_ID'].'" '.$is_disabled.'>'.$pcs.stripslashes($result_mi_mother['MIL_ALIAS']).'</option>';
						print_structure_gallery($result_mi_mother['MI_ID'], $pcs.' - - - ');
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
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_CREATE_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="g_rank" class="digits short" type="text"  maxlength="4" value="0" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_CREATE_VISIBLE; ?>">[?]</span>Ορατό</div><div class="form_right"><input name="g_visible" type="checkbox"  value="1" CHECKED /></div>
	<div class="clear"></div>
	<div class="form_unified fill_alias"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_CREATE_ALIAS; ?>">[?]</span><img src="images/electro_expand.png" class="expand_collapse_attributes expand_collapse" />Γλωσσική Αντιστοίχιση</div>
	<div class="clear"></div>
	<!-- START: LANGUAGES -->
	<div id="lang_list">
	<?php
		//Get the `languages` from the databases except from the default language
		include("db_connect.php");
		$sql_languages = "SELECT * FROM `languages` WHERE L_ID <> '$DLTL' AND L_VISIBLE = 1 ORDER BY L_RANK";
		$query_languages = mysql_query($sql_languages) or die(mysql_error());
		$rows_languages = mysql_num_rows($query_languages);
		if ($rows_languages){
			while($result_languages = mysql_fetch_array($query_languages))
			{
				echo '
				<div class="form_left">'.stripslashes($result_languages['L_NAME']).'</div><div class="form_right"><input name="g_name['.$result_languages['L_ID'].']" class="long" type="text"  maxlength="255" /></div>
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