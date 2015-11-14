<?php
/* Short description for file
 * [ Module: Comment Proccess
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
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

	// REPLY
	if($mod=='comment' AND $act=='reply'){
		$cid = $v->sql(epm_decode(@$_POST['hash']));
		$content = htmlspecialchars(@$_POST['content'],ENT_QUOTES);

		// check id exist or not
		// single query
		$tb = new ElybinTable('elybin_comments');
		$cc = $tb->SelectFullCustom("
		SELECT
		*,
		COUNT(*) as `row`
		FROM
		`elybin_comments` as `c`
		LEFT JOIN
			`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
		WHERE
		`c`.`comment_id` = '$cid'
		LIMIT 0,1
		")->current();

		if($cc->row < 1){
			json(array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_iderrorpleasereloadpage
			));
		}

		// get current user
		$cu = _u();

		//if field empty
		if(empty($content)){
			//fill important
			json(array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => lg('Please fill our reply first.')
			));
		}


		// insert
		$d = array(
			'author' => $cu->fullname,
			'email' => $cu->user_account_email,
			'content' => @$SESSION['visitor'],
			'date' => date('Y-m-d H:i:s'),
			'content' => $content,
			'parent' => $cid,
			'user_id' => $cu->user_id,
			'post_id' => $cc->post_id,
			'status' => 'active',
		);
		$tb->Insert($d);

		// update comment reply status to yes
		$ar = array('reply' => 'yes');
		$tb->Update($ar, 'comment_id', $cid);

		//Done
		// check the data result
		if(@$_GET['result'] == 'json'){
			// json
			json(array(
				'status' => 'ok',
				'title' => lg('Success'),
				'isi' => lg('Your reply successfully posted.'),
				'callback' => 'reply',
				'callback_hash' => @$_POST['hash'],
				'callback_msg' => 'posted'
			));
		}else{
			// redirect
			header('location: ../../admin.php?mod=comment&filter=unread&hash='.@$_POST['hash'].'&msg=posted');
		}
	}

	//BLOCK
	elseif($mod=='comment' AND $act=='block'){
		//validate id from sqli
		$cid = $v->sql(epm_decode(@$_POST['hash']));
		$tb = new ElybinTable('elybin_comments');

		// check id exist or not
		$cc = $tb->SelectFullCustom("
		SELECT
		`c`.`user_id`,
		COUNT(`comment_id`) as `row`
		FROM
		`elybin_comments` as `c`
		WHERE
		`c`.`comment_id` = '$cid' &&
		`c`.`user_id` != '"._u()->user_id."' &&
		`c`.`status` = 'active'
		LIMIT 0,1
		")->current();

		// check row
		if($cc->row < 1){
			header('location: ../../../404.html');
			exit;
		}

		// can't do self block
		if($cc->user_id == _u()->user_id){
			header('location: ../../../404.html');
			exit;
		}

		// change status to blocked
		$ar = array('status' => 'blocked');
		$tb->Update($ar,'comment_id', $cid);

		//Done
		header('location:../../admin.php?mod=comment&filter=blocked&hash='.@$_POST['hash'].'&msg=blocked');
	}
	//UNBLOCK
	elseif($mod=='comment' AND $act=='unblock'){
		//validate id from sqli
		$cid = $v->sql(epm_decode(@$_POST['hash']));
		$tb = new ElybinTable('elybin_comments');

		// check id exist or not
		$cc = $tb->SelectFullCustom("
		SELECT
		`c`.`user_id`,
		COUNT(`comment_id`) as `row`
		FROM
		`elybin_comments` as `c`
		WHERE
		`c`.`comment_id` = '$cid' &&
		`c`.`user_id` != '"._u()->user_id."' &&
		`c`.`status` = 'blocked'
		LIMIT 0,1
		")->current();

		// check row
		if($cc->row < 1){
			header('location: ../../../404.html');
			exit;
		}

		// can't do self unblock
		if($cc->user_id == _u()->user_id){
			header('location: ../../../404.html');
			exit;
		}

		// change status to blocked
		$ar = array('status' => 'active');
		$tb->Update($ar,'comment_id', $cid);

		//Done
		header('location:../../admin.php?mod=comment&hash='.@$_POST['hash'].'&msg=unblocked');
	}

	//DEL
	elseif($mod=='comment' AND $act=='del'){
		//validate id from sqli
		$cid = $v->sql(epm_decode(@$_POST['hash']));
		$tb = new ElybinTable('elybin_comments');

		// check id exist or not
		$cc = $tb->SelectFullCustom("
		SELECT
		*,
		COUNT(`comment_id`) as `row`
		FROM
		`elybin_comments` as `c`
		WHERE
		`c`.`comment_id` = '$cid'
		LIMIT 0,1
		")->current();
		if($cc->row < 1){
			header('location: ../../../404.html');
			exit;
		}
		$tb->Delete('comment_id', $cid);

		//Done
		header('location:../../admin.php?mod=comment&act=reply&hash='.epm_encode($cc->parent).'&msg=deleted');
	}
	//MULTI DEL
	elseif($mod=='comment' AND $act=='multidel'){
		//array of delected comment
		$comment_id = $_POST['del'];

		//if id array empty
		if(!empty($comment_id)){
			foreach ($comment_id as $ps) {
				// explode data because we use pipe
				$pecah = explode("|",$ps);
				$pecah = $pecah[0];
				// check id safe from sqli
				$comment_id_fix = epm_decode($v->sql($pecah));

				// check id exist or not
				$tb = new ElybinTable('elybin_comments');
				$cocomment = $tb->GetRow('comment_id', $comment_id_fix);
				if(empty($comment_id_fix) OR ($cocomment == 0)){
					header('location: ../../../404.html');
					exit;
				}

				//Done
				$tb->Delete('comment_id', $comment_id_fix);
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
