<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	
	if(!empty($_REQUEST['id'])){
		$id = $_REQUEST['id'];
	}else{
		$valid_entry = 0;
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
		$sql_title = "SELECT * FROM `newsletter_members` WHERE NM_ID = '$id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = $result_title['NM_EMAIL'];
		}
		$elog_action = "Διαγραφή Μέλους Newsletter με e-mail ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		$sql_nm_delete = "DELETE FROM `newsletter_members` WHERE NM_ID = '$id'";
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
	header('Location: ../?action=nl_membership&validation='.$valid_entry);
?>