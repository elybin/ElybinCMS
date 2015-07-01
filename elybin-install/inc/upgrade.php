<?php
/* Short description for file
 * Upgrade
 * check previous version and do upgrade
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */

// check previous version
if(file_exists("../../elybin-file/backup/elybin-config_backup.php") AND file_exists("../../elybin-file/backup/elybin-version_backup.php")){
	$backup_available = true;
}else{
	$backup_available = false;
}

// get previous version
if($backup_available){
	include("../../elybin-file/backup/elybin-version_backup.php");
	
	// check again
	if(empty($ELYBIN_VERSION)){
		echo "File backup korup. (Err: elybin_version_backup.php)";
		exit;
	}else{
		// get from version
		$version = "$ELYBIN_VERSION.$ELYBIN_BUILD";
		
		// include specific upgrade for previous version
		switch($version){
			// version 1.0.0 (alpha 1)
			case "1.0.0":
				include("upgrade_version/1.0.0_1.1.0.php");
				break;
			// version 1.0.1 (alpha 2)
			case "1.0.1":
				include("upgrade_version/1.0.1_1.1.0.php");
				break;
			// version 1.0.12 (beta)
			case "1.0.12":
				include("upgrade_version/1.0.12_1.1.0.php");
				break;
			// not found
			default:
				echo "Previous version unrecognizable. (err: version $version)";
				exit;
				break;
		}
		


	}
}
?>