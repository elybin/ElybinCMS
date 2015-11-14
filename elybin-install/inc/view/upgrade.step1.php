<?php
/**
 * Upgrader .
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
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>

		<div class="pb" style="width: 5%"><span>5%</span></div>
		<div class="box">


			<div class="cen">
				<h2><?php _e('Before we\'re going too far...') ?></h2>
				<i><?php _e('Make sure you are reading carefully.') ?></i><br/><br/>
			</div>
			<div class="lef">
				<pre class="code"><?php e( get_upgrade_readme() ); ?></pre>
			</div>



			<form action="<?php e( process('upgrade.step1') ) ?>" method="post">
				<div class="rig">
					<button type="submit" class="btn p-rig"><?php _e('Okay, Continue') ?></button><br/><br/>
				</div>
			</form>



		</div>
		<div class="xs">
			<i><?php _e('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
