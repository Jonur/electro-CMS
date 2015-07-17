<?php
	require("environment.php");
	$mysqli = new mysqli($db_host, $db_username, $db_password, $db_name);
	/* check connection */
	if (mysqli_connect_errno()) {
		printf("Connect failed: %s\n", mysqli_connect_error());
		exit();
	}
	if (!$mysqli->set_charset("utf8")) {
		printf("Error loading character set utf8: %s\n", $mysqli->error);
	} else {
		//printf("Current character set: %s\n", $mysqli->character_set_name());
	}
?>