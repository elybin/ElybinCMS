<?php
/**
 * Installer main function, contain many important function.
 *
 * @package   Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @author		Khakim A <kim@elybin.com>
 * @since 		Elybin 1.1.3
 */
@session_start();
require("upgrade.func.php");

function lets_start_the_setup(){
	/**
	 * Starting setup
	 * @since 1.1.4
	 */

  // before anything, check the state on install or upgrade
	install_or_upgrade();

	// need db
	@include(many_trans()."elybin-core/elybin-config.php");

 	/**  Call install lock */
 	install_lock();

 	/**  Call change language */
 	change_language();

	/** W.I.W.S */
	where_i_was_supposed();

	/** Installer section */
	if(whats_opened('install.default') && !check_upgrade_possible()){
			/**  Include controller */
			controller('install.default');
			/**  Include view */
			view('install.default');
	}
	else if(whats_opened('install.step1')){
			/**  Include controller */
			controller('install.step1');
			/**  Include view */
			view('install.step1');
	}
	else if(whats_opened('install.step2')){
			/**  Include controller */
			controller('install.step2');
			/**  Include view */
			view('install.step2');
	}
	else if(whats_opened('install.step3')){
			/**  Include controller */
			controller('install.step3');
			/**  Include view */
			view('install.step3');
	}
	else if(whats_opened('install.finish')){
			/**  Include controller */
			controller('install.finish');
			/**  Include view */
			view('install.finish');
	}
	else if(whats_opened('install.locked')){
			/**  Include controller */
			controller('install.locked');
			/**  Include view */
			view('install.locked');
	}
	/** Misc section */
	else if(whats_opened('go.home')){
			/**  Include controller */
			controller('go.home');
	}
	else if(whats_opened('go.login')){
			/**  Include controller */
			controller('go.login');
	}
	else if(whats_opened('change.language')){
			/**  Call Function */
			change_language();
	}

	/** Upgrade */
	else if(whats_opened('upgrade.default') && check_upgrade_possible()){
		/**  Include controller */
		controller('upgrade.default');
		/**  Include view */
		view('upgrade.default');
	}
	else if(whats_opened('upgrade.step1')){
	  /**  Include controller */
	  controller('upgrade.step1');
		/**  Include view */
		view('upgrade.step1');
	}
	else if(whats_opened('upgrade.step2')){
		/**  Include controller */
		controller('upgrade.step2');
		/**  Include view */
		view('upgrade.step2');
	}
	else if(whats_opened('upgrade.step3')){
		/**  Include controller */
		controller('upgrade.step3');
		/**  Include view */
		view('upgrade.step3');
	}
	else if(whats_opened('upgrade.finish')){
		/**  Include controller */
		controller('upgrade.finish');
		/**  Include view */
		view('upgrade.finish');
	}
	else if(whats_opened('upgrade.na')){
		/**  Include controller */
		controller('upgrade.na');
		/**  Include view */
		view('upgrade.na');
	}
	else if(whats_opened('upgrade.needroot')){
		/**  Include controller */
		controller('upgrade.needroot');
		/**  Include view */
		view('upgrade.needroot');
	}
}

