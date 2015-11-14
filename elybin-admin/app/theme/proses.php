<?php
/* Short description for file
 * [ Module: Themes Proccess
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
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
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
}else{
	// start here
	$v = new ElybinValidasi;
	$mod = @$_POST['mod'];
	$act = @$_POST['act'];

	//ADD
	if ($mod=='theme' AND $act=='add'){
		$file_name = $_POST['file_name'];
		$ext = substr($file_name, -4);
		$prefix = substr($file_name, 0, 4);

		// check file extension
		if($prefix!=="thm." || $ext!==".zip"){
			// give error
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_themecorrupt." (Err.Invalid filename)"
			);
			echo json_encode($a);
			exit;
		}
		// remove prefix and ext
		$folder = str_replace("thm.", "", $file_name);
		$folder = str_replace(".zip", "", $folder);


		// create temp folder
		$destination_dir = "../../tmp/";
		if(!file_exists($destination_dir.$folder."/")){
			mkdir($destination_dir.$folder."/");
		}

		if(file_exists($destination_dir.$folder."/")){
			// extract the zip
			$archive = new PclZip("../../../elybin-file/ext/thm.$folder.zip");
			if ($archive->extract(PCLZIP_OPT_BY_NAME, 'ElybinManifest.php', PCLZIP_OPT_PATH, $destination_dir.$folder."/") == 0){
				// give error
				$a = array(
					'status' => 'error',
					'title' => $lg_error,
					'isi' => $lg_themecorrupt." (Err.Can't unzip package)"
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
				'title' => $lg_error,
				'isi' => $lg_themecorrupt." (Err.ElybinManifest Missing)"
			);
			echo json_encode($a);
			exit;
		}

		// get plguin info
		include($destination_dir.$folder."/ElybinManifest.php");
		// already installed
		$tbl = new ElybinTable('elybin_themes');
		$cpth = $tbl->GetRow('folder', $thm_folder);
		if($cpth > 0){
			// give error plugin already installed
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_themealreadyinstalled
			);
			echo json_encode($a);
			deleteDir($destination_dir.$folder."/");
			exit;
		}

		// copy to targetdir
		@mkdir("../../../elybin-file/theme/".$thm_folder);
		$archive = new PclZip("../../../elybin-file/ext/thm.$folder.zip");
		if ($archive->extract(PCLZIP_OPT_PATH, "../../../elybin-file/theme/".$thm_folder) == 0){
			// give error
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_themecorrupt." (Err.Can't unzip package)"
			);
			echo json_encode($a);
			exit;
		}

		// write to database
		$data = array(
			'name' => $thm_name,
			'description' => $thm_description,
			'author' => $thm_author,
			'url' => $thm_url,
			'folder' => $thm_folder,
			'status' => 'deactive'
		);
		$tbl->Insert($data);

		//remove temp dir
		deleteDir($destination_dir.$folder."/");
		if(file_exists($destination_dir.$folder.".zip")){
			unlink($destination_dir.$folder.".zip");
		}

		//Done
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_themeuploaded
		);
		echo json_encode($a);
		exit;
	}
	//ACTIVE
	elseif ($mod=='theme' AND $act=='active'){
		$tid 	= sqli_(@$_POST['theme_id']);

		// check id exist or not
		if(	empty($tid)	){
			redirect(get_url('404'));
			exit;
		}

		/**
		 * @since 1.1.4 elybin_themes table not used anymore.
		 * And moved to elybin_options */
		$tb = new ElybinTable('elybin_options');
		$tb->Update( ['value' => $tid], 'name', 'template');

		header('location:../../admin.php?mod='.$mod);
	}
	elseif ($mod=='theme' AND $act=='admin_theme'){
		$value = $v->xss($_POST['id']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_changessaved
		);
		echo json_encode($a);
	}
	//DEL
	elseif ($mod=='theme' AND $act=='del'){
		$theme_id = $v->sql($_POST['theme_id']);
		$tabledel = new ElybinTable('elybin_themes');

		// check id exist or not
		$cotheme = $tabledel->GetRow('theme_id', $theme_id);
		if(empty($theme_id) OR ($cotheme == 0)){
			header('location: ../../../404.html');
			exit;
		}

		$ctheme = $tabledel->SelectWhereAnd('theme_id',$theme_id,'status','deactive','','');
		$ctheme = $ctheme->current();


		$dir = "../../../elybin-file/theme/".$ctheme->folder."/";

		deleteDir($dir);


		$tabledel->Delete('theme_id', $theme_id);
		header('location:../../admin.php?mod='.$mod);
	}
	//404
	else{
		header('location: ../../../404.html');
	}
}
}
?>
