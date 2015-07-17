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
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	require("db_connect.php");
	$sqp_edit_c = "SELECT * FROM `contestants` 
				   INNER JOIN `polls-contestants` ON `contestants`.C_ID = `polls-contestants`.C_ID 
				   INNER JOIN `polls` ON `polls-contestants`.P_ID = `polls`.P_ID 
				   WHERE `contestants`.C_ID = '$edit_id'";
	if(!$query_edit_c = mysql_query($sqp_edit_c))
		header('Location: ../electro/');
	while ($c_row = mysql_fetch_array($query_edit_c))
	{
		$c_name = stripslashes($c_row['C_NAME']);
		$c_info = stripslashes($c_row['C_INFO']);
		$c_url = stripslashes($c_row['C_URL']);
		$p_id = $c_row['P_ID'];
		$pc_votes = $c_row['PC_VOTES'];
		$p_title = stripslashes($c_row['P_TITLE']);
	}
	require("db_disconnect.php");
	
	$HELP_CONTESTANTS_EDIT_NAME = 'Υποχρεωτικό πεδίο. Αλφαριθμητικό μέχρι 255 χαρακτήρες.';
	$HELP_CONTESTANTS_EDIT_POLLS = 'Υποχρεωτικό πεδίο. Επιλογή απο λίστα.';
	$HELP_CONTESTANTS_EDIT_URL = 'Μη υποχρεωτικό πεδίο. Σύνδεσμος του συμμετέχοντος.';
	$HELP_CONTESTANTS_EDIT_INFO = 'Μη υποχρετικό πεδίο. Λεπτομέρειες του συμμετέχοντος.';
?>
<div class="breadcrumb">Διαγωνισμοί &raquo; Συμμετέχοντες &raquo; Επεξεργασία</div>
<?php echo $validation_message; ?>
<form id="valform" name="contestants_edit" method="post" action="scripts/contestants_update.php?<?php echo $TOOLBOX_SELECTED_OPTIONS; ?>">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_CONTESTANTS_EDIT_NAME; ?>">[?]</span>Όνομα<span class="mandatory_field">*</span></div><div class="form_right"><input name="c_name" class="required long" type="text"  maxlength="255" value="<?php echo $c_name; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_CONTESTANTS_EDIT_POLLS; ?>">[?]</span>Διαγωνισμός</div>
	<div class="form_right">
		<?php
			if ($pc_votes)
			{
				echo '<input name="p_title" class="long readonly" type="text"  maxlength="255" value="'.$p_title.'" readonly />';
			}else{
				//Get the `polls`
				include("db_connect.php");
				$sql_p = "SELECT * FROM `polls` ORDER BY P_TITLE";
				$query_p = mysql_query($sql_p) or die(mysql_error());
				$rows_p = mysql_num_rows($query_p);
				if ($rows_p)
				{	
					echo '<select name="p_id" class="required long">';
					while($result_p = mysql_fetch_array($query_p))
					{
						$is_selected = '';
						if ($p_id == $result_p['P_ID'])
							$is_selected = "SELECTED";
						echo '<option value="'.$result_p['P_ID'].'" '.$is_selected.'>'.stripslashes($result_p['P_TITLE']).'</option>';
					}
					echo '</select>';
				}
				include("db_disconnect.php");
			}
		?>
	</div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_CONTESTANTS_EDIT_URL; ?>">[?]</span>URL</div><div class="form_right"><input name="c_url" class="url long" type="text"  maxlength="255" value="<?php echo $c_url; ?>" /></div>
	<div class="clear"></div>
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_CONTESTANTS_EDIT_INFO; ?>">[?]</span>Λεπτομέρειες</div><div class="form_right"><textarea name="c_info" class="required jquery_ckeditor" width="500"><?php echo $c_info; ?></textarea></div>
	<div class="clear"></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input type="submit" class="form_button" value="Καταχώρηση" /></div>
	<div class="clear"></div>
</form>