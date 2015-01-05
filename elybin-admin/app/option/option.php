<?php
/* Short description for file
 * [ Module: Setting
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
if(!isset($_SESSION['login'])){
	echo '403';
	header('location:../403.php');
}else{
$modpath 	= "app/option/";
$action		= $modpath."proses.php";

// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
$level = $tbus->current()->level; // getting level from curent user

$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
$usergroup = $tbug->current()->setting;

// give error if no have privilage
if($usergroup == 0){
  er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
}else{
  // start here
  switch (@$_GET['act']) {

    case 'location':
    $tb = new ElybinTable('elybin_options');
    $in9 = $tb->SelectWhere('name','site_coordinate','','');
    $in9 = $in9->current()->value;
    if($in9 == ""){
      $in9 = "-7.396119962181347, 109.69514252969367";
    }
    $in9 = html_entity_decode($in9);
    $in9_ex = explode(",", $in9);
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-map-marker"></i>&nbsp;&nbsp;<?php echo $lg_picklocation?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo $lg_setting?> / </span><?php echo $lg_picklocation?></span>
				</h1>
			</div>
		</div> <!-- ./Page Header -->
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel">
		  			<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-map-marker hidden-xs">&nbsp;&nbsp;</i><?php echo $lg_pickyourlocation?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
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
										<button class="btn btn-success" id="btn-save"><i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo $lg_savelocation?></button>
									</span>
								</div>   
								<p id="coordinate" class="help-block"><i><?php echo $lg_coordinate?>:&nbsp;</i><span><?php echo $in9?></span></p>
							</div>
							<!-- Margin -->
							<div class="visible-xs clearfix form-group-margin"></div>
							<div class="col-xs-12 col-sm-12 col-md-2 pull-right">
								<button class="col-xs-12 col-sm-12 btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></button>
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
								<h4 class="modal-title"><?php echo $lg_helptitle?></h4>
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
  	$in1 = $tb->SelectWhere('name','site_url','','');
  	$in1 = $in1->current()->value;

  	$in2 = $tb->SelectWhere('name','site_name','','');
  	$in2 = $in2->current()->value;

  	$in3 = $tb->SelectWhere('name','site_description','','');
  	$in3 = $in3->current()->value;

  	$in4 = $tb->SelectWhere('name','site_keyword','','');
  	$in4 = $in4->current()->value;

  	$in5 = $tb->SelectWhere('name','site_phone','','');
  	$in5 = $in5->current()->value;
  	$in5 = html_entity_decode($in5);

  	$in6 = $tb->SelectWhere('name','site_office_address','','');
  	$in6 = $in6->current()->value;

  	$in7 = $tb->SelectWhere('name','site_owner','','');
  	$in7 = $in7->current()->value;

  	$in8 = $tb->SelectWhere('name','site_email','','');
  	$in8 = $in8->current()->value;
	
  	$op_site_hero_title = $tb->SelectWhere('name','site_hero_title','','')->current()->value;
  	$op_site_hero_subtitle = $tb->SelectWhere('name','site_hero_subtitle','','')->current()->value;
  	$op_site_hero = $tb->SelectWhere('name','site_hero','','')->current()->value;

  	$in9 = $tb->SelectWhere('name','site_coordinate','','');
  	$in9 = $in9->current()->value;
  	$in9 = html_entity_decode($in9);

  	$in10 = $tb->SelectWhere('name','site_logo','','');
  	$in10 = $in10->current()->value;

  	$in11 = $tb->SelectWhere('name','site_favicon','','');
  	$in11 = $in11->current()->value;

  	//KE2
  	$in12 = $tb->SelectWhere('name','users_can_register','','');
    $in12 = $in12->current()->value;
    if($in12=="allow"){
      $in12_label = $lg_allow;
    }else{
      $in12_label = $lg_deny;
    }
    $in12_label = ucwords($in12_label);
  	
    $tbl = new ElybinTable('elybin_category');
  	$in13 = $tb->SelectWhere('name','default_category','','');
    $in13_id = $in13->current()->value;
    $in13 = $tbl->SelectWhere('category_id',$in13->current()->value,'','')->current()->name;

  	$in14 = $tb->SelectWhere('name','default_comment_status','','');
  	$in14 = $in14->current()->value;
    if($in14=="allow"){
      $in14_label = $lg_allow;
    }
	elseif($in14=="confrim"){
	  $in14_label = $lg_confrim;
	}else{
      $in14_label = $lg_deny;
    }
    $in14_label = ucwords($in14_label);

  	$in15 = $tb->SelectWhere('name','posts_per_page','','');
  	$in15 = $in15->current()->value;

  	$in16 = $tb->SelectWhere('name','timezone','','');
  	$in16 = $in16->current()->value;

    $in17 = $tb->SelectWhere('name','language','','');
    $in17 = $in17->current()->value;

  	$in18 = $tb->SelectWhere('name','maintenance_mode','','');
  	$in18 = $in18->current()->value;
    if($in18=="active"){
      $in18_label = $lg_active;
    }else{
      $in18_label = $lg_inactive;
    }
    $in18_label = ucwords($in18_label);

  	$in19 = $tb->SelectWhere('name','developer_mode','','');
  	$in19 = $in19->current()->value;
    if($in19=="active"){
      $in19_label = $lg_active;
    }else{
      $in19_label = $lg_inactive;
    }
    $in19_label = ucwords($in19_label);

    $in20 = $tb->SelectWhere('name','short_name','','');
    $in20 = $in20->current()->value;
    if($in20=="first"){
      $in20_label = $lg_first;
    }else{
      $in20_label = $lg_last;
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
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-gear"></i>&nbsp;&nbsp;<?php echo $lg_setting?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo $lg_setting?> / </span><?php echo $lg_general?></span>
				</h1>
			</div>
		</div> <!-- ./Page Header -->

		<!-- Content here -->
		<style><?php include("assets/stylesheets/table.css"); ?></style>
		<style><?php include("assets/stylesheets/select2.css"); ?></style>
		<div class="row">
			<div class="col-sm-12">
				<div class="panel">
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-gear hidden-xs">&nbsp;&nbsp;</i><?php echo $lg_generalsetting?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div> 
					<!-- ./Panel Heading -->
					
			  <div class="panel-body">
					<h5 class="text-light-gray text-semibold text-s" style="margin:20px 0 10px 0;"><?php echo strtoupper($lg_siteinformation)?></h5>
					<table id="user" class="table table-bordered table-striped " style="clear: both">
					  <tbody>
						<tr>
						  <td width="35%"><?php echo $lg_siteurl?></td>
						  <td width="65%"><a href="#" id="site_url" data-title="<?php echo $lg_siteurl?>"><?php echo $in1?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_officename?></td>
						  <td><a href="#" id="site_name" data-title="<?php echo $lg_officename?>"><?php echo $in2?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_description?></td>
						  <td><a href="#" id="site_description" data-title="<?php echo $lg_description?>"><?php echo $in3?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_keyword?></td>
						  <td><a href="#" id="site_keyword" data-title="<?php echo $lg_keyword?>..."><?php echo $in4?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_phonenumber?></td>
						  <td><a href="#" id="site_phone" data-title="<?php echo $lg_phonenumber?>"><?php echo $in5?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_address?></td>
						  <td><a href="#" id="site_office_address" data-placeholder="<?php echo $lg_address?>..." data-title="<?php echo $lg_address?>"><?php echo $in6?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_owner?></td>
						  <td><a href="#" id="site_owner" data-title="<?php echo $lg_owner?>"><?php echo $in7?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_siteemail?></td>
						  <td><a href="#" id="site_email" data-title="<?php echo $lg_siteemail?>"><?php echo $in8?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_coordinate?></td>
						  <td>
							<a href="?mod=option&amp;act=location" id="site_coordinate" data-title="<?php echo $lg_coordinate?>"><?php echo $in9?></a>
						  </td>
						</tr>
						<tr>
						  <td><?php echo $lg_herotitle?></td>
						  <td><a href="#" id="site_hero_title" data-title="<?php echo $lg_herotitle?>"><?php echo $op_site_hero_title?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_herosubtitle?></td>
						  <td><a href="#" id="site_hero_subtitle" data-title="<?php echo $lg_herosubtitle?>"><?php echo $op_site_hero_subtitle?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_heroimage?></td>
						  <td>
							<span class="btn btn-xs" id="site_hero"><?php echo $lg_show?></span>
							<div id="site_hero_img" style="display:none;">
							  <form action="<?php echo $action?>" method="post"  enctype="multipart/form-data">
								<span class="btn btn-xs pull-right" id="close"><i class="fa fa-times"></i></span>
								<div class="col-sm-12 panel-padding no-padding-b">
								  <img src="../elybin-file/system/medium-<?php echo $op_site_hero?>" alt="" class="img-thumbnail form-group-margin" style="width: 100%">
								</div>
								<div class="col-sm-12 panel-padding no-padding-t">
								  <div class="input-group">
									 <input type="file" name="image" id="file-style3" class="form-control"/>
									 <span class="input-group-btn">
									  <input type="hidden" name="name" value="site_hero" />
									  <input type="hidden" name="pk" value="option" />
									  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-upload"></i>&nbsp;<?php echo $lg_upload?>&nbsp;&amp;&nbsp;<?php echo $lg_save?></button>
									 </span>
								  </div> 
								</div>
							  </form>
							</div>
						  </td>
						</tr>
						<tr>
						  <td><?php echo $lg_sitelogo?></td>
						  <td>
							<span class="btn btn-xs" id="site_logo"><?php echo $lg_show?></span>
							<div id="site_logo_img" style="display:none;">
							  <form action="<?php echo $action?>" method="post"  enctype="multipart/form-data">
								<span class="btn btn-xs pull-right" id="close"><i class="fa fa-times"></i></span>
								<div class="col-sm-12 panel-padding no-padding-b">
								  <img src="../elybin-file/system/<?php echo $in10?>" alt="" class="img-thumbnail form-group-margin">
								</div>
								<div class="col-sm-12 panel-padding no-padding-t">
								  <div class="input-group">
									 <input type="file" name="image" id="file-style" class="form-control"/>
									 <span class="input-group-btn">
									  <input type="hidden" name="name" value="site_logo" />
									  <input type="hidden" name="pk" value="option" />
									  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-upload"></i>&nbsp;<?php echo $lg_upload?>&nbsp;&amp;&nbsp;<?php echo $lg_save?></button>
									 </span>
								  </div> 
								</div>
							  </form>
							</div>
						  </td>
						</tr>
						<tr>
						  <td><?php echo $lg_favicon?></td>
						  <td>
							<span class="btn btn-xs" id="site_favicon"><?php echo $lg_show?></span>
							<div id="site_favicon_img" style="display:none;">
							  <form action="<?php echo $action?>" method="post"  enctype="multipart/form-data">
								<span class="btn btn-xs pull-right" id="close"><i class="fa fa-times"></i></span>
								<div class="col-sm-12 panel-padding no-padding-b">
								  <img src="../elybin-file/system/<?php echo $in11?>" alt="" class="img-thumbnail form-group-margin" style="width:50px;height:50px">
								</div>
								<div class="col-sm-12 panel-padding no-padding-t">
								  <div class="input-group">
									 <input type="file" name="image" id="file-style2" class="form-control"/>
									 <span class="input-group-btn">
									  <input type="hidden" name="name" value="site_favicon" />
									  <input type="hidden" name="pk" value="option" />
									  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-upload"></i>&nbsp;<?php echo $lg_upload?>&nbsp;&amp;&nbsp;<?php echo $lg_save?></button>
									 </span>
								  </div> 
								</div>
							  </form>
							</div>
						  </td>
						</tr>
					  </tbody>
					</table>

					<h5 class="text-light-gray text-semibold text-s" style="margin:20px 0 10px 0;"><?php echo strtoupper($lg_system)?></h5>
					<table id="user" class="table table-bordered table-striped" style="clear: both">
					  <tbody>
						<tr>
						  <td width="35%"><?php echo $lg_usercanregister?></td>
						  <td width="65%"><a href="#" id="users_can_register" data-value="<?php echo $in12?>"><?php echo $in12_label?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_defaultcategory?></td>
						  <td><a href="#" id="default_category" data-value="<?php echo $in13_id?>"><?php echo $in13?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_defaultcommentstatus?></td>
						  <td><a href="#" id="default_comment_status" data-value="<?php echo $in14?>"><?php echo $in14_label?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_postperpage?></td>
						  <td><a href="#" id="posts_per_page" data-value="<?php echo $in15?>"><?php echo $in15?>&nbsp;<?php echo $lg_post?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_timezone?></td>
						  <td><a href="#" id="timezone" data-value="<?php echo $in16?>"><?php echo rename_timezone($in16)?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_language?></td>
						  <td><a href="#" id="language" data-value="<?php echo $in17?>"><?php echo $in17?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_maintenancemode?></td>
						  <td><a href="#" id="maintenance_mode" data-value="<?php echo $in18?>"><?php echo $in18_label?></a></td>
						</tr>
						<tr>
						  <td><?php echo $lg_developermode?></td>
						  <td><a href="#" id="developer_mode" data-value="<?php echo $in19?>"><?php echo $in19_label?></a></td>
						</tr>
					  </tbody>
					</table>

					<?php
					  if($in19=="active"){
					?>
					<h5 class="text-light-gray text-semibold text-s" style="margin:20px 0 10px 0;"><?php echo strtoupper($lg_developer)?></h5>
					<table id="user" class="table table-bordered table-striped" style="clear: both">
					  <tbody>
						<tr>
						  <td width="35%"><?php echo $lg_shortname?></td>
						  <td width="65%"><a href="#" id="short_name" data-value="<?php echo $in20?>"><?php echo $in20_label?></a></td>
						</tr>
						<tr>
						  <td width="35%"><?php echo $lg_texteditor?></td>
						  <td width="65%"><a href="#" id="text_editor" data-value="<?php echo $in21?>"><?php echo $in21_label?></a></td>
						</tr>
					  </tbody>
					</table>
					<?php } ?>
			  </div><!-- / .panel-body -->
			</div><!-- / .panel -->
			
        <!-- Help modal -->
        <div id="help" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
                <h4 class="modal-title"><?php echo $lg_helptitle?></h4>
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
