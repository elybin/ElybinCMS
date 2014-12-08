<?php
/* Short description for file
 * [ Module: Settings
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
$usergroup = $tbug->current()->setting;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
}else{
	// start here
	$v = new ElybinValidasi;
	$mod = $_POST['pk'];
	$act = $_POST['name'];

	//UPDATE
	if ($mod=='option' AND $act=='site_url'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_name'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_description'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_keyword'){
		$value = $_POST['value'];
		$v = implode(", ", $value);
		$v = rtrim($v, ", ");
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $v);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_phone'){
		$value = htmlspecialchars($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_office_address'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_owner'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_email'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_hero_title'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_hero_subtitle'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_coordinate'){
		$value = htmlspecialchars($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='users_can_register'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='default_category'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='default_comment_status'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='posts_per_page'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='timezone'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='language'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='maintenance_mode'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='developer_mode'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='short_name'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='text_editor'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}
	elseif ($mod=='option' AND $act=='site_logo'){
		$tbl = new ElybinTable('elybin_options');
		$cimg = $tbl->SelectWhere('name',$act,'','');
		foreach($cimg as $i){
			$image = $i->value;
		}
		$fileimage = "../../../elybin-file/system/$image";
			if (file_exists("$fileimage")){
				unlink("../../../elybin-file/system/$image");
				unlink("../../../elybin-file/system/medium-$image");
			}
		$extensionList = array("jpg", "jpeg","png");
		$fileName = $_FILES['image']['name'];
		$tmpName = $_FILES['image']['tmp_name'];
		$pecah = explode(".", $fileName);
		$ekstensi = $pecah[1];
		$image = "logo.$ekstensi";
		if(!empty($tmpName)){
			if (in_array($ekstensi, $extensionList)){
				UploadImage($image,'system');
				$data = array('value' => $image);
				$tbl->Update($data,'name', $act);
				header('location:../../admin.php?mod='.$mod);
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_dataeditsuccessful
				);
				json($a);
			}
		}else{
			echo '404';
			header('location:../../../404.php');
		}
	}
	elseif ($mod=='option' AND $act=='site_favicon'){
		$tbl = new ElybinTable('elybin_options');
		$cimg = $tbl->SelectWhere('name',$act,'','');
		foreach($cimg as $i){
			$image = $i->value;
		}
		$fileimage = "../../../elybin-file/system/$image";
			if (file_exists("$fileimage")){
				unlink("../../../elybin-file/system/$image");
				unlink("../../../elybin-file/system/medium-$image");
			}
		$extensionList = array("jpg", "jpeg","png");
		$fileName = $_FILES['image']['name'];
		$tmpName = $_FILES['image']['tmp_name'];
		$pecah = explode(".", $fileName);
		$ekstensi = $pecah[1];
		$image = "favicon.$ekstensi";
		if(!empty($tmpName)){
			if (in_array($ekstensi, $extensionList)){
				UploadImage($image,'system');
				$data = array('value' => $image);
				$tbl->Update($data,'name', $act);
				header('location:../../admin.php?mod='.$mod);
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_dataeditsuccessful
				);
				//json($a);
			}
		}else{
			echo '404';
			header('location:../../../404.php');
		}
	}
	elseif ($mod=='option' AND $act=='site_hero'){
		$tbl = new ElybinTable('elybin_options');
		$cimg = $tbl->SelectWhere('name',$act,'','');
		foreach($cimg as $i){
			$image = $i->value;
		}
		$fileimage = "../../../elybin-file/system/$image";
			if (file_exists("$fileimage")){
				unlink("../../../elybin-file/system/$image");
				unlink("../../../elybin-file/system/medium-$image");
			}
		$extensionList = array("jpg", "jpeg","png");
		$fileName = $_FILES['image']['name'];
		$tmpName = $_FILES['image']['tmp_name'];
		$pecah = explode(".", $fileName);
		$ekstensi = $pecah[1];
		$image = "heroimg.$ekstensi";
		if(!empty($tmpName)){
			if (in_array($ekstensi, $extensionList)){
				UploadImage($image,'system');
				$data = array('value' => $image);
				$tbl->Update($data,'name', $act);
				header('location:../../admin.php?mod='.$mod);
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_dataeditsuccessful
				);
				//json($a);
			}
		}else{
			echo '404';
			header('location:../../../404.php');
		}
	}
	//404
	else{
		echo '404';
		header('location:../../../404.php');
	}
}

}
?>