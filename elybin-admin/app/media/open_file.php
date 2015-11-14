<?php
/* *
 * Media download and share link.
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */

// string validation for security
$v 	= new ElybinValidasi();

// check id exist or not
$tb = new ElybinTable('elybin_media');
$hash 	= $v->sql($_GET['media']);

// if shared
$com = $tb->GetRowAnd('hash', $hash, 'share', 'yes');
// check existance
if($com < 1){
	redirect(get_url('404'));
	exit;
}
// get data
$cm	= $tb->SelectWhereAnd('hash', $hash, 'share', 'yes')->current();

// file
if(@$_GET['mode'] == 'd'){
	// set header
	header('Content-Disposition: attachment;filename="'.$cm->title.'"');
}
// and include
header('Content-Type: '.$cm->mime);
include('elybin-file/media/'.$cm->filename);

// download + 1
$tb->Custom("UPDATE","SET  `download` =  `download`+1 WHERE  `media_id` = ".$cm->media_id);
