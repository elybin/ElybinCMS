<?php
/* Javascript
 * Module: About
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
@session_start();
if(empty($_SESSION['login'])){
	header('location: index.php');
}else{	
	@include_once('../../../elybin-core/elybin-function.php');
	@include_once('../../../elybin-core/elybin-oop.php');
	@include_once('../../lang/main.php');
	
	// get usergroup privilage/access from current user to this module
	$usergroup = _ug()->setting;

	switch (@$_GET['act']) {
		default: // case default
?>
<!-- Javascript -->
<script>
init.push(function () {
	$('#tooltip a, #tooltip-ck').tooltip();	
});
</script>
<!-- / Javascript -->
<?php		
		break;
	}
}	
?>