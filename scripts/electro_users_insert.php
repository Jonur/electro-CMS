<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	if ((empty($_POST['eu_email']) || filter_var($_POST['eu_email'], FILTER_VALIDATE_EMAIL)) && !empty($_POST['eu_username']) && !empty($_POST['eu_pwd']) && !empty($_POST['eu_pwd_re']) && $_POST['eu_pwd'] == $_POST['eu_pwd_re'] && isset($_POST['eu_level'])){		
		$form_eu_email = addslashes($_POST['eu_email']);
		$form_eu_username = addslashes($_POST['eu_username']);
		$form_eu_level = $_POST['eu_level'];
		
		$pos = strpos($_POST['eu_pwd'], " ");
		$pwd_len = strlen($_POST['eu_pwd']);
		if ($pos === false && $pwd_len >=4)
		{
			$form_eu_pwd = md5($_POST['eu_pwd']);
		}else{
			$valid_entry = 0;
		}
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
			$sql_id = "SELECT * FROM `menu_groups` WHERE MG_ID='".$generatedId."'";
			$query_id = mysql_query($sql_id);
			$rows = mysql_num_rows($query_id);
		}while($rows);
		//END: Generate ID
		
		$sql_nl = "INSERT INTO `electro_users` VALUES ('$generatedId', '$form_eu_username', '$form_eu_pwd', '$form_eu_email', '$form_eu_level', '')";
		$query_nl = mysql_query($sql_nl);
		if (!$query_nl){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Προσθήκη Χρήστη electro με username ".$form_eu_username;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=electro_users_create&validation='.$valid_entry);
?>