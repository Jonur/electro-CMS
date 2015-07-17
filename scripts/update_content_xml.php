<?php
	require("access_isset.php");
	
	//Connect to database
	require("db_connect.php");
	
	$Feed_XML = "../fullcontent.xml"; //Create the file
	
	$fh = fopen($Feed_XML, 'w') or die("Cannot Open the file!");
	
	//We write in the file the basic info
	$TheWriter = '<?xml version="1.0" encoding="UTF-8" ?>';
	fwrite($fh,$TheWriter);
	
	//We create the XML tree
	$sql_l = "SELECT * FROM `languages` ORDER BY L_RANK";
	$query_l = mysql_query($sql_l) or die (mysql_error());
	$rows_l = mysql_num_rows($query_l);
	
	//Print first article
	if ($rows_l)
	{
		$TheWriter = "<content>";
		while ($result_l = mysql_fetch_array($query_l))
		{
			$TheWriter .= '<lang name="'.stripslashes($result_l['L_NAME']).'">';
			
			$sql_mi = "SELECT * FROM `menu_items` 
					   INNER JOIN `menu_items-languages` ON `menu_items`.MI_ID = `menu_items-languages`.MI_ID 
					   WHERE `menu_items-languages`.L_ID = '".$result_l['L_ID']."' 
					   AND `menu_items`.MI_DELETED = 0 
					   AND `menu_items`.MI_VISIBLE = 1";
			$query_mi = mysql_query($sql_mi) or die(mysql_error());
			while($result_mi = mysql_fetch_array($query_mi))
			{
				$TheWriter .= '<menu>';
				$TheWriter .= '<title>'.stripslashes($result_mi['MIL_ALIAS']).'</title>';
				
				$sql_a = "SELECT * FROM `articles` WHERE MI_ID = '".$result_mi['MI_ID']."' AND A_DELETED = 0 AND A_VISIBLE = 1 ORDER BY A_ID DESC";
				$query_a = mysql_query($sql_a) or die(mysql_error());
				while($result_a = mysql_fetch_array($query_a))
				{
					$TheWriter .= '<article>';
					$TheWriter .= '<title>'.stripslashes($result_a['A_TITLE']).'</title>';
					$TheWriter .= '<body>'.stripslashes($result_a['A_BODY']).'</body>';
					$TheWriter .= '</article>';
				}
				
				$TheWriter .= "</menu>";
			}
			
			$TheWriter .= "</lang>";
			
		}
		$TheWriter .= "</content>";
		fwrite($fh,$TheWriter);
	}
	
	//We disconnect from the database
	require("db_disconnect.php");
	
	//fwrite($fh,$TheWriter);
	fclose($fh);
?>
<div class="breadcrumb">Πρόσθετα &raquo; Ανανέωση XML Περιεχομένου</div>
<div class="validation_message true">Επιτυχής ενέργεια!</div>
<p><img class = "xml-image" src = "images/xml.png" alt = "XML logo" title = "XML" />Η XML σχεδιάστηκε να ικανοποιήσει πολλές ανάγκες δίνοντας στα έγγραφα ένα μεγαλύτερο επίπεδο προσαρμοστικότητας στο στυλ και τη δομή από αυτό που υπήρχε παλαιότερα στην HTML. Η XML προσφέρει στους σχεδιαστές της HTML τη δυνατότητα να προσθέτουν περισσότερα στοιχεία στη γλώσσα. Δεν αναφέρεται μονάχα στους σχεδιαστές του web αλλά σε οποιονδήποτε ασχολείται με εκδόσεις. Στην πραγματικότητα, η XML ειναι markup γλώσσα για εγγραφα που περιέχουν δομημένες πληροφορίες. Markup γλώσσα είναι ένας μηχανισμός που καθορίζει δομές σε ένα έγγραφο.Οι δομημένες πληροφορίες περιλαμβάνουν περιεχόμενο και κάποιες διευκρινίσεις για το ρόλο που παίζει το περιεχόμενο.σχεδόν όλα τα έγγραφα έχουν την ίδια δομή.</p><p>Η εξαγωγή της Βάσης Δεδομένων του electro CMS σε ένα XML αρχείο χρησιμοποιείται κυρίως στην περίπτωση όπου η ιστοσελίδα είναι δημιουργημένη σε Adobe Flash, μιας και ο μόνος διαθέσιμος τρόπος σύνδεσης του Flash (ActionScript) με την MySQL είναι μέσω ενός XML αρχείου.</p>
<span class="xml_info">Κάντε κλίκ <a href="../fullcontent.xml">εδώ</a> για να δείτε το αρχείο.</span>