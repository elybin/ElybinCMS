<?php
/**
 * Upgrade main function, contain many important function.
 *
 * @package   Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @author		Khakim <elybin.inc@gmail.com>
 * @since 		Elybin 1.1.3
 */
@session_start();

function upgrade_status($param = null){
	/**
	 * Check the upgrade status
	 * --------------------------
	 * list of code		:	 0 => (idle)
	 *									------------------------------
	 *									20 => Begining - Logged in
	 *									21 => Step 1	 - "Install Lock" created & checking s('ok_upgrade')
	 *									22 => Step 2	 - Upgrade confirmed
	 *									23 => Step 3 	 - Database upgraded & by seeing db version
	 *									24 => Finish 	 - Optimizing success by checking s('optimizing_ok')
	 *									------------------------------
	 *									 -1 => Not Logged in (redirect to login)
	 *									 -2 => Update not available
	 *									 -3 => Not Root
	 *
	 * @since 1.1.4
	 */

	// debug
	$debug = false;

	// set origin status
	$upgrade_status = 0;

	// checking upgrade possible first
	if(check_upgrade_possible()){
		// not logged in
		$upgrade_status = -1;
		// check login
		if(is_login(true)){
			// set = 20
			$upgrade_status = 20;
			// check install lock
			if(file_exists(many_trans().'elybin-install/install_date.txt')){
				// file exist, we don't need to check them, because upgrade already login
				$upgrade_status = 21;
				// check ok_upgrade session
				if(@$_SESSION['ok_upgrade']){
					// set = 22
					$upgrade_status = 22;
					// check database version, if upgraded goto next step
					if(get_upgrade_info('database_version', 'refresh') == get_upgrade_info('installer_version','refresh')){
						// set = 23
						$upgrade_status = 23;
						// because optimizing is dynamic and in the future we dont know whats should add or deleted, so for today just check the session
						if(@$_SESSION['optimizing_ok']){
							// set = 24
							$upgrade_status = 24;
							// that's it, it's done!
						}else{
							// give error space dude!
							$error_msg = __('Optimizing session not set.');
						}
					}else{
						// give error space dude!
						$error_msg = __('Database version still lowet than Installer version.');
					}
				}else{
					// give error space dude!
					$error_msg = __('Please read carefully the "Readme" files and, push the "Continue" button.');
				}
			}else{
				// give error space dude!
				$error_msg = __('Install Lock not found, maybe there\'s a problem with your directory permissions, fix your directory permissions and try again.');
			}
		}else{
			// need root
			$upgrade_status = -3;

			// give error space dude!
			$error_msg = __('Upgrade need root permissions, please login as root user first.');
		}
	}else{
		// if root
		if(is_login(true)){
			// upgrade possible
			$upgrade_status = -2;

			// give error space dude!
			$error_msg = sprintf(__('Your system version ("%s"), not upgradeable. Please delete all data, and install it from begining.'), get_upgrade_info('database_version'));
		}else{
			// need root
			$upgrade_status = -3;

			// give error space dude!
			$error_msg = __('Upgrade need root permissions, please login as root user first.');
		}
	}

	// result
	if($debug || $param == 'debug'){
		var_dump(sprintf(__('Upgrade Status: %s, Error: %s'), $upgrade_status, @$error_msg));
	}else{
		return $upgrade_status;
	}
}

