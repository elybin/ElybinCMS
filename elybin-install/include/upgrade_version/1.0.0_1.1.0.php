<?php
/* Short description for file
 * Upgrade version 1.0.0 to 1.1.0
 * version 1.0.0 to 1.1.0
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */

// check previous version
if(file_exists("../../elybin-file/backup/elybin-config_backup.php") AND file_exists("../../elybin-file/backup/elybin-version_backup.php")){
	$backup_available = true;
}else{
	$backup_available = false;
}

// write new `elybin-config.php`
// config file changed since version 1.1.0 (Gasing)
if($backup_available){
	// check connection 
	include("check_db.php");

	// get cwd (Current Working Directory)
	$local_dir = @getcwd();
	$local_dir = str_replace("\\elybin-install\include","",$local_dir);
	$local_dir = str_replace("/elybin-install/include","",$local_dir);
	$local_dir = str_replace("\\","/", $local_dir);
	
	// write new (elybin-config.php)
	//SITE CONFIG
	$config_dir = '../../elybin-core/elybin-config.php';
	$config_template = 
'<?php
//SITE CONFIG
$DIR_ROOT						= "'.$DIR_ROOT.'";
$DIR_ADMIN						= "{$DIR_ROOT}elybin-admin/";
$DIR_CONTENT					= "{$DIR_ROOT}elybin-content/";
$DIR_CORE						= "{$DIR_ROOT}elybin-core/";

$DB_HOST						= "'.$db_host.'";
$DB_USER						= "'.$db_user.'";
$DB_PASSWD						= "'.$db_pass.'";
$DB_NAME						= "'.$db_name.'";

define("DB_HOST", $DB_HOST);
define("DB_USER", $DB_USER);
define("DB_PASSWD", $DB_PASSWD);
define("DB_NAME", $DB_NAME);

define("DIR_ROOT", $DIR_ROOT);
define("DIR_ADMIN", $DIR_ADMIN);
?>';
	// write to file
	$f = fopen($config_dir, "w");
	if(fwrite($f, $config_template) == false){
		// if failed write data
		$s = array(
			'status' => 'error',
			'title' => $lg_error,
			'isi' => $lg_failedwritingconfigfile,
			'error' => 'Error: Write Config File'
		);
		echo json_encode($s);
		exit;
	}
	fclose($f);
	
	// import databse
	include("import_db.php");
	
	// database change
	mysql_query("UPDATE `elybin_themes` SET `name` = 'Young Free v.1.0.1' WHERE `folder` = 'young-free'");

	
	// update htaccess
	// Create htaccess (force write not copy to avoid some error in linux server)
	$htaccess_dir = '../../.htaccess';
	// read `htaccess_template.txt`
	$f = fopen("htaccess_template.txt", "r");
	$htaccess_template = '';
	while(!feof($f)){
	  $htaccess_template .= fgets($f);
	}
	fclose($f);
	// write to file
	$f = fopen($htaccess_dir, "w");
	if(fwrite($f, $htaccess_template) == false){
		// if failed write htaccess
		echo "Error: Write .htaccess";
		exit;
	}
	fclose($f);
	
	// finish
	header('location: ../upgradesuccess.php');
}
?>