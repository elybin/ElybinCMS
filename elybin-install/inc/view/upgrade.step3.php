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

		<?php if( error_message( 'cannot_delete_htaccess' ) ) : ?>

		<div class="al er"><p><?php _e('We cannot delete your old .htaccess files, due the permission problem. Please delete manually to continue this step.') ?></p></div>

		<?php endif; ?>

		<div class="pb" style="width: 83%"><span>83%</span></div>
		<div class="box">


			<div class="cen">
				<h2><?php _e('Almost done, we need optimizing something') ?></h2>
				<i><?php _e('Finally, checking all files are working well. Just push the button.') ?></i><br/><br/>
			</div>


			<form action="<?php e( process('upgrade.step3') ) ?>" method="post">
				<div class="cen">
					<button type="submit" class="btn"><?php _e('Optimize System') ?></button><br/><br/>
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
