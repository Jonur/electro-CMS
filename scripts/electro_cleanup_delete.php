<?php
	require("session_isset.php");
	//Get the form values
	$valid_entry = 1;
	
	if(!empty($_POST['item'])){
		$item = $_POST['item'];
	}else{
		$valid_entry = 0;
	}

	//Truncate the tables
	if ($valid_entry)
	{
		require("db_connect_mysqli.php");
		
		if(in_array('menu_groups',$item)){
			$sql_el_truncate = "
				TRUNCATE `menu_groups`;
				TRUNCATE `menu_groups-languages`;
				TRUNCATE `menu_groups-menu_items`;
				TRUNCATE `menu_items`;
				TRUNCATE `menu_items-languages`;
			";
			
			$mysqli->multi_query($sql_el_truncate);
			do{ 
				$mysqli->use_result(); 
			}while ($mysqli->next_result());
		}
		if(in_array('menu_items',$item)){
			$sql_el_truncate = "
				TRUNCATE `menu_groups-menu_items`;
				TRUNCATE `menu_items`;
				TRUNCATE `menu_items-languages`;
			";
			
			$mysqli->multi_query($sql_el_truncate);
			do{ 
				$mysqli->use_result(); 
			}while ($mysqli->next_result());
		}
		if(in_array('articles',$item)){
			$sql_el_truncate = "
				TRUNCATE `articles`;
				TRUNCATE `articles-files`;
				TRUNCATE `articles-galleries`;
				TRUNCATE `articles-languages`;
			";
			
			$mysqli->multi_query($sql_el_truncate);
			do{ 
				$mysqli->use_result(); 
			}while ($mysqli->next_result());
		}
		if(in_array('galleries',$item)){
			$sql_el_truncate = "
				TRUNCATE `galleries`;
				TRUNCATE `articles-galleries`;
				TRUNCATE `galleries-languages`;
				TRUNCATE `galleries-files`;
			";
			
			$mysqli->multi_query($sql_el_truncate);
			do{ 
				$mysqli->use_result(); 
			}while ($mysqli->next_result());
		}
		if(in_array('files',$item)){
			$sql_el_truncate = "
				TRUNCATE TABLE `articles-files`;
				TRUNCATE TABLE `files`;
				TRUNCATE TABLE `galleries-files`;
				TRUNCATE TABLE `image_captions`;
			";
			
			$mysqli->multi_query($sql_el_truncate);
			do{ 
				$mysqli->use_result(); 
			}while ($mysqli->next_result()); 

			if ($mysqli->errno) { 
				$valid_entry = 0;
			} 
		}
		if(in_array('newsletter',$item)){
			$sql_el_truncate = "
				TRUNCATE `newsletter_members`;
			";
			
			$mysqli->multi_query($sql_el_truncate);
			do{ 
				$mysqli->use_result(); 
			}while ($mysqli->next_result());
		}
		if(in_array('contests',$item)){
			$sql_el_truncate = "
				TRUNCATE `contestants`;
				TRUNCATE `polls`;
				TRUNCATE `polls-contestants`;
				TRUNCATE `poll_voters`;
			";
			
			$mysqli->multi_query($sql_el_truncate);
			do{ 
				$mysqli->use_result(); 
			}while ($mysqli->next_result());
		}
		if(in_array('website_users',$item)){
			$sql_el_truncate = "
				TRUNCATE `website_users`;
			";
			
			$mysqli->multi_query($sql_el_truncate);
			do{ 
				$mysqli->use_result(); 
			}while ($mysqli->next_result());
		}
		
		require("db_disconnect_mysqli.php");
		
		if ($valid_entry && in_array('files',$item)){
			$files = glob($uploaddir_img.'*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file) && ($file != $uploaddir_img.'noimg.gif'))
					@unlink($file); // delete file
			}
			$files = glob($uploaddir_img.'thumbs/*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file) && ($file != $uploaddir_img.'thumbs/thumb_noimg.gif'))
					@unlink($file); // delete file
			}
			$files = glob($uploaddir_text.'*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
					@unlink($file); // delete file
			}
			$files = glob($uploaddir_audio.'*'); // get all file names
			foreach($files as $file){ // iterate files
				if(is_file($file))
					@unlink($file); // delete file
			}
		}
	}
	
	//Redirection
	header('Location: ../?action=electro_cleanup&validation='.$valid_entry);
?>