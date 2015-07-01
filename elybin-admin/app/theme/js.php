<?php
/* Javascript
 * Module: Theme
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
<script>
init.push(function () {
	$('#tooltip a').tooltip();	
	
	// on submit
	$('#form').submit(function(e){
		// disable button and growl!
		$('#form .btn-success').addClass('disabled');
		$.growl({ title: "<?php echo lg('Processing')?>", message: "<?php echo lg('Proccessing')?>...", duration: 9999*9999 });
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
					window.location.href="?mod=theme";
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
		var setEqHeight = function () {
			$('#content-wrapper .row').each(function () {
				var $p = $(this).find('.stat-panel');
				if (! $p.length) return;
				$p.attr('style', '');
				var h = $p.first().height(), max_h = h;
				$p.each(function () {
					h = $(this).height();
					if (max_h < h) max_h = h;
				});
				$p.css('height', max_h);
			});
		};
		
			if ($(this).hasClass('disabled')) return;
			$(this).addClass('disabled');
			setEqHeight();
			$(window).on('pa.resize', setEqHeight);
			$(window).resize();
	});
	window.PixelAdmin.start(init);
	
</script>
<script>
init.push(function () {
	$('.stat-cell a, .stat-cell button, #tooltip-ck, #tooltip a').tooltip();
		var demo_settings = {
		fixed_navbar: true,
		fixed_menu:   false,
		rtl:          false,
		menu_right:   false,
		theme:        'clean'
	};
	
	// Change theme
	$('#demo-themes .demo-theme').on('click', function () {
		if ($(this).hasClass('text-success')) return;
		$('#demo-themes .text-success').removeClass('text-success');
		$(this).addClass('text-success');
		demo_settings.theme = $(this).attr('data-theme');
		activateTheme($('#main-menu .btn-outline'));
		saveDemoSettings();
		return false;
	});
	
	var activateTheme = function (btns) {
	  document.body.className = document.body.className.replace(/theme\-[a-z0-9\-\_]+/ig, 'theme-' + demo_settings.theme);
	  
	  if (! btns) return;
	  btns.removeClass('dark');
	  if (demo_settings.theme != 'clean' && demo_settings.theme != 'white') {
		btns.addClass('dark');
	  }
	}
	
	function saveDemoSettings(){
		//new
		// disable button and growl!
		$.growl({ title: "<?php echo lg('Proccessing')?>", message: "<?php echo lg('Proccessing')?>...", duration: 9999*9999 });
		// start ajax
	    $.ajax({
	      url: 'app/theme/proses.php',
		  type: 'POST',
		  data: "mod=theme&act=admin_theme&id=" + demo_settings.theme,
	      success: function(data) {
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
	    e.preventDefault();
	    return false;
	}
});
</script>
<?php		
			break;
	}
  }
}
?>