function check_upgrade_possible($param = null, $mode = null){
	/**
	 * Are new upgrade found?
	 * And if available, save in cookie
	 * @param $mode = 'refresh' to get fresh version, not from cache, but still not changing the cache
	 * @param $mode = 'reset' to get fresh version, not from cache, but changing the cache
	 * @param $param = 'debug' debug mode on
	 * @since 1.1.4
	 */

	// what's made upgrade possibele?
	// 1. Connection already exist
	// 2. Datasbas exist
	// 3. User already exist
	// 4. Version on database lower than elybin-version.php
	// 5. The old version available to upgrade bassed on version_list.php

	// 6. Install Lock Maybe Not Exist (Maybe)


	// Let's start
	$debug = false;
	$upgrade_possible = false;
	$error_msg = null;

	/**
	 * because we found a bug, when this function checking upgrade
	 * for the second time, we fix it with saving upgrade possibility in cookie
	 * so, we just get the cookie value, and not checking many stuff again.
	 */
	// check cookie first
	if(empty($_COOKIE['upgrade_possible']) || $mode == 'reset' || $mode == 'refresh'){
		// refresh not affecting the cookie
		if($mode !== 'refresh'){
			// set to false first
			setcookie('upgrade_possible', false, time()+3456000);
		}
		// check `elybin-config.php`
		if(file_exists(many_trans().'elybin-core/elybin-config.php')){
			// try to connect with config
			if(connect_with_config()){
				// get database version
				$q = mysql_query("SELECT * FROM `elybin_options` WHERE `name` = 'database_version'");
				$c = mysql_num_rows($q);
				// if found, get it
				if($c > 0){
					// get database version
					$database_version = mysql_fetch_array($q)['value'];
					// refresh not affecting the cookie
					if($mode !== 'refresh'){
						setcookie('database_version', $database_version, time()+3456000);
					}
				}else{
					// for version 1.1.3, we check the user password, if, the password length more than 32 character, its exactly 1.1.3
					$q = mysql_query("SELECT * FROM `elybin_users` LIMIT 0,1");
					$c = mysql_num_rows($q);
					if($c > 0){
						// try to count password length
						$pass_len = strlen(mysql_fetch_array($q)['user_account_pass']);
						if($pass_len > 32){
							$database_version = '1.1.3';
						}else{
							$database_version = '1.1.1';
						}
						// refresh not affecting the cookie
						if($mode !== 'refresh'){
							//set database ver
							setcookie('database_version', $database_version, time()+3456000);
						}
					}else{
						// give error space dude!
						$error_msg = __('Users table not exists or empty.');
					}
				}
				// get current installer version
				if(file_exists(many_trans().'elybin-core/elybin-version.php')){
					// include elybin-version
					include(many_trans().'elybin-core/elybin-version.php');
					// get installer version
					$installer_version = "$ELYBIN_VERSION.$ELYBIN_BUILD";
					// refresh not affecting the cookie
					if($mode !== 'refresh'){
						// set cookie
						setcookie('installer_version', $installer_version, time()+3456000);
					}
				}else{
					// give error space dude!
					$error_msg = __('Installer version unknown because version file not found.');
				}
				// we got the database version, match with version_list
				if(file_exists(many_trans().'elybin-install/inc/version_list.php')){
					// make sure two important variable exist
					if(!empty($database_version) && !empty($installer_version)){
						// include version_list
						include(many_trans().'elybin-install/inc/version_list.php');
						// try to compare it
						for ($i=0; $i < count($version); $i++) {
							// seek database array id
							if($version[$i]['version'] == $database_version){
								// save current array
								$database_arr_pos = $i;
							}
							// seek installer array id
							if($version[$i]['version'] == $installer_version){
								// save current array
								$installer_arr_pos = $i;
							}
						}
						// check
						if(isset($database_arr_pos) && isset($installer_arr_pos)){
							// try to compare
							if($installer_arr_pos < $database_arr_pos){
								// once again
								if($version[$database_arr_pos]['upgrade_support']){
									// bingo!, it's upgradeable!
									$upgrade_possible = true;
									// refresh not affecting the cookie
									if($mode !== 'refresh'){
										// set cok
										setcookie('upgrade_possible', true, time()+3456000);
									}
								}else{
									// give error space dude!
									$error_msg = __('Current version doesn\'t support upgrade, bassed on Version List.');
								}
							}else{
								// give error space dude!
								$error_msg = __('Database version is higher than Installer version.');
							}
						}else{
							// give error space dude!
							$error_msg = sprintf(__('Database or Installer version not found inside Version List. (Database: %s, Installer: %s)'), $database_arr_pos, $installer_arr_pos);
						}
					}else{
						// give error space dude!
						$error_msg = sprintf(__('$database_version or $installer_version not set. (Database: %s, Installer: %s)'), @$database_version, @$installer_version);
					}
				}else{
					// give error space dude!
					$error_msg = __('Version list not found.');
				}
			}else{
				// give error space dude!
				$error_msg = __('Trying to connect to database, but failed.');
			}
		}else{
			// give error space dude!
			$error_msg = __('Configuration file not found.');
		}
	}else{
		// refresh not affecting the cookie
		if($mode !== 'refresh'){
			// just get value
			$upgrade_possible = @$_COOKIE['upgrade_possible'];
			$database_version = @$_COOKIE['database_version'];
			$installer_version = @$_COOKIE['installer_version'];
		}
	}

	// return the value
	if($debug || $param == 'debug'){
		$upgrade_possible = __($upgrade_possible ? 'Yes': 'No');
		return $error_msg . '('. sprintf(__('Upgrade from "%s" to "%s" are possible?: %s'), @$database_version, @$installer_version, $upgrade_possible).')';
	}
	else if($param == 'installer_version'){
		return $installer_version;
	}
	else if($param == 'database_version'){
		return @$database_version;
	}
	else{
		return $upgrade_possible;
	}
}

