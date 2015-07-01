<?php
/* Short description for file
 * Install : Step 3 Process
 * Insert root user to database and self remove installation folder
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
		header('location: ../?p=step2');exit;
		break;
	case 4:
		//header('location: ../?p=step3');
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
$wn = @$_POST['wn'];
$wc = @$_POST['wc'];
$fc = @$_POST['fc'];

// set tmp session
@$_SESSION['wn'] = $wn;
@$_SESSION['wc'] = $wc;
@$_SESSION['fc'] = $fc;

if(empty($wn)){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Enter your site title.'),
		'msg_ses' => 'fill_sitetitle',
		'red' => '../?p=step3'
	), @$_GET['r']);
}
if($wc == 'none'){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Select website category.'),
		'msg_ses' => 'fill_category',
		'red' => '../?p=step3'
	), @$_GET['r']);
}
if($fc == 'none'){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Select your favorite colour.'),
		'msg_ses' => 'fill_colour',
		'red' => '../?p=step3'
	), @$_GET['r']);
}
if(strlen($wn) > 100){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Site title too long maybe.'),
		'msg_ses' => 'sitename_too_long',
		'red' => '../?p=step3'
	), @$_GET['r']);
}

// process data
if(isset($_SESSION['lang']) && @$_SESSION['lang'] = 'id-ID'){
	$lang = 'id-ID';
}
else{
	$lang = 'en-US';
}
// check working url
if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) { 
	$pfx = "https://www."; 
}else{ 
	$pfx = "http://www.";
} 
$current_url = $pfx.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$site_url = str_replace("elybin-install/inc/install_step3.php", "", urldecode($current_url));
											
// check with dircheck.php
/*$site_url_cf = @file_get_contents($site_url."elybin-install/inc/dircheck.php");
if($site_url_cf !== "Bismillah")){ 
	$site_url_found = false;
}else{
	$site_url_found = true;
	$site_url = $site_url;
}*/


// update information
$installdate = date("Y-m-d H:i:s");
mysql_query("UPDATE `elybin_options` SET `value` = '$site_url' WHERE `name` = 'site_url'");
mysql_query("UPDATE `elybin_options` SET `value` = '$wn' WHERE `name` = 'site_name'");
mysql_query("UPDATE `elybin_options` SET `value` = '$installdate' WHERE `name` = 'installdate'");
mysql_query("UPDATE `elybin_options` SET `value` = '$fc' WHERE `name` = 'fav_colour'");
mysql_query("UPDATE `elybin_options` SET `value` = '$wc' WHERE `name` = 'site_category'");
mysql_query("UPDATE `elybin_options` SET `value` = '$lang' WHERE `name` = 'language'");

// set tmp session
@$_SESSION['wn'] = '';
@$_SESSION['wc'] = '';
@$_SESSION['fc'] = '';
@$_SESSION['un'] = '';

// result
result(array(
	'status' => 'ok',
	'title' => lg('Success'),
	'msg' => lg('Account Created!'),
	'msg_ses' => 'step3_ok',
	'red' => '../?p=finish'
), @$_GET['r']);

// change step
$_SESSION['step'] = "finish";

// prevent error by hosting external js
exit;
?>