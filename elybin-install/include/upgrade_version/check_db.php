<?php
/* Short description for file
 * Check DB
 * Checking databse conenction while upgrading
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */

// check previous version
if(!file_exists("../../elybin-file/backup/elybin-config_backup.php")){
	echo "File konfigurasi tidak ditemukan. (Err: elybin-config_backup.php ?)";
	exit;
}else{
	// check connection
	include("../../elybin-file/backup/elybin-config_backup.php");
	
	// check again
	if(empty($DB_HOST) OR empty($DB_USER) OR empty($DB_PASSWD) OR empty($DB_NAME)){
		echo "Tidak bisa membaca konfigurasi database. (Err: elybin_config_backup.php)";
		exit;
	}else{
		// get data
		$db_host = $DB_HOST;
		$db_user = $DB_USER;
		$db_pass = $DB_PASSWD;
		$db_name = $DB_NAME;
		
		// try connect
		$con = @mysql_connect($db_host,$db_user,$db_pass);
		if($con){
			// cannot connect to db
			if(mysql_select_db($db_name,$con) == false){
				$s = array(
					'status' => 'error',
					'title' => $lg_error,
					'isi' => $lg_cannotconnecttodatabasepleasecheck,
					'error' => 'Database Name'
				);
				echo json_encode($s);
				exit;
			}	
		}else{
			// cannot connect to database host
			$s = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_cannotconnecttodatabasehostpleasecheck,
				'error' => 'Database Host/Database User/Database Password'
			);
			echo json_encode($s);
			exit;
		}
		
	}
}
?>