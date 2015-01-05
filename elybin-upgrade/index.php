<pre>
<?php
/* Short description for file
 * Upgrade
 * backup config, database and elybin-file
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
include('../elybin-admin/lang/main.php');
include_once('../elybin-core/elybin-function.php');

// banner
echo "=======================================================================
* Elybin CMS - Quick Backup & Upgrade                                 *
* Elybin CMS (www.elybin.com) - Open Source Content Management System *
=======================================================================

";

// starting
echo "Memulai Backup...\r\n";

// create dir
if(!file_exists("../elybin-file/backup/")){
	mkdir("../elybin-file/backup/");
	echo "Membuat Direkrori /elybin-file/backup/ ................ [Done]\r\n";
	mkdir("../elybin-file/backup/db/");
	echo "Membuat Direkrori /elybin-file/backup/db/ ................ [Done]\r\n";
	copy("../elybin-file/index.html","../elybin-file/backup/index.html");
	echo "Membuat File Index /elybin-file/backup/index.html ................ [Done]\r\n";
	copy("../elybin-file/index.html","../elybin-file/backup/db/index.html");
	echo "Membuat File Index /elybin-file/backup/db/index.html ................ [Done]\r\n";
}else{
	echo "Direktori Sudah ada /elybin-file/backup/ ................ [Done]\r\n";
}

// if `elybin-config.php` exsist, continue backup
if(file_exists("../elybin-core/elybin-config.php") AND file_exists("../elybin-file/backup/")){
	copy("../elybin-core/elybin-config.php","../elybin-file/backup/elybin-config_backup.php");
	echo "Menyalin /elybin-file/backup/elybin-config_backup.php ................ [Done]\r\n";
}

// if `elybin-version.php` exsist, continue backup
if(file_exists("../elybin-core/elybin-version.php") AND file_exists("../elybin-file/backup/")){
	copy("../elybin-core/elybin-version.php","../elybin-file/backup/elybin-version_backup.php");
	echo "Menyalin /elybin-file/backup/elybin-version_backup.php ................ [Done]\r\n";
}


// backup database
include("export.php");

// delete all directory
deleteDir("../elybin-admin/");
deleteDir("../elybin-main/");
deleteDir("../.htaccess");
deleteDir("../403.php");
deleteDir("../404.php");
deleteDir("../index.php");
deleteDir("../LICENSE.txt");
deleteDir("../maintenance.php");
@deleteDir("../LICENSE");
@deleteDir("../README.md");
@deleteDir("../README.rdoc");
echo "Hapus direktori /elybin-admin/ ................ [Done]\r\n";
echo "Hapus direktori /elybin-main/ ................ [Done]\r\n";

// self remove
deleteDir("../elybin-upgrade/");
echo "Hapus direktori /elybin-upgrade/ ................ [Done]\r\n";

// remove core
deleteDir("../elybin-core/");
echo "Hapus direktori /elybin-core/ ................ [Done]\r\n";

// finish and info

echo "Backup Selesai ................ [Done]\r\n";

echo "\r\nBackup selesai, silahkan lanjutkan proses upgrade dengan 
meng-ekstrak file instalasi kedalam situs anda, dan akses `/elybin-install/`.";


?>
</pre>