function get_upgrade_info($param = null, $mode = null){
	/**
	 * Getting few upgrade info
	 * @param $mode = 'refresh' to get fresh version, not from cache, but still not changing the cache
	 * @param $mode = 'reset' to get fresh version, not from cache, but changing the cache
	 * @since 1.1.41
	 */
	// database_version
	if($param == 'database_version'){
		return check_upgrade_possible('database_version', $mode);
	}
	else if($param == 'installer_version'){
		return check_upgrade_possible('installer_version', $mode);
	}
	else {
		return __('Invalid first parameter.');
	}
}

function get_upgrade_readme(){
	/**
	 * Get upgrade readme
	 * @since 1.1.4
	 */
	// debug = false
	$debug = false;
	$o = null;
	// read
	$f = fopen(many_trans().'elybin-install/inc/upgrade_readme.php', "r");
	while(!feof($f)) {
	  $o .= fgets($f);
	}
	fclose($f);

	// remove header
	$extract_origin = preg_match('/\/\*\*\*(.*)/s', $o, $match);
	$o = $match[1];

	return $o;
}

function is_login($root = false){
	/**
	 * Check login, if logged in return true
	 * @since 1.1.4
	 */
	// debug first
	$debug = false;
	$login = false;

	// check as root user.
	if(!empty($_SESSION['login'])){
		// try connect first
		if(connect_with_config()){
			// get user_id
			$q = mysql_query("SELECT * FROM `elybin_users` WHERE `session` = '".$_SESSION['login']."' ");
			$c = mysql_num_rows($q);
			// if found, get it
			if($c > 0){
				// checking root
				if($root){
					// if theres is user with id 1
					$q2 = mysql_query("SELECT * FROM `elybin_users` WHERE `session` = '".$_SESSION['login']."' && `user_id` = 1");
					$c2 = mysql_num_rows($q2);
					// if found, get it
					if($c2 > 0){
						// yes, it's root
						$login = true;
						$root = true;
					}
				}else{
					// yes, not root
					$login = true;
				}
			}
		}else{
			// give error space dude
			$error_msg = __('Cannot connect to database with exiting configuration.');
		}
	}else{
		// give error space dude
		$error_msg = __('Currently not logged in.');
	}
	// result
	if($debug){
		var_dump(@$error_msg." ".sprintf(__('Connect to database with config: %s, Root?: %s'), $login, @$root));
		exit;
	}else{
		return $login;
	}
}

