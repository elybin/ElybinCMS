<?php
/* Javascript
 * Module: Contact
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
@session_start();
if(empty($_SESSION['login'])){
	header('location: index.php');
}else{	
	@include_once('../../../elybin-core/elybin-function.php');
	@include_once('../../../elybin-core/elybin-oop.php');
	@include_once('../../lang/main.php');
	
	switch (@$_GET['act']) {
		case 'compose': // case 'add'		// getting text_editor
		$edt = _op()->text_editor;
		if($edt=='summernote'){
?>
<script src="min/?f=assets/javascripts/summernote.min.js"></script>
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
			},
		});
	}
})<?php ob_end_flush(); ?>
</script>
<?php 
	}
	elseif($edt=='bs-markdown'){
?>
<script src="min/?f=assets/javascripts/bootstrap-markdown.min.js"></script>
<script><?php ob_start('minify_js'); ?>
init.push(function () {
	if (! $('html').hasClass('ie8')) {
		$("#text-editor").markdown({ iconlibrary: 'fa' });
	}
})<?php ob_end_flush(); ?>
</script>
<?php } ?>
?>
<script src="min/?b=assets/javascripts&amp;f=elybin-function.min.js,jquery.tagsinput.min.js,jquery-ui.min.js"></script>
<script type="text/javascript">
init.push(function () {
	// tags pick
	$('#recipient_pick').tagsInput({
        width: 'auto',
        height: 'auto',
		defaultText:'<?php echo lg('Type E-mail or Name of recipient...')?>',
        autocomplete_url:'app/messager/ajax/recipient_auto.php', 
		autocomplete:{selectFirst:true,width:'300px',height:'80px',autoFill:true}
    });

 	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Please wail...')?>...", duration: 9999*9999 });
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
						window.location.href="?mod=messager&act=" + data.callback + "&hash=" + data.callback_hash + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=messager&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=messager" + data.callback_msg;
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
<?php
			break;
		case 'reply': // case 'add'		// getting text_editor
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
			},
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
?>
<script src="assets/javascripts/elybin-function.min.js"></script>
<script type="text/javascript">
init.push(function () {
 	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Please wail...')?>...", duration: 9999*9999 });
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
						window.location.href="?mod=messager&act=" + data.callback + "&hash=" + data.callback_hash + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=messager&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=messager" + data.callback_msg;
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
<?php
			break;
			
		default: // case default
?>
<script type="text/javascript">
init.push(function () {
	$('#tooltip a, #tooltip-ck').tooltip();
});
ElybinView();
ElybinCheckAll();
countDelData();
</script>
<?php		
			break;
	}
  }
?>