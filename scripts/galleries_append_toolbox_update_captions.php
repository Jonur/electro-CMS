<?php
	require("session_isset.php");
	//Get the form values
	if (!empty($_POST['ic_alias']) && !empty($_POST['fid']))
	{
		$form_f_id = $_POST['fid'];
		$form_ic_alias = $_POST['ic_alias'];
		foreach($form_ic_alias as $key=>$item){
			$form_ic_alias[$key] = addslashes($form_ic_alias[$key]);
		}
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
	
	$sql_delete_rows = "DELETE FROM `image_captions` WHERE F_ID = '$form_f_id'";
	if(!$query_delete_rows = mysql_query($sql_delete_rows)){
		$valid_entry = 0;
		$commit = "rollback";
	}
	
	foreach($form_ic_alias as $key=>$item)
	{
		if(!empty($form_ic_alias[$key]))
		{
			$sql_ic_alias = "INSERT INTO `image_captions` VALUES ('$form_f_id', '$key', '$form_ic_alias[$key]')";
			$query_ic_alias = mysql_query($sql_ic_alias);
			if (!$query_ic_alias){
				$valid_entry = 0;
				$commit = "rollback";
			}
		}
	}
	//START: REPORT ACTION TO THE LOG FILE
	$sql_title = "SELECT * FROM `files` WHERE F_ID = '$form_f_id'";
	$query_title = mysql_query($sql_title);
	while($result_title = mysql_fetch_array($query_title)){
		$title = $result_title['F_FILENAME'];
	}
	$elog_action = "Προσθήκη Λεζάντας στο αρχείο με όνομα ".$title;
	eLog($elog_action);
	//END: REPORT ACTION TO THE LOG FILE
	
	//End Transaction - Commit or Rollback
	mysql_query($commit);
	require("db_disconnect.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" >
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	</head>
	<body onload="window.parent.Shadowbox.close();">
	</body>
</html>