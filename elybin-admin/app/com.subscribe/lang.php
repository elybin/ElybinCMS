<?php
/* Short description for file
 * [ Plugin: Self Dict
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
$default_language = "en";

//get current language
$tbo = new ElybinTable('elybin_options');
$clg = $tbo->SelectWhere('name','language','','')->current()->value;

$cmod = @$_GET['mod'];
$lgdir = "./app/$cmod/lang/$clg/$clg.php";

if(file_exists($lgdir)){
	include_once($lgdir);
}else{
	include_once("./app/$cmod/lang/$default_language/$default_language.php");
}
?>