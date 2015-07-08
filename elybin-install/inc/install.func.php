<?php
@session_start();
// need db
@include(many_trans()."elybin-core/elybin-config.php");

// Count how many directory transversal needed
// @author 	: Khakim A. <hamas182@gmail.com>
function many_trans($sring_result = true){
	// current dir
	$cd = @getcwd();
	$cd = str_replace("\\","/", $cd);
	// 				  0    1     2     3        4             5          6         7
	// $cd 			= D:/xampp/htdocs/rsch/percobaan10/elybin-install/include/ <you here>
	// $installbase = D:/xampp/htdocs/rsch/percobaan10/
	// $many_trans 	= -2
	// return 		= '../../' (-2)
	// return 		= 'elybin-install/include/' (2)

	// explode per dir
	$expcd = explode("/", $cd);

	// seek `elybin-install` dir
	$ei_dir = array_search("elybin-install", $expcd);
	// current dir
	$c_dir = $expcd[count($expcd)-1];
	// position c dir
	$p_c_dir = array_search($expcd[count($expcd)-1], $expcd);

	// if in current base
	if(is_int($ei_dir)){
		// install base
		$install_dir = $expcd[$ei_dir-1];
		// position install base
		$p_install_dir = array_search($expcd[$ei_dir-1], $expcd);
	}else{
		$install_dir = $expcd[count($expcd)-1];
		$p_install_dir = array_search($expcd[count($expcd)-1], $expcd);
	}
	// many transversal
	$many_trans = ($p_install_dir-$p_c_dir);
	// many transversal as string
	$many_trans_s = '';
	if($many_trans < 0){
		// negative values
		for($i=0; $i < $many_trans*-1; $i++){
			$many_trans_s .= '../';
		}
	}else{
		// positive values
		for($i=$p_install_dir; $i < $p_install_dir+$many_trans; $i++){
			$many_trans_s .= $expcd[$i].'/';
		}
	}

	// if result sring_result
	if($sring_result){
		return $many_trans_s;
	}else{
		return $many_trans;
	}
}

// function
// json function, to put clear data respone
function json(Array $a){
	echo json_encode($a);
	exit;
}

// 1.1.3
// mixing json and showing manual redirect if javascript fail to load
// r = redirect, j = json
function result(Array $a, $result = 'r', $exit = true){
	if($result == 'j'){
		json($a);
	}else{
		// set session first
		@$_SESSION['msg'] = $a['msg_ses'];
		// redirect loop bug
		if($a['red'] !== ''){
			header('location: '.@$a['red']);
		}
	}

	// exit sctipt
	if($exit){
		exit;
	}
}

// 1.1.3
// language function
function lg($s){
	// check current session
	if(!isset($_SESSION['lang'])){
		// set to default
		$lang = 'en-US';
	}else{
		// set to session
		$lang = @$_SESSION['lang'];
	}

	// check language exists
	$fl = many_trans()."elybin-install/lang/$lang.json";
	if(file_exists($fl)){
		// read
		$dict = @file_get_contents($fl);

		// find out
		$object_dict = json_decode($dict);
		$found = false;
		for($i=0; $i < count($object_dict->dictionary); $i++){
			$dt = $object_dict->dictionary;
			// get it
			if($dt[$i]->f == $s){
				// return
				$found = true;
				return $dt[$i]->t;
				exit;
			}
		}
		// if not found
		if(!$found){
			return $s;
		}
	}
}

// 1.1.3  - 7/7/2015
function chmod_dir(){
	// try to set directory permissions
	if(substr(sprintf('%o', fileperms(many_trans().'elybin-install')), -4) != '0777'){
		if(!chmod(many_trans().'elybin-install', 0777)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Set these directory to writeable (777): "elybin-install/", "elybin-core/", "elybin-file".'),
				'msg_ses' => 'failed_chmod',
				'red' => ''
			), @$_GET['r'], false);
		}
	}
	if(substr(sprintf('%o', fileperms(many_trans().'elybin-core')), -4) !='0777'){
		if(!chmod(many_trans().'elybin-core', 0777)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Set these directory to writeable (777): "elybin-install/", "elybin-core/", "elybin-file".'),
				'msg_ses' => 'failed_chmod',
				'red' => ''
			), @$_GET['r'], false);
		}
	}
	if(substr(sprintf('%o', fileperms(many_trans().'elybin-file')), -4) != '0777'){
		if(!chmod(many_trans().'elybin-file', 0777)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Set these directory to writeable (777): "elybin-install/", "elybin-core/", "elybin-file".'),
				'msg_ses' => 'failed_chmod',
				'red' => ''
			), @$_GET['r'], false);
		}
	}
}


