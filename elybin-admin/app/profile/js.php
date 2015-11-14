<?php
/* Javascript
 * Module: Profile
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

	switch (@$_GET['act']) {

		default: // case default
?>

<!-- Javascript -->
<script><?php ob_start('minify_js'); ?>
init.push(function(){
	$('#file-style').pixelFileInput({ placeholder: '<?php echo lg('No file selected')?>...' });

	$('#tooltip a, #tooltipl').tooltip();

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing')?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: $(this).attr('action') + '?r=j',
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
					if(data.callback !== "" && data.callback_id !== 0){
						window.location.href="?mod=profile&act=" + data.callback + "&id=" + data.callback_id + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=profile&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=profile" + data.callback_msg;
					}
				}
				else if(data.status == "error"){
					// error growl
					$.growl.warning({ title: data.title, message: data.msg });
				}
				else if(data.status == "danger"){
					// danger growl
					$.growl.error({ title: data.title, message: data.msg, duration: 10000  });
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
	}
}
?>
