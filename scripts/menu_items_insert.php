<?php
	require("session_isset.php");
	//Initialization values
	ini_set("memory_limit","32M");
	ini_set("max_execution_time","900");
	$MAX_SIZE = 10485760;
	$img_arr = array('.jpeg','.jpg','.png','.gif');
	$valid_entry = 1;
	
	require("environment.php");
	
	if (!empty($_POST['mi_mg']) && !empty($_POST['mi_title'][$DLTL])){	
		$form_mi_title = $_POST['mi_title'];
		foreach($form_mi_title as $key=>$item){
			$form_mi_title[$key] = addslashes($form_mi_title[$key]);
		}
		
		$form_mi_mg = 0;
		if (!empty($_POST['mi_mg'])){
			$form_mi_mg = $_POST['mi_mg'];
		}
		
		$form_mi_mother = 0;
		if (!empty($_POST['mi_mother'])){
			$form_mi_mother = $_POST['mi_mother'];
		}
		
		$form_mi_type = 0;
		if (!empty($_POST['mi_type'])){
			$form_mi_type = $_POST['mi_type'];
		}
	
		$form_mi_rank = 0;
		if (isset($_POST['mi_rank']) && ctype_digit($_POST['mi_rank']))
			$form_mi_rank = $_POST['mi_rank'];
		
		$form_mi_visible = 0;
		if (isset($_POST['mi_visible']) && is_numeric($_POST['mi_visible']))
			$form_mi_visible = 1;
		
		$form_mi_extrainfo = "";
		if (!empty($_POST['mi_extrainfo']))
			$form_mi_extrainfo = addslashes($_POST['mi_extrainfo']);
		
		$form_mi_meta_description = addslashes($_POST['mi_meta_description']);
		if(!empty($form_mi_meta_description) && (mb_strlen($form_mi_meta_description,'utf-8') < 70 || mb_strlen($form_mi_meta_description,'utf-8') > 160)){
			$valid_entry = 0;
		}
		
		$form_mi_meta_keywords = '';
		if (!empty($_POST['mi_meta_keywords']))
			$form_mi_meta_keywords = addslashes($_POST['mi_meta_keywords']);
			
		//Get filename and extension
		$new_file_name = '';
		if ($_FILES['file_from_pc']['name'])
		{
			$form_filename = $_FILES['file_from_pc']['name']; //file_from_pc=userfile
			$ext = substr($form_filename, strpos($form_filename,'.'), strlen($form_filename)-1);
			$ext = strtolower($ext);
			
			//Set temp_name, extension and file size
			$thefile = $form_filename;
			$thefile_temp_name = $_FILES['file_from_pc']['tmp_name'];
			$thefile_ext = $ext;
			$thefile_size = $_FILES['file_from_pc']['size'];
			
			//Check if the file is legit, proper and if there were any errors during the upload process
			if (!in_array($ext,$img_arr))
				$valid_entry = 0;
				
			if (empty($thefile) || $thefile_size>$MAX_SIZE || ($_FILES['file_from_pc']['error'] !== UPLOAD_ERR_OK))
				$valid_entry = 0;
			
			require("environment.php");
			$uploadedfile = $thefile_temp_name;
			
			//Creating unique file names for the server storage and database entry
			$new_file_name = date("YmdHis").$ext;
			
			//Files with full path
			$uploadfile = $uploaddir_menu_item.$new_file_name;
			
			//Upload the user's file and return validation
			if (!move_uploaded_file($uploadedfile, $uploadfile))
				$valid_entry = 0;
		}
	}else{
		$valid_entry = 0;
	}
	
	//Inserting the data row
	if ($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		//START: Generate ID
		do{
			$generatedId = generateId();
			$sql_id = "SELECT * FROM `menu_items` WHERE MI_ID='".$generatedId."'";
			$query_id = mysql_query($sql_id);
			$rows = mysql_num_rows($query_id);
		}while($rows);
		//END: Generate ID
		
		$sql_mi = "INSERT INTO `menu_items` VALUES ('$generatedId','$form_mi_mother', $form_mi_rank, '$form_mi_type', '$form_mi_extrainfo', '$new_file_name', $form_mi_visible, 0, 0, '$form_mi_meta_description', '$form_mi_meta_keywords')";
		$query_mi = mysql_query($sql_mi);
		if (!$query_mi){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		if ($valid_entry)
		{
			$last_id = $generatedId;
			
			//insert alias
			foreach($form_mi_title as $key=>$item)
			{
				if(!empty($form_mi_title[$key]))
				{
					//create friendly URL
					$mi_furl = create_furl($form_mi_title[$key]);
					$sql_furl = "SELECT * FROM `menu_items` 
								 INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID = `menu_items-languages`.MI_ID 
								 WHERE MI_MOTHER = '$form_mi_mother' AND L_ID = '$key' AND MIL_FURL = '$mi_furl' AND MI_DELETED = 0";
					$query_furl = mysql_query($sql_furl);
					if (mysql_num_rows($query_furl)){
						$valid_entry = 0;
						$commit = "rollback";
					}
					
					$sql_mi_lang = "INSERT INTO `menu_items-languages` VALUES ('$last_id', '$key', '$form_mi_title[$key]', '$mi_furl')";
					$query_mi_lang = mysql_query($sql_mi_lang);
					if (!$query_mi_lang){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
			}
			//insert menou groups
			if ($form_mi_mg){
				$sql_mi_mg = "INSERT INTO `menu_groups-menu_items` VALUES ('$form_mi_mg', '$last_id')";
				$query_mi_mg = mysql_query($sql_mi_mg);
				if (!$query_mi_mg){
					$valid_entry = 0;
					$commit = "rollback";
				}
			}
			
			if(!$valid_entry)
			{
				@unlink($uploadfile);
			}
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Δημιουργία Στοιχείου Μενού με τίτλο ".$form_mi_title[$DLTL];
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=menu_items_create&validation='.$valid_entry);
?>