// 1.1.3
// function import_sql(array("sql1.sql","sql2.sql"));
// error code 		: true => success
//					  false => fail
function import_sql(array $dir){
	$read_sql = '';
	// read form .sql file
	foreach($dir as $dr){
		$read_sql .= @file_get_contents($dr);
	}
	// trim
	$read_sql = rtrim($read_sql, " ;\r\n");
	$read_sql = rtrim($read_sql, " ;");
	// explode
	$arr_query = explode(";", $read_sql); // fixing mistake explode
	// try connect
	if(!connect_with_config()){
		return false;
	}
	// execute query per line
	$ok_query_c = 0;
	$ok_query[] = ''; //fixed (the corrent way to declare array is not $a = []; but $a[] = '')
	for($i=0; $i < count($arr_query); $i++){
		$ok_query[$i]['no'] = $i;
		if(mysql_query($arr_query[$i])){
			// ok
			$ok_query_c++;
			$ok_query[$i]['query'] = substr(trim(str_replace("\r\n","",str_replace("--\r\n-- Table structure for table ", "", str_replace("CREATE TABLE IF NOT EXISTS","", $arr_query[$i]))),"\r\n"),0,15).'...';
			$ok_query[$i]['status'] = 'ok';
		}else{
			// fail
			$ok_query[$i]['query'] = $arr_query[$i];
			$ok_query[$i]['status'] = 'fail';

			// write error logs
			$f = fopen(many_trans().'elybin-install/error_logs.txt', "a+");
			fwrite($f, '# '.date('Y-m-d H:i:s').'==>'.$arr_query[$i]."\r\n");
			fclose($f);
		}
	}
	// give query result
	if($ok_query_c < count($arr_query)){
		// query execution error
		return false;
	}else{
		return true;
	}
}

// function connect with config
// error code 		: 0 => configfile not found
function connect_with_config(){
	if(!include(many_trans().'elybin-core/elybin-config.php')){
		return false;
	}else{

		$con = mysql_connect(DB_HOST,DB_USER,DB_PASSWD) or die(mysql_error());

		if($con){
			if(mysql_select_db(DB_NAME,$con)){
				return true;
			}else{
				return false;
			}
		}

	}
}

// 1.1.3
// function install_status()
// return str(1) = step of installation
// --------------------------
// list of code		: 0 => (not installed)
// ------------------------------------- step 1
//					  1 => elybin-config.php set
// 					  2 => .htaccess ok
// 					  3 => sql imported (session_sql_ok = true)
// ------------------------------------- step 2
//					  4 => Account Created (uid_1)
// ------------------------------------- step 3
// 					  5 => Table option changed, install date added
// ------------------------------------- finish
//					  6 => installed
// 					  -1 => Locked temporary
function install_status(){
	// I don't know...
	$install_status = 0;
	// because installation only works in 24hours, check install date
	if($install_date = @file_get_contents(many_trans().'elybin-install/install_date.txt')){
		if(diff_date(date("Y-m-d H:i:s"), $install_date, 'hour') > 2){
			// status is locked = -1
			$install_status = -1;
		}else{
			// Checking step 1a (Database Connection Config)
			if(file_exists(many_trans().'elybin-core/elybin-config.php')){
				// set to 1
				$install_status = 1;
				// check .htaccess
				if(file_exists(many_trans().'.htaccess')){
						// set to 2
						$install_status = 2;
				}

				// try to connect to database
				@include(many_trans()."elybin-core/elybin-config.php");
				if(connect_with_config() == true){
					// this is, I'm tries to check `elybin_users` table
					$q = mysql_query("CHECK TABLE `elybin_users`");
					$f = mysql_fetch_array($q);

					// if `elybin_options` row not empty
					if($f['Msg_text'] == 'OK'){
						// step 1c successfully passed
						$install_status = 3;

						// Next, Checking step 2 (Administrator Account)
						// if user found in table `elybin_users`
						$q = mysql_query("SELECT * FROM `elybin_users` WHERE `user_id` = 1 LIMIT 0,1");
						$c = mysql_num_rows($q);
						if($c > 0){
							// step 2 successfully passed
							$install_status = 4;

							// chck option
							$qq = mysql_query("SELECT * FROM `elybin_options` WHERE `name` = 'installdate' && `value` != '0000-00-00 00:00:00' LIMIT 0,1");
							$cc = mysql_num_rows($qq);
							if($cc > 0){
								// step 2 successfully passed
								$install_status = 5;

								// chck option
							}
						}
					}
				}
			}
		}
	}
	return $install_status;
}



