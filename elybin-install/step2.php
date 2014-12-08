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
	if($coop > 0  || $coop != ''){
		header('location: ../404.html');
		exit;
	}
}

include_once('../elybin-admin/lang/main.php');
include_once('./sqlquery.php');
// Step 2

// get data
$current_url = @$_POST['site_url'];
$site_name = @$_POST['site_name'];
$site_email = @$_POST['site_email'];
$timezone = @$_POST['timezone'];
$admin_theme = @$_POST['admin_theme'];

//if field empty
if(empty($current_url) || empty($site_name) || empty($site_email) || empty($timezone) || empty($admin_theme)){
	if(empty($current_url)){
		$err = "site_url";
	}
	elseif(empty($site_name)){
		$err = "site_name";
	}
	elseif(empty($site_email)){
		$err = "site_email";
	}
	elseif(empty($timezone)){
		$err = "timezone";
	}
	elseif(empty($admin_theme)){
		$err = "admin_theme";
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

// check with dircheck.php
$site_url_cfg = str_replace("elybin-install/install.php", "", urldecode($current_url));
$f = fopen("dircheck.php", "r");
if(!$f OR !fgets($f) == "Bismillah"){ 
	$site_url_cfg = $current_url;
}

ins_table($site_url_cfg, $site_name, $site_email, $timezone, $admin_theme);
?>