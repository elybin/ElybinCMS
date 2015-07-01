<?php
/* Short description for file
 * [ Module: Settings
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
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
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to access this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	exit;
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
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_name'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_description'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
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
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_phone'){
		$value = htmlspecialchars($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_office_address'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_owner'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_email'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_hero_title'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_hero_subtitle'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='site_coordinate'){
		$value = htmlspecialchars($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='users_can_register'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='default_category'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='default_comment_status'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='posts_per_page'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='default_homepage'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='timezone'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='language'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		// destroy cookie
		@setcookie('lang', '', time()-(60*60*24*30), str_replace('/app/option/proses.php', '', $_SERVER['REQUEST_URI']));
		// set cookie
		@setcookie("lang", $value, time()+(60*60*24*30), str_replace('/app/option/proses.php', '', $_SERVER['REQUEST_URI']));
		// result
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='maintenance_mode'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='developer_mode'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='short_name'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='text_editor'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);
		//header('location:../../admin.php?mod='.$mod);
		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='social_twitter'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='social_facebook'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='social_instagram'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='smtp_host'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='smtp_port'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='smtp_user'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='smtp_pass'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='smtp_status'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
	}
	elseif ($mod=='option' AND $act=='mail_daily_limit'){
		$value = $v->xss($_POST['value']);
		$tbl = new ElybinTable('elybin_options');
		$data = array('value' => $value);
		$tbl->Update($data,'name', $act);

		$a = array(
			'status' => 'ok',
			'title' => lg('Success'),
			'isi' => lg('Changes Saved')
		);
		echo json_encode($a);
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
				unlink("../../../elybin-file/system/md-$image");
			}
		$extensionList = array("jpg", "jpeg","png");
		$fileName = $_FILES['file']['name'];
		$tmpName = $_FILES['file']['tmp_name'];
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
					'title' => lg('Success'),
					'isi' => lg('Changes Saved')
				);
				echo json_encode($a);
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
				unlink("../../../elybin-file/system/md-$image");
			}
		$extensionList = array("jpg", "jpeg","png");
		$fileName = $_FILES['file']['name'];
		$tmpName = $_FILES['file']['tmp_name'];
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
					'title' => lg('Success'),
					'isi' => lg('Changes Saved')
				);
				//echo json_encode($a);
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
				unlink("../../../elybin-file/system/md-$image");
			}
		$extensionList = array("jpg", "jpeg","png");
		$fileName = $_FILES['file']['name'];
		$tmpName = $_FILES['file']['tmp_name'];
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
					'title' => lg('Success'),
					'isi' => lg('Changes Saved')
				);
				//echo json_encode($a);
			}
		}else{
			header('location:../../../404.html');
		}
	}
	//404
	else{
		header('location:../../../404.html');
	}
}

}
?>