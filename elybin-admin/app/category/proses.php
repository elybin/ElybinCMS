<?php
/* Short description for file
 * [ Module: Category proccess
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
if(empty($_SESSION['login'])){	
	echo '403';
	header('location:../../../403.php');
}else{

	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once('../../lang/main.php');

	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//ADD
	if ($mod=='category' AND $act=='add'){
		$name = $v->xss($_POST['name']);
		if(empty($name)){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}
		$seotitle =  seo_title($name);

		$tbl = new ElybinTable('elybin_category');
		$data = array(
			'name' => $name,
			'seotitle' => $seotitle,
			'status' => 'active'	
			);
		$tbl->Insert($data);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_datainputsuccessful
		);
		json($a);
	}
	//EDIT
	elseif($mod=='category' AND $act=='edit'){
		$category_id = $v->sql($_POST['category_id']);
		$name = $v->xss($_POST['name']);
		
		// check id exist or not
		$tbl 	= new ElybinTable('elybin_category');
		$cocat = $tbl->GetRow('category_id', $category_id);
		if(empty($category_id) OR ($cocat == 0)){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_iderrorpleasereloadpage
			);
			json($a);
			exit;
		}
		
		if(empty($name)){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}
		
		$status = $v->xss(@$_POST['status']);
		if($status == "on"){
			$status = "active";
		}else{
			$status = "deactive";
		}
		$seotitle =  seo_title($name);

		$data = array(
			'name' => $name,
			'seotitle' => $seotitle,
			'status' => $status	
			);
		$tbl->Update($data,'category_id',$category_id);
		
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}

	//DEL
	elseif($mod=='category' AND $act=='del'){
		$category_id = $v->sql($_POST['category_id']);

		// check id exist or not
		$tbl 	= new ElybinTable('elybin_category');
		$cocat = $tbl->GetRow('category_id', $category_id);
		if(empty($category_id) OR ($cocat == 0)){
			header('location: ../../../404.html');
			exit;
		}
		
		// if just move
		if(isset($_POST['move']) AND $_POST['move'] == "yes"){
			$tbp 	= new ElybinTable('elybin_posts');
			$cop = $tbp->GetRow('category_id', $category_id);
			if($cop > 0){
				// get default category
				$tbop = new ElybinTable('elybin_options');  
				$default_category = $tbop->SelectWhere('name','default_category','','')->current()->value; 
				$data = array(
					'category_id' => $default_category 
				);
				$tbp->Update($data, 'category_id', $category_id);
			}
		}
		// if delete all post related
		elseif(isset($_POST['delete']) AND $_POST['delete'] == "yes"){
			$tbp 	= new ElybinTable('elybin_posts');
			$cop = $tbp->GetRow('category_id', $category_id);
			if($cop > 0){
				$tbp->Delete('category_id', $category_id);
			}
		}
		
		$tbl->Delete('category_id', $category_id);
		header('location: ../../admin.php?mod='.$mod);
	}	
	//MULTI DEL
	elseif($mod=='category' AND $act=='multidel'){
		$category_id = $_POST['del'];

		if(isset($category_id)){
			foreach ($category_id as $cat) {
				$pecah = explode("|",$cat);
				$pecah = $pecah[0];
				$category_id_fix = $v->sql($pecah);
				
				// check id exist or not
				$tbl 	= new ElybinTable('elybin_category');
				$cocat = $tbl->GetRow('category_id', $category_id_fix);
				if($cocat == 0){
					header('location: ../../../404.html');
					exit;
				}
				
				// if moved
				if(isset($_POST['move']) AND $_POST['move'] == "yes"){
					$tbp 	= new ElybinTable('elybin_posts');
					$cop = $tbp->GetRow('category_id', $category_id_fix);
					if($cop > 0){
						// get default category
						$tbop = new ElybinTable('elybin_options');  
						$default_category = $tbop->SelectWhere('name','default_category','','')->current()->value; 
						$data = array(
							'category_id' => $default_category 
						);
						$tbp->Update($data, 'category_id', $category_id_fix);
					}
				}
				// if delete all post related
				elseif(isset($_POST['delete']) AND $_POST['delete'] == "yes"){
					$tbp 	= new ElybinTable('elybin_posts');
					$cop = $tbp->GetRow('category_id', $category_id_fix);
					if($cop > 0){
						$tbp->Delete('category_id', $category_id_fix);
					}
				}
				
				$tbl->Delete('category_id', $category_id_fix);
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