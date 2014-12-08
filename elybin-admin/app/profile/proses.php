<?php
/* Short description for file
 * [ Module: Profile Proccess
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

	//EDIT
	if($mod=='profile' AND $act=='edit'){
		//get current user session
		$s = $_SESSION['login'];
		$tblu = new ElybinTable("elybin_users");
		$tblu = $tblu->SelectWhere("session","$s","","");
		$tblu = $tblu->current();
		$user_id = $tblu->user_id;

		$username = $v->xss($_POST['username']);
		$password = @$_POST['newpassword'];
		$fullname = $v->xss($_POST['fullname']);
		$email 	= $v->xss($_POST['email']);
		$phone = $v->xss(@$_POST['phone']);
		$bio = $v->xss($_POST['bio']);

		//if field empty
		if(empty($username) || empty($fullname) || empty($email)){
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
		$tbluc = new ElybinTable('elybin_users');
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
					'bio' => $bio
				);
				$tbl = new ElybinTable('elybin_users');
				$tbl->Update($data,'user_id',$user_id);

				//Done
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_yourprofileupdated
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
					'bio' => $bio
				);
				$tbl = new ElybinTable('elybin_users');
				$tbl->Update($data,'user_id',$user_id);

				//Done
				$a = array(
					'status' => 'ok',
					'title' => $lg_success,
					'isi' => $lg_yourpasswordupdated
				);
				json($a);
			}


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

		//jika file di isi
		}else{
			//avatar update
			$extensionList = array("jpg", "jpeg","png","gif");

			$fileName = $_FILES['image']['name'];
			$tmpName = $_FILES['image']['tmp_name'];
			$pecah = explode(".", $fileName);
			$ekstensi = @$pecah[1];
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
					UploadImage($avatar,"avatar");
					$data = array(
						'user_account_login' => $username,
						'user_account_email' => $email,
						'fullname' => $fullname,
						'phone' => $phone,
						'bio' => $bio,
						'avatar' => $avatar
					);
					$tbl = new ElybinTable('elybin_users');
					$tbl->Update($data,'user_id',$user_id);


					//Done
					$a = array(
						'status' => 'ok',
						'title' => $lg_success,
						'isi' => $lg_yourprofileupdated
					);
					json($a);
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
						'avatar' => $avatar
					);
					$tbl = new ElybinTable('elybin_users');
					$tbl->Update($data,'user_id',$user_id);

					//Done
					$a = array(
						'status' => 'ok',
						'title' => $lg_success,
						'isi' => $lg_yourpasswordupdated
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
	//404
	else{
		header('location:../../../404.php');
	}
}	
?>