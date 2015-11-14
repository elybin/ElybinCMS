<?php
/* Short description for file
 * Install : Step 2 Process
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
require_once('../install.func.php');
require_once('../upgrade.func.php');

//W.I.W.S
where_i_was_supposed();

// do database backup
do_database_backup();

// only works if upgrade possible
if(check_upgrade_possible()){
	// get query filename
	$qfn = upgrade_diff();
	// import/query a sql
	foreach ($qfn as $ud) {
		// check first
		if(check_upgrade_query($ud)){
			// query now
			if(import_sql(array(many_trans()."elybin-install/mysql/{$ud}"))){
				// redirect
				result(array(
					'status' => 'ok',
					'title' => lg('Success'),
					'msg' => lg('Step 2 passed!'),
					'msg_ses' => 'upgrade_step2_ok',
					'red' => get_url('upgrade.step3')
				), @$_GET['r']);

				// change step
				$_SESSION['step'] = "23";
			}else{
				// give error space dude
				result(array(
					'status' => 'error',
					'title' => lg('Error'),
					'msg' => lg('Failed to execute query, this is out mistake. Please contact us at hi@elybin.com.'),
					'msg_ses' => 'failed_execute_query',
					'red' => get_url('upgrade.step2')
				), @$_GET['r']);
			}
		}else{
			// give error space dude
			result(array(
				'status' => 'error',
				'title' => lg('Error'),
				'msg' => lg('Upgrade query not found, this is out mistake. Please contact us at hi@elybin.com'),
				'msg_ses' => 'upgrade_query_not_found',
				'red' => get_url('upgrade.step2')
			), @$_GET['r']);
		}
	}
}else{
	// give error space dude
	result(array(
		'status' => 'error',
		'title' => lg('Error'),
		'msg' => lg('Your system version not upgradeable.'),
		'msg_ses' => 'system_not_upgradeable',
		'red' => get_url('upgrade.na')
	), @$_GET['r']);
}


// prevent error by hosting external js
exit;
?>
