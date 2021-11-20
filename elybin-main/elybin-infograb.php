<?php
// get options
$tbo = new ElybinTable('elybin_options');

// this is all information
$option = array('cmsbase' => "ElybinCMS");

// option
$getop = $tbo->Select('','');
foreach ($getop as $go) {
	$option = array_merge($option, array($go->name => $go->value));
}

// themes
// get current active themes
$tbt = new ElybinTable('elybin_themes');
$ctheme = $tbt->SelectWhere('status','active','','')->current();
$option = array_merge($option, array('themes_folder' => $option['site_url']."/elybin-file/theme/".$ctheme->folder."/"));

//print_r($option);

// convert array to object
$op = new stdClass();
foreach ($option as $key => $value)
{
    $op->$key = $value;
}

?>