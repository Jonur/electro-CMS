<?php require("access_isset.php"); ?>
<form class = "valform_rank" name="galleries_append_toolbox_showrank" method="post" action="scripts/galleries_append_toolbox_updaterank.php">
	<input type="hidden" name="gid" value="<?php echo $gid; ?>" />
	<input type="hidden" name="fid" value="<?php echo $fid; ?>" />
	<input name="gf_rank" class="digits tiny" type="text"  maxlength="4" value="<?php echo $gf_rank; ?>" />
	<input type="submit" class="form_button_tiny" value="ΟΚ" />
	<span class="error_output file_error"></span>
</form>