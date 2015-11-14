<?php
/* Javascript
 * Module: Menu Manager
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
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

// give error if no have privilage
if($usergroup == 0){
	header('location:../403.html');
	exit;
}else{
	switch (@$_GET['act']) {
		case 'add': // case 'add'
?>
<!-- Javascript -->
<script src="assets/javascripts/select2.min.js"></script>
<script>
init.push(function () {
	$('#file-style').pixelFileInput({ placeholder: '<?php echo lg("Select file")?>...' });
	$("#multiselect-style").select2({
		allowClear: false,
		placeholder: "<?php echo lg('Category')?>"
	});
	$('#tooltip a').tooltip();

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing')?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: 'app/menumanager/proses.php',
	      type: 'POST',
	      data: $(this).serialize(),
	      success: function(data) {
				// enable button
				$("#growls .growl-default").hide();
				$('#form .btn-success').removeClass('disabled');
	      		console.log(data);
				// decode json
				try {
					var data = $.parseJSON(data);
				}
				catch(e){
					// if failed to decode json
					$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
				}
				if(data.status == "ok"){
					// ok growl
					$.growl.notice({ title: data.title, message: data.isi });
					window.location.href="?mod=menumanager";
				}
				else if(data.status == "error"){
					// error growl
					$.growl.warning({ title: data.title, message: data.isi });
				}
		   }
	    });
	    e.preventDefault();
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
<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/sortable.min.js"></script>
<script>
init.push(function () {
	$('#file-style').pixelFileInput({ placeholder: '<?php echo lg("Select file")?>...' });
	$("#multiselect-style").select2({
		allowClear: false,
		placeholder: "<?php echo lg('Category')?>"
	});
	$('#tooltip a').tooltip();

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing')?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: 'app/menumanager/proses.php',
	      type: 'POST',
	      data: $(this).serialize(),
	      success: function(data) {
				// enable button
				$("#growls .growl-default").hide();
				$('#form .btn-success').removeClass('disabled');
	      		console.log(data);
				// decode json
				try {
					var data = $.parseJSON(data);
				}
				catch(e){
					// if failed to decode json
					$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
				}
				if(data.status == "ok"){
					// ok growl
					$.growl.notice({ title: data.title, message: data.isi });
					window.location.href="?mod=menumanager";
				}
				else if(data.status == "error"){
					// error growl
					$.growl.warning({ title: data.title, message: data.isi });
				}
		   }
	    });
	    e.preventDefault();
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

			// disable button and growl!
			$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing')?>...", duration: 9999*9999 });
			// start ajax
			$.ajax({
				type: "POST",
				url: "app/menumanager/proses.php",
				data: "mod=menumanager&act=save&neworder=" + neworder,
				success: function(data){
					// enable button
					$("#growls .growl-default").hide();
					console.log(data);
					// decode json
					try {
						var data = $.parseJSON(data);
					}
					catch(e){
						// if failed to decode json
						$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
					}
					if(data.status == "ok"){
						// ok growl
						$.growl.notice({ title: data.title, message: data.isi });
					}
					else if(data.status == "error"){
						// error growl
						$.growl.warning({ title: data.title, message: data.isi });
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
<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/sortable.min.js"></script>
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

			// disable button and growl!
			$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing')?>...", duration: 9999*9999 });
			// start ajax
			$.ajax({
				type: "POST",
				url: "app/menumanager/proses.php",
				data: "mod=menumanager&act=save&neworder=" + neworder,
				success: function(data){
					// enable button
					$("#growls .growl-default").hide();
					console.log(data);
					// decode json
					try {
						var data = $.parseJSON(data);
					}
					catch(e){
						// if failed to decode json
						$.growl.error({ title: "Failed to decode JSON!", message: e + "<br/><br/>" + data, duration: 10000 });
					}
					if(data.status == "ok"){
						// ok growl
						$.growl.notice({ title: data.title, message: data.isi });
					}
					else if(data.status == "error"){
						// error growl
						$.growl.warning({ title: data.title, message: data.isi });
					}
				}
			});
		}
	});

});
ElybinView();
</script>
<!-- / Javascript -->
<?php
			break;
	}
  }
}
?>
