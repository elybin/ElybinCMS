<?php
// 1.1.3 
// - Updating result funciton
session_start();	
include_once('../../elybin-core/elybin-function.php');
include_once('../../elybin-core/elybin-oop.php');
include_once('../elybin-infograb.php');
include_once('../../elybin-admin/lang/main.php');

$v = new ElybinValidasi;
settzone();

$name = $v->xss(@$_POST['name']);
$email = $v->xss(@$_POST['email']);
$subject = $v->xss(@$_POST['subject']);
$content = htmlspecialchars(@$_POST['message']);
$date = date("Y-m-d H:i:s");


// validate
$v->name($name, 'contact.html');
$v->mail($email, 'contact.html');

//if field empty
if(empty($name) OR empty($email) OR empty($content)){
	//fill important
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Please fill important field'),
		'red' => 'contact.html'
	), @$_GET['r']);
}

//if overflow
if(strlen($content) > 500){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Maximum content is 500 character.'),
		'msg_ses' => 'max_content',
		'red' => 'contact.html'
	), @$_GET['r']);
}
// if code wrong
if(checkcode(@$_POST['code']) == false){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Invalid Code'),
		'msg_ses' => 'captcha_error',
		'red' => 'contact.html'
	), @$_GET['r']);
}

$tbm = new ElybinTable('elybin_message');
//1.1.3
// duplicate messages detection
$coc = $tbm->SelectFullCustom("
	SELECT 
	COUNT(`mid`) as `row`
	FROM
	`elybin_message` as `m`
	WHERE
	`m`.`subject` = '$subject' || 
	`m`.`msg_body` = '$content' || 
	`m`.`from_name` = '$name' 
	ORDER BY `mid` DESC
	LIMIT 0,1
")->current();
// kill
if($coc->row > 0){
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Dublicate message detected'),
		'msg_ses' => 'duplicate_message',
		'red' => 'contact.html'
	), @$_GET['r']);
	exit;
}


// prepare data
$tbm->Insert(array(
	'subject' => $subject,
	'msg_body' => $content,
	'msg_date' => $date,
	'msg_type' => 'feedback',
	'msg_priority' => 'normal',
	'msg_status' => 'sent',
	'msg_status_recp' => 'received',
	'from_uid' => 0,
	'from_email' => $email,
	'from_name' => $name,
	'to_uid' => 1
));

// push notif
pushnotif(array(
	'module'	=> 'messager',
	'icon'		=> 'fa-envelope',
	'type'		=> 'info',
	'code' 		=> 'new_message',
	'title'		=> lg('New Message'),
	'content'	=> '<b>'.strip_tags($name).'</b> &#34;'.substr(strip_tags($content),0,100).';...&#34<br/>...'
));

//Done
result(array(
	'status' => 'ok',
	'title' => lg('Success'),
	'msg' => lg('Messages sent, we\'ll respone it as soon as possible'),
	'red' => 'contact.html'
), @$_GET['r']);


// destroy cp session (still not effective)
unset($_SESSION['cp']); @$_SESSION['cp']='';
exit;
?>