<?php
/* Short description for file
 * [ Module: Widget
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/widget/";
$action		= $modpath."proses.php";


// get usergroup privilage/access from current user to this module
$usergroup = _ug()->media;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
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
					<span class="hidden-xs text-light-gray"><?php echo lg('Setting')?> / </span>
					<span class="hidden-sm hidden-md hidden-lg fa fa-th-large">&nbsp;&nbsp;</span><?php echo lg('Widget')?>
				</h1>
			</div>
		</div> <!-- ./Page Header -->
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form action="<?php echo $action?>" method="post" class="panel">
					
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-th-large hidden-xs">&nbsp;&nbsp;</i><?php echo lg('Widget') ?></span>
						<div class="panel-heading-controls">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div> 
					
					<div class="panel-body">
						<div class="row">
							<!-- Position 1 -->
							<div class="col-md-12 panel-padding no-padding-b no-padding-t" style="background:#fdfdfd; border: 1px dashed #ddd;">
										<h4 class="text-center"><?php echo lg('Position'); ?> 1</h4>
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
													<a href="<?php echo $action; ?>?mod=widget&mp;act=status&amp;id=<?php echo $w->widget_id; ?>" class="btn btn-xs <?php echo $status_btn; ?>"><span class="fa <?php echo $status_icon; ?>"></span></a>
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
												<p><?php echo lg('Status'); ?>: <?php echo $w->status; ?></p>
												<p><?php echo lg('Type'); ?>: <?php echo $w->type; ?></p>
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
								<h4 class="text-center"><br/><br/><br/><br/><br/><br/><br/><br/><br/><?php echo lg('Content'); ?></h4>	
								</div>
							</div>
							
							<!-- Position 2 -->
							<div class="col-xs-12 col-sm-12 col-md-5 pull-right">
								<div  class="row">
									<div class="col-md-12 panel-padding no-padding-b no-padding-t bg-dark" style="background:#fdfdfd; border: 1px dashed #ddd;">
										<h4 class="text-center"><?php echo lg('Position'); ?> 2</h4>	
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
												<p><?php echo lg('Status'); ?>: <?php echo $w->status; ?></p>
												<p><?php echo lg('Type'); ?>: <?php echo $w->type; ?></p>
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
							<?php echo lg('Loading')?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- View Modal -->
				<div id="view" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<?php echo lg('Loading')?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / View Modal -->
				<!-- Install Modal -->
				<div id="install" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<?php echo lg('Loading')?>...
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
								<h4 class="modal-title"><?php echo lg('')?></h4>
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
