<?php
session_start();	
include_once('../../elybin-core/elybin-function.php');
include_once('../../elybin-core/elybin-oop.php');
include_once('../elybin-infograb.php');
include_once('../../elybin-admin/lang/main.php');

$v = new ElybinValidasi;
settzone();

$op = _op();

//if comment deny
if($op->default_comment_status=="deny"){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Comment Disabled'),
		'msg_ses' => 'comment_disabled',
		'red' => 'post-'.$post_id.'-post.html'
	), @$_GET['r']);
}


// get data
if(empty($_SESSION['login'])){
	$post_id = $v->sql(@$_POST['post_id']);
	$name = $v->xss(@$_POST['name']);
	$email = $v->xss(@$_POST['email']);
	$content = htmlspecialchars(@$_POST['message']);
	$avatar = "default/medium-no-ava.png";
	if($op->default_comment_status=="confrim"){ $status = "deactive"; }else{ $status = "active";}
	$uid = 0;

	//if field empty
	if(empty($name) OR empty($email) OR empty($content)){
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Please fill important field (*)'),
			'msg_ses' => 'fill_important',
			'red' => 'post-'.$post_id.'-post.html'
		), @$_GET['r']);
	}

	// validate
	$v->name($name,'post-'.$post_id.'-post.html');
	$v->mail($email, 'post-'.$post_id.'-post.html');


}else{
	// get current active user
	$u = _u();

	$post_id = $v->sql(@$_POST['post_id']);
	$name = $u->fullname;
	$email = $u->user_account_email;
	$content = htmlentities(@$_POST['message'], ENT_QUOTES);
	if($u->avatar == "default/no-ava.png"){ $avatar = "default/medium-no-ava.png"; }else{ $avatar = "md-$u->avatar";}
	if($op->default_comment_status=="confrim"){ $status = "deactive"; }else{ $status = "active";}
	$uid = $u->user_id;

	//if field empty
	if(empty($content)){
		//fill important
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Please fill important field (*)'),
			'msg_ses' => 'fill_important',
			'red' => 'post-'.$post_id.'-post.html'
		), @$_GET['r']);
	}
}	
//if overflow
if(strlen($content) > 500){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Maximum content is 500 character.'),
		'msg_ses' => 'max_content',
		'red' => 'post-'.$post_id.'-post.html'
	), @$_GET['r']);
}
// if code wrong
if(checkcode(@$_POST['code']) == false){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Invalid Code'),
		'msg_ses' => 'captcha_error',
		'red' => 'post-'.$post_id.'-post.html'
	), @$_GET['r']);
}
// if post deny commenting
$p = _p('post_id', $post_id);
if($p->comment!=='allow'){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Comment Disabled'),
		'msg_ses' => 'comment_disabled',
		'red' => 'post-'.$post_id.'-post.html'
	), @$_GET['r']);
}

// get visitor id 
$vi = _vi('visitor_ip', $_SERVER['REMOTE_ADDR']);

// prepare data
$tbc = new ElybinTable('elybin_comments');
$tbc->Insert(array(
	'author' => $name,
	'email' => $email,
	'visitor_id' => $vi->visitor_id,
	'date' => date('Y-m-d H:i:s'),
	'content' => $content,
	'status' => $status,
	'post_id' => $post_id,
	'user_id' => $uid
));

// push notif
pushnotif(array(
	'module'	=> 'comment',
	'icon'		=> 'fa-comments',
	'type'		=> 'info',
	'code' 		=> 'new_comment',
	'title'		=> lg('New Comment'),
	'content'	=> '<b>'.strip_tags($name).'</b> &#34;'.substr(strip_tags($content),0,100).';...&#34<br/>'.substr($p->title,0,20).'...'
));

	
//Done
if($op->default_comment_status=="allow"){
	result(array(
		'status' => 'ok',
		'title' => lg('Success'),
		'msg' => lg('Comment Saved.'),
		'msg_ses' => 'comment_saved',
		'red' => 'post-'.$post_id.'-post.html',
		'fullname' => $name,
		'message' => $content,
		'avatar' => $avatar
	), @$_GET['r']);
}
elseif($op->default_comment_status=="confrim"){
	result(array(
		'status' => 'ok',
		'title' => lg('Success'),
		'msg' => lg('Comment saved, and waiting moderation.'),
		'msg_ses' => 'comment_saved',
		'red' => 'post-'.$post_id.'-post.html',
		'fullname' => $name,
		'message' => $content,
		'avatar' => $avatar
	), @$_GET['r']);
}

// destroy cp session (still not effective)
unset(@$_SESSION['cp']); @$_SESSION['cp']='';
exit;
?>