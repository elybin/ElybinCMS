<?php
/**
 * Checking "SEO Title (a unique id every post)", then return true/false.
 *
 * @package   Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @author		Khakim A <kim@elybin.com>
 */
session_start();
header('Content-Type: application/json');
if(empty($_SESSION['login'])){
	red('../../../../403.html');
}else{
	include_once('../../../../elybin-core/elybin-function.php');
	include_once('../../../../elybin-core/elybin-oop.php');
	include_once('../inc/module-function.php');

	// give error if no have privilage
	if(_ug()->post == 0){
		result(array(
			'status' => 'error',
			'title' => lg('Access Desied 403.'),
			'msg' => lg('You don\'t have access to access this page.'),
			'msg_ses' => 'access_denied',
			'red' => '../../../../?p=login'
		), @$_GET['r']);
		exit;
	}else{
		// catch
		$seo = sqli_(@$_GET['seo']);
		$pid = sqli_(epm_decode(@$_GET['pid']));
		// final result
		if(!check_seotitle($seo, $pid)){
			json(array(
				'available' => false,
				'suggestion' => suggest_unique($seo, $pid),
				'error' => _('Error'),
				'msg' => _('SEO title already used, there our suggestion.')
			));
		}else{
			json(array(
				'available' => true
			));
		}
	}
}
?>
