<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	if ((empty($_POST['wu_email']) || filter_var($_POST['wu_email'], FILTER_VALIDATE_EMAIL)) && !empty($_POST['wu_un']) && ((empty($_POST['wu_pwd']) && empty($_POST['wu_pwd_re'])) || $_POST['wu_pwd'] == $_POST['wu_pwd_re']) 
		&& !empty($_POST['edit_id'])){		
		$form_id = $_POST['edit_id'];
		$form_wu_username = addslashes($_POST['wu_un']);
		
		$set_password = "";
		if (!empty($_POST['wu_pwd'])){
			$pos = strpos($_POST['wu_pwd'], " ");
			$pwd_len = strlen($_POST['wu_pwd']);
			if ($pos === false && $pwd_len >=4){
				$form_wu_pwd = md5($_POST['wu_pwd']);
				$set_password = ", WU_PASSWORD = '$form_wu_pwd'";
			}else{
				$valid_entry = 0;
			}
		}
		
		$form_wu_brandname = addslashes($_POST['wu_brandname']);
		$form_wu_fname = addslashes($_POST['wu_fname']);
		$form_wu_lname = addslashes($_POST['wu_lname']);
		$form_wu_address = addslashes($_POST['wu_address']);
		$form_wu_zipcode = addslashes($_POST['wu_zipcode']);
		$form_wu_city = addslashes($_POST['wu_city']);
		$form_wu_country = addslashes($_POST['wu_country']);
		$form_wu_tel = addslashes($_POST['wu_tel']);
		$form_wu_cel = addslashes($_POST['wu_cel']);
		$form_wu_fax = addslashes($_POST['wu_fax']);
		$form_wu_email = addslashes($_POST['wu_email']);
		$form_wu_afm = addslashes($_POST['wu_afm']);
		$form_wu_comments = addslashes($_POST['wu_comments']);

		$form_wu_date_start = '';
		$form_wu_date_expire = '';
		if(!empty($_POST['wu_date_start']) && !empty($_POST['wu_date_expire'])){
			if($_POST['wu_date_expire'] < $_POST['wu_date_start']){
				$valid_entry = 0;
			}else{
				$form_wu_date_start = $_POST['wu_date_start'];
				$form_wu_date_expire = $_POST['wu_date_expire'];
			}
		}else{
			if(empty($_POST['wu_date_start']) && empty($_POST['wu_date_expire'])){
				$form_wu_date_start = '';
				$form_wu_date_expire = '';
			}else{
				$valid_entry = 0;
			}
		}
		
		$form_wu_active = 0;
		if (isset($_POST['wu_active']) && is_numeric($_POST['wu_active']))
			$form_wu_active = 1;
		
	}else{
		$valid_entry = 0;
	}
	
	//Create selected options for URL
	$TOOLBOX_SELECTED_OPTIONS = '';
	if (!empty($_REQUEST['tob'])){
		$TOOLBOX_SELECTED_OPTIONS .= '&tob='.$_REQUEST['tob'];
	}
	
	//Inserting the data row
	if ($valid_entry){
		require("db_connect.php");
		include("functions.php");
		
		//Begin Transaction
		$commit = "commit";
		mysql_query("begin", $con);
		
		$sql_nl = "UPDATE `website_users` SET WU_USERNAME = '$form_wu_username', WU_BRANDNAME = '$form_wu_brandname', WU_FNAME = '$form_wu_fname', WU_LNAME = '$form_wu_lname', WU_ADDRESS = '$form_wu_address', WU_ZIPCODE = '$form_wu_zipcode', WU_CITY = '$form_wu_city', WU_COUNTRY = '$form_wu_country', WU_TEL = '$form_wu_tel', WU_CEL = '$form_wu_cel', WU_FAX = '$form_wu_fax', WU_EMAIL = '$form_wu_email', WU_AFM = '$form_wu_afm', WU_COMMENTS = '$form_wu_comments', WU_DATESTART = '$form_wu_date_start', WU_DATEEXPIRE = '$form_wu_date_expire', WU_ACTIVE = $form_wu_active $set_password WHERE WU_ID = '$form_id'";
		$query_nl = mysql_query($sql_nl);
		if (!$query_nl){
			$valid_entry = 0;
			$commit = "rollback";
		}
		
		//START: REPORT ACTION TO THE LOG FILE
		$elog_action = "Επεξεργασία Χρήστη Ιστότοπου με username ".$form_wu_username;
		eLog($elog_action);
		//END: REPORT ACTION TO THE LOG FILE
		
		//End Transaction - Commit or Rollback
		mysql_query($commit);
		require("db_disconnect.php");
	}
	
	//Redirection
	header('Location: ../?action=website_users&validation='.$valid_entry.$TOOLBOX_SELECTED_OPTIONS);
?>