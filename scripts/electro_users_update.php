<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	if ((empty($_POST['eu_email']) || filter_var($_POST['eu_email'], FILTER_VALIDATE_EMAIL)) && !empty($_POST['eu_username']) && ((empty($_POST['eu_pwd']) && empty($_POST['eu_pwd_re'])) || $_POST['eu_pwd'] == $_POST['eu_pwd_re'])
		&& !empty($_POST['edit_id']) && isset($_POST['eu_level'])){
		$form_id = $_POST['edit_id'];
		$form_eu_email = addslashes($_POST['eu_email']);
		$form_eu_username = addslashes($_POST['eu_username']);
		$form_eu_level = $_POST['eu_level'];
		
		$set_password = "";
		if (!empty($_POST['eu_pwd'])){
			$pos = strpos($_POST['eu_pwd'], " ");
			$pwd_len = strlen($_POST['eu_pwd']);
			if ($pos === false && $pwd_len >=4){
				$form_eu_pwd = md5($_POST['eu_pwd']);
				$set_password = ", EU_PASSWORD = '$form_eu_pwd'";
			}else{
				$valid_entry = 0;
			}
		}
		
	}else{
		$valid_entry = 0;
	}
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
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
		
		$sql_nl = "UPDATE `electro_users` SET EU_USERNAME = '$form_eu_username', EU_EMAIL='$form_eu_email', EU_LEVEL='$form_eu_level' $set_password WHERE EU_ID = '$form_id'";
		//echo $sql_nl;return;
		$query_nl = mysql_query($sql_nl);
		if (!$query_nl){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Επεξεργασία Χρήστη electro με username ".$form_eu_username;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=electro_users&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>