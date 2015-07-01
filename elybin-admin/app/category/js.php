<?php
/* Javascript
 * Module: -
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
	$usergroup = $tbug->current()->category;

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
	$('#tooltip a').tooltip();	

	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing...') ?>", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: $(this).attr('action') + '?result=json',
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
					window.location.href="?mod=category";
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
<script>
init.push(function () {
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
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Processing...') ?>", duration: 9999*9999 });
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
					window.location.href="?mod=category";
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
			
	default: // case default
?>
<script type="text/javascript">
init.push(function () {
	$('#tooltip a, #tooltip-ck').tooltip();
});
ElybinCheckAll();
countDelData();
</script>
<?php		
			break;
	}
  }
}
?>