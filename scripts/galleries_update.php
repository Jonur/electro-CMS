<?php
	require("session_isset.php");
	require("environment.php");
	
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['g_name'][$DLTL]) && !empty($_POST['edit_id']))
	{
		$form_id = $_POST['edit_id'];
		$form_g_name = $_POST['g_name'];
		foreach($form_g_name as $key=>$item){
			$form_g_name[$key] = addslashes($form_g_name[$key]);
		}
		
		$form_g_mi = 0;
		if (!empty($_POST['g_mi'])){
			$form_g_mi = $_POST['g_mi'];
		}
		
		$form_g_rank = 0;
		if (isset($_POST['g_rank']) && ctype_digit($_POST['g_rank']))
			$form_g_rank = $_POST['g_rank'];
		
		$form_g_visible = 0;
		if (isset($_POST['g_visible']) && is_numeric($_POST['g_visible']))
			$form_g_visible = 1;
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
	
	//Inserting the data row
	if ($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		$sql_g = "UPDATE `galleries` SET MI_ID = '$form_g_mi', G_RANK = $form_g_rank, G_VISIBLE = $form_g_visible WHERE G_ID = '$form_id'";
		$query_g = mysql_query($sql_g);
		if (!$query_g){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		if ($valid_entry)
		{
			$last_id = $form_id;
			//delete record if any
			$sql_delete_rows = "DELETE FROM `galleries-languages` WHERE G_ID = '$last_id'";
			if(!$query_delete_rows = mysql_query($sql_delete_rows)){
				$valid_entry = 0;
				$commit = "rollback";
			}
			foreach($form_g_name as $key=>$item)
			{
				if(!empty($form_g_name[$key]))
				{
					$sql_g_lang = "INSERT INTO `galleries-languages` VALUES ('$last_id', '$key', '$form_g_name[$key]')";
					$query_g_lang = mysql_query($sql_g_lang);
					if (!$query_g_lang){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
			}
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Επεξεργασία της Γκαλερί με όνομα ".$form_g_name[$DLTL];
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	//Redirection
	header('Location: ../?action=galleries&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>