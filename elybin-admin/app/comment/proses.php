<?php
/* Short description for file
 * [ Module: Comment Proccess
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

	if($mod=='comment' AND $act=='edit'){
		$comment_id = $v->sql($_POST['comment_id']);
		$content = htmlspecialchars($_POST['content'],ENT_QUOTES);
		$status = @$_POST['status'];
		if($status){
			$status = "active";
		}else{
			$status = "deactive";
		}

		// check id exist or not
		$tbl = new ElybinTable('elybin_comments');
		$cocomment = $tbl->GetRow('comment_id', $comment_id);
		if(empty($comment_id) OR ($cocomment == 0)){
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_iderrorpleasereloadpage
			);

			json($a);
			exit;
		}

		//if field empty
		if(empty($content)){
			//fill important
			$a = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => $lg_pleasefillimportant
			);

			json($a);
			exit;
		}

		//get comment information 
		$getuser = $tbl->SelectWhere('comment_id',$comment_id,'','');
		$getuser = $getuser->current();

		//if user are exist in table user
		if($getuser->user_id > 0){
			//get user id
			$tbluser = new ElybinTable('elybin_users');
			$cuser = $tbluser->SelectWhere('user_id',$getuser->user_id,'','');
			$cuser = $cuser->current();
			$author = $cuser->fullname;
			$email = $cuser->user_account_email;
			$data = array(
				'author' => $author,
				'email' => $email,
				'content' => $content,
				'status' => $status	
				);
		}else{
			//if anonymous
			$author = $v->xss($_POST['author']);
			$email = $v->xss($_POST['email']);
					//if field empty
			if(empty($author) AND empty($email)){
				//please fill important
				$a = array(
					'status' => 'error',
					'title' => $lg_error,
					'isi' => $lg_pleasefillimportant
				);

				json($a);
				exit;
			}
			$data = array(
				'author' => $author,
				'email' => $email,
				'content' => $content,
				'status' => $status	
				);
		}

		$tbl->Update($data,'comment_id',$comment_id);
		
		//Done
		$a = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_dataeditsuccessful
		);
		json($a);
	}

	//DEL
	elseif($mod=='comment' AND $act=='del'){
		//validate id from sqli
		$comment_id = $v->sql($_POST['comment_id']);
		$tabledel = new ElybinTable('elybin_comments');

		// check id exist or not
		$cocomment = $tabledel->GetRow('comment_id', $comment_id);
		if(empty($comment_id) OR ($cocomment == 0)){
			header('location: ../../../404.html');
			exit;
		}
		$tabledel->Delete('comment_id', $comment_id);

		//Done
		header('location:../../admin.php?mod='.$mod);
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
				$comment_id_fix = $v->sql($pecah);
				
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
		header('location :../../../404.html');
	}
}	
?>