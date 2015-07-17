<?php require("access_isset.php"); ?>
<div class="breadcrumb">Δημιουργία Περιεχομένου &raquo; Άρθρα</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=articles_create'">Δημιουργία</button>
<?php
	echo $validation_message;
	require_once("articles_toolbox.php");
	
	//Article listing
	require("db_connect.php");
	$sql_a = " SELECT * FROM `articles`  
			   INNER JOIN `articles-languages` ON `articles`.A_ID=`articles-languages`.A_ID 
			   LEFT JOIN `menu_items-languages` ON `articles`.MI_ID=`menu_items-languages`.MI_ID AND `menu_items-languages`.L_ID='$TOOLBAR_LANG' 
			   WHERE `articles-languages`.L_ID = '$TOOLBAR_LANG' 
			   AND `articles`.A_DELETED = 0 
			   ORDER BY $mysql_order_by ";
	$query_a = mysql_query($sql_a) or die(mysql_error());
	$rows_a = mysql_num_rows($query_a);
	if ($rows_a){
		//Titles
		echo '<ul id = "record-listing">';
		while($result_a = mysql_fetch_array($query_a)){
			//START:Create the links
			$edit_link = '?action=articles_edit&id='.$result_a['A_ID'].$TOOLBOX_SELECTED_OPTIONS;
			$delete_link = '<a href="scripts/articles_delete.php?id='.$result_a['A_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete" title = "Διαγραφή"></a>';
			//END:Create the links
			
			//START:Echo visibility
			$visibility_caption = "Όχι";
			if ($result_a['A_VISIBLE']){
				$visibility_caption = "Ναι";
			}
			//END:Echo visibility
			
			//START:Echo directivity
			$directivity_caption = "Όχι";
			if ($result_a['A_DIRECT']){
				$directivity_caption = "Ναι";
			}
			//END:Echo directivity
			
			//START:Echo date added
			$date_added = '';
			if ($result_a['A_DATEADDED']){
				$date_added = date('d F Y, H:i', strtotime($result_a['A_DATEADDED']));
			}
			//END:Echo date added
			
			//START:Echo Menu Tree
			$current_mi = $result_a['MI_ID'];
			$sql_mt = "SELECT * FROM `menu_items` 
					   INNER JOIN `menu_items-languages` ON `menu_items`. MI_ID = `menu_items-languages`.MI_ID 
					   WHERE L_ID = '$TOOLBAR_LANG' AND `menu_items`.MI_ID = '$current_mi' LIMIT 1";
			$query_mt = mysql_query($sql_mt) or die(mysql_error());
			if ($result_mt = mysql_fetch_array($query_mt)){
				if ($result_mt['MI_MOTHER'] == '0' || !$result_mt['MI_MOTHER']){
					$menu_tree = stripslashes($result_mt['MIL_ALIAS']);
				}else{
					$menu_tree = stripslashes($result_a['MIL_ALIAS']);
					$found_mother = true;
					$current_mi = $result_mt['MI_MOTHER'];
					while ($found_mother){
						$sql_mt = "SELECT * FROM `menu_items` 
								   INNER JOIN `menu_items-languages` ON `menu_items`. MI_ID = `menu_items-languages`.MI_ID 
								   WHERE L_ID = '$TOOLBAR_LANG' AND `menu_items`.MI_ID = '$current_mi' LIMIT 1";
						$query_mt = mysql_query($sql_mt) or die(mysql_error());
						if ($result_mt = mysql_fetch_array($query_mt)){
							if ($result_mt['MI_MOTHER'] == '0' || !$result_mt['MI_MOTHER']){
								$menu_tree = stripslashes($result_mt['MIL_ALIAS']).' &raquo; '.$menu_tree;
								$found_mother = false;
							}else{
								$current_mi = $result_mt['MI_MOTHER'];
							}
						}
					}
				}
			}else{
				$menu_tree = '-';
			}
			//END:Echo Menu Tree
			
			echo '<li>
					<a href = "'.$edit_link.'" title = "Επεξεργασία">'.stripslashes($result_a['A_TITLE']).'</a>
					<span class = "details">Στο Μενού: '.$menu_tree.'</span>
					<span class = "details">Κατάταξη: '.$result_a['A_RANK'].', Ορατό: '.$visibility_caption.', Άμεσο: '.$directivity_caption.', Δημιουργία: '.$date_added.'</span>
					'.$delete_link.'
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>