<?php
	require("session_isset.php");
	require("environment.php");
	
	//Get the form values
	$valid_entry = 1;
	if (!empty($_POST['a_title']) && !empty($_POST['a_body']) && !empty($_POST['edit_id'])){	
		$form_id = $_POST['edit_id'];
		$form_a_title = addslashes($_POST['a_title']);
		
		$form_a_info= '';
		if (!empty($_POST['a_info'])){
			$form_a_info = addslashes($_POST['a_info']);
		}
		
		$form_a_mi= 0;
		if (!empty($_POST['a_mi'])){
			$form_a_mi = $_POST['a_mi'];
		}
		
		$form_a_body = addslashes($_POST['a_body']);
		
		$form_a_lang[0] = $DLTL;
		if (!empty($_POST['a_lang']))
			$form_a_lang = $_POST['a_lang'];
		
		$form_a_rank = 0;
		if (isset($_POST['a_rank']) && ctype_digit($_POST['a_rank']))
			$form_a_rank = $_POST['a_rank'];
		
		$form_a_visible = 0;
		if (isset($_POST['a_visible']) && is_numeric($_POST['a_visible']))
			$form_a_visible = 1;
			
		$form_a_direct = 0;
		if (isset($_POST['a_direct']) && is_numeric($_POST['a_direct']))
			$form_a_direct = 1;
			
		$form_a_meta_description = addslashes($_POST['a_meta_description']);
		if(!empty($form_a_meta_description) && (mb_strlen($form_a_meta_description,'utf-8') < 70 || mb_strlen($form_a_meta_description,'utf-8') > 160)){
			$valid_entry = 0;
		}
		
		$form_a_meta_keywords = '';
		if (!empty($_POST['a_meta_keywords']))
			$form_a_meta_keywords = addslashes($_POST['a_meta_keywords']);
			
		$form_a_gallery = 0;
		if (!empty($_POST['a_gallery']))
			$form_a_gallery = $_POST['a_gallery'];

		$form_a_file = 0;
		if (!empty($_POST['a_file']))
			$form_a_file = $_POST['a_file'];
	}else{
		$valid_entry = 0;
	}
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['tl'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tl='.$_REQUEST['tl'];
	}
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
		
		//create friendly URL
		$a_furl = create_furl($form_a_title).'.html';
		$sql_furl = "SELECT * FROM `articles` WHERE A_FURL = '$a_furl' AND MI_ID = '$form_a_mi' AND A_DELETED = 0 AND A_ID <> '$form_id'";
		$query_furl = mysql_query($sql_furl);
		if (mysql_num_rows($query_furl)){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		$sql_a = "UPDATE `articles` SET A_TITLE = '$form_a_title', A_FURL = '$a_furl', A_INFO = '$form_a_info', MI_ID = '$form_a_mi', A_BODY = '$form_a_body', A_RANK = $form_a_rank, A_VISIBLE = $form_a_visible, A_DIRECT = $form_a_direct, A_META_DESCRIPTION = '$form_a_meta_description', A_META_KEYWORDS = '$form_a_meta_keywords' WHERE A_ID = '$form_id'";
		$query_a = mysql_query($sql_a);
		if (!$query_a){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		if ($valid_entry)
		{
			$last_id = $form_id;
			//empty tables
			$sql_delete_rows = "DELETE FROM `articles-languages` WHERE A_ID = '$last_id'";
			if(!$query_delete_rows = mysql_query($sql_delete_rows)){
				$valid_entry = 0;
				$commit = "rollback";
			}
			$sql_delete_rows = "DELETE FROM `articles-galleries` WHERE A_ID = '$last_id'";
			if(!$query_delete_rows = mysql_query($sql_delete_rows)){
				$valid_entry = 0;
				$commit = "rollback";
			}
			$sql_delete_rows = "DELETE FROM `articles-files` WHERE A_ID = '$last_id'";
			if(!$query_delete_rows = mysql_query($sql_delete_rows)){
				$valid_entry = 0;
				$commit = "rollback";
			}
			
			//insert languages
			for($i=0;$i<count($form_a_lang);$i++)
			{
				$sql_a_lang = "INSERT INTO `articles-languages` VALUES ('$last_id', '".$form_a_lang[$i]."')";
				$query_a_lang = mysql_query($sql_a_lang);
				if (!$query_a_lang){
					$valid_entry = 0;
					$commit = "rollback";
				}
			}
			//insert galleries
			if ($form_a_gallery){
				for($i=0;$i<count($form_a_gallery);$i++)
				{
					$sql_a_gallery = "INSERT INTO `articles-galleries` VALUES ('$last_id', '".$form_a_gallery[$i]."')";
					$query_a_gallery = mysql_query($sql_a_gallery);
					if (!$query_a_gallery){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
			}
			//insert files
			if ($form_a_file){
				for($i=0;$i<count($form_a_file);$i++)
				{
					$sql_a_file = "INSERT INTO `articles-files` VALUES ('$last_id', '".$form_a_file[$i]."')";
					$query_a_file = mysql_query($sql_a_file);
					if (!$query_a_file){
						$valid_entry = 0;
						$commit = "rollback";
					}
				}
			}
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Επεξεργασία Άρθρου με τίτλο ".$form_a_title;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=articles&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>