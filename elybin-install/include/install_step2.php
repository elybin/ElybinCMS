<?php
/* Short description for file
 * Install : Step 2 Process
 * Checking user installation directory, write site information to `elybin_options`
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
include_once('../../elybin-core/elybin-function.php');
include_once('../../elybin-admin/lang/main.php');

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
$coop = @$tbop->GetRow('','');
// if `elybin_options` row empty 
if($coop > 0){
	// step 2 successfully passed
	// redirect to step2
	header('location: ../step3.php');
	exit;
}
// step 2 passed

// get data
$site_url = @$_POST['site_url'];
$site_name = @$_POST['site_name'];
$site_email = @$_POST['site_email'];
$timezone = @$_POST['timezone'];
$admin_theme = @$_POST['admin_theme'];

// check working url
if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) { 
	$pfx = "https://"; 
}else{ 
	$pfx = "http://";
} 
$current_url = $pfx.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$site_url_check = str_replace("elybin-install/include/install_step2.php", "", urldecode($current_url));
											
// check with dircheck.php
$f = fopen($site_url_check."elybin-install/include/dircheck.php", "r");
if(!$f OR (fgets($f) !== "Bismillah")){ 
	$site_url_found = false;
}else{
	$site_url_found = true;
	$site_url = $site_url_check;
}

//if field empty
if(empty($site_url) || empty($site_name) || empty($site_email) || empty($timezone) || empty($admin_theme)){
	if(empty($site_url)){
		$err = "Site Url";
	}
	elseif(empty($site_name)){
		$err = "Site Name";
	}
	elseif(empty($site_email)){
		$err = "Site Email";
	}
	elseif(empty($timezone)){
		$err = "Timezone";
	}
	elseif(empty($admin_theme)){
		$err = "Admin Theme";
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


// read `../mysql/newest.sql"`
$f = fopen("../mysql/newest.sql", "r");
$newest_query = '';
while(!feof($f)){
  $newest_query .= fgets($f);
}
fclose($f);

// try connect
$con = mysql_connect(DB_HOST,DB_USER,DB_PASSWD) or die(mysql_error());
if($con){
 	if(mysql_select_db(DB_NAME,$con) == false){
		$s = array(
			'status' => 'error',
			'title' => $lg_error,
			'isi' => $lg_cannotconnecttodatabasepleasecheck,
			'error' => 'Database Name'
		);
		echo json_encode($s);
		exit;
	}
}else{
	// cannot connect to database host
	$s = array(
		'status' => 'error',
		'title' => $lg_error,
		'isi' => $lg_cannotconnecttodatabasehostpleasecheck,
		'error' => 'Database Host/Database User/Database Password'
	);
	echo json_encode($s);
	exit;
}

// explode query per line
$newest_query = explode(";\r\n", $newest_query);
$q = $newest_query;
$success = 0;
for($i=0; $i < count($q); $i++){
	if(@mysql_query(trim($q[$i]))){
		$success++;
	}else{
		$success--;
	}
}

// give query result
if($success < count($q)){
	// query execution error
	$s = array(
		'status' => 'error',
		'title' => $lg_error,
		'isi' =>  $lg_fewqueryfailedtoexecutedbutok,
		'error' => 'Query Success: ('.$success."/".count($q).') '
	);
	echo json_encode($s);
	exit;
}

// update information
date_default_timezone_set($timezone);
$installdate = date("Y-m-d H:i:s");
mysql_query("UPDATE `elybin_options` SET `value` = '$site_url' WHERE `name` = 'site_url'");
mysql_query("UPDATE `elybin_options` SET `value` = '$site_name' WHERE `name` = 'site_name'");
mysql_query("UPDATE `elybin_options` SET `value` = '$site_email' WHERE `name` = 'site_email'");
mysql_query("UPDATE `elybin_options` SET `value` = '$timezone' WHERE `name` = 'timezone'");
mysql_query("UPDATE `elybin_options` SET `value` = '$admin_theme' WHERE `name` = 'admin_theme'");
mysql_query("UPDATE `elybin_options` SET `value` = '$installdate' WHERE `name` = 'installdate'");


// success
$s = array(
	'status' => 'ok',
	'title' => $lg_success,
	'isi' => $lg_systeminformationsaved,
	'site_url' => $site_url,
	'site_name' => $site_name,
	'site_email' => $site_email,
	'timezone' => $timezone,
	'admin_theme' => $admin_theme
);
echo json_encode($s);

// change step
$_SESSION['step'] = "3";
?>