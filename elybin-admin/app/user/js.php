<?php
/* Javascript
 * Module: User
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
	
	// get user privilages
	$tbus = new ElybinTable('elybin_users');
	$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
	$level = $tbus->current()->level; // getting level from curent user

	$tbug = new ElybinTable('elybin_usergroup');
	$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
	$usergroup = $tbug->current()->setting;

// give error if no have privilage
if($usergroup == 0){
	header('location:../403.html');
	exit;
}else{
	switch (@$_GET['act']) {
		case 'add': // case 'add'
?>
<script src="assets/javascripts/select2.min.js"></script>
<!-- Javascript -->
<script>
init.push(function () {
	$('#tooltip a').tooltip();	

 	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Please wait...')?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: $(this).attr('action') + '?result=json',
	      type: 'POST',
	      data: new FormData(this),
	      processData: false,
	      contentType: false,
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
					$.growl.notice({ title: data.title, message: data.msg });
					
					// 1.1.3
					// msg
					if(data.callback_msg == ''){
						data.callback_msg = '';
					}else{
						data.callback_msg = "&msg=" + data.callback_msg
					}
					// callback
					if(data.callback !== "" && data.callback_hash !== 0){
						window.location.href="?mod=user&act=" + data.callback + "&hash=" + data.callback_hash + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=user&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=user" + data.callback_msg;
					}
				}
				else if(data.status == "error"){
					// error growl
					$.growl.warning({ title: data.title, message: data.msg });
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
<script src="assets/javascripts/select2.min.js"></script>

<!-- Javascript -->
<script>
init.push(function () {
	$('#file-style').pixelFileInput({ placeholder: '<?php echo lg("Select file...")?>' });
	$("#multiselect-style").select2({
		allowClear: false,
		placeholder: "<?php echo lg('Level')?>"
	});
	$('#switcher-style').switcher({
		theme: 'square',
		on_state_content: '<span class="fa fa-check"></span>',
		off_state_content: '<span class="fa fa-times"></span>'
	});
	$('#tooltip a, #tooltipl').tooltip();

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Please wait...')?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: $(this).attr('action') + '?result=json',
	      type: 'POST',
	      data: new FormData(this),
	      processData: false,
	      contentType: false,
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
					$.growl.notice({ title: data.title, message: data.msg });
					
					// 1.1.3
					// msg
					if(data.callback_msg == ''){
						data.callback_msg = '';
					}else{
						data.callback_msg = "&msg=" + data.callback_msg
					}
					// callback
					if(data.callback !== "" && data.callback_hash !== 0){
						window.location.href="?mod=user&act=" + data.callback + "&hash=" + data.callback_hash + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=user&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=user" + data.callback_msg;
					}
				}
				else if(data.status == "error"){
					// error growl
					$.growl.warning({ title: data.title, message: data.msg });
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
			
		default: // case default
?>
<!-- Javascript -->
<script>
init.push(function () {
	$('#tooltip a, #tooltip-ck').tooltip();	
});
ElybinView();
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