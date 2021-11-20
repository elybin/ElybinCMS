<?php
/* Short description for file
 * [ Module: Category proccess
 *	
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
-----------------
v.1.1.3 
- Delete Related Comment
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
	if ($mod=='category' AND $act=='add'){
		$name = $v->xss($_POST['name']);
		if(empty($name)){
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Please fill important field (*)')
			);

			echo json_encode($a);
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
		
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Data saved successfully.')
		);
		echo json_encode($a);
		exit;
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
				'title' => lg('Error'),
				'isi' => lg('ID mismatch, please reload page')
			);
			echo json_encode($a);
			exit;
		}
		
		if(empty($name)){
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Please fill important field (*)')
			);

			echo json_encode($a);
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
			'title' => lg('Success'),
			'isi' => lg('Changes saved')
		);
		echo json_encode($a);
		exit;
	}

	//DEL
	elseif($mod=='category' AND $act=='del'){
		$category_id = $v->sql($_POST['category_id']);

		// check id exist or not
		$tbl 	= new ElybinTable('elybin_category');
		$cocat = $tbl->GetRow('category_id', $category_id);
		if(empty($category_id) OR ($cocat == 0)){
			red('../../../404.html');
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
				// 1.1.3
				//get related post
				$related_post = $tbp->SelectFullCustom("
				SELECT
				*
				FROM
				`elybin_posts` as `p`
				WHERE
				`p`.`category_id` = $category_id
				");
				
				// delete related comment
				$tbco 	= new ElybinTable('elybin_comments');
				foreach($related_post as $rp){
					$coco = $tbco->GetRow('post_id', $rp->post_id);
					if($coco > 0){
						$tbco->Delete('post_id', $rp->post_id);
					}
						
					// delete post
					$tbp->Delete('post_id', $rp->post_id);
						
					// delete revision of post
					$tbp->Delete('parent', $rp->post_id);
				}
			}
			
		}
		// delete category
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
						// 1.1.3
						//get related post
						$related_post = $tbp->SelectFullCustom("
						SELECT
						*
						FROM
						`elybin_posts` as `p`
						WHERE
						`p`.`category_id` = $category_id_fix
						");
						
						// delete related comment
						$tbco 	= new ElybinTable('elybin_comments');
						foreach($related_post as $rp){
							$coco = $tbco->GetRow('post_id', $rp->post_id);
							if($coco > 0){
								$tbco->Delete('post_id', $rp->post_id);
							}
								
							// delete post
							$tbp->Delete('post_id', $rp->post_id);
								
							// delete revision of post
							$tbp->Delete('parent', $rp->post_id);
						}
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