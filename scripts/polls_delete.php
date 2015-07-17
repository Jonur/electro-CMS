<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	
	if(!empty($_REQUEST['id'])){
		$id = $_REQUEST['id'];
	}else{
		$valid_entry = 0;
	}
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
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
		
		//START: REPORT ACTION TO THE LOG FILE
		$sql_title = "SELECT * FROM `polls` WHERE P_ID = '$id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = $result_title['P_TITLE'];
		}
		$elog_action = "Διαγραφή Διαγωνισμού με τίτλο ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		$sql_p_delete = "DELETE FROM `polls` WHERE P_ID = '$id'"; //POLLS
		$query_p_delete = mysql_query($sql_p_delete);
		if (!$query_p_delete){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		$sql_p_delete = "DELETE FROM `polls-contestants` WHERE P_ID = '$id'"; //POLL_CONTESTANTS
		$query_p_delete = mysql_query($sql_p_delete);
		if (!$query_p_delete){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		$sql_p_delete = "DELETE FROM `poll_voters` WHERE P_ID = '$id'"; //POLL_VOTERS
		$query_p_delete = mysql_query($sql_p_delete);
		if (!$query_p_delete){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=polls&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>