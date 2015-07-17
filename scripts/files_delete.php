<?php
	require("session_isset.php");
	require("environment.php");
	
	//Get the form values
	$valid_entry = 1;
	
	if(!empty($_REQUEST['id'])){
		$id = $_REQUEST['id'];
	}else{
		$valid_entry = 0;
	}
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['ft'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&ft='.$_REQUEST['ft'];
	}
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	//Deleting the data row
	if ($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		$sql_f_delete = "UPDATE `files` SET F_DELETED = 1 WHERE F_ID = '$id'";
		$query_f_delete = mysql_query($sql_f_delete);
		if (!$query_f_delete){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$sql_title = "SELECT * FROM `files` WHERE F_ID = '$id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = $result_title['F_FILENAME'];
		}
		$elog_action = "Διαγραφή Αρχείου με όνομα ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=files&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>