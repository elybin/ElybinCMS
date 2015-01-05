<?php
/* Short description for file
 * Install : Step 1 Process
 * After checking connection from information that user input, this file will write data to config file and write .htaccess too
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
include_once('../../elybin-core/elybin-function.php');
// Checking step 1 (Database Connection Config)
// checking `.htaccess` 
if(file_exists("../../.htaccess") && file_exists("../../elybin-core/elybin-config.php")){
	// redirect to index 
	header('location: ../step2.php');
	exit;
}
// step 1 passed

// delete `.htaccess` and `elybin-config.php` before installation
deleteDir("../../.htaccess");
deleteDir("../../elybin-core/elybin-config.php");

// include language
include_once('../../elybin-admin/lang/main.php');

// get post data
$db_host = @$_POST['db_host'];
$db_user = @$_POST['db_user'];
$db_pass = @$_POST['db_pass'];
$db_name = @$_POST['db_name'];

//if field empty
if(empty($db_host) || empty($db_user) || empty($db_pass) || empty($db_name)){
	if(empty($db_host)){
		$err = "Database Host";
	}
	elseif(empty($db_user)){
		$err = "Database Username";
	}
	elseif(empty($db_pass)){
		$err = "Database Password";
	}
	elseif(empty($db_name)){
		$err = "Database Name";
	}

	//fill important
	$s = array(
		'status' => 'error',
		'title' => $lg_error,
		'isi' => $lg_pleasefillimportant,
		'error' => $err
	);
	echo json_encode($s);
	exit;
}

// try connect
$con = @mysql_connect($db_host,$db_user,$db_pass);
if($con){
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

// get cwd (Current Working Directory)
$local_dir = @getcwd();
$local_dir = str_replace("\\elybin-install\include","",$local_dir);
$local_dir = str_replace("/elybin-install/include","",$local_dir);
$local_dir = str_replace("\\","/", $local_dir);

// write to file (elybin-config.php)
//SITE CONFIG
$config_dir = '../../elybin-core/elybin-config.php';
$config_template = 
'<?php
//SITE CONFIG
$DIR_ROOT						= "'.$local_dir.'/";
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
	$s = array(
		'status' => 'error',
		'title' => $lg_error,
		'isi' => $lg_failedwritinghtaccessfile,
		'error' => 'Error: Write .htaccess'
	);
	echo json_encode($s);
	exit;
}
fclose($f);

// success write `.htaccess` file
$s = array(
	'status' => 'ok',
	'title' => $lg_success,
	'isi' => $lg_systeminformationsaved,
	'db_host' => $db_host,
	'db_user' => $db_user,
	'db_pass' => '*********',
	'db_name' => $db_name
);
echo json_encode($s);

// change step
$_SESSION['step'] = "2";
?>