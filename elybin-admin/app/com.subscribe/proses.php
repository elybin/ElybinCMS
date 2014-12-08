<?php
/* Short description for file
 * [ Plugin: Subscribe Proccess
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
if(empty($_SESSION['login'])){	
	header('location:../../../403.php');	
}else{
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');

// get current active user
$s = $_SESSION['login'];
$tblu = new ElybinTable("elybin_users");
$tblu = $tblu->SelectWhere("session","$s","","");
$tblu = $tblu->current();
$level = $tblu->level; // getting level from curent user

// get user privilages
$tblpl = new ElybinTable('elybin_plugins');
$lpl = $tblpl->SelectWhereAnd('status','active','alias','com.subscribe','','')->current()->usergroup;


//explode usergroup and search
$plugin_priv = explode(",",$lpl);
// hide if privillage not found
if (array_search($level, $plugin_priv) !== false) {
	@$plavailable++;
}

if(@$plavailable == 0){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
}else{
	// start here
	//include self language library
	include_once('lang.php');

	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//DEL
	if ($mod=='com.subscribe' AND $act=='del'){
		//validate id from sqli
		$subscribe_id = $v->sql($_POST['subscribe_id']);
		$tabledel = new ElybinTable('com.elybin_subscribe');

		$tabledel->Delete('subscribe_id', $subscribe_id);

		//Done
		header('location:../../admin.php?mod='.$mod);
	}
	//404
	else{
		header('location:../../../404.php');
	}
}	
}
?>