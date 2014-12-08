<?php
/* Short description for file
 * [ Module: Setting - Plugin Proccess
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
if(empty($_SESSION['login'])){
	header('location:../../../403.php');
}else{	
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once '../../../elybin-core/elybin-pclzip.lib.php';
	include_once('../../lang/main.php');

// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
$level = $tbus->current()->level; // getting level from curent user

$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
$usergroup = $tbug->current()->setting;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
}else{
	// start here
	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//ADD
	if ($mod=='plugin' AND $act=='add'){
		
		$fileName = $_FILES['plugin_file']['name'];
		$tmpName = $_FILES['plugin_file']['tmp_name'];
		$pecah = explode(".", $fileName);
		$ekstensi = $pecah[2];
		$folder = seo_title($pecah[1]);

		if(!empty($tmpName)){
			// only zip file
			$extensionList = array("zip");
			if (in_array($ekstensi, $extensionList)){
				UploadPlugin($folder.".zip");

				// move to temp folder
				$destination_dir = "../../tmp/";
				if(!file_exists($destination_dir.$folder."/")){
					mkdir($destination_dir.$folder."/");
				
					// extract the zip
					$archive = new PclZip($destination_dir.$folder.".zip");
					if ($archive->extract(PCLZIP_OPT_PATH, $destination_dir.$folder."/") == 0){
						// give error
						$a = array(
							'status' => 'error',
							'title' => $lg_error,
							'isi' => $lg_plugincorrupt
						);
						json($a);
						exit;
					}
				}
				//INCLUDE MANIFEST AMBIL NAMA FOLDER
				if(file_exists($destination_dir.$folder."/ElybinManifest.php")){
					include($destination_dir.$folder."/ElybinManifest.php");
					$app_folder_ok = $app_alias; 

					if(file_exists("../".$app_folder_ok)){
						// give error plugin already installed
						$a = array(
							'status' => 'error',
							'title' => $lg_error,
							'isi' => $lg_pluginalreadyinstalled
						);
						json($a);
						exit;
					}else{
						mkdir("../".$app_folder_ok);
				
						$archive = new PclZip($destination_dir.$folder.".zip");
						if ($archive->extract(PCLZIP_OPT_PATH, "../".$app_folder_ok) == 0){
							// give error
							$a = array(
								'status' => 'error',
								'title' => $lg_error,
								'isi' => $lg_plugincorrupt
							);
							json($a);
							exit;
						}

						// write to database
						$tbl = new ElybinTable('elybin_plugins');
						$plugin2 = $tbl->SelectLimit('plugin_id','DESC','0,1');
						$plugin_id = 1;
						foreach ($plugin2 as $ps) {
							$plugin_id = $ps->plugin_id + 1;
						}

						// get all usergroup
						$tblug = new ElybinTable('elybin_usergroup');
						$tblug = $tblug->Select('','');
						$usergroup_all = '';
						foreach ($tblug as $ugal) {
							$usergroup_all = "$usergroup_all,$ugal->usergroup_id";
						}
						$usergroup_all = ltrim($usergroup_all, ",");

						$data = array(
							'plugin_id' => $plugin_id,
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
					}
				}
				//Done 
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_pluginuploaded,
					'plugin_id' => $plugin_id
				);
				json($a);
				//header('location:../../admin.php?mod='.$mod.'&next=install&id='.$plugin_id);
			}
		}
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

		// execute installer
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
		header('location:../../admin.php?mod='.$mod);
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
				'title' => $lg_error,
				'isi' => $lg_pluginremovefailed
			);
			json($a);
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