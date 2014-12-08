<?php
/* Short description for file
 * [ Module: Media Proccess
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
	include_once('../../lang/main.php');

	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//ADD
	if ($mod=='media' AND $act=='add'){
		//get lastest media id
		$tbpage = new ElybinTable('elybin_media');
		$page2 = $tbpage->SelectLimit('media_id','DESC','0,1');
		$media_id = 1;
		foreach ($page2 as $ps) {
			$media_id = $ps->media_id + 1;
		}


		if(!empty($_FILES['file']['tmp_name'])){
			//allowed file type
			$extensionList = array("jpg", "jpeg","png","xls","xlsx","ppt","pptx","txt","doc","docx","pdf","rar","zip");
			$fileName = $_FILES['file']['name'];
			$tmpName = $_FILES['file']['tmp_name'];
			$fileType = $_FILES['file']['type'];
			$fileSize = $_FILES['file']['size'];
			$pecah = explode(".", $fileName);
			$ekstensi = @$pecah[1];
			$seotitle = seo_title($pecah[0]);
			$elybin = "elybin-cms";
			$acak = rand(1111,9999);
			$nama_file_unik = "$seotitle-$elybin-$acak.$ekstensi";
			$file = strtolower($nama_file_unik);
			$tgl = now();

			//filter extension
			if (in_array($ekstensi, $extensionList)){

				//upload file
				UploadFile($file,'media');
				$table = new ElybinTable('elybin_media');
				$data = array(
					'media_id' => $media_id,  
					'filename' => $file,
					'type' => $fileType,
					'size' => $fileSize,
					'date' => $tgl
				);
				$table->Insert($data);

				// getting site url
				$tblo = new ElybinTable('elybin_options');
				$site_url = $tblo->SelectWhere('name','site_url','','')->current()->value;

				// check callback set of not
				if(!empty($_POST['callback'])){
					echo "$site_url/elybin-file/media/$file";
					exit;
				}

				//Done
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_datainputsuccessful
				);
				json($a);
			}else{
				//file extension deny
				$a = array(
					'status' => 'error',
					'title' => $lg_error,
					'isi' => $lg_fileextensiondeny
				);
				json($a);
			}
		}else{
			//please fill important
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}
	}
	//DOWNLOAD
	elseif($mod=='media' AND $act=='download'){
		$media_id = $v->sql($_POST['media_id']);
		$tableget = new ElybinTable('elybin_media');

		// check id exist or not
		$comedia = $tableget->GetRow('media_id', $media_id);
		if(empty($media_id) OR ($comedia == 0)){
			header('location: ../../../404.html');
			exit;
		}
		
		//get filename
		$gfile = $tableget->SelectWhere('media_id',$media_id,'','');
		foreach($gfile as $i){
			$file = $i->filename;
		}
		$file = "../../../elybin-file/media/$file";
		
		//Done
		header('location: '.$file);
	}
	//DEL
	elseif($mod=='media' AND $act=='del'){
		$media_id = $v->sql($_POST['media_id']);
		$tabledel = new ElybinTable('elybin_media');

		// check id exist or not
		$comedia = $tabledel->GetRow('media_id', $media_id);
		if(empty($media_id) OR ($comedia == 0)){
			header('location: ../../../404.html');
			exit;
		}
		
		$gfile = $tabledel->SelectWhere('media_id',$media_id,'','');
		foreach($gfile as $i){
			$file = $i->filename;
		}
		$dir = "../../../elybin-file/media/$file";
		if (file_exists("$dir")){
			unlink("../../../elybin-file/media/$file");
		}
		$tabledel->Delete('media_id', $media_id);

		//Done
		header('location:../../admin.php?mod='.$mod);
	}
	//MULTI DEL
	elseif($mod=='media' AND $act=='multidel'){
		$media_id = $_POST['del'];
		$getfile = new ElybinTable('elybin_media');

		//if array not empty
		if(!empty($media_id)){
			foreach ($media_id as $tg) {
				$pecah = explode("|",$tg);
				$pecah = $pecah[0];
				$media_id_fix = $v->sql($pecah);
				
				// check id exist or not
				$comedia = $getfile->GetRow('media_id', $media_id_fix);
				if(empty($media_id_fix) OR ($comedia == 0)){
					header('location: ../../../404.html');
					exit;
				}
				
				$gfile = $getfile->SelectWhere('media_id',$media_id_fix,'','');
				$gfile = $gfile->current();
				$filename = $gfile->filename;

				$dir = "../../../elybin-file/media/$filename";
					if (file_exists($dir)){
						unlink("../../../elybin-file/media/$filename");
					}
				$getfile->Delete('media_id', $media_id_fix);
				//Done
				header('location:../../admin.php?mod='.$mod);
			}
		}
	}		
	//404
	else{
		header('location: ../../../404.html');
	}
}	
?>