function where_i_was_supposed($param = null){
	/**
	 * Where I was supposed, redirect to right page.
	 * @param = 'debug', to run debug mode.
	 * @since 1.1.4
	 */
	// debug
	$debug = false;

	/** Install */
	if(is_install() && install_status() == 0 && !whats_opened('install.default')){
 		$redirect = get_url('install.default');
 	}
	else if(is_install() && (install_status() == 1 || install_status() == 2) && !whats_opened('install.step1')){
 		$redirect = get_url('install.step1');
 	}
 	else if(is_install() && install_status() == 3 && !whats_opened('install.step2')){
 		$redirect = get_url('install.step2');
 	}
 	else if(is_install() && install_status() == 4 && !whats_opened('install.step3')){
 		$redirect = get_url('install.step3');
 	}
 	else if(is_install() && install_status() == 5 && !whats_opened('install.finish')){
 		$redirect = get_url('install.finish');
 	}
 	else if(is_install() && install_status() == -1 && !whats_opened('install.locked')){
 		$redirect = get_url('install.locked');
 	}
	/** Upgrade Section */
 	else if(is_upgrade() && upgrade_status() == 20 && !whats_opened('upgrade.default')){
 		$redirect = get_url('upgrade.default');
 	}
 	else if(is_upgrade() && upgrade_status() == 21 && !whats_opened('upgrade.step1')){
 		$redirect = get_url('upgrade.step1');
 	}
 	else if(is_upgrade() && upgrade_status() == 22 && !whats_opened('upgrade.step2')){
 		$redirect = get_url('upgrade.step2');
 	}
 	else if(is_upgrade() && upgrade_status() == 23 && !whats_opened('upgrade.step3')){
 		$redirect = get_url('upgrade.step3');
	}
 	else if(is_upgrade() && upgrade_status() == 24 && !whats_opened('upgrade.finish')){
 		$redirect = get_url('upgrade.finish');
 	}
 	else if(is_upgrade() && upgrade_status() == -2 && !whats_opened('upgrade.na')){
 		$redirect = get_url('upgrade.na');
 	}
	else if(is_upgrade() && upgrade_status() == -3 && !whats_opened('upgrade.needroot')){
		$redirect = get_url('upgrade.needroot');
	}
 	else if(is_upgrade() && upgrade_status() == -1){
 		$redirect = get_url('go.login_and_back');
 	}
	// else{
	// 	// if is_install()
	// 	if(is_install()){
	// 		$redirect = get_url('install.default');
	// 	}else{
	// 		$redirect = get_url('upgrade.default');
	// 	}
	//  }

	// return
	if($debug || $param == 'debug'){
		var_dump(sprintf(__('Redirect URL: %s, What\'s Opened: %s, Install Status: %s, Upgrade Status: %s, is_install(): %s, is_upgrade(): %s'), @$redirect, whats_opened(), install_status(), upgrade_status(), is_install(), is_upgrade() ) );
		exit;
	}
	else if(isset($redirect)){
		redirect($redirect);
	}
}

function install_status(){
	/**
	 * @since 1.1.3
	 * function install_status()
	 * return str(1) = step of installation
	 * --------------------------
	 * list of code		: 0 => (not installed)
	 * ------------------------------------- step 1
	 *					  1 => elybin-config.php set
	 * 					  2 => .htaccess ok
	 * 					  3 => sql imported (session_sql_ok = true)
	 * ------------------------------------- step 2
	 *					  4 => Account Created (uid_1)
	 * ------------------------------------- step 3
	 * 					  5 => Table option changed, install date added
	 * ------------------------------------- finish
	 *					  6 => installed
	 * 					 -1 => Locked temporary
	 * ------------
	 * @since 1.1.4
	 * --------------------------
	 * list of code		: 0 => (not installed)
	 * ------------------------------------- step 1
	 *					  1 => s(ok_install) = true
	 * 						2 => elybin-config.php set
	 * 					  3 => sql imported (session_sql_ok = true)
	 * ------------------------------------- step 2
	 *					  4 => Account Created (uid_1)
	 * ------------------------------------- step 3
	 * 					  5 => Table option changed, install date added
	 * ------------------------------------- finish
	 *					  6 => installed
	 * 					 -1 => Locked temporary
	 *
	 *===================================================
	 *==== @since 1.1.4, change it again.
	 * 0 => (not installed)
	 * ---
	 * 1 => s(ok_install) : trye ==>  step 1 (setting database)
	 * 2 => elybin-config.php set ==>  step 1 (setting database)
	 * ---
	 * 3 => sql imported (session_sql_ok = true) ==>  step 2 (creating account)
	 * ---
	 * 4 => Account Created (uid_1)	==> step 3 (setting up website info)
	 * ---
	 * 5 => Table option changed, install date added ==> finish
	 * ---
	 * -1 => locked
	 */

	// debug
	$debug = false;

	// I don't know...
	$install_status = 0;
	// because installation only works in couple hours, check install date
	if($install_date = @file_get_contents(many_trans().'elybin-install/install_date.txt')){
		if(diff_date(date("Y-m-d H:i:s"), $install_date, 'hour') > 2){
			// status is locked = -1
			$install_status = -1;
			// give error space dude!
			$error_msg = __('Installer locked.');
		}else{
			// checking s(ok_install)
			if(@$_SESSION['ok_install'] == true){
				// set to 1
				$install_status = 1;
				// Checking step 1a (Database Connection Config)
				if(file_exists(many_trans().'elybin-core/elybin-config.php')){
					// set to 2
					$install_status = 2;
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
								}else{
									// give error space dude!
									$error_msg = __('Cannot found "installdate" = "0000-00-00" inside database.');
								}
							}else{
								// give error space dude!
								$error_msg = __('Admin user not found on database.');
							}
						}else{
							// give error space dude!
							$error_msg = __('Database empty.');
						}
					}else{
						// give error space dude!
						$error_msg = __('Failed connect with config.');
					}
				}else{
					// give error space dude!
					$error_msg = __('Config file not set.');
				}
			}else{
				// give error space dude!
				$error_msg = __('"ok_install" session not set.');
			}
		}
	}else{
		// give error space dude!
		$error_msg = __('Failed to writing install lock.');
	}

	// return
	if($debug){
		// debug result
		var_dump(@$error_msg." ".sprintf(__('Install status: %s'), @$install_status));
		exit;
	}else{
		return $install_status;
	}
}

