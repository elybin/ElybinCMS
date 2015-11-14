<?php
session_start();
include_once('../../elybin-core/elybin-function.php');
include_once('../../elybin-core/elybin-oop.php');
include_once('../elybin-infograb.php');
include_once('../../elybin-admin/lang/main.php');

$v = new ElybinValidasi;
settzone();

//if comment deny
if(get_option('default_comment_status') =="deny"){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Comment Disabled'),
		'msg_ses' => 'comment_disabled',
		'red' => get_url('post', $post_id).'#message'
	), @$_GET['r']);
}


// get data
if(empty($_SESSION['login'])){
	$post_id = epm_decode($v->sql($_POST['post_id']));
	$name = $v->xss(@$_POST['name']);
	$email = $v->xss(@$_POST['email']);
	$url = @$_POST['url'];
	$content = htmlspecialchars(@$_POST['message']);
	$avatar = "default/medium-no-ava.png";
	$status = (get_option('default_comment_status')=='confrim' ? 'deactive': 'active');
	$uid = 0;

	// save to session
	$_SESSION['comment_name'] = @$name;
	$_SESSION['comment_email'] = @$email;
	$_SESSION['comment_url'] = @$url;
	$_SESSION['comment_content'] = @$content;

	//if field empty
	if(empty($name)){
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Please fill your name'),
			'msg_ses' => 'fill_name',
			'red' => get_url('post', $post_id).'#message'
		), @$_GET['r']);
	}
	// validate
	$v->name($name, get_url('post', $post_id).'#message');

	if(empty($email)){
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Please fill your email'),
			'msg_ses' => 'fill_email',
			'red' => get_url('post', $post_id).'#message'
		), @$_GET['r']);
	}
	// validate
	$v->mail($email, get_url('post', $post_id).'#message');

	if(empty($content)){
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Write your comment message'),
			'msg_ses' => 'fill_message',
			'red' => get_url('post', $post_id).'#message'
		), @$_GET['r']);
	}


}else{
	// get current active user
	$u = _u();

	$post_id = epm_decode($v->sql($_POST['post_id']));
	$name = $u->fullname;
	$email = $u->user_account_email;
	$url = @$_POST['url'];
	$content = htmlentities(@$_POST['message'], ENT_QUOTES);
	$avatar = ($u->avatar == 'default/no-ava.png' ? 'default/medium-no-ava.png': "md-{$u->avatar}");
	$status = (get_option('default_comment_status')=='confrim' ? 'deactive': 'active');
	$uid = $u->user_id;

	// save to session
	$_SESSION['comment_name'] = @$name;
	$_SESSION['comment_email'] = @$email;
	$_SESSION['comment_url'] = @$url;
	$_SESSION['comment_content'] = @$content;

	//if field empty
	if(empty($content)){
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('Write your comment message'),
			'msg_ses' => 'fill_message',
			'red' => get_url('post', $post_id).'#message'
		), @$_GET['r']);
	}
}
//if overflow
if(strlen($content) > 500){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Maximum message is 500 character.'),
		'msg_ses' => 'max_content',
		'red' => get_url('post', $post_id).'#message'
	), @$_GET['r']);
}
// if code wrong
if(checkcode(@$_POST['code']) == false){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Invalid Code'),
		'msg_ses' => 'captcha_error',
		'red' => get_url('post', $post_id).'#message'
	), @$_GET['r']);
}
// if post deny commenting
$p = _p('post_id', $post_id);
if($p->comment != 'allow'){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Comment Disabled'),
		'msg_ses' => 'comment_disabled',
		'red' => get_url('post', $post_id).'#message'
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
if(get_option('default_comment_status') =="allow"){
	result(array(
		'status' => 'ok',
		'title' => lg('Success'),
		'msg' => lg('Comment Saved.'),
		'msg_ses' => 'comment_saved',
		'red' => get_url('post', $post_id).'#message',
		'fullname' => $name,
		'message' => $content,
		'avatar' => $avatar
	), @$_GET['r']);
}
elseif(get_option('default_comment_status')=="confrim"){
	result(array(
		'status' => 'ok',
		'title' => lg('Success'),
		'msg' => lg('Comment saved, and waiting moderation.'),
		'msg_ses' => 'comment_saved',
		'red' => get_url('post', $post_id).'#message',
		'fullname' => $name,
		'message' => $content,
		'avatar' => $avatar
	), @$_GET['r']);
}

// destroy cp session (still not effective)
unset($_SESSION['cp']);
$_SESSION['cp']='';
exit;
?>
