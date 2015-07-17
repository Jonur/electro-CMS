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
	$sql_edit_a = " SELECT * FROM `articles` WHERE `articles`.A_ID = '$edit_id'";
	
	if(!$query_edit_a = mysql_query($sql_edit_a))
		header('Location: ../electro/');
	while ($a_row = mysql_fetch_array($query_edit_a))
	{
		$a_title = stripslashes($a_row['A_TITLE']);
		$a_body = stripslashes($a_row['A_BODY']);
		$a_mi = $a_row['MI_ID'];
		$a_rank = $a_row['A_RANK'];
		$a_visible = $a_row['A_VISIBLE'];
		$a_direct = $a_row['A_DIRECT'];
		$a_info = stripslashes($a_row['A_INFO']);
		$a_meta_description = stripslashes($a_row['A_META_DESCRIPTION']);
		$a_meta_keywords = stripslashes($a_row['A_META_KEYWORDS']);
	}
	
	//Get languages
	$sql_l = "SELECT * FROM `articles-languages` WHERE A_ID = '$edit_id'";
	$query_l = mysql_query($sql_l) or die(mysql_error());
	$i = 0;
	$a_l[] = 0;
	while ($result_l = mysql_fetch_array($query_l))
	{
		$a_l[$i] = $result_l['L_ID'];
		$i++;
	}
	
	//Check if seo-serp attributes are set
	$seoSerp_id = "seo-serp";
	$seoSerp_img = "images/electro_expand.png";
	if (!empty($a_meta_description) || !empty($a_meta_keywords)){
		$seoSerp_id = "seo-serp_edit";
		$seoSerp_img = "images/electro_collapse.png";
	}
	
	//Get galleries
	$sql_g = "SELECT * FROM `articles-galleries` WHERE A_ID = '$edit_id'";
	$query_g = mysql_query($sql_g) or die(mysql_error());
	$i = 0;
	$a_g = array();
	$gallery_id = "gallery_list";
	$gallery_img = "images/electro_expand.png";
	while ($result_g = mysql_fetch_array($query_g))
	{
		$a_g[$i] = $result_g['G_ID'];
		$i++;
	}
	if (mysql_num_rows($query_g)){
		$gallery_id = "gallery_list_edit";
		$gallery_img = "images/electro_collapse.png";
	}
	
	//Get files
	$sql_f = "SELECT * FROM `articles-files` WHERE A_ID = '$edit_id'";
	$query_f = mysql_query($sql_f) or die(mysql_error());
	$i = 0;
	$a_f[] = array();
	$file_id = "file_list";
	$file_img = "images/electro_expand.png";
	while ($result_f = mysql_fetch_array($query_f))
	{
		$a_f[$i] = $result_f['F_ID'];
		$i++;
	}
	if (mysql_num_rows($query_f)){
		$file_id = "file_list_edit";
		$file_img = "images/electro_collapse.png";
	}
	require("db_disconnect.php");

	$is_visible = "";
	if ($a_visible == 1){
		$is_visible = "CHECKED";
	}
	$is_direct = "";
	if ($a_direct == 1){
		$is_direct = "CHECKED";
	}
	
	$HELP_ARTICLES_EDIT_TITLE = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες. Επίσης, δεν μπορεί να υπάρχει άρθρο με ίδιο τίτλο που να ανήκει στην ίδιο Στοιχείο Μενού.';
	$HELP_ARTICLES_EDIT_INFORMATION = 'Μη υποχρωτικό πεδίο. Σχετικές πληροφορίες άρθρου.';
	$HELP_ARTICLES_EDIT_MENU = 'Υποχρωτικό πεδίο. Αντιστοίχιση του άρθρου με Στοιχείο Μενού στο οποία ανήκει.';
	$HELP_ARTICLES_EDIT_BODY = 'Υποχρεωτικό πεδίο. Το περιεχόμενο του άρθρου.';
	$HELP_ARTICLES_EDIT_LANGUAGES = 'Αντιστοίχιση του άρθρου στις γλώσσες του Στοιχείου Μενού στο οποίο ανήκει.';
	$HELP_ARTICLES_EDIT_RANK = 'Μη υποχρεωτικό πεδίο. Ακέραιος μέχρι και 4 ψηφία (0-9999). Προτεραιότητα κατάταξης του στοιχείου στην ιστοσελίδα.';
	$HELP_ARTICLES_EDIT_VISIBLE = 'Πεδίο ελέγχου. Εμφάνιση ή απόκρυψη του στοιχείου στην ιστοσελίδα.';
	$HELP_ARTICLES_EDIT_DIRECT = 'Πεδίο ελέγχου. Άμεση ή έμμεση εμφάνιση του άρθρου στην ιστοσελίδα. Αν η εμφάνιση ενός άρθρου είναι έμμεση, τότε εμφανίζεται μόνο με άμεσο σύνδεσμο και δεν εμφανίζεται σε λίστες άρθρων.';
	$HELP_ARTICLES_EDIT_SEO_SERP = 'Μη υποχρωτικά πεδία. Καταχώρηση SEO - SERP για το συγκεκριμένο Άρθρο.';
	$HELP_ARTICLES_EDIT_DESCRIPTION = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο 70 - 160 χαρακτήρες.';
	$HELP_ARTICLES_EDIT_KEYWORDS = 'Μη υποχρωτικό πεδίο. Αλφαριθμητικό πεδίο μέχρι 255 χαρακτήρες.';
	$HELP_ARTICLES_EDIT_GALLERIES = 'Αντιστοίχιση του άρθρου με Γκαλερί. Για να δημιουργήσετε γκαλερί επιλέξτε \'Γκαλερί\' από το αριστερό μενού.';
	$HELP_ARTICLES_EDIT_FILES = 'Αντιστοίχιση του άρθρου με Αρχεία. Για να ανεβάσετε αρχεία επιλέξτε \'Αρχεία\' από το αριστερό μενού.';
