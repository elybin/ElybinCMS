<?php
/* Javascript
 * Module: -
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
@session_start();
if(empty($_SESSION['login'])){
	header('location:  index.php');
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
	$usergroup = $tbug->current()->comment;

// give error if no have privilage
if($usergroup == 0){
	header('location: ../403.html');
	exit;
}else{
	switch (@$_GET['act']) {

		// case 'reply'
		case 'reply':

		// getting text_editor
		$edt = _op()->text_editor;
		if($edt=='summernote'){
?>
<script src="assets/javascripts/summernote.min.js"></script>
<script><?php ob_start('minify_js'); ?>
init.push(function () {
	//summernote editor
	if (! $('html').hasClass('ie8')) {
		$('#text-editor').summernote({
			height: 300,
			tabsize: 2,
			codemirror: {
				theme: 'monokai'
			},
			onImageUpload: function(files, editor, editable){
				uploadMedia(files[0], editor, editable);
			},
			onkeyup: function(e) {
				$("#form textarea[name='content']").html($(this).code());
				//console.log($("#form textarea[name='content']").val($(this).code()));
			}
		});
	}
})<?php ob_end_flush(); ?>
</script>
<?php
	}
	elseif($edt=='bs-markdown'){
?>
<script src="assets/javascripts/bootstrap-markdown.min.js"></script>
<script><?php ob_start('minify_js'); ?>
init.push(function () {
	if (! $('html').hasClass('ie8')) {
		$("#text-editor").markdown({ iconlibrary: 'fa' });
	}
})<?php ob_end_flush(); ?>
</script>
<?php } ?>
<script src="assets/javascripts/elybin-function.min.js"></script>
<script><?php ob_start('minify_js'); ?>
ElybinView();
init.push(function () {

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing')?>...", duration: 9999*9999 });
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
					$.growl.notice({ title: data.title, message: data.isi });

					// 1.1.3
					// msg
					if(data.callback_msg == ''){
						data.callback_msg = '';
					}else{
						data.callback_msg = "&msg=" + data.callback_msg
					}
					// callback
					if(data.callback !== "" && data.callback_hash !== ''){
						window.location.href="?mod=comment&act=" + data.callback + "&hash=" + data.callback_hash + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=comment&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=comment" + data.callback_msg;
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
<?php
			break;

	default: // case default
?>
<script type="text/javascript">
init.push(function () {
	$('#tooltip a, #tooltipc, #tooltip-ck').tooltip();
});
ElybinView();
ElybinCheckAll();
countDelData();
</script>
<?php
			break;
	}
  }
}
?>
