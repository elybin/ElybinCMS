<?php
/* Short description for file
 * [ Forgot password 
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
include_once('../elybin-core/elybin-function.php');
include_once('../elybin-core/elybin-oop.php');
include_once('./lang/main.php');
if(isset($_SESSION['login'])){
	header('location:'.$SITE_ADMIN.'admin.php');
}else{
	$v = new ElybinValidasi;
	settzone();

	//start here 
	if(empty($_GET['key'])){

		// if email set
		if(isset($_POST['elybin_email'])){
		// getting post value
		$email = @$_POST['elybin_email'];
		
		// if code wrong
		if(checkcode(@$_POST['code']) == false){
			header('location:index.php?act=invalidcode');
			exit;
		}
			if(empty($email)){
				header('location:index.php');
			}else{
				// aware from sql
				$email = explode("@", $email);
				if(count($email) > 2){
					header('location:index.php');
					exit;
				}else{
					$email = $v->sql($email[0])."@".$v->sql($email[1]);
				}
				
				// if login failed reach limit
				if(@$_SESSION['loginfail'] >= 6){
					header('location:index.php?act=banned');
					exit;
				}

				// checking on database
				$tbl = new ElybinTable('elybin_users');
				// check first are email match or not
				$countuser = $tbl->GetRowCustom("`user_account_email` = '$email' AND `user_account_forgetkey`=''");
				if($countuser > 0){
					// generate random key
					$forgot_key = md5(md5(rand(1111,9999).microtime().md5(rand(88888,99999))).microtime().$email);
					$data = array(
						'user_account_forgetkey' => $forgot_key
					);
					$tbl->Update($data, 'user_account_email', $email);

					// get all information if matched
					$cuser = $tbl->SelectWhere('user_account_email', $email,'','')->current();
					$tblo = new ElybinTable('elybin_options');

					$fullname = $cuser->fullname;
					$shortname_cfg = $tblo->SelectWhere('name', 'short_name','','')->current()->value; // get short_name
					$shortname = explode(" ", $fullname);
						if(count($shortname)>0){
							if($shortname_cfg=='first'){
								$shortname = $shortname[0];
							}else{
								$shortname = $shortname[count($shortname)-1];
							}		
						}
					$sitemail = $tblo->SelectWhere('name', 'site_email','','')->current()->value; // get email
					$siteurl = $tblo->SelectWhere('name', 'site_url','','')->current()->value; // get site_url
					$sitename = $tblo->SelectWhere('name', 'site_name','','')->current()->value; // get site_url

					$to = "$fullname <$email>";
					$from = "Elybin CMS <$sitemail>";
					$subject = "Elybin CMS Password Reset";
					$content = "

		Hi $shortname, <br/><br/>

		Someone recently requested a password change for your account in &quot;$sitename&quot;. 
		If this was you, you can set a new password  <a href=\"$siteurl/elybin-admin/forgot.php?key=".$forgot_key."\">here</a> :<br/><br/>

		<a href=\"$siteurl/elybin-admin/forgot.php?key=".$forgot_key."\">Reset Password</a><br/><br/>

		If you don't want to change your password or didn't request this, just ignore and delete this message.<br/><br/>

		To keep your account secure, please don't forward this email to anyone.<br/><br/>

		Thanks!<br/>
		- $sitename Owner<br/>

					";
					$header = "From: $from\r\n";
					$header .= "Content-Type: text/html; charset=utf-8\r\n";
					$header .= "MIME-Version: 1.0\r\n";
					$header .= "Content-Transfer-Encoding: quoted-printable";

					// send it
					mail($to, $subject, $content, $header);
					header('location:index.php?act=emailsent');
					exit;
				}else{
					// give error if email doesn't match
					header('location:index.php?act=emailnotfound');
					exit;
				}
			}
		}

		// if new password set
		elseif(isset($_POST['elybin_newpassword']) AND isset($_POST['elybin_confrimnewpassword']) AND isset($_POST['key'])){
			$forgotkey = $v->sql($_POST['key']);
			$newpassword = $v->sql($_POST['elybin_newpassword']);
			$confrimnewpassword = $v->sql($_POST['elybin_confrimnewpassword']);

			if(empty($newpassword) OR empty($confrimnewpassword)){
				header('location:forgot.php?key='.$forgotkey);
				exit;
			}

			if($newpassword == $confrimnewpassword){
				//get current user session for notification
				$tblu = new ElybinTable("elybin_users");
				$cuser = $tblu->SelectWhere('user_account_forgetkey', $forgotkey,'','');
				$cuser = $cuser->current();

				$data = array(
					'user_account_pass' => md5($newpassword),
					'user_account_forgetkey' => NULL
				);

				// done 
				$tblu->Update($data, 'user_account_forgetkey', $forgotkey);
				

				//insert to notification
				$tbln = new ElybinTable("elybin_notification");
				$lnotif = $tbln->SelectWhere('title','user','notif_id','DESC');
				$lnotif = $lnotif->current();
				$data = array(
					'notif_code'=>'user_password_reset',
					'title'=>'user',
					'value'=>"<strong>".$cuser->fullname."</strong> $lg_successresettheirpassword.",
					'date'=>now(),
					'time'=>date("H:i:s"),
					'type'=>'success',
					'icon'=>'fa-user'
				);
				$tbln->Insert($data);

				header('location:index.php?act=resetsuccess');
				exit;
			}else{
				header('location:forgot.php?key='.$forgotkey);
				exit;
			}

		}

		// redirect back to index if this file access directly
		else{
			header('location:index.php');
		}
	}else{
	// if forgot access directly and have key
	// start here

	$forgotkey = $v->sql($_GET['key']);
	if(isset($forgotkey) AND (strlen($forgotkey) > 10)){
		$tblu = new ElybinTable('elybin_users');
		$cuser = $tblu->GetRow('user_account_forgetkey', $forgotkey);

		if($cuser == 0){
			// if key not matched
			header('location:index.php?act=urlexpired');
			exit;
		}
	}else{
		// if url expired
		header('location:index.php?act=urlexpired');
		exit;
	}
?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ElybinCMS - <?php echo $lg_resetpassword?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">

	<!-- Open Sans font from Google CDN -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

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
<!-- Demo script --> <script src="assets/demo/demo.js"></script> <!-- / Demo script -->



<!-- 2. $MAIN_NAVIGATION ===========================================================================

	Main navigation
-->
	<div class="signin-header">
		<a href="" class="logo">
			<div class="demo-logo bg-primary"><img src="assets/demo/logo-big.png" alt="" style="margin-top: -4px;"></div>&nbsp;
			<strong>Elybin</strong>CMS
		</a> <!-- / .logo -->
	</div> <!-- / .header -->
	<div id="content-wrapper" style="padding-top: 19px !important;"></div>
	<h1 class="form-header" id="header-title"><?php echo $lg_resetpassword?></h1>


	<!-- Form -->
	<form action="forgot.php" method="post" id="signin-form_id" class="panel">
		<div class="alert alert-success">
			<button type="button" class="close" data-dismiss="alert"><i class="fa fa-times close"></i></button>
			<strong><?php echo $lg_cool?>!</strong> <?php echo $lg_newpasswordhint?>.
		</div>
		<div class="form-group">
			<strong><?php echo $lg_newpassword?>:</strong>
			<input type="password" name="elybin_newpassword" id="newpassword_id" class="form-control input-lg" placeholder="<?php echo $lg_newpassword?>" autocomplete="off" required="required">
		</div> <!-- / New Password -->

		<input type="hidden" name="key" value="<?php echo $_GET['key']?>">
		<div class="form-group">
			<strong><?php echo $lg_confrimnewpassword?>:</strong>
			<input type="password" name="elybin_confrimnewpassword" id="confrimnewpassword_id" class="form-control input-lg" placeholder="<?php echo $lg_confrimnewpassword?>" autocomplete="off" required="required">
		</div> <!-- / Crf Password -->
		<div class="form-actions">
			<input type="submit" value="<?php echo $lg_savechanges?>" class="btn btn-primary btn-block btn-lg">
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
	window.PixelAdmin.start();
});
</script>
</body>
</html>
<?php
	}
}
?>