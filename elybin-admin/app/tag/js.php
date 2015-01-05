<?php
/* Javascript
 * Module: Tag
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
	
	// get user privilages
	$tbus = new ElybinTable('elybin_users');
	$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
	$level = $tbus->current()->level; // getting level from curent user

	$tbug = new ElybinTable('elybin_usergroup');
	$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
	$usergroup = $tbug->current()->setting;

// give error if no have privilage
if($usergroup == 0){
	header('location:../403.php');
	exit;
}else{
	switch (@$_GET['act']) {
		case 'add': // case 'add'
?>
<!-- Javascript -->
<script>
	init.push(function () {
		$('#tooltip a').tooltip();	

		$().ajaxStart(function() {
			$.growl({ title: "Loading", message: "Writing..." });
			$('#form').hide();
		}).ajaxStop(function() {
			$.growl({ title: "Success", message: "Success" });
		});

		//ajax
		$('#form').submit(function() {
			$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				success: function(data) {
					data = explode(",",data);

					if(data[0] == "ok"){
						$.growl.notice({ title: data[1], message: data[2] });
						window.location.href="?mod=tag";
					}
					else if(data[0] == "error"){
						$.growl.warning({ title: data[1], message: data[2] });
					}
					

				}
			})
			return false;
		});
	});
</script>
<!-- / Javascript -->
<?php
			break;
			
		default: // case default
?>
<!-- Javascript -->
<script>
init.push(function () {
	$('#tooltip a, #tooltip-ck').tooltip();	
});
ElybinPager();
ElybinSearch();
ElybinCheckAll();
countDelData();
</script>
<!-- / Javascript -->
<?php		
			break;
	}
  }
}
?>