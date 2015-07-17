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
	$ctin = 5;
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
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		switch($action)
		{	
			case "restore":
				for($i=0;$i<count($item);$i++)
				{
					$sql = "UPDATE `files` SET F_DELETED = 0 WHERE F_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
				
				//START: REPORT ACTION TO THE LOG FILE
				$elog_action = "Ανάκτηση Αρχείων από τη Διαχείριση Ανάκτησης";
				eLog($elog_action);
				//END: REPORT ACTION TO THE LOG FILE
				
				break;
			case "prune":
				for($i=0;$i<count($item);$i++)
				{
					//Get filename
					$sql = "SELECT * FROM `files` WHERE F_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					while($result = mysql_fetch_array($query))
					{
						$filename = $result['F_FILENAME'];
					}
					
					$sql = "DELETE FROM `files` WHERE F_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
					$sql = "DELETE FROM `galleries-files` WHERE F_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
					$sql = "DELETE FROM `articles-files` WHERE F_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
					$sql = "DELETE FROM `image_captions` WHERE F_ID = '".$item[$i]."'";
					$query = mysql_query($sql);
					if (!$query){
						$valid_entry = 0;
						$commit = "rollback";
					}
					
					//START: REPORT ACTION TO THE LOG FILE
					$elog_action = "Διαγραφή Αρχείων από τη Διαχείριση Ανάκτησης";
					eLog($elog_action);
					//END: REPORT ACTION TO THE LOG FILE
					
					if ($valid_entry){
						$uploadfile = $uploaddir_img.$filename;
						@unlink($uploadfile);
						$uploadfile = $uploaddir_img.'thumbs/thumb_'.$filename;
						@unlink($uploadfile);
						$uploadfile = $uploaddir_text.$filename;
						@unlink($uploadfile);
						$uploadfile = $uploaddir_audio.$filename;
						@unlink($uploadfile);
					}
				}
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