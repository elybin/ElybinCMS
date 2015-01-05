<?php
/* Javascript
 * Module: -
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
<!-- Optional javascripts -->
<!-- 
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.3.1/jquery.maskedinput.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/bootstrap-datepicker.min.js"></script>
<script src="assets/javascripts/jquery.maskedinput.min.js"></script>
-->
<script src="min/?b=assets/javascripts&amp;f=select2.min.js,bootstrap-datepicker.min.js,jquery.maskedinput.min.js"></script>
<!-- Javascript -->
<script>
	init.push(function () {
		$('#tooltip a').tooltip();	
		$('#date-pick').datepicker();
		$("#date-input").mask("99/99/9999");

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
						window.location.href="?mod=album";
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

		case 'edit': // case 'add'
?>
<!-- Optional javascripts -->
<!-- 
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery.maskedinput/1.3.1/jquery.maskedinput.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.1/bootstrap3-editable/js/bootstrap-editable.min.js"></script>

<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/bootstrap-datepicker.min.js"></script>
<script src="assets/javascripts/jquery.maskedinput.min.js"></script>
-->
<script src="min/?b=assets/javascripts&amp;f=select2.min.js,bootstrap-datepicker.min.js,jquery.maskedinput.min.js"></script>
<!-- Javascript -->
<script>
	init.push(function () {
		$('#tooltip a').tooltip();	
		$('#date-pick').datepicker();
		$("#date-input").mask("99/99/9999");
		$('#switcher-style').switcher({
			theme: 'square',
			on_state_content: '<span class="fa fa-check"></span>',
			off_state_content: '<span class="fa fa-times"></span>'
		});

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
						window.location.href="?mod=album";
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
<script type="text/javascript">
init.push(function () {
	$('#tooltip a, #tooltip-ck, #tooltip-foto').tooltip();
});
ElybinPager();
ElybinSearch();
ElybinCheckAll();
countDelData();
</script>
<?php		
			break;
	}
  }
}
?>