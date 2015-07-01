<?php
session_start();
include_once('../../../elybin-core/elybin-function.php');
include_once('../../../elybin-core/elybin-oop.php');

// string validation for security
$v 	= new ElybinValidasi();

// check id exist or not
$tb = new ElybinTable('elybin_media');
$hash 	= $v->sql($_GET['hash']);

// give error if no have privilage
if(!$_SESSION['login']){
	// if public
	$com = $tb->GetRowAnd('hash', $hash, 'share', 'yes');
	
	if($com < 1){
		echo '404';
		exit;
	}
	
	// file
	if(@$_GET['mode'] == 'd'){
		// download + 1
		$tb->Custom("UPDATE","SET  `download` =  `download`+1 WHERE  `media_id` = ".$cm->media_id);
		header('Content-Disposition: attachment;filename="'.$cm->filename.'"');
	}
}else{	
	$cm	= $tb->SelectWhere('hash',$hash)->current();
	// type
	header('Content-Type: '.$cm->mime);
	
	// diferent size - image
	if($cm->type == 'image'){
		if(@$_GET['mode'] == 'v' || @$_GET['mode'] == 'o' || @$_GET['mode'] == 'd'){
			include('../../../elybin-file/media/'.$cm->filename);
		}
		// medium image (300px)
		elseif(@$_GET['mode'] == 'm'){
			include('../../../elybin-file/media/medium-'.$cm->filename);
		}
		// small image (100px)
		elseif(@$_GET['mode'] == 's' || @$_GET['mode'] == 'sm'){
			include('../../../elybin-file/media/sm-'.$cm->filename);
		}
		// x-small image (50px)
		elseif(@$_GET['mode'] == 'xs'){
			include('../../../elybin-file/media/xs-'.$cm->filename);
		}
	}else{
		// other file
		include('../../../elybin-file/media/'.$cm->filename);
	}


}
?>