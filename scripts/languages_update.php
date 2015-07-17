<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['l_name']) && !empty($_POST['l_abbreviation']) && !empty($_POST['edit_id'])){
		$form_id = $_POST['edit_id'];
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

	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	
	//Inserting the data row
	if ($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		$sql_l = "UPDATE `languages` SET L_NAME = '$form_l_name', L_ABBREVIATION = '$form_l_abbreviation', L_VISIBLE = $form_l_visible, L_RANK = $form_l_rank WHERE L_ID = '$form_id'";
		$query_l = mysql_query($sql_l);
		if (!$query_l){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Eπεξεργασία	Γλώσσας με όνομα ".$form_l_name;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=languages&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>