<?php
/* Javascript
 * Module: -
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

	// string validation for security
	$v 	= new ElybinValidasi();

	// get usergroup privilage/access from current user to this module
	$usergroup = _ug()->album;

// give error if no have privilage
if($usergroup == 0){
	header('location:../403.html');
	exit;
}else{
	switch (@$_GET['act']) {
		case 'add': // case 'add'
?>
<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/bootstrap-datepicker.min.js"></script>
<script src="assets/javascripts/jquery.maskedinput.min.js"></script>
<script src="assets/javascripts/jquery.lazyload.js"></script>
<script><?php ob_start('minify_js'); ?>
// endless scrolling
$(window).scroll(function() {
	if($(window).scrollTop() + $(window).height() == $(document).height()) {
		endless();
	}
});
$(document).ready(function () {
	$("#scroll-edge").click(function() {
		endless();
	});
	$("img.lazy").lazyload();
});
init.push(function () {
	$('#tooltip a').tooltip();
	$('#date-pick').datepicker();
	$("#date-input").mask("99/99/9999");

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing')?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: $(this).attr('action'),
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

					// 1.1.3
					// msg
					if(data.callback_msg == ''){
						data.callback_msg = '';
					}else{
						data.callback_msg = "&msg=" + data.callback_msg
					}
					// callback
					if(data.callback !== "" && data.callback_hash !== 0){
						window.location.href="?mod=album&act=" + data.callback + "&hash=" + data.callback_hash + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=album&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=album" + data.callback_msg;
					}
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
});<?php ob_end_flush(); ?>
</script>
<!-- / Javascript -->
<?php
			break;

		case 'edit':
?>
<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/bootstrap-datepicker.min.js"></script>
<script src="assets/javascripts/jquery.maskedinput.min.js"></script>
<script src="assets/javascripts/jquery.lazyload.js"></script>
<script><?php ob_start('minify_js'); ?>
// endless scrolling
$(window).scroll(function() {
	if($(window).scrollTop() + $(window).height() == $(document).height()) {
		endless();
	}
});
$(document).ready(function () {
	$("#scroll-edge").click(function() {
		endless();
	});
	$("img.lazy").lazyload();
});
init.push(function () {
	$('#tooltip a').tooltip();
	$('#date-pick').datepicker();
	$("#date-input").mask("99/99/9999");
	$('#switcher-style').switcher({
		theme: 'square',
		on_state_content: '<span class="fa fa-check"></span>',
		off_state_content: '<span class="fa fa-times"></span>'
	});

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing')?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: $(this).attr('action'),
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

					// 1.1.3
					// msg
					if(data.callback_msg == ''){
						data.callback_msg = '';
					}else{
						data.callback_msg = "&msg=" + data.callback_msg
					}
					// callback
					if(data.callback !== "" && data.callback_hash !== 0){
						window.location.href="?mod=album&act=" + data.callback + "&hash=" + data.callback_hash + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=album&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=album" + data.callback_msg;
					}
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
});<?php ob_end_flush(); ?>
</script>
<!-- / Javascript -->
<?php
			break;

		case 'edit_more':
?>
<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/bootstrap-datepicker.min.js"></script>
<script src="assets/javascripts/jquery.maskedinput.min.js"></script>
<script src="assets/javascripts/jquery.lazyload.js"></script>
<script><?php ob_start('minify_js'); ?>
// endless scrolling
$(window).scroll(function() {
	if($(window).scrollTop() + $(window).height() == $(document).height()) {
		endless();
	}
});
$(document).ready(function () {
	$("#scroll-edge").click(function() {
		endless();
	});
	$("img.lazy").lazyload();
});
// test
toggleform("#hidden_toggle","select");
init.push(function () {
	$('#tooltip a').tooltip();
	$('#date-pick').datepicker();
	$("#date-input").mask("99/99/9999");
	$('#switcher-style').switcher({
		theme: 'square',
		on_state_content: '<span class="fa fa-check"></span>',
		off_state_content: '<span class="fa fa-times"></span>'
	});

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing')?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: $(this).attr('action'),
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

					// 1.1.3
					// msg
					if(data.callback_msg == ''){
						data.callback_msg = '';
					}else{
						data.callback_msg = "&msg=" + data.callback_msg
					}
					// callback
					if(data.callback !== "" && data.callback_hash !== 0){
						window.location.href="?mod=album&act=" + data.callback + "&hash=" + data.callback_hash + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=album&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=album" + data.callback_msg;
					}
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

		// Check seo Title
		inp = $("#check_seo_input");
		fix = $("#check_seo_fix");
		btn = $("#check_seo_btn");
		edt = $("#check_seo_edit");
		aid = $("input[name='aid']");
		btn.click(function(){
			$.ajax({
					url: 'app/album/ajax/check_seotitle.php?seo=' + inp.val() + '&pid=' + aid.val(),
					type: 'GET',
					success: function(data) {
						console.log(data);
						if(data['available']){
							inp.hide();
							btn.hide();
							fix.show();
							edt.show();

							fix.html(inp.val());
						}
						else if(!data['available']){
							fix.html(data['suggestion']);
							inp.val(data['suggestion']);
							// error growl
							$.growl.warning({ title: data['error'], message: data['msg']});
						}
				 },
				 error: function(e){
					$('#info').fadeIn().html('<?php echo lg("Failed to checking seo title, trying again...") ?>');
				 }
				});
		});
		edt.click(function(){
			edt.hide();
			fix.hide();
			inp.show();
			btn.show();
			return false;
		})

});<?php ob_end_flush(); ?>
</script>
<!-- / Javascript -->
<?php
			break;

	default: // case default
?>
<script src="assets/javascripts/jquery.lazyload.js"></script>
<script src="assets/javascripts/elybin-function.min.js"></script>
<script type="text/javascript"><?php ob_start('minify_js'); ?>
init.push(function () {
	$('#tooltip a, #tooltip-ck, #tooltip-foto').tooltip();
});
ElybinView();
ElybinCheckAll();
countDelData();
$(document).ready(function () {
	$("img.lazy").lazyload();
});
<?php ob_end_flush(); ?>
</script>
<?php
			break;
	}
  }
}
?>
