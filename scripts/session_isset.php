<?php
	session_start();
	if(empty($_SESSION['EU_ID']) || empty($_SESSION['EU_USERNAME']) || empty($_SESSION['EU_LEVEL'])){
		header('Location: logout.php');
		exit;
	}
?>