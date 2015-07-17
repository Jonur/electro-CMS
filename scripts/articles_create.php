<?php 
	require("access_isset.php"); 
	
	$HELP_ARTICLES_CREATE_TITLE = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες. Επίσης, δεν μπορεί να υπάρχει άρθρο με ίδιο τίτλο που να ανήκει στην ίδιο Στοιχείο Μενού.';
	$HELP_ARTICLES_CREATE_INFORMATION = 'Μη υποχρωτικό πεδίο. Σχετικές πληροφορίες άρθρου.';
	$HELP_ARTICLES_CREATE_MENU = 'Υποχρωτικό πεδίο. Αντιστοίχιση του άρθρου με Στοιχείο Μενού στο οποία ανήκει.';
	$HELP_ARTICLES_CREATE_BODY = 'Υποχρεωτικό πεδίο. Το περιεχόμενο του άρθρου.';
	$HELP_ARTICLES_CREATE_LANGUAGES = 'Αντιστοίχιση του άρθρου στις γλώσσες του Στοιχείου Μενού στο οποίο ανήκει.';
	$HELP_ARTICLES_CREATE_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του στοιχείου στην ιστοσελίδα.';
	$HELP_ARTICLES_CREATE_VISIBLE = 'Πεδίο ελέγχου. Εμφάνιση ή απόκρυψη του στοιχείου στην ιστοσελίδα.';
	$HELP_ARTICLES_CREATE_DIRECT = 'Πεδίο ελέγχου. Άμεση ή έμμεση εμφάνιση του άρθρου στην ιστοσελίδα. Αν η εμφάνιση ενός άρθρου είναι έμμεση, τότε εμφανίζεται μόνο με άμεσο σύνδεσμο και δεν εμφανίζεται σε λίστες άρθρων.';
	$HELP_ARTICLES_CREATE_SEO_SERP = 'Μη υποχρωτικά πεδία. Καταχώρηση SEO - SERP για το συγκεκριμένο Άρθρο.';
	$HELP_ARTICLES_CREATE_DESCRIPTION = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο 70 - 160 χαρακτήρες.';
	$HELP_ARTICLES_CREATE_KEYWORDS = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο μέχρι 255 χαρακτήρες.';
	$HELP_ARTICLES_CREATE_GALLERIES = 'Αντιστοίχιση του άρθρου με Γκαλερί. Για να δημιουργήσετε γκαλερί επιλέξτε \'Γκαλερί\' από το αριστερό μενού.';
	$HELP_ARTICLES_CREATE_FILES = 'Αντιστοίχιση του άρθρου με Αρχεία. Για να ανεβάσετε αρχεία επιλέξτε \'Αρχεία\' από το αριστερό μενού.';
