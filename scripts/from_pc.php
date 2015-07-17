<?php 
	require("access_isset.php"); 
	$HELP_GALLERIES_APPEND_FROM_PC_IMAGE = 'Επιτρέπονται μόνο αρχεία τύπου εικόνας (jpg, jpeg, gif, png). Μέγιστο επιτρεπτό μέγεθος αρχείου: 10ΜΒ.';
?>
<div class="breadcrumb">Από Υπολογιστή</div>
<form id = "image-to-gallery" name="form_from_pc" enctype="multipart/form-data" method = "post" action="scripts/galleries_append_from_pc.php">
	<input type="hidden" name="edit_id" value="<?php echo $edit_id; ?>" />
	<div class="form_left"><span class = "electro-tooltip" title = "<?php echo $HELP_GALLERIES_APPEND_FROM_PC_IMAGE; ?>">[?]</span>Επιλέξτε<span class="mandatory_field">*</span></div>
	<div class="form_right">
		<input class="form_button_choose_file" type="button" value="Προσθήκη Αρχείου" onclick="javascript:trigger_from_pc();" />
		<input id="my_file_element" name="file_from_pc" type="file" accept="image/*" class="choose_file" onchange="javascript:update_file_list(this);" />
	</div>
	<div class="form_left">Αρχείο</div><div class="form_right"><div id="files_list"><img id = "image-preview" src = "#" class = "no-icon" /></div></div>
	<div class="form_left">&nbsp;</div><div class="form_right"><input class="form_button" type="submit" value="Ανέβασμα" /></div>
</form>
