<?php
	require("session_isset.php");
	$valid_entry = 1; 
	
	//Get Form Values
	$form_subject = $_POST['mail_subject'];
	$form_body = stripslashes($_POST['mail_body']);
	$form_a_id = $_POST['a_id'];
	
	if (empty($form_subject) || empty($form_body))
		$valid_entry = 0;
	
	if ($valid_entry)
	{
		//Attach the article
		include("db_connect.php");
		include("functions.php");
		
		$sql_a = "SELECT * FROM `articles` WHERE A_ID = '$form_a_id'";
		$query_a = mysql_query($sql_a) or die(mysql_error());
		while ($result_a = mysql_fetch_array($query_a))
			$form_body .= '<hr /><br />'.stripslashes($result_a['A_BODY']).'<br /><hr />';
		
		//IF images in BODY change URL relative paths to absolute http 
		$form_body = str_replace($image_server_relative_path, $image_server_full_path, $form_body);
		
		//Compose the e-mail
		$charset = "UTF-8";
		$mail_to = '';
		$email = $owner_email_address;
		$name = $owner_title;
		$subject = $form_subject;
		$output = $form_body;
		
		//Form the BCC Headers
		$sql_bcc = "SELECT * FROM `newsletter_members`";
		$query_bcc = mysql_query($sql_bcc);
		$bcc_header = 'Bcc: ';
		$rows_bcc = mysql_num_rows($query_bcc);
		while ($result_bcc = mysql_fetch_array($query_bcc))
		{
			$bcc_header .= $result_bcc['NM_EMAIL'].',';
		}
		$bcc_header .= "\n";
		include("db_disconnect.php");
		
		if($rows_bcc)
		{
			$snd_name_addr_enc = "=?$charset?B?".base64_encode($name)."?="." <".$email.">";
			$subject = "=?$charset?B?". base64_encode($subject) . '?=';	
			
					
			$hdrs = "From: ".$snd_name_addr_enc."\n".
			  "MIME-Version: 1.0\n". 
			  "Content-Type: text/html; charset=$charset; format=flowed\n".$bcc_header.
			  "Content-Transfer-Encoding: 8bit\n". 
			  "Message-ID: <".md5(uniqid(time()))."@{$_SERVER['SERVER_NAME']}>\n".
			  "X-Mailer: PHP/".phpversion();

			@mail($mail_to, $subject, $output, $hdrs) or die(header('Location: ../?action=nl_send_mail&validation=0'));
			
			//START: REPORT ACTION TO THE LOG FILE
			include("db_connect.php");
			
			//Begin Transaction
			$commit = "commit";
			mysql_query("begin", $con);
			$elog_action = "Αποστολή Μαζικού e-mail με Θέμα ".$form_subject;
			eLog($elog_action);
			//End Transaction - Commit or Rollback
			
			mysql_query($commit);
			include("db_disconnect.php");
			//END: REPORT ACTION TO THE LOG FILE
			
		}else{
			$valid_entry = 0;
		}
	}
	
	//Redirection
	header('Location: ../?action=nl_send_mail&validation='.$valid_entry);
?>