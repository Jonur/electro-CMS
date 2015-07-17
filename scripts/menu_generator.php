<?php 
	require("access_isset.php");

	//Left menu
	echo '<div class="menu_title menu_bg_style">Ιστοσελίδα</div>';
	echo '<div class = "active menu_spacing">';
		echo '<div class="menu_item menu_bg_style"><a href="?action=basic_settings">Βασικές Ρυθμίσεις</a></div>';
	echo '</div>';
	
	echo '<div class="menu_title menu_bg_style">Δημιουργία Μενού</div>';
	echo '<div class = "active menu_spacing">';
		echo '<div class="menu_item menu_bg_style"><a href="?action=menu_groups">Ομάδες Μενού</a></div>';
		echo '<div class="menu_item menu_bg_style"><a href="?action=menu_items">Στοιχεία Μενού</a></div>';
		echo '<div class="menu_item menu_bg_style"><a href="?action=menu_structure">Δομή Μενού</a></div>';
	echo '</div>';

	echo '<div class="menu_title menu_bg_style">Δημιουργία Περιεχομένου</div>';
	echo '<div class = "active menu_spacing">';
		echo '<div class="menu_item menu_bg_style"><a href="?action=articles">Άρθρα</a></div>';
		echo '<div class="menu_item menu_bg_style"><a href="?action=galleries">Γκαλερί</a></div>';
		echo '<div class="menu_item menu_bg_style"><a href="?action=files">Αρχεία</a></div>';
	echo '</div>';
	
	echo '<div class="menu_title menu_bg_style">Newsletter</div>';
	echo '<div class = "active menu_spacing">';
		echo '<div class="menu_item menu_bg_style"><a href="?action=nl_membership">Αρχείο μελών</a></div>';
		echo '<div class="menu_item menu_bg_style"><a href="?action=nl_send_mail">Αποστολή</a></div>';
	echo '</div>';
	
	echo '<div class="menu_title menu_bg_style">Διαγωνισμοί</div>';
	echo '<div class = "active menu_spacing">';
		echo '<div class="menu_item menu_bg_style"><a href="?action=polls">Διαγωνισμοί</a></div>';
		echo '<div class="menu_item menu_bg_style"><a href="?action=contestants">Συμμετέχοντες</a></div>';
	echo '</div>';
	
	echo '<div class="menu_title menu_bg_style">Πρόσθετα</div>';
		echo '<div class = "active menu_spacing">';
			echo '<div class="menu_item menu_bg_style"><a href="?action=update_rss_xml">Ανανέωση RSS XML</a></div>';
			echo '<div class="menu_item menu_bg_style"><a href="?action=update_content_xml">Ανανέωση XML περιεχομένου</a></div>';
			echo '<div class="menu_item menu_bg_style"><a href="?action=languages">Γλώσσες</a></div>';
		echo '</div>';
	
	if($_SESSION['EU_LEVEL'])//Only visible to super admin
	{
		echo '<div class="menu_title menu_bg_style">Διαχείριση electro</div>';
		echo '<div class = "active menu_spacing">';
			echo '<div class="menu_item menu_bg_style"><a href="?action=website_users">Χρήστες Ιστότοπου</a></div>';
			echo '<div class="menu_item menu_bg_style"><a href="?action=electro_users">Χρήστες electro</a></div>';
			echo '<div class="menu_item menu_bg_style"><a href="?action=restore_manager">Διαχείριση ανάκτησης</a></div>';
			echo '<div class="menu_item menu_bg_style"><a href="?action=electro_log">Αρχείο συμβάντων</a></div>';
			echo '<div class="menu_item menu_bg_style"><a href="?action=electro_cleanup">Εκκαθάριση electro</a></div>';
			echo '<br />';
			echo '<div class="menu_item menu_bg_style"><a href="?action=electro_release_notes">Πληροφορίες έκδοσης</a></div>';
		echo '</div>';
	}
?>