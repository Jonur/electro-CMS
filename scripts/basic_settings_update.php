<?php
	require("session_isset.php");
	//Initialization values
	ini_set("memory_limit","32M");
	ini_set("max_execution_time","900");
	$MAX_SIZE = 10240;
	$img_arr = array('.ico');
	$valid_entry = 1;
	
	require("environment.php");
	
	$revisit_after_values = array('1 hour', '1 day', '7 days', '1 month', '1 year');
	$rating_values = array('general', 'mature', 'restricted', '14 years', 'safe for kids');
	
	if (!empty($_POST['bs_title']))
	{	
		$form_bs_title = addslashes($_POST['bs_title']);
		if(!(mb_strlen($form_bs_title,'utf-8') > 10 && mb_strlen($form_bs_title,'utf-8') < 70)){
			$valid_entry = 0;
		}
		$form_bs_basepath = addslashes($_POST['bs_basepath']);
		$form_bs_description = addslashes($_POST['bs_description']);
		if(!empty($form_bs_description) && (mb_strlen($form_bs_description,'utf-8') < 70 || mb_strlen($form_bs_description,'utf-8') > 160)){
			$valid_entry = 0;
		}
		$form_bs_keywords = addslashes($_POST['bs_keywords']);
		$form_bs_revisit_after = addslashes($_POST['bs_revisit_after']);
		$form_bs_author = addslashes($_POST['bs_author']);
		$form_bs_dcterms_abstract = addslashes($_POST['bs_dcterms_abstract']);
		$form_bs_rating = addslashes($_POST['bs_rating']);
		$form_bs_ms_validate = addslashes($_POST['bs_ms_validate']);
		
		//check if dropdowns has accepted values
		if (!in_array($form_bs_revisit_after, $revisit_after_values) || !in_array($form_bs_rating, $rating_values)){
			$valid_entry = 0;
		}
			
		//Get filename and extension
		$new_file_name = '';
		$update_favico = false;
		if ($_FILES['file_from_pc']['name']){
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
			$new_file_name = 'favicon'.$ext;
			
			//Files with full path
			$uploadfile = $uploaddir_favico.$new_file_name;
			
			//Upload the user's file and return validation
			if($valid_entry){
				if (!move_uploaded_file($uploadedfile, $uploadfile)){
					$valid_entry = 0;
				}
			}
			
			if($valid_entry){
				$update_favico = $new_file_name;
			}
		}
	}else{
		$valid_entry = 0;
	}
	
	//Inserting the data row
	if ($valid_entry){
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		if (!$update_favico){
			$sql_bs = "UPDATE `basic_settings` SET BS_TITLE = '$form_bs_title', BS_BASEPATH = '$form_bs_basepath', BS_DESCRIPTION = '$form_bs_description', BS_KEYWORDS = '$form_bs_keywords', BS_REVISIT_AFTER = '$form_bs_revisit_after', BS_AUTHOR = '$form_bs_author', BS_DCTERMS_ABSTRACT = '$form_bs_dcterms_abstract', BS_RATING = '$form_bs_rating', BS_MS_VALIDATE = '$form_bs_ms_validate' WHERE BS_ID = 'KNQJBHCHMI'";
		}else{
			$sql_bs = "UPDATE `basic_settings` SET BS_TITLE = '$form_bs_title', BS_BASEPATH = '$form_bs_basepath', BS_FAVICO = '$new_file_name', BS_DESCRIPTION = '$form_bs_description', BS_KEYWORDS = '$form_bs_keywords', BS_REVISIT_AFTER = '$form_bs_revisit_after', BS_AUTHOR = '$form_bs_author', BS_DCTERMS_ABSTRACT = '$form_bs_dcterms_abstract', BS_RATING = '$form_bs_rating', BS_MS_VALIDATE = '$form_bs_ms_validate' WHERE BS_ID = 'KNQJBHCHMI'";
		}
		
		$query_bs = mysql_query($sql_bs);		
		if (!$query_bs){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		if(!$valid_entry){
			@unlink($uploadfile);
		}
	
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Επεξεργασία Βασικών ρυθμίσεων ";
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=basic_settings&validation='.$valid_entry);
?>