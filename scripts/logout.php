<?php
	session_start();
	unset($_SESSION['EU_ID']);
	unset($_SESSION['EU_USERNAME']);
	unset($_SESSION['EU_LEVEL']);
	session_destroy();
	
	//Redirect
	header('Location: ../');
?>