<?php
@session_start();
// need db
//@include(many_trans()."elybin-core/elybin-config.php");
@include("install.func.php");

// 1.1.3
// function do_upgrade
// upgradeable version is 1.1.1 or higher
function do_upgrade(){
	$upgrade = false;
	// check ./elybin-core/elybin-version.php
	if(file_exists(many_trans().'elybin-core/elybin-version.php'))){
		// get latest version
		include 'elybin-version.php';
		$to_ver = $ELYBIN_VERSION.'.'.$ELYBIN_BUILD;

		@include(many_trans().'elybin-core/elybin-version.php');
		// check old version
		$_fromver = $ELYBIN_VERSION.'.'.$ELYBIN_BUILD;
		// check available upgrade
		while($now_ver !== $to_ver){
			// upgrade table (asc)
			switch ($from_ver) {
				/* 
				* this version not supported upgrade
				*
				case '1.0.0':
					// 1.0.0 -> 1.0.1
					include many_trans().'elybin-install/inc/upgrade/to_1.0.1.php';
					$now_ver = '1.0.1';
					break;

				case '1.0.1':
					// 1.0.1 -> 1.0.12
					include many_trans().'elybin-install/inc/upgrade/to_1.0.12.php';
					$now_ver = '1.0.12';
					break;

				case '1.0.12':
					// 1.0.12 -> 1.1.0
					include many_trans().'elybin-install/inc/upgrade/to_1.1.0.php';
					$now_ver = '1.1.0';
					break;

				case '1.1.0':
					// 1.1.0 -> 1.1.1
					include many_trans().'elybin-install/inc/upgrade/to_1.1.1.php';
					$now_ver = '1.1.1';
					break;*/

				case '1.1.1':
					// 1.1.1 -> 1.1.3-dev
					include many_trans().'elybin-install/inc/upgrade/to_1.1.3-dev.php';
					$now_ver = '1.1.3-dev';
					break;

				default:
					// unknown version
					$now_ver = 0;
					break;
			}
		}
		// upgrade success
		$upgrade = true;
	}
	// return
	return $upgrade;
}
?>