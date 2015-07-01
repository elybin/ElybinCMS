<?php
/* Short description for file
 * Phto
 * [ 
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 -----------------
 1.1.3
 - First Build
 */
session_start();
header('Content-Type: application/json');
if(empty($_SESSION['login'])){	
	red('../../../../403.html');	
}else{
	include_once('../../../../elybin-core/elybin-function.php');
	include_once('../../../../elybin-core/elybin-oop.php');
	
	// string validation for security
	$v 	= new ElybinValidasi();

	// get usergroup privilage/access from current user to this module
	$usergroup = _ug()->post;

	// give error if no have privilage
	if($usergroup == 0){
		//er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to access this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
		
		$a = array(
			'status' => 'error',
			'value' => lg('You don\'t have access to access this page. Access Desied 403.')
		);

		echo json_encode($a);
		exit;
	}else{
		// fitler query first
		$term = $v->sql(@$_GET['term']);
	
		// get tags
		$tbt = new ElybinTable("");
		$ltag = $tbt->SelectFullCustom("
		SELECT 
		*
		FROM
		`elybin_tag` as `t`
		WHERE
		`t`.`name` LIKE '$term%'
		");
		
		// tampilkan
		$i = 0;
		foreach($ltag as $lt){
			// success
			$a[$i] = array(
				'id' => $lt->tag_id,
				'label' => $lt->name,
				'value' => $lt->name
			);
			$i++;
		}

		echo @json_encode($a);
		exit;
	}
}
?>