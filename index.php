<?php 
	require("scripts/session.php");
	require("scripts/init.php");
	require("scripts/environment.php");
?>
<!DOCTYPE html>
<html lang="en" dir="ltr" >
	<head>
		<title>electro</title>
		<link rel="icon" href="images/favicon.ico" type="image/x-icon" />
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name="robots" content="none" />
		
		<!-- Include the CSS files -->
		<link rel="stylesheet" type="text/css" href="shadowbox/shadowbox.css">
		<link rel="stylesheet" type="text/css" href="css/smoothness/jquery-ui-1.10.3.custom.min.css">
		<link rel="stylesheet" type="text/css" href="css/electrocss.css?v=1.5">
		
		<!-- Include the JS files -->
		<script type="text/javascript" charset="UTF-8" src="js/jquery-1.10.1.min.js"></script>
		<script type="text/javascript" charset="UTF-8" src="js/jquery-ui-1.10.3.custom.min.js"></script>
		<script type="text/javascript" charset="UTF-8" src="ckeditor/ckeditor.js"></script>
		<script type="text/javascript" charset="UTF-8" src="ckeditor/adapters/jquery.js"></script> 
		<script type="text/javascript" charset="UTF-8" src="shadowbox/shadowbox.js"></script>
		<script type="text/javascript" charset="UTF-8" src="js/jquery.validate.js"></script>
		<script type="text/javascript" charset="UTF-8" src="js/jquery.getUrlParam.js"></script>
		<script type="text/javascript" charset="UTF-8" src="js/css_browser_selector.js"></script>
		<script type="text/javascript" charset="UTF-8" src="js/electro.js"></script>
	</head>
	<body>
		<div id="container">
			<div id="header_area"></div>
			<div id="horizontal_menu_area">
				<?php include("scripts/horizontal_menu.php"); ?>
			</div>
			<?php
				if(!(isset($_SESSION['EU_ID']) && isset($_SESSION['EU_USERNAME']))){
					//if not logged
					echo '<div id="login_area">';
						include("scripts/login_form.php");
					echo '</div>';
				}else{
					//if logged
					echo '<div id="left_menu_area">';
						include("scripts/menu_generator.php");
					echo '</div>';
					echo '<div id="content_area">';
						if ($action_file)
							include($action_file); 
					echo '</div>';
				}
			?>
			<div class="clear"></div>
			<div id="spacer_area"></div>
			<div id="footer_area">
				&copy;2012-2013 <a href="http://www.cmagnet.gr/" target="_blank">cmagnet</a>, electro 1.5 | <a href="<?php echo $front_end_url; ?>" target="_blank">Front-end website</a>
			</div>
		</div>
	</body>
</html>