<?php
include '../elybin-core/elybin-oop.php';
include '../elybin-core/elybin-function.php';

// redirect to latest url
if(@$_GET['p'] != 'logout' && @$_GET['p'] != 'logout_modal'){
	if(isset($_SESSION['login'])){
		if(isset($_SESSION['ref'])){
			header('location: '.urldecode($_SESSION['ref']));
		}else{
			header('location: admin.php?mod=home');
		}
		exit;
	}
}else{
	// because logout is only for logged user, so force login
	if(!isset($_SESSION['login'])){
		header('location: index.php?p=login');
		exit;
	}
}

// get options
$op = op();

// err msg
$msg = @$_SESSION['msg'];
@$_SESSION['msg'] = '';

// use swtch
switch (@$_GET['p']) {

	default:
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo lg('Login')?> - <?php echo $op->site_name ?></title>
	<link rel='stylesheet' href='assets/stylesheets/login.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
		switch ($msg) {
			case 'logout_success':
				echo '<div class="al ok"><p>'.lg('Logout Successful.').'</p></div>';
				break;
			case 'password_changed':
				echo '<div class="al ok"><p>'.lg('Changes saved! Login with new password.').'</p></div>';
				break;
			case 'wrong_combination':
				echo '<div class="al er"><p>'.lg('The Username or Password is incorrect.').'</p></div>';
				break;
			case 'invalid_code':
				echo '<div class="al er"><p>'.lg('Wrong captcha code. Please try again.').'</p></div>';
				break;
			case 'login_blocked':
				echo '<div class="al er"><p>'.lg('You have exceeded the number of allowed login attempts. Please try again later.').'</p></div>';
				break;
			case 'fill_username':
				echo '<div class="al er"><p>'.lg('We need something to identify you, like Username or E-mail.').'</p></div>';
				break;
			case 'invalid_char':
				echo '<div class="al er"><p>'.lg('Username or E-mail format not recognized. Double check please.').'</p></div>';
				break;
			case 'invalid_link':
				echo '<div class="al er"><p>'.lg('You try to access invalid link. Please contact Administrator.').'</p></div>';
				break;
			case 'expired_link':
				echo '<div class="al er"><p>'.lg('You try to access expired link. Try to do forgot password again.').'</p></div>';
				break;
			case 'not_found':
				echo '<div class="al er"><p>'.lg('Page not found. (404)').'</p></div>';
				break;
			case 'session_expired':
				echo '<div class="al er"><p>'.lg('Session Expired, Please login again').'</p></div>';
				break;
			case 'register_complete':
				echo '<div class="al ok"><p>'.lg('Registration complete. You can login now.').'</p></div>';
				break;

			default:

				break;
		}
		?>

		<form action="login-process.php?p=login" method="POST">
			<div class="group">
				<input type="text" name="u" placeholder="<?php echo lg('Username or E-mail') ?>" required/>
			</div>
			<div class="group">
				<input type="password" name="p" placeholder="<?php echo lg('Password') ?>" required/>
			</div>
			<div class="group">
				<input type="text" name="c" class="w-50" placeholder="<?php echo lg('Right code here') ?>" required/>
				<img src="../elybin-core/elybin-captcha.php" class="w-45">
			</div>
			<input type="hidden" name="callback" value="<?php e(@$_GET['callback']) ?>">
			<button class="btn"><?php echo lg('Sign in') ?></button>
		</form>
		<div class="cen">
			<a href="?p=register"><?php echo lg('Register') ?></a> |
			<a href="?p=forgot"><?php echo lg('Forgot password?') ?></a>
			<br/>
			<a href="../">&#8592;&nbsp; <?php echo lg('Back to') ?> <?php echo $op->site_name ?></a>
		</div>
	</div>
</body>
</html>
<?php
		break;
	case 'register':
		// get temp session
		$ses_u = @$_SESSION['ses_u'];
		$ses_e = @$_SESSION['ses_e'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo lg('Register')?> - <?php echo $op->site_name ?></title>
	<link rel='stylesheet' href='assets/stylesheets/login.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
		switch ($msg) {
			case 'fill_username':
				echo '<div class="al er"><p>'.lg('Please fill Username first.').'</p></div>';
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
				echo '<div class="al er"><p>'.lg('Username format not recognized. Allowed character for Username is letter(a-z), number(0-9) and underscore (_)').'</p></div>';
				break;
			case 'username_too_long':
				echo '<div class="al er"><p>'.lg('Maximum username character is 12 letter.').'</p></div>';
				break;
			case 'username_too_short':
				echo '<div class="al er"><p>'.lg('Minimum username character is 3 letter.').'</p></div>';
				break;
			case 'password_not_match':
				echo '<div class="al er"><p>'.lg('Both password din\'t match each other, Please check.').'</p></div>';
				break;
			case 'username_taken':
				echo '<div class="al er"><p>'.lg('Username already taken, pick new one.').'</p></div>';
				break;
			case 'email_used':
				echo '<div class="al er"><p>'.lg('E-mail already used by another account.').'</p></div>';
				break;
			case 'invalid_code':
				echo '<div class="al er"><p>'.lg('Oops, wrong captcha code. Please try again.').'</p></div>';
				break;
			case 'password_too_short':
				echo '<div class="al er"><p>'.lg('Your password is too weak, try to use more combination.').'</p></div>';
				break;

			default:
				echo '<div class="al if"><p>'.lg('To complete registration fill this form.').'</p></div>';
				break;
		}
		?>

		<form action="login-process.php?p=register" method="POST">
			<div class="group">
				<input type="text" name="u" placeholder="<?php echo lg('Username') ?>" value="<?php echo $ses_u ?>" required/>
			</div>
			<div class="group">
				<input type="text" name="e" placeholder="<?php echo lg('E-mail') ?>" value="<?php echo $ses_e ?>" required/>
			</div>
			<div class="group">
				<input type="password" name="p" placeholder="<?php echo lg('Password') ?>" required/>
			</div>
			<div class="group">
				<input type="password" name="pc" placeholder="<?php echo lg('Type Password Again') ?>" required/>
			</div>
			<div class="group">
				<input type="text" name="c" class="w-50" placeholder="<?php echo lg('Right code here') ?>"/>
				<img src="../elybin-core/elybin-captcha.php" class="w-45">
			</div>
			<button class="btn"><?php echo lg('Register') ?></button>
		</form>
		<div class="cen">
			<a href="?p=login"><?php echo lg('Login') ?></a> |
			<a href="?p=forgot"><?php echo lg('Forgot password?') ?></a>
			<br/>
			<a href="../">&#8592;&nbsp; <?php echo lg('Back to') ?> <?php echo $op->site_name ?></a>
		</div>
	</div>
</body>
</html>
<?php
		break;

	case 'recover':
		// grab parameter
		$get_k = @$_GET['k'];
		// filter input & never let them empty
		if(!preg_match("/^[a-z0-9]+$/", $get_k) || empty($get_k) || strlen($get_k) > 32 || strlen($get_k) < 32){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('You try to access invalid link. Please contact Administrator.'),
				'msg_ses' => 'invalid_link',
				'red' => 'index.php?p=login'
			), @$_GET['r']);
		}

		// counting day from reset to access this link (using lastlogin)
		$tb = new ElybinTable('elybin_users');
		$cu = $tb->SelectFullCustom("
			SELECT
			*,
			COUNT(`user_id`) as `row`
			from
			`elybin_users` as `u`
			WHERE
			`u`.`user_account_forgetkey` = '$get_k'
			LIMIT 0,1
			")->current();

		// if link expired in 24 hour
		if($cu->row < 1 || diff_date(date('Y-m-d H:i:s'), $cu->forget_date, 'hour') > 24){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('You try to access expired link. Try to do forgot password again.'),
				'msg_ses' => 'expired_link',
				'red' => 'index.php?p=login'
			), @$_GET['r']);
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo lg('Reset Password')?> - <?php echo $op->site_name ?></title>
	<link rel='stylesheet' href='assets/stylesheets/login.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
		switch ($msg) {
			case 'password_not_match':
				echo '<div class="al er"><p>'.lg('Both password din\'t match each other, Please check.').'</p></div>';
				break;
			case 'password_too_short':
				echo '<div class="al er"><p>'.lg('Your password is too weak, try to use more combination.').'</p></div>';
				break;
			default:
				echo '<div class="al if"><p>'.lg('Okay! Enter your new password for your account.').'</p></div>';
				break;
		}
		?>
		<form action="login-process.php?p=recover" method="POST">
			<div class="group">
				<input type="password" name="p" placeholder="<?php echo lg('Password') ?>"/>
			</div>
			<div class="group">
				<input type="password" name="pc" placeholder="<?php echo lg('Type Password Again') ?>" required/>
			</div>
			<input type="hidden" name="k" value="<?php echo $get_k ?>"/>
			<button class="btn"><?php echo lg('Reset Password') ?></button>
		</form>
		<div class="cen">
			<a href="?p=register"><?php echo lg('Register') ?></a> |
			<a href="?p=login"><?php echo lg('Login') ?></a>
			<br/>
			<a href="../">&#8592;&nbsp; <?php echo lg('Back to') ?> <?php echo $op->site_name ?></a>
		</div>
	</div>
