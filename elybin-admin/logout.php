<?php
/* Short description for file
 * [ Logout
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
include_once('../elybin-core/elybin-config.php');
include_once('../elybin-core/elybin-oop.php');
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
  // set session to offline
  $tbus = new ElybinTable('elybin_users');
  $tbus->Update(array('session' => 'offline'), 'session',$_SESSION['login']);
  
  session_unset();
  session_destroy();
  unset($_SESSION['login']);
  unset($_SESSION['last_activity']);
  unset($_SESSION['activity_created']);
  header('location:index.php?act=logout');
}
?>