<?php
/* Short description for file
 * Module 	: Messager (Beta)
 * File	 	: app/messager/proses.php
 *	
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System 
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 -----------------
 1.1.3
 - First Create 
 */
session_start();
if(empty($_SESSION['login'])){
	header('location: ../../../403.html');	
}else{	
	include_once('../../../elybin-core/elybin-oop.php');
	include_once('../../../elybin-core/elybin-function.php');
	include_once('../../lang/main.php');
	settzone();

	$v = new ElybinValidasi;
	$mod = $_POST['mod'];
	$act = $_POST['act'];

	// COMPOSE
	if ($mod=='messager' AND $act=='compose'){
		// get data first
		$to = @$_POST['to'];
		$subject = @$_POST['subject'];
		$body = @$_POST['body'];

		// set session, to prevent data loss
		$_SESSION['to'] = $to;
		$_SESSION['subject'] = $subject;
		$_SESSION['body'] = $body;

		// verify empty data
		if(empty($to)){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Please enter the recipient.')
				));
			}else{
				header('location: ../../admin.php?mod=messager&act=compose&err=fill_recipient');
			}
		}

		// verify empty data
		if(empty($body)){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('You forgot the body message?')
				));
			}else{
				header('location: ../../admin.php?mod=messager&act=compose&err=fill_body');
			}
		}

		// verify empty data
		if(empty($subject)){
			$subject = '&lt;'.lg('No Subject').'&gt;';
		}

		// how much recipient?
		$tmp_to1 = @explode(",", $to);
		// normal user only allow 3 broadcast message
		if(count($tmp_to1) > 3){
			// limiter email.
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('You are exccending maximum number of multiple recipient.')
				));
			}else{
				header('location: ../../admin.php?mod=messager&act=compose&err=maximum_recipient');
				exit;
			}
		}

		// decare object
		$tb = new ElybinTable('elybin_message');
		// get current active information
		$u = _u();

		// check the recipient 
		foreach ($tmp_to1 as $to1) {
			// one by one
			$tmp_recip = @explode("@", $to1);
			if(count($tmp_recip) > 1){
				// it's email!
				$tmp_to = $v->sql($tmp_recip[0]).'@'.$v->sql($tmp_recip[1]);
			}else{
				// invalid email.
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => '"'.$tmp_to.'" '.lg('is invalid recipient. Please check again.')
					));
				}else{
					header('location: ../../admin.php?mod=messager&act=compose&err=invalid_email');
					exit;
				}
			}



			// check to databas
			$cr = $tb->SelectFullCustom("
				SELECT
				*,
				COUNT(`user_id`) as `row`
				FROM 
				`elybin_users` as `u`
				WHERE
				`u`.`user_account_email` = '$tmp_to'
				LIMIT 0,1
				")->current();

			if($cr->row < 1){
				// invalid email.
				if(@$_GET['result'] == 'json'){
					json(array(
						'status' => 'error',
						'title' => lg('Error'),
						'msg' => '"'.$tmp_to.'" '.lg('is invalid recipient. Please check again.')
					));
				}else{
					header('location: ../../admin.php?mod=messager&act=compose&err=invalid_email');
					exit;
				}
			}


			// input
			$d = array(
				'subject' => $subject,
				'msg_body' => htmlspecialchars($body), 
				'msg_date' => date('Y-m-d H:i:s'),
				'msg_type' => 'message',
				'msg_priority' => 'normal',
				'msg_status' => 'sent',
				'to_uid' => $cr->user_id,
				'from_uid' => $u->user_id,
				'from_email' => $u->user_account_email,
				'from_name' => $u->fullname
	 			);
			$tb->Insert($d);
		}



		// remove session
		$_SESSION['to'] = '';
		$_SESSION['subject'] = '';
		$_SESSION['body'] = '';

		//Done
		if(@$_GET['result'] == 'json'){
			json(array(
				'status' => 'ok',
				'title' => lg('Success'),
				'msg' => lg('Message sent successfuly.'),
				'callback' => '&filter=sent',
				'callback_hash' => epm_encode($cr->user_id),
				'callback_msg' => 'sent' 
			));
		}else{
			header('location: ../../admin.php?mod=messager&flter=sent&msg=sent');
		}
	}
	// COMPOSE
	else if ($mod=='messager' AND $act=='reply'){
		// get hash
		$mid = $v->sql(epm_decode(@$_POST['hash']));

		// get data first
		$subject = @$_POST['subject'];
		$body = @$_POST['body'];

		// set session, to prevent data loss
		$_SESSION['subject'] = $subject;
		$_SESSION['body'] = $body;

		// verify empty data
		if(empty($body)){
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('You forgot the body message?')
				));
			}else{
				header('location: ../../admin.php?mod=messager&act=reply&err=fill_body');
			}
		}

		// verify empty data
		if(empty($subject)){
			$subject = '&lt;'.lg('No Subject').'&gt;';
		}
	
		// get current active information
		$u = _u();

		// check to databas
		$tb = new ElybinTable('elybin_message');
		$cm = $tb->SelectFullCustom("
			SELECT
			*,
			COUNT(`mid`) as `row`
			FROM 
			`elybin_message` as `m`
			WHERE
			`m`.`mid` = '$mid'
			LIMIT 0,1
			")->current();

		if($cm->row < 1){
			// invalid email.
			if(@$_GET['result'] == 'json'){
				json(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Invalid recipient. Please check again.')
				));
			}else{
				header('location: ../../admin.php?mod=messager&act=reply&err=invalid_email');
				exit;
			}
		}

		// input
		$d = array(
			'subject' => $subject,
			'msg_body' => htmlspecialchars($body), 
			'msg_date' => date('Y-m-d H:i:s'),
			'msg_type' => 'message',
			'msg_priority' => 'normal',
			'msg_status' => 'sent',
			'to_uid' => $cm->from_uid,
			'from_uid' => $u->user_id,
			'from_email' => $u->user_account_email,
			'from_name' => $u->fullname
 			);
		$tb->Insert($d);

		// Update message msg_status_recp to replied
		$d = array(
			'msg_status_recp' => 'replied'
			);	
		$tb->Update($d, 'mid', $mid);

		// remove session
		$_SESSION['subject'] = '';
		$_SESSION['body'] = '';

		//Done
		if(@$_GET['result'] == 'json'){
			json(array(
				'status' => 'ok',
				'title' => lg('Success'),
				'msg' => lg('Message sent successfuly.'),
				'callback' => '&filter=sent',
				'callback_hash' => epm_encode($cm->from_uid),
				'callback_msg' => 'sent' 
			));
		}else{
			header('location: ../../admin.php?mod=messager&act=&filter=sent&msg=sent');
		}
	}
	//DEL
	else if ($mod=='messager' AND $act=='del'){
		//validate id from sqli
		$mid = $v->sql(epm_decode(@$_POST['hash']));

		// declare object			
		$tb = new ElybinTable('elybin_message');

		// get from current user
		$u = _u();

		// check id exist or not
		$cm = $tb->SelectFullCustom("
			SELECT
			*,
			COUNT(mid) as `row` 
			FROM
			`elybin_message` as `m`
			WHERE
			`m`.`mid` = '$mid' &&
			(`m`.`from_uid` = '".$u->user_id."' || `m`.`to_uid` = '".$u->user_id."')
			")->current();
		if($cm->row < 1){
			header('location: ../../../404.html');
			exit;
		}

		// actually not delete, but change status_recp to 'deleted'
		if($cm->from_uid == $u->user_id && $cm->to_uid == $u->user_id){
			$d = array(
				'msg_status' => 'deleted',
				'msg_status_recp' => 'deleted'
				);
		}
		else if($cm->from_uid == $u->user_id){
			$d = array(
				'msg_status' => 'deleted'
				);
		}else{
			$d = array(
				'msg_status_recp' => 'deleted'
				);	
		}
		$tb->Update($d, 'mid', $mid);

		//Done
		header('location: ../../admin.php?mod=messager&msg=deleted');
	}
	//MULTI DEL
	elseif ($mod=='messager' AND $act=='multidel'){
		//array of delected contact
		$arr_mid = @$_POST['del'];
		//if id array empty
		if(!empty($arr_mid)){
			// check id exist or not
			$tb = new ElybinTable('elybin_message');
			// get from current user
			$u = _u();

			foreach ($arr_mid as $arr_id) {
				// explode data because we use pipe
				$pecah = @explode("|",$arr_id);
				$pecah = $pecah[0];
				// check id safe from sqli
				$mid = $v->sql(epm_decode($pecah));
				
				// check id exist or not
				$cm = $tb->SelectFullCustom("
					SELECT
					*,
					COUNT(mid) as `row` 
					FROM
					`elybin_message` as `m`
					WHERE
					`m`.`mid` = '$mid' &&
					(`m`.`from_uid` = '".$u->user_id."' || `m`.`to_uid` = '".$u->user_id."')
					")->current();
				if($cm->row < 1){
					header('location: ../../../404.html');
					exit;
				}
				// actually not delete, but change status_recp to 'deleted'
				if($cm->from_uid == $u->user_id && $cm->to_uid == $u->user_id){
					$d = array(
						'msg_status' => 'deleted',
						'msg_status_recp' => 'deleted'
						);
				}
				else if($cm->from_uid == $u->user_id){
					$d = array(
						'msg_status' => 'deleted'
						);
				}else{
					$d = array(
						'msg_status_recp' => 'deleted'
						);	
				}
				$tb->Update($d, 'mid', $mid);	
			}
			// done			
			header('location: ../../admin.php?mod=messager&msg=deleted');
		}
	}
	//404
	else{
		header('location: ../../../404.html');
	}
}	
?>