<?php
/* Short description for file
 * [ Module: User Proccess
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

	settzone();

// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','')->current();
$level = $tbus->level; // getting level from curent user

$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
$usergroup = $tbug->current()->user;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
}else{
	// start here
	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//ADD
	if ($mod=='user' AND $act=='add'){
		$username = $v->xss($_POST['username']);
		$password = md5($_POST['password']);
		$fullname = $v->xss($_POST['fullname']);
		$email 	= $v->xss($_POST['email']);
		$phone = $v->xss($_POST['phone']);
		$level = $v->xss($_POST['level']);
		$avatar = "default/no-ava.png";
		$reg = now();

		//if field empty
		if(empty($username) || empty($password) || empty($fullname) || empty($email) || empty($level)){
			//echo "{,$lg_pleasefillimportant}";
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}
		elseif(empty($phone)){
			$phone = "-";
		}	
		
		// olny root user can make new su/ad user
		if($tbus->user_id != 1 AND $level == 1){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_iderrorpleasereloadpage
			);

			json($a);
			exit;
		}
		
		//check username available
		$tbl = new ElybinTable('elybin_users');
		$userc = 0;
		$userc = $tbl->GetRow('user_account_login', $username);
		//if user already taken
		if($userc>=1){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_useralreadytaken
			);

			json($a);
			exit;
		}
		//get lastest id
		$user3 = $tbl->SelectLimit('user_id','DESC','0,1');
		$user_id = 1;
		foreach ($user3 as $usr) {
			$user_id = $usr->user_id + 1;
		}
		//write it
		$tbl = new ElybinTable('elybin_users');
		$data = array(
			'user_id' => $user_id,
			'user_account_login' => $username,
			'user_account_pass' => $password,
			'user_account_email' => $email,
			'fullname' => $fullname,
			'phone' => $phone,
			'avatar' => $avatar,
			'registered' => $reg,
			'level' => $level,
			'session' => 'offline'
		);
		$tbl->Insert($data);

		//get current user session for notification
		$s = $_SESSION['login'];
		$tblu = new ElybinTable("elybin_users");
		$tblu = $tblu->SelectWhere("session","$s","","");
		$tblu = $tblu->current();
		//get level 
		$tblug = new ElybinTable('elybin_usergroup');
		$tblug = $tblug->SelectWhere('usergroup_id',$level,'','');
		$level = $tblug->current()->name;
		
		// push notif
		$dpn = array(
			'code' => 'user_added',
			'title' => '$lg_user',
			'icon' => 'fa-user',
			'type' => 'success',
			'content' => '[{"content":"'.$tblu->fullname.'", "single":"$lg_newuseraddedby","more":"$lg_newuseradded"}]'
		);
		pushnotif($dpn);

		//Done
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_datainputsuccessful
		);
		json($a);
	}
	//EDIT
	elseif($mod=='user' AND $act=='edit'){
		$user_id = $v->sql(@$_POST['user_id']);
		$username = $v->xss($_POST['username']);
		$password = @$_POST['newpassword'];
		$fullname = $v->xss($_POST['fullname']);
		$email 	= $v->xss($_POST['email']);
		$phone = $v->xss(@$_POST['phone']);
		$level = $v->sql($_POST['level']);
		$bio = $v->xss(@$_POST['bio']);
		$status = @$_POST['status'];
		if($status == "on"){
			$status = "active";
		}else{
			$status="deactive";
		}
		
		// olny root user can make new su/ad user
		if($tbus->user_id != 1 AND $level == 1){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_iderrorpleasereloadpage
			);

			json($a);
			exit;
		}
		
		// check id exist or not
		$tbluc = new ElybinTable('elybin_users');
		$couser = $tbluc->GetRow('user_id', $user_id);
		if(empty($user_id) OR ($couser == 0)){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_iderrorpleasereloadpage
			);

			json($a);
			exit;
		}

		//if field empty
		if(empty($username) || empty($fullname) || empty($email) || empty($level)){
			//echo "{,$lg_pleasefillimportant}";
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}
		elseif(empty($phone)){
			$phone = "";
		}
		elseif(empty($bio)){
			$bio = "- $lg_nobio -";
		}	

		$bio = htmlspecialchars($bio,ENT_QUOTES);

		//check if username already taken
		$cekuser = $tbluc->GetRowAndNot('user_account_login',$username,'user_id',$user_id);
		if($cekuser>0){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_useralreadytaken
			);

			json($a);
			exit;
		}
		//check if username already taken
		$cekemail = $tbluc->GetRowAndNot('user_account_email',$email,'user_id',$user_id);
		if($cekemail>0){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_emailalreadytaken
			);

			json($a);
			exit;
		}

		//jika mendapat form file kosong
		if(empty($_FILES['image']['tmp_name'])){
			//jika password baru kosong
			if (empty($_POST['newpassword'])) {
				$data = array(
					'user_account_login' => $username,
					'user_account_email' => $email,
					'fullname' => $fullname,
					'phone' => $phone,
					'bio' => $bio,
					'level' => $level,
					'status' => $status
				);
				$tbl = new ElybinTable('elybin_users');
				$tbl->Update($data,'user_id',$user_id);

				//Done
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_dataeditsuccessful
				);
				json($a);
			//jika password isi
			}else{
				$password = md5($_POST['newpassword']);
				$data = array(
					'user_account_login' => $username,
					'user_account_pass' => $password,
					'user_account_email' => $email,
					'fullname' => $fullname,
					'phone' => $phone,
					'bio' => $bio,
					'level' => $level,
					'status' => $status
				);
				$tbl = new ElybinTable('elybin_users');
				$tbl->Update($data,'user_id',$user_id);

				//Done
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_dataeditsuccessful
				);
				json($a);
			}

			//renew current session
			$tbuser = new ElybinTable('elybin_users');
			$s = $_SESSION['login'];
			$cuser = $tbuser->SelectWhere('session', $s,'','');
			$cuser = $cuser->current();

			// generating new random session
			$rand = md5(md5(rand(1000,9999).rand(1,9999)));
			$d = array('session' => $rand);
			$tbuser->Update($d,'user_id',$cuser->user_id);

			//apply new session
			$_SESSION['level'] = $cuser->level;
			$_SESSION['login'] = $rand;

			//Done
			$a = array(
				'status' => 'ok',
				'title' => $lg_success,
				'isi' => $lg_dataeditsuccessful
			);
			json($a);

		//jika file di isi
		}else{
			//avatar update
			$extensionList = array("jpg", "jpeg","png","gif");

			$fileName = $_FILES['image']['name'];
			$tmpName = $_FILES['image']['tmp_name'];
			$pecah = explode(".", $fileName);
			$ekstensi = strtolower(@$pecah[1]);
			$nama_file_unik = $user_id.'.'.$ekstensi;
			$avatar = 'user-'.$nama_file_unik;

			if (in_array($ekstensi, $extensionList)){
				//jika password kosong
				if (empty($_POST['newpassword'])) {
					// get previous ava
					$tbl = new ElybinTable('elybin_users');
					$avatar_lama = $tbl->SelectWhere('user_id',$user_id,'','');
					foreach ($avatar_lama as $i) {
						$avatar_lama = $i->avatar;
					}
					//remove previous ava
					$dir = "../../../elybin-file/avatar/$avatar_lama";
					if (file_exists("$dir") AND ($avatar_lama!="default/no-ava.png")){
						unlink("../../../elybin-file/avatar/$avatar_lama");
						unlink("../../../elybin-file/avatar/medium-$avatar_lama");
					}
					//upload avatar
					UploadImage($avatar,"avatar");
					$data = array(
						'user_account_login' => $username,
						'user_account_email' => $email,
						'fullname' => $fullname,
						'phone' => $phone,
						'bio' => $bio,
						'avatar' => $avatar,
						'level' => $level,
						'status' => $status
					);
					$tbl = new ElybinTable('elybin_users');
					$tbl->Update($data,'user_id',$user_id);

				//jika password diisi
				}else{
					// get previous ava
					$tbl = new ElybinTable('elybin_users');
					$avatar_lama = $tbl->SelectWhere('user_id',$user_id,'','');
					foreach ($avatar_lama as $i) {
						$avatar_lama = $i->avatar;
					}
					//remove previous ava
					$dir = "../../../elybin-file/avatar/$avatar_lama";
					if (file_exists("$dir") AND ($avatar_lama!="default/no-ava.png")){
						unlink("../../../elybin-file/avatar/$avatar_lama");
						unlink("../../../elybin-file/avatar/medium-$avatar_lama");
					}
					UploadImage($avatar,"avatar");
					$password = md5($_POST['newpassword']);
					$data = array(
						'user_account_login' => $username,
						'user_account_pass' => $password,
						'user_account_email' => $email,
						'fullname' => $fullname,
						'phone' => $phone,
						'bio' => $bio,
						'avatar' => $avatar,
						'level' => $level,
						'status' => $status
					);
					$tbl = new ElybinTable('elybin_users');
					$tbl->Update($data,'user_id',$user_id);

				}
				//renew current session
				$tbuser = new ElybinTable('elybin_users');
				$s = $_SESSION['login'];
				$cuser = $tbuser->SelectWhere('session', $s,'','');
				$cuser = $cuser->current();

				// generating new random session
				$rand = md5(md5(rand(1000,9999).rand(1,9999)));
				$d = array('session' => $rand);
				$tbuser->Update($d,'user_id',$cuser->user_id);

				//apply new session
				$_SESSION['level'] = $cuser->level;
				$_SESSION['login'] = $rand;

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
		}
	}
	//ACTIVE
	elseif($mod=='user' AND $act=='active'){
		$user_id = $v->sql(@$_POST['user_id']);
		$tblact = new ElybinTable('elybin_users');

		// check id exist or not
		$couser = $tblact->GetRow('user_id', $user_id);
		if(empty($user_id) OR ($couser == 0)){
			header('location: ../../../404.html');
			exit;
		}
		// ambil data
		$status = $tblact->SelectWhere('user_id',$user_id,'','');
		$status = $status->current();
		
		if($status->level == 1){
			header('location: ../../../404.html');
			exit;
		}
		
		$status = $status->status;
		if($status == "active"){
			$data = array( 'status' => "deactive");
			$tblact->Update($data,'user_id',$user_id);
		}else{
			$data = array( 'status' => "active");
			$tblact->Update($data,'user_id',$user_id);
		}
		header('location: ../../admin.php?mod='.$mod);
	}

	//DEL
	elseif($mod=='user' AND $act=='del'){
		$user_id = $v->sql($_POST['user_id']);
		$tabledel = new ElybinTable('elybin_users');

		// check id exist or not
		$couser = $tabledel->GetRow('user_id', $user_id);
		if(empty($user_id) OR ($couser == 0)){
			header('location: ../../../404.html');
			exit;
		}
		
		// get level
		$cuser = $tabledel->SelectWhere('user_id', $user_id)->current();
		
		// olny root user can delete su/ad user
		if($user_id == 1 OR $user_id == $tbus->user_id OR ($cuser->level == 1 AND $tbus->level != 1)){
			header('location: ../../../404.html');
			exit;
		}	

		$avatar = $tabledel->SelectWhere('user_id',$user_id,'','');
		foreach ($avatar as $i) {
			$avatar = $i->avatar;
		}
		$fileavatar = "../../../elybin-file/avatar/$avatar";
		if (file_exists("$fileavatar") AND ($avatar!="default/no-ava.png")){
			unlink("../../../elybin-file/avatar/$avatar");
		}
		$tabledel->Delete('user_id', $user_id);
		header('location:../../admin.php?mod='.$mod);
	}
	//MULTI DEL
	elseif($mod=='user' AND $act=='multidel'){
		$user_id = $_POST['del'];

		if(!empty($user_id)){
			foreach ($user_id as $usr) {
				$pecah = explode("|",$usr);
				$pecah = $pecah[0];
				$user_id_fix = $v->sql($pecah);
				$tabledel = new ElybinTable('elybin_users');

				// check id exist or not
				$couser = $tabledel->GetRow('user_id', $user_id_fix);
				if(empty($user_id_fix) OR ($couser == 0)){
					header('location: ../../../404.html');
					exit;
				}
				
				// get level
				$cuser = $tabledel->SelectWhere('user_id', $user_id_fix)->current();
				
				// olny root user can delete su/ad user
				if($user_id_fix == 1 OR $user_id_fix == $tbus->user_id OR ($cuser->level == 1 AND $tbus->level != 1)){
					header('location: ../../../404.html');
					exit;
				}	

				$ava = $tabledel->SelectWhere('user_id',$user_id_fix,'','');
				$ava = $ava->current();
				$avatar = $ava->avatar;
				$fileavatar = "../../../elybin-file/avatar/$avatar";
				if (file_exists("$fileavatar") AND ($avatar!="default/no-ava.png")){
					unlink("../../../elybin-file/avatar/$avatar");
				}
				$tabledel->Delete('user_id', $user_id_fix);
				header('location:../../admin.php?mod='.$mod);
			}
		} // > foreach
	}		
	//404
	else{
		header('location:../../../404.html');
	}
}
}	
?>