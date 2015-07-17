<?php
	require("access_isset.php");
	
	//Connect to database
	require("db_connect.php");
	
	$Feed_XML = "../rss.xml"; //Create the file
	
	$fh = fopen($Feed_XML, 'w') or die("Cannot Open the file!");
	
	//We write in the file the basic info
	$TheWriter = '<?xml version="1.0" encoding="UTF-8" ?><rss version="2.0">';
	fwrite($fh,$TheWriter);
	
	$TheWriter = '<channel>
	  <title>'.$owner_title.'</title>
	  <link>'.$website_url.'/</link>
	  <description>Νέα / News</description>';
	fwrite($fh,$TheWriter);
	

	
	//We create the XML tree
	$sql_a = "  SELECT * FROM `articles` 
				INNER JOIN `menu_items-languages` ON `articles`.MI_ID = `menu_items-languages`.MI_ID 
				WHERE A_VISIBLE = 1 
				AND A_DELETED = 0 
				AND `articles`.MI_ID > 0 
				AND L_ID = '$DLTL' 
				ORDER BY A_ID DESC";
	$query_a = mysql_query($sql_a) or die (mysql_error());
	$rows_a = mysql_num_rows($query_a);
	
	//Print first article
	if ($rows_a)
	{
		while ($result_a = mysql_fetch_array($query_a))
		{
			$TheWriter = "<item>";
			
			$a_id = $result_a['A_ID'];			
			$TheWriter .= '<title>'.stripslashes($result_a['A_TITLE']).'</title>';
			$TheWriter .= '<link>'.$website_url.'?mi='.$result_a['MI_ID'].'</link>';
			$TheWriter .= '<description>'.stripslashes($result_a['MIL_ALIAS']).'</description>';
			
			$TheWriter .= "</item>";
			fwrite($fh,$TheWriter);
		}
	}
	
	//We disconnect from the database
	require("db_disconnect.php");
	
	$TheWriter = '</channel></rss>';
	fwrite($fh,$TheWriter);
	
	fclose($fh);
?>
<div class="breadcrumb">Πρόσθετα &raquo; Ανανέωση RSS XML</div>
<div class="validation_message true">Επιτυχής ενέργεια!</div>
<p><img class = "rss-image" src = "images/rss.png" alt = "RSS logo" title = "RSS" />Το RSS είναι ένας εναλλακτικός τρόπος να ενημερώνεστε για τα γεγονότα. Το Διαδίκτυο αποτελείται πλέον από δισεκατομμύρια σελίδες οι οποίες περιέχουν τέτοιο πλούτο πληροφοριών που είναι σχεδόν αδύνατο για τον οποιονδήποτε να μπορεί να παρακολουθεί διαρκώς ότι νεότερο συμβαίνει στον κόσμο ή στο αντικείμενο που τον ενδιαφέρει. Εδώ έρχεται να δώσει τη λύση το RSS. Πλέον όλες οι πληροφορίες που σας ενδιαφέρουν έρχονται στον υπολογιστή σας χωρίς εσείς να χρειάζεται να επισκέπτεστε κάθε φορά τους σχετικούς δικτυακούς τόπους.</p><p>Το RSS σας επιτρέπει να βλέπετε πότε ανανεώθηκε το περιεχόμενο των δικτυακών τόπων που σας ενδιαφέρουν. Μπορείτε να λαμβάνετε κατευθείαν στον υπολογιστή σας τους τίτλους των τελευταίων ειδήσεων και των άρθρων που επιθυμείτε (ή ακόμα και εικόνων ή βίντεο) αμέσως μόλις αυτά γίνουν διαθέσιμα χωρίς να είναι απαραίτητο να επισκέπτεστε καθημερινά τους αντίστοιχους δικτυακούς τόπους.</p>
<span class="xml_info">Κάντε κλίκ <a href="../rss.xml">εδώ</a> για να δείτε το αρχείο.</span>