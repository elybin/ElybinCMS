<?php
/* Short description for file
 * [ Index of admin panel
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();

// check instaled or not
if(!file_exists("../elybin-core/elybin-config.php")){
	header('location: ../elybin-install/');
	exit;
}

include_once('../elybin-core/elybin-function.php');
include_once('../elybin-core/elybin-oop.php');
include_once('./lang/main.php');

//act
$act = @$_GET['act'];
switch($act){
	case 'wrong':
	$msg_type = "warning";
	$msg = "<strong>$lg_ouch!</strong> $lg_wrongcombination";
		break;
		
	case 'invalidcode':
	$msg_type = "warning";
	$msg = "<strong>$lg_ouch!</strong> $lg_invalidcode";
		break;
		
	case 'logout':
	$msg_type = "info";
	$msg = "<strong>$lg_cool!</strong> $lg_logoutsuccessful!";
		break;

	case 'banned':
	$msg_type = "danger";
	$msg = "<strong>$lg_hey!</strong> $lg_bannedattempt.";
		break;

	case 'emailsent':
	$msg_type = "success";
	$msg = "<strong>$lg_success!</strong> $lg_emailsentcheckyouremail.";
		break;

	case 'emailnotfound':
	$msg_type = "warning";
	$msg = "<strong>$lg_ouch!</strong> $lg_noaccountwithemailexist.";
		break;

	case 'urlexpired':
	$msg_type = "warning";
	$msg = "<strong>$lg_ouch!</strong> $lg_urlexpired.";
		break;
		
	case 'sessionexpired':
	$msg_type = "warning";
	$msg = "<strong>$lg_ouch!</strong> $lg_sessionexpired.";
		break;
		
	case 'resetsuccess':
	$msg_type = "success";
	$msg = "<strong>$lg_success!</strong> $lg_yourpasswordupdated.";
		break;

	default:
		break;
}

// count visitor
$tbv = new ElybinTable("elybin_visitor");
$ip = str_replace("IP: ","", client_info("yes"));
$covisitor = $tbv->GetRow('visitor_ip', $ip);
if($covisitor == 0){
	// record new
	$data = array(
		'visitor_ip' => $ip,
		'date' => date("Y-m-d"),
		'hits' => 1,
		'online' => date("Y-m-d H:i:s")
	);
	$tbv->Insert($data);
}else{
	// Get prev data
	$cvisitor = $tbv->SelectWhere('visitor_ip', $ip,'','')->current();
	$hits = $cvisitor->hits+1;
	// ban malicious user
	if($cvisitor->status == "deny"){
		header('location: ../maintenance.html');
		exit;
	}
		
	// update exiting
	$data = array(
		'hits' => $hits,
		'online' => date("Y-m-d H:i:s")
	);
	$tbv->Update($data,'visitor_ip', $ip);
}
	
//check if already login
if(isset($_SESSION['login'])){
	header('location: admin.php');
}else{
if(@$_SESSION['loginfail'] >= 6){
	settzone();

	// push notif
	$dpn = array(
		'code' => 'user_attempt',
		'title' => '$lg_user',
		'icon' => 'fa-ban',
		'type' => 'warning',
		'content' => '[{"author":"Anonymous", "content":"'.client_info("yes").'", "single":"$lg_someonefailedtologin","more":"$lg_userloginattempt"}]'
	);
	pushnotif($dpn);
}
?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ElybinCMS - <?php echo $lg_login?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->
	<!-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'> -->

	<!-- Pixel Admin's stylesheets -->
	<link href="assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->

</head>


<!-- 1. $BODY ======================================================================================
	
	Body

	Classes:
	* 'theme-{THEME NAME}'
	* 'right-to-left'     - Sets text direction to right-to-left
-->
<body class="theme-default page-signin-alt">
<!-- Demo script  <script src="assets/demo/demo.js"></script>  / Demo script -->



<!-- 2. $MAIN_NAVIGATION ===========================================================================

	Main navigation
-->
	<div class="signin-header">
		<a href="" class="logo">
			<div class="demo-logo bg-primary" style="background-color: rgba(0,0,0,0) !important"><img src="assets/full/logo-big.png" alt="" style="width: 30px"></div>&nbsp;
			Elybin<em><strong>CMS</strong></em>
		</a> <!-- / .logo -->
	</div> <!-- / .header -->
	<div id="content-wrapper" style="padding-top: 19px !important;"></div>
	<h1 class="form-header" id="header-title"><?php echo $lg_signintoyouraccount?></h1>


	<!-- Form -->
	<form action="login.php" method="post" id="signin-form_id" class="panel">
		<div class="form-group">
			<input type="text" name="elybin_username" id="username_id" class="form-control input-lg" placeholder="<?php echo $lg_username?> <?php echo $lg_or?> <?php echo $lg_email?>">
		</div> <!-- / Username -->

		<div class="form-group signin-password">
			<input type="password" name="elybin_password" id="password_id" class="form-control input-lg" placeholder="<?php echo $lg_password?>">
			<a class="forgot" id="forgot-password-link"><?php echo $lg_forgot?>?</a>
		</div> <!-- / Password -->
		
		<div class="row">
			<div class="form-group col-xs-6 col-md-8 controls">
				<input type="text" class="form-control input-lg" name="code" placeholder="<?php echo $lg_code?>" id="code" required data-validation-required-message="Please enter code.">
				<p class="help-block text-danger"></p>
			</div>
			<div class="form-group col-xs-6 col-md-4 controls">
				<img src="../code.jpg" class="img-rounded img-thumbnail" style="height: 45px">
			</div>
		</div> <!-- / Code-->
		
		<div class="form-actions">
			<input type="submit" value="<?php echo $lg_login?>" class="btn btn-primary btn-block btn-lg">
		</div> <!-- / .form-actions -->
	</form>
	<!-- / Form -->

	<!-- Form -->

	<form action="forgot.php" method="post" id="forgot_form_id" class="panel" style="display: none">
		<div class="alert">
			<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times close"></i></button>
			<strong><?php echo $lg_forgot?> <?php echo strtolower($lg_password)?>?</strong> <?php echo $lg_forgotemailhint?>.
		</div>
		<div class="form-group">
			<input type="email" name="elybin_email" id="email_id" class="form-control input-lg" placeholder="<?php echo $lg_email?>" required="required">
		</div> <!-- / Username -->
		<div class="row">
			<div class="form-group col-xs-6 col-md-8 controls">
				<input type="text" class="form-control input-lg" name="code" placeholder="<?php echo $lg_code?>" id="code" required data-validation-required-message="Please enter code.">
				<p class="help-block text-danger"></p>
			</div>
			<div class="form-group col-xs-6 col-md-4 controls">
				<img src="../code.jpg" class="img-rounded img-thumbnail" style="height: 45px">
			</div>
		</div> <!-- / Code-->
		<div class="form-actions">
			<input type="submit" value="<?php echo $lg_resetpassword?>" class="btn btn-primary btn-block btn-lg">
		</div> <!-- / .form-actions -->
	</form>
	<!-- / Form -->


	<div class="signin-with">
		<div class="header"><?php echo $lg_followus?></div>
		<a href="http://facebook.com/elybincms" class="btn btn-lg btn-facebook rounded" target="_blank"><i class="fa fa-facebook"></i></a>&nbsp;&nbsp;
		<a href="https://twitter.com/@elybincms" class="btn btn-lg btn-info rounded" target="_blank"><i class="fa fa-twitter"></i></a>&nbsp;&nbsp;
		<a href="https://google/+elybincms" class="btn btn-lg btn-danger rounded" target="_blank"><i class="fa fa-google-plus"></i></a>
	</div>

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
<!--	<script type="text/javascript"> window.jQuery || document.write('<script src="../ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js">'+"<"+"/script>"); </script> -->
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->


<!-- Pixel Admin's javascripts -->
<script src="assets/javascripts/jquery.min.js"></script>
<script src="assets/javascripts/bootstrap.min.js"></script>
<script src="assets/javascripts/pixel-admin.min.js"></script>

<script>
$(document).ready(function() {  
<?php
	if(!empty($msg)){
?>	setTimeout(function () {
		options = {
		type: '<?php echo $msg_type?>',
		auto_close: 3,// seconds
		classes: 'alert-dark' // add custom classes
		}; 
		PixelAdmin.plugins.alerts.add("<?php echo $msg?>", options);
	}, 800);
<?php }?>
	// Show/Hide password reset form on click
	
	$('#forgot-password-link').click(function () {
		$('#signin-form_id').hide();
		$('#forgot_form_id').fadeIn(400);
		$('#header-title').html("<?php echo $lg_resetpassword?>");
		return false;
	});
	$('#forgot_form_id .close').click(function () {
		$('#forgot_form_id').hide();
		$('#signin-form_id').fadeIn(400);
		$('#header-title').html("<?php echo $lg_signintoyouraccount?>");
		return false;
	});	
	window.PixelAdmin.start();
});
</script>
</body>
</html>
<?php
}
?>