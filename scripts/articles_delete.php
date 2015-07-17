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
	
	//Deleting the data row
	if ($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		$sql_article_delete = "UPDATE `articles` SET A_DELETED = 1 WHERE A_ID = '$id'";
		$query_article_delete = mysql_query($sql_article_delete);
		if (!$query_article_delete){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$sql_title = "SELECT * FROM `articles` WHERE A_ID = '$id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = $result_title['A_TITLE'];
		}
		$elog_action = "Διαγραφή Άρθρου με τίτλο ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=articles&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>