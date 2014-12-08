<?php
/* Short description for file
 * [ Main theme of admin panel
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
?>
<?php function theme_head(){ 
define("START_EXEC", microtime());
include('./lang/main.php');
//
$getoption1 = new ElybinTable('elybin_options'); 
$homeurl = $getoption1->SelectWhere('name','site_url','','')->current()->value; 

$site_name = $getoption1->SelectWhere('name','site_name','','')->current()->value; 
$admin_theme = $getoption1->SelectWhere('name','admin_theme','','')->current()->value; 

$getoption2 = new ElybinTable('elybin_options'); 
$shortname_option = $getoption2->SelectWhere('name','short_name','','')->current()->value; 

//
$menucount1 = new ElybinTable('elybin_posts'); 
$c_post = '';
$c_post = $menucount1->GetRow('',''); 

$menucount2 = new ElybinTable('elybin_category'); 
$c_category = '';
$c_category = $menucount2->GetRow('',''); 

$menucount3 = new ElybinTable('elybin_tag'); 
$c_tag = '';
$c_tag = $menucount3->GetRow('',''); 

$menucount4 = new ElybinTable('elybin_media'); 
$c_media = '';
$c_media = $menucount4->GetRow('',''); 

$menucount5 = new ElybinTable('elybin_album'); 
$c_album = '';
$c_album = $menucount5->GetRow('',''); 

$menucount6 = new ElybinTable('elybin_gallery'); 
$c_gallery = '';
$c_gallery = $menucount6->GetRow('',''); 

$menucount7 = new ElybinTable('elybin_pages'); 
$c_page = '';
$c_page = $menucount7->GetRow('',''); 

$menucount8 = new ElybinTable('elybin_comments'); 
$c_comment = '';
$c_comment = $menucount8->GetRow('',''); 

$menucount9 = new ElybinTable('elybin_contact'); 
$c_message = '';
$c_message = $menucount9->GetRow('',''); 

$menucount10 = new ElybinTable('elybin_users'); 
$c_user = '';
$c_user = $menucount10->GetRow('',''); 

// get current active user
$s = $_SESSION['login'];
$tblu = new ElybinTable("elybin_users");
$tblu = $tblu->SelectWhere("session","$s","","");
$tblu = $tblu->current();

// get user privilages
$level = $tblu->level; // getting level from curent user
$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
// get priv value
$privpost = $tbug->current()->post;
// get priv value
$privcat = $tbug->current()->category;
// get priv value
$privtag = $tbug->current()->tag;
// get priv value
$privmedia = $tbug->current()->media;
// get priv value
$privalbum = $tbug->current()->album;
// get priv value
$privgallery = $tbug->current()->gallery;
// get priv value
$privpage = $tbug->current()->page;
// get priv value
$privcomment = $tbug->current()->comment;
// get priv value
$privcontact = $tbug->current()->contact;
// get priv value
$privuser = $tbug->current()->user;
// get priv value
$privsetting = $tbug->current()->setting;

// sub title
if(isset($subtitle)){
	$subtitle = " - $subtitle";
}else{
	$subtitle = "";
}


?>
<!DOCTYPE html>
<!--[if IE 8]>         <html class="ie8"> <![endif]-->
<!--[if IE 9]>         <html class="ie9 gt-ie8"> <![endif]-->
<!--[if gt IE 9]><!--> <html class="gt-ie8 gt-ie9 not-ie"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ElybinCMS<?php echo $subtitle?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	
	<!-- Favicons -->
    <link rel="icon" href="assets/images/pixel-admin/main-navbar-logo.png" />
	
	<!-- Open Sans font from Google CDN -->
	<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'> 

	<!-- Pixel Admin's stylesheets -->
	<link href="assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/pages.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/rtl.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/themes.min.css" rel="stylesheet" type="text/css">

	<!--[if lt IE 9]>
		<script src="assets/javascripts/ie.min.js"></script>
	<![endif]-->

</head>
<body class="theme-<?php echo $admin_theme; ?> main-menu-animated main-navbar-fixed">

<script src="assets/javascripts/elybin-function.php"></script>
<script src="assets/javascripts/jquery.min.js"></script>
<script>
var init = [];
</script>
<div id="main-wrapper">


<!-- 2. $MAIN_NAVIGATION ===========================================================================

	Main navigation
-->
	<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
		<!-- Main menu toggle -->
		<button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text"><?php echo strtoupper($lg_hidemenu)?></span></button>
		
		<div class="navbar-inner">
			<!-- Main navbar header -->
			<div class="navbar-header">

				<!-- Logo -->
				<a href="admin.php?mod=home" class="navbar-brand">
					<div><img alt="Pixel Admin" src="assets/images/pixel-admin/main-navbar-logo.png"></div>
					Elybin<em><strong>CMS</strong></em>
				</a>

				<!-- Main navbar toggle -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>

			</div> <!-- / .navbar-header -->

			<div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
				<div>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo $site_name?></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo $homeurl?>" target="_blank"><?php echo $lg_visitpage?></a></li>
							</ul>
						</li>
						<?php
							// show if have privilage
							if($privpost == 1 OR $privmedia == 1 OR $privpage == 1 OR $privuser == 1){
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo $lg_new?></a>
							<ul class="dropdown-menu">
							<?php
								// show if have privilage
								if($privpost == 1){
							?>
								<li><a href="?mod=post&amp;act=add"><?php echo $lg_post?></a></li>
							<?php } ?>
							<?php
								// show if have privilage
								if($privmedia == 1){
							?>
								<li><a href="?mod=media&amp;act=add"><?php echo $lg_media?></a></li>
							<?php } ?>
							<?php
								// show if have privilage
								if($privpage == 1){
							?>
								<li><a href="?mod=page&amp;act=add"><?php echo $lg_page?></a></li>
							<?php } ?>
							<?php
								// show if have privilage
								if($privuser == 1){
							?>
								<li><a href="?mod=user&amp;act=add"><?php echo $lg_user?></a></li>
							<?php } ?>
							</ul>
						</li>
						<?php } ?>
					</ul> <!-- / .navbar-nav -->
					<div class="right clearfix">
						<ul class="nav navbar-nav pull-right right-navbar-nav">


<!-- 3. $NAVBAR_ICON_BUTTONS =======================================================================

							Navbar Icon Buttons

							NOTE: .nav-icon-btn triggers a dropdown menu on desktop screens only. On small screens .nav-icon-btn acts like a hyperlink.

							Classes:
							* 'nav-icon-btn-info'
							* 'nav-icon-btn-success'
							* 'nav-icon-btn-warning'
							* 'nav-icon-btn-danger' 
-->	

							<?php
								// show if have privilage
								if($privsetting == 1){
								include "notification.php";
								} 
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
									<?php
										$avatar = $tblu->avatar;

										if(file_exists("../elybin-file/avatar/medium-".$avatar)){
											$avatar = "medium-".$avatar;
										}else{
											$avatar = $avatar;
										}
										$avatar = "../elybin-file/avatar/".$avatar;
									?><img src="<?php echo $avatar?>" alt="<?php echo $lg_thumbnail?>">
									<span><?php echo $tblu->fullname?></span>
								</a>
								<ul class="dropdown-menu">
									<li class="dropdown-header text-center"><?php echo $lg_shortcut?></li>
									<li class="divider"></li>
									<li><a href="<?php echo $homeurl?>"  target="_blank"><i class="fa fa-desktop"></i>&nbsp;&nbsp;<?php echo $lg_frontend?></a></li>
									<?php
										// show if have privilage
										if($privcontact == 1){
									?>
									<li><a href="?mod=contact"><i class="fa fa-envelope"></i>&nbsp;&nbsp;<?php echo $lg_message?></a></li>
									<?php } ?>
									<li class="divider"></li>
									<li><a href="?mod=profile"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo $lg_account?></a></li>
									<?php
										// show if have privilage
										if($privsetting == 1){
									?>
									<li><a href="?mod=option"><i class="fa fa-cog"></i>&nbsp;&nbsp;<?php echo $lg_setting?></a></li>
									<?php } ?>
									<li><a href="?mod=about"><i class="fa fa-info-circle"></i>&nbsp;&nbsp;<?php echo $lg_about?></a></li>
									<li class="divider"></li>
									<li><a data-toggle="modal" data-target="#logout-modal"><i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;<?php echo $lg_logout?></a></li>
								</ul>
							</li>
						</ul> <!-- / .navbar-nav -->


					</div> <!-- / .right -->
				</div>
			</div> <!-- / #main-navbar-collapse -->
		</div> <!-- / .navbar-inner -->
	</div> <!-- / #main-navbar -->
<!-- /2. $END_MAIN_NAVIGATION -->

	<div id="main-menu" role="navigation">
		<div id="main-menu-inner">
			<div class="menu-content top" id="menu-content-demo">
				<div>
					<?php
						$shortname = $tblu->fullname;
						$shortname = explode(" ", $shortname);
						if(count($shortname)>0){
							if($shortname_option=='first'){
								$shortname = $shortname[0];
							}else{
								$shortname = $shortname[count($shortname)-1];
							}
							
						}
					?><div class="text-bg"><span class="text-slim"><?php echo $lg_hi?>,</span> <span class="text-semibold"><?php echo $shortname?></span></div>
					<img src="<?php echo $avatar?>" alt="Avatar">
					<div class="btn-group">	
						<a href="<?php echo $homeurl?>" target="_blank" class="btn btn-xs btn-primary btn-outline dark" data-original-title="Tooltip on bottom" data-placement="bottom" data-toggle="tooltip"><i class="fa fa-desktop"></i></a>
						<a href="?mod=profile" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-user"></i></a>
						<?php
							// show if have privilage
							if($privcontact == 1){
						?>
						<a href="?mod=option" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-cog"></i></a>
						<?php }else{ ?>
						<a href="?mod=about" class="btn btn-xs btn-primary btn-outline dark"><i class="fa fa-info"></i></a>
						<?php } ?>
						<a class="btn btn-xs btn-danger btn-outline dark" data-toggle="modal" data-target="#logout-modal"><i class="fa fa-power-off"></i></a>
					</div>
				</div>
			</div>
			<ul class="navigation">
				<li class="active">
					<a href="?mod=home"><i class="menu-icon fa fa-dashboard"></i><span class="mm-text"><?php echo $lg_dashboard?></span></a>
				</li>
				<?php
					// show if have privilage
					if($privpost == 1 OR $privcat == 1 OR $privtag == 1){
				?>
				<li class="mm-dropdown">
					<a href="#"><i class="menu-icon fa fa-pencil"></i><span class="mm-text"><?php echo $lg_post?></span></a>
					<ul>
						<?php
							// show if have privilage
							if($privpost == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=post"><span class="mm-text"><?php echo $lg_allpost?></span><span class="label label-info"><?php echo $c_post?></span></a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=post&amp;act=add"><span class="mm-text"><?php echo $lg_addnew?></span></a>
						</li>
						<?php } ?>
						<?php
							// show if have privilage
							if($privcat == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=category"><i class="menu-icon fa fa-star"></i><span class="mm-text"><?php echo $lg_category?></span><span class="label label-info"><?php echo $c_category?></span></a>
						</li>
						<?php } ?>
						<?php
							// show if have privilage
							if($privtag == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=tag"><i class="menu-icon fa fa-tags"></i><span class="mm-text"><?php echo $lg_tag?></span><span class="label label-info"><?php echo $c_tag?></span></a>
						</li>
						<?php } ?>
					</ul>
				</li>
				<?php } ?>
				<?php
					// show if have privilage
					if($privmedia == 1 OR $privalbum == 1 OR $privgallery == 1){
				?>
				<li class="mm-dropdown">
					<a href="#"><i class="menu-icon fa fa-cloud"></i><span class="mm-text"><?php echo $lg_media?></span></a>
					<ul>
						<?php
							// show if have privilage
							if($privmedia == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=media"><span class="mm-text"><?php echo $lg_library?></span><span class="label label-info"><?php echo $c_media?></span></a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=media&amp;act=add"><span class="mm-text"><?php echo $lg_addnew?></span></a>
						</li>
						<?php } ?>
						<?php
							// show if have privilage
							if($privalbum == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=album"><span class="mm-text"><i class="menu-icon fa fa-book"></i><?php echo $lg_album?></span><span class="label label-info"><?php echo $c_album?></span></a>
						</li>
						<?php } ?>
						<?php
							// show if have privilage
							if($privgallery == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=gallery"><span class="mm-text"><i class="menu-icon fa fa-picture-o"></i><?php echo $lg_photogallery?></span><span class="label label-info"><?php echo $c_gallery?></span></a>
						</li>
						<?php } ?>
					</ul>
				</li>
				<?php } ?>
				<?php
					// show if have privilage
					if($privpage == 1){
				?>
				<li class="mm-dropdown">
					<a href="#"><i class="menu-icon fa fa-file"></i><span class="mm-text"><?php echo $lg_page?></span></a>
					<ul>
						<li>
							<a tabindex="-1" href="?mod=page"><span class="mm-text"><?php echo $lg_allpage?></span><span class="label label-info"><?php echo $c_page?></span></a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=page&amp;act=add"><span class="mm-text"><?php echo $lg_addnew?></span></a>
						</li>
					</ul>
				</li>
				<?php } ?>
				<?php
					// show if have privilage
					if($privcomment == 1 OR $privcontact == 1){
				?>
				<li class="mm-dropdown">
					<a href="#"><i class="menu-icon fa fa-comments"></i><span class="mm-text"><?php echo $lg_interaction?></span></a>
					<ul>
						<?php
							// show if have privilage
							if($privcomment == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=comment"><span class="mm-text"><i class="menu-icon fa fa-comment"></i><?php echo $lg_comment?></span><span class="label label-info"><?php echo $c_comment?></span></a>
						</li>
						<?php } ?>
						<?php
							// show if have privilage
							if($privcontact == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=contact"><span class="mm-text"><i class="menu-icon fa fa-envelope"></i><?php echo $lg_message?></span><span class="label label-info"><?php echo $c_message?></span></a>
						</li>
						<?php } ?>
					</ul>
				</li>
				<?php } ?>
				<?php
					// show if have privilage
					if($privuser == 1){
				?>
				<li class="mm-dropdown">
					<a href="#"><i class="menu-icon fa fa-users"></i><span class="mm-text"><?php echo $lg_user?></span></a>
					<ul>
						<li>
							<a tabindex="-1" href="?mod=user"><span class="mm-text"><?php echo $lg_alluser?></span><span class="label label-info"><?php echo $c_user?></span></a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=user&amp;act=add"><span class="mm-text"><?php echo $lg_addnew?></span></a>
						</li>
					</ul>
				</li>
				<?php } ?>
				<?php
					$tblpl = new ElybinTable('elybin_plugins');
					$lpl = $tblpl->SelectWhereAnd('status','active','type','apps','','');
					$cpl = $tblpl->GetRowAnd('status','active','type','apps');

					// count available plugin for cureent user
					foreach ($lpl as $pl) {
						//explode usergroup and search
						$plugin_priv = explode(",",$pl->usergroup);
						// hide if privillage not found
						if (array_search($level, $plugin_priv) !== false) {
							@$plavailable++;
						}
					}

					// if active pluigin and available plugin for this user more than zero
					if($cpl>0 AND @$plavailable>0){
				?>
				<li class="mm-dropdown">
					<a href="#"><i class="menu-icon fa fa-puzzle-piece"></i><span class="mm-text"><?php echo $lg_apps?></span></a>
					<ul>
						<?php
							foreach ($lpl as $pl) {
								//explode usergroup and search
								$plugin_priv = explode(",",$pl->usergroup);
								// hide if privillage not found
								if (array_search($level, $plugin_priv) !== false) {
									// notificatrion hide if return zero
									if($pl->notification > 0){
										$notif = $pl->notification;
									}else{
										$notif = '';
									}
						?>
						<li>
							<a tabindex="-1" href="?mod=<?php echo $pl->alias?>"><span class="mm-text"><i class="menu-icon fa <?php echo $pl->icon?>"></i><?php echo $pl->name?></span><span class="label label-info"><?php echo $notif?></span></a>
						</li>
						<?php } } ?>
					</ul>
				</li>
				<?php } ?>
				<?php
					// show if have privilage
					if($privsetting == 1){
				?>				
				<li class="mm-dropdown">
					<a href="#"><i class="menu-icon fa fa-wrench"></i><span class="mm-text"><?php echo $lg_setting?></span></a>
					<ul>
						<li>
							<a tabindex="-1" href="?mod=option"><span class="mm-text"><i class="menu-icon fa fa-gear"></i><?php echo $lg_general?></span></a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=theme"><span class="mm-text"><i class="menu-icon fa fa-tint"></i><?php echo $lg_theme?></span></a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=plugin"><span class="mm-text"><i class="menu-icon fa fa-puzzle-piece"></i><?php echo $lg_plugin?></span></a>
						</li>
						<?php if($tblu->user_id == 1){ ?>
						<li>
							<a tabindex="-1" href="?mod=usergroup"><span class="mm-text"><i class="menu-icon fa fa-users"></i><?php echo $lg_usergroup?></span></a>
						</li>
						<?php } ?>
						<li>
							<a tabindex="-1" href="?mod=menumanager"><span class="mm-text"><i class="menu-icon fa fa-bars"></i><?php echo $lg_menumanager?></span></a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=notification"><span class="mm-text"><i class="menu-icon fa fa-bell"></i><?php echo $lg_notification?></span></a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=widget"><span class="mm-text"><i class="menu-icon fa fa-th-large"></i><?php echo $lg_widget?></span></a>
						</li>
						<?php if($tblu->user_id == 1){ ?>
						<li>
							<a tabindex="-1" href="?mod=tools"><span class="mm-text"><i class="menu-icon fa fa-magic"></i><?php echo $lg_tools?></span></a>
						</li>
						<?php  } ?>
						<li>
							<a tabindex="-1" href="?mod=about"><span class="mm-text"><i class="menu-icon fa fa-info-circle"></i><?php echo $lg_about?></span></a>
						</li>
					</ul>
				</li>
				<?php } ?>
			</ul> <!-- / .navigation -->
		</div> <!-- / #main-menu-inner -->
	</div> <!-- / #main-menu -->
<!-- /4. $MAIN_MENU -->


	<div id="content-wrapper">
		 <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("IH0gcGhwPzwJCQoNPnZpZC88CQkKDT52aWQvPAkJCQoNLj4/IHN1dGNhdG5vY2VzYWVscGVsYmF0c3RvbmxsaXdtZXRzeXNyZWJtdW5sYWlyZXNkaWxhdm5pX2dsJCBvaGNlIHBocD88ID5nbm9ydHMvPCE+PyBoY3VvX2dsJCBvaGNlIHBocD88Pmdub3J0czwJCQkJCg0+ImtyYWQtdHJlbGEgcmVnbmFkLXRyZWxhIGtyYWRfc3RyZWxhX2VnYXBfYXAgZWdhcC10cmVsYSB0cmVsYSI9c3NhbGMgImV1cnQiPWV0YW1pbmEtYXRhZCAiIj1lbHl0cyB2aWQ8CQkJCg0+InhvYi1zdHJlbGEtZWdhcC1hcCI9ZGkgdmlkPAkJCg0+PyB7KWVzbGFmID09ICkob2VzZW5pZ25laGNyYWVzKGZp"))); ?>
<!-- 5. $CONTENT ===================================================================================

		Content
-->
<?php } ?>
<?php 
function theme_foot(){ 
include('./lang/main.php');
?>
		<hr class="no-grid-gutter-h"/>
		<div class="text-right text-light-gray">
			proccesed <?php echo round(((microtime()-START_EXEC)/60),5)?> seconds - <a href="http://www.elybin.com/" alt="Elybin Official">Elybin CMS</a> &copy; 2014
		</div>
	</div> <!-- / #content-wrapper -->
	<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->

	<!-- Logout Modal -->
	<div id="logout-modal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><i class="fa fa-times"></i></button>
					<h4 class="modal-title"><i class="fa fa-power-off"></i>&nbsp;&nbsp;<?php echo $lg_logouttitle?></h4>
				</div>
				<div class="modal-body"><?php echo $lg_logoutquestion?>
					<hr/>
					<a href="logout.php" class="btn btn-danger"><i class="fa fa-power-off"></i>&nbsp;<?php echo $lg_yesexit?></a>
					<button class="btn pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></button>
				</div>
			</div> <!-- / .modal-content -->
		</div> <!-- / .modal-dialog -->
	</div> <!-- / .modal -->
	<!-- / Logout Modal -->

<!-- Get jQuery from Google CDN -->
<!--[if !IE]> -->
	<script type="text/javascript"> window.jQuery || document.write('<script src="assets/javascripts/jquery.min.js">'+"<"+"/script>"); </script>
<!-- <![endif]-->
<!--[if lte IE 9]>
	<script type="text/javascript"> window.jQuery || document.write('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js">'+"<"+"/script>"); </script>
<![endif]-->

<script src="assets/javascripts/jquery.transit.js"></script>

<!-- Pixel Admin's javascripts -->
<script src="assets/javascripts/bootstrap.min.js"></script>
<script src="assets/javascripts/pixel-admin.min.js"></script>
<script type="text/javascript">
	init.push(function () {
		// Javascript code here
		$("#notif .notification-description i").hide();
		$('#notificon').click(function(){
			$('#notificon a .label').html("");
				$.ajax({
					type: 'POST',
					url: "app/notification/proses.php",
					data: "mod=notification&act=read",
					success: function(data) {
						if(data=="ok"){
							$("#notif").css("background","#efefef");
						}
					}
				})
		});
	});
	window.PixelAdmin.start(init);
</script>


</body>
</html>
<?php } ?>