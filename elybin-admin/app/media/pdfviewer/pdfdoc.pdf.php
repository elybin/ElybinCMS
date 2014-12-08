<?php
include_once('../../../../elybin-core/elybin-function.php');
include_once('../../../../elybin-core/elybin-oop.php');
include_once('../../../lang/main.php');

$v = new ElybinValidasi;
$id = $v->sql($_GET['id']);

// get filename
$tb 	= new ElybinTable('elybin_media');
$cmedia	= $tb->SelectCustom("SELECT * FROM","WHERE MD5(`media_id`) = '$id'")->current();
if($cmedia->type!=="application/pdf"){	
	header('location: ../../../../404.html');
	exit;
}

$filename = $cmedia->filename;
include "../../../../elybin-file/media/$filename";
?>