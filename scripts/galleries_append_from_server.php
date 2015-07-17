<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['photocell_item']) && !empty($_POST['edit_id'])){
		$form_g_id = $_POST['edit_id'];
		$form_item = $_POST['photocell_item'];
	}else{
		$valid_entry = 0;
	}
	
	//Inserting the data rows
	if ($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		for($i=0;$i<count($form_item);$i++)
		{
			$sql_mg = "INSERT INTO `galleries-files` VALUES ('$form_g_id','$form_item[$i]', 0)";
			$query_mg = mysql_query($sql_mg) or die (mysql_error());
			if (!$query_mg){
				$valid_entry = 0;
				$commit = "rollback";
			}
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$title = '';
		for($i=0;$i<count($form_item);$i++)
		{
			$sql_title = "SELECT * FROM `files` WHERE F_ID = '$form_item[$i]'";
			$query_title = mysql_query($sql_title);
			while($result_title = mysql_fetch_array($query_title)){
				$title .= $result_title['F_FILENAME'].', ';
			}
		}
		
		$sql_gtitle = "SELECT * FROM `galleries-languages` WHERE L_ID = '$DLTL' AND G_ID = '$form_g_id'";
		$query_gtitle = mysql_query($sql_gtitle);
		while($result_gtitle = mysql_fetch_array($query_gtitle)){
			$gtitle = $result_gtitle['GL_ALIAS'];
		}
		$title = substr($title, 0, -2);
		$elog_action = "Προσθήκη των Αρχείων (".$title.") στην Γκαλερί με όνομα ".$gtitle;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	//Redirection
	header('Location: ../?action=galleries_append&id='.$form_g_id.'&validation='.$valid_entry);
?>