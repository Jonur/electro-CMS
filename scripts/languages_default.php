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
	if ($valid_entry){
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		//START: REPORT ACTION TO THE LOG FILE
		$sql_title = "SELECT * FROM `languages` WHERE L_ID = '$id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = stripslashes($result_title['L_NAME']);
		}
		$elog_action = "Αλλαγή προεπιλεγμένης γλώσσας στα ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		$sql_default_reset = "UPDATE `languages` SET L_DEFAULT = 0";
		$query_default_reset = mysql_query($sql_default_reset);
		if (!$query_default_reset){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		$sql_nm_default = "UPDATE `languages` SET L_DEFAULT = 1 WHERE L_ID = '$id'";
		$query_nm_default = mysql_query($sql_nm_default);
		if (!$query_nm_default){
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