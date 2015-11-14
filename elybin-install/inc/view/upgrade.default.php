<?php
/**
 * The main script of upgrader.
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
	<title><?php _e('Upgrade')?> - Elybin CMS</title>
	<link rel='stylesheet' href='assets/stylesheets/install-welcome.css' type='text/css'/>
	<link rel='stylesheet' href='assets/stylesheets/fontawesome.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>

		<?php if( error_message( 'failed_locksys' ) ) : ?>

		<div class="al er"><p><?php _e('Set your directory to writeable, and try again.') ?></p></div>

		<?php endif; ?>

		<div class="pb" style="width: 0%"><span>0%</span></div>
		<div class="box">
			<div class="cen">
				<h2><?php _e('Upgrade Available') ?></h2><br/>
				<i class="fa fa-5x fa-gears"></i><br/><br/>
				<i><?php _e('We found that your system available to upgraded to new version.') ?></i><br/>
				<i><?php _e('Press the button to start the setup.') ?></i><br/><br/>
			</div>

			<form action="<?php e( process('upgrade.default') ) ?>" method="post">
				<div class="cen">
					<?php
					// disabled when directory isn't writeable
					if( error_message( 'failed_locksys' ) ) : ?>
					<button class="btn disabled"><?php printf(__('Start Upgrade to %s'), get_upgrade_info('installer_version')) ?></button>
					<?php else: ?>
					<button type="submit" class="btn"><?php printf(__('Start Upgrade to %s'), get_upgrade_info('installer_version')) ?></button>
					<?php endif; ?>
				</div>
			</form>

		</div>
		<div class="cen xs">
			<i><?php _e('Language:') ?> <b><?php e(s('lang')); ?></b></i><br/>
			<a href="<?php e(get_url('change.language','en-US')) ?>"><?php _e('English') ?></a> |
			<a href="<?php e(get_url('change.language','id-ID')) ?>"><?php _e('Bahasa Indonesia') ?></a>
		</div>
	</div>
</body>
</html>
