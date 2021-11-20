<?php
/* Short description for file
 * [ Module: Usergroup Proccess
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
	include_once('../../lang/main.php');

	// @since 1.1.3
	// only root user can create ug
	$u = _u(); 

// give error if no have privilage
if($u->user_id != 1){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	exit;
}else{
	// start here
	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];
	$access_name = array("post","category","tag","comment","media","album","page","user","setting");

	//ADD
	if ($mod=='usergroup' AND $act=='add'){
		$name = $v->xss($_POST['name']);
		$alias = $v->xss($_POST['alias']);
		
		//if field empty
		if(empty($name) || empty($alias)){
			//echo "{,lg('Please fill important field (*)')}";
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Please fill important field (*)')
			);

			echo json_encode($a);
			exit;
		}


		$tbl = new ElybinTable('elybin_usergroup');
		$data = array(
			'name' => $name,
			'alias' => $alias	
			);

		// menu privilages 
		foreach ($access_name as $an) {
			$priv = "privilege_".$an;
			if(!isset($_POST[$priv])){
				$data[$an] = "0";
			}else{
				$data[$an] = "1";
			}
		}

		// plugin privilages
		// getting array of plugin id
		$tbpl = new ElybinTable('elybin_plugins');
		$plugin_list = $tbpl->SelectWhere('status','active','','');

		foreach ($plugin_list as $pll) {
			$pl_post = "plugin_".$pll->plugin_id; 

			// do if post value set or checked
			if(isset($_POST[$pl_post])){
				// check if usergroup of plugin empty
				if($pll->usergroup==""){
					$plugin_saved = $usergroup_id;
				}else{
					$plugin_saved = $pll->usergroup.",".$usergroup_id; 
				}
				// create array and save
				$plugin_data = array(
					'usergroup' => $plugin_saved
				);
				// Save it
				$tbpl->Update($plugin_data,'plugin_id',$pll->plugin_id);
			}
		}

		$tbl->Insert($data);
		// Done
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Usergroup created')
		);
		echo json_encode($a);
	}
	//EDIT
	elseif($mod=='usergroup' AND $act=='edit'){
		$usergroup_id = $v->sql($_POST['usergroup_id']);
		$name = $v->xss($_POST['name']);
		$alias = $v->xss($_POST['alias']);

		// olny root user can make new su/ad user
		if($u->user_id != 1 OR $usergroup_id == 1){
			header('location: ../../../404.html');
			exit;
		}
		
		// check id exist or not
		$tbl 	= new ElybinTable('elybin_usergroup');
		$cousergroup = $tbl->GetRow('usergroup_id', $usergroup_id);
		if(empty($usergroup_id) OR ($cousergroup == 0)){
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('ID mismatch, please reload page')
			);

			echo json_encode($a);
			exit;
		}

		//if field empty
		if(empty($name) || empty($alias) || empty($usergroup_id)){
			//echo "{,lg('Please fill important field (*)')}";
			$a = array(
				'status' => 'error',
				'title' => lg('Error'),
				'isi' => lg('Please fill important field (*)')
			);

			echo json_encode($a);
			exit;
		}	
		// usergroup privilages
		$data = array(
			'name' => $name,
			'alias' => $alias
			);
		foreach ($access_name as $an) {
			$priv = "privilege_".$an;
			if(!isset($_POST[$priv])){
				$data[$an] = "0";
			}else{
				$data[$an] = "1";
			}
		}

		// plugin privilages
		// getting array of plugin id
		$tbpl = new ElybinTable('elybin_plugins');
		$plugin_list = $tbpl->SelectWhere('status','active','','');

		foreach ($plugin_list as $pll) {
			$pl_post = "plugin_".$pll->plugin_id; 

			// do if post value set or checked
			if(isset($_POST[$pl_post])){
				
				// verify first that id not added
				$plugin_saved = explode(",", $pll->usergroup); 
				if (array_search($usergroup_id, $plugin_saved) !== true) {

					// check if usergroup of plugin empty
					if($pll->usergroup==""){
						$plugin_saved = $usergroup_id;
					}else{
						$plugin_saved = explode(",", $pll->usergroup);
						if (($key = array_search($usergroup_id, $plugin_saved)) == false) {
						    array_push($plugin_saved, $usergroup_id); // push current usergroup id
						}
						$plugin_saved = implode(",", $plugin_saved);
					}
					// create array and save
					$plugin_data = array(
						'usergroup' => $plugin_saved
					);
					// Save it
					$tbpl->Update($plugin_data,'plugin_id',$pll->plugin_id);

				}
			}else{
				// check if usergroup of plugin empty
				if($pll->usergroup!=""){
					$plugin_saved = explode(",", $pll->usergroup);
					if (($key = array_search($usergroup_id, $plugin_saved)) !== false) {
					    unset($plugin_saved[$key]); // unset matched usergroup id
					}
					$plugin_saved = implode(",", $plugin_saved);
				}
				// create array and save
				$plugin_data = array(
					'usergroup' => $plugin_saved
				);
				// Save it
				$tbpl->Update($plugin_data,'plugin_id',$pll->plugin_id);
			}
		}

		$tbl->Update($data,'usergroup_id',$usergroup_id);
		//Done 
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes saved')
		);
		echo json_encode($a);
	}

	//DEL
	elseif($mod=='usergroup' AND $act=='del'){
		$usergroup_id = $v->sql($_POST['usergroup_id']);
		$tabledel = new ElybinTable('elybin_usergroup');
		
		// olny root user can make new su/ad user
		if($tbus->user_id != 1 OR $usergroup_id == 1){
			header('location: ../../../404.html');
			exit;
		}
		
		// check id exist or not
		$cousergroup = $tabledel->GetRow('usergroup_id', $usergroup_id);
		if(empty($usergroup_id) OR ($cousergroup == 0)){
			header('location: ../../../404.html');
			exit;
		}


		$tabledel->Delete('usergroup_id', $usergroup_id);

		// delete plugin relation
		// getting array of plugin id
		$tbpl = new ElybinTable('elybin_plugins');
		$plugin_list = $tbpl->SelectWhere('status','active','','');

		foreach ($plugin_list as $pll) {
			// check if usergroup of plugin empty
			$plugin_saved = explode(",", $pll->usergroup);
			if (($key = array_search($usergroup_id, $plugin_saved)) !== false) {
				unset($plugin_saved[$key]); // unset matched usergroup id
			}
			$plugin_saved = implode(",", $plugin_saved);

			// create array and save
			$plugin_data = array(
				'usergroup' => $plugin_saved
			);
			// Save it
			$tbpl->Update($plugin_data,'plugin_id',$pll->plugin_id);
		}
		
		// Done
		header('location:../../admin.php?mod='.$mod);
	}	
	//MULTI DEL
	elseif($mod=='usergroup' AND $act=='multidel'){
		$usergroup_id = $_POST['del'];
		
		// olny root user can make new su/ad user
		if($tbus->user_id != 1){
			header('location: ../../../404.html');
			exit;
		}
		
		if(!empty($usergroup_id)){
			foreach ($usergroup_id as $cat) {
				$pecah = explode("|",$cat);
				$pecah = $pecah[0];
				$usergroup_id_fix = $v->xss($pecah,'sql');
				$tabledel = new ElybinTable('elybin_usergroup');

				// check id exist or not
				$cousergroup = $tabledel->GetRow('usergroup_id', $usergroup_id_fix);
				if(empty($usergroup_id) OR ($cousergroup == 0) OR $usergroup_id_fix == 1){
					header('location: ../../../404.html');
					exit;
				}

				$tabledel->Delete('usergroup_id', $usergroup_id_fix);

				// delete plugin relation
				// getting array of plugin id
				$tbpl = new ElybinTable('elybin_plugins');
				$plugin_list = $tbpl->SelectWhere('status','active','','');

				foreach ($plugin_list as $pll) {
					// check if usergroup of plugin empty
					$plugin_saved = explode(",", $pll->usergroup);
					if (($key = array_search($usergroup_id_fix, $plugin_saved)) !== false) {
						unset($plugin_saved[$key]); // unset matched usergroup id
					}
					$plugin_saved = implode(",", $plugin_saved);

					// create array and save
					$plugin_data = array(
						'usergroup' => $plugin_saved
					);
					// Save it
					$tbpl->Update($plugin_data,'plugin_id',$pll->plugin_id);
				}
				
				// Done
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
