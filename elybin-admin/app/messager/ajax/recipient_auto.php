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

	// give error if no have privilage
		// fitler query first
		$term = $v->sql(@$_GET['term']);
	
		// get tags
		$tb = new ElybinTable("");
		$lu = $tb->SelectFullCustom("
		SELECT 
		*
		FROM
		`elybin_users` as `u`
		WHERE
		`u`.`fullname` LIKE '$term%' || `u`.`user_account_email` LIKE '$term%' 
		");
		
		// tampilkan
		$i = 0;
		foreach($lu as $cu){
			// success
			$a[$i] = array(
				'id' => epm_encode($cu->user_id),
				'label' => $cu->fullname.' ('.$cu->user_account_email.')',
				'value' => $cu->user_account_email
			);
			$i++;
		}

		echo @json_encode($a);
		exit;
}
?>