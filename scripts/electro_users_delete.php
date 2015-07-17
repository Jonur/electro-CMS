<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	
	if(!empty($_REQUEST['id']) && $_REQUEST['id'] != $_SESSION['EU_ID']){
		$id = $_REQUEST['id'];
	}else{
		$valid_entry = 0;
	}
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	require("db_connect.php");
	include("functions.php");
	
	//Exclude electro Default Admin (EDA)
	if ($valid_entry){
		$sql_eda = "SELECT * FROM `electro_users` WHERE EU_ID = '$id'";
		$query_eda = mysql_query($sql_eda);
		if (!$query_eda){
			$valid_entry = 0;
		}else{
			while ($result_eda = mysql_fetch_array($query_eda)){
				$eu_level = $result_eda['EU_LEVEL'];
			}
		}
		if ($eu_level == '2')
			$valid_entry = 0;
	}
	
	//Deleting the data row
	if ($valid_entry)
	{	
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		//START: REPORT ACTION TO THE LOG FILE
		$sql_title = "SELECT * FROM `electro_users` WHERE EU_ID = '$id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = $result_title['EU_USERNAME'];
		}
		$elog_action = "Διαγραφή Χρήστη electro με username ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		$sql_eu_delete = "DELETE FROM `electro_users` WHERE EU_ID = '$id'";
		$query_eu_delete = mysql_query($sql_eu_delete);
		if (!$query_eu_delete){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
	}
	
	require("db_disconnect.php");
	
	//Redirection
	header('Location: ../?action=electro_users&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>