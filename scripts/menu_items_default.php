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
	if (!empty($_REQUEST['tl'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tl='.$_REQUEST['tl'];
	}
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	if (!empty($_REQUEST['tmg'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tmg='.$_REQUEST['tmg'];
	}
	
	//Deleting the data row
	if ($valid_entry){
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		$sql_default_reset = "UPDATE `menu_items` SET MI_DEFAULT = 0";
		$query_default_reset = mysql_query($sql_default_reset);
		if (!$query_default_reset){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		$sql_mi_default = "UPDATE `menu_items` SET MI_DEFAULT = 1 WHERE MI_ID = '$id'";
		$query_mi_default = mysql_query($sql_mi_default);
		if (!$query_mi_default){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$sql_title = "SELECT * FROM `menu_items-languages` WHERE L_ID = '$DLTL' AND MI_ID = '$id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = $result_title['MIL_ALIAS'];
		}
		$elog_action = "Αλλαγή προεπιλεγμένου Στοιχείου Μενού με τίτλο ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=menu_items&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>