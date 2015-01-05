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
if(!file_exists("../../elybin-file/backup/db/")){
	echo "Backup databse tidak ditemukan. (Err: /elybin-file/backup/db/ empty?)";
	exit;
}else{
	// scan `/elybin-file/backup/db/` directory
	$dir = scandir("../../elybin-file/backup/db/");
	$file_found = false;
	$file_name = "";
	foreach($dir as $d){
		if(substr($d, -3) == "sql" && $file_found == false){	
			$file_found = true;
			$file_name = $d;
		}
	}
	
	// if file not found, give error
	if($file_found = false){
		echo "Backup databse tidak ditemukan. (Err: /elybin-file/backup/db/ empty?)";
		exit;
	}else{
		// check again
		if(!file_exists("../../elybin-file/backup/db/$file_name")){
			echo "File backup sql tidak bisa di akses. (Err: /elybin-file/backup/db/$file_name)";
			exit;
		}else{
			// include read query and execute
			// read `sql backup`
			$f = fopen("../../elybin-file/backup/db/$file_name", "r");
			$newest_query = '';
			while(!feof($f)){
			  $newest_query .= fgets($f);
			}
			fclose($f);
				
			
			// try connect
			$con = mysql_connect(DB_HOST,DB_USER,DB_PASSWD) or die(mysql_error());
			if($con){
				if(mysql_select_db(DB_NAME,$con) == false){
					echo "Tidak bisa meneukan database. (Err: Nama Database)";
					exit;
				}
			}else{
				// cannot connect to database host
				echo "Tidak bisa terhubung ke host database, mohon cek ulang (Err: Database Host/Database User/Database Password)";
				exit;
			}

			// explode query per line
			$newest_query = explode(";\n", $newest_query);
			$q = $newest_query;
			$success = 0;
			for($i=0; $i < count($q); $i++){
				if(@mysql_query(trim($q[$i]))){
					$success++;
				}else{
					$success--;
				}
			}

			// give query result
			if($success < count($q)){
				// query execution error
				echo "Beberapa queri gagal tapi mungkin tidak masalah.";
			}else{
				// finish
				echo "Database Imported Successfully.";
			}
			
		}
	}
}
?>