<?php
/* Short description for file
 * Upgrade Success
 * final step of upgrade
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
include_once('../elybin-admin/lang/main.php');
include_once('../elybin-core/elybin-function.php');

// Checking step 1 (Database Connection Config)
// checking `.htaccess` 
if(!file_exists("../.htaccess") || !file_exists("../elybin-core/elybin-config.php")){
	// redirect to index 
	header('location: index.php');
	exit;
}

// finish
// self delete
deleteDir("../elybin-upgrade/");
deleteDir("../elybin-install/");
deleteDir("../elybin-install/install_date.txt");
deleteDir("../README.txt");
exit;

// minify html
ob_start('minify_html');
?>
<!DOCTYPE html>
<!--[if IE 8]>         
	<html class="ie8"> 
<![endif]-->
<!--[if IE 9]>         
	<html class="ie9 gt-ie8"> 
<![endif]-->
<!--[if gt IE 9]>--> 
	<html class="gt-ie8 gt-ie9 not-ie"> 
<!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Elybin CMS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	
	<!-- Favicons -->
    <link rel="icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAACkklEQVR42u2W3UtTYRzHDwS9eha0q3Wzuqy/IKi7lRHdWZDQbd304plF3UQoaaQpCVHD0m0SGzpd5s7YKiIpfNk808Cc8w0UphtumM5NdC/ufHueY2k2pM2O3ugXPhzO2/fznJvfcxhmNzsyarX6OMdxWjk4RpK12Ol08pApDofDlpU0X6M5J5LIJaZdGo3m7L+8ewSPpxsLCcT0ZkQqnyNS/XJzkHdjBjNol1vwdNHuDa2FhVev0FVG60qToWsXkuGbBf8F7aBdtJN2b+Q9ODoW9GG2EakvrLjsOpqWA9qF2SaMjAV81JFh5bj7RcAiIJwAOpVAt0oeaJdwknzzErTae7fXSVmWVYbDkYA/1AKX6zw8wmXCJdmgnf6QFdOhuSmFQnFkVVz5pKqcrsjZp4Wt9xb4Xi5HijKw961BO9+TbuqoqHhaJklVKpU6sRCP9E82ocV9He88XAatv1h/rl3HW4JVohgtFKEYzcIdCYtwFybXDXj8ViQWFiPUyVgbTfqBuAgl/x0KfgAKu1eC5X8ziDz7IFjCYbuP3FuBlRiSyCMcIhzgV9jPD0vsW2UEe23DyLMNwZsALG8aXjPpdDo8HU9jYD4Fb2wZ3ugKg39Crn8Ix8E4psDwBPtftPlxUZiBL5Yiz26Mdz6JUCKN2ZmZCSaVSk1mM4Ei8WXkm9ziaX2neMbQtYaxSzxV+1Ws6ZnIepoFg8GxrMUgQ7Td8gm6B69geGyEvtwIA6G+zIDakjqExgNbJCaZn4uhQdeKqof1qHlkxLNSA6pL6tHd/i2n+Z2zmGZpMY6ejn7YLZ/xsa0D46OTOW8cmxLLkR0qJvv0j+0WR6PRAGMymV6YzeZmcrRsB9Sl0+lqdv9sd7Nl+Qlys2tBBC/Z4AAAAABJRU5ErkJggg==" />

	<link href="../elybin-admin/assets/stylesheets/fontawesome.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/primary.min.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/default.min.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/select2.min.css" rel="stylesheet" type="text/css"/>
	
	<meta name="robots" content="nofollow">
	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->
</head>
<body class="theme-default no-main-menu">
<div id="main-wrapper">
	<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
		<!-- Main menu toggle -->

		<div class="navbar-inner">
			<!-- Main navbar header -->
			<div class="navbar-header">
				<!-- Logo -->
				<a href="http://elybin.com" class="navbar-brand" target="_blank">
					<div class="demo-logo bg-primary" style="background-color: rgba(0,0,0,0) !important"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAACkklEQVR42u2W3UtTYRzHDwS9eha0q3Wzuqy/IKi7lRHdWZDQbd304plF3UQoaaQpCVHD0m0SGzpd5s7YKiIpfNk808Cc8w0UphtumM5NdC/ufHueY2k2pM2O3ugXPhzO2/fznJvfcxhmNzsyarX6OMdxWjk4RpK12Ol08pApDofDlpU0X6M5J5LIJaZdGo3m7L+8ewSPpxsLCcT0ZkQqnyNS/XJzkHdjBjNol1vwdNHuDa2FhVev0FVG60qToWsXkuGbBf8F7aBdtJN2b+Q9ODoW9GG2EakvrLjsOpqWA9qF2SaMjAV81JFh5bj7RcAiIJwAOpVAt0oeaJdwknzzErTae7fXSVmWVYbDkYA/1AKX6zw8wmXCJdmgnf6QFdOhuSmFQnFkVVz5pKqcrsjZp4Wt9xb4Xi5HijKw961BO9+TbuqoqHhaJklVKpU6sRCP9E82ocV9He88XAatv1h/rl3HW4JVohgtFKEYzcIdCYtwFybXDXj8ViQWFiPUyVgbTfqBuAgl/x0KfgAKu1eC5X8ziDz7IFjCYbuP3FuBlRiSyCMcIhzgV9jPD0vsW2UEe23DyLMNwZsALG8aXjPpdDo8HU9jYD4Fb2wZ3ugKg39Crn8Ix8E4psDwBPtftPlxUZiBL5Yiz26Mdz6JUCKN2ZmZCSaVSk1mM4Ei8WXkm9ziaX2neMbQtYaxSzxV+1Ws6ZnIepoFg8GxrMUgQ7Td8gm6B69geGyEvtwIA6G+zIDakjqExgNbJCaZn4uhQdeKqof1qHlkxLNSA6pL6tHd/i2n+Z2zmGZpMY6ejn7YLZ/xsa0D46OTOW8cmxLLkR0qJvv0j+0WR6PRAGMymV6YzeZmcrRsB9Sl0+lqdv9sd7Nl+Qlys2tBBC/Z4AAAAABJRU5ErkJggg==" alt="" style="width: 20px; height: 20px;"></div>&nbsp;Elybin<em><strong>CMS</strong></em>
				</a>
			</div> <!-- / .navbar-header -->
			<div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse"></div> <!-- / #main-navbar-collapse -->
		</div> <!-- / .navbar-inner -->
	</div> <!-- / #main-navbar -->
	
	<div id="content-wrapper">
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm"><i class="fa fa-magic"></i>&nbsp;&nbsp;<?php echo $lg_upgrade ?></h1>
			</div>
		</div> <!-- ./Page Header -->
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-download"></i>&nbsp;&nbsp;<?php echo $lg_quickinstall ?></span>
						<div class="panel-heading-controls" style="width: 30%">
							<div class="progress progress-striped active" style="width: 100%">
								<div class="progress-bar progress-bar-success" style="width: 100%;" id="pg-bar"></div>
							</div>
						</div> <!-- / .panel-heading-controls -->
					</div> <!-- / .panel-heading -->
					<div class="panel-body no-padding no-border">
						<div class="wizard ui-wizard-example">
							<div class="wizard-content panel no-border-hr no-border-b no-padding-b">
								<div class="wizard-pane" id="wizard-example-step4">
									<div class="text-center col-md-6 col-md-offset-3">
										<h2><?php echo $lg_finish ?>!</h2>
										<h4 class="text-muted"><?php echo $lg_everythingisready ?>.</h4>
										<p><i class="fa fa-5x  fa-check"></i></p>
										<p><?php echo $lg_upgradefinishhint ?>.</p>
										<hr class="clearfix no-border">
										<a class="btn btn-success wizard-next-step-btn" href="../elybin-admin/index.php"><?php echo $lg_startnow ?></a>
									</div>
								</div> <!-- / .wizard-pane -->
							</div> <!-- / .wizard-content -->
						</div> <!-- / .wizard -->
					</div>
				</div>
			</div><!-- / .col -->
		</div><!-- / .row -->
	</div><!-- / .content -->
</div><!-- / .main warper -->
<!-- Javascript -->
<script> var init = []; </script>
<!-- For Lower than IE 9 -->
<!--[if lte IE 9]>
 	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->
<!-- For all browser except IE -->
<!--[if !IE]> -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript">if (!window.jQuery) { document.write('<script src="../elybin-admin/min/?f=assets/javascripts/jquery.min.js"><\/script>'); }</script>
	<script src="../elybin-admin/assets/javascripts/bootstrap.min.js" type="text/javascript"></script>
	<script src="../elybin-admin/assets/javascripts/pixel-admin.min.js" type="text/javascript"></script>
	<script src="../elybin-admin/assets/javascripts/elybin-function.min.js" type="text/javascript"></script>
	<script src="../elybin-admin/assets/javascripts/select2.min.js" type="text/javascript"></script>
	<script src="../elybin-admin/assets/javascripts/jquery.validate.min.js" type="text/javascript"></script>
<!-- <![endif]-->
<!-- Javascript -->
<script src="assets/install.js"></script>
<!-- / Javascript -->

<script><?php ob_start('minify_js'); // minify js ?>
init.push(function () {
	$('#tooltip a').tooltip();

	$("#account-setting").validate({
		ignore: '.ignore, .select2-input',
		focusInvalid: false,
		rules: {
			'el_fn': {
				required: true,
				minlength: 10,
				maxlength: 100
			},
			'el_un': {
				required: true,
				minlength: 6,
				maxlength: 20
			},
			'el_em': {
				required: true,
				email: true
			},
			'el_pw': {
				required: true,
				minlength: 6,
				maxlength: 20
			},
			'el_pwc': {
				required: true,
				minlength: 6,
				equalTo: "#el_pw_input"
			},
			'jq-validation-required': {
				required: true
			},
		},
		messages: {
			'jq-validation-policy': 'You must check it!'
		}
	});
});
window.PixelAdmin.start(init);
<?php ob_end_flush(); // minify_js ?>
</script>
</body>
</html>
<?php 
ob_end_flush(); // minify_html	
?>