<?php
/* Short description for file
 * [ Home file of admin panel
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
@session_start();
if(!file_exists("../elybin-core/elybin-config.php")){
	header('location: ../elybin-install/');
	exit;
}

if(empty($_SESSION['login']) || !isset($_SESSION['login'])){
	$ref = urlencode("http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");
	$_SESSION['ref'] = $ref;
	header('location: index.php?p=login');
	exit;
}else{
include_once('../elybin-core/elybin-oop.php');
include_once('../elybin-core/elybin-function.php');
include_once('../elybin-core/elybin-function.panel.php');
include_once('./lang/main.php');
include_once('theme.php');
session_exp();

// session kill if not found in db
$tbus = new ElybinTable('elybin_users');
$csession = $tbus->GetRow('session',$_SESSION['login']);
if($csession == 0){
  session_destroy();
  unset($_SESSION['login']);
  header('location: index.php');
  exit;
}

$mod = "home";
$mod = @$_GET['mod'];
$clear = "no";
$clear = @$_GET['clear'];

$tbop = new ElybinTable('elybin_options');
$tbop = $tbop->SelectWhere('name','timezone','','')->current()->value;
date_default_timezone_set($tbop);

//ob_start('minify_html');
if(file_exists('./app/'.$mod.'/'.$mod.'.php')){
	if(!isset($clear)){

		theme_head();
		include('./app/'.$mod.'/'.$mod.'.php');
		theme_foot();

	}else{
		include('./app/'.$mod.'/'.$mod.'.php');
	}
}else{
	theme_head();
	include('./app/home/home.php');
	theme_foot();
}
//ob_end_flush(); // minify_html
}
?>
