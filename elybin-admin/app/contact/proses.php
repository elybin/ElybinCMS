<?php
/* Short description for file
 * [ Module: Contact Proccess
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

// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
$level = $tbus->current()->level; // getting level from curent user

$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
$usergroup = $tbug->current()->contact;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
	echo '';
}else{
	//start here
	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//DEL
	if ($mod=='contact' AND $act=='del'){
		//validate id from sqli
		$contact_id = $v->sql($_POST['contact_id']);
		$tabledel = new ElybinTable('elybin_contact');

		// check id exist or not
		$cocontact = $tabledel->GetRow('contact_id', $contact_id);
		if(empty($contact_id) OR ($cocontact == 0)){
			header('location: ../../../404.html');
			exit;
		}

		$tabledel->Delete('contact_id', $contact_id);

		//Done
		header('location:../../admin.php?mod='.$mod);
	}
	//MULTI DEL
	elseif ($mod=='contact' AND $act=='multidel'){
		//array of delected contact
		$contact_id = $_POST['del'];

		//if id array empty
		if(!empty($contact_id)){
			foreach ($contact_id as $ps) {
				// explode data because we use pipe
				$pecah = explode("|",$ps);
				$pecah = $pecah[0];
				// check id safe from sqli
				$contact_id_fix = $v->sql($pecah);
				
				// check id exist or not
				$tb 	= new ElybinTable('elybin_contact');
				$cocontact = $tb->GetRow('contact_id', $contact_id_fix);
				if(empty($contact_id) OR ($cocontact == 0)){
					header('location: ../../../404.html');
					exit;
				}

				//Done
				$tb->Delete('contact_id', $contact_id_fix);
				header('location:../../admin.php?mod='.$mod);
			}
		}
	}
	//404
	else{
		header('location: ../../../404.html');
	}
}	
}
?>