function deleteDir($dirname) {
	// Sanity check
    if (!file_exists($dirname)) {
        return false;
    }
    // Simple delete for a file
    if (is_file($dirname) || is_link($dirname)) {
        return unlink($dirname);
    }
    // Create and iterate stack
    $stack = array($dirname);
    while ($entry = array_pop($stack)) {
        // Watch for symlinks
        if (is_link($entry)) {
            unlink($entry);
            continue;
        }
        // Attempt to remove the directory
        if (@rmdir($entry)) {
            continue;
        }
        // Otherwise add it to the stack
        $stack[] = $entry;
        $dh = opendir($entry);
        while (false !== $child = readdir($dh)) {
            // Ignore pointers
            if ($child === '.' || $child === '..') {
                continue;
            }
            // Unlink files and add directories to stack
            $child = $entry . DIRECTORY_SEPARATOR . $child;
            if (is_dir($child) && !is_link($child)) {
                $stack[] = $child;
            } else {
                unlink($child);
            }
        }
        closedir($dh);
        //print_r($stack);
    }
    return true;
}


#---------------------------------------
#- step 1 ------------------------------
#---------------------------------------

// funtion try connect manual
// error code 		: 0 => database not found
//					  1 => connection error
// 					  2 => success
function try_connect_manual($db_host, $db_user, $db_pass, $db_name){
	// try connect
	$con = @mysql_connect($db_host,$db_user,$db_pass);
	if($con){
		if(mysql_select_db($db_name,$con) == false){
			$status = 0;
			@$_SESSION['db_ok'] = false;
		}else{
			$status = 2;
			// connection success, set session
			@$_SESSION['db_ok'] = true;
			@$_SESSION['h'] = $h;
			@$_SESSION['u'] = $u;
			@$_SESSION['p'] = $p;
			@$_SESSION['n'] = $n;
		}
	}else{
		// cannot connect to database host
		$status = 1;
		@$_SESSION['db_ok'] = false;
	}

	return $status;
}


// function write_config
// error code 		: 0 => failed to write, access denied
// erro
function write_config($db_host, $db_user, $db_pass, $db_name){
	// check existace
	if(file_exists(many_trans()."elybin-core/elybin-config.php")){
		$r = true;
	}else{
		// get cwd (Current Working Directory)
		$local_dir = @getcwd();
		$local_dir = str_replace("\\elybin-install\inc","",$local_dir);
		$local_dir = str_replace("/elybin-install/inc","",$local_dir);
		$local_dir = str_replace("\\","/", $local_dir);

		// write to file (elybin-config.php)
		//SITE CONFIG
		$config_dir = many_trans().'elybin-core/elybin-config.php';
		$config_template =
		'<?php
	# `elybin-config.php`
	# If you see this error, copy paste script below and manually create this file.
	# Directory: your_root_website/elybin-core/elybin-config.php
	# After that, refresh this page

	// SESSION START
	@session_start();

	// SITE CONFIG
	$DIR_ROOT						= "'.$local_dir.'/";
	$DIR_ADMIN						= "{$DIR_ROOT}elybin-admin/";
	$DIR_CORE						= "{$DIR_ROOT}elybin-core/";

	$DB_HOST						= "'.$db_host.'";
	$DB_USER						= "'.$db_user.'";
	$DB_PASSWD						= "'.$db_pass.'";
	$DB_NAME						= "'.$db_name.'";

	@define("DB_HOST", $DB_HOST);
	@define("DB_USER", $DB_USER);
	@define("DB_PASSWD", $DB_PASSWD);
	@define("DB_NAME", $DB_NAME);

	@define("DIR_ROOT", $DIR_ROOT);
	@define("DIR_ADMIN", $DIR_ADMIN);
	?>';
		// write to file
		$f = fopen($config_dir, "w");
		if(fwrite($f, $config_template) == false){
			// fixing directory unwriteable (fixed)
			$r = false;
			$_SESSION['config_template'] = $config_template;
		}else{
			$r = true;
		}
		fclose($f);
	}

	return $r;
}

