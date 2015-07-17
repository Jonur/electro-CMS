<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['c_name']) && !empty($_POST['p_id'])){
		$form_c_name = addslashes($_POST['c_name']);
		$form_c_info = addslashes($_POST['c_info']);
		
		//check if url return 404
		$form_c_url = addslashes($_POST['c_url']);
		if(!empty($form_c_url)){
			$handle = curl_init($form_c_url);
			curl_setopt($handle,  CURLOPT_RETURNTRANSFER, TRUE);

			/* Get the HTML or whatever is linked in $url. */
			$response = curl_exec($handle);

			/* Check for 404 (file not found). */
			$httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
			if($httpCode == 404) {
				/* Handle 404 here. */
				$valid_entry = 0;
			}

			curl_close($handle);
		}
		
		$form_p_id = $_POST['p_id'];
	}else{
		$valid_entry = 0;
	}
	
	//Inserting the data row
	if ($valid_entry)
	{
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		//START: Generate ID
		do{
			$generatedId = generateId();
			$sql_id = "SELECT * FROM `contestants` WHERE C_ID = '".$generatedId."'";
			$query_id = mysql_query($sql_id);
			$rows = mysql_num_rows($query_id);
		}while($rows);
		//END: Generate ID
		
		$sql_c = "INSERT INTO `contestants` VALUES ('$generatedId','$form_c_name','$form_c_info','$form_c_url')";
		$query_c = mysql_query($sql_c);
		if (!$query_c){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		$last_id = $generatedId;
		
		$sql_p = "INSERT INTO `polls-contestants` VALUES ('$form_p_id','$last_id',0)";
		$query_p = mysql_query($sql_p);
		if (!$query_p){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Προσθήκη Συμμετέχοντος με όνομα ".$form_c_name;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=contestants_create&validation='.$valid_entry);
?>