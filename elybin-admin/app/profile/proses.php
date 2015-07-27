<?php
// Elybin CMS (www.elybin.com) - Open Source Content Management System
// @copyright	Copyright (C) 2014 - 2015 Elybin, All rights reserved.
// @license		GNU General Public License version 2 or later; see LICENSE.txt
// @author		Khakim A <kim@elybin.com>
// ----
// Apps				: Profile v1.0.1
// File Info	: "Proccess for Module Profile"
session_start();
include_once('../../../elybin-core/elybin-function.php');
include_once('../../../elybin-core/elybin-oop.php');
include_once('../../../elybin-core/lib/password.php');

// define apps
$apps_identifer = 'profile';
$apps_part = '';

if(empty($_SESSION['login'])){
	result(array(
		'status' => 'error',
		'title' => lg('Login First'),
		'msg' => lg('Please login to perform this action.'),
		'msg_ses' => 'login_first',
		'red' => '../../../?p=login'
	), @$_GET['r']);
}else{

	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	//EDIT
	if($mod=='profile' AND $act=='edit'){
		$tbl = new ElybinTable('elybin_users');
		//get current user session
		$u = _u();
		// get post variable
		$username 	= $v->xss($_POST['username']);
		$password 	= @$_POST['newpassword'];
		$cpassword 	= @$_POST['newconfirmpassword'];
		$fullname 	= $v->xss($_POST['fullname']);
		$email 			= $v->xss(@$_POST['email']);
		$phone 			= $v->xss(@$_POST['phone']);
		$bio 				= $v->xss($_POST['bio']);

		//if field empty
		// never let them empty
		if(empty($username)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Please fill Username first.'),
				'msg_ses' => 'fill_username',
				'red' => '../../admin.php?mod='.$apps_identifer
			), @$_GET['r']);
		}
		// never let them empty
		if(empty($email)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Please fill E-mail.'),
				'msg_ses' => 'fill_email',
				'red' => '../../admin.php?mod='.$apps_identifer
			), @$_GET['r']);
		}
		// never let them empty
		if(empty($fullname)){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Please fill Fullname.'),
				'msg_ses' => 'fill_fullname',
				'red' => '../../admin.php?mod='.$apps_identifer
			), @$_GET['r']);
		}

		// if bio empty
		if(empty($bio)){
			$bio = '- '.lg('No Bio').' -';
		}
		$bio = htmlspecialchars($bio,ENT_QUOTES);

		// try filter username
		if(!preg_match("/^[a-z0-9_]+$/", $username)){
			// woops! not matched anything, I given up! give 'em result!
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Username format not recognized. Allowed character for Username is letter(a-z), number(0-9) and underscore (_).'),
				'msg_ses' => 'invalid_username',
				'red' => '../../admin.php?mod='.$apps_identifer
			), @$_GET['r']);
		}
		// check username length
		if(strlen($username) > 12){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Maximum username character is 12 letter.'),
				'msg_ses' => 'username_too_long',
				'red' => '../../admin.php?mod='.$apps_identifer
			), @$_GET['r']);
		}
		// limit username length
		if(strlen($username) < 3){
			// woops! not matched anything, I given up! give 'em result!
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Minimum username character is 3 letter.'),
				'msg_ses' => 'username_too_short',
				'red' => '../../admin.php?mod='.$apps_identifer
			), @$_GET['r']);
		}
		//check if username already taken
		$cou = $tbl->GetRowAndNot('user_account_login',$username,'user_id',$u->user_id);
		if($cou>0){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Username already taken, pick new one.'),
				'msg_ses' => 'username_taken',
				'red' => '../../admin.php?mod='.$apps_identifer
			), @$_GET['r']);
		}

		// filter email
		if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/", $email)){
			// woops! not matched anything, I given up! give 'em result!
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('E-mail format not recognized. Example format is xxx@xxx.xxx.'),
				'msg_ses' => 'invalid_email',
				'red' => '../../admin.php?mod='.$apps_identifer
			), @$_GET['r']);
		}
		//check if email already taken
		$cekemail = $tbl->GetRowAndNot('user_account_email',$email,'user_id',$u->user_id);
		if($cekemail>0){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('E-mail already used by another account.'),
				'msg_ses' => 'email_used',
				'red' => '../../admin.php?mod='.$apps_identifer
			), @$_GET['r']);
		}

		// check fullname length
		if(strlen($fullname) > 60){
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Maximum name character is 60 letter.'),
				'msg_ses' => 'fullname_too_long',
				'red' => '../../admin.php?mod='.$apps_identifer
			), @$_GET['r']);
		}

		// update 1.1.3
		// email that has been verified, cannot be chenged
		// $email_status = $tbl->GetRowAnd('user_account_login', $username, 'email_status', 'verified');
		// if($email_status > 0){
		// 	$email = $tbl->SelectWhere('user_account_login', $username)->current()->user_account_email;
		// }

		//jika mendapat form file kosong
		if(empty($_FILES['file']['tmp_name'])){
			//jika password baru kosong
			if(empty($password)) {
				$tbl->Update(array(
					'user_account_login' => $username,
					'user_account_email' => $email,
					'fullname' => $fullname,
					'phone' => $phone,
					'bio' => $bio
				),'user_id',$u->user_id);

				//Done
				result(array(
					'status' => 'ok',
					'title' => lg('Success'),
					'msg' => lg('Your profile photo updated.'),
					'msg_ses' => 'photo_updated',
					'red' => '../../admin.php?mod='.$apps_identifer
				), @$_GET['r']);

			//jika password isi
			}else{
				// limit password
				if(strlen($password) < 6){
					result(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Your password is too weak, try to use more combination.'),
						'msg_ses' => 'password_too_short',
						'red' => '../../admin.php?mod='.$apps_identifer
					), @$_GET['r']);
				}
				// never let them empty
				if(empty($cpassword)){
					result(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Don\'t forget to fill Password in both field.'),
						'msg_ses' => 'fill_both',
						'red' => '../../admin.php?mod='.$apps_identifer
					), @$_GET['r']);
				}
				// match the password
				if($password !== $cpassword){
					result(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Both password din\'t match each other, Please check.'),
						'msg_ses' => 'password_not_match',
						'red' => '../../admin.php?mod='.$apps_identifer
					), @$_GET['r']);
				}

				$tbl->Update(array(
					'user_account_login' => $username,
					'user_account_pass' => password_hash($password, PASSWORD_BCRYPT),
					'user_account_email' => $email,
					'fullname' => $fullname,
					'phone' => $phone,
					'bio' => $bio
				),'user_id',$u->user_id);

				//Done
				result(array(
					'status' => 'ok',
					'title' => lg('Success'),
					'msg' => lg('Your password updated.'),
					'msg_ses' => 'profile_updated',
					'red' => '../../admin.php?mod='.$apps_identifer
				), @$_GET['r']);
			}

			// generating new random session
			$rand = md5(date('YmddmyhHisYYmdddddd--&*--ssssiiiisssiiiss'));
			$tbl->Update(array('session' => $rand),'user_id',$u->user_id);

			//apply new session
			$_SESSION['level'] = $u->level;
			$_SESSION['login'] = $rand;

		//jika file di isi
		}else{
			//avatar update
			$allowedext = array("jpg", "jpeg","png","gif");

			$fileName = $_FILES['file']['name'];
			$tmpName = $_FILES['file']['tmp_name'];
			$pecah = explode(".", $fileName);
			$ext = @$pecah[count($pecah)-1];
			$avatar = 'user-'.$u->user_id.'-'.date('Y-m-d_H-i-s').'.'.$ext;

			if (in_array($ext, $allowedext)){
				//jika password kosong
				if (empty($password)) {
					// previous ava
					$avatar_lama = $u->avatar;
					//remove previous ava
					if ($avatar_lama != 'default/no-ava.png'){
						@unlink("../../../elybin-file/avatar/$avatar_lama");
						@unlink("../../../elybin-file/avatar/hd-$avatar_lama");
						@unlink("../../../elybin-file/avatar/md-$avatar_lama");
						@unlink("../../../elybin-file/avatar/sm-$avatar_lama");
						@unlink("../../../elybin-file/avatar/xs-$avatar_lama");
					}
					UploadImage($avatar, 'avatar');
					$tbl->Update(array(
						'user_account_login' => $username,
						'user_account_email' => $email,
						'fullname' => $fullname,
						'phone' => $phone,
						'bio' => $bio,
						'avatar' => $avatar
					),'user_id', $u->user_id);

					// Done
					result(array(
						'status' => 'ok',
						'title' => lg('Success'),
						'msg' => lg('Your profile updated.'),
						'msg_ses' => 'profile_updated',
						'red' => '../../admin.php?mod='.$apps_identifer
					), @$_GET['r']);
				//jika password diisi
				}else{
					// previous ava
					$avatar_lama = $u->avatar;
					//remove previous ava
					if ($avatar_lama != 'default/no-ava.png'){
						@unlink("../../../elybin-file/avatar/$avatar_lama");
						@unlink("../../../elybin-file/avatar/hd-$avatar_lama");
						@unlink("../../../elybin-file/avatar/md-$avatar_lama");
						@unlink("../../../elybin-file/avatar/sm-$avatar_lama");
						@unlink("../../../elybin-file/avatar/xs-$avatar_lama");
					}
					UploadImage($avatar, 'avatar');
					$tbl->Update(array(
						'user_account_login' => $username,
						'user_account_pass' => password_hash($password, PASSWORD_BCRYPT),
						'user_account_email' => $email,
						'fullname' => $fullname,
						'phone' => $phone,
						'bio' => $bio,
						'avatar' => $avatar
					),'user_id',$u->user_id);

					//Done
					result(array(
						'status' => 'ok',
						'title' => lg('Success'),
						'msg' => lg('Your password updated.'),
						'msg_ses' => 'password_updated',
						'red' => '../../admin.php?mod='.$apps_identifer
					), @$_GET['r']);
				}

				// generating new random session
				$rand = md5(date('YmddmyhHisYYmdddddd--&*--ssssiiiisssiiiss'));
				$tbl->Update(array('session' => $rand),'user_id',$u->user_id);

				//apply new session
				$_SESSION['level'] = $u->level;
				$_SESSION['login'] = $rand;

			}else{
				//image extension deny
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Extension not allowed.'),
					'msg_ses' => 'extension_not_allowed',
					'red' => '../../admin.php?mod='.$apps_identifer
				), @$_GET['r']);
			}
		}

	}
	//404
	else{
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Target process not found, this is our mistake, please contact us.'),
			'msg_ses' => 'target_process_mismatch',
			'red' => '../../admin.php?mod='.$apps_identifer
		), @$_GET['r']);
	}
}
?>
