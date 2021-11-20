<?php
/* Short description for file
 * Install : Step 2 Process
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
require_once('../install.func.php');
require_once('../upgrade.func.php');

//W.I.W.S (still bug)
/**
 * There's still bug, why?
 * Because we identify the process through ?p= paramater.
 * And in this files (process) not using any paramater. So W.I.W.S detect that you are not in step3. so it causing redirect loop.
 * Maybe anyone can fix it, I already tired trying it but still fails.
 */
//where_i_was_supposed();

// try to connect
connect_with_config();

/** optimize nav menu */
// getting list of url
$q = mysql_query("SELECT * FROM `elybin_menu`");
// make sure there's no empty result
if(mysql_num_rows($q) > 0){
	while($f = mysql_fetch_array($q)){
		// use regex to filtering/finding specifict url
		if(preg_match("/^([a-z]+)-([0-9]+)-(.*).html/", $f['menu_url'], $match)){
		  // get the value
		  $section = $match[1];
		  $content_id = $match[2];
		  // new dynamic expression url
		  $newurl = json_encode([$section => $content_id]);
		  // update
			mysql_query("UPDATE `elybin_menu` SET `menu_url` = '$newurl' WHERE `menu_id` = {$f['menu_id']}");
		}
		// if old index.php replace to {"home"}
		else if($f['menu_url'] == 'index.php'){
			// update
			mysql_query("UPDATE `elybin_menu` SET `menu_url` = '" . '{"home"}' . "' WHERE `menu_id` = {$f['menu_id']}");
		}
		// if old index.html replace to {"home"}
		else if($f['menu_url'] == 'index.html'){
			// update
			mysql_query("UPDATE `elybin_menu` SET `menu_url` = '" . '{"home"}' . "' WHERE `menu_id` = {$f['menu_id']}");
		}
		// if old gallery.html replace to {"gallery"}
		else if($f['menu_url'] == 'gallery.html'){
			// update
			mysql_query("UPDATE `elybin_menu` SET `menu_url` = '" . '{"gallery"}' . "' WHERE `menu_id` = {$f['menu_id']}");
		}
		// if old map.html replace to {"page":"5"}
		else if($f['menu_url'] == 'map.html'){
			// update
			mysql_query("UPDATE `elybin_menu` SET `menu_url` = '" . '{"page":"5"}' . "' WHERE `menu_id` = {$f['menu_id']}");
		}
		// if old contact.html delete it!
		else if($f['menu_url'] == 'contact.html'){
			// update
			mysql_query("DELETE FROM `elybin_menu` WHERE `menu_id` = {$f['menu_id']}");
		}
		// if old {"page":"2"} delete it!
		else if($f['menu_url'] == '{"page":"2"}'){
			// update
			mysql_query("DELETE FROM `elybin_menu` WHERE `menu_id` = {$f['menu_id']}");
		}
	}
}

// disable all widget except default
mysql_query("
	UPDATE
		`elybin_widget`
	SET
		`status` = 'deactive'
	WHERE
		(`type` != 'admin-widget') &&
		(`name` != 'Recent Popular')
");

// delete htaccess
if(file_exists(many_trans().'.htaccess')){
	// delete
	@deleteDir(many_trans().'.htaccess');
	// check again
	if(file_exists(many_trans().'.htaccess')){
		result(array(
			'status' => 'error',
			'title' => lg('Error'),
			'msg' => lg('We cannot delete your old .htaccess files, due the permission problem. Please delete manually to continue this step.'),
			'msg_ses' => 'cannot_delete_htaccess',
			'red' => get_url('upgrade.step3')
		), @$_GET['r']);
	}
}


// ok optimizing
$_SESSION['optimizing_ok'] = true;

result(array(
	'status' => 'ok',
	'title' => lg('Success'),
	'msg' => lg('Step 3 passed!'),
	'msg_ses' => 'upgrade_step3_ok',
	'red' => get_url('upgrade.finish')
), @$_GET['r']);

// change step
$_SESSION['step'] = "24";

// prevent error by hosting external js
exit;
?>
