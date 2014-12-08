<?php
include_once('../../../../elybin-core/elybin-function.php');
include_once('../../../../elybin-core/elybin-oop.php');
include_once('../../../lang/main.php');

$v = new ElybinValidasi;
$id = $v->sql($_GET['id']);

// get filename
$tb 	= new ElybinTable('elybin_media');
$cmedia	= $tb->SelectWhere('media_id',$id,'','')->current();
if($cmedia->type!=="application/pdf"){	
	header('location: ../../../../404.html');
	exit;
}

// set header to download
header("Content-Type: application/download");
header("Content-Type: attachment;filename=dos.pdf");
$filename = $cmedia->filename;
include "../../../../elybin-file/media/$filename";
?>