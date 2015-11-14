<?php
/* Short description for file
 * [ Module: Setting
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/option/";
$action		= $modpath."proses.php";

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->setting;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	// require first
	require_once('inc/main_function.inc.php');

  // start here
  switch (@$_GET['act']) {

    case 'location':
		$op = _op();
		if($op->site_coordinate == ""){
		  $op->site_coordinate  = "-7.396119962181347, 109.69514252969367";
		}
		$op->site_coordinate_ex  = explode(",", $op->site_coordinate );
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;<?php echo lg('Pick location')?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo lg('Setting')?> / </span><?php echo lg('Pick location')?></span>
				</h1>
			</div>
		</div> <!-- ./Page Header -->

		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel">
		  			<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-map-marker hidden-xs">&nbsp;&nbsp;</i><?php echo lg('Pick your current location')?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div>
					<!-- ./Panel Heading -->

					<!-- panel-body -->
					<div class="panel-body">
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-7">
								<div class="input-group">
									<input type="text" id="address" class="form-control"/>
									<span class="input-group-btn">
										<button class="btn btn-success" id="btn-save"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo lg('Save location')?></button>
									</span>
								</div>
								<p id="coordinate" class="help-block"><i><?php echo lg('Coordinate:')?>&nbsp;</i><span><?php echo $op->site_coordinate?></span></p>
							</div>
							<!-- Margin -->
							<div class="visible-xs clearfix form-group-margin"></div>
							<div class="col-xs-12 col-sm-12 col-md-2 pull-right">
								<button class="col-xs-12 col-sm-12 btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></button>
							</div>
						</div>
						<hr class="no-margin-b">
						<div class="row">
							<div class="col-sm-12">
								<div id="google-maps" style="width: 100%; height: 400px;" class="text-center">
								<br><br><br><br><br><br><br><br><br><br>
								<img src="assets/images/plugins/bootstrap-editable/loading.gif"><br>
							</div>
						</div>
					</div>
				</div>
				<!-- .panel-body -->
				<!-- Help modal -->
				<div id="help" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
								<h4 class="modal-title"><?php echo lg('')?></h4>
							</div>
							<div class="modal-body">
								...
							</div>
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / Help modal -->
			</div><!-- .panel -->
		</div> <!-- col -->
	</div> <!-- row -->

<?php
      break;

  	default:
  	$tb = new ElybinTable('elybin_options');
  	$in1 = $tb->SelectWhere('name','site_url','','')->current()->value;

  	$in2 = $tb->SelectWhere('name','site_name','','')->current()->value;

  	$in3 = $tb->SelectWhere('name','site_description','','')->current()->value;

  	$in4 = $tb->SelectWhere('name','site_keyword','','')->current()->value;

  	$in5 = $tb->SelectWhere('name','site_phone','','')->current()->value;
  	$in5 = html_entity_decode($in5);

  	$in6 = $tb->SelectWhere('name','site_office_address','','')->current()->value;

  	$in7 = $tb->SelectWhere('name','site_owner','','')->current()->value;

  	$in8 = $tb->SelectWhere('name','site_email','','')->current()->value;

  	$op_site_hero_title = $tb->SelectWhere('name','site_hero_title','','')->current()->value;
  	$op_site_hero_subtitle = $tb->SelectWhere('name','site_hero_subtitle','','')->current()->value;
  	$op_site_hero = $tb->SelectWhere('name','site_hero','','')->current()->value;

  	$in9 = $tb->SelectWhere('name','site_coordinate','','')->current()->value;
  	$in9 = html_entity_decode($in9);

  	$in10 = $tb->SelectWhere('name','site_logo','','')->current()->value;

  	$in11 = $tb->SelectWhere('name','site_favicon','','')->current()->value;

  	//KE2
  	$in12 = $tb->SelectWhere('name','users_can_register','','')->current()->value;
    if($in12=="allow"){
      $in12_label = lg('Allow');
    }else{
      $in12_label = lg('Deny');
    }
    $in12_label = ucwords($in12_label);

    $tbl = new ElybinTable('elybin_category');
  	$in13 = $tb->SelectWhere('name','default_category','','');
    $in13_id = $in13->current()->value;
    $in13 = $tbl->SelectWhere('category_id',$in13->current()->value,'','')->current()->name;

  	$in14 = $tb->SelectWhere('name','default_comment_status','','');
  	$in14 = $in14->current()->value;
    if($in14=="allow"){
      $in14_label = lg('Allow');
    }
	elseif($in14=="confrim"){
	  $in14_label = lg('Confrim');
	}else{
      $in14_label = lg('Deny');
    }
    $in14_label = ucwords($in14_label);

  	$in15 = $tb->SelectWhere('name','posts_per_page','','')->current()->value;

  	$in16 = $tb->SelectWhere('name','timezone','','');
  	$in16 = $in16->current()->value;

    $in17 = $tb->SelectWhere('name','language','','');
    $in17 = $in17->current()->value;

  	$in18 = $tb->SelectWhere('name','maintenance_mode','','');
  	$in18 = $in18->current()->value;
    if($in18=="active"){
      $in18_label = lg('Active');
    }else{
      $in18_label = lg('Inactive');
    }
    $in18_label = ucwords($in18_label);

  	$in19 = $tb->SelectWhere('name','developer_mode','','');
  	$in19 = $in19->current()->value;
    if($in19=="active"){
      $in19_label = lg('Active');
    }else{
      $in19_label = lg('Inactive');
    }
    $in19_label = ucwords($in19_label);

    $in20 = $tb->SelectWhere('name','short_name','','');
    $in20 = $in20->current()->value;
    if($in20=="first"){
      $in20_label = lg('First');
    }else{
      $in20_label = lg('Last');
    }
    $in20_label = ucwords($in20_label);

    $in21 = $tb->SelectWhere('name','text_editor','','');
    $in21 = $in21->current()->value;
    if($in21=="summernote"){
      $in21_label = "Summernote WYSIWYG";
    }
    elseif($in21=="bs-markdown"){
      $in21_label = "Bootstrap Markdown";
    }
    $in21_label = ucwords($in21_label);

	// social
	$in22 = $tb->SelectWhere('name','social_twitter','','')->current()->value;
	$in23 = $tb->SelectWhere('name','social_facebook','','')->current()->value;
	$in24 = $tb->SelectWhere('name','social_instagram','','')->current()->value;

	// stmp
	$smtp_host = $tb->SelectWhere('name','smtp_host','','')->current()->value;
	$smtp_port = $tb->SelectWhere('name','smtp_port','','')->current()->value;
	$smtp_user = $tb->SelectWhere('name','smtp_user','','')->current()->value;
	$smtp_pass = $tb->SelectWhere('name','smtp_pass','','')->current()->value;
	$smtp_status = $tb->SelectWhere('name','smtp_status','','')->current()->value;
	$mail_daily_limit = $tb->SelectWhere('name','mail_daily_limit','','')->current()->value;

	$op = _op();
    if($op->smtp_status=="active"){
      $smtp_status_label = lg('Active');
    }else{
      $smtp_status_label = lg('Inactive');
    }

	// default homepage
	$in_defaulthomepage = $tb->SelectWhere('name','default_homepage','','')->current()->value;
	// ambil dari table elybin_menu
	$tbmn = new ElybinTable('elybin_menu');
	$in_defaulthomepage_id = $in_defaulthomepage;
	$in_defaulthomepage = $tbmn->SelectWhere('menu_id',$in_defaulthomepage,'','')->current()->menu_title;
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-gear"></i>&nbsp;&nbsp;<?php echo lg('Setting')?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo lg('Setting')?> / </span><?php echo lg('General')?></span>
				</h1>
			</div>
		</div> <!-- ./Page Header -->

		<!-- Content here -->
		<style><?php include("assets/stylesheets/table.css"); ?></style>
		<style><?php include("assets/stylesheets/select2.css"); ?></style>

		<?php
		/** Get Message */
		get_message() ?>

		<div class="row">
			<div class="col-sm-12">
				<div class="panel">
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-gear hidden-xs">&nbsp;&nbsp;</i><?php echo lg('General Setting')?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div>
					<!-- ./Panel Heading -->

			 		<div class="panel-body">
			 		<a href="?mod=option&amp;act=information" class="btn<?php e( (@$_GET['act']=='information' || !isset($_GET['act']) ) ? ' btn-primary' : '')?>" style="margin-bottom: 10px;"><?php _e('Site Information')?></a>&nbsp;
			 		<a href="?mod=option&amp;act=interface" class="btn<?php e(@$_GET['act']=='interface' ? ' btn-primary' : '')?>" style="margin-bottom: 10px;"><?php _e('Interface')?></a>&nbsp;
			 		<a href="?mod=option&amp;act=communication" class="btn<?php e(@$_GET['act']=='communication' ? ' btn-primary' : '')?>" style="margin-bottom: 10px;"><?php _e('Communication')?></a>&nbsp;
			 		<a href="?mod=option&amp;act=system" class="btn<?php e(@$_GET['act']=='system' ? ' btn-primary' : '')?>" style="margin-bottom: 10px;"><?php _e('System')?></a>&nbsp;
			 		<a href="?mod=option&amp;act=permalink" class="btn<?php e(@$_GET['act']=='permalink' ? ' btn-primary': '')?>" style="margin-bottom: 10px;"><?php _e('Permalink')?></a>

			 		<?php
			 		// show if..
			 		if(@$_GET['act']=='information' || !isset($_GET['act'])){
			 		?>
					<table id="user" class="table table-bordered table-striped " style="clear: both">
					  <tbody>
						<tr>
						  <td width="35%"><?php echo lg('Install Location (Don\'t change this)')?></td>
						  <td width="65%"><a href="#" data-title="<?php echo lg('Install Location')?>"><?php echo $in1?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Site Title')?></td>
						  <td><a href="#" id="site_name" data-title="<?php echo lg('Site Title')?>"><?php echo $in2?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Site Description')?></td>
						  <td><a href="#" id="site_description" data-title="<?php echo lg('Site Description')?>"><?php echo $in3?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('SEO Keywords')?></td>
						  <td><a href="#" id="site_keyword" data-title="<?php echo lg('SEO Keywords')?>"><?php echo $in4?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Website Owner')?></td>
						  <td><a href="#" id="site_owner" data-title="<?php echo lg('Website Owner')?>"><?php echo $in7?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Location Address')?></td>
						  <td><a href="#" id="site_office_address" data-placeholder="<?php echo lg('Location Address')?>" data-title="<?php echo lg('Address')?>"><?php echo $in6?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Location Coordinate')?></td>
						  <td>
							<a href="?mod=option&amp;act=location" id="site_coordinate" data-title="<?php echo lg('Location Coordinate')?>"><?php echo $in9?></a>
						  </td>
						</tr>
						</tbody>
					</table>
			 		<?php
			 		// show if..
			 		}else if(@$_GET['act']=='interface'){
			 		?>
					<table id="user" class="table table-bordered table-striped " style="clear: both">
					  <tbody>
						<tr>
						  <td width="35%"><?php echo lg('Hero Title (Main title appear in homepage)')?></td>
						  <td width="65%"><a href="#" id="site_hero_title" data-title="<?php echo lg('Hero Title')?>"><?php echo $op_site_hero_title?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Hero Subtitle')?></td>
						  <td><a href="#" id="site_hero_subtitle" data-title="<?php echo lg('Hero Subtitle')?>"><?php echo $op_site_hero_subtitle?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Hero Image (Cover/Header)')?></td>
						  <td>
							<span class="btn btn-xs" id="site_hero"><?php echo lg('Show')?></span>
							<div id="site_hero_img" style="display:none;">
							  <form action="<?php e($action) ?>" method="post"  enctype="multipart/form-data">
								<span class="btn btn-xs pull-right" id="close"><i class="fa fa-times"></i></span>
								<div class="col-sm-12 panel-padding no-padding-b">
								  <img src="../elybin-file/system/md-<?php e(get_option('site_hero')) ?>" alt="" class="img-thumbnail form-group-margin" style="width: 100%">
								</div>
								<div class="col-sm-12 panel-padding no-padding-t">
								  <div class="input-group">
									 <input type="file" name="file" id="file-style3" class="form-control"/>
									 <span class="input-group-btn">
									  <input type="hidden" name="name" value="site_hero" />
									  <input type="hidden" name="pk" value="option" />
									  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-upload"></i>&nbsp;<?php echo lg('Uplaod') ?>&nbsp;&amp;&nbsp;<?php echo lg('Save') ?></button>
									 </span>
								  </div>
								</div>
							  </form>
							</div>
						  </td>
						</tr>
						<tr>
						  <td><?php echo lg('Site Logo')?></td>
						  <td>
							<span class="btn btn-xs" id="site_logo"><?php echo lg('Show')?></span>
							<div id="site_logo_img" style="display:none;">
							  <form action="<?php e($action)?>" method="post"  enctype="multipart/form-data">
								<span class="btn btn-xs pull-right" id="close"><i class="fa fa-times"></i></span>
								<div class="col-sm-12 panel-padding no-padding-b">
								  <img src="../elybin-file/system/<?php e(get_option('site_logo'))?>" alt="" class="img-thumbnail form-group-margin">
								</div>
								<div class="col-sm-12 panel-padding no-padding-t">
								  <div class="input-group">
									 <input type="file" name="file" id="file-style" class="form-control"/>
									 <span class="input-group-btn">
									  <input type="hidden" name="name" value="site_logo" />
									  <input type="hidden" name="pk" value="option" />
									  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-upload"></i>&nbsp;<?php echo lg('Uplaod') ?>&nbsp;&amp;&nbsp;<?php echo lg('Save') ?></button>
									 </span>
								  </div>
								</div>
							  </form>
							</div>
						  </td>
						</tr>
						<tr>
						  <td><?php echo lg('Site Favicon (appear in statusbar)')?></td>
						  <td>
							<span class="btn btn-xs" id="site_favicon"><?php echo lg('Show')?></span>
							<div id="site_favicon_img" style="display:none;">
							  <form action="<?php e($action) ?>" method="post"  enctype="multipart/form-data">
								<span class="btn btn-xs pull-right" id="close"><i class="fa fa-times"></i></span>
								<div class="col-sm-12 panel-padding no-padding-b">
								  <img src="../elybin-file/system/<?php e(get_option('site_favicon'))?>" alt="" class="img-thumbnail form-group-margin" style="width:50px;height:50px">
								</div>
								<div class="col-sm-12 panel-padding no-padding-t">
								  <div class="input-group">
									 <input type="file" name="file" id="file-style2" class="form-control"/>
									 <span class="input-group-btn">
									  <input type="hidden" name="name" value="site_favicon" />
									  <input type="hidden" name="pk" value="option" />
									  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-upload"></i>&nbsp;<?php echo lg('Uplaod') ?>&nbsp;&amp;&nbsp;<?php echo lg('Save') ?></button>
									 </span>
								  </div>
								</div>
							  </form>
							</div>
						  </td>
						</tr>
					  </tbody>
					</table>
			 		<?php
			 		// show if..
			 		}else if(@$_GET['act']=='communication'){
			 		?>
					<table id="user" class="table table-bordered table-striped " style="clear: both">
					  <tbody>
						<tr>
						  <td width="35%"><?php echo lg('Website E-mail')?></td>
						  <td width="65%"><a href="#" id="site_email" data-title="<?php echo lg('Website E-mail')?>"><?php echo $in8?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Phone Number')?></td>
						  <td><a href="#" id="site_phone" data-title="<?php echo lg('Phone Number')?>"><?php echo $in5?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Twitter Account')?></td>
						  <td><a href="#" id="social_twitter" data-title="<?php echo lg('Twitter Account')?>"><?php echo $in22?></a></td>
						</tr>

						<tr>
						  <td><?php echo lg('Facebook Account')?></td>
						  <td><a href="#" id="social_facebook" data-title="<?php echo lg('Facebook Account')?>"><?php echo $in23?></a></td>
						</tr>

						<tr>
						  <td><?php echo lg('Instagram Account')?></td>
						  <td><a href="#" id="social_instagram" data-title="<?php echo lg('Instagram Account')?>"><?php echo $in24?></a></td>
						</tr>

					  </tbody>
					</table>
			 		<?php
			 		// show if..
			 		}
					else if(@$_GET['act']=='system'){
			 		?>
					<table id="user" class="table table-bordered table-striped" style="clear: both">
					  <tbody>
						<tr>
						  <td width="35%"><?php echo lg('User can register')?></td>
						  <td width="65%"><a href="#" id="users_can_register" data-value="<?php echo $in12?>"><?php echo $in12_label?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Default Post Category')?></td>
						  <td><a href="#" id="default_category" data-value="<?php echo $in13_id?>"><?php echo $in13?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Default Comment Status')?></td>
						  <td><a href="#" id="default_comment_status" data-value="<?php echo $in14?>"><?php echo $in14_label?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Homepage')?></td>
						  <td><a href="#" id="default_homepage" data-value="<?php echo $in_defaulthomepage_id?>"><?php echo $in_defaulthomepage?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Post Per Page')?></td>
						  <td><a href="#" id="posts_per_page" data-value="<?php echo $in15?>"><?php echo $in15?>&nbsp;<?php echo lg('Posts')?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Time Zone')?></td>
						  <td><a href="#" id="timezone" data-value="<?php echo $in16?>"><?php echo rename_timezone($in16)?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Language')?></td>
						  <td><a href="#" id="language" data-value="<?php echo $in17?>"><?php echo $in17?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Maintenance Mode')?></td>
						  <td><a href="#" id="maintenance_mode" data-value="<?php echo $in18?>"><?php echo $in18_label?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Developer Mode')?></td>
						  <td><a href="#" id="developer_mode" data-value="<?php echo $in19?>"><?php echo $in19_label?></a></td>
						</tr>
					  </tbody>
					</table>
					<i><?php _e('Beta') ?></i>
					<table id="user" class="table table-bordered table-striped" style="clear: both">
					  <tbody>
						<tr>
						  <td width="35%"><?php echo lg('SMTP Host')?></td>
						  <td width="65%"><a href="#" id="smtp_host" data-value="<?php echo $smtp_host?>"><?php echo $smtp_host?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('SMTP Port (Default: 587)')?></td>
						  <td><a href="#" id="smtp_port" data-value="<?php echo $smtp_port?>"><?php echo $smtp_port?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('SMTP User')?></td>
						  <td><a href="#" id="smtp_user" data-value="<?php echo $smtp_user?>"><?php echo $smtp_user?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('SMTP Pass')?></td>
						  <td><a href="#" id="smtp_pass" data-value="<?php echo $smtp_pass?>"><?php echo $smtp_pass?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('SMTP Status (Active: SMTP/Deactive: mail();)')?></td>
						  <td><a href="#" id="smtp_status" data-value="<?php echo $smtp_status?>"><?php echo $smtp_status_label?></a></td>
						</tr>
						<tr>
						  <td><?php echo lg('Mail Daily Limit')?></td>
						  <td><a href="#" id="mail_daily_limit" data-value="<?php echo $mail_daily_limit?>"><?php echo $mail_daily_limit?></a></td>
						</tr>
					  </tbody>
					</table>
					<?php
					  if($in19=="active"){
					?>
					<h5 class="text-light-gray text-semibold text-s" style="margin:20px 0 10px 0;"><?php echo lg('Developer')?></h5>
					<table id="user" class="table table-bordered table-striped" style="clear: both">
					  <tbody>
						<tr>
						  <td width="35%"><?php echo lg('Short Name')?></td>
						  <td width="65%"><a href="#" id="short_name" data-value="<?php echo $in20?>"><?php echo $in20_label?></a></td>
						</tr>
						<tr>
						  <td width="35%"><?php echo lg('Text Editor')?></td>
						  <td width="65%"><a href="#" id="text_editor" data-value="<?php echo $in21?>"><?php echo $in21_label?></a></td>
						</tr>
					  </tbody>
					</table>
					<?php } ?>

				<?php }
						// show if..
							else if(@$_GET['act']=='permalink'){
					 		?>
							<form action="<?php e($action) ?>" method="post"  enctype="multipart/form-data">
								<table id="user" class="table table-bordered table-striped " style="clear: both">
								  <tbody>
									<tr>
									  <td width="35%"><?php _e('Permalink Style')?></td>
									  <td width="65%">
											<?php
											/** Get permalink template */
											$prm = get_permalink_style();
											if( empty($prm['error']) ):
												// loop
												foreach ($prm['data'] as $pr) {
											?>
											<div class="radio" style="margin-top: 0;">
												<label>
													<input type="radio" name="permalink_style" value="<?php e( base64_encode(json_encode($pr)) ) ?>" <?php e( $pr['active'] ? ' checked':'' ) ?> class="px">
													<span class="lbl"><?php e( $pr['style_name'] ) ?> </span>	<?php _e($pr['htaccess'] ? '<span class="text-danger"><i>('.__('Required .htaccess').')</i></span>':'') ?><br/>
													<div class="panel <?php e( $pr['active'] ? '  panel-dark panel-success':'' ) ?>">
														<div class="panel-body">
														<b><?php _e('Preview') ?></b><br/>
														<?php _e('Post URL') ?> : <b><?php e( $pr['preview_post'] ) ?></b><br/>
														<?php _e('Page URL') ?> : <b><?php e( $pr['preview_page'] ) ?></b><br/>
														<?php _e('Archives URL') ?> : <b><?php e( $pr['preview_archive'] ) ?></b><br/>
														<?php _e('Not Found URL') ?> : <b><?php e( $pr['preview_404'] ) ?></b><br/>
														</div>
														<?php
														// if failed write htaccess
														if(!empty($pr['htaccess_template'])){ ?>
														<div class="panel-body">
															<span class="text-danger"><i><?php _e('Cannot write .htaccess please write manually.') ?></i></span>
															<textarea rows="9" class="form-control"><?php e( $pr['htaccess_template'] ) ?></textarea>
														</div>
														<?php } ?>
													</div>
												</label>
											</div> <!-- / .radio -->
											<?php
												}
											else:
												var_dump($prm);
											endif; ?>

										</td>
									</tr>

								  </tbody>
								</table>
								<input type="hidden" name="name" value="url_rewrite_style" />
								<input type="hidden" name="pk" value="option" />
								<button type="submit" value="Submit" class="btn btn-success pull-right"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save') ?></button>
							</form>
					 		<?php
					 		}
					 ?>
			  </div><!-- / .panel-body -->
			</div><!-- / .panel -->

        <!-- Help modal -->
        <div id="help" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title"><?php echo lg('Help')?></h4>
              </div>
              <div class="modal-body">...</div>
            </div> <!-- / .modal-content -->
          </div> <!-- / .modal-dialog -->
        </div> <!-- / .modal -->
        <!-- / Help modal -->
      </div><!-- / .col -->
    </div><!-- / .row -->
<?php
  		break;
    }
  }
}
?>
