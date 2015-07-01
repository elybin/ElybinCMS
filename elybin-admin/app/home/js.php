<?php
/* Javascript
 * Module: Dashboard
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
?>
<!-- Optional javascripts -->
<script src="min/?b=widget/statistic/assets/js&f=raphael.min.js,morris.min.js"></script>
<script type="text/javascript">
	init.push(function () {
		$('#tooltip a, #tooltip-ck, #tooltip-foto').tooltip();	
	});
	ElybinView();
	ElybinEditModal();
</script>
<?php 
}
?>