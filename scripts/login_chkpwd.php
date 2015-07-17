<?php 
	//Get values from log in form
	$form_un = addslashes($_POST['electro_un']);
	$form_pw = $_POST['electro_pw'];
	
	//We connect from the database
	require("db_connect.php");
		
	//Check username and password
	$hash = md5($form_pw);
	$sql = "SELECT * FROM `electro_users` WHERE EU_USERNAME = '$form_un' AND EU_PASSWORD = '$hash'";
	$query = mysql_query($sql);
	$result = mysql_fetch_array($query);
	$rows = mysql_num_rows($query);

	//We check if the inputed username and password exist and are both correct
	//If the inputed values are correct, then we proceed to the main.php file where the user gains access to the CMS.
	//Else, the user is automatically redirected to the initial log-in screen; this time with an indication that he/she has inputed wrong data.
	if ($rows){
		//Before proceeding, we open a session to store useful data about the user
		session_start();
		$_SESSION['EU_ID'] = $result['EU_ID'];
		$_SESSION['EU_USERNAME'] = $result['EU_USERNAME'];
		$_SESSION['EU_LEVEL'] = $result['EU_LEVEL'];
		
		//update the user's record with his last login
		$now = date("Y-m-d H:i:s");
		$thisone = $result['EU_ID'];
		$sql_enterlastlogin = "UPDATE `electro_users` SET EU_LASTLOGIN = '$now' WHERE EU_ID = '$thisone'";
		$query_enterlastlogin = mysql_query($sql_enterlastlogin);
		
		$sql_dltl = "SELECT L_ID FROM `languages` WHERE L_DEFAULT = 1 LIMIT 1";
		$query_dltl = mysql_query($sql_dltl) or die(mysql_error());
		if ($result_dltl = mysql_fetch_array($query_dltl)){
			$_SESSION['DLTL'] = $result_dltl['L_ID'];
		}else{
			unset($_SESSION['EU_ID']);
			unset($_SESSION['EU_USERNAME']);
			unset($_SESSION['EU_LEVEL']);
			session_destroy();
			header('Location: ../?error_state=7');
			return;
		}
		
		//and then we redirect the user to the CMS
		header('Location: ../');
	}else{
		header('Location: ../?error_state=99');
	}
	
	//We disconnect from the database
	require("db_disconnect.php");
?>