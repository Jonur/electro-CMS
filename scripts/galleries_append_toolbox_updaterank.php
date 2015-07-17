<?php
	require("session_isset.php");
	$valid_entry = 1;
	//Get the form values
	if (!empty($_POST['gid']) && !empty($_POST['fid']))
	{
		$form_g_id = $_POST['gid'];
		$form_f_id = $_POST['fid'];
		
		$form_gf_rank = 0;
		if (isset($_POST['gf_rank']) && ctype_digit($_POST['gf_rank'])){
			$form_gf_rank = $_POST['gf_rank'];
		}else{
			$valid_entry = 0;
		}
	}else{
		//Redirection
		header('Location: ../electro/');
	}
	
	require("db_connect.php");
	include("functions.php");
	
	//Begin Transaction
	$commit = "commit";
	mysql_query("begin", $con);
	
	$sql_update = "UPDATE `galleries-files` SET GF_RANK = $form_gf_rank WHERE G_ID = '".$form_g_id."' AND F_ID = '".$form_f_id."'";
	$query_update = mysql_query($sql_update);
	if (!$query_update){
		$valid_entry = 0;
		$commit = "rollback";
	}
	
	//START: REPORT ACTION TO THE LOG FILE
	$sql_title = "SELECT * FROM `files` WHERE F_ID = '$form_f_id'";
	$query_title = mysql_query($sql_title);
	while($result_title = mysql_fetch_array($query_title)){
		$title = $result_title['F_FILENAME'];
	}
	$elog_action = "Αλλαγή Κατάταξης στο Αρχείο με όνομα ".$title;
	eLog($elog_action);
	//END: REPORT ACTION TO THE LOG FILE
	
	//End Transaction - Commit or Rollback
	mysql_query($commit);
	require("db_disconnect.php");
		
	//Redirection
	header('Location: ../?action=galleries_append&id='.$form_g_id.'&validation='.$valid_entry);
?>