<?php
/* Short description for file
 * [ Module: Setting - Menu manager Proccess
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

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->setting;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	exit;
}else{
	// start here
	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//SAVE
	if ($mod=='menumanager' AND $act=='save'){
		$list = $_POST['neworder'];

		$pecah = explode(",", $list);
		$total = count($pecah);

		for($i=0; $i<$total;  $i++){
			$tbl = new ElybinTable('elybin_menu');
			$data = array(
				'menu_position' => $i+1
			);
			$tbl->UpdateAndNot($data,'menu_id',$pecah[$i],'parent_id','0');
		}
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('New menu order saved')
		);
		echo json_encode($a);
		exit;
	}
	//ADD
	elseif ($mod=='menumanager' AND $act=='add'){
		$title = $v->xss($_POST['title']);
		$url = htmlspecialchars_decode($_POST['url']);
		$parent = $v->xss($_POST['parent_id']);
		$class = $v->xss($_POST['class']);

		//if field empty
		if(empty($title) || empty($url)){
			//echo "{,lg('Please fill important field (*)')}";
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Please fill important field (*)')
			);

			echo json_encode($a);
			exit;
		}

		$tbl = new ElybinTable('elybin_menu');

		// wnt create  with parent (parent_id 16)
		//
		//			-X- parent_id: 16 / menu_id: X  (Want to create)  << maximum (sub sub sub menu) = >denied
		//
		//	 	- parent_id: 15 / menu_id: 16 (Sub Sub Menu)
		//	 - parent_id: 14 (Sub Menu)
		// - parent_id: 0 (Menu)

		//if not parent
		if($parent>0){  //16
			// get parent_id from menu_id = 16
			$checksub2 = $tbl->SelectWhere('menu_id',$parent,'','');
			//  menu_id 	parent_id 	menu_title 		menu_url 	menu_class 	menu_position
			//  16 				15 		Sub Sub Menu 	MAX
			$parentsub1 = $checksub2->current()->parent_id; // parent_id = 15

			// count row that contain parent_id = 15
			$csub2 = $tbl->GetRow('parent_id',$parentsub1); //2
			//  menu_id 	parent_id 	menu_title 		menu_url 	menu_class 	menu_position
			//	16 				15 		Sub Sub Menu 	MAX 						12
			//	17 				15 		Sub Sub Menu 2 	MAX 						13

			if($csub2>0){ // 2
				$checksub1 = $tbl->SelectWhere('menu_id',$parentsub1,'','');
				//  menu_id 	parent_id 	menu_title 		menu_url 	menu_class 	menu_position
				//	15 				14 		Sub Menu 		sub-menu 					11
				foreach ($checksub1 as $s1) {
					if($s1->parent_id>0){ //parent_id = 14
						//give error code
						$a = array(
							'status' => 'error',
							'title' => lg('Error'),
							'isi' => lg('You can\'t create to many submenu')
						);
						echo json_encode($a);
						exit;
					}

				}
			}

		}

		// getting lastest id
		$menu2 = $tbl->SelectLimit('menu_id','DESC','0,1');
		$menu_id = 1;
		foreach ($menu2 as $ps) {
			$menu_id = $ps->menu_id + 1;
		}
		// getting larger position
		$menu3 = $tbl->SelectLimit('menu_position','DESC','0,1');
		$menu_position = 1;
		foreach ($menu3 as $ps) {
			$menu_position = $ps->menu_position + 1;
		}

		$data = array(
			'menu_id' => $menu_id,
			'menu_title' => $title,
			'menu_url' => $url,
			'menu_class' => $class,
			'parent_id' => $parent,
			'menu_position' => $menu_position
		);
		$tbl->Insert($data);


		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('New menu created successfully.')
		);
		echo json_encode($a);
	}
	//EDIT
	elseif ($mod=='menumanager' AND $act=='edit'){
		$id = $v->sql($_POST['id']);
		$title = xss_($_POST['title'])	;
		$url = htmlspecialchars_decode($_POST['url']);
		$parent = $v->xss($_POST['parent_id']);
		$class = $v->xss($_POST['class']);

		// check id exist or not
		$tbl 	= new ElybinTable('elybin_menu');
		$comenu = $tbl->GetRow('menu_id', $id);
		if(empty($id) OR ($comenu == 0)){
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('ID mismatch, please reload page')
			);

			echo json_encode($a);
			exit;
		}

		//if field empty
		if(empty($title) || empty($url)){
			//echo "{,lg('Please fill important field (*)')}";
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Please fill important field (*)')
			);

			echo json_encode($a);
			exit;
		}

		// wnt create  with parent (parent_id 16)
		//
		//			-X- parent_id: 16 / menu_id: X  (Want to create)  << maximum (sub sub sub menu) = >denied
		//
		//	 	- parent_id: 15 / menu_id: 16 (Sub Sub Menu)
		//	 - parent_id: 14 (Sub Menu)
		// - parent_id: 0 (Menu)

		//if not parent
		if($parent>0){  //16
			// get parent_id from menu_id = 16
			$checksub2 = $tbl->SelectWhere('menu_id',$parent,'','');
			//  menu_id 	parent_id 	menu_title 		menu_url 	menu_class 	menu_position
			//  16 				15 		Sub Sub Menu 	MAX
			$parentsub1 = $checksub2->current()->parent_id; // parent_id = 15

			// count row that contain parent_id = 15
			$csub2 = $tbl->GetRow('parent_id',$parentsub1); //2
			//  menu_id 	parent_id 	menu_title 		menu_url 	menu_class 	menu_position
			//	16 				15 		Sub Sub Menu 	MAX 						12
			//	17 				15 		Sub Sub Menu 2 	MAX 						13

			if($csub2>0){ // 2
				$checksub1 = $tbl->SelectWhere('menu_id',$parentsub1,'','');
				//  menu_id 	parent_id 	menu_title 		menu_url 	menu_class 	menu_position
				//	15 				14 		Sub Menu 		sub-menu 					11
				foreach ($checksub1 as $s1) {
					if($s1->parent_id>0){ //parent_id = 14
						//give error code
						$a = array(
							'status' => 'error',
							'title' => lg('Error'),
							'isi' => lg('You can\'t create to many submenu')
						);
						echo json_encode($a);
						exit;
					}

				}
			}

		}

		$data = array(
			'menu_title' => $title,
			'menu_url' => $url,
			'menu_class' => $class,
			'parent_id' => $parent
		);
		$tbl->Update($data,'menu_id',$id);


		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
		exit;
	}
	//DEL
	elseif($mod=='menumanager' AND $act=='del'){
		$id = $v->sql($_POST['id']);
		$back = $v->sql($_POST['back']);

		// check id exist or not
		$tbl = new ElybinTable('elybin_menu');
		$comenu = $tbl->GetRow('menu_id', $id);
		if(empty($id) OR ($comenu == 0)){
			header('location: ../../../404.html');
			exit;
		}

		//check if menu have sub menu1
		$tbsub1 = new ElybinTable('elybin_menu');
		$csub1 = $tbsub1->GetRow('parent_id',$id); //1
		$sub1 = $tbsub1->SelectWhere('parent_id',$id,'','')->current();

			//if C > 1
			if($csub1>0){
				//get menu with parent sub $id
				$tbsub2 = new ElybinTable('elybin_menu');
				$csub2 = $tbsub2->GetRow('parent_id',$sub1->menu_id); //1

				//if
				if($csub2>0){
					// delete sub sub menu
					$csub2 = $tbsub2->Delete('parent_id',$sub1->menu_id);
				}

				//delete current sub
				$csub1 = $tbsub1->Delete('parent_id',$id);
			}

		//delete current menu
		$tabledel = new ElybinTable('elybin_menu');
		$tabledel->Delete('menu_id', $id);

		if(!empty($back)){
			$mod = $mod."&act=edit&id=$back";
		}
		header('location:../../admin.php?mod='.$mod);
	}

	//404
	else{
		header('location:../../../404.html');
	}
}
}
?>
