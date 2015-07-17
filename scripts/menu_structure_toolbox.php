<?php 
	//Get toolbar values
	$TOOLBOX_FILE = 'menu_structure';
	
	$TOOLBAR_LANG = $DLTL;
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	
	if (!empty($_REQUEST['tl'])){
		$TOOLBAR_LANG = $_REQUEST['tl'];
		$TOOLBOX_SELECTED_OPTIONS .= '&tl='.$_REQUEST['tl'];
	}
?>
<div id = "toolbar">
	<select id = "lang" title = "Επιλογή γλώσσας αποτελεσμάτων" onchange = "javascript:refreshListMS('<?php echo $TOOLBOX_FILE; ?>', this.value);">
		<?php
			require_once("db_connect.php"); 
			$sql_l = "SELECT * FROM `languages` WHERE L_VISIBLE = 1 ORDER BY L_RANK";
			$query_l = mysql_query($sql_l) or die(mysql_error());
			while($result_l = mysql_fetch_array($query_l)){
				$lang_selected = '';
				if ($TOOLBAR_LANG == $result_l['L_ID']){
					$lang_selected = 'SELECTED';
				}
				echo '<option value = "'.$result_l['L_ID'].'" '.$lang_selected.'>'.stripslashes($result_l['L_NAME']).'</option>';
			}
			require_once("db_disconnect.php");
		?>
	</select>
	
	<div class = "clear"></div>
</div>
<div class="clear"></div>