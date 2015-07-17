<?php
	require("session_isset.php");
	require("environment.php");
	
	//Get the form values
	$valid_entry = 1;
	
	if(!empty($_REQUEST['id']) && $_REQUEST['id'] != $DLTL){
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
		$sql_title = "SELECT * FROM `languages` WHERE L_ID = '$id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = $result_title['L_NAME'];
		}
		$elog_action = "Διαγραφή Γλώσσας με όνομα ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		$sql_nm_delete = "DELETE FROM `languages` WHERE L_ID = '$id'";
		$query_nm_delete = mysql_query($sql_nm_delete);
		if (!$query_nm_delete){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=languages&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>