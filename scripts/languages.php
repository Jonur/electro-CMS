<?php require("access_isset.php"); ?>
<div class="breadcrumb">Πρόσθετα &raquo; Γλώσσες</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=languages_create'">Δημιουργία</button>
<?php
	echo $validation_message;
	require_once("languages_toolbox.php");
	
	//Newsletter members listing
	require("db_connect.php");
	$sql_l = "SELECT *FROM `languages` ORDER BY $mysql_order_by ";
	$query_l = mysql_query($sql_l) or die(mysql_error());
	$rows_l = mysql_num_rows($query_l);
	if ($rows_l){
		echo '<ul id = "record-listing">';
		while($result_l = mysql_fetch_array($query_l)){
			//START:Create the links
			$edit_link = '?action=languages_edit&id='.$result_l['L_ID'].$TOOLBOX_SELECTED_OPTIONS;
			$delete_link = '<a href="scripts/languages_delete.php?id='.$result_l['L_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete" title="Διαγραφή"></a>';
			$isDefault = '<a href = "scripts/languages_default.php?id='.$result_l['L_ID'].$TOOLBOX_SELECTED_OPTIONS.'" class = "star" title = "Αλλαγή σε προεπιλεγμένη"><img src = "images/isDefaultGrey.png" /></a>';
			if (($result_l['L_ID'] == $DLTL) || ($_SESSION['EU_LEVEL'] != '2')){
				$delete_link = '';
			}
			if ($result_l['L_DEFAULT']){
				$isDefault = '<a href = "javascript:;" class = "star no-link"><img src = "images/isDefaultGold.png" title = "Προεπιλεγμένη" /></a>';
				$delete_link = '';
			}
			//END:Create the links
			
			//START:Echo visibility
			$is_visible = "Όχι";
			if ($result_l['L_VISIBLE']){
				$is_visible = "Ναι";
			}
			//END:Echo visibility
			
			echo '<li class = "hasDefault">
					'.$isDefault.'
					<a href = "'.$edit_link.'" title = "Επεξεργασία">'.stripslashes($result_l['L_NAME']).'</a>
					<span class = "details">Συντομογραφία: '.stripslashes($result_l['L_ABBREVIATION']).', Κατάταξη: '.$result_l['L_RANK'].', Ενεργή: '.$is_visible.'</span>
					'.$delete_link.'
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>