?>
<div class="breadcrumb">Δημιουργία Περιεχομένου &raquo; Άρθρα &raquo; Επεξεργασία</div>
<?php echo $validation_message; ?>
<form id="valform" name="articles_edit" method="post" action="scripts/articles_update.php?<?php echo $TOOLBOX_SELECTED_OPTIONS; ?>">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_TITLE; ?>">[?]</span>Τίτλος<span class="mandatory_field">*</span></div><div class="form_right"><input name="a_title" class="required long" type="text"  maxlength="255" value="<?php echo $a_title; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_INFORMATION; ?>">[?]</span>Πληροφορίες</div><div class="form_right"><input name="a_info" class="long" type="text"  maxlength="255" value = "<?php echo $a_info; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_MENU; ?>">[?]</span>Μενού<span class="mandatory_field">*</span></div>
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
				echo '<option value="0" SELECTED>Κανένα</option>';
				while($result_mg = mysql_fetch_array($query_mg))
				{
					echo '<optgroup label="'.stripslashes($result_mg['MGL_ALIAS']).'">';
					//START: MENU ITEMS
					$sql_mi_mother = "SELECT * FROM `menu_items` 
									INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID=`menu_items-languages`.MI_ID
									INNER JOIN `menu_groups-menu_items` ON `menu_items`.MI_ID=`menu_groups-menu_items`.MI_ID
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
						if($result_mi_mother['MT_ID'] != '8BPTpENdPB'){
							$is_disabled = "DISABLED";
						}
						$mi_selected = "";
						if($result_mi_mother['MI_ID']== $a_mi){
							$mi_selected = "SELECTED";
						}
						echo '<option value="'.$result_mi_mother['MI_ID'].'" '.$mi_selected.' '.$is_disabled.'>'.$pcs.stripslashes($result_mi_mother['MIL_ALIAS']).'</option>';
						print_structure_article($result_mi_mother['MI_ID'], $pcs.' - - - ',$a_mi);
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
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_BODY; ?>">[?]</span>Κείμενο<span class="mandatory_field">*</span></div><div class="form_right"><textarea name="a_body" class="required jquery_ckeditor" width="500"><?php echo htmlspecialchars($a_body); ?></textarea></div>
	<div class="clear"></div>
	<!-- START: LANGUAGES -->
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_LANGUAGES; ?>">[?]</span>Γλώσσες<span class="mandatory_field">*</span></div><div class="form_right">
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
				$is_selected = "";
				if (in_array($result_languages['L_ID'],$a_l))
					$is_selected = "SELECTED";
				echo '<option value="'.$result_languages['L_ID'].'" '.$is_selected.'>'.stripslashes($result_languages['L_NAME']).'</option>';
			}
			echo '</select>';
		}
		include("db_disconnect.php");
	?>
	</div>
	<div class="clear"></div>
	<!-- END: LANGUAGES -->
	
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_RANK; ?>">[?]</span>Κατάταξη</div><div class="form_right"><input name="a_rank" class="digits short" type="text"  maxlength="4" value="<?php echo $a_rank; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_VISIBLE; ?>">[?]</span>Ορατό</div><div class="form_right"><input name="a_visible" type="checkbox"  value="1" <?php echo $is_visible; ?> /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_DIRECT; ?>">[?]</span>Άμεσο</div><div class="form_right"><input name="a_direct" type="checkbox"  value="1" <?php echo $is_direct; ?> /></div>
	<div class="clear"></div>
	
	<div class="form_unified fill_seo-serp"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_SEO_SERP; ?>">[?]</span><img src="<?php echo $seoSerp_img; ?>" class="expand_collapse_attributes expand_collapse_seo-serp" />SEO - SERP</div>
	<div class="clear"></div>
	<div id = "<?php echo $seoSerp_id; ?>">
		<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_DESCRIPTION; ?>">[?]</span>description</div><div class="form_right"><input name="a_meta_description" class="long" type="text" maxlength = "160" value = "<?php echo $a_meta_description; ?>" /></div>
		<div class="clear"></div>
		<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_KEYWORDS; ?>">[?]</span>keywords</div><div class="form_right"><textarea name="a_meta_keywords" class="long"><?php echo $a_meta_keywords; ?></textarea></div>
		<div class="clear"></div>
	</div>
	
	<div class="form_unified attach_gallery"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_GALLERIES; ?>">[?]</span><img src="<?php echo $gallery_img; ?>" class="expand_collapse_attributes expand_collapse_gallery" />Επισύναψη Γκαλερί</div>
	<div class="clear"></div>
	<!-- START: GALLERIES -->
	<div id="<?php echo $gallery_id; ?>">
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
					$is_selected = "";
					if (in_array($result_gallery['G_ID'],$a_g))
						$is_selected = "SELECTED";
					echo '<option value = "'.$result_gallery['G_ID'].'" '.$is_selected.'>'.stripslashes($result_gallery['GL_ALIAS']).'</option>';
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
	
	<div class="form_unified attach_file"><span class = "electro-tooltip" title = "<?php echo $HELP_ARTICLES_EDIT_FILES; ?>">[?]</span><img src="<?php echo $file_img; ?>" class="expand_collapse_attributes expand_collapse_file" />Επισύναψη Αρχείων</div>
	<div class="clear"></div>
	<!-- START: FILES -->
	<div id="<?php echo $file_id; ?>">
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
					
					$is_selected = "";
					if (in_array($result_file['F_ID'], $a_f)){
						$is_selected = "SELECTED";
					}
					echo '<option value = "'.$result_file['F_ID'].'" '.$is_selected.'>'.$namestring.'</option>';
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
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Αλλαγή" /></div>
	<div class="clear"></div>
</form>