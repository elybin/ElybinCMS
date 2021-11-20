<?php
/**
 * Upgrader .
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
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>

		<div class="pb" style="width: 30%"><span>30%</span></div>
		<div class="box">


			<div class="cen">
				<h2><?php _e('Touching Database...') ?></h2>

				<i><?php printf(__('After this step, your old database version (%s) will upgraded to newer version (%s). Because we need changing many aspect, this step maybe take more seconds.'), get_upgrade_info('database_version'), get_upgrade_info('installer_version')) ?></i><br/>
				<i><?php _e('Avoiding unwanted condition, we\'re backup your database inside <code>elybin-file/backup/</code>. Now push the <b>"Continue"</b> button.') ?></i><br/><br/>
			</div>


			<form action="<?php e( process('upgrade.step2') ) ?>" method="post">
				<div class="cen">
					<button type="submit" class="btn"><?php _e('Continue') ?></button>
				</div>
			</form>

		</div>
		<div class="xs">
			<i><?php _e('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.github.io/" class="p-rig" target="_blank">www.elybin.github.io</a>
		</div>
	</div>
</body>
</html>
