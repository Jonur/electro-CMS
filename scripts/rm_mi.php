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
	$ctin = 2;
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
					//Protect the active menu-item from double titles and Friendly URLs
					$sql_getTitles = "SELECT * FROM `menu_items` 
									INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID = `menu_items-languages`.MI_ID 
									WHERE `menu_items`.MI_ID = '".$item[$i]."' ";
					$query_getTitles = mysql_query($sql_getTitles);
					while($result = mysql_fetch_array($query_getTitles)){
						$current_alias = $result['MIL_ALIAS'];
						$sql_alias = "SELECT * FROM `menu_items` 
									INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID = `menu_items-languages`.MI_ID 
									WHERE MIL_ALIAS = '".$current_alias."' ";
						$query_alias = mysql_query($sql_alias);
						if($result_alias = mysql_fetch_array($query_alias)){
							$sql_update_alias = "UPDATE `menu_items-languages` SET MIL_ALIAS = CONCAT('OLD_', MIL_ALIAS), MIL_FURL = CONCAT('OLD_', MIL_FURL) WHERE MI_ID = '".$item[$i]."' 
							AND MIL_ALIAS = '".$result_alias['MIL_ALIAS']."'";
							$query_update_alias = mysql_query($sql_update_alias);
							if (!$query_update_alias){
								$valid_entry = 0;
								$commit = "rollback";
							}
						}
						
					}
					
					$sql = "UPDATE `menu_items` SET MI_DELETED = 0 WHERE MI_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
				
				//START: REPORT ACTION TO THE LOG FILE
				$elog_action = "Ανάκτηση Στοιχείων Μενού από τη Διαχείριση Ανάκτησης";
				include("functions.php");
				eLog($elog_action);
				//END: REPORT ACTION TO THE LOG FILE
				
				break;
			case "prune":
				for($i=0;$i<count($item);$i++)
				{
					//Get Menu Item's Photo filename
					$sql = "SELECT * FROM `menu_items` WHERE MI_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					while($result = mysql_fetch_array($query))
					{
						$mi_photo[$i] = $result['MI_PHOTO'];
					}
					
					
					$sql = "DELETE FROM `menu_items` WHERE MI_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
					$sql = "DELETE FROM `menu_items-languages` WHERE MI_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
					
					//Clean-up ARTICLES
					$sql = "SELECT * FROM `articles` WHERE MI_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					while($result = mysql_fetch_array($query))
					{
						$sql_a = "UPDATE `articles` SET MI_ID=0 WHERE A_ID = '".$result['A_ID']."'";
						$query_a = mysql_query($query_a);
						if (!$query_a){
						$valid_entry = 0;
						$commit = "rollback";
						}
					}
					
					//Clean-up GALLERIES
					$sql = "SELECT * FROM `galleries` WHERE MI_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					while($result = mysql_fetch_array($query))
					{
						$sql_g = "UPDATE `articles` SET MI_ID=0 WHERE G_ID = '".$result['G_ID']."'";
						$query_g = mysql_query($query_g);
						if (!$query_g){
						$valid_entry = 0;
						$commit = "rollback";
						}
					}
					
					//Clean-up FILES
					$sql = "SELECT * FROM `files` WHERE MI_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					while($result = mysql_fetch_array($query))
					{
						$sql_f = "UPDATE `articles` SET MI_ID = 0 WHERE F_ID = '".$result['F_ID']."'";
						$query_f = mysql_query($query_f);
						if (!$query_f){
						$valid_entry = 0;
						$commit = "rollback";
						}
					}
				}
				
				//START: REPORT ACTION TO THE LOG FILE
				$elog_action = "Διαγραφή Στοιχείων Μενού από τη Διαχείριση Ανάκτησης";
				include("functions.php");
				eLog($elog_action);
				//END: REPORT ACTION TO THE LOG FILE
				
				break;
			default:
				$valid_entry = 0;
		}
		
		if($valid_entry && $action=="prune")
		{
			for($i=0;$i<count($item);$i++)
			{
				@unlink($uploaddir_menu_item.$mi_photo[$i]);
			}
		}
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=restore_manager&validation='.$valid_entry.'&'.$tab_select);
?>