</body>
</html>
<?php
		break;

	case 'forgot':
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php echo lg('Reset Password')?> - <?php echo $op->site_name ?></title>
	<link rel='stylesheet' href='assets/stylesheets/login.css' type='text/css'/>
	<meta name='robots' content='noindex,follow' />
</head>
<body>
	<div class="in">
		<div class="lo">
			<img src="assets/images/logo.svg">
		</div>
		<?php
		switch ($msg) {
			case 'enter':
				echo '<div class="al er"><p>'.lg('Please enter E-mail of your account.').'</p></div>';
				break;
			case 'invalid_char':
				echo '<div class="al er"><p>'.lg('Username or E-mail format not recognized. Double check please.').'</p></div>';
				break;
			case 'email_notfound':
				echo '<div class="al er"><p>'.lg('E-mail not found inside our database. Try to register new account.').'</p></div>';
				break;
			case 'email_limit':
				echo '<div class="al er"><p>'.lg('We can\'t complete your request right now. Our mailing server very busy & reaching daily limit.').'</p></div>';
				break;
			case 'reset_sent':
				echo '<div class="al ok"><p>'.lg('Instruction was sent into your E-mail. Please check your E-mail.').'</p></div>';
				break;

			default:
				echo '<div class="al if"><p>'.lg('Enter your E-mail of your account. And follow the next step.').'</p></div>';
				break;
		}
		?>
		<form action="login-process.php?p=forgot" method="POST">
			<div class="group">
				<input type="text" name="e" placeholder="<?php echo lg('E-mail') ?>" required/>
			</div>
			<button class="btn"><?php echo lg('Send my Password') ?></button>
		</form>
		<div class="cen">
			<a href="?p=register"><?php echo lg('Register') ?></a> |
			<a href="?p=login"><?php echo lg('Login') ?></a>
			<br/>
			<a href="../">&#8592;&nbsp; <?php echo lg('Back to') ?> <?php echo $op->site_name ?></a>
		</div>
	</div>
</body>
</html>
<?php
		break;

	case 'logout_modal':
?>
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<h4 class="modal-title"><i class="fa fa-power-off"></i>&nbsp;&nbsp;<?php echo lg('Logout')?></h4>
				</div>
				<div class="modal-body"><?php echo lg('Are you sure to leave current session?')?>
					<hr/>
					<a href="index.php?p=logout" class="btn btn-danger"><i class="fa fa-power-off"></i>&nbsp;<?php echo lg('Yes, Exit')?></a>
					<button class="btn pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></button>
				</div>
<?php
		break;

	case 'logout':
		// logout
		if(!isset($_SESSION['login'])){
			header('location: index.php');
		}else{
			// set session to offline
			$tb = new ElybinTable('elybin_users');
			$tb->Update(array('session' => 'offline'), 'session', @$_SESSION['login']);

			session_unset();
			session_destroy();
			unset($_SESSION['login']);
			unset($_SESSION['last_activity']);
			unset($_SESSION['activity_created']);

			// result
			result(array(
				'status' => 'ok',
				'title' => lg('Success'),
				'msg' => lg('Logout Successful.'),
				'msg_ses' => 'logout_success',
				'red' => 'index.php?p=login'
				), @$_GET['r']);
		}
		break;
}
?>
