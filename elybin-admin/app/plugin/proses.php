<?php
/* Short description for file
 * [ Module: Setting - Plugin Proccess
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
if(empty($_SESSION['login'])){
	header('location:../../../403.html');
}else{	
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once '../../../elybin-core/elybin-pclzip.lib.php';
	include_once('../../lang/main.php');


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
		$plugin_id = $v->sql($_POST['plugin_id']);

		// check id exist or not
		$tb = new ElybinTable('elybin_plugins');
		$coplugin = $tb->GetRow('plugin_id', $plugin_id);
		if(empty($plugin_id) OR ($coplugin == 0)){
			header('location: ../../../404.html');
			exit;
		}

		// get plugin information
		$cplug = $tb->SelectWhere('plugin_id',$plugin_id,'','');
		$cplug = $cplug->current();

		// sql installer
		$sql_contents = "";
		$fp = fopen("../".$cplug->alias."/db/install.sql","r");
		while(! feof($fp))
		  {
		  $sql_contents .= fgets($fp);
		  }
		fclose($fp);

		$sql_contents =  explode(";", rtrim($sql_contents, ";"));

		// because we can't use oop
		$dbhostsql = DB_HOST;
		$dbusersql = DB_USER;
		$dbpasswordsql = DB_PASSWD;
		$dbnamesql = DB_NAME;
		$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
		mysql_select_db($dbnamesql, $connection) or die(mysql_error());

		foreach($sql_contents as $query){
			$result = @mysql_query($query);
			if ($result){
				$tb 	= new ElybinTable('elybin_plugins');
				$ccon	= $tb->SelectWhere('plugin_id',$plugin_id,'','');
				$ccon	= $ccon->current();
				$status = $ccon->status;
				if($status == 'install'){
					$data = array('status' => 'active');
					$tb->Update($data,'plugin_id',$plugin_id);
				}

				deleteDir("../".$cplug->alias."/db/install.sql");
			}
		}
		
		// execute installer
		if(file_exists("../".$cplug->alias."/ElybinInstall.php")){
			include("../".$cplug->alias."/ElybinInstall.php");
		}
		
		//header('location:../../admin.php?mod='.$mod);
	}
	//DEL
	elseif ($mod=='plugin' AND $act=='del'){
		$plugin_id = $v->sql($_POST['plugin_id']);
		$tabledel = new ElybinTable('elybin_plugins');

		// check id exist or not
		$coplugin = $tabledel->GetRow('plugin_id', $plugin_id);
		if(empty($plugin_id) OR ($coplugin == 0)){
			header('location: ../../../404.html');
			exit;
		}

		$cplug = $tabledel->SelectWhere('plugin_id',$plugin_id,'','');
		$cplug = $cplug->current();

		// only delete dir if plugin not installed
		if($cplug->status == 'install'){
			$dir = "../".$cplug->alias."/";
			deleteDir($dir);
			$tabledel->Delete('plugin_id', $plugin_id);
			header('location:../../admin.php?mod='.$mod);
			exit;
		}

		// execute remover
		$sql_contents = "";
		$fp = fopen("../".$cplug->alias."/db/remove.sql","r");
		while(! feof($fp))
		  {
		  $sql_contents .= fgets($fp);
		  }
		fclose($fp);

		// because we can't use oop
		$dbhostsql = DB_HOST;
		$dbusersql = DB_USER;
		$dbpasswordsql = DB_PASSWD;
		$dbnamesql = DB_NAME;
		$connection = mysql_connect($dbhostsql, $dbusersql, $dbpasswordsql) or die(mysql_error());
		mysql_select_db($dbnamesql, $connection) or die(mysql_error());
		$result = mysql_query($sql_contents) or die(mysql_error());
		if ($result){
			// Wipe 
			$dir = "../".$cplug->alias."/";
			deleteDir($dir);
			//Done
			$tabledel->Delete('plugin_id', $plugin_id);
		}else{
			// give error
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => $lg_pluginremovefailed
			);
			echo json_encode($a);
			exit;
		}
		
		header('location:../../admin.php?mod='.$mod);
	}
	//404
	else{
		echo '404';
		header('location:../../../404.php');
	}
}	
}
?>