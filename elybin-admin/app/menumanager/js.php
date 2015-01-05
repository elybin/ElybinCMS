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
<!-- Javascript -->
<!--
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js"></script>
-->
<script src="assets/javascripts/select2.min.js"></script>
<script>
init.push(function () {
	$('#file-style').pixelFileInput({ placeholder: '<?php echo $lg_nofileselected?>...' });
	$("#multiselect-style").select2({
		allowClear: false,
		placeholder: "<?php echo $lg_category?>"
	});
	$('#tooltip a').tooltip();

	$().ajaxStart(function() {
		$.growl({ title: "Loading", message: "Writing..." });
	}).ajaxStop(function() {
		$.growl({ title: "Success", message: "Success" });
	});

	//ajax
	$('#form').submit(function() {
		$.ajax({
			type: 'POST',
			url: 'app/menumanager/proses.php',
			data: $(this).serialize(),
			success: function(data) {
				console.log(data);
				data = explode(",",data);

				if(data[0] == "ok"){
					$.growl.notice({ title: data[1], message: data[2] });
					window.location.href="?mod=menumanager";
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

		case 'edit': // case 'edit'
?>
<!-- Javascript -->
<!--
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/sortable.min.js"></script>
-->

<script src="min/?f=assets/javascripts/select2.min.js,assets/javascripts/sortable.min.js"></script>
<script>
init.push(function () {
	$('#file-style').pixelFileInput({ placeholder: '<?php echo $lg_nofileselected?>...' });
	$("#multiselect-style").select2({
		allowClear: false,
		placeholder: "<?php echo $lg_category?>"
	});
	$('#tooltip a').tooltip();

	$().ajaxStart(function() {
		$.growl({ title: "Loading", message: "Writing..." });
	}).ajaxStop(function() {
		$.growl({ title: "Success", message: "Success" });
	});

	//ajax
	$('#form').submit(function() {
		$.ajax({
			type: 'POST',
			url: 'app/menumanager/proses.php',
			data: $(this).serialize(),
			success: function(data) {
				console.log(data);
				data = explode(",",data);

				if(data[0] == "ok"){
					$.growl.notice({ title: data[1], message: data[2] });
					window.location.href="?mod=menumanager";
				}
				else if(data[0] == "error"){
					$.growl.warning({ title: data[1], message: data[2] });
				}
				

			}
		})
		return false;
	});

	//shorable
	$('#sortable-list').sortable({
		update : function () {
			var neworder = new Array();

			$('#sortable-list .task span').each(function() {    	
				//get the id
				var id  = $(this).attr("id");
				neworder.push(id);
			});

			$.ajax({
				type: "POST",
				url: "app/menumanager/proses.php",
				data: "mod=menumanager&act=save&neworder=" + neworder,
				success: function(data){
					console.log(neworder);
					data = explode(",",data);

					if(data[0] == "ok"){
						$.growl.notice({ title: data[1], message: data[2] });
					}
					else{
						$.growl.warning({ title: '<?php echo $lg_error?>', message: data });
					}
				}
			});
		}
	});
});
</script>
<!-- / Javascript -->
<?php
			break;	
			
		default: // case default
?>
<!-- Javascript -->
<!--
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/3.5.2/select2.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>

<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/sortable.min.js"></script>
-->
<script src="min/?f=assets/javascripts/select2.min.js,assets/javascripts/sortable.min.js"></script>
<script>
init.push(function () {
	$('#tooltip a, #tooltip-ck').tooltip();	


	$('#sortable-list').sortable({
		update : function () {
			var neworder = new Array();

			$('#sortable-list .task span').each(function() {    	
				//get the id
				var id  = $(this).attr("id");
				neworder.push(id);
			});

			$.ajax({
				type: "POST",
				url: "app/menumanager/proses.php",
				data: "mod=menumanager&act=save&neworder=" + neworder,
				success: function(data){
					console.log(data);
					data = explode(",",data);

					if(data[0] == "ok"){
						$.growl.notice({ title: data[1], message: data[2] });
						//window.location.href="?mod=menumanager";
					}
					else{
						$.growl.warning({ title: '<?php echo $lg_error?>', message: data });
					}
				}
			});
		}
	});
});
</script>
<!-- / Javascript -->
<?php		
			break;
	}
  }
}
?>