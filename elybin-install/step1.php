<?php
session_start();
if(file_exists("../elybin-core/elybin-config.php")){
	header('location: ../404.html');
	exit;
}

include_once('../elybin-admin/lang/main.php');

// get data
$db_host = @$_POST['db_host'];
$db_user = @$_POST['db_user'];
$db_pass = @$_POST['db_pass'];
$db_name = @$_POST['db_name'];

//if field empty
if(empty($db_host) || empty($db_user) || empty($db_pass) || empty($db_name)){
	if(empty($db_host)){
		$err = "db_host";
	}
	elseif(empty($db_user)){
		$err = "db_user";
	}
	elseif(empty($db_pass)){
		$err = "db_pass";
	}
	elseif(empty($db_name)){
		$err = "db_name";
	}

	//fill important
	$s = array(
		'status' => 'error',
		'title' => $lg_error,
		'isi' => $lg_pleasefillimportant,
		'error' => $err
	);
	echo json_encode($s);
	exit;
}



// get cwd
$local_dir = @getcwd();
$local_dir = str_replace("\\elybin-install","",$local_dir);
$local_dir = str_replace("/elybin-install","",$local_dir);

// try connect
$con = @mysql_connect($db_host,$db_user,$db_pass);
if($con){
	if(mysql_select_db($db_name,$con)){

	}else{
		$s = array(
			'status' => 'error',
			'title' => $lg_error,
			'isi' => $lg_cannotconnecttodatabasepleasecheck,
			'error' => 'db_name'
		);
		echo json_encode($s);
		exit;
	}	
	
}else{
	$s = array(
		'status' => 'error',
		'title' => $lg_error,
		'isi' => $lg_cannotconnecttodatabasepleasecheck,
		'error' => 'db_pass'
	);
	echo json_encode($s);
	exit;
}

// write to file (elybin-config.php)
//SITE CONFIG
$config_dir = '../elybin-core/elybin-config.php';
$config_template = 
'<?php
//SITE CONFIG
$SITE_TITLE						= "Elybin CMS";
$SITE_URL						= "";
$SITE_ADMIN						= "{$SITE_URL}elybin-admin/";
$SITE_CONTENT					= "{$SITE_URL}elybin-content/";
$SITE_CORE						= "{$SITE_URL}elybin-core/";

$DIR_ROOT						= "'.$local_dir.'";
$DIR_ADMIN						= "{$DIR_ROOT}elybin-admin/";
$DIR_CONTENT					= "{$DIR_ROOT}elybin-content/";
$DIR_CORE						= "{$DIR_ROOT}elybin-core/";

$DB_HOST						= "'.$db_host.'";
$DB_USER						= "'.$db_user.'";
$DB_PASSWD						= "'.$db_pass.'";
$DB_NAME						= "'.$db_name.'";

define("DB_HOST", $DB_HOST);
define("DB_USER", $DB_USER);
define("DB_PASSWD", $DB_PASSWD);
define("DB_NAME", $DB_NAME);
?>';

// write to file
$f = fopen($config_dir, "w");
fwrite($f, $config_template);
fclose($f);

// create htaccess
$htaccess_dir = '../.htaccess';
$htaccess_template = '
<IfModule mod_rewrite.c>
RewriteEngine on
RewriteRule ^$ index.php?mod=index [L]
RewriteRule ^index\.html index.php?mod=index [L]
RewriteRule ^post-([0-9]+)-(.*)\.html$ index.php?mod=post&id=$1 [L]
RewriteRule ^page-([0-9]+)-(.*)\.html$ index.php?mod=page&id=$1 [L]
RewriteRule ^gallery\.html$ index.php?mod=gallery [L]
RewriteRule ^gallery-([0-9]+)-(.*)\.html$ index.php?mod=gallery&album=$1 [L]
RewriteRule ^photo-([0-9]+)-(.*)\.html$ index.php?mod=photo&id=$1 [L]
RewriteRule ^contact\.html$ index.php?mod=contact [L]
RewriteRule ^category-([0-9]+)-([0-9]+)-(.*)\.html$ index.php?mod=category&id=$1&p=$2 [L]
RewriteRule ^tag-([0-9]+)-([0-9]+)-(.*)\.html$ index.php?mod=tag&id=$1&p=$2 [L]
RewriteRule ^postpage-([0-9]+)\.html$ index.php?mod=index&p=$1 [L]
RewriteRule ^elybin-admin/app/media/pdfviewer/pdf-(.*)-(.*)\.pdf$ elybin-admin/app/media/pdfviewer/pdfviewer.php?id=$1 [L]
RewriteRule ^search\.html$ index.php?mod=search [L]
RewriteRule ^sitemap\.html$ index.php?mod=sitemap [L]
RewriteRule ^maintenance\.html$ maintenance.php [L]
RewriteRule ^404\.html$ 404.php [L]
RewriteRule ^403\.html$ 403.php [L]
RewriteRule ^code\.jpg$ elybin-core/elybin-captcha.php [L]
</IfModule>
';
// write to file
$f = fopen($htaccess_dir, "w");
fwrite($f, $htaccess_template);
fclose($f);

$s = array(
	'status' => 'ok',
	'title' => $lg_success,
	'isi' => $lg_systeminformationsaved,
	'db_host' => $db_host,
	'db_user' => $db_user,
	'db_pass' => '*********',
	'db_name' => $db_name
);
echo json_encode($s);
?>