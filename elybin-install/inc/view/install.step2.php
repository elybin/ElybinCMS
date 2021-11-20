<?php
/**
 * The main script of installer.
 *
 * @package   Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @author		Khakim <elybin.inc@gmail.com>
 * @since 		Elybin 1.0.0
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
			case 'fill_fullname':
				echo '<div class="al er"><p>'.__('You don\'t have a name?').'</p></div>';
				break;
			case 'fill_username':
				echo '<div class="al er"><p>'.__('Please fill Nickname first.').'</p></div>';
				break;
			case 'fill_email':
				echo '<div class="al er"><p>'.__('Please fill E-mail.').'</p></div>';
				break;
			case 'fill_password':
				echo '<div class="al er"><p>'.__('Please fill Password.').'</p></div>';
				break;
			case 'fill_both':
				echo '<div class="al er"><p>'.__('Don\'t forget to fill Password in both field.').'</p></div>';
				break;
			case 'invalid_email':
				echo '<div class="al er"><p>'.__('E-mail format not recognized. Example format is xxx@xxx.xxx.').'</p></div>';
				break;
			case 'invalid_username':
				echo '<div class="al er"><p>'.__('Nickname format not recognized. Allowed character is letter(a-z), number(0-9) and underscore (_)').'</p></div>';
				break;
			case 'username_too_long':
				echo '<div class="al er"><p>'.__('Maximum nickname character is 12 letter.').'</p></div>';
				break;
			case 'username_too_short':
				echo '<div class="al er"><p>'.__('Minimum nickname character is 3 letter.').'</p></div>';
				break;
			case 'password_not_match':
				echo '<div class="al er"><p>'.__('Both password didn\'t match each other, Please check.').'</p></div>';
				break;
			case 'password_too_short':
				echo '<div class="al er"><p>'.__('Your password is too weak, try to use more combination.').'</p></div>';
				break;
			case 'db_auth_error':
				echo '<div class="al er"><p>'.__('Connection error. Check Database Username or Database Password.').'</p></div>';
				break;
			case 'db_auth_error':
				echo '<div class="al er"><p>'.__('Connection error. Check Database Username or Database Password.').'</p></div>';
				break;
			case 'register_user_failed':
				echo '<div class="al er"><p>'.__('Failed to register new user.').'</p></div>';
				break;
			case 'query_error':
				echo '<div class="al er"><p>'.__('Some query failed to execute, This is our mistake. Please contact us.').'</p></div>';
				break;

			default:

				break;
		}
		?>

		<div class="pb" style="width: 36%"><span>36%</span></div>
		<div class="box">
			<form action="<?php e( process('install.step2') ) ?>" method="post">
				<div class="cen">
					<h2><?php _e('Hi bro! Introduce your self') ?></h2><br/>
				</div>
				<div class="lef">
					<div class="group">
						<input type="text" name="fn" placeholder="<?php _e('My Name is...') ?>" value="<?php e( s('fn') ) ?>"/>
						<p class="cb"><?php _e('Your full name here.') ?></p>
					</div>
					<div class="group">
						<input type="text" name="un" placeholder="<?php _e('You can call me...') ?>" value="<?php e( s('un') ) ?>"/>
						<p class="cb"><?php _e('Your short name, without space but allowed using underscore and lower case only (letter and number).') ?></p>
					</div>
					<div class="group">
						<input type="text" name="e" placeholder="<?php _e('Maybe sometimes you need to E-mail me...') ?>" value="<?php e( s('e') )  ?>"/>
						<p class="cb"><?php _e('Enter your active e-mail, it needed when your site in bad situation.') ?></p>
					</div>
					<div class="group">
						<input type="password" name="pu" placeholder="<?php _e('My secret word... (Password)') ?>"/>
						<p class="cb"><?php _e('Some combination of letter, number and symbol. Pick one that easy to remember.') ?></p>
					</div>
					<div class="group">
						<input type="password" name="puc" placeholder="<?php _e('Secret word once again... (Password Again)') ?>"/>
						<p class="cb"><?php _e('Type again your password. And remember it.') ?></p>
					</div>

				</div>
				<div class="rig">
					<button type="submit" class="btn p-rig"><?php _e('Next') ?></button><br/><br/>
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
