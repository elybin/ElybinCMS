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
		<div class="al if"><p><?php _e('Don\'t forget to delete &#34;elybin-install&#34; directory.') ?></p></div>
		<div class="pb" style="width: 100%"><span>100%</span></div>
		<div class="box">
			<div class="cen">
				<h2><?php _e('Hurray! your website already up!') ?></h2>

				<?php if( !empty( $_SESSION['temp_user'] ) ): ?>

				<code class="text-left">
				<?php _e('Login with this account') ?><br/>
				<?php _e('Username or E-mail:') ?> <?php e( s('temp_user') ) ?><br/>
				<?php _e('Password:') ?> <?php e( s('temp_pass') ) ?>
				</code><br/><br/>

				<?php else: ?>

				<i class="fa fa-rocket fa-5x"></i><br/><br/>
				<?php endif; ?>
				<i><?php _e('Let\'s celebrate, don\'t forget to decorate it.') ?></i>
			</div>
			<div class="cen">
				<a href="<?php e(get_url('go.home')) ?>" class="btn"><?php _e('Visit your new home') ?></a>
				<a href="<?php e(get_url('go.login')) ?>" class="btn"><?php _e('Login as Owner') ?></a>
			</div>
		</div>
		<div class="xs">
			<i><?php _e('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
