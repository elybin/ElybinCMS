<?php
/* Short description for file
 * [ Module: Media Proccess
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
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once('../../lang/main.php');
	include_once('inc/module-function.php');

	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//ADD
	if (($mod=='media' && $act=='add') || isset($_GET['addmulti'])){
		if(isset($_FILES['file'])){
			//allowed file type
			$extensionList = array("jpg", "jpeg","png","svg","xls","xlsx","ppt","pptx","txt","doc","docx","pdf","rar","zip","mp3");
			$fileName = $_FILES['file']['name'];
			$tmpName = $_FILES['file']['tmp_name'];
			$fileType = $_FILES['file']['type'];
			$fileSize = $_FILES['file']['size'];
			$category = categorize_mime_types($fileType);
			$pecah = explode(".", $fileName);
			$ekstensi = strtolower(@$pecah[count($pecah)-1]);
			$seotitle = seo_title($pecah[0]);
			$tanggal = date("Y-m-d_H-i-s");
			$acak = rand(1111,9999);
			$nama_file_unik = "$seotitle-$tanggal-$acak.$ekstensi";
			$file = strtolower($nama_file_unik);

			/**
			 * Filter seotitle
			 * @since 1.1.4
			 */
			// checking seo title
 			if(!check_seotitle($seotitle, 0)){
 				$seotitle = suggest_unique($seotitle, 0);
 			}

			//filter extension
			if (in_array($ekstensi, $extensionList)){
				if($category == 'image'){
					//upload file if has image mime
					$up = UploadImage($file,'media');
					if(empty($up['ok'])){
						// return error
						//image extension deny
						$a = array(
							'status' => 'error',
							'title' => lg('Error'),
							'isi' => $up['error']['message']
						);
						echo json_encode($a);
						exit;
					}
				}else{
					//upload file if has non-image mime
					UploadFile($file,'media');
				}
				$table = new ElybinTable('elybin_media');
				$data = array(
					'title' => $fileName,
					'seotitle' => $seotitle,
					'filename' => $file,
					'description' => '',
					'metadata' => json_encode(@exif_read_data("../../../elybin-file/media/".$file)),
					'hash' => md5(md5($file)),
					'mime' => $fileType,
					'type' => $category,
					'size' => $fileSize,
					'share' => 'yes',
					'media_password' => '',
					'date' => date('Y-m-d H:i:s')
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

				_red('../../admin.php?mod=media&msg=uploaded');
				exit;
			}else{
				//file extension deny
				$a = array(
					'status' => 'error',
					'title' => lg('Error'),
					'isi' => lg('File type not allowed')
				);
				echo json_encode($a);
				exit;
			}
		}else{
			//please fill important
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Please select file')
			);

			echo json_encode($a);
			exit;
		}
	}
	//DOWNLOAD
	elseif($mod=='media' AND $act=='download'){
		// 1.1.3
		// moved to open_file.php
		exit;
	}
	//DEL
	elseif($mod=='media' AND $act=='del'){
		$media_id = $v->sql(epm_decode($_POST['media_id']));
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
				$media_id_fix = $v->sql(epm_decode($pecah));

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
