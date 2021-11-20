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
			case 'fill_sitetitle':
				echo '<div class="al er"><p>'.__('Enter your site title.').'</p></div>';
				break;
			case 'fill_category':
				echo '<div class="al er"><p>'.__('Select site category.').'</p></div>';
				break;
			case 'fill_colour':
				echo '<div class="al er"><p>'.__('Select your favorite color.').'</p></div>';
				break;
			case 'sitename_too_long':
				echo '<div class="al er"><p>'.__('Site title too long maybe.').'</p></div>';
				break;

			default:
				break;
		}
		?>

		<div class="pb" style="width: 82%"><span>82%</span></div>
		<div class="box">
			<div class="cen">
				<?php
				// call his name, so it looks more friendly
				if( !empty( $_SESSION['un'] ) ): ?>
					<h2><?php e( ucfirst( s('un') ) ) ?>, <?php _e('How your website will look like?') ?></h2><br/>

				<?php else: ?>

					<h2><?php _e('How your website will look like?') ?></h2><br/>

				<?php endif; ?>
			</div>
			<form action="<?php e( process('install.step3') ) ?>" method="post">
				<div class="lef">
					<div class="group">

						<input type="text" name="wn" placeholder="<?php printf( __('Enter site title. for example: %s\'s Amazing Story') , (!empty($_SESSION['un']) ? ucfirst( strtolower( $_SESSION['un'] ) ): "Richo") )?> "  value="<?php _e( s('wn') )?>"/>

						<p class="cb"><?php _e('Enter your site main title, I suggest name that simple but can describe yours.') ?></p>
					</div>
					<div class="group">
						<select name="wc">
							<option value="none"<?php e( (s('wc')=='none' ? ' selected="selected"' : '') ) ?>><?php _e('It will be...') ?></option>
							<option value="personal"<?php e( (s('wc')=='personal' ? ' selected="selected"' : '' ) ) ?>><?php _e('Personal Website') ?></option>
							<option value="community"<?php e( (s('wc')=='community' ? ' selected="selected"' : '' ) ) ?>><?php _e('Community or Organization') ?></option>
							<option value="business"<?php e( (s('wc')=='business' ? ' selected="selected"' : '' ) ) ?>><?php _e('Company or Business Profile') ?></option>
							<option value="business"<?php e( (s('wc')=='catalogue' ? ' selected="selected"' : '' ) ) ?>><?php _e('Online Catalogue/Sell and Buy Website') ?></option>
							<option value="business"<?php e( (s('wc')=='gallery' ? ' selected="selected"' : '' ) ) ?>><?php _e('Photo Gallery/About Art') ?></option>
							<option value="business"<?php e( (s('wc')=='event' ? ' selected="selected"' : '' ) ) ?>><?php _e('Event Website/RSVP') ?></option>
							<option value="business"<?php e( (s('wc')=='application' ? ' selected="selected"' : '' ) ) ?>><?php _e('Application/Internal System/Cashier') ?></option>
							<option value="other"<?php e( (s('wc')=='other' ? ' selected="selected"' : '' ) ) ?>><?php _e('Other...') ?></option>
						</select>
					</div>
					<div class="group">
						<select name="fc">
							<option value="none"<?php e ( (s('fc')=='none' ? ' selected="selected"' : '' ) ) ?>><?php _e('My favorite color...') ?></option>
							<option value="red"<?php e ( (s('fc')=='red' ? ' selected="selected"' : '' ) ) ?>><?php _e('Red') ?></option>
							<option value="pink"<?php e ( (s('fc')=='pink' ? ' selected="selected"' : '' ) ) ?>><?php _e('Pink') ?></option>
							<option value="orange"<?php e ( (s('fc')=='orange' ? ' selected="selected"' : '' ) ) ?>><?php _e('Orange') ?></option>
							<option value="yellow"<?php e ( (s('fc')=='yellow' ? ' selected="selected"' : '' ) ) ?>><?php _e('Yellow') ?></option>
							<option value="green"<?php e ( (s('fc')=='green' ? ' selected="selected"' : '' ) ) ?>><?php _e('Green') ?></option>
							<option value="brown"<?php e ( (s('fc')=='brown' ? ' selected="selected"' : '' ) ) ?>><?php _e('Brown') ?></option>
							<option value="blue"<?php e ( (s('fc')=='blue' ? ' selected="selected"' : '' ) ) ?>><?php _e('Light Blue') ?></option>
							<option value="purple"<?php e ( (s('fc')=='purple' ? ' selected="selected"' : '' ) ) ?>><?php _e('Purple') ?></option>
							<option value="black"<?php e ( (s('fc')=='black' ? ' selected="selected"' : '' ) ) ?>><?php _e('Black') ?></option>
							<option value="other"<?php e ( (s('fc')=='other' ? ' selected="selected"' : '' ) ) ?>><?php _e('Other...') ?></option>
						</select>
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
