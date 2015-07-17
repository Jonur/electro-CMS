<?php require("access_isset.php"); ?>
<div class="breadcrumb">Δημιουργία Περιεχομένου &raquo; Αρχεία</div>
<button type="button" class="create_button" onclick="javascript:location.href='?action=files_create'">Ανέβασμα</button>
<?php echo $validation_message; ?>
<?php
	echo $validation_message;
	require_once("files_toolbox.php");
	
	//Files listing		
	require("db_connect.php");
	$sql_f = "  SELECT * FROM `files` 
				WHERE `files`.F_FILETYPE IN ".$current_arr." 
				AND `files`.F_DELETED = 0 
				ORDER BY $mysql_order_by";
	$query_f = mysql_query($sql_f) or die(mysql_error());
	$rows_f = mysql_num_rows($query_f);
	if ($rows_f){	
		echo '<ul id = "record-listing">';
		while($result_f = mysql_fetch_array($query_f)){
			//START:Create the links
			$edit_link = '?action=files_edit&id='.$result_f['F_ID'].$TOOLBOX_SELECTED_OPTIONS;
			$files_preview_link = '<a href = "'.$local_image_path.$result_f['F_FILENAME'].'" class = "files_preview" title = "Προεπισκόπηση εικόνας" rel="shadowbox[photos]"></a>';
			$delete_link = '<a href="scripts/files_delete.php?id='.$result_f['F_ID'].$TOOLBOX_SELECTED_OPTIONS.'" onclick="return checkfields(this);" class = "delete" title="Διαγραφή"></a>';
			//END:Create the links
			
			//START: Echo File Name
			$file_name = 'Χωρίς Όνομα';
			if ($result_f['F_NAME']){
				$file_name = stripslashes($result_f['F_NAME']);
			}
			if ($ft != "photos"){
				$files_preview_link = '';
			}
			//END: Echo File Name
			
			//START: In case of image files, echo the gallery names
			$galleries = '';
			if ($ft == "photos"){
				$gallery_names = '';
				$sql_g = "SELECT * FROM `galleries-files` 
						  INNER JOIN `galleries` ON `galleries-files`.G_ID = `galleries`.G_ID 
						  INNER JOIN `galleries-languages` ON `galleries`.G_ID = `galleries-languages`.G_ID 
						  WHERE F_ID = '".$result_f['F_ID']."' 
						  AND L_ID = '$DLTL' 
						  ORDER BY GL_ALIAS";
				$query_g = mysql_query($sql_g) or die(mysql_error());
				while ($result_g = mysql_fetch_array($query_g)){
					$gallery_names .= stripslashes($result_g['GL_ALIAS']).', ';
				}
				$galleries = '<span class = "details">Στις Γκαλερί: '.substr($gallery_names, 0, -2).'</span>';
			}
			//END: In case of image files, echo the gallery names
			
			echo '<li>
					<a href = "'.$edit_link.'" title = "Επεξεργασία">'.$file_name.'</a>
					'.$galleries.'
					<span class = "details">Κατάταξη: '.$result_f['F_RANK'].'</span>
					'.$files_preview_link.$delete_link.'
				  </li>';
		}
		echo '</ul>';
	}else{
		echo '<div class="validation_message_false">Δεν υπάρχουν καταχωρημένες εγγραφές στη βάση.</div>';
	}
	require("db_disconnect.php");
?>