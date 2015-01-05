<?php
/* Short description for file
 * Install: Step 2 
 * collect site information that user inputed and send to `install_step2.php` with AJAX and write the JSON result
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
session_start();
include_once('../elybin-admin/lang/main.php');
include_once('../elybin-core/elybin-function.php');

// because installation only works in 24hours, check install date
$f = @fopen("install_date.txt", "r");
if($f && (@fgets($f) !== date("Y-m-d"))){ 
	// cancel installation
	header('location: locked.php');
	exit;
}

// Checking step 1 (Database Connection Config)
// checking `.htaccess` 
if(!file_exists("../.htaccess") || !file_exists("../elybin-core/elybin-config.php")){
	// redirect to index 
	header('location: index.php');
	exit;
}
// step 1 passed

// Checking step 2 (Information Setup/Writing database)
// check table `elybin_config` exist or not
@include_once('../elybin-core/elybin-oop.php');
$tbop = new ElybinTable("elybin_options");
$coop = @$tbop->GetRow('','');
// if `elybin_options` row empty 
if($coop > 0){
	// step 2 successfully passed
	// redirect to index
	header('location: step3.php');
	exit;
}
// step 2 passed

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
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm"><i class="fa fa-magic"></i>&nbsp;&nbsp;<?php echo $lg_install ?></h1>
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
								<div class="progress-bar progress-bar-success" style="width: 33%;" id="pg-bar"></div>
							</div>
						</div> <!-- / .panel-heading-controls -->
					</div> <!-- / .panel-heading -->
					<div class="panel-body no-padding no-border">
						<div class="wizard ui-wizard-example">
							<div class="wizard-wrapper">
								<ul class="wizard-steps">
									<li data-target="#wizard-example-step1" >
										<span class="wizard-step-number">1</span>
										<span class="wizard-step-caption">
											<?php echo $lg_step ?> 1
											<span class="wizard-step-description"><?php echo $lg_databaseconfig ?></span>
										</span>
									</li>
									<li data-target="#wizard-example-step2" class="active"> <!-- ! Remove space between elements by dropping close angle -->
										<span class="wizard-step-number">2</span>
										<span class="wizard-step-caption">
											<?php echo $lg_step ?> 2
											<span class="wizard-step-description"><?php echo $lg_siteinformation ?></span>
										</span>
									</li>
									<li data-target="#wizard-example-step3"> <!-- ! Remove space between elements by dropping close angle -->
										<span class="wizard-step-number">3</span>
										<span class="wizard-step-caption">
											<?php echo $lg_step ?> 3
											<span class="wizard-step-description"><?php echo $lg_createaccount ?></span>
										</span>
									</li>
									<li data-target="#wizard-example-step4"> <!-- ! Remove space between elements by dropping close angle -->
										<span class="wizard-step-number">4</span>
										<span class="wizard-step-caption">
											<?php echo $lg_finish ?>
										</span>
									</li>
								</ul> <!-- / .wizard-steps -->
							</div> <!-- / .wizard-wrapper -->
							<div class="wizard-content panel no-border-hr no-border-b no-padding-b">
								<div class="wizard-pane" id="wizard-example-step2" style="display: block">
									<form action="include/install_step2.php" method="POST" id="website-info">
										<?php
										
											// check working url
											if(!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) { 
												$pfx = "https://"; 
											}else{ 
												$pfx = "http://";
											} 
											$current_url = $pfx.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
											$site_url = str_replace("elybin-install/step2.php", "", urldecode($current_url));
											
											// check with dircheck.php
											$f = fopen($site_url."elybin-install/include/dircheck.php", "r");
											if(!$f OR (fgets($f) !== "Bismillah")){ 
												$site_url_found = false;
											}else{
												$site_url_found = true;
											}
		
										?>
										<div class="form-group" id="site_url">
											<label class="control-label"><?php echo $lg_siteurl ?>* <i class="text-success"><?php if(@$site_url_found){ echo 'Found!';} ?></i></label>
											<input type="text" name="site_url" class="form-control" placeholder="<?php echo $lg_siteurl ?>" value="<?php echo $site_url ?>" <?php if(@$site_url_found){ echo 'disabled="disabled"';} ?>/>
										</div> <!-- / .form-group -->	
										<div class="form-group" id="site_name">
											<label class="control-label"><?php echo $lg_sitename ?>*</label>
											<input type="text" name="site_name" class="form-control" placeholder="<?php echo $lg_sitename ?>"/>
										</div> <!-- / .form-group -->	
										<div class="form-group" id="site_email">
											<label class="control-label"><?php echo $lg_siteemail ?>*</label>
											<input type="text" name="site_email" class="form-control" placeholder="<?php echo $lg_siteemail ?>" id="site_email_input"/>
										</div> <!-- / .form-group -->	
										<div class="form-group" id="timezone">
											<label class="control-label"><?php echo $lg_timezone ?>*</label>
<?php
	$timezones = array(
	    'Pacific/Midway'       => "(GMT-11:00) Midway Island",
	    'US/Samoa'             => "(GMT-11:00) Samoa",
	    'US/Hawaii'            => "(GMT-10:00) Hawaii",
	    'US/Alaska'            => "(GMT-09:00) Alaska",
	    'US/Pacific'           => "(GMT-08:00) Pacific Time (US &amp; Canada)",
	    'America/Tijuana'      => "(GMT-08:00) Tijuana",
	    'US/Arizona'           => "(GMT-07:00) Arizona",
	    'US/Mountain'          => "(GMT-07:00) Mountain Time (US &amp; Canada)",
	    'America/Chihuahua'    => "(GMT-07:00) Chihuahua",
	    'America/Mazatlan'     => "(GMT-07:00) Mazatlan",
	    'America/Mexico_City'  => "(GMT-06:00) Mexico City",
	    'America/Monterrey'    => "(GMT-06:00) Monterrey",
	    'Canada/Saskatchewan'  => "(GMT-06:00) Saskatchewan",
	    'US/Central'           => "(GMT-06:00) Central Time (US &amp; Canada)",
	    'US/Eastern'           => "(GMT-05:00) Eastern Time (US &amp; Canada)",
	    'US/East-Indiana'      => "(GMT-05:00) Indiana (East)",
	    'America/Bogota'       => "(GMT-05:00) Bogota",
	    'America/Lima'         => "(GMT-05:00) Lima",
	    'America/Caracas'      => "(GMT-04:30) Caracas",
	    'Canada/Atlantic'      => "(GMT-04:00) Atlantic Time (Canada)",
	    'America/La_Paz'       => "(GMT-04:00) La Paz",
	    'America/Santiago'     => "(GMT-04:00) Santiago",
	    'Canada/Newfoundland'  => "(GMT-03:30) Newfoundland",
	    'America/Buenos_Aires' => "(GMT-03:00) Buenos Aires",
	    'Greenland'            => "(GMT-03:00) Greenland",
	    'Atlantic/Stanley'     => "(GMT-02:00) Stanley",
	    'Atlantic/Azores'      => "(GMT-01:00) Azores",
	    'Atlantic/Cape_Verde'  => "(GMT-01:00) Cape Verde Is.",
	    'Africa/Casablanca'    => "(GMT) Casablanca",
	    'Europe/Dublin'        => "(GMT) Dublin",
	    'Europe/Lisbon'        => "(GMT) Lisbon",
	    'Europe/London'        => "(GMT) London",
	    'Africa/Monrovia'      => "(GMT) Monrovia",
	    'Europe/Amsterdam'     => "(GMT+01:00) Amsterdam",
	    'Europe/Belgrade'      => "(GMT+01:00) Belgrade",
	    'Europe/Berlin'        => "(GMT+01:00) Berlin",
	    'Europe/Bratislava'    => "(GMT+01:00) Bratislava",
	    'Europe/Brussels'      => "(GMT+01:00) Brussels",
	    'Europe/Budapest'      => "(GMT+01:00) Budapest",
	    'Europe/Copenhagen'    => "(GMT+01:00) Copenhagen",
	    'Europe/Ljubljana'     => "(GMT+01:00) Ljubljana",
	    'Europe/Madrid'        => "(GMT+01:00) Madrid",
	    'Europe/Paris'         => "(GMT+01:00) Paris",
	    'Europe/Prague'        => "(GMT+01:00) Prague",
	    'Europe/Rome'          => "(GMT+01:00) Rome",
	    'Europe/Sarajevo'      => "(GMT+01:00) Sarajevo",
	    'Europe/Skopje'        => "(GMT+01:00) Skopje",
	    'Europe/Stockholm'     => "(GMT+01:00) Stockholm",
	    'Europe/Vienna'        => "(GMT+01:00) Vienna",
	    'Europe/Warsaw'        => "(GMT+01:00) Warsaw",
	    'Europe/Zagreb'        => "(GMT+01:00) Zagreb",
	    'Europe/Athens'        => "(GMT+02:00) Athens",
	    'Europe/Bucharest'     => "(GMT+02:00) Bucharest",
	    'Africa/Cairo'         => "(GMT+02:00) Cairo",
	    'Africa/Harare'        => "(GMT+02:00) Harare",
	    'Europe/Helsinki'      => "(GMT+02:00) Helsinki",
	    'Europe/Istanbul'      => "(GMT+02:00) Istanbul",
	    'Asia/Jerusalem'       => "(GMT+02:00) Jerusalem",
	    'Europe/Kiev'          => "(GMT+02:00) Kyiv",
	    'Europe/Minsk'         => "(GMT+02:00) Minsk",
	    'Europe/Riga'          => "(GMT+02:00) Riga",
	    'Europe/Sofia'         => "(GMT+02:00) Sofia",
	    'Europe/Tallinn'       => "(GMT+02:00) Tallinn",
	    'Europe/Vilnius'       => "(GMT+02:00) Vilnius",
	    'Asia/Baghdad'         => "(GMT+03:00) Baghdad",
	    'Asia/Kuwait'          => "(GMT+03:00) Kuwait",
	    'Africa/Nairobi'       => "(GMT+03:00) Nairobi",
	    'Asia/Riyadh'          => "(GMT+03:00) Riyadh",
	    'Asia/Tehran'          => "(GMT+03:30) Tehran",
	    'Europe/Moscow'        => "(GMT+04:00) Moscow",
	    'Asia/Baku'            => "(GMT+04:00) Baku",
	    'Europe/Volgograd'     => "(GMT+04:00) Volgograd",
	    'Asia/Muscat'          => "(GMT+04:00) Muscat",
	    'Asia/Tbilisi'         => "(GMT+04:00) Tbilisi",
	    'Asia/Yerevan'         => "(GMT+04:00) Yerevan",
	    'Asia/Kabul'           => "(GMT+04:30) Kabul",
	    'Asia/Karachi'         => "(GMT+05:00) Karachi",
	    'Asia/Tashkent'        => "(GMT+05:00) Tashkent",
	    'Asia/Kolkata'         => "(GMT+05:30) Kolkata",
	    'Asia/Kathmandu'       => "(GMT+05:45) Kathmandu",
	    'Asia/Yekaterinburg'   => "(GMT+06:00) Ekaterinburg",
	    'Asia/Almaty'          => "(GMT+06:00) Almaty",
	    'Asia/Dhaka'           => "(GMT+06:00) Dhaka",
	    'Asia/Novosibirsk'     => "(GMT+07:00) Novosibirsk",
	    'Asia/Bangkok'         => "(GMT+07:00) Bangkok",
	    'Asia/Jakarta'         => "(GMT+07:00) Jakarta",
	    'Asia/Krasnoyarsk'     => "(GMT+08:00) Krasnoyarsk",
	    'Asia/Chongqing'       => "(GMT+08:00) Chongqing",
	    'Asia/Hong_Kong'       => "(GMT+08:00) Hong Kong",
	    'Asia/Kuala_Lumpur'    => "(GMT+08:00) Kuala Lumpur",
	    'Australia/Perth'      => "(GMT+08:00) Perth",
	    'Asia/Singapore'       => "(GMT+08:00) Singapore",
	    'Asia/Taipei'          => "(GMT+08:00) Taipei",
	    'Asia/Ulaanbaatar'     => "(GMT+08:00) Ulaan Bataar",
	    'Asia/Urumqi'          => "(GMT+08:00) Urumqi",
	    'Asia/Irkutsk'         => "(GMT+09:00) Irkutsk",
	    'Asia/Seoul'           => "(GMT+09:00) Seoul",
	    'Asia/Tokyo'           => "(GMT+09:00) Tokyo",
	    'Australia/Adelaide'   => "(GMT+09:30) Adelaide",
	    'Australia/Darwin'     => "(GMT+09:30) Darwin",
	    'Asia/Yakutsk'         => "(GMT+10:00) Yakutsk",
	    'Australia/Brisbane'   => "(GMT+10:00) Brisbane",
	    'Australia/Canberra'   => "(GMT+10:00) Canberra",
	    'Pacific/Guam'         => "(GMT+10:00) Guam",
	    'Australia/Hobart'     => "(GMT+10:00) Hobart",
	    'Australia/Melbourne'  => "(GMT+10:00) Melbourne",
	    'Pacific/Port_Moresby' => "(GMT+10:00) Port Moresby",
	    'Australia/Sydney'     => "(GMT+10:00) Sydney",
	    'Asia/Vladivostok'     => "(GMT+11:00) Vladivostok",
	    'Asia/Magadan'         => "(GMT+12:00) Magadan",
	    'Pacific/Auckland'     => "(GMT+12:00) Auckland",
	    'Pacific/Fiji'         => "(GMT+12:00) Fiji",
	);
?>
											<select name="timezone" id="select2">
<?php 
	for($i=0; $i<count($timezones)-1; $i++){
	$city =  array_keys($timezones);
	$gmt = $city[$i];
?>
					      						<option value="<?php echo $city[$i]; ?>"><?php echo $timezones[$gmt]; ?></option>
<?php } ?>
					      					</select>
										</div> <!-- / .form-group -->	
										<div class="form-group has-feedback" id="admin_theme">
											<label class="control-label"><?php echo $lg_theme ?>*</label>
											<p>
												<div class="col-md-1">
													<label class="radio">
														<input type="radio" name="admin_theme" value="adminflare" class="px" checked="checked"/>
														<span class="lbl"><img src="../elybin-admin/assets/full/themes/adminflare.png" class="img-rounded" alt="thumbnail" style="width: 40px; height: 40px;"/></span>
													</label>
												</div>
												<div class="col-md-1">
													<label class="radio">
														<input type="radio" name="admin_theme" value="asphalt" class="px"/>
														<span class="lbl"><img src="../elybin-admin/assets/full/themes/asphalt.png" class="img-rounded" alt="thumbnail" style="width: 40px; height: 40px;"/></span>
													</label>
												</div>
												<div class="col-md-1">
													<label class="radio">
														<input type="radio" name="admin_theme" value="clean" class="px"/>
														<span class="lbl"><img src="../elybin-admin/assets/full/themes/clean.png" class="img-rounded" alt="thumbnail" style="width: 40px; height: 40px;"/></span>
													</label>
												</div>
												<div class="col-md-1">
													<label class="radio">
														<input type="radio" name="admin_theme" value="default" class="px"/>
														<span class="lbl"><img src="../elybin-admin/assets/full/themes/default.png" class="img-rounded" alt="thumbnail" style="width: 40px; height: 40px;"/></span>
													</label>
												</div>
												<div class="col-md-1">
													<label class="radio">
														<input type="radio" name="admin_theme" value="dust" class="px"/>
														<span class="lbl"><img src="../elybin-admin/assets/full/themes/dust.png" class="img-rounded" alt="thumbnail" style="width: 40px; height: 40px;"/></span>
													</label>
												</div>
												<div class="col-md-1">
													<label class="radio">
														<input type="radio" name="admin_theme" value="fresh" class="px"/>
														<span class="lbl"><img src="../elybin-admin/assets/full/themes/fresh.png" class="img-rounded" alt="thumbnail" style="width: 40px; height: 40px;"/></span>
													</label>
												</div>
												<div class="col-md-1">
													<label class="radio">
														<input type="radio" name="admin_theme" value="frost" class="px"/>
														<span class="lbl"><img src="../elybin-admin/assets/full/themes/frost.png" class="img-rounded" alt="thumbnail" style="width: 40px; height: 40px;"/></span>
													</label>
												</div>
												<div class="col-md-1">
													<label class="radio">
														<input type="radio" name="admin_theme" value="purple-hills" class="px"/>
														<span class="lbl"><img src="../elybin-admin/assets/full/themes/purple-hills.png" class="img-rounded" alt="thumbnail" style="width: 40px; height: 40px;"/></span>
													</label>
												</div>
												<div class="col-md-1">
													<label class="radio">
														<input type="radio" name="admin_theme" value="silver" class="px"/>
														<span class="lbl"><img src="../elybin-admin/assets/full/themes/silver.png" class="img-rounded" alt="thumbnail" style="width: 40px; height: 40px;"/></span>
													</label>
												</div>
												<div class="col-md-1">
													<label class="radio">
														<input type="radio" name="admin_theme" value="white" class="px"/>
														<span class="lbl"><img src="../elybin-admin/assets/full/themes/white.png" class="img-rounded" alt="thumbnail" style="width: 40px; height: 40px;"/></span>
													</label>
												</div>
											</p>
										</div> <!-- / .form-group -->																
										<hr class="panel-wide"/>
										<button class="btn btn-primary"><?php echo $lg_next ?></button>
										<a class="btn btn-primary wizard-next-step-btn" style="display: none"><?php echo $lg_next ?></a>
										<span id="pg-loading" style="display: none">&nbsp;&nbsp; <i class="fa fa-spin fa-repeat"></i>&nbsp;&nbsp;<?php echo $lg_processing ?>...</span>
										<span id="pg-res" style="display: none"></span>
									</form>
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
	<script type="text/javascript">if (!window.jQuery) { document.write('<script src="../elybin-admin/assets/javascripts/jquery.min.js"><\/script>'); }</script>
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
	$("#select2").select2({
		allowClear: false,
		placeholder: "Zona Waktu"
	});	
	$("#select3").select2({
		allowClear: false,
		placeholder: "Admin Theme"
	});
	$("#website-info").validate({
		ignore: '.ignore, .select2-input',
		focusInvalid: false,
		rules: {
			'site_email': {
				required: true,
				email: true
			}
		}
	});
	$('#tooltip a').tooltip();
});
window.PixelAdmin.start(init);
<?php ob_end_flush(); // minify_js ?>
</script>
</body>
</html>
<?php 
ob_end_flush(); // minify_html	
?>