<?php
/* Short description for file
 * [ Module: Widget
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
$modpath 	= "app/widget/";
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
	$v 	= new ElybinValidasi();
	$next = @$_GET['next'];
	
	$tbwg = new ElybinTable('elybin_widget');
	$cwidget = $tbwg->GetRow('', '');
	
	switch (@$_GET['act']) {
		default:
		$tb 	= new ElybinTable('elybin_widget');
		$lwidget	= $tb->Select('widget_id','DESC');
		$no = 1;
		$id = @$_GET['id'];
?>	
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-xs text-light-gray"><?php echo $lg_apps?> / </span>
					<span class="hidden-sm hidden-md hidden-lg fa fa-th-large">&nbsp;&nbsp;</span><?php echo $lg_widget?>
				</h1>
			</div>
		</div> <!-- ./Page Header -->
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form action="<?php echo $action?>" method="post" class="panel">
					
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-th-large hidden-xs">&nbsp;&nbsp;</i><?php echo $lg_widget; ?></span>
						<div class="panel-heading-controls">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div> 
					
					<div class="panel-body">
						<?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
						<div class="row">
							<!-- Position 1 -->
							<div class="col-md-12 panel-padding no-padding-b no-padding-t" style="background:#fdfdfd; border: 1px dashed #ddd;">
										<h4 class="text-center"><?php echo $lg_position; ?> 1</h4>
										<?php
										// get data 
										$widget = $tbwg->SelectWhere('position', '1', 'sort', 'ASC');

										foreach($widget as $w){
											if($w->type == "include" OR $w->type == "code"){
												if($w->status == 'active'){
													$status_btn = "btn-success";
													$status_icon = "fa-check-circle";
												}else{
													$status_btn = "btn-default";
													$status_icon = "fa-circle-o";
												}
											
										?>
										<!-- Widget -->
										<div class="panel colourable">
											<div class="panel-heading">
												<span class="panel-title"><?php echo $w->sort; ?>. <?php echo $w->name; ?></span>
												<div class="panel-heading-controls">
													<a href="<?php echo $action; ?>?mod=widget&act=status&id=<?php echo $w->widget_id; ?>" class="btn btn-xs <?php echo $status_btn; ?>"><span class="fa <?php echo $status_icon; ?>"></span></a>
													<?php
														if(0 == 1){
													?>
													<div class="btn-group btn-group-xs">
														<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"><span class="fa fa-cog"></span>&nbsp;<span class="fa fa-caret-down"></span></button>
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a href="#">Options</a></li>
															<li><a href="#">Change Position</a></li>
														</ul> <!-- / .dropdown-menu -->
													</div> <!-- / .btn-group -->
													<?php } ?>
												</div> <!-- / .panel-heading-controls -->
											</div> <!-- / .panel-heading -->
											<div class="panel-body">
												<p><?php echo $lg_status; ?>: <?php echo $w->status; ?></p>
												<p><?php echo $lg_type; ?>: <?php echo $w->type; ?></p>
											</div>
										</div>
										<?php
											}
										}
										?>
							</div>
						</div>
						<div class="clearfix form-group-margin"></div>
						<div class="row">
							<!-- Content -->
							<div class="hidden-xs hidden-sm col-md-7 bg-dark">
								
								<div  class="row"  style="height: 400px; background:#fff; border: 1px dashed #ddd; margin-right: 10px;">
								<h4 class="text-center"><br/><br/><br/><br/><br/><br/><br/><br/><br/><?php echo $lg_content; ?></h4>	
								</div>
							</div>
							
							<!-- Position 2 -->
							<div class="col-xs-12 col-sm-12 col-md-5 pull-right">
								<div  class="row">
									<div class="col-md-12 panel-padding no-padding-b no-padding-t bg-dark" style="background:#fdfdfd; border: 1px dashed #ddd;">
										<h4 class="text-center"><?php echo $lg_position; ?> 2</h4>	
										<?php
										// get data 
										$widget = $tbwg->SelectWhere('position', '2', 'sort', 'ASC');

										foreach($widget as $w){
											if($w->type == "include" OR $w->type == "code"){
												if($w->status == 'active'){
													$status_btn = "btn-success";
													$status_icon = "fa-check-circle";
												}else{
													$status_btn = "btn-default";
													$status_icon = "fa-circle-o";
												}
												
												// deny up
												if($w->sort <= 1){
													$deny_up = " disabled";
													$up_link = "";
												}else{
													$deny_up = "";
													$up_link = "$action?mod=widget&act=up&id=$w->widget_id";
												}
												
												// deny down
												// count row
												$cocowidget = $tbwg->SelectWhere('position', 2,'','');
												$countwidget = 0;
												foreach($cocowidget as $ccw){
													if($ccw->type == 'include' OR $ccw->type == 'code'){
														@$countwidget++;
													}
												}
												if($w->sort >= $countwidget){
													$deny_down = " disabled";
													$down_link = "";
												}else{
													$deny_down = "";
													$down_link = "$action?mod=widget&act=down&id=$w->widget_id";
												}
										?>
										<!-- Widget -->
										<div class="panel colourable">
											<div class="panel-heading">
												<span class="panel-title"><?php echo $w->sort; ?>. <?php echo $w->name; ?></span>
												<div class="panel-heading-controls">
													<a href="<?php echo $up_link; ?>" class="btn btn-xs btn-primary btn-outline<?php echo $deny_up; ?>"><span class="fa fa-chevron-up"></span>&nbsp;&nbsp;Up</a>
													<a href="<?php echo $down_link; ?>" class="btn btn-xs btn-primary btn-outline<?php echo $deny_down; ?>"><span class="fa fa-chevron-down"></span>&nbsp;&nbsp;Down</a>
													<a href="<?php echo $action; ?>?mod=widget&act=status&id=<?php echo $w->widget_id; ?>" class="btn btn-xs <?php echo $status_btn; ?>"><span class="fa <?php echo $status_icon; ?>"></span></a>
													<?php
														if(0 == 1){
													?>
													<div class="btn-group btn-group-xs">
														<button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown"><span class="fa fa-cog"></span>&nbsp;<span class="fa fa-caret-down"></span></button>
				
														<ul class="dropdown-menu dropdown-menu-right">
															<li><a href="#" class="disabled">Options</a></li>
															<li><a href="#">Change Position</a></li>
														</ul> <!-- / .dropdown-menu -->
														
													</div> <!-- / .btn-group -->
													<?php } ?>
												</div> <!-- / .panel-heading-controls -->
											</div> <!-- / .panel-heading -->
											<div class="panel-body">
												<p><?php echo $lg_status; ?>: <?php echo $w->status; ?></p>
												<p><?php echo $lg_type; ?>: <?php echo $w->type; ?></p>
											</div>
										</div>
										<?php
											}
										}
										?>

									</div>
								</div>
							</div>
						</div>
					</div><!-- / .panel-body -->
				</form>
				<!-- Delete Modal -->
				<div id="delete" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<?php echo $lg_loading?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- View Modal -->
				<div id="view" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<?php echo $lg_loading?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / View Modal -->
				<!-- Install Modal -->
				<div id="install" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<?php echo $lg_loading?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / Install Modal -->
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
			</div><!-- / .col -->
		</div><!-- / .row -->
<?php

		break;
		}
	}
}
?>
