<?php require("access_isset.php"); ?>
<div class="breadcrumb">Διαχείριση electro &raquo; Εκκαθάριση electro</div>
<button type="button" class="create_button create_button_extra_w" onclick="javascript:electro_cleanup_submit();">Εκκαθάριση επιλεγμένων</button>
<?php echo $validation_message; ?>
<div class="clear"></div>

<form id="electro_cleanup" name="electro_cleanup" action="scripts/electro_cleanup_delete.php" method="post">
	<div class="select_unselect">
		<span class="select_all" onclick="javascript:select_unselect(true);">Επιλογή Όλων</span>
		&nbsp;&#124;&nbsp;
		<span class="unselect_all" onclick="javascript:select_unselect(false);">Επιλογή Κανενός</span>
	</div>
	<div class="clear"></div>
	
	<ul id = "record-listing">
		<li class = "single-line electro-cleanup" title = "Επιλογή">
			<input type="checkbox" name="item[]" value="menu_groups" />
			<a href = "javascript:;">Ομάδες Μενού και Στοιχεία Μενού</a>
		</li>
		<li class = "single-line electro-cleanup" title = "Επιλογή">
			<input type="checkbox" name="item[]" value="menu_items" />
			<a href = "javascript:;">Στοιχεία Μενού</a>
		</li>
		<li class = "single-line electro-cleanup" title = "Επιλογή">
			<input type="checkbox" name="item[]" value="articles" />
			<a href = "javascript:;">Άρθρα</a>
		</li>
		<li class = "single-line electro-cleanup" title = "Επιλογή">
			<input type="checkbox" name="item[]" value="galleries" />
			<a href = "javascript:;">Γκαλερί</a>
		</li>
		<li class = "single-line electro-cleanup" title = "Επιλογή">
			<input type="checkbox" name="item[]" value="files" />
			<a href = "javascript:;">Αρχεία</a>
		</li>
		<li class = "single-line electro-cleanup" title = "Επιλογή">
			<input type="checkbox" name="item[]" value="newsletter" />
			<a href = "javascript:;">Αρχείο μελών Newsletter</a>
		</li>
		<li class = "single-line electro-cleanup" title = "Επιλογή">
			<input type="checkbox" name="item[]" value="contests" />
			<a href = "javascript:;">Διαγωνισμοί και Συμμετέχοντες Διαγωνισμών</a>
		</li>
		<li class = "single-line electro-cleanup" title = "Επιλογή">
			<input type="checkbox" name="item[]" value="website_users" />
			<a href = "javascript:;">Χρήστες Ιστότοπου</a>
		</li>
	</ul>
	
</form>