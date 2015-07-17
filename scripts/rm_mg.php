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
	$ctin = 1;
	if (!empty($_REQUEST['ctin']) && !empty($_REQUEST['ctsn']))
	{
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
					$sql = "UPDATE `menu_groups` SET MG_DELETED = 0 WHERE MG_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
				
				//START: REPORT ACTION TO THE LOG FILE
				$elog_action = "Ανάκτηση Ομάδων Μενού από τη Διαχείριση Ανάκτησης";
				include("functions.php");
				eLog($elog_action);
				//END: REPORT ACTION TO THE LOG FILE
				
				break;
			case "prune":
				for($i=0;$i<count($item);$i++)
				{
					$sql = "DELETE FROM `menu_groups` WHERE MG_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
					$sql = "DELETE FROM `menu_groups-menu_items` WHERE MG_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
					$sql = "DELETE FROM `menu_groups-languages` WHERE MG_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
				
				//START: REPORT ACTION TO THE LOG FILE
				$elog_action = "Διαγραφή Ομάδων Μενού από τη Διαχείριση Ανάκτησης";
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