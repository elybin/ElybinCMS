<?php
/**
 * The main script of installer.
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
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
		switch ( error_message() ) {
			case 'empty_db_host':
				echo '<div class="al er"><p>'.__('Enter Database Host.').'</p></div>';
				break;
			case 'empty_db_user':
				echo '<div class="al er"><p>'.__('Enter Database Username.').'</p></div>';
				break;
			case 'empty_db_name':
				echo '<div class="al er"><p>'.__('Enter Database Name.').'</p></div>';
				break;
			case 'db_notfound':
				echo '<div class="al er"><p>'.__('Connection to database error. Database not found.').'</p></div>';
				break;
			case 'db_auth_error':
				echo '<div class="al er"><p>'.__('Connection error. Check Database Username or Database Password.').'</p></div>';
				break;
			case 'failed_config':
				echo '<div class="al er"><p>'.__('Failed writing &#34;elybin-config.php&#34;. Copy the script below, and create file manually.').'</p></div>';
				break;
			case 'failed_locksys':
				echo '<div class="al er"><p>'.__('Failed writing &#34;elybin-install/install_date.txt&#34;. Fix your directory permissions, and try again.').'</p></div>';
				break;
			case 'unk_error':
				echo '<div class="al er"><p>'.__('Unknown error. Please contact us.').'</p></div>';
				break;
			case 'failed_copy_version':
				echo '<div class="al er"><p>'.__('Failed to copy `elybin-version.php`. Copy manually from `elybin-install/inc/elybin-version.php` to `elybin-core/elybin-version.php`.').'</p></div>';
				break;
			case 'step1_ok':
				echo '<div class="al ok"><p>'.__('Database configuration success!').'</p></div>';
				break;
			default:
				break;
		}
		?>

		<div class="pb" style="width: 12%"><span>12%</span></div>
		<div class="box">
			<?php if( !empty( $_SESSION['config_template'] ) ) :
			?>

			<div class="cen">
				<h2><?php _e('I can\'t, I need your hand.') ?></h2>
				<i><?php _e('Check your directory permissions, or you can create this file manually. After that refresh this page.') ?></i><br/><br/>
			</div>
			<div class="lef">
				<pre class="code"><?php e( htmlspecialchars( s('config_template') ) ); ?></pre>
			</div>

			<?php else: ?>

			<form action="<?php e( process('install.step1') ) ?>" method="post">
				<div class="cen">
					<h2><?php _e('Set your Database!') ?></h2><br/>
				</div>
				<div class="lef">
					<div class="group">
						<input type="text" name="h" placeholder="<?php _e('Database Host, I guess localhost') ?>" value="<?php e( isset($_SESSION['h']) ? $_SESSION['h'] : 'localhost' ) ?>"/>
						<p class="cb"><?php _e('Commonly it set localhost') ?></p>
					</div>
					<div class="group">
						<input type="text" name="u" placeholder="<?php _e('Database Username, for example: user_db_elybin') ?>" value="<?php e( isset($_SESSION['u']) ? $_SESSION['u'] : '' ) ?>"/>
						<p class="cb"><?php _e('Enter username of your Database connection. Ask your hosting provider, if you don\'t know that.') ?></p>
					</div>
					<div class="group">
						<input type="text" name="p" placeholder="<?php _e('Database Password, usually are random string.') ?>" value="<?php e( isset($_SESSION['p']) ? $_SESSION['p'] : '' ) ?>"/>
						<p class="cb"><?php _e('Enter password to your Database. Ask your hosting provider, if you don\'t know that.')?></p>
					</div>
					<div class="group">
						<input type="text" name="n" placeholder="<?php _e('Database Name, for example: db_elybin') ?>" value="<?php e( isset($_SESSION['n']) ? $_SESSION['n']  : '' ) ?>"/>
						<p class="cb"><?php _e('Enter name of your Database. Ask your hosting provider, if you don\'t know that.')?></p>
					</div>
				</div>
				<div class="rig">
					<button type="submit" class="btn p-rig"><?php _e('Next') ?></button><br/><br/>
				</div>
			</form>

			<?php endif; ?>

		</div>
		<div class="xs">
			<i><?php _e('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
