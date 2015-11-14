<?php
/* Short description for file
 * Install : Step 1 Process
 * After checking connection from information that user input, this file will write data to config file and write .htaccess too
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
include_once('../install.func.php');

//W.I.W.S
where_i_was_supposed();

// get post data
$h = @$_POST['h'];
$u = @$_POST['u'];
$p = @$_POST['p'];
$n = @$_POST['n'];

// set tmp session
@$_SESSION['h'] = $h;
@$_SESSION['u'] = $u;
@$_SESSION['p'] = $p;
@$_SESSION['n'] = $n;

// never let em empty
if(empty($h)){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Enter Database Host.'),
		'msg_ses' => 'empty_db_host',
		'red' => get_url('install.step1')
	), @$_GET['r']);
}
if(empty($u)){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Enter Database Username.'),
		'msg_ses' => 'empty_db_user',
		'red' => get_url('install.step1')
	), @$_GET['r']);
}
if(empty($n)){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Enter Database Name.'),
		'msg_ses' => 'empty_db_name',
		'red' => get_url('install.step1')
	), @$_GET['r']);
}

if(try_connect_manual($h, $u, $p, $n) == 0){
	// db not found
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Connection to database error. Database not found.'),
		'msg_ses' => 'db_notfound',
		'red' => get_url('install.step1')
	), @$_GET['r']);
}else
if(try_connect_manual($h, $u, $p, $n) == 1){
	// cannot connect to database host
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Connection error. Check Database Username or Database Password.'),
		'msg_ses' => 'db_auth_error',
		'red' => get_url('install.step1')
	), @$_GET['r']);
}
else if(try_connect_manual($h, $u, $p, $n) == 2){
	if(write_config($h, $u, $p, $n) == false){
		// because failed to write config,
		// alternative to weite it manually
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Failed writing &#34;elybin-config.php&#34;. Fix your directory permissions, and try again.'),
			'msg_ses' => 'failed_config',
			'red' => get_url('install.step1')
		), @$_GET['r']);
	}else{
		// if install with content
		if(!import_sql(array(many_trans()."elybin-install/mysql/latest.sql"))){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Some query failed to execute, This is our mistake. Please contact us.'),
				'msg_ses' => 'query_error',
				'red' => get_url('install.step1')
			), @$_GET['r']);
		}else{
			// success

			// rem tmp session
			@$_SESSION['h'] = '';
			@$_SESSION['u'] = '';
			@$_SESSION['p'] = '';
			@$_SESSION['n'] = '';
			$_SESSION['msg'] = '';

			result(array(
				'status' => 'ok',
				'title' => lg('Success'),
				'msg' => lg('Database configuration success!'),
				'msg_ses' => 'step1_ok',
				'red' => get_url('install.step2')
			), @$_GET['r']);

			// change step
			$_SESSION['step'] = "2";
		}
	}
}

// unknown error
result(array(
	'status' => 'error',
	'title' => lg('Error'),
	'msg' => lg('Unknown error. Please contact us.'),
	'msg_ses' => 'unk_error',
	'red' => get_url('install.step1')
), @$_GET['r']);

// prevent error by hosting external js
exit;
?>
