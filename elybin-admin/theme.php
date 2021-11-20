<?php
/* Short description for file
 * [ Main theme of admin panel
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
?>
<?php function theme_head(){
define("START_EXEC", microtime());
include('./lang/main.php');

// grab info
$op = _op();

// current user
$u = _u();

// current user
$ug = _ug();

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
$privgallery = 0;
// get priv value
$privpage = $tbug->current()->page;
// get priv value
$privcomment = $tbug->current()->comment;
// get priv value
$privcontact = @$tbug->current()->messager;
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
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>Elybin CMS - <?php echo date('H:i:s') ?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">


	<link href="assets/stylesheets/<?php echo $op->admin_theme?>.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/fontawesome.css" rel="stylesheet" type="text/css">


	<link href="assets/stylesheets/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/pixel-admin.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/<?php echo $op->admin_theme?>.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/primary.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/widgets.min.css" rel="stylesheet" type="text/css">
	<link href="assets/stylesheets/ui.css" rel="stylesheet" type="text/css">

	<meta name="theme-color" content="#435267">
</head>
<body class="theme-<?php echo $op->admin_theme?> main-menu-animated main-navbar-fixed mmc">
<script>var init = [];</script>
<div id="main-wrapper">

	<div id="main-navbar" class="navbar navbar-inverse" role="navigation">
		<!-- Main menu toggle -->
		<button type="button" id="main-menu-toggle"><i class="navbar-icon fa fa-bars icon"></i><span class="hide-menu-text"><?php echo lg('Hide Menu') ?></span></button>

		<div class="navbar-inner">
			<!-- Main navbar header -->
			<div class="navbar-header">

				<!-- Logo -->
				<a href="admin.php?mod=home" class="navbar-brand">
					<div><img alt="Elybin CMS" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAYAAAA7MK6iAAACkklEQVR42u2W3UtTYRzHDwS9eha0q3Wzuqy/IKi7lRHdWZDQbd304plF3UQoaaQpCVHD0m0SGzpd5s7YKiIpfNk808Cc8w0UphtumM5NdC/ufHueY2k2pM2O3ugXPhzO2/fznJvfcxhmNzsyarX6OMdxWjk4RpK12Ol08pApDofDlpU0X6M5J5LIJaZdGo3m7L+8ewSPpxsLCcT0ZkQqnyNS/XJzkHdjBjNol1vwdNHuDa2FhVev0FVG60qToWsXkuGbBf8F7aBdtJN2b+Q9ODoW9GG2EakvrLjsOpqWA9qF2SaMjAV81JFh5bj7RcAiIJwAOpVAt0oeaJdwknzzErTae7fXSVmWVYbDkYA/1AKX6zw8wmXCJdmgnf6QFdOhuSmFQnFkVVz5pKqcrsjZp4Wt9xb4Xi5HijKw961BO9+TbuqoqHhaJklVKpU6sRCP9E82ocV9He88XAatv1h/rl3HW4JVohgtFKEYzcIdCYtwFybXDXj8ViQWFiPUyVgbTfqBuAgl/x0KfgAKu1eC5X8ziDz7IFjCYbuP3FuBlRiSyCMcIhzgV9jPD0vsW2UEe23DyLMNwZsALG8aXjPpdDo8HU9jYD4Fb2wZ3ugKg39Crn8Ix8E4psDwBPtftPlxUZiBL5Yiz26Mdz6JUCKN2ZmZCSaVSk1mM4Ei8WXkm9ziaX2neMbQtYaxSzxV+1Ws6ZnIepoFg8GxrMUgQ7Td8gm6B69geGyEvtwIA6G+zIDakjqExgNbJCaZn4uhQdeKqof1qHlkxLNSA6pL6tHd/i2n+Z2zmGZpMY6ejn7YLZ/xsa0D46OTOW8cmxLLkR0qJvv0j+0WR6PRAGMymV6YzeZmcrRsB9Sl0+lqdv9sd7Nl+Qlys2tBBC/Z4AAAAABJRU5ErkJggg=="></div>
					Elybin<em><strong>CMS</strong></em>
				</a>

				<!-- Main navbar toggle -->
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse"><i class="navbar-icon fa fa-bars"></i></button>

			</div> <!-- / .navbar-header -->

			<div id="main-navbar-collapse" class="collapse navbar-collapse main-navbar-collapse">
				<div>
					<ul class="nav navbar-nav">
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-home"></i>&nbsp;&nbsp;<?php echo $op->site_name?></a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo $op->site_url?>" target="_blank"><?php echo lg('Visit Page')?></a></li>
							</ul>
						</li>
						<?php
							// show if have privilage
							if($ug->post == 1 || $ug->media == 1 || $ug->page == 1 || $ug->user == 1){
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-plus"></i>&nbsp;&nbsp;<?php echo lg('New')?></a>
							<ul class="dropdown-menu">
							<?php
								// show if have privilage
								if($ug->post == 1){
							?>
								<li><a href="?mod=post&amp;act=add"><?php echo lg('Post') ?></a></li>
							<?php } ?>
							<?php
								// show if have privilage
								if($ug->media == 1){
							?>
								<li><a href="?mod=media&amp;act=add"><?php echo lg('Media') ?></a></li>
							<?php } ?>
							<?php
								// show if have privilage
								if($ug->page == 1){
							?>
								<li><a href="?mod=page&amp;act=add"><?php echo lg('Page') ?></a></li>
							<?php } ?>
							<?php
								// show if have privilage
								if($ug->user == 1){
							?>
								<li><a href="?mod=user&amp;act=add"><?php echo lg('User')?></a></li>
							<?php } ?>
							</ul>
						</li>
						<?php } ?>
					</ul> <!-- / .navbar-nav -->
					<div class="right clearfix">
						<ul class="nav navbar-nav pull-right right-navbar-nav">


							<?php
								// show if have privilage
								if($ug->setting == 1){
								include "notification.php";
								}
							?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle user-menu" data-toggle="dropdown">
									<?php
										// avatar
										if($u->avatar == "default/no-ava.png"){
											echo  '<img src="../elybin-file/avatar/default/medium-no-ava.png">';
										}else{
											echo  '<img src="../elybin-file/avatar/sm-'.$u->avatar.' ">';
										}
									?>
									<span><?php echo $u->fullname?></span>
								</a>
								<ul class="dropdown-menu">
									<li class="dropdown-header text-center"><?php echo lg('Shortcut')?></li>
									<li class="divider"></li>
									<li>
										<a href="<?php echo $op->site_url ?>"  target="_blank">
											<i class="fa fa-desktop"></i>&nbsp;&nbsp;<?php echo lg('Front End')?>
										</a>
									</li>
									<li>
										<a href="?mod=messager">
											<i class="fa fa-envelope"></i>&nbsp;&nbsp;<?php echo lg('Message')?>
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="?mod=profile">
											<i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo lg('Profile')?>
										</a>
									</li>
									<?php
										// show if have privilage
										if($ug->setting == 1){
									?>
									<li>
										<a href="?mod=option">
											<i class="fa fa-cog"></i>&nbsp;&nbsp;<?php echo lg('Setting')?>
										</a>
									</li>
									<?php } ?>
									<li>
										<a href="?mod=about">
											<i class="fa fa-info-circle"></i>&nbsp;&nbsp;<?php echo lg('About')?>
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a href="index.php?p=logout_modal" data-toggle="modal" data-target="#logout-modal">
											<i class="dropdown-icon fa fa-power-off"></i>&nbsp;&nbsp;<?php echo lg('Logout')?>
										</a>
									</li>
								</ul>
							</li>
						</ul> <!-- / .navbar-nav -->


					</div> <!-- / .right -->
				</div>
			</div> <!-- / #main-navbar-collapse -->
		</div> <!-- / .navbar-inner -->
	</div> <!-- / #main-navbar -->

	<div id="main-menu" role="navigation">
		<div id="main-menu-inner">
			<ul class="navigation">
				<li class="active">
					<a href="?mod=home">
						<i class="menu-icon fa fa-dashboard"></i>
						<span class="mm-text"><?php echo lg('Dashboard')?></span>
					</a>
				</li>
				<?php
					// show if have privilage
					if($ug->post == 1 ||  $ug->category == 1 ||  $ug->tag == 1){
				?>
				<li class="mm-dropdown">
					<a href="?mod=post">
						<i class="menu-icon fa fa-pencil"></i>
						<span class="mm-text"><?php echo lg('Post')?></span>
					</a>
					<ul>
						<?php
							// show if have privilage
							if($ug->post == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=post">
								<span class="mm-text"><?php echo lg('All Post')?></span>
							</a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=post&amp;act=add">
								<span class="mm-text"><?php echo lg('Add New')?></span>
							</a>
						</li>
						<?php } ?>
						<?php
							// show if have privilage
							if($ug->category == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=category">
								<i class="menu-icon fa fa-star"></i>
								<span class="mm-text"><?php echo lg('Category')?></span>
							</a>
						</li>
						<?php } ?>
						<?php
							// show if have privilage
							if($ug->tag == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=tag">
								<i class="menu-icon fa fa-tags"></i>
								<span class="mm-text"><?php echo lg('Tags')?></span>
							</a>
						</li>
						<?php } ?>
					</ul>
				</li>
				<?php } ?>
				<?php
					// show if have privilage
					if($ug->media == 1 || $ug->album == 1){
				?>
				<li class="mm-dropdown">
					<a href="#"><i class="menu-icon fa fa-cloud"></i>
						<span class="mm-text"><?php echo lg('Media')?></span>
					</a>
					<ul>
						<?php
							// show if have privilage
							if($ug->media == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=media">
								<span class="mm-text"><?php echo lg('Library')?></span>
							</a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=media&amp;act=add">
								<span class="mm-text"><?php echo lg('Add New')?></span>
							</a>
						</li>
						<?php } ?>
						<?php
							// show if have privilage
							if($ug->album == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=album">
								<span class="mm-text">
									<i class="menu-icon fa fa-book"></i><?php echo lg('Album')?>
								</span>
							</a>
						</li>
						<?php } ?>
					</ul>
				</li>
				<?php } ?>
				<?php
					// show if have privilage
					if($ug->page == 1){
				?>
				<li class="mm-dropdown">
					<a href="?mod=page">
						<i class="menu-icon fa fa-file"></i>
						<span class="mm-text"><?php echo lg('Page')?></span>
					</a>
					<ul>
						<li>
							<a tabindex="-1" href="?mod=page">
								<span class="mm-text"><?php echo lg('All Page')?></span>
							</a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=page&amp;act=add">
								<span class="mm-text"><?php echo lg('Add New')?></span>
							</a>
						</li>
					</ul>
				</li>
				<?php } ?>
				<?php
					// show if have privilage
					if($ug->comment == 1 || $u->user_id == 1){
				?>
				<li class="mm-dropdown">
					<a href="?mod=comment">
						<i class="menu-icon fa fa-comments"></i>
						<span class="mm-text"><?php echo lg('Interaction')?></span>
					</a>
					<ul>
						<?php
							// show if have privilage
							if($ug->comment == 1){
						?>
						<li>
							<a tabindex="-1" href="?mod=comment&amp;filter=unread">
								<span class="mm-text">
									<i class="menu-icon fa fa-comment"></i><?php echo lg('Comment')?>
								</span>
							</a>
						</li>
						<?php } ?>
						<li>
							<a tabindex="-1" href="?mod=messager">
								<span class="mm-text">
									<i class="menu-icon fa fa-envelope"></i><?php echo lg('Messager')?>
								</span>
							</a>
						</li>
					</ul>
				</li>
				<?php } ?>
				<?php
					// show if have privilage
					if($ug->user == 1){
				?>
				<li class="mm-dropdown">
					<a href="?mod=user">
						<i class="menu-icon fa fa-users"></i>
						<span class="mm-text"><?php echo lg('User') ?></span>
					</a>
					<ul>
						<li>
							<a tabindex="-1" href="?mod=user">
								<span class="mm-text"><?php echo lg('All User') ?></span>
							</a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=user&amp;act=add">
								<span class="mm-text"><?php echo lg('Add New') ?></span>
							</a>
						</li>
					</ul>
				</li>
				<?php } ?>
				<?php
				/** PLUGIN MENU */
					// count available plugin for current user
					// foreach ($lpl as $pl) {
					// 	//explode usergroup and search
					// 	$plugin_priv = explode(",",$pl->usergroup);
					// 	// hide if privillage not found
					// 	if (array_search($u->level, $plugin_priv) !== false) {
					// 		@$plavailable++;
					// 	}
					// }
					$plavailable = 1;

					/** echo */
					// not empty
					if( get_panel_menu() !== null ) {
						// loop
						foreach (get_panel_menu() as $k => $v) {
							$k = array_keys($v)[0];
							$v = $v[$k];
					?>
					<li<?php e(	(empty($v['submenu']) ? '':' class="mm-dropdown"')	) ?>>
						<a href="<?php e(	(empty($v['submenu']) ? @$v['url']:'#')	) ?>">
							<?php e(	(empty($v['icon']) ? '':'<i class="menu-icon fa '.$v['icon'].'"></i>')	) ?>
							<span class="mm-text"><?php e(	(empty($k) ? '':$k)	) ?></span>
							<span class="label label-primary"><?php e(	(empty($v['label']) ? '':$v['label'])	) ?></span>
						</a>

						<?php
						// if has child
						if(	!empty($v['submenu'])	){ ?>
							<ul>

							<?php
							// loop
							foreach ($v['submenu'] as $k2 => $v2) { ?>
							<li>
								<a href="<?php e(	(empty($v2['submenu']) ? $v2['url']:'#')	) ?>">
									<?php e(	(empty($v2['icon']) ? '':'<i class="menu-icon fa '.$v2['icon'].'"></i>')	) ?>
									<span class="mm-text"><?php e(	(empty($k2) ? '':$k2)	) ?></span>
									<span class="label label-primary"><?php e(	(empty($v2['label']) ? '':$v2['label'])	) ?></span>
								</a>
							</li>
						<?php
							} // loop?>
						</ul>
						<?php
						} // if end ?>
					</li>
					<?php
						} // loop
					} // not empty

					// if active pluigin and available plugin for this user more than zero
					if(@$plavailable>0){
						/*
				?>
				<li class="mm-dropdown">
					<a href="#">
						<i class="menu-icon fa fa-puzzle-piece"></i>
						<span class="mm-text"><?php echo lg('Apps') ?></span></a>
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
							<a tabindex="-1" href="?mod=<?php echo $pl->alias?>">
								<span class="mm-text">
									<i class="menu-icon fa <?php echo $pl->icon?>"></i>
									<?php echo $pl->name?></span>
								</a>
						</li>
						<?php } } ?>
					</ul>
				</li>
			<?php */} ?>
				<?php
					// show if have privilage
					if($ug->setting == 1){
				?>
				<li class="mm-dropdown">
					<a href="?mod=option">
						<i class="menu-icon fa fa-wrench"></i>
						<span class="mm-text"><?php echo lg('Setting') ?></span>
					</a>
					<ul>
						<li>
							<a tabindex="-1" href="?mod=option">
								<span class="mm-text">
									<i class="menu-icon fa fa-gear"></i><?php echo lg('General') ?>
								</span>
							</a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=theme">
								<span class="mm-text">
									<i class="menu-icon fa fa-tint"></i><?php echo lg('Theme') ?>
								</span></a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=plugin">
								<span class="mm-text">
									<i class="menu-icon fa fa-puzzle-piece"></i><?php echo lg('Plugin') ?></span>
								</a>
						</li>
						<?php if($u->user_id == 1){ ?>
						<li>
							<a tabindex="-1" href="?mod=usergroup">
								<span class="mm-text">
									<i class="menu-icon fa fa-users"></i><?php echo lg('Usergroup') ?>
								</span>
							</a>
						</li>
						<?php } ?>
						<li>
							<a tabindex="-1" href="?mod=menumanager">
								<span class="mm-text">
									<i class="menu-icon fa fa-bars"></i><?php echo lg('Menu Manager')?>
								</span>
							</a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=notification">
								<span class="mm-text">
									<i class="menu-icon fa fa-bell"></i><?php echo lg('Notification')?>
								</span>
							</a>
						</li>
						<li>
							<a tabindex="-1" href="?mod=widget">
								<span class="mm-text">
									<i class="menu-icon fa fa-th-large"></i><?php echo lg('Widget')?>
								</span>
							</a>
						</li>
						<?php if($u->user_id == 1){ ?>
						<li>
							<a tabindex="-1" href="?mod=tools">
								<span class="mm-text">
									<i class="menu-icon fa fa-magic"></i><?php echo lg('Tools') ?>
								</span>
							</a>
						</li>
						<?php  } ?>
						<li>
							<a tabindex="-1" href="?mod=about">
								<span class="mm-text">
									<i class="menu-icon fa fa-info-circle"></i><?php echo lg('About') ?>
								</span>
							</a>
						</li>
					</ul>
				</li>
				<?php } ?>
			</ul> <!-- / .navigation -->
		</div> <!-- / #main-menu-inner -->
	</div> <!-- / #main-menu -->

	<div id="content-wrapper">
