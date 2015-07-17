<?php
	require("session_isset.php");
	require("environment.php");
	
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['mg_title'][$DLTL])){
		$form_mg_title = $_POST['mg_title'];
		foreach($form_mg_title as $key=>$item){
			$form_mg_title[$key] = addslashes($form_mg_title[$key]);
		}

		$form_mg_rank = 0;
		if (isset($_POST['mg_rank']) && ctype_digit($_POST['mg_rank']))
			$form_mg_rank = $_POST['mg_rank'];
		
		$form_mg_visible = 0;
		if (isset($_POST['mg_visible']) && is_numeric($_POST['mg_visible']))
			$form_mg_visible = 1;
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
			$sql_id = "SELECT * FROM `menu_groups` WHERE MG_ID='".$generatedId."'";
			$query_id = mysql_query($sql_id);
			$rows = mysql_num_rows($query_id);
		}while($rows);
		//END: Generate ID
		
		$sql_mg = "INSERT INTO `menu_groups` VALUES ('$generatedId',$form_mg_rank,$form_mg_visible,0)";
		$query_mg = mysql_query($sql_mg);
		if (!$query_mg){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		if ($valid_entry)
		{
			$last_id = $generatedId;
			foreach($form_mg_title as $key=>$item)
			{
				if(!empty($form_mg_title[$key]))
				{
					$sql_mg_lang = "INSERT INTO `menu_groups-languages` VALUES ('$last_id', '$key', '$form_mg_title[$key]')";
					$query_mg_lang = mysql_query($sql_mg_lang);
					if (!$query_mg_lang){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
			}
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Δημιουργία Ομάδας Μενού με τίτλο ".$form_mg_title[$DLTL];
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		
		require("db_disconnect.php");
	}
	//Redirection
	header('Location: ../?action=menu_groups_create&validation='.$valid_entry);
?>