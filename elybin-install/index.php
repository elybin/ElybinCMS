<?php
session_start();
// include function
include 'inc/install.func.php';

// call install lock
install_lock();

// chmod
chmod_dir();

// err msg
$msg = @$_SESSION['msg'];
@$_SESSION['msg'] = '';

// use swtch
switch (@$_GET['p']) {

	default:
	// allowed if status 0,1,2
	switch(install_status()){
		case 0:
			//header('location: index.php');
			break;
		case 1:
			header('location: ?p=step1');exit;
			break;
		case 2:
			header('location: ?p=step1');exit;
			break;
		case 3:
			header('location: ?p=step2');exit;
			break;
		case 4:
			header('location: ?p=step3');exit;
			break;
		case 5:
			header('location: ?p=finish');exit;
			break;
		case -1:
			header('location: ?p=locked');exit;
			break;
		default:
			header('location: ?p=404');
			break;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo lg('Quick Install')?> - Elybin CMS</title>
	<link rel='stylesheet' href='assets/stylesheets/install-welcome.css' type='text/css'/>
	<link rel='stylesheet' href='assets/stylesheets/fontawesome.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
		switch ($msg) {
			// failed chmod
			case 'failed_chmod':
				echo '<div class="al if"><p>'.lg('Set these directory to writeable (777): "elybin-install/", "elybin-core/", "elybin-file".').'</p><p>'.lg('or execute this command line').' <code>sudo chmod 777 elybin-install/ elybin-file/ elybin-core/</code></p></div>';
				break;
			// lock system
			case 'failed_locksys':
				echo '<div class="al er"><p>'.lg('Failed writing &#34;elybin-install/install_date.txt&#34;. Fix your directory permissions, and try again.').'</p></div>';
				break;

			default:
				break;
		}
		?>
		<div class="pb" style="width: 0%"><span>0%</span></div>
		<div class="box">
			<div class="cen">
				<h2><?php echo lg('Welcome!') ?></h2><br/>
				<i class="fa fa-5x fa-magic"></i><br/>
				<i><?php echo lg('This is magic! your site will up in a second.') ?></i><br/>
				<i><?php echo lg('Are you ready?') ?></i><br/>
			</div>
			<div class="cen">
				<?php
				// disabled when directory isn't writeable
				if($msg == 'failed_chmod'){
						echo '<a class="btn disabled">'.lg('Yes, Start Installation!').'</a>';
				}else{
						echo '<a href="?p=step1" class="btn">'.lg('Yes, Start Installation!').'</a>';
				}
				?>
			</div>
		</div>
		<div class="cen xs">
			<i><?php echo lg('Language:') ?><?php echo @$_SESSION['lg']; ?></i><br/>
			<a href="?p=en"><?php echo lg('English') ?></a> |
			<a href="?p=id"><?php echo lg('Bahasa Indonesia') ?></a>
		</div>
	</div>
</body>
</html>
<?php
		break;

	case 'step1':
	// allowed if status 0,1,2
	switch(install_status()){
		case 0:
			//header('location: index.php');
			break;
		case 1:
			//header('location: ?p=step1');
			break;
		case 2:
			//header('location: ?p=step1');
			break;
		case 3:
			header('location: ?p=step2');exit;
			break;
		case 4:
			header('location: ?p=step3');exit;
			break;
		case 5:
			header('location: ?p=finish');exit;
			break;
		case -1:
			header('location: ?p=locked');exit;
			break;
		default:
			header('location: ?p=404');exit;
			break;
	}

	// check status proses
	if(install_status() == 1){
		$_SESSION['msg'] = '';
		unset($_SESSION['config_template']);
		// call
		if(write_htaccess() == false){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Failed writing &#34;.htaccess&#34;. Copy the script below, and create file manually.'),
				'msg_ses' => 'failed_htaccess',
				'red' => ''
			), @$_GET['r'], false);
		}
	}

	if(install_status() == 2){
		$_SESSION['msg'] = '';
		unset($_SESSION['msg']);
		unset($_SESSION['htaccess_template']);

		// success

		// rem tmp session
		@$_SESSION['h'] = '';
		@$_SESSION['u'] = '';
		@$_SESSION['p'] = '';
		@$_SESSION['n'] = '';
		@$_SESSION['msg'] = '';

		// change step
		$_SESSION['step'] = "2";

		// if install with content
		if(import_sql(array("mysql/latest_structure.sql", "mysql/latest_content.sql")) == false){
			//echo lg('Some query failed to execute, This is our mistake. Please contact us.');
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Some query failed to execute, This is our mistake. Please contact us.'),
				'msg_ses' => 'query_error',
				'red' => '?p=step2'
			), @$_GET['r']);
		}else{
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Database configuration success!'),
				'msg_ses' => 'step1_ok',
				'red' => '?p=step2'
			), @$_GET['r']);
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo lg('Quick Install')?> - Elybin CMS</title>
	<link rel='stylesheet' href='assets/stylesheets/install-welcome.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
		switch ($msg) {
			case 'empty_db_host':
				echo '<div class="al er"><p>'.lg('Enter Database Host.').'</p></div>';
				break;
			case 'empty_db_user':
				echo '<div class="al er"><p>'.lg('Enter Database Username.').'</p></div>';
				break;
			case 'empty_db_name':
				echo '<div class="al er"><p>'.lg('Enter Database Name.').'</p></div>';
				break;
			case 'db_notfound':
				echo '<div class="al er"><p>'.lg('Connection to database error. Database not found.').'</p></div>';
				break;
			case 'db_auth_error':
				echo '<div class="al er"><p>'.lg('Connection error. Check Database Username or Database Password.').'</p></div>';
				break;
			case 'failed_config':
				echo '<div class="al er"><p>'.lg('Failed writing &#34;elybin-config.php&#34;. Copy the script below, and create file manually.').'</p></div>';
				break;
			case 'failed_htaccess':
				echo '<div class="al er"><p>'.lg('Failed writing &#34;.htaccess&#34;. Copy the script below, and create file manually.').'</p></div>';
				break;
			// lock system
			case 'failed_locksys':
				echo '<div class="al er"><p>'.lg('Failed writing &#34;elybin-install/install_date.txt&#34;. Fix your directory permissions, and try again.').'</p></div>';
				break;
			case 'unk_error':
				echo '<div class="al er"><p>'.lg('Unknown error. Please contact us.').'</p></div>';
				break;
			case 'step1_ok':
				echo '<div class="al ok"><p>'.lg('Database configuration success!').'</p></div>';
				break;

			default:
				break;
		}
		?>

		<div class="pb" style="width: 12%"><span>12%</span></div>
		<div class="box">
			<?php

			if(isset($_SESSION['config_template'])){
			?>
			<div class="cen">
				<h2><?php echo lg('I can\'t, I need your hand.') ?></h2>
				<i><?php echo lg('Check your directory permissions, or you can create this file manually. After that refresh this page.') ?></i><br/><br/>
			</div>
			<div class="lef">
				<pre class="code"><?php echo htmlspecialchars($_SESSION['config_template']); ?></pre>
			</div>
			<?php
			}
			elseif(isset($_SESSION['htaccess_template']) && install_status() == 1){
			?>
			<div class="cen">
				<h2><?php echo lg('Opps, I can\'t do again.') ?></h2>
				<i><?php echo lg('Check your directory permissions, or you can create this file manually. After that refresh this page.') ?></i><br/><br/>
			</div>
			<div class="lef">
				<pre class="code"><?php echo htmlspecialchars($_SESSION['htaccess_template']); ?></pre>
			</div>
			<?php
			}
			else{
			?>
			<form action="inc/install_step1.php" method="post">
				<div class="cen">
					<h2><?php echo lg('Set your Database!') ?></h2><br/>
				</div>
				<div class="lef">
					<div class="group">
						<input type="text" name="h" placeholder="<?php echo lg('Database Host, I guess localhost') ?>" value="<?php if(isset($_SESSION['h'])){echo $_SESSION['h'];}else{echo 'localhost';}?>"/>
						<p class="cb"><?php echo lg('Commonly it set localhost') ?></p>
					</div>
					<div class="group">
						<input type="text" name="u" placeholder="<?php echo lg('Database Username, for example: user_db_elybin') ?>" value="<?php if(isset($_SESSION['u'])){echo $_SESSION['u'];}?>"/>
						<p class="cb"><?php echo lg('Enter username of your Database connection. Ask your hosting provider, if you don\'t know that.') ?></p>
					</div>
					<div class="group">
						<input type="text" name="p" placeholder="<?php echo lg('Database Password, usually are random string.') ?>" value="<?php if(isset($_SESSION['p'])){echo $_SESSION['p'];}?>"/>
						<p class="cb"><?php echo lg('Enter password to your Database. Ask your hosting provider, if you don\'t know that.')?></p>
					</div>
					<div class="group">
						<input type="text" name="n" placeholder="<?php echo lg('Database Name, for example: db_elybin') ?>" value="<?php if(isset($_SESSION['n'])){echo $_SESSION['n'];}?>"/>
						<p class="cb"><?php echo lg('Enter name of your Database. Ask your hosting provider, if you don\'t know that.')?></p>
					</div>
				</div>
				<div class="rig">
					<button type="submit" class="btn p-rig"><?php echo lg('Next') ?></button><br/><br/>
				</div>
			</form>
			<?php } ?>
		</div>
		<div class="xs">
			<i><?php echo lg('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
<?php
		break;

	case 'step2':
	// allowed if...
	switch(install_status()){
		case 0:
			header('location: index.php');exit;
			break;
		case 1:
			header('location: index.php');exit;
			break;
		case 2:
			header('location: ?p=step1');exit;
			break;
		case 3:
			//header('location: ?p=step2');
			break;
		case 4:
			header('location: ?p=step3');exit;
			break;
		case 5:
			header('location: ?p=finish');exit;
			break;
		case -1:
			header('location: ?p=locked');exit;
			break;
		default:
			header('location: ?p=404');exit;
			break;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo lg('Quick Install')?> - Elybin CMS</title>
	<link rel='stylesheet' href='assets/stylesheets/install-welcome.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
		switch ($msg) {
			case 'fill_fullname':
				echo '<div class="al er"><p>'.lg('You don\'t have a name?').'</p></div>';
				break;
			case 'fill_username':
				echo '<div class="al er"><p>'.lg('Please fill Nickname first.').'</p></div>';
				break;
			case 'fill_email':
				echo '<div class="al er"><p>'.lg('Please fill E-mail.').'</p></div>';
				break;
			case 'fill_password':
				echo '<div class="al er"><p>'.lg('Please fill Password.').'</p></div>';
				break;
			case 'fill_both':
				echo '<div class="al er"><p>'.lg('Don\'t forget to fill Password in both field.').'</p></div>';
				break;
			case 'invalid_email':
				echo '<div class="al er"><p>'.lg('E-mail format not recognized. Example format is xxx@xxx.xxx.').'</p></div>';
				break;
			case 'invalid_username':
				echo '<div class="al er"><p>'.lg('Nickname format not recognized. Allowed character is letter(a-z), number(0-9) and underscore (_)').'</p></div>';
				break;
			case 'username_too_long':
				echo '<div class="al er"><p>'.lg('Maximum nickname character is 12 letter.').'</p></div>';
				break;
			case 'username_too_short':
				echo '<div class="al er"><p>'.lg('Minimum nickname character is 3 letter.').'</p></div>';
				break;
			case 'password_not_match':
				echo '<div class="al er"><p>'.lg('Both password didn\'t match each other, Please check.').'</p></div>';
				break;
			case 'password_too_short':
				echo '<div class="al er"><p>'.lg('Your password is too weak, try to use more combination.').'</p></div>';
				break;
			case 'db_auth_error':
				echo '<div class="al er"><p>'.lg('Connection error. Check Database Username or Database Password.').'</p></div>';
				break;
			case 'db_auth_error':
				echo '<div class="al er"><p>'.lg('Connection error. Check Database Username or Database Password.').'</p></div>';
				break;
			case 'register_user_failed':
				echo '<div class="al er"><p>'.lg('Failed to register new user.').'</p></div>';
				break;
			case 'query_error':
				echo '<div class="al er"><p>'.lg('Some query failed to execute, This is our mistake. Please contact us.').'</p></div>';
				break;

			default:

				break;
		}
		?>

		<div class="pb" style="width: 36%"><span>36%</span></div>
		<div class="box">
			<form action="inc/install_step2.php" method="post">
				<div class="cen">
					<h2><?php echo lg('Hi bro! Introduce your self') ?></h2><br/>
				</div>
				<div class="lef">
					<div class="group">
						<input type="text" name="fn" placeholder="<?php echo lg('My Name is...') ?>" value="<?php echo @$_SESSION['fn'] ?>"/>
						<p class="cb"><?php echo lg('Your full name here.') ?></p>
					</div>
					<div class="group">
						<input type="text" name="un" placeholder="<?php echo lg('You can call me...') ?>" value="<?php echo @$_SESSION['un'] ?>"/>
						<p class="cb"><?php echo lg('Your short name, without space but allowed using underscore and lower case only (letter and number).') ?></p>
					</div>
					<div class="group">
						<input type="text" name="e" placeholder="<?php echo lg('Maybe sometimes you need to E-mail me...') ?>" value="<?php echo @$_SESSION['e'] ?>"/>
						<p class="cb"><?php echo lg('Enter your active e-mail, it needed when your site in bad situation.') ?></p>
					</div>
					<div class="group">
						<input type="password" name="pu" placeholder="<?php echo lg('My secret word... (Password)') ?>"/>
						<p class="cb"><?php echo lg('Some combination of letter, number and symbol. Pick one that easy to remember.') ?></p>
					</div>
					<div class="group">
						<input type="password" name="puc" placeholder="<?php echo lg('Secret word once again... (Password Again)') ?>"/>
						<p class="cb"><?php echo lg('Type again your password. And remember it.') ?></p>
					</div>

				</div>
				<div class="rig">
					<button type="submit" class="btn p-rig"><?php echo lg('Next') ?></button><br/><br/>
				</div>
			</form>
		</div>
		<div class="xs">
			<i><?php echo lg('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
<?php
		break;

	case 'step3':
	// allowed if..
	switch(install_status()){
		case 0:
			header('location: index.php');exit;
			break;
		case 1:
			header('location: ?p=step1');exit;
			break;
		case 2:
			header('location: ?p=step1');exit;
			break;
		case 3:
			header('location: ?p=step2');exit;
			break;
		case 4:
			//header('location: ?p=step3');
			break;
		case 5:
			header('location: ?p=finish');exit;
			break;
		case -1:
			header('location: ?p=locked');exit;
			break;
		default:
			header('location: ?p=404');exit;
			break;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo lg('Quick Install')?> - Elybin CMS</title>
	<link rel='stylesheet' href='assets/stylesheets/install-welcome.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
		switch ($msg) {
			case 'fill_sitetitle':
				echo '<div class="al er"><p>'.lg('Enter your site title.').'</p></div>';
				break;
			case 'fill_category':
				echo '<div class="al er"><p>'.lg('Select site category.').'</p></div>';
				break;
			case 'fill_colour':
				echo '<div class="al er"><p>'.lg('Select your favorite color.').'</p></div>';
				break;
			case 'sitename_too_long':
				echo '<div class="al er"><p>'.lg('Site title too long maybe.').'</p></div>';
				break;

			default:
				break;
		}
		?>

		<div class="pb" style="width: 82%"><span>82%</span></div>
		<div class="box">
			<div class="cen">
				<?php
				// more friendly
				if(isset($_SESSION['un']) && @$_SESSION['un'] !== ''){
					echo '<h2>'.ucfirst($_SESSION['un']).', '.lg('How your website will look like?').'</h2><br/>';
				}else{
					echo '<h2>'.lg('How your website will look like?').'</h2><br/>';
				}
				?>
			</div>
			<form action="inc/install_step3.php" method="post">
				<div class="lef">
					<div class="group">
						<?php
						// more friendly
						if(isset($_SESSION['un']) && @$_SESSION['un'] !== ''){
							echo '<input type="text" name="wn" placeholder="'.lg('Enter site title. for example:').' '.ucfirst(strtolower($_SESSION['un'])).'\'s Amazing Story'.'"  value="'.@$_SESSION['wn'].'"/>';
						}else{
							echo '<input type="text" name="wn" placeholder="'.lg('Enter site title. for example: Richoo\'s Amazing Story').'"  value="'.@$_SESSION['wn'].'"/>';
						}
						?>

						<p class="cb"><?php echo lg('Enter your site main title, I suggest name that simple but can describe yours.') ?></p>
					</div>
					<div class="group">
						<select name="wc">
							<option value="none"<?php if(@$_SESSION['wc']=='none'){ echo ' selected="selected"';} ?>><?php echo lg('It will be...') ?></option>
							<option value="personal"<?php if(@$_SESSION['wc']=='personal'){ echo ' selected="selected"';} ?>><?php echo lg('Personal Website') ?></option>
							<option value="community"<?php if(@$_SESSION['wc']=='community'){ echo 's elected="selected"';} ?>><?php echo lg('Community or Organization') ?></option>
							<option value="business"<?php if(@$_SESSION['wc']=='business'){ echo ' selected="selected"';} ?>><?php echo lg('Company or Business Profile') ?></option>
							<option value="business"<?php if(@$_SESSION['wc']=='catalogue'){ echo ' selected="selected"';} ?>><?php echo lg('Online Catalogue/Sell and Buy Website') ?></option>
							<option value="business"<?php if(@$_SESSION['wc']=='gallery'){ echo ' selected="selected"';} ?>><?php echo lg('Photo Gallery/About Art') ?></option>
							<option value="business"<?php if(@$_SESSION['wc']=='event'){ echo ' selected="selected"';} ?>><?php echo lg('Event Website/RSVP') ?></option>
							<option value="business"<?php if(@$_SESSION['wc']=='application'){ echo ' selected="selected"';} ?>><?php echo lg('Application/Internal System/Cashier') ?></option>
							<option value="other"<?php if(@$_SESSION['wc']=='other'){ echo ' selected="selected"';} ?>><?php echo lg('Other...') ?></option>
						</select>
					</div>
					<div class="group">
						<select name="fc">
							<option value="none"<?php if(@$_SESSION['fc']=='none'){ echo ' selected="selected"';} ?>><?php echo lg('My favorite color...') ?></option>
							<option value="red"<?php if(@$_SESSION['fc']=='red'){ echo ' selected="selected"';} ?>><?php echo lg('Red') ?></option>
							<option value="pink"<?php if(@$_SESSION['fc']=='pink'){ echo ' selected="selected"';} ?>><?php echo lg('Pink') ?></option>
							<option value="orange"<?php if(@$_SESSION['fc']=='orange'){ echo ' selected="selected"';} ?>><?php echo lg('Orange') ?></option>
							<option value="yellow"<?php if(@$_SESSION['fc']=='yellow'){ echo ' selected="selected"';} ?>><?php echo lg('Yellow') ?></option>
							<option value="green"<?php if(@$_SESSION['fc']=='green'){ echo ' selected="selected"';} ?>><?php echo lg('Green') ?></option>
							<option value="brown"<?php if(@$_SESSION['fc']=='brown'){ echo ' selected="selected"';} ?>><?php echo lg('Brown') ?></option>
							<option value="blue"<?php if(@$_SESSION['fc']=='blue'){ echo ' selected="selected"';} ?>><?php echo lg('Light Blue') ?></option>
							<option value="purple"<?php if(@$_SESSION['fc']=='purple'){ echo ' selected="selected"';} ?>><?php echo lg('Purple') ?></option>
							<option value="black"<?php if(@$_SESSION['fc']=='black'){ echo ' selected="selected"';} ?>><?php echo lg('Black') ?></option>
							<option value="other"<?php if(@$_SESSION['fc']=='other'){ echo ' selected="selected"';} ?>><?php echo lg('Other...') ?></option>
						</select>
					</div>
				</div>
				<div class="rig">
					<button type="submit" class="btn p-rig"><?php echo lg('Next') ?></button><br/><br/>
				</div>
			</form>
		</div>
		<div class="xs">
			<i><?php echo lg('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
<?php
		break;

	case 'finish':
	// allowed if status -1
	switch(install_status()){
		case 0:
			header('location: index.php');exit;
			break;
		case 1:
			header('location: ?p=step1');exit;
			break;
		case 2:
			header('location: ?p=step1');exit;
			break;
		case 3:
			header('location: ?p=step2');exit;
			break;
		case 4:
			header('location: ?p=step3');exit;
			break;
		case 5:
			//header('location: ?p=finish');exit;
			break;
		case -1:
			header('location: ?p=locked');exit;
			break;
		default:
			header('location: ?p=404');exit;
			break;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo lg('Quick Install')?> - Elybin CMS</title>
	<link rel='stylesheet' href='assets/stylesheets/install-welcome.css' type='text/css'/>
	<link rel='stylesheet' href='assets/stylesheets/fontawesome.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
			echo '<div class="al if"><p>'.lg('Don\'t forget to delete &#34;elybin-install&#34; directory.').'</p></div>';
		?>
		<div class="pb" style="width: 100%"><span>100%</span></div>
		<div class="box">
			<div class="cen">
				<h2><?php echo lg('Hurray! your website already up!') ?></h2>
				<?php
				// if
				if(isset($_SESSION['temp_user'])){
				?>
				<code class="text-left">
				<?php echo lg('Login with this account') ?><br/>
				<?php echo lg('Username or E-mail:') ?> <?php echo @$_SESSION['temp_user'] ?><br/>
				<?php echo lg('Password:') ?> <?php echo @$_SESSION['temp_pass'] ?>
				</code><br/><br/>
				<?php
				}else{ ?>
				<i class="fa fa-rocket fa-5x"></i><br/><br/>
				<?php } ?>
				<i><?php echo lg('Let\'s celebrate, don\'t forget to decorate it.') ?></i>
			</div>
			<div class="cen">
				<a href="../" class="btn"><?php echo lg('Visit your new home') ?></a>
				<a href="../elybin-admin/?p=login" class="btn"><?php echo lg('Login as Owner') ?></a>
			</div>
		</div>
		<div class="xs">
			<i><?php echo lg('Everything inside one Bin, Elybin CMS.') ?></i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
<?php
		break;

	case 'locked':
	// allowed if status -1
	switch(install_status()){
		case 0:
			header('location: index.php');exit;
			break;
		case 1:
			header('location: ?p=step1');exit;
			break;
		case 2:
			header('location: ?p=step1');exit;
			break;
		case 3:
			header('location: ?p=step2');exit;
			break;
		case 4:
			header('location: ?p=step3');exit;
			break;
		case 5:
			header('location: ?p=finish');exit;
			break;
		case -1:
			//header('location: ?p=locked');
			break;
		default:
			header('location: ?p=404');exit;
			break;
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo lg('Locked')?> - Elybin CMS</title>
	<link rel='stylesheet' href='assets/stylesheets/install-welcome.css' type='text/css'/>
	<link rel='stylesheet' href='assets/stylesheets/fontawesome.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
		switch ($msg) {
			case 'register_complete':
				echo '<div class="al ok"><p>'.lg('Registration complete. You can login now.').'</p></div>';
				break;

			default:

				break;
		}
		?>

		<div class="box">
			<div class="cen">
				<h2><?php echo lg('Installation Locked Temporary') ?></h2><br/>
				<i class="fa fa-5x fa-lock"></i><br/>
				<i><?php echo lg('We\'re preventing someone steal your website while installing. So, your install process automatically locked after 2 hours, to continue installaion delete <code>install_date.txt</code> inside <code>elybin-install</code> and refresh this page.') ?></i>
			</div>
			<div class="cen">
				<a href="index.php" class="btn"><?php echo lg('Refresh Page') ?></a>
			</div>
		</div>
		<div class="xs">
			<i>Everything inside one Bin, Elybin CMS.</i>
			<a href="http://www.elybin.com/" class="p-rig" target="_blank">www.elybin.com</a>
		</div>
	</div>
</body>
</html>
<?php
		break;

	case 'visit':
	// allowed if status -1
	switch(install_status()){
		case 5:
			//header('location: ?p=finish');exit;
			break;
		default:
			header('location: index.php');exit;
			break;
	}
	// self kill
	remove_installer();
	header('location: ../');
		break;

	case 'login':
	// allowed if status -1
	switch(install_status()){
		case 5:
			//header('location: ?p=finish');exit;
			break;
		default:
			header('location: index.php');exit;
			break;
	}
	// self kill
	remove_installer();
	header('location: ../elybin-admin/index.php?p=login');
		break;


	// change language
	case 'id':
		change_language('id-ID');
		break;
	// change language
	case 'en':
		change_language('en-US');
		break;
}
?>
