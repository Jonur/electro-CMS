<?php
	require("session_isset.php");
	require("environment.php");
	
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['g_name'][$DLTL])){
		$form_g_name = $_POST['g_name'];
		foreach($form_g_name as $key=>$item){
			$form_g_name[$key] = addslashes($form_g_name[$key]);
		}
		
		$form_g_mi = 0;
		if (!empty($_POST['g_mi'])){
			$form_g_mi = $_POST['g_mi'];
		}
		
		$form_g_rank = 0;
		if (isset($_POST['g_rank']) && ctype_digit($_POST['g_rank']))
			$form_g_rank = $_POST['g_rank'];
		
		$form_g_visible = 0;
		if (isset($_POST['g_visible']) && is_numeric($_POST['g_visible']))
			$form_g_visible = 1;
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
			$sql_id = "SELECT * FROM `galleries` WHERE G_ID='".$generatedId."'";
			$query_id = mysql_query($sql_id);
			$rows = mysql_num_rows($query_id);
		}while($rows);
		//END: Generate ID
		
		$sql_g = "INSERT INTO `galleries` VALUES ('$generatedId','$form_g_mi',$form_g_rank, $form_g_visible,0)";
		$query_g = mysql_query($sql_g);
		if (!$query_g){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		if ($valid_entry)
		{
			$last_id = $generatedId;
			foreach($form_g_name as $key=>$item)
			{
				if(!empty($form_g_name[$key]))
				{
					$sql_g_lang = "INSERT INTO `galleries-languages` VALUES ('$last_id', '$key', '$form_g_name[$key]')";
					$query_g_lang = mysql_query($sql_g_lang);
					if (!$query_g_lang){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
			}
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Δημιουργία της Γκαλερί με όνομα ".$form_g_name[$DLTL];
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	//Redirection
	header('Location: ../?action=galleries_create&validation='.$valid_entry);
?>