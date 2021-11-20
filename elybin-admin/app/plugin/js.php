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
	$next = @$_GET['next'];
	switch (@$_GET['act']) {
		case 'add': // case 'add'
?>

<!-- Javascript -->
<script>
init.push(function () {
	$('#file-style').pixelFileInput({ placeholder: '<?php echo lg("Select file...")?>' });
	$('#tooltip a').tooltip();
	
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
					window.location.href="?mod=plugin&next=install&id="+data.plugin_id;
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

		case 'install': // case 'edit'
 ?>
 <!-- Javascript -->
<script>
init.push(function () {

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
					window.location.href="?mod=plugin";
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
		
		$id = @$_GET['id'];
?>
<!-- Javascript -->
<script>
init.push(function () {
	$('#tooltip a, #tooltipc, #tooltip-ck').tooltip();	
});
ElybinView();
ElybinPager();
ElybinSearch();
ElybinCheckAll();
countDelData();
<?php
	if($next == "install"){
		echo '$(function() {$("#install").modal({remote: "?mod=plugin&act=install&id='.$id.'&clear=yes"});});';
	}
?>
</script>
<!-- / Javascript -->

<?php		
			break;
	}
  }
}
?>