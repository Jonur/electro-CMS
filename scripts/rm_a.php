<?php
	require("session_isset.php"); 
	//Get values
	$valid_entry =1;
	if(!empty($_REQUEST['action']) && !empty($_POST['item'])){
		$action = $_REQUEST['action'];
		$item = $_POST['item'];
	}else{
		$valid_entry = 0;
	}
	
	//START: CTSN/CTIN
	//Get values for Tab-Set name and Tab Index number to return to the correct jQuery UI tab
	$ctsn = 'entity_tabs';
	$ctin = 3;
	if (!empty($_REQUEST['ctin']) && !empty($_REQUEST['ctsn'])){
		$ctsn = $_REQUEST['ctsn'];
		$ctin = $_REQUEST['ctin'];
	}
	$tab_select = 'ctsn='.$ctsn.'&ctin='.$ctin;
	//END: CTSN/CTIN
	
	if($valid_entry)
	{	
		require("db_connect.php");
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		switch($action)
		{	
			case "restore":
				for($i=0;$i<count($item);$i++)
				{
					$updateTitleFurl ='';
					$a_title = '';
					$a_furl = '';
					$a_mi = '';
					
					//Protect the active `articles` from double titles and Friendly URLs
					$sql_getTitle = "SELECT * FROM `articles` WHERE A_ID = '".$item[$i]."'";
					$query_getTitle = mysql_query($sql_getTitle);
					if($result = mysql_fetch_array($query_getTitle)){
						$a_title = $result['A_TITLE'];
						$a_furl = $result['A_FURL'];
						$a_mi = $result['MI_ID'];
					}
					
					$sql_furl = "SELECT * FROM `articles` WHERE A_TITLE = '$a_title' AND MI_ID = '$a_mi' AND A_DELETED = 0 LIMIT 1";
					$query_furl = mysql_query($sql_furl);
					if (mysql_num_rows($query_furl)){
						$updateTitleFurl = ", A_TITLE = 'OLD_".$a_title."', A_FURL = 'OLD_".$a_furl."' ";
					}
					
					$sql = "UPDATE `articles` SET A_DELETED = 0 ".$updateTitleFurl." WHERE A_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
				
				//START: REPORT ACTION TO THE LOG FILE
				$elog_action = "Ανάκτηση Άρθρων από τη Διαχείριση Ανάκτησης";
				include("functions.php");
				eLog($elog_action);
				//END: REPORT ACTION TO THE LOG FILE
				
				break;
			case "prune":
				for($i=0;$i<count($item);$i++)
				{
					$sql = "DELETE FROM `articles` WHERE A_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
					$sql = "DELETE FROM `articles-languages` WHERE A_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
					$sql = "DELETE FROM `articles-galleries` WHERE A_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
				
				//START: REPORT ACTION TO THE LOG FILE
				$elog_action = "Διαγραφή Άρθρων από τη Διαχείριση Ανάκτησης";
				include("functions.php");
				eLog($elog_action);
				//END: REPORT ACTION TO THE LOG FILE
				
				break;
			default:
				$valid_entry = 0;
		}
		
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=restore_manager&validation='.$valid_entry.'&'.$tab_select);
?>