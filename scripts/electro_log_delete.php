<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	
	//Deleting the data row
	if ($valid_entry)
	{
		require("db_connect.php");
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		//Empty the table (TRUNCATE also resets the AUTO_INCREMENT value to 1)
		$sql_el_delete = "TRUNCATE TABLE `electro_log`";
		$query_el_delete = mysql_query($sql_el_delete);
		if (!$query_el_delete){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=electro_log&validation='.$valid_entry);
?>