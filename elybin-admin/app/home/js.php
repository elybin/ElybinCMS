<?php
/* Javascript
 * Module: Dashboard
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
@session_start();
if(empty($_SESSION['login'])){
	header('location: index.php');
}else{
	@include_once('../../../elybin-core/elybin-function.php');
	@include_once('../../../elybin-core/elybin-oop.php');
	@include_once('../../lang/main.php');
?>
<script src="widget/statistic/assets/js/raphael.min.js"></script>
<script src="widget/statistic/assets/js/morris.min.js"></script>
<script type="text/javascript">
init.push(function () {
	$('#tooltip a, #tooltip-ck').tooltip();
});
ElybinView();
</script>
<?php
}
?>