<?php } ?>
<?php
function theme_foot(){
?>
		<hr class="no-grid-gutter-h"/>
		<div class="pull-left text-light-gray">
			<i><?php echo lg('Everything inside one bin, Elybin CMS.') ?></i>
		</div>
		<div class="pull-right text-light-gray">
			<?php echo round(((microtime()-START_EXEC)/60),5).' '.lg('sec') ?> - <a href="http://www.elybin.github.io/" title="Elybin CMS - Open Source Content Management">www.elybin.github.io</a>
		</div>
	</div> <!-- / #content-wrapper -->
	<div id="main-menu-bg"></div>
</div> <!-- / #main-wrapper -->
	<!-- Logout Modal -->
	<div id="logout-modal" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
		<div class="modal-dialog modal-sm animated bounceIn">
			<div class="modal-content">
				<?php echo lg('Loading...') ?>
			</div> <!-- / .modal-content -->
		</div> <!-- / .modal-dialog -->
	</div> <!-- / .modal -->
	<!-- / Logout Modal -->

	<script src="assets/javascripts/jquery.min.js"></script>
	<script src="assets/javascripts/bootstrap.min.js"></script>
	<script src="assets/javascripts/pixel-admin.min.js"></script>
	<script src="assets/javascripts/elybin-function.min.js"></script>

<script>
// load
init.push(function () {
	notif();
	// help
	$("a#help-button").click(function(){
		$("div#help-panel").toggle(300);
	});
});
window.PixelAdmin.start(init);
</script>
<?php
// check if js.php exist
$mod = @$_GET['mod'];
if(file_exists('./app/'.$mod.'/js.php')){
	include('./app/'.$mod.'/js.php');
}else{
	include('./app/home/js.php');
}
?>
</body>
</html>
<?php } ?>
