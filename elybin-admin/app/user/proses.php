<?php
/* Short description for file
 * Module 	: User
 * File  	: proses.php
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
	include_once('../../../elybin-core/lib/password.php');
	include_once('../../../elybin-core/elybin-oop.php');
	include_once('../../lang/main.php');

	// get user privilages
	$ug = _ug()->user;

// give error if no have privilage
if($ug == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to access this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	// start here
	$v = new ElybinValidasi;
	$mod = @$_POST['mod'];
	$act = @$_POST['act'];

	//ADD
	if ($mod=='user' AND $act=='add'){
		$username = $v->xss(@$_POST['username']);
		$password = @$_POST['password'];
		$password_c = @$_POST['password_confrim'];
		$email 	= $v->xss(@$_POST['email']);
		$level = $v->xss(@$_POST['level']);

		// set to session
		$_SESSION['s_username'] = $username;
		$_SESSION['s_email'] = $email;
		$_SESSION['s_level'] = $level;

		// 1.1.3 - more specific error
		if(empty($username)){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Please fill "Username" field.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=fill_username');
			}
		}

		if(empty($password)){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Please fill "Password" field.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=fill_password');
			}
		}

		if(empty($password_c)){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Please type password again in "Password Confirm" field.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=fill_password');
			}
		}

		if(empty($email)){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Please fill "E-mail" field.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=fill_email');
			}
		}

		if(empty($email)){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Please select user "Level".')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=fill_level');
			}
		}
		// pass != pass_c
		if($password !== $password_c){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('"Password Confirm" didn\'t match with Password.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=pass_mismatch');
			}
		}
		// check username length
		if(strlen($username) > 12){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Maximum username character is 12 letter.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=username_too_long');
			}
		}
		if(strlen($username) < 3){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Minimum username character is 3 letter.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=username_too_short');
			}
		}

		$pat_un = "/^[a-z0-9_]+$/";
		if(!preg_match($pat_un, $username)){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Allowed character for Username is letter(a-z), number(0-9) and underscore (_)')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=username_invalid');
			}
		}

		// validate email
		// http://stackoverflow.com/questions/13447539/php-preg-match-with-email-validation-issue
		$pat_em = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
		if(!preg_match($pat_em, $email)){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Invalid e-mail, the format is xxx@xxx.xxx.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=email_invalid');
			}
		}

		// check username availability
		$tb = new ElybinTable('elybin_users');
		$cou = $tb->GetRow('user_account_login', $username);
		if($cou > 0){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Username already taken, pick new one.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=username_taken');
			}
		}

		// check email availability
		$cou = $tb->GetRow('user_account_email', $email);
		if($cou > 0){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('E-mail already used by other user.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=email_taken');
			}
		}

		// get current active user
		$u = _u();

		// olny root user can create new su/ad user
		if($u->user_id != 1 AND $level == 1){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('You are not allowed to perform this action.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=add&err=action_denied');
			}
		}
		
		// since 1.1.3, we use new password hasing function
		$password_hash = password_hash($password, PASSWORD_BCRYPT);

		//write it
		$d = array(
			'user_account_login' => $username,
			'user_account_pass' => $password_hash,
			'user_account_email' => $email,
			'fullname' => strtoupper($username),
			'phone' => '',
			'avatar' => 'default/no-ava.png',
			'registered' => date("Y-m-d H:i:s"),
			'level' => $level,
			'email_status' => 'notverified',
			'session' => 'offline'
		);
		$tb->Insert($d);

		
		// remove to session
		$_SESSION['s_username'] = '';
		$_SESSION['s_email'] = '';
		$_SESSION['s_level'] = '';

		// push notif
		/*
		$dpn = array(
			'code' => 'user_added',
			'title' => '$lg_user',
			'icon' => 'fa-user',
			'type' => 'success',
			'content' => '[{"content":"'.$tblu->fullname.'", "single":"$lg_newuseraddedby","more":"$lg_newuseradded"}]'
		);
		pushnotif($dpn);*/

		//Done
		if(@$_GET['result'] == 'json'){
			json(array(
				'status' => 'ok',
				'title' => lg('Success'),
				'msg' => lg('New user successfully registered.')
			));
		}else{
			header('location: ../../admin.php?mod=user&act=add&err=saved');
		}
	}
	//EDIT
	elseif($mod=='user' AND $act=='edit'){
		// hash to uid
		$uid = $v->sql(epm_decode(@$_POST['hash']));

		// declare 
		$tb = new ElybinTable('elybin_users');

		// check existance
		$cu = $tb->SelectFullCustom("
			SELECT
			*,
			COUNT(`user_id`) as `row`
			FROM
			`elybin_users` as `u`
			WHERE
			`u`.`user_id` = $uid
			")->current();
		if($cu->row < 1){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('User not exist.')
				));
			}else{
				header('location: ../../admin.php?mod=user&act=edit&err=not_exsist&hash='.@$_POST['hash']);
			}
		}

		// 1.1.3
		// using sub menu
		if(@$_POST['sub'] == 'account'){
			// collect data
			$username = $v->xss($_POST['username']);
			$password = $v->xss(@$_POST['password']);
			$password_c = $v->xss(@$_POST['password_c']);
			$email 	= $v->xss($_POST['email']);
			$level = $v->sql($_POST['level']);

			// verify
			// 1.1.3 - more specific error
			if(empty($username)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Please fill "Username" field.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=fill_username&hash='.@$_POST['hash']);
				}
			}		
			// check username length
			if(strlen($username) > 12){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Maximum username character is 12 letter.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=username_too_long&hash='.@$_POST['hash']);
				}
			}
			if(strlen($username) < 3){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Minimum username character is 3 letter.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=username_too_short&hash='.@$_POST['hash']);
				}
			}
			$pat_un = "/^[a-z0-9_]+$/";
			if(!preg_match($pat_un, $username)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Allowed character for Username is letter(a-z), number(0-9) and underscore (_)')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=username_invalid&hash='.@$_POST['hash']);
				}
			}
			// check username availability
			$tb = new ElybinTable('elybin_users');
			$cou = $tb->GetRowAndNot('user_account_login',$username,'user_id',$uid);
			if($cou > 0){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Username already taken, pick new one.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=username_taken&hash='.@$_POST['hash']);
				}
			}


			if(!empty($password) && empty($password_c)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Please type password again in "Password Confirm" field.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=fill_password&hash='.@$_POST['hash']);
				}
			}

			if(!empty($password) && !empty($password_c) && $password !== $password_c){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Both password didn\'t match, check again.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=check_password&hash='.@$_POST['hash']);
				}
			}

			if(empty($email)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Please fill "E-mail" field.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=fill_email&hash='.@$_POST['hash']);
				}
			}

			// validate email
			// http://stackoverflow.com/questions/13447539/php-preg-match-with-email-validation-issue
			$pat_em = "/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/";
			if(!preg_match($pat_em, $email)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Invalid e-mail, the format is xxx@xxx.xxx and Lower Case.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=email_invalid&hash='.@$_POST['hash']);
				}
			}

			// check email availability
			$cou = $tb->GetRowAndNot('user_account_email',$email,'user_id',$uid);
			if($cou > 0){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('E-mail already used by other user.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=email_taken&hash='.@$_POST['hash']);
				}
			}


			if(empty($level)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Please select user "Level".')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=fill_level&hash='.@$_POST['hash']);
				}
			}

			// process
			// since 1.1.3
			// nobody can create user with su/1
			if($level == 1){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('You can\'t perform this action, Access Denied.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&err=denied&hash='.@$_POST['hash']);
				}
			}


			//jika password baru kosong
			if (empty($password)) {
				$tb->Update(array(
					'user_account_login' => $username,
					'user_account_email' => $email,
					'level' => $level
				),'user_id',$uid);
			}else{ //jika password isi
				// since 1.1.3, we use new password hasing function
				$password_hash = password_hash($password, PASSWORD_BCRYPT);

				$tb->Update(array(
					'user_account_login' => $username,
					'user_account_pass' => $password,
					'user_account_email' => $email,
					'level' => $level
				),'user_id',$uid);
			}

			// renew current session
			// since 1.1.3
			// it removed, and moved to module profile

			// done
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'ok',
					'title' => lg('Success'),
					'msg' => lg('Changes Saved.'),
					'callback' => 'edit',
					'callback_hash' => @$_POST['hash'],
					'callback_msg' => 'updated'
				));
			}else{
				header('location: ../../admin.php?mod=user&act=edit&msg=updated&hash='.@$_POST['hash']);
			}
		} 

		// sub = 'personal'
		else if(@$_POST['sub'] == 'personal'){
			// collect data
			$fullname = $v->xss(@$_POST['fullname']);
			$bio = $v->xss(@$_POST['bio']);
			$phone = $v->xss(@$_POST['phone']);
			$facebook_id = $v->xss(@$_POST['facebook_id']);
			$twitter_id = $v->xss(@$_POST['twitter_id']);
			$website = $v->xss(@$_POST['website']);

			// verify
			if(empty($fullname)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Please fill "Fullname" field.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=fill_fullname');
				}
			}		
			// check username length
			if(strlen($fullname) > 50){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Maximum fullname character is 50 letter.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=fullname_too_long');
				}
			}
			if(strlen($fullname) < 4){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Minimum fullname character is 4 letter.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=fullname_too_short');
				}
			}
			$pat_fn = "/^[A-Za-z-'` ]+$/";
			if(!preg_match($pat_fn, $fullname)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Fullname must letter only.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=fullname_invalid');
				}
			}
			if(!empty($bio) && strlen($bio) > 250){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Maximum character of bio is 250.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=bio_too_long');
				}
			}
			if(!empty($phone) && strlen($phone) > 20){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Maximum character of phone number is 20.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=phone_too_long');
				}
			}
			$pat_ph = "/^[0-9+-]+$/";
			if(!empty($phone) && !preg_match($pat_ph, $phone)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Phone number invalid, fill with format like +620000000000')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=phone_invalid');
				}
			}
			if(!empty($facebook_id) && strlen($facebook_id) > 20){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Maximum character of Facebook ID number is 20.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=fbid_too_long');
				}
			}
			$pat_fbid = "/^[0-9a-zA-Z._-]+$/";
			if(!empty($facebook_id) && !preg_match($pat_fbid, $facebook_id)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Facebook ID invalid, fill with format like elybincms')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=fbid_invalid');
				}
			}
			if(!empty($twitter_id) && strlen($twitter_id) > 20){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Maximum character of Twitter ID/ Username number is 20.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=twid_too_long');
				}
			}
			if(!empty($twitter_id) && !preg_match("/^[0-9a-zA-Z_@]+$/", $twitter_id)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Twitter ID/Username invalid, fill with format like @elybincms')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=twid_invalid');
				}
			}
			$pat_web = "/^[a-z0-9.-\/]+$/";
			if(!empty($website) && !preg_match($pat_web, $website)){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Website invalid, fill with format like www.elybin.com')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=website_invalid');
				}
			}

			// proccess
			$tb->Update(array(
				'fullname' => $fullname,
				'bio' => $bio,
				'phone' => $phone,
				'facebook_id' => $facebook_id,
				'twitter_id' => $twitter_id,
				'website' => $website
				),'user_id',$uid);

			// done
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'ok',
					'title' => lg('Success'),
					'msg' => lg('Changes Saved.'),
					'callback' => 'edit&sub=personal',
					'callback_hash' => @$_POST['hash'],
					'callback_msg' => 'updated'
				));
			}else{
				header('location: ../../admin.php?mod=user&act=edit&sub=personal&msg=updated&hash='.@$_POST['hash']);
			}
		}

		else if(@$_POST['sub'] == 'avatar'){
			//jika mendapat form file kosong
			if(empty($_FILES['file']['tmp_name'])){
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Nothing changed?')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=avatar&err=nothing_changed');
				}
			}else{
				//avatar update
				$extList = array("jpg", "jpeg","png","gif");
				$fileName = $_FILES['file']['name'];
				$tmpName = $_FILES['file']['tmp_name'];
				$pecah = @explode(".", $fileName);
				$ext = strtolower(@$pecah[count($pecah)-1]);
				$date = date("Y-m-d_H-i-s");
				$rn = rand(1111,9999);
				$avatar = strtolower("user-$uid-$date-$rn.$ext");

				if (!in_array($ext, $extList)){
					if(@$_GET['result'] == 'json'){
						json(array(
							'status' => 'error',
							'title' => lg('Error'),
							'msg' => lg('Image extension not recognized, be sure your image extension is (jpg, jpeg, png or gif)')
						));
					}else{
						header('location: ../../admin.php?mod=user&act=edit&sub=personal&err=ext_denied');
					}
				}else{
					//remove previous ava
					if (file_exists('../../../elybin-file/avatar/'.$cu->avatar) && ($cu->avatar!=='default/no-ava.png')){
						@unlink('../../../elybin-file/avatar/'.$cu->avatar);
						@unlink('../../../elybin-file/avatar/hd-'.$cu->avatar);
						@unlink('../../../elybin-file/avatar/md-'.$cu->avatar);
						@unlink('../../../elybin-file/avatar/sm-'.$cu->avatar);
						@unlink('../../../elybin-file/avatar/xs-'.$cu->avatar);
					}
					//upload 
					UploadImage($avatar,"avatar");
					// update
					$tb->Update(array(
						'avatar' => $avatar
					),'user_id',$uid);
				}
				
				// done
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'ok',
						'title' => lg('Success'),
						'msg' => lg('Changes Saved.'),
						'callback' => 'edit&sub=avatar',
						'callback_hash' => @$_POST['hash'],
						'callback_msg' => 'updated'
						));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=avatar&msg=updated&hash='.@$_POST['hash']);
				}
			}
		}

		else if(@$_POST['sub'] == 'misc'){
			$status = $v->xss(@$_POST['status']);

			if($status == 'active' || $status == 'deactive'){
			}else{
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => lg('Input not recognized. This is our mistake or you want another. Access Denied.')
					));
				}else{
					header('location: ../../admin.php?mod=user&act=edit&sub=misc&err=denied');
				}
			}

			// proccess
			$tb->Update(array(
				'status' => $status
				),'user_id',$uid);

			// done
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'ok',
					'title' => lg('Success'),
					'msg' => lg('Changes Saved.'),
					'callback' => 'edit&sub=misc',
					'callback_hash' => @$_POST['hash'],
					'callback_msg' => 'updated'
					));
			}else{
				header('location: ../../admin.php?mod=user&act=edit&sub=misc&msg=updated&hash='.@$_POST['hash']);
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