<?php
	require("session_isset.php");
	require("environment.php");

	//Get the form values
	$valid_entry = 1;
	
	if(!empty($_REQUEST['id'])){
		$id = $_REQUEST['id'];
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
	if (!empty($_REQUEST['tmg'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tmg='.$_REQUEST['tmg'];
	}
	
	//Deleting the data row
	if ($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		$sql_mi_delete = "UPDATE `menu_items` SET MI_DELETED = 1 WHERE MI_ID = '$id'";
		$query_mi_delete = mysql_query($sql_mi_delete);
		if (!$query_mi_delete){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: FIX THE CHAIN OF MENU ITEM TREE
		$set_mother = 0;
		$sql_get_mother = "SELECT * FROM `menu_items` WHERE MI_ID = '$id'";
		$query_get_mother = mysql_query($sql_get_mother);
		while($result_get_mother = mysql_fetch_array($query_get_mother))
		{
			if ($result_get_mother['MI_MOTHER'])
				$set_mother = $result_get_mother['MI_MOTHER'];
		}
		
		$sql_fix_children = "SELECT * FROM `menu_items` WHERE MI_MOTHER='$id'";
		$query_fix_children = mysql_query($sql_fix_children);
		while($result_fix_children = mysql_fetch_array($query_fix_children))
		{
			$sql_update_child = "UPDATE `menu_items` SET MI_MOTHER='".$set_mother."' WHERE MI_ID='".$result_fix_children['MI_ID']."'";
			$query_update_child = mysql_query($sql_update_child);
			if (!$query_update_child){
				$valid_entry = 0;
				$commit = "rollback";
			}
		}
		//END: FIX THE CHAIN OF MENU ITEM TREE
		
		//START: REPORT ACTION TO THE LOG FILE
		$sql_title = "SELECT * FROM `menu_items-languages` WHERE L_ID = '$DLTL' AND MI_ID = '$id'";
		$query_title = mysql_query($sql_title);
		while($result_title = mysql_fetch_array($query_title)){
			$title = $result_title['MIL_ALIAS'];
		}
		$elog_action = "Διαγραφή Στοιχείου Μενού με τίτλο ".$title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=menu_items&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>