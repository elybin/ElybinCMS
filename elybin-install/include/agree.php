<?php
/* Short description for file
 * Install : Agree
 * recieve post from `index.php` and create `install_date.txt` for limiting installation only for 24 hours
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */

include_once('../../elybin-admin/lang/main.php');
include_once('../../elybin-core/elybin-function.php'); 
 
// check agreement
if(empty($_POST['agree'])){
	header('location: ../index.php?err=pleaseagree');
	exit;
}else{
	if($_POST['agree'] !== "on"){
		header('location: ../index.php?err=pleaseagree');
		exit;
	}

// check `backup` true?
if(@$_POST['backup'] == true){
	include("upgrade.php");
	exit;
}
	
// write installation date
$f = fopen("../install_date.txt", "w");
fwrite($f, date("Y-m-d"));
fclose($f);

// redirect to step1
header('location: ../step1.php');
}

?>