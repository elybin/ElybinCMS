<?php
/**
 * Interface of na upgrade.
 *
 * @package   Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @author		Khakim A <kim@elybin.com>
 * @since 		Elybin 1.1.4
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php _e('Upgrade Not Available')?> - Elybin CMS</title>
	<link rel='stylesheet' href='assets/stylesheets/install-welcome.css' type='text/css'/>
	<link rel='stylesheet' href='assets/stylesheets/fontawesome.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>

		<div class="box">
			<div class="cen">
				<h2><?php _e('Upgrade Not Available') ?></h2><br/>
				<i class="fa fa-5x fa-question-circle"></i><br/><br/>
				<i><?php printf(__('Your current system version cannot be upgraded to newer version, try to delete all files, and install it from begining.')) ?></i>
			</div>
		</div>
		<div class="xs">
			<i><?php _e('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
