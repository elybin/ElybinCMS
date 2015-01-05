<?php
/* Short description for file
 * Install : Step 3 Process
 * Insert root user to database and self remove installation folder
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
include_once('../../elybin-admin/lang/main.php');
include_once('../../elybin-core/elybin-function.php');
include_once('../../elybin-core/elybin-oop.php');
include_once("seo.php");

// Checking step 1 (Database Connection Config)
// checking `.htaccess` 
if(!file_exists("../../.htaccess") || !file_exists("../../elybin-core/elybin-config.php")){
	// redirect to index 
	header('location: ../index.php');
	exit;
}
include_once("../../elybin-core/elybin-config.php");
// step 1 passed

// Checking step 2 (Information Setup/Writing database)
// check table `elybin_config` exist or not
@include_once('../../elybin-core/elybin-oop.php');
$tbop = new ElybinTable("elybin_options");
$coop = $tbop->GetRow('','');
// if `elybin_options` row empty 
if($coop == 0  || $coop == ''){
	// step 2 hasn't passed yet, restart step 2 
	// redirect to step 2
	header('location: ../step2.php');
	exit;
}
// step 2 passed

// Checking step 3 (Administrator Account)
// if user found in table `elybin_users`
$tbu = new ElybinTable('elybin_users');
$couser = $tbu->GetRow('user_id','1');
if($couser > 0){
	// redirect to finish
	header('location: ../../elybin-admin/index.php');
	exit;
}
// step 3 already passed


// Step 3
$v = new ElybinValidasi();

// get data
$fullname = $v->sql($_POST['el_fn']);
$username = $v->sql($_POST['el_un']);
$email = $v->xss($_POST['el_em']);
$password = md5($_POST['el_pw']);
$passwordc = md5($_POST['el_pwc']);

//if field empty
if(empty($fullname) || empty($username) || empty($email) || empty($password) || empty($passwordc) || ($password !== $passwordc)){
	if(empty($fullname)){
		$err = "el_fn";
	}
	elseif(empty($username)){
		$err = "el_un";
	}
	elseif(empty($email)){
		$err = "el_em";
	}
	elseif(empty($password)){
		$err = "el_pw";
	}
	elseif(empty($passwordc)){
		$err = "el_pwc";
	}

	//fill important
	$s = array(
		'status' => 'error',
		'title' => $lg_error,
		'isi' => $lg_pleasefillimportant,
		'error' => @$err
	);
	echo json_encode($s);
	exit;
}

// modify user 1
$tbu = new ElybinTable("elybin_users");
$data = array(
	'user_id' => '1',
	'user_account_login' => $username,
	'user_account_pass' => $password,
	'user_account_email' => $email,
	'fullname' => $fullname,
	'phone' => '+6280000000000',
	'bio' => 'Change something, if you can&#039;t make it better, make it look nice.',
	'avatar' => 'default/no-ava.png',
	'registered' => date("Y-m-d"),
	'lastlogin' => '0000-00-00 00:00:00',
	'user_account_forgetkey' => '',
	'level' => '1',
	'session' => 'offline',
	'status' => 'active'
);
$tbu->Insert($data);

// self del
deleteDir("../../elybin-install/");
deleteDir("../../elybin-install/install_date.txt");
deleteDir("../../README.txt");

$s = array(
	'status' => 'ok',
	'title' => $lg_success,
	'isi' => $lg_systeminformationsaved,
	'el_fn' => $fullname,
	'el_un' => $username,
	'el_em' => $email,
	'el_pw' => '********',
	'el_pwc' => '********'
);
echo json_encode($s);

// change step
$_SESSION['step'] = "finish";
?>