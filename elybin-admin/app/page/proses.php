<?php
/* Short description for file
 * [ Module: Page Proccess
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
	if ($mod=='page' AND $act=='add'){
		$title = $v->xss($_POST['title']);
		$content = htmlspecialchars($_POST['content'],ENT_QUOTES);
		$seotitle =  seo_title($title);

		//untitled
		if(empty($title)){
			$title = "($lg_untitled)";
			$seotitle = seo_title($title);
		}
		elseif(empty($content)){
			$content = "<p></p>";
		}	

		//get lastest page id
		$tbpage = new ElybinTable('elybin_pages');
		$page2 = $tbpage->SelectLimit('page_id','DESC','0,1');
		$page_id = 1;
		foreach ($page2 as $pg) {
			$page_id = $pg->page_id + 1;
		}

		//with image
		if(!empty($_FILES['image']['tmp_name'])){
			$extensionList = array("jpg", "jpeg");
			$fileName = $_FILES['image']['name'];
			$tmpName = $_FILES['image']['tmp_name'];
			$pecah = explode(".", $fileName);
			$ekstensi = @$pecah[1];
			$rand = rand(1111,9999);
			$nama_file_unik = $rand."-".$seotitle.'.'.$ekstensi;
			$image = 'image-'.$nama_file_unik;

			if (in_array($ekstensi, $extensionList)){
				UploadImage($image,'page');
				$tbl = new ElybinTable('elybin_pages');
				$data = array(
					'page_id' => $page_id,
					'title' => $title,
					'content' => $content,
					'seotitle' => $seotitle,
					'image' => $image,
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
			}else{
				//image extension deny
				$a = array(
					'status' => 'error',
					'title' => $lg_error,
					'isi' => $lg_fileextensiondeny
				);
				json($a);
			}
		}else{
			//without image
			$tbl = new ElybinTable('elybin_pages');
			$data = array(
				'page_id' => $page_id,
				'title' => $title,
				'content' => $content,
				'seotitle' => $seotitle,
				'status' => 'active'
			);
			$tbl->Insert($data);
			
			
			// insert link to menu	
			$tbm = new ElybinTable('elybin_menu');
			// getting larger position
			$menu3 = $tbm->SelectLimit('menu_position','DESC','0,1');
			$menu_position = 1;
			foreach ($menu3 as $ps) {
				$menu_position = $ps->menu_position + 1;
			}
			$data = array(
				'menu_title' => $title,
				'menu_url' => "page-$page_id-$seotitle.html",
				'parent_id' => 0,
				'menu_position' => $menu_position
			);
			$tbm->Insert($data);
		
			//Done
			$a = array(
				'status' => 'ok',
				'title' => $lg_success,
				'isi' => $lg_datainputsuccessful
			);
			json($a);
		}
	}
	//EDIT
	elseif($mod=='page' AND $act=='edit'){
		$page_id = $v->sql($_POST['page_id']);
		$title = $v->xss($_POST['title']);
		$content = htmlspecialchars($_POST['content'],ENT_QUOTES);
		$seotitle =  seo_title($title);
		$status = @$_POST['status'];
		if($status == "on"){
			$status = "active";
		}else{
			$status = "deactive";
		}

		// check id exist or not
		$tbl = new ElybinTable('elybin_pages');
		$copage = $tbl->GetRow('page_id', $page_id);
		if(empty($page_id) OR ($copage == 0)){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_iderrorpleasereloadpage
			);

			json($a);
			exit;
		}

		//untitled
		if(empty($title)){
			$title = "($lg_untitled)";
			$seotitle = seo_title($title);
		}
		elseif(empty($content)){
			$content = "<p></p>";
		}	

		//with images
		if(!empty($_FILES['image']['tmp_name'])){
			$extensionList = array("jpg", "jpeg");
			$fileName = $_FILES['image']['name'];
			$tmpName = $_FILES['image']['tmp_name'];
			$fileType = $_FILES['image']['type'];
			$fileSize = $_FILES['image']['size'];
			$pecah = explode(".", $fileName);
			$ekstensi = $pecah[1];
			$rand = rand(1111,9999);
			$nama_file_unik = $rand."-".$seotitle.'.'.$ekstensi;
			$image = 'image-'.$nama_file_unik;

			//get previous images
			$tblim = new ElybinTable('elybin_pages');
			$image_lama = $tblim->SelectWhere('page_id',$page_id,'','');
			$image_lama = $image_lama->current()->image;

			//check extesion
			if (in_array($ekstensi, $extensionList)){
				$fileimage_lama = "../../../elybin-file/page/$image_lama";
				if (file_exists("$fileimage_lama") AND ($image_lama!="")){
					unlink("../../../elybin-file/page/$image_lama");
					unlink("../../../elybin-file/page/medium-$image_lama");
				}
				//upload images
				UploadImage($image,'page');
				$data = array(
					'title' => $title,
					'content' => $content,
					'seotitle' => $seotitle,
					'image' => $image,
					'status' => $status
				);
				$tbl->Update($data,'page_id',$page_id);

				//Done
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_dataeditsuccessful
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
		//without images
		}else{
			
			$data = array(
				'title' => $title,
				'content' => $content,
				'seotitle' => $seotitle,
				'status' => $status
			);
			$tbl->Update($data,'page_id',$page_id);
			
			//Done
			$a = array(
				'status' => 'ok',
				'title' => $lg_success,
				'isi' => $lg_dataeditsuccessful
			);
			json($a);
		}

	}

	//DEL
	elseif($mod=='page' AND $act=='del'){
		$page_id = $v->sql($_POST['page_id']);

		// check id exist or not
		$tbl = new ElybinTable('elybin_pages');
		$copage = $tbl->GetRow('page_id', $page_id);
		if(empty($page_id) OR ($copage == 0)){
			header('location: ../../../404.html');
			exit;
		}
		
		//get images filename
		$cimg = $tbl->SelectWhere('page_id',$page_id,'','')->current();
		$image = $cimg->image;
		$seotitle = $cimg->seotitle;

		$fileimage = "../../../elybin-file/page/$image";
			if (file_exists("$fileimage") AND ($image!="")){
				unlink("../../../elybin-file/page/$image");
				unlink("../../../elybin-file/page/medium-$image");
			}
		$tbl->Delete('page_id', $page_id);
		
		// delete related link
		$tbm = new ElybinTable("elybin_menu");
		$comenu = $tbm->GetRowCustom("`menu_url` LIKE '%page-$page_id-$seotitle.html%'");
		if($comenu > 0){
			$menu = $tbm->SelectCustom("SELECT * FROM","WHERE `menu_url` LIKE '%page-$page_id-$seotitle.html%'")->current();
			$tbm->Delete('menu_id', $menu->menu_id);
		}
		
		//Done
		header('location: ../../admin.php?mod='.$mod);
	}		
	//MULTI DEL
	elseif($mod=='page' AND $act=='multidel'){
		//array of delected post
		$page_id = $_POST['del'];

		//if id array empty
		if(!empty($page_id)){
			foreach ($page_id as $pg) {
				// explode data because we use pipe
				$pecah = explode("|",$pg);
				$pecah = $pecah[0];
				// check id safe from sqli
				$page_id_fix = $v->sql($pecah);

				// check id exist or not
				$tbl = new ElybinTable('elybin_pages');
				$copage = $tbl->GetRow('page_id', $page_id_fix);
				if(empty($page_id_fix) OR ($copage == 0)){
					header('location: ../../../404.html');
					exit;
				}

				$img = $tbl->SelectWhere('page_id',$page_id_fix,'','')->current();
				$seotitle = $img->seotitle;
				$pageimg = $img->image;
				
				$filepage = "../../../elybin-file/page/$pageimg";
				if (file_exists("$filepage")  AND ($pageimg!="")){
					unlink("../../../elybin-file/page/$pageimg");
					unlink("../../../elybin-file/page/medium-$pageimg");
				}
				$tbl->Delete('page_id', $page_id_fix);
				
				// delete related link
				$tbm = new ElybinTable("elybin_menu");
				$comenu = $tbm->GetRowCustom("`menu_url` LIKE '%page-$page_id_fix-$seotitle.html%'");
				if($comenu > 0){
					$menu = $tbm->SelectCustom("SELECT * FROM","WHERE `menu_url` LIKE '%page-$page_id_fix-$seotitle.html%'")->current();
					$tbm->Delete('menu_id', $menu->menu_id);
				}
				
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