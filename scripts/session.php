<?php
	session_start();
	
	$inactive = 1800; //Set timeout period in seconds
	// check to see if $_SESSION['timeout'] is set
	if(isset($_SESSION['timeout'])) 
	{
		$session_life = time() - $_SESSION['timeout'];
		if($session_life > $inactive)
		{
			unset($_SESSION['EU_ID']);
			unset($_SESSION['EU_USERNAME']);
			unset($_SESSION['EU_LEVEL']);
			session_destroy();
			header('Location: ../electro/?error_state=14');
			exit;
		}
	}
	$_SESSION['timeout'] = time();
?>