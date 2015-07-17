<?php
	//Defines a constant to prevent include `files` running with direct access
	define("ELECTRO_DIRECT_URL_ACCESS", false);
	
	//check for non logged users
	if (!isset($_SESSION['LOGGEDIN'])){
		$left_view = "scripts/login_form.php";
	}else{
		$left_view = "scripts/menu_generator.php";
	}
	
	//Get selected action
	$action_file = '';
	$actual_action = '';
	if(!empty($_REQUEST['action'])){
		$actual_action = $_REQUEST['action'];
		$action_file = 'scripts/'.$_REQUEST['action'].'.php';
	}
	if ($actual_action == 'basic_settings'){ //Refresh cache for correct .ICO preview
		header("Cache-Control: no-cache, must-revalidate");
	}
	
	//Get action success or failure state and create user notification
	$validation = '';
	$validation_message = '';
	if(isset($_REQUEST['validation'])){
		$validation = $_REQUEST['validation'];
		if ($validation)
		{
			$validation_message = '<div class="validation_message true">Επιτυχής ενέργεια!</div>';
		}else{
			$validation_message = '<div class="validation_message false">Η ενέργεια δεν ολοκληρώθηκε.</div>';
		}
	}
	
	//Get log in success or failure and create user notification
	if(!empty($_REQUEST['error_state'])){
		if ($_REQUEST['error_state'] == 99)
			$error_state_msg = '<div class="login_error">Λανθασμένο Όνομα Χρήστη ή/και Συνθηματικό</div>';
		if ($_REQUEST['error_state'] == 14)
			$error_state_msg = '<div class="login_error">Η συνεδρία τερματίστηκε λόγω εκτεταμένης αδράνειας.</div>';
		if ($_REQUEST['error_state'] == 7)
			$error_state_msg = '<div class="login_error">Λανθασμένοι παράμετροι στην εγκατάσταση του electro. Επικοινωνήστε με το διαχειριστή του συστήματος.</div>';
	}else{
		$error_state_msg = "";
	}
	
	//Get the $DLTL - Default Language for Tab Listing
	if(!empty($_SESSION['EU_ID'])){
		$DLTL = $_SESSION['DLTL'];
	}else{
		$DLTL = '';
	}
?>