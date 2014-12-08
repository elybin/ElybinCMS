<?php
/* Short description for file
 * [ Module: Themes Proccess
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
	$mod = @$_POST['mod'];
	$act = @$_POST['act'];
	
	//ADD
	if ($mod=='theme' AND $act=='add'){
		$extensionList = array("zip");
		$fileName = $_FILES['theme_file']['name'];
		$tmpName = $_FILES['theme_file']['tmp_name'];
		$pecah = explode(".", $fileName);
		$ekstensi = $pecah[2];
		$folder = seo_title($pecah[1]);

		if(!empty($tmpName)){
			if (in_array($ekstensi, $extensionList)){
				UploadTheme($folder.".zip");

				//EXTRACT SEMENTARA
				$destination_dir = "../../tmp/";
				if(!file_exists($destination_dir.$folder."/")){
					mkdir($destination_dir.$folder."/");
				
					$archive = new PclZip($destination_dir.$folder.".zip");
					if ($archive->extract(PCLZIP_OPT_PATH, $destination_dir.$folder."/") == 0){
						echo 'File Corrupt';
						header('location:../../../404.php');
						exit;
					}
				}
				//INCLUDE MANIFEST AMBIL NAMA FOLDER
				if(file_exists($destination_dir.$folder."/ElybinManifest.php")){
					include($destination_dir.$folder."/ElybinManifest.php");
					$thm_folder_ok = $thm_folder; 

					if(!file_exists("../../../elybin-main/".$thm_folder_ok)){
						mkdir("../../../elybin-main/".$thm_folder_ok);
				
						$archive = new PclZip($destination_dir.$folder.".zip");
						if ($archive->extract(PCLZIP_OPT_PATH, "../../../elybin-main/".$thm_folder_ok) == 0){
							echo 'File Corrupt';
							header('location:../../../404.php');
							
							exit;
						}

						//WRITE DATABASE
						$tbl = new ElybinTable('elybin_themes');
						$theme2 = $tbl->SelectLimit('theme_id','DESC','0,1');
						$theme_id = 1;
						foreach ($theme2 as $ps) {
							$theme_id = $ps->theme_id + 1;
						}

						$data = array(
							'theme_id' => $theme_id,
							'name' => $thm_name,
							'description' => $thm_description,
							'author' => $thm_author,
							'url' => $thm_url,
							'folder' => $thm_folder,
							'status' => 'deactive'
						);
						$tbl->Insert($data);

						//RM TEMP DIR
						deleteDir($destination_dir.$folder."/");
						if(file_exists($destination_dir.$folder.".zip")){
							unlink($destination_dir.$folder.".zip");
						}
					}else{
						echo 'App are already exist';
					}
				}

				header('location:../../admin.php?mod='.$mod);
			}
		}else{
			echo '404';
			header('location:../../../404.php');
		}
	}
	//ACTIVE
	elseif ($mod=='theme' AND $act=='active'){
		$v 	= new ElybinValidasi();
		$id 	= $v->sql($_POST['theme_id']);
		$id 	= $v->sql($id);

		$tb 	= new ElybinTable('elybin_themes');

		// check id exist or not
		$cotheme = $tb->GetRow('theme_id', $id);
		if(empty($id) OR ($cotheme == 0)){
			header('location: ../../../404.html');
			exit;
		}

		$ccon	= $tb->Select('','');
		
		$data = array('status' => 'deactive');
		$tb->Update($data,'status','active');
		

		$ccon	= $tb->SelectWhere('theme_id',$id,'','');
		$ccon	= $ccon->current();
		$status = $ccon->status;
		$data = array('status' => 'active');
		$tb->Update($data,'theme_id',$id);
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


		$dir = "../../../elybin-main/".$ctheme->folder."/";

		deleteDir($dir);

		
		$tabledel->Delete('theme_id', $theme_id);
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