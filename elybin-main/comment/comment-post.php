<?php
session_start();	
include_once('../../elybin-core/elybin-function.php');
include_once('../../elybin-core/elybin-oop.php');
include_once('../elybin-infograb.php');
include_once('../../elybin-admin/lang/main.php');

$v = new ElybinValidasi;
$tbc = new ElybinTable('elybin_comments');
settzone();

//if comment deny
if($op->default_comment_status=="deny"){
	header('location: ../../404.html');
	exit;
}

if(empty($_SESSION['login'])){

	$post_id = $v->sql($_POST['post_id']);
	$name = $v->xss($_POST['name']);
	$email = $v->xss($_POST['email']);
	$content = htmlspecialchars($_POST['message']);
	$ip = $_SERVER['REMOTE_ADDR'];
	$date = date("Y-m-d");
	$time = date("H:i:s");
	$avatar = "default/medium-no-ava.png";
	if($op->default_comment_status=="confrim"){
		$status = "deactive";
	}else{
		$status = "active";
	}

	//if field empty
	if(empty($name) OR empty($email) OR empty($content)){
		//fill important
		$s = array(
			'status' => 'error',
			'title' => $lg_error,
			'isi' => $lg_pleasefillimportant
		);
		echo json_encode($s);
		exit;
	}
	
	// if code wrong
	if(checkcode(@$_POST['code']) == false){
		//fill important
		$s = array(
			'status' => 'error',
			'title' => $lg_error,
			'isi' => $lg_invalidcode
		);
		echo json_encode($s);
		exit;
	}
	
	// prepare data
	$data = array(
		'author' => $name,
		'email' => $email,
		'ip' => $ip,
		'date' => $date,
		'time' => $time,
		'content' => $content,
		'status' => $status,
		'post_id' => $post_id
	);
	
	// push notif
	$dpn = array(
		'code' => 'new_comment',
		'title' => '$lg_comment',
		'icon' => 'fa-comments',
		'type' => 'info',
		'content' => '[{"post_id":"'.$post_id.'", "author":"'.$name.'", "user_id":"", "content":"'.htmlentities($content, ENT_QUOTES).'", "single":"$lg_newcommentfrom","more":"$lg_newcomments"}]'
	);
	pushnotif($dpn);
}else{	
	// get current active user
	$s = $_SESSION['login'];
	$tblu = new ElybinTable("elybin_users");
	$tblu = $tblu->SelectWhere("session","$s","","");
	$tblu = $tblu->current();

	$post_id = $v->sql($_POST['post_id']);
	$name = $tblu->fullname;
	$email = $tblu->user_account_email;
	$content = htmlentities($_POST['message'], ENT_QUOTES);
	$ip = $_SERVER['REMOTE_ADDR'];
	$date = date("Y-m-d");
	$time = date("H:i:s");
	
	if($tblu->avatar == "default/no-ava.png"){
		$avatar = "default/medium-no-ava.png";
	}else{
		$avatar = "medium-$tblu->avatar";
	}
	if($op->default_comment_status=="confrim"){
		$status = "deactive";
	}else{
		$status = "active";
	}

	//if field empty
	if(empty($content)){
		//fill important
		$s = array(
			'status' => 'error',
			'title' => $lg_error,
			'isi' => $lg_pleasefillimportant
		);
		echo json_encode($s);
		exit;
	}
	
	// if code wrong
	if(checkcode(@$_POST['code']) == false){
		//fill important
		$s = array(
			'status' => 'error',
			'title' => $lg_error,
			'isi' => $lg_invalidcode
		);
		echo json_encode($s);
		exit;
	}

	// prepare data
	$data = array(
		'author' => NULL,
		'email' => NULL,
		'ip' => $ip,
		'date' => $date,
		'time' => $time,
		'content' => $content,
		'status' => $status,
		'post_id' => $post_id,
		'user_id' => $tblu->user_id
	);
	
	// push notif
	$dpn = array(
		'code' => 'new_comment',
		'title' => '$lg_comment',
		'icon' => 'fa-comments',
		'type' => 'info',
		'content' => '[{"post_id":"'.$post_id.'", "user_id":"'.$tblu->user_id.'", "content":"'.$tblu->fullname.'", "single":"$lg_newcommentfrom","more":"$lg_newcomments"}]'
	);
	pushnotif($dpn);
}	
	// if post deny commenting
	$tbpo = new ElybinTable('elybin_posts');
	$cpost = $tbpo->SelectWhere('post_id', $post_id, '', '')->current();
	if($cpost->comment!=='allow'){
		header('location: ../../404.html');
		exit;
	}

	$tbc->Insert($data);
	$value_n = "$lg_newcommentfrom <strong>$name</strong>";
	//notif_push('new_comment', 'comment', $value_n, 'info', 'fa-comments');

	
	//Done
	if($op->default_comment_status=="allow"){
		$s = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_commenthasbeenadded,
			'fullname' => $name,
			'message' => $content,
			'avatar' => $avatar
		);
	}
	elseif($op->default_comment_status=="confrim"){
		$s = array(
			'status' => 'ok',
			'title' => $lg_success,
			'isi' => $lg_commenthasbeenaddedwaitingadminconfirmation,
			'fullname' => $name,
			'message' => $content,
			'avatar' => $avatar
		);
	}
	echo json_encode($s);

?>