function whats_opened($sec = ''){
	/**
	 * Informing whats currently opended.
	 * @since 1.1.4
	 */

	/** Installer section */
	if(isset($_GET['p']) && $_GET['p'] == 'install.step1'){
		$o = 'install.step1';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'install.step2'){
		$o = 'install.step2';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'install.step3'){
		$o = 'install.step3';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'install.finish'){
		$o = 'install.finish';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'install.locked'){
		$o = 'install.locked';
	}

	/** Upgrader */
	else if(isset($_GET['p']) && $_GET['p'] == 'upgrade.step1'){
		$o = 'upgrade.step1';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'upgrade.step2'){
		$o = 'upgrade.step2';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'upgrade.step3'){
		$o = 'upgrade.step3';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'upgrade.finish'){
		$o = 'upgrade.finish';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'upgrade.na'){
		$o = 'upgrade.na';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'upgrade.needroot'){
		$o = 'upgrade.needroot';
	}

	/** Miscellaneous */
	else if(isset($_GET['p']) && $_GET['p'] == 'go.home'){
		$o = 'go.home';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'go.login'){
		$o = 'go.login';
	}
	else if(isset($_GET['p']) && $_GET['p'] == 'change.language'){
		$o = 'change.language';
	}else{
		// split
		if(upgrade_status() == 20){
			$o = 'upgrade.default';
		}else{
			$o = 'install.default';
		}
	}

	// if $section set
  if(empty($sec)){
    return $o;
  }else{
    if($o == $sec){
      return true;
    }else{
      return false;
    }
  }
}

function get_url($section = '', $id = 0){
	/**
	 * Getting specifict url.
	 * @since 1.1.4
	 */
	// get current url
	$current_url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	// root url
	$strpos = strpos($current_url, "elybin-install/");
	$home_url = substr($current_url, 0, $strpos);
	// get only elybin-install url
	$strpos = strpos($current_url, "elybin-install/");
	$installer_url = substr($current_url, 0, $strpos+15);

	switch($section){
		/** Install section*/
		case 'install.step1':
			$url = "{$installer_url}index.php?p=install.step1";
			break;
		case 'install.step2':
			$url = "{$installer_url}index.php?p=install.step2";
			break;
		case 'install.step3':
			$url = "{$installer_url}index.php?p=install.step3";
			break;
		case 'install.finish':
			$url = "{$installer_url}index.php?p=install.finish";
			break;
		case 'install.locked':
			$url = "{$installer_url}index.php?p=install.locked";
			break;
		case 'install.default':
			$url = "{$installer_url}index.php";
			break;
		/** Upgrade section */
		case 'upgrade.step1':
			$url = "{$installer_url}index.php?p=upgrade.step1";
			break;
		case 'upgrade.step2':
			$url = "{$installer_url}index.php?p=upgrade.step2";
			break;
		case 'upgrade.step3':
			$url = "{$installer_url}index.php?p=upgrade.step3";
			break;
		case 'upgrade.finish':
			$url = "{$installer_url}index.php?p=upgrade.finish";
			break;
		case 'upgrade.na':
			$url = "{$installer_url}index.php?p=upgrade.na";
			break;
		case 'upgrade.needroot':
			$url = "{$installer_url}index.php?p=upgrade.needroot";
			break;
		case 'upgrade.default':
			$url = "{$installer_url}index.php";
			break;
		/** Misc */
		case 'go.home':
			$url = "{$installer_url}index.php?p=go.home";
			break;
		case 'go.login':
			$url = "{$installer_url}index.php?p=go.login";
			break;
		case 'go.login_and_back':
			$url = "{$home_url}elybin-admin/index.php?p=login&callback=".urlencode($installer_url.'index.php');
			break;
		case 'home':
			$url = "{$home_url}index.php";
			break;
		case 'login':
			$url = "{$home_url}elybin-admin/index.php";
			break;
		case 'change.language':
			if(is_numeric($id) || empty($id)){
				$url = "{$installer_url}index.php?p=change.language";
			}else{
				$url = "{$installer_url}index.php?p=change.language&lang={$id}";
			}
			break;
		case 'home_url':
			$url = "{$home_url}";
			break;
		case 'installer_url':
			$url = "{$installer_url}";
			break;
		default:
			$url = "{$installer_url}index.php";
			break;
	}
	return $url;
}

