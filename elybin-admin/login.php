<?php
/* Short description for file
 * [ Login Procees 
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
include_once('../elybin-core/elybin-function.php');
include_once('../elybin-core/elybin-oop.php');
include_once('./lang/main.php');
if(isset($_SESSION['login'])){
	header('location:'.$SITE_ADMIN.'admin.php');
}else{
	$v = new ElybinValidasi;

	// getting post value
	$username = $v->sql(@$_POST['elybin_username']);
	$password = md5(@$_POST['elybin_password']);
	if(empty($username)){
		header('location:index.php');
	}else{
		if(@$_SESSION['loginfail'] >= 6){
			header('location:index.php?act=banned');
			exit;
		}
		// if code wrong
		if(checkcode(@$_POST['code']) == false){
			header('location:index.php?act=invalidcode');
			exit;
		}
		// checking on database
		$tbl = new ElybinTable('elybin_users');
		$cuser = $tbl->Login('user_account_login', $username, 'user_account_pass', $password, 'status', 'active');
		$cuser = $cuser->current();

		if($cuser){
			// generating new random session
			$rand = md5(md5(rand(1000,9999).rand(1,9999)));
			$d = array(
				'session' => $rand,
				'user_account_forgetkey' => ''
			);
			$tbl->Update($d,'user_id',$cuser->user_id);

			//$_SESSION['level'] = $cuser->level;
			$_SESSION['login'] = $rand;
			$_SESSION['last_activity'] = time(); 
			$_SESSION['loginfail'] = 0;
			unset($_SESSION['loginfail']);

			//url referer
			if(isset($_SESSION['ref'])){
				$ref = urldecode($_SESSION['ref']);
				header('location: '.$ref);
			}else{
				header('location: admin.php?mod=home');
			}
			
		}else{
			//set if wrong login
			if(!isset($_SESSION['loginfail'])){
				$_SESSION['loginfail'] = 1;
			}else{
				$_SESSION['loginfail'] = $_SESSION['loginfail']+1;
			}
			header('location:index.php?act=wrong');
		}
	}
}
?>