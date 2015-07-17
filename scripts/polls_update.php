<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['p_title']) && !empty($_POST['edit_id'])){
		$form_id = $_POST['edit_id'];
		$form_p_title = addslashes($_POST['p_title']);
		$form_p_info = addslashes($_POST['p_info']);
		
		$form_p_startdate = '';
		$form_p_enddate = '';
		if(!empty($_POST['p_startdate']) && !empty($_POST['p_enddate']))
		{
			if($_POST['p_enddate'] < $_POST['p_startdate']){
				$valid_entry = 0;
			}else{
				$form_p_startdate = $_POST['p_startdate'];
				$form_p_enddate = $_POST['p_enddate'];
			}
		}else{
			if(empty($_POST['p_startdate']) && empty($_POST['p_enddate'])){
				$form_p_startdate = '';
				$form_p_enddate = '';
			}else{
				$valid_entry = 0;
			}
		}
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
		
		$sql_p = "UPDATE `polls` SET P_TITLE = '$form_p_title', P_INFO = '$form_p_info', P_STARTDATE = '$form_p_startdate', P_ENDDATE = '$form_p_enddate' WHERE P_ID = '$form_id'";
		$query_p = mysql_query($sql_p);
		if (!$query_p){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Επεξεργασία Διαγωνισμού με τίτλο ".$form_p_title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}

	//Redirection
	header('Location: ../?action=polls&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>