// function write_htaccess
// error code 		: 0 => failed
// 					  1 => success
function write_htaccess(){
	// Create htaccess (force write not copy to avoid some error in linux server)
	$htaccess_dir = many_trans().'.htaccess';

	// read `htaccess_template.txt`
	$htaccess_template = @file_get_contents(many_trans()."elybin-install/inc/htaccess_template.txt");

	// check existace
	if(file_exists(many_trans().'.htaccess')){
		$r = true;
	}else{
		// (try 1) write to file
		$f = fopen($htaccess_dir, "w");
		if(fwrite($f, $htaccess_template) == true){
			$r = true;
		}else{
			// (try 2) copy method
			if(@copy(many_trans()."elybin-install/inc/htaccess_template.txt", $htaccess_dir) == true){
				$r = true;
			}else{
				// write to session
				@$_SESSION['htaccess_template'] = $htaccess_template;
				// result
				$r = false;
			}
		}
		fclose($f);
	}

	return $r;
}

// function copy_version()
// error code 		: 0 => failed
// 					  1 => success
function copy_version(){
	$elybin_version = many_trans().'elybin-core/elybin-version.php';

	//remove
	@deleteDir(many_trans().'elybin-core/elybin-version.php');

	// copy
	if(@copy(many_trans()."elybin-install/inc/elybin-version.php", $elybin_version) == false){
		return false;
	}else{
		return true;
	}
	fclose($f);
}

// create install lock
function install_lock(){
	// set session
	$_SESSION['ininstall'] = true;

	// write installation date
	if(!file_exists(many_trans().'elybin-install/install_date.txt')){
		$f = fopen(many_trans().'elybin-install/install_date.txt', "w");
		if(fwrite($f, date("Y-m-d H:i:s")) == false){
			$r = false;
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Failed writing &#34;elybin-install/install_date.txt&#34;. Fix your directory permissions, and try again.'),
				'msg_ses' => 'failed_locksys',
				'red' => ''
			), @$_GET['r'], false);
		}else{
			$r = true;
		}
		fclose($f);
	}
	return $r;
}

// comparing date
// diff_date($future, $past, $res = second/minute/hour/day);
function diff_date($date1, $date2, $result = 'day'){
	$diff = strtotime($date1)-strtotime($date2);

	// dicision
	switch ($result) {
		case 'second':
			$diff = $diff;
			break;
		case 'minute':
			$diff = $diff/60;
			break;
		case 'hour':
			$diff = $diff/60/60;
			break;
		case 'day':
			$diff = $diff/60/60/24;
			break;
		default:
			$diff = $diff/60/60/24;
			break;
	}

	return $diff;
}

function remove_installer(){
	// self del
	@deleteDir(many_trans().'elybin-install/');
	@deleteDir(many_trans().'.git');
	@deleteDir(many_trans().'README.txt');
	@deleteDir(many_trans().'README.md');
	@deleteDir(many_trans().'README.rdoc');
	@deleteDir(many_trans().'LICENSE.txt');
	@deleteDir(many_trans().'LICENSE');
}

function change_language($lang = 'en-US'){
	// set session
	$_SESSION['lang'] = $lang;
	// redirect
	header('location: '.many_trans().'elybin-install/index.php');
	exit;
}
?>