function controller($cont_identifer){
	/**
	 * Include controller
	 * @since 1.1.4
	 */
	global $msg;

	if(file_exists(many_trans()."elybin-install/inc/controller/$cont_identifer.php")){
		include(many_trans()."elybin-install/inc/controller/$cont_identifer.php");
	}else{
		printf(__('"%s" is not a valid controller identity.'), $cont_identifer);
	}
}

function view($view_identifer){
	/**
	 * Include view
	 * @since 1.1.4
	 */
	global $msg;

	if(file_exists(many_trans()."elybin-install/inc/view/$view_identifer.php")){
		include(many_trans()."elybin-install/inc/view/$view_identifer.php");
	}else{
		printf(__('"%s" is not a valid view identity.'), $view_identifer);
	}
}

function process($view_identifer){
	/**
	 * Get process url.
	 * @since 1.1.4
	 */
	if(file_exists(many_trans()."elybin-install/inc/process/$view_identifer.php")){
		return get_url('installer_url')."inc/process/$view_identifer.php";
	}else{
		return sprintf(__('"%s" is not a valid process identity.'), $view_identifer);
	}
}

function import_sql(array $dir){
	/**
	 * Function import_sql(array("sql1.sql","sql2.sql"));
	 *
	 * error code 		: true => success
	 *								  false => fail
	 * @since 1.1.3
	 */
	$read_sql = '';
	// read form .sql file
	foreach($dir as $dr){
		$read_sql .= @file_get_contents($dr);
	}
	// trim
	$read_sql = rtrim($read_sql, " ;\r\n");
	$read_sql = rtrim($read_sql, " ;");
	// explode
	$arr_query = explode(";\n", $read_sql); // fixing mistake explode, oops something goes wrong again
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

function connect_with_config(){
	/**
	 * Function connect with exiting config
	 * error code 		: 0 => configfile not found
	 * @since 1.1.3
	 */
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

function try_connect_manual($db_host, $db_user, $db_pass, $db_name){
	/**
	 * Function to try manually connect to database.
	 * error code 		: 0 => database not found
	 *					  		  1 => connection error
	 * 					        2 => success
	 * @since 1.1.3
	 */

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
	// return
	return $status;
}

function write_config($db_host, $db_user, $db_pass, $db_name){
	/**
	 * Writing configuration file.
	 * error code 		: 0 => failed to write, access denied
	 * @since 	1.1.3
	 */
	// check existace
	if(file_exists(many_trans()."elybin-core/elybin-config.php")){
		$r = true;
	}else{
		// get cwd (Current Working Directory)
		$local_dir = @getcwd();
		$local_dir = str_replace("\\elybin-install\inc\process","",$local_dir);
		$local_dir = str_replace("/elybin-install/inc/process","",$local_dir);
		$local_dir = str_replace("\\","/", $local_dir);

		// write to file (elybin-config.php)
		//SITE CONFIG
		$config_dir = many_trans().'elybin-core/elybin-config.php';
		$config_template =
'<?php
/**
 * `elybin-config.php`
 * If you see this error message, copy paste script below and manually create php file.
 * Directory: your_root_website/elybin-core/elybin-config.php
 * After that, refresh this page
 *
 * @package   Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @author		Khakim A <kim@elybin.com>
 * @since 		Elybin 1.0.0
 */

// SESSION START
@session_start();

// SITE CONFIG
$DIR_ROOT						= "'.$local_dir.'/";
$DIR_ADMIN					= "{$DIR_ROOT}elybin-admin/";
$DIR_CORE						= "{$DIR_ROOT}elybin-core/";

$DB_HOST						= "'.$db_host.'";
$DB_USER						= "'.$db_user.'";
$DB_PASSWD					= "'.$db_pass.'";
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
	// return
	return $r;
}

function install_lock(){
	/**
	 * Installer automaticly locked after 2 hours to prevent unauthorized user steal your web.
	 * to unlock the installer, try to delete "install_date.txt" inside "elybin-install", and try again.
	 * @since 1.1.3
	 */
	// set session
	$_SESSION['ininstall'] = true;
	// set to false
	$r = false;
	// write installation date
	if(!file_exists(many_trans().'elybin-install/install_date.txt')){
		$f = @fopen(many_trans().'elybin-install/install_date.txt', "w");
		if(@fwrite($f, date("Y-m-d H:i:s")) == false){
			$r = false;
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Set your directory to writeable, and try again.'),
				'msg_ses' => 'failed_locksys',
				'red' => ''
			), @$_GET['r'], false);
		}else{
			$r = true;
			result(array(
				'status' => 'ok',
				'title' => lg('Success'),
				'msg' => lg('Directory now writeable.'),
				'msg_ses' => 'locksys_ok',
				'red' => ''
			), @$_GET['r'], false);
		}
		@fclose($f);
	}
	return $r;
}

function diff_date($date1, $date2, $result = 'day'){
	/**
	 * Comparing two date and get the difference.
	 * @param diff_date($future, $past, $res = second/minute/hour/day);
	 * @since 1.1.3
	 */
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

function lg($s){
	/**
	 * Language function
	 * @since 1.1.3
	 */

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

function change_language(){
	/**
	 * Changing language function.
	 * @since 1.1.3
	 */
	// if get set
	if(isset($_GET['lang'])){
		$lang = $_GET['lang'];

		// set session
		$_SESSION['lang'] = $lang;
		// redirect

		if(!whats_opened('install.default')){
			redirect(get_url('install.default'));
		}
	}
}

function json(Array $a){
	/**
	 * Json function, to put clear data respone
	 * @since 1.1.1
	 */
	echo json_encode($a);
	exit;
}

function result(Array $a, $result = 'r', $exit = true){
	/**
	 * Mixing json and showing manual redirect if javascript fail to load
	 * r = redirect, j = json
	 * @since 1.1.3
	 */

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

	// exit script
	if($exit){
		exit;
	}
}

function many_trans($sring_result = true){
	/**
	 * Count how many directory transversal needed
	 * @since 1.1.3
	 */
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

function e($s = ''){
	/**
	 * Alternate method of echo
	 * @since 1.1.4
	 */
	echo $s;
}

function __($s, $d = 'default'){
	/**
	 * Display translated string. (alternate of lg())
	 * @since Elybin 1.1.4
	 */
	 return lg($s);
}

function _e($s = ''){
	/**
	 * Alternate method of lg with echo result
	 * @since 1.1.4
	 */
	e(__($s));
}

function s($name = ''){
	/**
	 * Alternative if $_SESSION
	 * @since 1.1.4
	 */

	if(isset($_SESSION[$name])){
		return $_SESSION[$name];
	}else{
		//return sprintf(__('Session %s not set.'), $name);
		return false;
	}
}

function redirect($str){
	/**
   * Simple redirect function.
   * @since 1.1.4
   */
	header('location: ' . $str );
}

function error_message( $string = '' ){
	/**
	 * showing error message.
	 * @since 1.1.4
	 */
	global $msg;
	if(isset($_SESSION['msg'])){
		$msg = @$_SESSION['msg'];
		// return
		if(!empty($string) && $string == $msg){
			return true;
		}
		else if(!empty($string) && $string !== $msg){
			return false;
		}
		else{
			return $msg;
		}
	}
}

function is_install(){
	/**
	 * check is install state
	 * @since 1.1.4
	 */

	// call install_or_upgrade()
  if(install_or_upgrade() == 'install'){
		return true;
	}else{
		return false;
	}
}

function is_upgrade(){
	/**
	 * check is upgrade state
	 * @since 1.1.4
	 */

	 // call install_or_upgrade()
   if(install_or_upgrade() == 'upgrade'){
 		return true;
 	}else{
 		return false;
 	}
}

function install_or_upgrade(){
	/**
	 * Checking the state for first time.
	 * @since 1.1.4
	 */

  // debug first, always
	$debug = false;

	// check cookie not set
	if(empty($_COOKIE['state'])){
		// checking configuration file, exist or not
		if(file_exists(many_trans().'elybin-core/elybin-config.php')){
			// set state cookie to "upgrade", and 40 days expired
			setcookie('state', 'upgrade', time()+3456000);
			$state = 'upgrade';
		}else{
			// set state cookie to "install", and 40 days expired
			setcookie('state', 'install', time()+3456000);
			$state = 'install';
		}
		// I forget this line, make me headache for a week
		$cookie_based = false;
	}else{
		// if set, just get the cookie value
		$state = $_COOKIE['state'];
		$cookie_based = true;
	}
	// return
	if($debug){
		// return if debug
		// cookie bassed
		$cookie_based = ($cookie_based ? 'true': 'false');
		var_dump(sprintf(__('Current state: %s, Cookie bassed: %s'), $state, @$cookie_based));exit;
	}else{
		// return as normal
		return $state;
	}
}

///////////////////////////////
/// 				R.I.P						///
///////////////////////////////

function chmod_dir(){
	/**
	 * And since 1.1.4, it deactived
   * @since 1.1.3
	 */
	/*
	// try to set directory permissions
	if(substr(sprintf('%o', fileperms(many_trans().'elybin-install')), -4) != '0755'){
		if(!@chmod(many_trans().'elybin-install', 0755)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Set these directory to writeable (755): "elybin-install/", "elybin-core/", "elybin-file".'),
				'msg_ses' => 'failed_chmod',
				'red' => ''
			), @$_GET['r'], false);
		}
	}
	if(substr(sprintf('%o', fileperms(many_trans().'elybin-core')), -4) !='0755'){
		if(!@chmod(many_trans().'elybin-core', 0755)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Set these directory to writeable (755): "elybin-install/", "elybin-core/", "elybin-file".'),
				'msg_ses' => 'failed_chmod',
				'red' => ''
			), @$_GET['r'], false);
		}
	}
	if(substr(sprintf('%o', fileperms(many_trans().'elybin-file')), -4) != '0755'){
		if(!@chmod(many_trans().'elybin-file', 0755)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Set these directory to writeable (755): "elybin-install/", "elybin-core/", "elybin-file".'),
				'msg_ses' => 'failed_chmod',
				'red' => ''
			), @$_GET['r'], false);
		}
	}
	*/
}

function write_htaccess(){
	/**
	 * Writing htaccess, but it's turned off since 1.1.4
	 *  error code 		: 0 => failed
	 * 					  			1 => success
	 * @since 1.1.3
	 */

	// Create htaccess (force write not copy to avoid some error in linux server)
	$htaccess_dir = many_trans().'.htaccess';

	// read `htaccess_template.txt`
	$htaccess_template = @file_get_contents(many_trans()."elybin-install/inc/htaccess_template.txt");

	// check existace
	if(file_exists(many_trans().'.htaccess')){
		$r = true;
	}else{
		// (try 1) write to file
		$f = @fopen($htaccess_dir, "w");
		if(@fwrite($f, $htaccess_template) == true){
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
		@fclose($f);
	}

	return $r;
}

function copy_version(){
	/**
	 * Copy version file, it's also turned off since 1.1.4
	 * error code 		: 0 => failed
	 * 					  		  1 => success
	 * @since 1.1.3
	 */
	$new_verfile = many_trans().'elybin-core/elybin-version.php';
	// copy
	if(!copy(many_trans()."elybin-install/inc/elybin-version.php", $new_verfile)){
		$r = false;
	}else{
		$r = true;
	}
	// return
	return $r;
}

function remove_installer(){
	/**
	 * Remove installer and readme file, be careful it can be so dangerous.
	 * @since 1.1.3
	 */
	// self del
	/*
	@deleteDir(many_trans().'elybin-install/');
	@deleteDir(many_trans().'.git');
	@deleteDir(many_trans().'README.txt');
	@deleteDir(many_trans().'README.md');
	@deleteDir(many_trans().'README.rdoc');
	@deleteDir(many_trans().'LICENSE.txt');
	@deleteDir(many_trans().'LICENSE');
	*/
}

function deleteDir($dirname) {
	/**
	 * Deleting Directory, it's dangerous.
	 * @since 1.1.1
	 */
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
