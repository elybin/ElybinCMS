<?php
/**
 * Interface of installer.
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
	<title><?php _e('Locked')?> - Elybin CMS</title>
	<link rel='stylesheet' href='assets/stylesheets/install-welcome.css' type='text/css'/>
	<link rel='stylesheet' href='assets/stylesheets/fontawesome.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php if( error_message('register_complete') ) : ?>

			<div class="al ok"><p><?php _e('Registration complete. You can login now.') ?></p></div>

		<?php endif; ?>

		<div class="box">
			<div class="cen">
				<h2><?php _e('Installation Locked Temporary') ?></h2><br/>
				<i class="fa fa-5x fa-lock"></i><br/>
				<i><?php _e('We\'re preventing someone steal your website while installing. So, your installation process automatically locked after 2 hours, to continue installation delete <code>install_date.txt</code> inside <code>elybin-install</code> and refresh this page.') ?></i>
			</div>
			<div class="cen">
				<a href="<?php e(get_url('install.default')) ?>" class="btn"><?php _e('Refresh Page') ?></a>
			</div>
		</div>
		<div class="xs">
			<i><?php _e('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
