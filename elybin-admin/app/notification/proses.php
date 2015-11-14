<?php
/* Short description for file
 * [ Module: Notification Procces
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
session_start();
if(empty($_SESSION['login'])){
	echo '403';
	header('location:../../../403.html');
}else{	
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once('../../lang/main.php');

	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	// READ
	if ($mod=='notification' AND $act=='read'){
		//update to read
		$tbl = new ElybinTable('elybin_notification');
		$data = array('status'=>'read');
		$tbl->Update($data,'status','unread');	
		echo "ok";	
	}

	//404
	else{
		//echo '404';
		header('location:../../../404.html');
	}
}	
?>