<?php
session_start();	
include_once('../../elybin-core/elybin-function.php');
include_once('../../elybin-core/elybin-oop.php');
include_once('../elybin-infograb.php');
include_once('../../elybin-admin/lang/main.php');
include_once('lang.php');

$v = new ElybinValidasi;
$tbes = new ElybinTable('com.elybin_subscribe');
settzone();

$email = $v->xss(@$_POST['email']);
$date = date("Y-m-d");
$time = date("H:i:s");

//if field empty
if(empty($email)){
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
	'email' => $email,
	'date' => $date,
	'time' => $time,
	'status' => 'active'
);
$tbes->Insert($data);

// push notif
$dpn = array(
	'code' => 'new_subscriber',
	'module' => 'com.subscribe',
	'title' => '$lg_subscribe',
	'icon' => 'fa-rss',
	'type' => 'success',
	'content' => '[{"content":"'.$email.'", "single":"$lg_newsubscribefrom","more":"$lg_newsubscriber"}]'
);
pushnotif($dpn);

// Leave Session
$_SESSION['donesubscribe'] = true;

//Done
$s = array(
	'status' => 'ok',
	'title' => $lg_success,
	'isi' => $lg_thankyounowyouwillrecieveupdateautomatically
);
echo json_encode($s);
?>