<?php
/* Short description for file
 * Install : Step 1 Process
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
include_once('../install.func.php');

//W.I.W.S
where_i_was_supposed();

// change step
$_SESSION['step'] = "1";
// set ok_install
$_SESSION['ok_install'] = true;

// result
result(array(
	'status' => 'ok',
	'title' => lg('Success'),
	'msg' => lg('Install started!'),
	'msg_ses' => 'install_started',
	'red' => get_url('install.step1')
), @$_GET['r']);

// prevent error by hosting external js
exit;
?>
