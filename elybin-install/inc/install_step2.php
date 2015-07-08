<?php
/* Short description for file
 * Install : Step 2 Process
 * Checking user installation directory, write site information to `elybin_options`
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
include_once('install.func.php');

// allowed if...
switch(install_status()){
	case 0:
		header('location: ../index.php');exit;
		break;
	case 1:
		header('location: ../index.php');exit;
		break;
	case 2:
		header('location: ../step3.php');exit;
		break;
	case 3:
		//header('location: ../?p=step2');
		break;
	case 4:
		header('location: ../?p=step3');exit;
		break;
	case 5:
		header('location: ../?p=finish');exit;
		break;
	case -1:
		header('location: ../?p=locked');exit;
		break;
	default:
		header('location: ../?p=404');exit;
		break;
}



// get data
$fn = @$_POST['fn'];
$un = @$_POST['un'];
$e = @$_POST['e'];
$pu = @$_POST['pu'];
$puc = @$_POST['puc'];

// set tmp session
@$_SESSION['fn'] = $fn;
@$_SESSION['un'] = $un;
@$_SESSION['e'] = $e;
@$_SESSION['pu'] = $pu;
@$_SESSION['puc'] = $puc;

// temp
$tmpas = strlen($pu);
$tmpas_o = '';
for ($i=0; $i < $tmpas ; $i++) {
	$tmpas_o .= '*';
}
@$_SESSION['temp_user'] = substr($un, 0,strlen($un)-3).'*** / ***'.substr($e, 3,strlen($e));
@$_SESSION['temp_pass'] = $tmpas_o;

// never let em empty
if(empty($fn)){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('You don\'t have a name?'),
		'msg_ses' => 'fill_fullname',
		'red' => '../?p=step2'
	), @$_GET['r']);
}
if(empty($un)){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Please fill Nickname first.'),
		'msg_ses' => 'fill_username',
		'red' => '../?p=step2'
	), @$_GET['r']);
}// if input email error, try filter username
if(!preg_match("/^[a-z0-9_]+$/", $un)){
	// woops! not matched anything, I given up! give 'em result!
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Username format not recognized. Allowed character for Username is letter(a-z), number(0-9) and underscore (_)'),
		'msg_ses' => 'invalid_username',
		'red' => '../?p=step2'
	), @$_GET['r']);
}
// limit username length
if(strlen($un) > 12){
	// woops! not matched anything, I given up! give 'em result!
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Maximum nickname character is 12 letter.'),
		'msg_ses' => 'username_too_long',
		'red' => '../?p=step2'
	), @$_GET['r']);
}
// limit username length
if(strlen($un) < 3){
	// woops! not matched anything, I given up! give 'em result!
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Minimum nickname character is 3 letter.'),
		'msg_ses' => 'username_too_short',
		'red' => '../?p=step2'
	), @$_GET['r']);
}
if(empty($e)){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Please fill E-mail.'),
		'msg_ses' => 'fill_email',
		'red' => '../?p=step2'
	), @$_GET['r']);
}
if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $e)){
	// woops! not matched anything, I given up! give 'em result!
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('E-mail format not recognized. Example format is xxx@xxx.xxx.'),
		'msg_ses' => 'invalid_email',
		'red' => '../?p=step2'
	), @$_GET['r']);
}
if(empty($pu)){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Please fill Password.'),
		'msg_ses' => 'fill_password',
		'red' => '../?p=step2'
	), @$_GET['r']);
}
// limit password
if(strlen($pu) < 6){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Your password is too weak, try to use more combination.'),
		'msg_ses' => 'password_too_short',
		'red' => '../?p=step2'
	), @$_GET['r']);
}
if(empty($puc)){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Don\'t forget to fill Password in both field.'),
		'msg_ses' => 'fill_both',
		'red' => '../?p=step2'
	), @$_GET['r']);
}

// match the password
if($pu !== $puc){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Both password din\'t match each other, Please check.'),
		'msg_ses' => 'password_not_match',
		'red' => '../?p=step2'
	), @$_GET['r']);
}

// include password hasher
include '../../elybin-core/lib/password.php';

// process data
$un = strtolower($un);
$pu_h = password_hash($pu, PASSWORD_BCRYPT);

// input user
if(connect_with_config()){
	if(!mysql_query("
		INSERT INTO
		`elybin_users`(
			`user_id`,
			`user_account_login`,
			`user_account_pass`,
			`user_account_email`,
			`email_status`,
			`fullname`,
			`registered`,
			`level`
		)
		VALUES('1', '$un','$pu_h','$e','verified','$fn','".date('Y-m-d H:i:s')."','1');")){
		// error
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Failed to register new user.'),
			'msg_ses' => 'register_user_failed',
			'red' => '../?p=step2'
		), @$_GET['r']);
	}
}else{
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Connection error. Check Database Username or Database Password.'),
		'msg_ses' => 'db_auth_error',
		'red' => '../?p=step2'
	), @$_GET['r']);
}

// set tmp session
@$_SESSION['fn'] = '';
@$_SESSION['e'] = '';
@$_SESSION['pu'] = '';
@$_SESSION['puc'] = '';

// result
result(array(
	'status' => 'ok',
	'title' => lg('Success'),
	'msg' => lg('Account Created!'),
	'msg_ses' => 'step2_ok',
	'red' => '../?p=step3'
), @$_GET['r']);

// change step
$_SESSION['step'] = "3";

// prevent error by hosting external js
exit;
?>
