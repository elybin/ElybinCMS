<?php
/* Short description for file
 * Install : Locked
 * check installation date
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
include('../elybin-admin/lang/main.php');
include_once('../elybin-core/elybin-function.php');

// because installation only works in 24hours, check install date
$f = @fopen("install_date.txt", "r");
if(!$f || (@fgets($f) == date("Y-m-d"))){ 
	// cancel installation
	header('location: index.php');
	exit;
}

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
	<meta charset="utf-8"/>
	<title>Elybin CMS</title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>
	
	<!-- Favicons -->
    <link rel="icon" href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAACkklEQVR42u2W3UtTYRzHDwS9eha0q3Wzuqy/IKi7lRHdWZDQbd304plF3UQoaaQpCVHD0m0SGzpd5s7YKiIpfNk808Cc8w0UphtumM5NdC/ufHueY2k2pM2O3ugXPhzO2/fznJvfcxhmNzsyarX6OMdxWjk4RpK12Ol08pApDofDlpU0X6M5J5LIJaZdGo3m7L+8ewSPpxsLCcT0ZkQqnyNS/XJzkHdjBjNol1vwdNHuDa2FhVev0FVG60qToWsXkuGbBf8F7aBdtJN2b+Q9ODoW9GG2EakvrLjsOpqWA9qF2SaMjAV81JFh5bj7RcAiIJwAOpVAt0oeaJdwknzzErTae7fXSVmWVYbDkYA/1AKX6zw8wmXCJdmgnf6QFdOhuSmFQnFkVVz5pKqcrsjZp4Wt9xb4Xi5HijKw961BO9+TbuqoqHhaJklVKpU6sRCP9E82ocV9He88XAatv1h/rl3HW4JVohgtFKEYzcIdCYtwFybXDXj8ViQWFiPUyVgbTfqBuAgl/x0KfgAKu1eC5X8ziDz7IFjCYbuP3FuBlRiSyCMcIhzgV9jPD0vsW2UEe23DyLMNwZsALG8aXjPpdDo8HU9jYD4Fb2wZ3ugKg39Crn8Ix8E4psDwBPtftPlxUZiBL5Yiz26Mdz6JUCKN2ZmZCSaVSk1mM4Ei8WXkm9ziaX2neMbQtYaxSzxV+1Ws6ZnIepoFg8GxrMUgQ7Td8gm6B69geGyEvtwIA6G+zIDakjqExgNbJCaZn4uhQdeKqof1qHlkxLNSA6pL6tHd/i2n+Z2zmGZpMY6ejn7YLZ/xsa0D46OTOW8cmxLLkR0qJvv0j+0WR6PRAGMymV6YzeZmcrRsB9Sl0+lqdv9sd7Nl+Qlys2tBBC/Z4AAAAABJRU5ErkJggg==" />
	
	<link href="../elybin-admin/assets/stylesheets/fontawesome.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/primary.min.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css"/>
	<link href="../elybin-admin/assets/stylesheets/default.min.css" rel="stylesheet" type="text/css"/>	
	<meta name="robots" content="nofollow"/>
	
	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->
</head>
<body class="theme-default no-main-menu">
<div id="main-wrapper">
	<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
		<div class="navbar-inner">
			<!-- Main navbar header -->
			<div class="navbar-header">
				<!-- Logo -->
				<a href="http://elybin.com" class="navbar-brand" target="_blank">
					<div class="demo-logo bg-primary" style="background-color: rgba(0,0,0,0) !important"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAACkklEQVR42u2W3UtTYRzHDwS9eha0q3Wzuqy/IKi7lRHdWZDQbd304plF3UQoaaQpCVHD0m0SGzpd5s7YKiIpfNk808Cc8w0UphtumM5NdC/ufHueY2k2pM2O3ugXPhzO2/fznJvfcxhmNzsyarX6OMdxWjk4RpK12Ol08pApDofDlpU0X6M5J5LIJaZdGo3m7L+8ewSPpxsLCcT0ZkQqnyNS/XJzkHdjBjNol1vwdNHuDa2FhVev0FVG60qToWsXkuGbBf8F7aBdtJN2b+Q9ODoW9GG2EakvrLjsOpqWA9qF2SaMjAV81JFh5bj7RcAiIJwAOpVAt0oeaJdwknzzErTae7fXSVmWVYbDkYA/1AKX6zw8wmXCJdmgnf6QFdOhuSmFQnFkVVz5pKqcrsjZp4Wt9xb4Xi5HijKw961BO9+TbuqoqHhaJklVKpU6sRCP9E82ocV9He88XAatv1h/rl3HW4JVohgtFKEYzcIdCYtwFybXDXj8ViQWFiPUyVgbTfqBuAgl/x0KfgAKu1eC5X8ziDz7IFjCYbuP3FuBlRiSyCMcIhzgV9jPD0vsW2UEe23DyLMNwZsALG8aXjPpdDo8HU9jYD4Fb2wZ3ugKg39Crn8Ix8E4psDwBPtftPlxUZiBL5Yiz26Mdz6JUCKN2ZmZCSaVSk1mM4Ei8WXkm9ziaX2neMbQtYaxSzxV+1Ws6ZnIepoFg8GxrMUgQ7Td8gm6B69geGyEvtwIA6G+zIDakjqExgNbJCaZn4uhQdeKqof1qHlkxLNSA6pL6tHd/i2n+Z2zmGZpMY6ejn7YLZ/xsa0D46OTOW8cmxLLkR0qJvv0j+0WR6PRAGMymV6YzeZmcrRsB9Sl0+lqdv9sd7Nl+Qlys2tBBC/Z4AAAAABJRU5ErkJggg==" alt="" style="width: 20px; height: 20px"></div>&nbsp;Elybin<em><strong>CMS</strong></em>
				</a>
			</div> <!-- / .navbar-header -->

			<div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse"></div> <!-- / #main-navbar-collapse -->
		</div> <!-- / .navbar-inner -->
	</div> <!-- / #main-navbar -->
	
	<div id="content-wrapper">
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<i class="fa fa-magic"></i>&nbsp;&nbsp;<?php echo $lg_install ?>
				</h1>
			</div>
		</div> <!-- ./Page Header -->
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-download"></i>&nbsp;&nbsp;<?php echo $lg_quickinstall ?></span>
					</div> <!-- / .panel-heading -->
					<div class="panel-body no-padding no-border">
						<div class="wizard ui-wizard-example">
							<div class="wizard-content panel no-border-hr no-border-b no-padding-b">
								<!-- Database -->
								<div class="text-center col-md-8 col-md-offset-2">
									<h2><?php echo $lg_ouch ?>!</h2>
									<h4 class="text-muted"><?php echo $lg_installationlockedtemporary ?></h4>
									<br/>
									<p><i class="fa fa-5x fa-lock"></i></p>
									<br/>
									<p><?php echo $lg_installlockedhint ?>.</p>
									<hr class="clearfix no-border"/>
								</div>
							</div> <!-- / .wizard-content -->
						</div> <!-- / .wizard -->
					</div>
				</div>
			</div><!-- / .col -->
		</div><!-- / .row -->
	</div><!-- / .content -->
</div><!-- / .main warper -->
</body>
</html>
<?php 
ob_end_flush(); // minify_html
?>