<?php
	require("session_isset.php");
	require("environment.php");
	
	$valid_entry = 1;
	//Get form fields
	if(!empty($_POST['edit_id'])){
		$form_id = $_POST['edit_id'];
		$form_f_name = '';
		if (!empty($_POST['f_name']))
			$form_f_name = addslashes($_POST['f_name']);
		
		$form_f_mi = 0;
		if (!empty($_POST['f_mi'])){
			$form_f_mi = $_POST['f_mi'];
		}
		
		$form_f_rank = 0;
		if (isset($_POST['f_rank']) && ctype_digit($_POST['f_rank']))
			$form_f_rank = $_POST['f_rank'];
	}else{
		$valid_entry = 0;
	}

	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['ft'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&ft='.$_REQUEST['ft'];
	}
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	//Database entry
	if($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		$sql_nl_update = "UPDATE `files` SET F_NAME = '$form_f_name', F_RANK = $form_f_rank, MI_ID = '$form_f_mi' WHERE F_ID = '$form_id'";
		$query_nl_update = mysql_query($sql_nl_update);
		if (!$query_nl_update){
			$valid_entry = 0;
			$commit = "rollback";
		}	
		
		//START: REPORT ACTION TO THE LOG FILE
		$sql_title = "SELECT * FROM `files` WHERE F_ID = '$form_id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = $result_title['F_FILENAME'];
		}
		$elog_action = "Επεξεργασία Αρχείου με όνομα ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=files&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>