function upgrade_diff($param = null){
	/**
	 * Get upgrade diff version
	 * @since 1.1.4
	 */
	// debug
	$debug = false;

	// first
	$upgrade_diff = false;

	// works only if upgrade possible
	if(check_upgrade_possible()){
		// fill variable
		$database_version = get_upgrade_info('database_version');
		$installer_version = get_upgrade_info('installer_version');

		// first, get differec betweet version
		if(file_exists(many_trans().'elybin-install/inc/version_list.php')){
			// make sure two important variable exist
			if(!empty($database_version) && !empty($installer_version)){
				// include version_list
				include(many_trans().'elybin-install/inc/version_list.php');
				// try to compare it
				for ($i=0; $i < count($version); $i++) {
					// seek database array id
					if($version[$i]['version'] == $database_version){
						// save current array
						$database_arr_pos = $i;
					}
					// seek installer array id
					if($version[$i]['version'] == $installer_version){
						// save current array
						$installer_arr_pos = $i;
					}
				}
				// check
				if(isset($database_arr_pos) && isset($installer_arr_pos)){
					// try to compare
					if($installer_arr_pos < $database_arr_pos){
						// once again
						if($version[$database_arr_pos]['upgrade_support']){
							// bingo!, it's upgradeable!
							$upgrade_diff = $database_arr_pos-$installer_arr_pos;
							// get version since database ver
							for ($j=$installer_arr_pos; $j < $database_arr_pos; $j++) {
								$upgrade_diff_arr[] = $version[$j+1]['version'].'-'.$version[$j]['version'].'.sql';
							}

						}else{
							// give error space dude!
							$error_msg = __('Current version doesn\'t support upgrade, bassed on Version List.');
						}
					}else{
						// give error space dude!
						$error_msg = __('Database version is higher than Installer version.');
					}
				}else{
					// give error space dude!
					$error_msg = sprintf(__('Database or Installer version not found inside Version List. (Database: %s, Installer: %s)'), $database_arr_pos, $installer_arr_pos);
				}
			}else{
				// give error space dude!
				$error_msg = sprintf(__('$database_version or $installer_version not set. (Database: %s, Installer: %s)'), $database_version, $installer_version);
			}
		}else{
			// give error space dude!
			$error_msg = __('Version list not found.');
		}
	}

	// if debug
	if($debug || $param == 'debug'){
		return $error_msg;
	}else{
		// if get
		if($param == 'number'){
			return $upgrade_diff;
		}else{
			return @$upgrade_diff_arr;
		}
	}
}

function check_upgrade_query($query_file_name = null){
	/**
	 * Get upgrade query
	 * @since 1.1.4
	 */
	// debug
	$debug = false;

	// query available?
	$qa = false;

	// check upgrade query file existace
	if(file_exists(many_trans()."elybin-install/mysql/{$query_file_name}")){
		$qa = true;
	}

	// result
	if($debug){
		var_dump(many_trans()."elybin-install/mysql/{$query_file_name}");
	}else{
		return $qa;
	}
}

function do_database_backup(){
	/**
	 * Backuping database to `elybin-file/backup/`
	 */
	// include old config
 	require(many_trans().'elybin-core/elybin-config.php');

	// backup source code from POPOJI cms
	$con = mysql_connect($DB_HOST, $DB_USER, $DB_PASSWD) or die(mysql_error());
	mysql_select_db($DB_NAME, $con) or die(mysql_error());
	$tables = '*';
	$return = "";
	//get all of the tables
	if($tables == '*'){
		$tables = array();
		$result = mysql_query('SHOW TABLES');
		while($row = mysql_fetch_row($result))
		{
			$tables[] = $row[0];
		}
	}else{
		$tables = is_array($tables) ? $tables : explode(',',$tables);
	}

	//cycle through
	foreach($tables as $table){
		$result = mysql_query('SELECT * FROM '.$table);
		$num_fields = @mysql_num_fields($result);

		$return.= 'DROP TABLE IF EXISTS '.'`'.$table.'`'.';';
		$row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE `'.$table.'`'));
		$return.= "\n\n".$row2[1].";\n\n";

		for ($i = 0; $i < $num_fields; $i++) {
			while($row = mysql_fetch_row($result)){
				$return.= 'INSERT INTO `'.$table.'` VALUES(';
				for($j=0; $j<$num_fields; $j++) {
					$row[$j] = addslashes($row[$j]);
					$row[$j] = preg_replace("/\r\n/","\\r\\n",$row[$j]);
					if (isset($row[$j])) { $return.= '\''.$row[$j].'\'' ; } else { $return.= '\'\''; }
					if ($j<($num_fields-1)) { $return.= ','; }
				}
				$return.= ");\n";
			}
		}
		$return.="\n\n\n";
	}

	//save file
	// try to write it
	$f = fopen(many_trans().'elybin-file/backup/'.md5(md5(md5(rand(1111,9999))).rand(1111,9999)).date('-Y-m-d-H-i-s').'.sql', "w");
	if(fwrite($f, $return) == false){
		// write manually
		return false;
	}else{
		return true;
	}
	fclose($f);

}
