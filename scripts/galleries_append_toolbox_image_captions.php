<?php 
	if (!empty($_REQUEST['fid'])){
		$fid = $_REQUEST['fid'];	
	}else{
		//Redirection
		return;
	}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" >
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<!-- Include the CSS files -->
		<link rel="stylesheet" type="text/css" href="../css/electropopupcss.css">
		<!-- Include the JS files -->
		<script type="text/javascript" src="../js/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" src="../js/electro.js"></script>
	</head>
	<body>
		<form id="p_form" name="galleries_append_toolbox_image_captions" class="popup_form" method="post" action="../scripts/galleries_append_toolbox_update_captions.php">
			<input type="hidden" name="fid" value="<?php echo $fid; ?>" />
			<!-- START: LANGUAGES -->
			<?php
				//Get the `languages` from the databases except from the default language
				include("db_connect.php");
				$sql_languages = "SELECT * FROM `languages` ORDER BY L_RANK";
				$query_languages = mysql_query($sql_languages) or die(mysql_error());
				$rows_languages = mysql_num_rows($query_languages);
				if ($rows_languages){
					while($result_languages = mysql_fetch_array($query_languages))
					{
						$field_value = '';
						$sql_fv = "SELECT * FROM `image_captions` WHERE L_ID = '".$result_languages['L_ID']."' AND F_ID = '".$fid."'";
						$query_fv = mysql_query($sql_fv) or die(mysql_error());
						while ($result_fv = mysql_fetch_array($query_fv))
							$field_value = stripslashes($result_fv['IC_ALIAS']);
							
						echo '
						<div class="form_left">'.stripslashes($result_languages['L_NAME']).'</div><div class="form_right"><input name="ic_alias['.$result_languages['L_ID'].']" class="long" type="text"  maxlength="255" value="'.$field_value.'" /></div>
						<div class="clear"></div>
						';
					}
				}
				include("db_disconnect.php");
			?>
			<!-- END: LANGUAGES -->
			<div class="form_left">&nbsp;</div><div class="form_right"><input type="button" class="form_button" value="Καταχώρηση" onclick="submit($('#p_form'));" /></div>
			<div class="clear"></div>
		</form>
	</body>
</html>