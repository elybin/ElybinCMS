<?php
/**
 * Interface of installer.
 *
 * @package   Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @author		Khakim <elybin.inc@gmail.com>
 * @since 		Elybin 1.1.4
 */
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php _e('Upgrade')?> - Elybin CMS</title>
	<link rel='stylesheet' href='assets/stylesheets/install-welcome.css' type='text/css'/>
	<link rel='stylesheet' href='assets/stylesheets/fontawesome.css' type='text/css'/>
	<meta name='robots' content='noindex, follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<div class="al if"><p><?php _e('Don\'t forget to delete &#34;elybin-install&#34; directory.') ?></p></div>
		<div class="pb" style="width: 100%"><span>100%</span></div>
		<div class="box">
			<div class="cen">
				<h2><?php _e('Woohoo! Successfully upgraded!') ?></h2>

				<i class="fa fa-rocket fa-5x"></i><br/><br/>
				<i><?php printf(__('Your system core successfully upgraded to version "%s", Congratulation.'), get_upgrade_info('database_version','refresh')) ?></i>
			</div>
			<div class="cen">
				<a href="<?php e(get_url('go.login')) ?>" class="btn"><?php _e('Goto Admin Panel') ?></a>
			</div>
		</div>
		<div class="xs">
			<i><?php _e('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.github.io/" class="p-rig" target="_blank">www.elybin.github.io</a>
		</div>
	</div>
</body>
</html>
