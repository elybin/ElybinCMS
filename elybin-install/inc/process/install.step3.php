<?php
/* Short description for file
 * Install : Step 3 Process
 * Insert root user to database and self remove installation folder
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
include_once('../install.func.php');

//W.I.W.S
where_i_was_supposed();

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
		'red' => get_url('install.step3')
	), @$_GET['r']);
}
if($wc == 'none'){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Select website category.'),
		'msg_ses' => 'fill_category',
		'red' => get_url('install.step3')
	), @$_GET['r']);
}
if($fc == 'none'){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Select your favorite colour.'),
		'msg_ses' => 'fill_colour',
		'red' => get_url('install.step3')
	), @$_GET['r']);
}
if(strlen($wn) > 100){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Site title too long maybe.'),
		'msg_ses' => 'sitename_too_long',
		'red' => get_url('install.step3')
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
$site_url = urldecode(get_url('home_url'));

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
	'red' => get_url('install.finish')
), @$_GET['r']);

// change step
$_SESSION['step'] = "finish";

// prevent error by hosting external js
exit;
?>
