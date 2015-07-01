<?php
/* Javascript
 * Module: Media
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
	
	// get user privilages
	$tbus = new ElybinTable('elybin_users');
	$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
	$level = $tbus->current()->level; // getting level from curent user

	$tbug = new ElybinTable('elybin_usergroup');
	$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
	$usergroup = $tbug->current()->media;

// give error if no have privilage
if($usergroup == 0){
	header('location:../403.html');
	exit;
}else{
	switch (@$_GET['act']) {
		case 'add': // case 'add'
?>
<!-- Javascript -->
<script>
init.push(function () {
	$('#file-style').pixelFileInput({ placeholder: '<?php echo $lg_nofileselected?>...' });
	$('#tooltip a').tooltip();	

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo $lg_processing?>", message: "<?php echo $lg_processing?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: $(this).attr('action'),
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
					window.location.href="?mod=media";
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
<?php
			break;
		case 'addmulti': // case 'add'
?>
<script src="assets/javascripts/dropzone.min.js"></script>
<script>
init.push(function () {
	$('#file-style').pixelFileInput({ placeholder: '<?php echo $lg_nofileselected?>...' });
	$('#tooltip a').tooltip();	

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo $lg_processing?>", message: "<?php echo $lg_processing?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: $(this).attr('action'),
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
					window.location.href="?mod=media";
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

init.push(function () {
	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
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