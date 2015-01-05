<?php
/* Javascript
 * Module: Post
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
@session_start();
if(empty($_SESSION['login'])){
	header('location:../../../403.php');
}else{	
	@include_once('../../../elybin-core/elybin-function.php');
	@include_once('../../../elybin-core/elybin-oop.php');
	@include_once('../../lang/main.php');

  /*
	javascript start below
  */
?>
<!-- Optional javascripts -->
<!--
<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
-->
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