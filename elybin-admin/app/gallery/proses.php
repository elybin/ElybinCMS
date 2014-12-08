<?php
/* Short description for file
 * [ Module: Gallery Proccess
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
	if ($mod=='gallery' AND $act=='add'){
		$album_id = $v->sql($_POST['album_id']);
		$fileName = $_FILES['image']['name'];
		$tmpName = $_FILES['image']['tmp_name'];

		//if field empty
		if(empty($album_id) AND empty($fileName)){
			//please fill important
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}

		if(!empty($tmpName)){
			//get lastest gallery id
			$tbgallery = new ElybinTable('elybin_gallery');
			$gallery2 = $tbgallery->SelectLimit('gallery_id','DESC','0,1');
			$gallery_id = 1;
			foreach ($gallery2 as $ps) {
				$gallery_id = $ps->gallery_id + 1;
			}

			$pecah = explode(".", $fileName); 
			$ekstensi = @$pecah[1];

			//allowed extension
			$extensionList = array("jpg","jpeg","png");
			if (in_array($ekstensi, $extensionList)){
				$description = "- $lg_nodescription -";

				//replace to readable 
				$rep = array("-","_");
				$title = str_replace($rep, " ", $v->xss($pecah[0]));
				$title = ucwords(substr($title,0,200));

				$seotitle = substr(seo_title(trim($title)),0,50);
				$acak = rand(1111,9999);
				$nama_file_unik = "$seotitle-elybin-cms-$acak.$ekstensi";
				$image = strtolower($nama_file_unik);
				$tgl = now();

				//upload images
				UploadImage($image,'gallery');
				$tbl = new ElybinTable('elybin_gallery');
				$data = array(
					'gallery_id' => $gallery_id,
					'album_id' => $album_id,
					'name' => $title,
					'description' => $description,
					'date' => $tgl,
					'image' => $image
				);
				$tbl->Insert($data);

				//Done
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_datainputsuccessful
				);
				json($a);
			}else{
				//image extension deny
				$a = array(
					'status' => 'error',
					'title' => $lg_error,
					'isi' => $lg_fileextensiondeny
				);
				json($a);
			}
		}
	}
	//EDIT
	elseif($mod=='gallery' AND $act=='edit'){
		//validate from sqli
		$gallery_id = $v->sql($_POST['gallery_id']);
		$album_id = $v->sql($_POST['album_id']);
		$title = $v->xss($_POST['name']);
		$description = htmlspecialchars($_POST['description'],ENT_QUOTES);
		
		// check id exist or not
		$tbl 	= new ElybinTable('elybin_gallery');
		$cogallery = $tbl->GetRow('gallery_id', $gallery_id);
		if(empty($gallery_id) OR ($cogallery == 0)){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_iderrorpleasereloadpage
			);

			json($a);
			exit;
		}
		
		//if field empty
		if(empty($album_id) AND empty($gallery_id)){
			//echo "{,$lg_pleasefillimportant}";
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}
		elseif(empty($title)){
			$title = "($lg_untitled)";
		}
		elseif(empty($description)){
			$title = "- $lg_nodescription -";
		}

		//get lastest gallery id
		$tblim = new ElybinTable('elybin_gallery');
		$image_lama = $tblim->SelectWhere('gallery_id',$gallery_id,'','');
		foreach($image_lama as $i){
				$image_lama = $i->image;
		}

		$pecah = explode(".",$image_lama);
		$ekstensi = @$pecah[1];
		$seotitle = substr(seo_title(trim($title)),0,50);
		$acak = rand(1111,9999);
		$nama_file_unik = "$seotitle-elybin-cms-$acak.$ekstensi";
		$image = strtolower($nama_file_unik);

		//new name
		$fileimage = "../../../elybin-file/gallery/$image";
		$fileimage_med = "../../../elybin-file/gallery/medium-$image";
		//previous name
		$fileimage_lama = "../../../elybin-file/gallery/$image_lama";
		$fileimage_lama_med = "../../../elybin-file/gallery/medium-$image_lama";

		if (file_exists("$fileimage_lama")){
			rename($fileimage_lama, $fileimage);
			rename($fileimage_lama_med, $fileimage_med);
		}

		$data = array(
			'album_id' => $album_id,
			'name' => $title,
			'description' => $description,
			'image' => $image
		);
		$tbl->Update($data,'gallery_id',$gallery_id);
		
		//Done
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_datainputsuccessful
		);
		json($a);
	}

	//DEL
	elseif($mod=='gallery' AND $act=='del'){
		$gallery_id = $v->sql($_POST['gallery_id']);
		$tabledel = new ElybinTable('elybin_gallery');
		
		// check id exist or not
		$cogallery = $tabledel->GetRow('gallery_id', $gallery_id);
		if(empty($gallery_id) OR ($cogallery == 0)){
			header('location: ../../../404.html');
			exit;
		}
		
		//get image filename
		$cimg = $tabledel->SelectWhere('gallery_id',$gallery_id,'','');
		foreach($cimg as $i){
			$image = $i->image;
		}

		//remove it
		$fileimage = "../../../elybin-file/gallery/$image";
			if (file_exists("$fileimage")){
				unlink("../../../elybin-file/gallery/$image");
				unlink("../../../elybin-file/gallery/medium-$image");
			}
		$tabledel->Delete('gallery_id', $gallery_id);
		//Done
		header('location:../../admin.php?mod='.$mod);
	}	
	//MULTI DEL
	elseif($mod=='gallery' AND $act=='multidel'){
		$gallery_id = $_POST['del'];
		
		if(!empty($gallery_id)){
			foreach ($gallery_id as $tg) {
				$pecah = explode("|",$tg);
				$pecah = $pecah[0];
				$gallery_id_fix = $v->sql($pecah);
				
				// check id exist or not
				$cogallery = $tabledel->GetRow('gallery_id', $gallery_id);
				if(empty($gallery_id) OR ($cogallery == 0)){
					header('location: ../../../404.html');
					exit;
				}
				
				//get image filename
				$tabledel = new ElybinTable('elybin_gallery');
				$cimg = $tabledel->SelectWhere('gallery_id',$gallery_id_fix,'','');
				foreach($cimg as $i){
					$image = $i->image;
				}
				//remove it
				$fileimage = "../../../elybin-file/gallery/$image";
					if (file_exists("$fileimage")){
						unlink("../../../elybin-file/gallery/$image");
						unlink("../../../elybin-file/gallery/medium-$image");
					}
				$tabledel->Delete('gallery_id', $gallery_id_fix);
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