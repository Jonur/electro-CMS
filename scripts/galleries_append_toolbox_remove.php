<?php
	require("session_isset.php");
	//Get the form values
	if (!empty($_REQUEST['gid']) && !empty($_REQUEST['fid']))
	{
		$url_gid = $_REQUEST['gid'];
		$url_fid = $_REQUEST['fid'];
	}else{
		//Redirection
		header('Location: ../electro/');
	}
	
	$valid_entry = 1;
	require("db_connect.php");
	include("functions.php");
	
	//Begin Transaction
	$commit = "commit";
	mysql_query("begin", $con);
	
	$sql_remove = "DELETE FROM `galleries-files` WHERE G_ID = '".$url_gid."' AND F_ID = '".$url_fid."'";
	$query_remove = mysql_query($sql_remove);
	if (!$query_remove){
		$valid_entry = 0;
		$commit = "rollback";
	}
	
	//START: REPORT ACTION TO THE LOG FILE
	$sql_title = "SELECT * FROM `galleries-languages` WHERE L_ID = '$DLTL' AND G_ID = '$url_gid'";
	$query_title = mysql_query($sql_title);
	while($result_title = mysql_fetch_array($query_title)){
		$gtitle = $result_title['GL_ALIAS'];
	}
	$sql_title = "SELECT * FROM `files` WHERE F_ID = '$url_fid'";
	$query_title = mysql_query($sql_title);
	while($result_title = mysql_fetch_array($query_title)){
		$ftitle = $result_title['F_FILENAME'];
	}
	$elog_action = "Αφαίρεση του Αρχείου με όνομα ".$ftitle;
	$elog_action .= "<br />από τη Γκαλερί με όνομα ".$gtitle;
	eLog($elog_action);
	//END: REPORT ACTION TO THE LOG FILE
		
	//End Transaction - Commit or Rollback
	mysql_query($commit);
	require("db_disconnect.php");
		
	//Redirection
	header('Location: ../?action=galleries_append&id='.$url_gid.'&validation='.$valid_entry);
?>