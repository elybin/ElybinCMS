<?php
/* Short description for file
 * [ Module: Tag Proccess
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
	include_once('../../lang/main.php');

	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//ADD
	if ($mod=='tag' AND $act=='add'){
		$name = $v->xss($_POST['name']);
		//remove last coma
		$name = rtrim($name,",");

		//if field empty
		if(empty($name)){
			//please fill important
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Please fill important filed (*)')
			);

			echo json_encode($a);
			exit;
		}
		//explode coma
		$pecah = explode(",", $name);
		$total = count($pecah);

		$table = new ElybinTable('elybin_tag');
		for ($i=0; $i<$total; $i++) {
			$tag_name = rtrim(ltrim($pecah[$i]," ")," ");
			$tag_seo = seo_title($tag_name);
			$data = array(
				'name' => $tag_name,  
				'seotitle' => $tag_seo
			);
			$table->Insert($data);
		}
		//Done
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_datainputsuccessful
		);
		echo json_encode($a);
	}
	
	//DEL
	elseif($mod=='tag' AND $act=='del'){
		$tag_id = $v->sql($_POST['tag_id']);
		
		// check id exist or not
		$tbl	= new ElybinTable('elybin_tag');
		$cotag	= $tbl->GetRow('tag_id', $tag_id);
		if(empty($tag_id) OR ($cotag == 0)){
			header('location: ../../../404.html');
			exit;
		}
		
		// search tag on post and delate 
		$tbp = new ElybinTable('elybin_posts');
		$copost = $tbp->GetRow('','');
		if($copost > 0){
			$post = $tbp->SelectCustom("SELECT * FROM", "WHERE `tag` LIKE '%$tag_id%'");
			foreach($post as $p){
				// decode first and search in array
				$posttag = explode(",", $p->tag);
				unset($posttag [array_search($tag_id, $posttag)] );
				$posttag = implode(",", $posttag);
				$tbp->Update(array('tag' => $posttag), 'post_id', $p->post_id);
			}
		}

		$tbl->Delete('tag_id', $tag_id);
		//Done
		header('location:../../admin.php?mod='.$mod);
	}	
	//MULTI DEL
	elseif($mod=='tag' AND $act=='multidel'){
		$tag_id = $_POST['del'];

		if(!empty($tag_id)){
			foreach ($tag_id as $tg) {
				$pecah = explode("|",$tg);
				$pecah = $pecah[0];
				$tag_id_fix = $v->sql($pecah);
				
				// check id exist or not
				$tbl 	= new ElybinTable('elybin_tag');
				$cotag = $tbl->GetRow('tag_id', $tag_id_fix);
				if(empty($tag_id_fix) OR ($cotag == 0)){
					header('location: ../../../404.html');
					exit;
				}
				
				// search tag on post and delate 
				$tbp = new ElybinTable('elybin_posts');
				$copost = $tbp->GetRow('','');
				if($copost > 0){
					$post = $tbp->SelectCustom("SELECT * FROM", "WHERE `tag` LIKE '%$tag_id_fix%'");
					foreach($post as $p){
						// decode first and search in array
						$posttag = explode(",", $p->tag);
						unset($posttag [array_search($tag_id_fix, $posttag)] );
						$posttag = implode(",", $posttag);
						$tbp->Update(array('tag' => $posttag), 'post_id', $p->post_id);
					}
				}

				$tbl->Delete('tag_id', $tag_id_fix);
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