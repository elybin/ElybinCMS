<?php
/* Short description for file
 * Install : Step 1 Process
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
require_once('../install.func.php');
require_once('../upgrade.func.php');

//W.I.W.S
where_i_was_supposed();

// acc
$_SESSION['ok_upgrade'] = true;

result(array(
	'status' => 'ok',
	'title' => lg('Success'),
	'msg' => lg('Step 1 passed!'),
	'msg_ses' => 'upgrade_step1_ok',
	'red' => get_url('upgrade.step2')
), @$_GET['r']);

// change step
$_SESSION['step'] = "22";

// prevent error by hosting external js
exit;
?>
