<?php
	require("session_isset.php");
	require("environment.php");
	
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['mg_title'][$DLTL]) && !empty($_POST['edit_id'])){
		$form_id = $_POST['edit_id'];
		$form_mg_title = $_POST['mg_title'];
		foreach($form_mg_title as $key=>$item){
			$form_mg_title[$key] = addslashes($form_mg_title[$key]);
		}
		
		$form_mg_rank = 0;
		if (isset($_POST['mg_rank']) && ctype_digit($_POST['mg_rank']))
			$form_mg_rank = $_POST['mg_rank'];
		
		$form_mg_visible = 0;
		if (isset($_POST['mg_visible']) && is_numeric($_POST['mg_visible']))
			$form_mg_visible = 1;
	}else{
		$valid_entry = 0;
	}
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['tl'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tl='.$_REQUEST['tl'];
	}
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	//Updating the data row
	if ($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		$sql_mg = "UPDATE `menu_groups` SET MG_RANK = $form_mg_rank, MG_VISIBLE = $form_mg_visible WHERE MG_ID = '$form_id'";
		$query_mg = mysql_query($sql_mg);
		if (!$query_mg){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		if ($valid_entry)
		{
			$last_id = $form_id;
			//delete record if any
			$sql_delete_rows = "DELETE FROM `menu_groups-languages` WHERE MG_ID = '$last_id'";
			if(!$query_delete_rows = mysql_query($sql_delete_rows)){
				$valid_entry = 0;
				$commit = "rollback";
			}
			foreach($form_mg_title as $key=>$item)
			{
				if(!empty($form_mg_title[$key]))
				{
					$sql_mg_lang = "INSERT INTO `menu_groups-languages` VALUES ('$last_id', '$key', '$form_mg_title[$key]')";
					$query_mg_lang = mysql_query($sql_mg_lang);
					if (!$query_mg_lang){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
			}
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Επεξεργασία Ομάδας Μενού με τίτλο ".$form_mg_title[$DLTL];
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=menu_groups&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>