?>
<div class="breadcrumb">Δημιουργία Περιεχομένου &raquo; Άρθρα &raquo; Δημιουργία</div>
<?php echo $validation_message; ?>
<form id="valform" name="articles_create" method="post" action="scripts/articles_insert.php">
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_TITLE; ?>">[?]</span>Τίτλος<span class="mandatory_field">*</span></div><div class="form_right"><input name="a_title" class="required long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_INFORMATION; ?>">[?]</span>Πληροφορίες</div><div class="form_right"><input name="a_info" class="long" type="text"  maxlength="255" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_MENU; ?>">[?]</span>Μενού<span class="mandatory_field">*</span></div>
	<div class="form_right">
		<?php
			require("db_connect.php");
			include("functions.php");
			
			$sql_mg = "SELECT * FROM `menu_groups` 
					   INNER JOIN `menu_groups-languages` ON `menu_groups`.MG_ID=`menu_groups-languages`.MG_ID 
					   WHERE `menu_groups-languages`.L_ID = '$DLTL' 
					   AND `menu_groups`.MG_DELETED = 0 
					   ORDER BY `menu_groups`.MG_RANK, `menu_groups-languages`.MGL_ALIAS";
			$query_mg = mysql_query($sql_mg) or die(mysql_error());
			$rows_mg = mysql_num_rows($query_mg);
			if ($rows_mg)
			{
				echo '<select name="a_mi" class="required long">';
				echo '<option value="0">Κανένα</option>';
				while($result_mg = mysql_fetch_array($query_mg))
				{
					echo '<optgroup label="'.stripslashes($result_mg['MGL_ALIAS']).'">';
					//START: MENU ITEMS
					$sql_mi_mother = "SELECT * FROM `menu_items` 
									INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID
									INNER JOIN `menu_groups-menu_items` ON `menu_items`.MI_ID=`menu_groups-menu_items`.MI_ID
									WHERE `menu_groups-menu_items`.MG_ID='".$result_mg['MG_ID']."' 							
									AND `menu_items`.MI_DELETED = 0 
									AND `menu_items-languages`.L_ID = '$DLTL'  
									AND (`menu_items`.MI_MOTHER IS NULL OR `menu_items`.MI_MOTHER = '0') 
									ORDER BY `menu_items`.MI_RANK, `menu_items-languages`.MIL_ALIAS";
					$query_mi_mother = mysql_query($sql_mi_mother) or die(mysql_error());
					$pcs = ''; //dashes
					while ($result_mi_mother = mysql_fetch_array($query_mi_mother))
					{
						$is_disabled = "";
						if($result_mi_mother['MT_ID'] != '8BPTpENdPB'){
							$is_disabled = "DISABLED";
						}
						echo '<option value="'.$result_mi_mother['MI_ID'].'" '.$is_disabled.'>'.$pcs.stripslashes($result_mi_mother['MIL_ALIAS']).'</option>';
						print_structure_article($result_mi_mother['MI_ID'], $pcs.' - - - ');
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
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_BODY; ?>">[?]</span>Κείμενο<span class="mandatory_field">*</span></div><div class="form_right"><textarea name="a_body" class="required jquery_ckeditor" width="500"></textarea></div>
	<div class="clear"></div>
	<!-- START: LANGUAGES -->
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_LANGUAGES; ?>">[?]</span>Γλώσσες<span class="mandatory_field">*</span></div><div class="form_right">
	<?php
		//Get the `languages` from the databases except from the default language
		include("db_connect.php");
		$sql_languages = "SELECT * FROM `languages` WHERE L_VISIBLE = 1 ORDER BY L_RANK";
		$query_languages = mysql_query($sql_languages) or die(mysql_error());
		$rows_languages = mysql_num_rows($query_languages);
		if ($rows_languages)
		{	
			echo '<select name="a_lang[]" class="required multishort" multiple>';
			while($result_languages = mysql_fetch_array($query_languages))
			{
				echo '<option value="'.$result_languages['L_ID'].'">'.stripslashes($result_languages['L_NAME']).'</option>';
			}
			echo '</select>';
		}
		include("db_disconnect.php");
	?>
	</div>
	<div class="clear"></div>
	<!-- END: LANGUAGES -->
	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="a_rank" class="digits short" type="text"  maxlength="4" value="0" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_VISIBLE; ?>">[?]</span>Ορατό</div><div class="form_right"><input name="a_visible" type="checkbox"  value="1" CHECKED /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_DIRECT; ?>">[?]</span>Άμεσο</div><div class="form_right"><input name="a_direct" type="checkbox"  value="1" CHECKED /></div>
	<div class="clear"></div>
	
	<div class="form_unified fill_seo-serp"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_SEO_SERP; ?>">[?]</span><img src="images/electro_expand.png" class="expand_collapse_attributes expand_collapse_seo-serp" />SEO - SERP</div>
	<div class="clear"></div>
	<div id = "seo-serp">
		<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_DESCRIPTION; ?>">[?]</span>description</div><div class="form_right"><input name="a_meta_description" class="long" type="text" maxlength = "160" /></div>
		<div class="clear"></div>
		<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_KEYWORDS; ?>">[?]</span>keywords</div><div class="form_right"><textarea name="a_meta_keywords" class="long"></textarea></div>
		<div class="clear"></div>
	</div>
	
	<div class="form_unified attach_gallery"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_GALLERIES; ?>">[?]</span><img src="images/electro_expand.png" class="expand_collapse_attributes expand_collapse_gallery" />Επισύναψη Γκαλερί</div>
	<div class="clear"></div>
	<!-- START: GALLERIES -->
	<div id="gallery_list">
		<?php
			include("db_connect.php");
			$sql_gallery = "SELECT * FROM `galleries` 
							INNER JOIN `galleries-languages` ON `galleries`.G_ID = `galleries-languages`.G_ID 
							WHERE `galleries`.G_DELETED = 0 AND `galleries-languages`.L_ID = '$DLTL'";
			$query_gallery = mysql_query($sql_gallery) or die(mysql_error());
			$rows_gallery = mysql_num_rows($query_gallery);
			if ($rows_gallery)
			{
				echo '<div class="form_left">Επιλέξτε:</div><div class="form_right">';
				echo '<select name="a_gallery[]" class="multilong" multiple>';
				while($result_gallery = mysql_fetch_array($query_gallery))
				{
					echo '<option value = "'.$result_gallery['G_ID'].'">'.stripslashes($result_gallery['GL_ALIAS']).'</option>';
				}
				echo '</select>';
			}else{
				echo '<div class="form_left"></div><div class="form_right">Δεν υπάρχουν διαθέσιμες Γκαλερί για αντιστοίχιση.';
			}
			include("db_disconnect.php");
		?>
		</div>
		<div class="clear"></div>
	</div>
	<!-- END: GALLERIES -->
	
	<div class="form_unified attach_file"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_CREATE_FILES; ?>">[?]</span><img src="images/electro_expand.png" class="expand_collapse_attributes expand_collapse_file" />Επισύναψη Αρχείων</div>
	<div class="clear"></div>
	<!-- START: FILES -->
	<div id="file_list">
		<?php
			include("db_connect.php");
			$sql_file = "SELECT * FROM `files` 
						WHERE F_DELETED = 0 
						AND NOT F_FILETYPE IN ('.jpg','.jpeg','.gif','.png')";
			$query_file = mysql_query($sql_file) or die(mysql_error());
			$rows_file = mysql_num_rows($query_file);
			if ($rows_file)
			{
				echo '<div class="form_left">Επιλέξτε:</div><div class="form_right">';
				echo '<select name="a_file[]" class="multilong" multiple>';
				while($result_file = mysql_fetch_array($query_file))
				{
					$namestring = 'Ανώνυμο';
					if (stripslashes($result_file['F_NAME']))
						$namestring = stripslashes($result_file['F_NAME']);
					echo '<option value = "'.$result_file['F_ID'].'">'.$namestring.'</option>';
				}
				echo '</select>';
			}else{
				echo '<div class="form_left"></div><div class="form_right">Δεν υπάρχουν διαθέσιμα Αρχεία προς αντιστοίχιση.';
			}
			include("db_disconnect.php");
		?>
		</div>
		<div class="clear"></div>
	</div>
	<!-- END: FILES -->
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>