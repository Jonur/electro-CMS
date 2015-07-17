<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['nm_email']) && filter_var($_POST['nm_email'], FILTER_VALIDATE_EMAIL))
	{
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
		
		//START: Generate ID
		do{
			$generatedId = generateId();
			$sql_id = "SELECT * FROM `newsletter_members` WHERE NM_ID='".$generatedId."'";
			$query_id = mysql_query($sql_id);
			$rows = mysql_num_rows($query_id);
		}while($rows);
		//END: Generate ID
		
		$sql_nl = "INSERT INTO `newsletter_members` VALUES ('$generatedId','$form_nm_name','$form_nm_surname','$form_nm_email','$form_nm_tel')";
		$query_nl = mysql_query($sql_nl);
		if (!$query_nl){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Προσθήκη Μέλους Newsletter με e-mail ".$form_nm_email;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=nl_membership_create&validation='.$valid_entry);
?>