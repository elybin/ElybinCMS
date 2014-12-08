<?php
/* Short description for file
 * [ Module: Album Proccess
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

// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
$level = $tbus->current()->level; // getting level from curent user

$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
$usergroup = $tbug->current()->album;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
}else{
	// start here
	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//ADD
	if ($mod=='album' AND $act=='add'){
		$name = $v->xss($_POST['name']);
		$date = $v->xss($_POST['date']);

		//if field empty
		if(empty($date)){
			//fill importyant
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}
		if(empty($name)){
			$name = "($lg_untitled)";
		}

		$date = explode("/", $date); //mm-dd-yyyy
		$date = $date['2']."-".$date['0']."-".$date[1]; //yyyy-mm-dd
		$seotitle =  seo_title($name);

		//get lastest album id
		$tbalbum = new ElybinTable('elybin_album');
		$album2 = $tbalbum->SelectLimit('album_id','DESC','0,1');
		$album_id = 1;
		foreach ($album2 as $al) {
			$album_id = $al->album_id + 1;
		}

		$tbl = new ElybinTable('elybin_album');
		$data = array(
			'album_id' => $album_id,
			'name' => $name,
			'seotitle' => $seotitle,
			'date' => $date,
			'status' => 'active'	
			);
		$tbl->Insert($data);
		
		//Done
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_datainputsuccessful
		);
		json($a);
	}
	//EDIT
	elseif($mod=='album' AND $act=='edit'){
		$album_id = $v->sql($_POST['album_id']);
		$name = $v->xss($_POST['name']);
		$date = $v->xss($_POST['date']);
		$status = @$_POST['status'];
		if($status == "on"){
			$status = "active";
		}else{
			$status = "deactive";
		}
		
		// check id exist or not
		$tbl 	= new ElybinTable('elybin_album');
		$coalbum = $tbl->GetRow('album_id', $album_id);
		if(empty($album_id) OR ($coalbum == 0)){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_iderrorpleasereloadpage
			);

			json($a);
			exit;
		}
		
		//if field empty
		if(empty($date) || empty($album_id)){
			//echo "{,$lg_pleasefillimportant}";
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}

		if(empty($name)){
			$name = "($lg_untitled)";
		}

		$date = explode("/", $date); //mm-dd-yyyy
		$date = $date['2']."-".$date['0']."-".$date[1]; //yyyy-mm-dd
		$seotitle =  seo_title($name);


		$data = array(
			'name' => $name,
			'seotitle' => $seotitle,
			'date' => $date,
			'status' => $status	
			);
		$tbl->Update($data,'album_id',$album_id);
		//header('location:../../admin.php?mod='.$mod);

		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_datainputsuccessful
		);
		json($a);
	}

	//DEL
	elseif($mod=='album' AND $act=='del'){
		$album_id = $v->sql($_POST['album_id']);
		$tablegal = new ElybinTable('elybin_gallery'); //del foto
		
		// check id exist or not
		$tabledel = new ElybinTable('elybin_album');//del album
		$coalbum = $tabledel->GetRow('album_id', $album_id);
		if(empty($album_id) OR ($coalbum == 0)){
			header('location: ../../../404.html');
			exit;
		}
		
		$cimg = $tablegal->SelectWhere('album_id',$album_id,'','');
		foreach($cimg as $i){
			$image = $i->image;
			$fileimage = "../../../elybin-file/gallery/$image";
				if (file_exists("$fileimage")){
					unlink("../../../elybin-file/gallery/$image");
					unlink("../../../elybin-file/gallery/medium-$image");
				}
			$tablegal->Delete('gallery_id', $gallery_id); //del foto
		}

		
		$tabledel->Delete('album_id', $album_id); 

		$tbgal= new ElybinTable('elybin_gallery');
		$delgal = $tbgal->Delete('album_id',$album_id);
		header('location:../../admin.php?mod='.$mod);
	}
	//MULTI DEL
	elseif($mod=='album' AND $act=='multidel'){
		$album_id = $_POST['del'];

		if(!empty($album_id)){
			foreach ($album_id as $tg) {
				$pecah = explode("|",$tg);
				$pecah = $pecah[0];
				$album_id_fix = $v->sql($pecah);
				
				// check id exist or not
				$tabledel = new ElybinTable('elybin_album');//del album
				$coalbum = $tabledel->GetRow('album_id', $album_id_fix);
				if(empty($album_id_fix) OR ($coalbum == 0)){
					header('location: ../../../404.html');
					exit;
				}
		
				$tablegal = new ElybinTable('elybin_gallery'); //del foto
				$cimg = $tablegal->SelectWhere('album_id',$album_id_fix,'','');
				foreach($cimg as $i){
					$image = $i->image;
					$fileimage = "../../../elybin-file/gallery/$image";
						if (file_exists("$fileimage")){
							unlink("../../../elybin-file/gallery/$image");
							unlink("../../../elybin-file/gallery/medium-$image");
						}
					$tablegal->Delete('gallery_id', $gallery_id); //del foto
				}

				//del album
				$tabledel->Delete('album_id', $album_id_fix); 

				$tbgal= new ElybinTable('elybin_gallery');
				$delgal = $tbgal->Delete('album_id',$album_id_fix);
				header('location:../../admin.php?mod='.$mod);
			}
		} // > foreach
	}	
	//404
	else{
		header('location:../../../404.php');
	}
}	
}
?>