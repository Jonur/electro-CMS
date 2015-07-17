<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['nm_email']) && filter_var($_POST['nm_email'], FILTER_VALIDATE_EMAIL) && !empty($_POST['edit_id'])){
		$form_id = $_POST['edit_id'];
		$form_nm_email = addslashes($_POST['nm_email']);
		$form_nm_name = '';
		if (!empty($_POST['nm_name']))
			$form_nm_name = addslashes($_POST['nm_name']);
		$form_nm_surname = '';
		if (!empty($_POST['nm_surname']))
			$form_nm_surname = addslashes($_POST['nm_surname']);
		$form_nm_tel = '';
		if (!empty($_POST['nm_tel']))
			$form_nm_tel = addslashes($_POST['nm_tel']);
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
		
		$sql_nl_update = "UPDATE `newsletter_members` SET NM_NAME = '$form_nm_name', NM_SURNAME = '$form_nm_surname', NM_EMAIL = '$form_nm_email', NM_TEL = '$form_nm_tel' WHERE NM_ID = '$form_id'";
		$query_nl_update = mysql_query($sql_nl_update);
		if (!$query_nl_update){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Επεξεργασία Μέλους Newsletter με e-mail ".$form_nm_email;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=nl_membership&validation='.$valid_entry);
?>