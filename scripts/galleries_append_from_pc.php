<?php
	require("session_isset.php");
	//Initialization values
	ini_set("memory_limit","32M");
	ini_set("max_execution_time","900");
	$MAX_SIZE = 10485760;
	$img_arr = array('.jpeg','.jpg','.png','.gif');
	$valid_entry = 1;
	
	require("environment.php");
	
	//Get gallery id
	if (!empty($_POST['edit_id'])){
		$id = $_POST['edit_id'];
	}else{
		$valid_entry = 0;
		$id = 0;
	}
	
	//Get filename and extension
	$form_filename = $_FILES['file_from_pc']['name'];
	$ext = substr($form_filename, strpos($form_filename,'.'), strlen($form_filename)-1);
	$ext = strtolower($ext);
	
	//Set temp_name, extension and file size
	$thefile = $form_filename;
	$thefile_temp_name = $_FILES['file_from_pc']['tmp_name'];
	$thefile_ext = $ext;
	$thefile_size = $_FILES['file_from_pc']['size'];
	
	//Check if the file is legit, proper and if there were any errors during the upload process
	if (empty($thefile) || !in_array($ext,$img_arr) || $thefile_size > $MAX_SIZE || ($_FILES['file_from_pc']['error'] !== UPLOAD_ERR_OK))
		$valid_entry = 0;
	
	if($valid_entry)
	{	
		$uploadedfile = $thefile_temp_name;
		
		//Creating unique file names for the server storage and database entry
		$new_file_name = date("YmdHis").$ext;
		$new_file_name_thumb = 'thumb_'.date("YmdHis").$ext;
		
		//Files with full path
		$uploadfile = $uploaddir_img.$new_file_name;
		$uploadfile_thumb = $uploaddir_img.'thumbs/'.$new_file_name_thumb;
		
		//Create the SRC
		if(($ext == ".jpg") || ($ext == ".jpeg"))
			$src = imagecreatefromjpeg($uploadedfile);
		if($ext == ".png")
			$src = imagecreatefrompng($uploadedfile);
		if($ext == ".gif")
			$src = imagecreatefromgif($uploadedfile);
		
		//Calculate thumb size
		list($width,$height) = getimagesize($uploadedfile);
		if ($thumb_width){
			$thumb_height = ($thumb_width * $height) / $width;
		}else{
			$thumb_width = ($thumb_height * $width) / $height;
		}
		
		//Create the thumb
		$thumb_black = imagecreatetruecolor($thumb_width,$thumb_height);
		imagecopyresampled($thumb_black,$src,0,0,0,0,$thumb_width,$thumb_height,$width,$height);
		imagejpeg($thumb_black,$uploadfile_thumb,100);
		
		//Delete the temporary images from server
		imagedestroy($src);
		imagedestroy($thumb_black);
		
		//Upload the user's file and return validation
		if (!move_uploaded_file($uploadedfile, $uploadfile))
			$valid_entry = 0;
	}

	//Database entry
	if($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		//START: Generate ID
		do{
			$generatedId = generateId();
			$sql_id = "SELECT * FROM `files` WHERE F_ID = '".$generatedId."'";
			$query_id = mysql_query($sql_id);
			$rows = mysql_num_rows($query_id);
		}while($rows);
		//END: Generate ID
		
		$sql_img = "INSERT INTO `files` VALUES ('$generatedId','','$new_file_name','$ext',0,'',0)";
		$query_img = mysql_query($sql_img);
		if (!$query_img){
			$valid_entry = 0;
			$commit = "rollback";
		}	
		
		$last_id = $generatedId;
		
		$sql_gf = "INSERT INTO `galleries-files` VALUES ('$id','$last_id',0)";
		$query_gf = mysql_query($sql_gf);
		if (!$query_gf){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$sql_title = "SELECT * FROM `galleries-languages` WHERE L_ID = '$DLTL' AND G_ID = '$id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = $result_title['GL_ALIAS'];
		}
		$elog_action = "Δημιουργία Αρχείου με όνομα ".$new_file_name;
		$elog_action .= "<br />και προσθήκη στη Γκαλερί με όνομα ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
		
		//Delete `files` if data entry fails
		if(!$valid_entry)
		{
			@unlink($uploadfile);
			@unlink($uploadfile_thumb);
		}
	}
	
	//Redirection
	header('Location: ../?action=galleries_append&id='.$id.'&validation='.$valid_entry);
?>