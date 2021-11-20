<?php
/* Short description for file
 * [ Module: Setting - Plugin Proccess
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */

session_start();
if(empty($_SESSION['login'])){
	header('location:../../../403.html');
}else{
	require_once('../../../elybin-core/elybin-function.php');
	require_once('../../../elybin-core/elybin-oop.php');
	require_once('inc/main.func.php');


// get usergroup privilage/access from current user to this module
$usergroup = _ug()->setting;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	exit;
}else{
	// start here
	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//ADD
	if ($mod=='plugin' AND $act=='add'){
		_e('Disabled since 1.1.4');
		exit;
		$file_name = $_POST['file_name'];
		$ext = substr($file_name, -4);
		$prefix = substr($file_name, 0, 4);

		// check file extension
		if($prefix!=="com." || $ext!==".zip"){
			// give error
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Plugin Corrupt.')." (Err.Invalid filename)"
			);
			echo json_encode($a);
			exit;
		}
		// remove prefix and ext
		$folder = str_replace("com.", "", $file_name);
		$folder = str_replace(".zip", "", $folder);


		// create temp folder
		$destination_dir = "../../tmp/";
		if(!file_exists($destination_dir.$folder."/")){
			mkdir($destination_dir.$folder."/");
		}

		if(file_exists($destination_dir.$folder."/")){
			// extract the zip
			$archive = new PclZip("../../../elybin-file/ext/com.$folder.zip");
			if ($archive->extract(PCLZIP_OPT_BY_NAME, 'ElybinManifest.php', PCLZIP_OPT_PATH, $destination_dir.$folder."/") == 0){
				// give error
				$a = array(
					'status' => 'error',
					'title' => lg('Error'),
					'isi' => lg('Plugin Corrupt.')." (Err.Can't unzip package)"
				);
				echo json_encode($a);
				exit;
			}
		}

		//check ElybinManifest
		if(!file_exists($destination_dir.$folder."/ElybinManifest.php")){
			// give error
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Plugin Corrupt.')." (Err.ElybinManifest Missing)"
			);
			echo json_encode($a);
			exit;
		}

		// get plguin info
		include($destination_dir.$folder."/ElybinManifest.php");
		// already installed
		$tbl = new ElybinTable('elybin_plugins');
		$cplg = $tbl->GetRowAnd('alias', $app_alias,'version', $app_version);
		if($cplg > 0){
			// give error plugin already installed
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => $lg_pluginalreadyinstalled
			);
			echo json_encode($a);
			deleteDir($destination_dir.$folder."/");
			exit;
		}

		// copy to targetdir
		@mkdir("../".$app_alias);
		$archive = new PclZip("../../../elybin-file/ext/com.$folder.zip");
		if ($archive->extract(PCLZIP_OPT_PATH, "../".$app_alias) == 0){
			// give error
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Plugin Corrupt.')." (Err.Can't unzip package)"
			);
			echo json_encode($a);
			exit;
		}

		// get all usergroup
		$tblug = new ElybinTable('elybin_usergroup');
		$tblug = $tblug->Select('','');
		$usergroup_all = '';
		foreach ($tblug as $ugal) {
			$usergroup_all = "$usergroup_all,$ugal->usergroup_id";
		}
		$usergroup_all = ltrim($usergroup_all, ",");

		// write to database
		$data = array(
			'name' => $app_name,
			'alias' => $app_alias,
			'icon' => $app_icon,
			'notification' => '',
			'version' => $app_version,
			'description' => $app_description,
			'author' => $app_author,
			'url' => $app_url,
			'usergroup' => $usergroup_all,
			'table_name' => $app_table,
			'type' => $app_type,
			'status' => 'install'
		);
		$tbl->Insert($data);

		//remove temp dir
		deleteDir($destination_dir.$folder."/");
		if(file_exists($destination_dir.$folder.".zip")){
			unlink($destination_dir.$folder.".zip");
		}
		// Get plugin id
		$plugin_id = $tbl->SelectWhere('alias',$app_alias,'plugin_id', 'DESC')->current()->plugin_id;

		//Done
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Please wait...'),
			'plugin_id' => $plugin_id
		);
		echo json_encode($a);
	}
	//INSTALL
	elseif ($mod=='plugin' AND $act=='install'){
		$slug = $v->sql($_POST['plugin_id']);

		// get error
		if( !empty(get_plugin_info($slug)['error']) ){
			// error
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => get_plugin_info($slug)['error']['message'],
				'msg_ses' => get_plugin_info($slug)['error']['code'],
				'red' => get_url('admin_home').'admin.php?mod=plugin'
			), @$_GET['r']);
		}else{
			// get data
			$p = get_plugin_info($slug)['data'][0];
			// update database
			$data = array(
				'alias' => $slug,
				'version' => $p['version'],
				'status' => true
			);
			// insert
			$tb = new ElybinTable('elybin_plugins');
			$tb->Insert($data);

			// success
			result(array(
				'status' => 'ok',
				'title' => __('Installed'),
				'msg' => __('Plugin successfully installed.'),
				'msg_ses' => 'plugin_installed',
				'red' => get_url('admin_home').'admin.php?mod=plugin'
			), @$_GET['r']);
		}
	}
	//DEL
	elseif ($mod=='plugin' AND $act=='del'){
		$slug = $v->sql($_POST['plugin_id']);

		// get error
		if( !empty(get_plugin_info($slug)['error']) ){
			// error
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => get_plugin_info($slug)['error']['message'],
				'msg_ses' => get_plugin_info($slug)['error']['code'],
				'red' => get_url('admin_home').'admin.php?mod=plugin'
			), @$_GET['r']);
		}else{
			// delete
			$tb = new ElybinTable('elybin_plugins');
			$tb->Delete('alias', $slug);

			// success
			result(array(
				'status' => 'ok',
				'title' => __('Success'),
				'msg' => __('Plugin successfully uninsalled.'),
				'msg_ses' => 'plugin_uninstalled',
				'red' => get_url('admin_home').'admin.php?mod=plugin'
			), @$_GET['r']);
		}
	}
	//404
	else{
		echo '404';
		header('location:../../../404.php');
	}
}
}
?>
