<?php
	//Environment variables
	$db_name = "electro";
	$db_host = "localhost";
	$db_username = "root";
	$db_password = "";
	
	//Standard time zone UTC/GMT+2 in use
	date_default_timezone_set('Europe/Athens');
	
	//Website FrontEnd and BackEnd relative links and Domain Link
	$website_url = "http://www.cmagnet.gr/";
	$front_end_url = "../";
	$back_end_url = "electro/";
	
	//Newsletter
	$owner_email_address = "info@cmagnet.gr";
	$owner_title = "Local Website";
	$image_server_relative_path = '/electro/upload_images/images/';
	$image_server_full_path = 'http://www.cmagnet.gr/electro/upload_images/images/';
	
	//Upload and Call paths
	//Server Paths (Upload) - getcwd()
	$FILES_DIR_PREFIX = 'C:\Program Files (x86)\EasyPHP-DevServer-13.1VC9\data\localweb\electro\upload_files\\';
	$FILES_DIR_SUFFIX = '\\';
	
	$uploaddir_img = $FILES_DIR_PREFIX.'images'.$FILES_DIR_SUFFIX;
	$uploaddir_text = $FILES_DIR_PREFIX.'text'.$FILES_DIR_SUFFIX;
	$uploaddir_audio = $FILES_DIR_PREFIX.'audio'.$FILES_DIR_SUFFIX;
	$uploaddir_menu_item = $FILES_DIR_PREFIX.'mi_photos'.$FILES_DIR_SUFFIX;
	$uploaddir_favico = $FILES_DIR_PREFIX.'favico'.$FILES_DIR_SUFFIX;
	
	//Relative Paths (Call)
	$local_image_path = "upload_files/images/";
	$local_text_path = "upload_files/text/";
	$local_audio_path = "upload_files/audio/";
	$local_menu_item_path = "upload_files/mi_photos/";
	$local_favico = "upload_files/favico/";
	
	//Thumbnail creation with image dynamic resizing - value initialization
	//Either thumb_width or thumb_height has to be set to 0 (zero)
	//So the resize can be dynamically take place according to either respectively
	$thumb_width = 0;
	$thumb_height = 115;
	
	//Get the $DLTL - Default Language for Tab Listing
	if(!empty($_SESSION['EU_ID'])){
		$DLTL = $_SESSION['DLTL'];
	}else{
		$DLTL = '';
	}
?>