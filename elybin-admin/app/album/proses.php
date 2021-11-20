<?php
/* Short description for file
 * [ Module: Album Proccess
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
session_start();
if(empty($_SESSION['login'])){
	header('location:../../../403.php');
}else{
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once('inc/module-function.php');

	// string validation for security
	$v 	= new ElybinValidasi();

	// get usergroup privilage/access from current user to this module
	$usergroup = _ug()->album;

// give error if no have privilage
if($usergroup == 0){
	header('location:../../../403.php');
}else{
	// start here
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//ADD
	if ($mod=='album' AND $act=='add'){
		$aid = sqli_(epm_decode($_POST['aid']));
		$name = xss_($_POST['name']);
		$seotitle =  seo_title($name);
		$image = @$_POST['image'];

		//if field empty
		if(empty($name)){
			$name = lg('Untitled');
			$seotitle =  seo_title($name);
		}

		// checking seo title
		if(!check_seotitle($seotitle, $aid)){
			$seotitle = suggest_unique($seotitle, $aid);
		}

		// basic info
 		$tbp = new ElybinTable('elybin_posts');
		$d1 = array(
			'title' => $name,
			'seotitle' => $seotitle,
			'status' => 'active'
			);
		$tbp->Update($d1,'post_id', $aid);

		// relate images to their album
		$tbr = new ElybinTable('elybin_relation');
		if(!empty($image)){
			foreach($image as $iid){
				$d2 = array(
					'type' => 'album',
					'target' => 'media',
					'first_id' => $aid,
					'second_id' => sqli_(epm_decode($iid))
				);
				$tbr->Insert($d2);
			}
		}


		//Done
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Album created successfully'),
			'callback' => 'edit',
			'callback_hash' => epm_encode($aid),
			'callback_msg' => 'saved'
		);
		echo json_encode($a);
	}
	//EDIT
	elseif($mod=='album' AND $act=='edit'){
		$aid = sqli_(epm_decode(@$_POST['aid']));
		$name = $v->xss(@$_POST['name']);
		$image = @$_POST['image'];

		// if image empty
		if(empty($image)){
			$image = [];
		}

		//if field empty
		if(empty($name)){
			$name = lg('Untitled');
		}

		// basic info
 		$tbp = new ElybinTable('elybin_posts');
		$d1 = array(
			'title' => $name
			);
		$tbp->Update($d1,'post_id', $aid);

		// relate images to their album
		$tbr = new ElybinTable('elybin_relation');
		// delete all related relation
		$tbr->DeleteAnd('type', 'album','first_id',$aid);
		foreach($image as $iid){
			$d2 = array(
				'type' => 'album',
				'target' => 'media',
				'first_id' => $aid,
				'second_id' => $v->sql(epm_decode($iid))
			);
			$tbr->Insert($d2);
		}

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes saved'),
			'callback' => 'edit',
			'callback_hash' => epm_encode($aid),
			'callback_msg' => 'updated'
		);
		echo json_encode($a);
	}
	//EDIT MORE
	elseif($mod=='album' AND $act=='edit_more'){
		$aid = sqli_(epm_decode(@$_POST['aid']));
		$title = xss_(@$_POST['title']);
		$seotitle = xss_($_POST['seotitle']);
		$image = @$_POST['image'];
		$status = xss_(@$_POST['status']);
		$content = html_entity_decode($_POST['content'],ENT_QUOTES);

		// if image empty
		if(empty($image)){
			$image = [];
		}

		//if field empty
		if(empty($title)){
			$title = lg('Untitled');
			$seotitle =  seo_title($title);
		}

		/*
		 * check seo title available or no
		 * @since 1.1.4
		 */
		if(!check_seotitle($seotitle, $aid)){
			$a = array(
				'status' => 'error',
				'title' => __('Error'),
				'isi' => __('SEO title already used, there our suggestion.'),
				'callback' => 'edit',
				'callback_id' => epm_encode($aid),
				'callback_msg' => __('SEO title already used, please check it first.')
			);
			echo json_encode($a);
			exit;
		}

		// basic info
 		$tbp = new ElybinTable('elybin_posts');
		$d1 = array(
			'title' => $title,
			'seotitle' => $seotitle,
			'content' => $content,
			'status' => $status
			);
		$tbp->Update($d1,'post_id', $aid);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes saved'),
			'callback' => 'edit_more',
			'callback_hash' => epm_encode($aid),
			'callback_msg' => 'updated'
		);
		echo json_encode($a);
	}

	//DEL
	// 1.1.3 - updated
	elseif($mod=='album' AND $act=='del'){
		$aid = $v->sql(epm_decode($_POST['hash']));

		// check id exist or not
		$tb 	= new ElybinTable('elybin_posts');
		$cop= $tb->GetRowAnd('post_id', $aid,'type','album');
		if($cop == 0){
			header('location: ../../../404.html');
			exit;
		}
		// delete album
		$tb->DeleteAnd('post_id', $aid,'type','album');

		// delete relaiton
		$tbr = new ElybinTable('elybin_relation');
		$tbr->Delete('first_id',$aid);
		header('location: ../../admin.php?mod=album&msg=deleted');
		exit;
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
		header('location: ../../../404.php');
	}
}
}
?>
