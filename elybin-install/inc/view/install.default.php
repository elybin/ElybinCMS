<?php
/**
 * The main script of installer.
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
	<title><?php _e('Quick Install')?> - Elybin CMS</title>
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
				<h2><?php _e('Welcome!') ?></h2><br/>
				<i class="fa fa-5x fa-magic"></i><br/>
				<i><?php _e('This is magic! your site will up in a second.') ?></i><br/>
				<i><?php _e('Are you ready?') ?></i><br/>
			</div>

			<form action="<?php e( process('install.default') ) ?>" method="post">
				<div class="cen">
					<?php
					// disabled when directory isn't writeable
					if( error_message( 'failed_locksys' ) ) : ?>
					<button class="btn disabled"><?php _e('Yes, Start Installation!') ?></button>
					<?php else: ?>
					<button type="submit" class="btn"><?php _e('Yes, Start Installation!') ?></button>
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
