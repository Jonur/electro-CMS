<?php
	require("environment.php");
	@$con = mysql_connect($db_host,$db_username,$db_password);
	if (!$con)
	{
		die('Could not connect: ' . mysql_error());
	}
	mysql_query("SET NAMES 'utf8'", $con);
	mysql_query("SET CHARACTER SET 'utf8'", $con);
	mysql_select_db($db_name, $con);
	mysql_set_charset('utf8',$con);
?>