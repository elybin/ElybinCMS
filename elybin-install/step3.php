<?php
session_start();
if(!file_exists("../elybin-core/elybin-config.php")){
	header('location: ../404.html');
	exit;
}else{
	// check elybin_config exist or not
	include('../elybin-core/elybin-config.php');
	include('../elybin-core/elybin-oop.php');
										
	$tbop = new ElybinTable("elybin_options");
	$coop = @$tbop->GetRow('','');
	if($coop == 0){
		header('location: ../404.html');
		exit;
	}
}


include_once('../elybin-admin/lang/main.php');
include_once('../elybin-core/elybin-function.php');
include_once('../elybin-core/elybin-oop.php');
include_once('./sqlquery.php');
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
		'error' => $err
	);
	echo json_encode($s);
	exit;
}

// modify user 1
$tbu = new ElybinTable("elybin_users");
$data = array(
'user_account_login' => $username,
'user_account_pass' => $password,
'user_account_email' => $email,
'fullname' => $fullname,
'avatar' => 'default/no-ava.png',
'registered' => date("Y-m-d")
);
$tbu->Update($data, 'user_id', '1');

// self del
deleteDir("../elybin-install/");
deleteDir("../README.txt");

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
?>