<?php
/* Short description for file
 * Install : Index
 * this file is agreement page, and installatation progress checker
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
if($f && (@fgets($f) !== date("Y-m-d"))){ 
	// cancel installation
	header('location: locked.php');
	exit;
}

// check setup complete or not
// if `elybin-config.php` not exsist, continue setup
if(file_exists("../elybin-core/elybin-config.php")){

	// Checking step 1 (Database Connection Config)
	// checking `.htaccess` 
	if(!file_exists("../.htaccess")){
		// redirect to step 1 
		header('location: step1.php');
		exit;
	}
	// step 1 passed
	
	// Checking step 2 (Information Setup/Writing database)
	// check table `elybin_config` exist or not
	@include_once('../elybin-core/elybin-oop.php');
	$tbop = new ElybinTable("elybin_options");
	$coop = $tbop->GetRow('','');
	// if `elybin_options` row empty 
	if($coop == 0  || $coop == ''){
		// step 2 hasn't passed yet, restart step 2 
		// redirect to step 2
		header('location: step2.php');
		exit;
	}
	// step 2 passed
	
	// Checking step 3 (Administrator Account)
	// if no user found in table `elybin_users`
	$tbu = new ElybinTable('elybin_users');
	$couser = $tbu->GetRow('user_id','1');
	if($couser == 0 OR $couser = ''){
		// redirect to step 3
		header('location: step3.php');
		exit;
	}
	// step 3 passed
	
	// Redirect to last step (finish)
	header('location: ../elybin-admin/index.php');
	exit; 
}else{
	// please agree
	$err = @$_GET['err'];
	switch($err){
		case 'pleaseagree':
		$msg_type = "warning";
		$msg = "<strong>$lg_ouch!</strong> $lg_pleasereadandagree";
			break;
		default:
			break;
	}
	
	// check previous version
	if(file_exists("../elybin-file/backup/elybin-config_backup.php")){
		$backup_available = true;
	}else{
		$backup_available = false;
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
									<h2><?php echo $lg_welcome ?></h2>
									<h4 class="text-muted"><?php echo $lg_areyouready ?>?</h4>
									<br/>
									<p><i class="fa fa-5x  fa-magic"></i></p>
									<br/>
									<p><?php echo $lg_installstarthint ?>?</p>
									<hr class="clearfix no-border"/>
								</div>
								<div class="text-left col-md-12">
									<?php
									if($backup_available){
									?>
									<div class="note note-warning">
										<h4 class="note-title">Elybin CMS versi sebelumnya terdeteksi</h4>
										Sistem kami mendeteksi adanya backup data dari versi sebelimnya, <br/>sistem akan secara otomatis mengupgrade ke versi terbaru.
									</div>
									<?php } ?>
									<pre style="max-height: 300px;">
SYARAT DAN KETENTUAN - http://docs.elybin.com/syarat-dan-ketentuan.html
=========================================
Ada beberapa syarat dan ketentuan yang anda harus ketahui selama anda menggunakan produk ini.<br/><br/>

<b>A. OPEN SOURCE & TIDAK MENGHAPUS CREDIT</b><br/>
Diperbolehkan untuk digunakan oleh siapa saja baik itu perorangan maupun kelompok, 
memperbanyak atau mendistribusikan kepada orang lain, ataupun mendesain ulang/mengubah/menulis 
ulang script/kode dalam CMS ini. Dengan catatan masih menyertakan link dan tanda pengenal 
dari pihak pengembang yaitu Elybin CMS. Kami rasa itu tidak terlalu menyulitkan, mengingat 
link/identitas kami tidak memakan banyak ruang, tidak seberapa memang, namun suatu kebanggaan 
dan penghargaan bagi kami jika nama kami turut disertakan.<br/><br/>

"Kebebasan adalah hal yang utama dalam menggunakan produk Open Source, kami mungkin tidak 
mendapat apapun, itu tidak masalah. Nama kami terpampang dengan baik dan benar sebagai bukti 
kerja keras, itu saja sudah cukup. (Tim Elybin)"<br/><br/>

<b>B. SUPPORT & BANTUAN</b><br/>
Kami tidak bisa memberikan garansi atas segala kerusakan/error atau merasa merugi saat 
menggunakan produk kami. Namun, anda dapat meminta bantuan/support dari kami ketika anda
menemui kesulitan/error dengan menghubungi tim support kami. Sangat di sarankan pula untuk 
memberikan masukan/kritik/saran jika anda menemukan sebuah kelemahan pada produk kami 
ataupun anda bisa meminta fitur baru kepada kami, karena kami menyadari bahawa produk 
kami masih membutuhkan masukan dari anda.<br/><br/>

<b>C. SISTEM DONASI, BUKAN BERBAYAR</b><br/>
Dalam menggunakan produk ini, anda tidak diperlukan untuk membayar kepada kami, karena 
produk ini bersifat gratis dan open source. Kecuali beberapa plugin dan tema yang memang 
dikembangkan oleh beberapa developer, namun perlu ditegaskan bahwa kami tidak menetapkan 
sistem membayar melaikan sistem donasi untuk beberapa kegiatan sosial, seperti yang ada 
pada misi kami. Perlu anda ketahui juga bahwa sistem donasi berbeda dengan sistem bayar, 
karena pada sistem donasi, anda akan terus mendapat update/pembaharuan seumur hidup selama 
produk kami terus digunakan dan dikembangkan.<br/><br/>

<b>D. MISI KAMI UNTUK ANDA</b><br/>
Saat pertama kali kami memulai Elybin CMS kami memiliki misi yang cukup sederhana dan 
kami sangat antusias untuk mewujudkan misi tersebut bersama anda. Atas dasar tersebut 
kami sadar bahwa anda bukanlah sebuah produk ataupun konsumen, tapi anda adalah mitra 
satu tim dengan kami. Karena itu kami mengundang anda untuk turut mengembangkan bersama 
termasuk dalam bentuk menggunakan dengan baik produk kami ataupun sebagai tim developer.<br/><br/>

Dengan penggunaan produk ini anda menyetujui Syarat dan Ketentuan dari Elybin CMS.
Terimakasih telah menggunakan produk kami, 
bantu kami mewujudkan misi kami, 
tetap cintai produk asli Indonesia ini.
									</pre>
										
									<hr class="clearfix no-border"/>
									<form action="include/agree.php" method="post">
										<div class="checkbox">
											<label>
												<input type="checkbox" class="px" name="agree"/>
												<span class="lbl">
												Saya menyetujui syarat dan ketentuan Elybin CMS
												</span>
											</label> 
										</div>
										<?php
										if($backup_available){
										?>
										<input type="hidden" name="backup" value="true"/>
										<input class="btn btn-warning"  type="submit" value="<?php echo $lg_startupgrade ?>"/>
										<?php }else{ ?>
										<input class="btn btn-success wizard-next-step-btn"  type="submit" value="<?php echo $lg_startinstallation ?>"/>
										<?php } ?>
									</form>
								</div>
							</div> <!-- / .wizard-content -->
						</div> <!-- / .wizard -->
					</div>
				</div>
			</div><!-- / .col -->
		</div><!-- / .row -->
	</div><!-- / .content -->
</div><!-- / .main warper -->
<!-- Javascript -->
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
<!-- <![endif]-->

<script><?php ob_start('minify_js'); // minify js ?>
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
	window.PixelAdmin.start();
});<?php ob_end_flush(); // minify_js ?>
</script>
</body>
</html>
<?php 
	ob_end_flush(); // minify_html
} 
?>