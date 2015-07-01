<?php
session_start();

if(!file_exists("./elybin-core/elybin-config.php")){
	header('location: ./elybin-install/');
	exit;
}

include_once('./elybin-core/elybin-function.php');
include_once('./elybin-core/elybin-oop.php');
include_once('./elybin-admin/lang/main.php');
include_once('./elybin-main/elybin-infograb.php');

// get current active themes
$tbt = new ElybinTable('elybin_themes');
$ctheme = $tbt->SelectWhere('status','active','','')->current();
// get maintenance status
$tbo = new ElybinTable('elybin_options');
$maintenance = $tbo->SelectWhere('name','maintenance_mode','','')->current()->value;
$default_homepage = $tbo->SelectWhere('name','default_homepage ','','')->current()->value;

$mod = @$_GET['mod'];
$p = @$_GET['p'];  	
if ($maintenance == "active"){
	header('location: maintenance.html');
}else{
	// count visitor
	$tbv = new ElybinTable("elybin_visitor");
	$ip = str_replace("IP: ","", client_info("yes"));
	$covisitor = $tbv->GetRow('visitor_ip', $ip);
	if($covisitor == 0){
		// record new
		$data = array(
			'visitor_ip' => $ip,
			'date' => date("Y-m-d"),
			'hits' => 1,
			'online' => date("Y-m-d H:i:s")
		);
		$tbv->Insert($data);
	}else{
		// Get prev data
		$cvisitor = $tbv->SelectWhere('visitor_ip', $ip,'','')->current();
		$hits = $cvisitor->hits+1;
		// ban malicious user
		if($cvisitor->status == "deny"){
			header('location: maintenance.html');
			exit;
		}
		
		// update exiting
		$data = array(
			'hits' => $hits,
			'online' => date("Y-m-d H:i:s")
		);
		$tbv->Update($data,'visitor_ip', $ip);
	}
	
	// redirect to default homepage if is set
	$tbmn = new ElybinTable('elybin_menu');
	$chomepage = $tbmn->GetRow('menu_id', $default_homepage);
	if($chomepage == 1 && $chomepage !== "" && $mod == "index"){
		$menu = $tbmn->SelectWhere('menu_id', $default_homepage,'','')->current();
		$menu_url = $menu->menu_url;
		
		// jika bukan index  yang jadi default
		if($menu->menu_id > 1){
			// redirect
			header('location: '.$menu_url);
			
			// terminate main include page
			exit;
		}
	}
	
	// include page
	if (file_exists("elybin-file/theme/$ctheme->folder/$mod.php")){
		include "elybin-file/theme/$ctheme->folder/$mod.php";
	}else{
		include "elybin-file/theme/$ctheme->folder/index.php";
	}
}
?>