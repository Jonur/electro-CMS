<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['l_name']) && !empty($_POST['l_abbreviation'])){
		$form_l_name = addslashes($_POST['l_name']);
		$form_l_abbreviation = addslashes($_POST['l_abbreviation']);
		$form_l_rank = 0;
		if (isset($_POST['l_rank']) && ctype_digit($_POST['l_rank']))
			$form_l_rank = $_POST['l_rank'];
		
		$form_l_visible = 0;
		if (isset($_POST['l_visible']) && is_numeric($_POST['l_visible']))
			$form_l_visible = 1;
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
			$sql_id = "SELECT * FROM `languages` WHERE L_ID='".$generatedId."'";
			$query_id = mysql_query($sql_id);
			$rows = mysql_num_rows($query_id);
		}while($rows);
		//END: Generate ID
		
		$sql_l = "INSERT INTO `languages` VALUES ('$generatedId','$form_l_name','$form_l_abbreviation', $form_l_rank, $form_l_visible, 0)";
		$query_l = mysql_query($sql_l);
		if (!$query_l){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Δημιουργία Γλώσσας με όνομα ".$form_l_name;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=languages_create&validation='.$valid_entry);
?>