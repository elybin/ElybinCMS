<?php
/**
 * Interface of need root  upgrade.
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
	<title><?php _e('Administrator Access Only')?> - Elybin CMS</title>
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
				<h2><?php _e('Administrator Access Only') ?></h2><br/>
				<i class="fa fa-5x fa-minus-circle"></i><br/><br/>
				<i><?php printf(__('Please login as Administrator.')) ?></i><br/>
				<a href="<?php e(get_url('go.login')) ?>" class="btn"><?php _e('Login') ?></a>
			</div>
		</div>
		<div class="xs">
			<i><?php _e('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
