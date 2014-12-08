<?php
session_start();	
include_once('../../elybin-core/elybin-function.php');
include_once('../../elybin-core/elybin-oop.php');
include_once('../elybin-infograb.php');
include_once('../../elybin-admin/lang/main.php');

$v = new ElybinValidasi;
$tbcn = new ElybinTable('elybin_contact');
settzone();

$name = $v->xss(@$_POST['name']);
$email = $v->xss(@$_POST['email']);
$content = htmlspecialchars(@$_POST['message']);
$date = date("Y-m-d");
$time = date("H:i:s");


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
	'name' => $name,
	'email' => $email,
	'content' => $content,
	'date' => $date,
	'time' => $time,
	'status' => 'unread'
);
$tbcn->Insert($data);

// push notif
$dpn = array(
	'code' => 'new_message',
	'title' => '$lg_message',
	'icon' => 'fa-envelope',
	'type' => 'info',
	'content' => '[{"content":"'.$name." (".$email.')", "single":"$lg_newmessagefrom","more":"$lg_newmessages"}]'
);
pushnotif($dpn);

//Done
$s = array(
	'status' => 'ok',
	'title' => $lg_success,
	'isi' => $lg_messagesentthankyoucontactus
);
echo json_encode($s);
?>