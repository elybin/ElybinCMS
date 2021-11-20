<?php
/* Javascript
 * Module: Post
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
@session_start();
if(empty($_SESSION['login'])){
	_red('index.php');
}else{
	@include_once('../../../elybin-core/elybin-function.php');
	@include_once('../../../elybin-core/elybin-oop.php');
	@include_once('../../lang/main.php');

	// shutdown at 1.1.3
	// get user privilages
	/*
	$tbus = _u();
	$level = $tbus->level; // getting level from curent user

	$tbug = new ElybinTable('elybin_usergroup');
	$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
	$usergroup = $tbug->current()->post; */

	// simple way :)
	$usergroup = _ug()->post;

// give error if no have privilage
if($usergroup == 0){
	// simple red
	_red('../403.html');
	exit;
}else{
	switch (@$_GET['act']) {
		case 'add': // case 'add'

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
<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/elybin-function.min.js"></script>
<script src="assets/javascripts/jquery.tagsinput.min.js"></script>
<script src="assets/javascripts/jquery-ui.min.js"></script>
<script><?php ob_start('minify_js'); ?>
init.push(function () {
	$('#file-style').pixelFileInput({ placeholder: '<?php echo lg("Select file...")?>' });
 	$("#multiselect-style").select2({
		allowClear: false,
		placeholder: "<?php echo lg('Category')?>"
	});
	$('#switcher-style').switcher({
		theme: 'square',
		on_state_content: '<span class="fa fa-check"></span>',
		off_state_content: '<span class="fa fa-times"></span>'
	});
	$('#tooltip a').tooltip();
	// multiselect tag

 	$("#select-multiple").select2({
		placeholder: "<?php echo lg('Tag')?>"
	});


	// test
	toggleform("#hidden_toggle","select");
	toggleform("#hidden_toggle2","selectchild");
	toggleform("#hidden_toggle3","selectchild");

	// tags pick
	$('#tags_pick').tagsInput({
        width: 'auto',
        height: 'auto',
		defaultText:'<?php echo lg('Type tag...')?>',
        autocomplete_url:'app/post/ajax/tags_auto.php',
		autocomplete:{selectFirst:true,width:'100px',autoFill:true}
    });
	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing...')?>", message: "<?php echo lg('Processing...')?>", duration: 9999*9999 });
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
					if(data.callback !== "" && data.callback_id !== 0){
						window.location.href="?mod=post&act=" + data.callback + "&id=" + data.callback_id + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=post&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=post" + data.callback_msg;
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

	// 1.1.3
	// auto save
	function autoSave(t){
		// masi hbug di text area + summernote
		$('#form .btn-success').addClass('disabled');
		console.log('auto save...');
		$.ajax({
	      url: 'app/post/proses.php',
	      type: 'POST',
	      data: t.serialize() + '&mod=post&act=autosave',
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
					autoSave(t);
					$('#autosave').fadeIn().html('<?php echo lg("Gagal menyimpan, mencoba kembali...") ?>');
				}
				if(data.status == "ok"){
					// ok growl
					//$.growl.notice({ title: data.title, message: data.isi });
					$('#autosave').html(data.isi);
				}
				else if(data.status == "error"){
					// error growl
					$.growl.warning({ title: data.title, message: data.isi });
				}
		   },
		   error: function(e){
				autoSave(t);
				$('#autosave').fadeIn().html('<?php echo lg("Gagal menyimpan, mencoba kembali...") ?>');
		   }
	    });
		//e.preventDefault();
		return;
	}
	// set awal
	textchange = 0;
	// fungsi trigger uto save
	function triggerAS(t){

		// trigger auto save on change
		$("#form input[name='title']").change(function(){
			textchange = textchange + 395;
		});
		$("#form .note-editable").keypress(function(){
			textchange = textchange + 1;
		});
		$("#form input, #form .note-editable").keypress(function(){
			// jika textchange > 99
			if(textchange > 400){
				// trigger autoSave
				autoSave(t);
				$('#autosave').fadeIn().html('<?php echo lg('Sedang menyimpan...') ?>');
				// set back to zero
				textchange = 0;
			}

			// console
			if(textchange%50 == 0){
				console.log(textchange);
			}
		});
	}
	// trigger triggerAS
	triggerAS($('#form'));

})<?php ob_end_flush(); ?>
</script>
<?php
			break;

		// case 'edit'
		case 'edit':

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
<script src="assets/javascripts/select2.min.js"></script>
<script src="assets/javascripts/elybin-function.min.js"></script>
<script src="assets/javascripts/jquery.tagsinput.min.js"></script>
<script src="assets/javascripts/jquery-ui.min.js"></script>
<script><?php ob_start('minify_js'); ?>
init.push(function () {
	$('#file-style').pixelFileInput({ placeholder: '<?php echo lg("Select file...")?>' });
	$("#multiselect-style").select2({
		allowClear: false,
		placeholder: "<?php echo lg('Category')?>"
	});

	$('#tooltip a').tooltip();
	$("#select-multiple").select2({
		placeholder: "<?php echo lg('Tag')?>"
	});

	// test
	toggleform("#hidden_toggle","select");
	toggleform("#hidden_toggle2","selectchild");
	toggleform("#hidden_toggle3","select");
	toggleform("#hidden_toggle4","selectchild");

	// tags picker
	$('#tags_pick').tagsInput({
        width: 'auto',
        height: 'auto',
		defaultText:'<?php echo lg('Type tag...')?>',
        autocomplete_url:'app/post/ajax/tags_auto.php',
		autocomplete:{selectFirst:true,width:'100px',autoFill:true}
    });

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing...')?>", message: "<?php echo lg('Processing')?>...", duration: 9999*9999 });
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
					if(data.callback !== "" && data.callback_id !== 0){
						window.location.href="?mod=post&act=" + data.callback + "&id=" + data.callback_id + data.callback_msg;
					}
					else if(data.callback !== ""){
						window.location.href="?mod=post&act=" + data.callback + data.callback_msg;
					}
					else{
						window.location.href="?mod=post" + data.callback_msg;
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



	// 1.1.3
	// auto save
	function autoSave(t){
		// masi hbug di text area + summernote
		$('#form .btn-success').addClass('disabled');
		console.log('auto save...');
		$.ajax({
	      url: 'app/post/proses.php',
	      type: 'POST',
	      data: t.serialize() + '&mod=post&act=autosave',
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
					autoSave(t);
					$('#autosave').fadeIn().html('<?php echo lg("Gagal menyimpan, mencoba kembali...") ?>');
				}
				if(data.status == "ok"){
					// ok growl
					//$.growl.notice({ title: data.title, message: data.isi });
					$('#autosave').html(data.isi);
				}
				else if(data.status == "error"){
					// error growl
					$.growl.warning({ title: data.title, message: data.isi });
				}
		   },
		   error: function(e){
				autoSave(t);
				$('#autosave').fadeIn().html('<?php echo lg("Gagal menyimpan, mencoba kembali...") ?>');
		   }
	    });
		//e.preventDefault();
		return;
	}
	// set awal
	textchange = 0;
	// fungsi trigger uto save
	function triggerAS(t){

		// trigger auto save on change
		$("#form input[name='title']").change(function(){
			textchange = textchange + 395;
		});
		$("#form .note-editable").keypress(function(){
			textchange = textchange + 1;
		});
		$("#form input, #form .note-editable").keypress(function(){
			// jika textchange > 99
			if(textchange > 400){
				// trigger autoSave
				autoSave(t);
				$('#autosave').fadeIn().html('<?php echo lg('Sedang menyimpan...') ?>');
				// set back to zero
				textchange = 0;
			}

			// console
			if(textchange%50 == 0){
				console.log(textchange);
			}
		});
	}
	// trigger triggerAS
	triggerAS($('#form'));

	// Check seo Title
	inp = $("#check_seo_input");
	fix = $("#check_seo_fix");
	btn = $("#check_seo_btn");
	edt = $("#check_seo_edit");
	pid = $("input[name='pid']");
	btn.click(function(){
		$.ajax({
				url: 'app/post/ajax/check_seotitle.php?seo=' + inp.val() + '&pid=' + pid.val(),
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
				autoSave(t);
				$('#autosave').fadeIn().html('<?php echo lg("Gagal menyimpan, mencoba kembali...") ?>');
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
<?php
			break;
		case 'editquick';
?>
<script src="assets/javascripts/select2.min.js"></script>
<script><?php ob_start('minify_js'); ?>
	init.push(function () {
		$('#file-style').pixelFileInput({ placeholder: '<?php echo lg("Select file...") ?>' });
	});<?php ob_end_flush(); ?>
</script>
<?php
			break;

		default: // case default
?>
<script><?php ob_start('minify_js'); ?>
init.push(function () {
	$('#tooltip a, #tooltipc, #tooltip-ck').tooltip();
});

ElybinView();
ElybinCheckAll();
countDelData();<?php ob_end_flush(); ?>
</script>
<?php
			break;
	} // switch
  } // else ug
} // session
?>
