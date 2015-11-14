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
include_once('../upgrade.func.php');

//W.I.W.S
where_i_was_supposed();

// 

result(array(
	'status' => 'ok',
	'title' => lg('Success'),
	'msg' => lg('Upgrade started!'),
	'msg_ses' => 'upgrade_started',
	'red' => get_url('upgrade.step1')
), @$_GET['r']);

// change step
$_SESSION['step'] = "21";

// prevent error by hosting external js
exit;
?>
