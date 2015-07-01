<?php
/* Short description for file
 * [ Module: Notification
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/menumanager/";
$action		= $modpath."proses.php";

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->setting;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	// start here
	switch (@$_GET['act']) {
		default:
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-bell"></i>&nbsp;&nbsp;<?php echo lg('Notification')?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo lg('Setting')?> / </span><?php echo lg('Notification')?></span>
				</h1>
			</div>
		</div> <!-- ./Page Header -->
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel">
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-bell hidden-xs">&nbsp;&nbsp;</i><?php echo lg('Notification')?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help') ?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div> 
					<!-- ./Panel Heading --> 
		  
					<div class="panel-body">
					  <div class="col-sm-8">
						<div class="panel widget-notifications">
							<div class="panel-heading">
									<?php
										$tbn = new ElybinTable('elybin_notification');
										$notif_count = $tbn->GetRow();
										$notif_unread = $tbn->GetRow('status','unread');

										if($notif_unread > 0){
											echo '<span class="label">'.$notif_unread.'</span>';
										}
									?>
								<span class="panel-title"><i class="panel-title-icon"></i><?php if($notif_count > 20){ echo "20"; }else{ echo $notif_count; } ?> <?php echo lg('of'); ?> <?php echo $notif_count?> <?php echo lg('Latest notification')?></span>
							</div> <!-- / .panel-heading -->
							<div class="panel-body padding-sm">
								<div class="notifications-list">
										<?php
										if($notif_count < 1){
										?>
										<div class="form-group-margin" style="margin-top: 30px;"></div>
										<div class="text-center text-muted panel-padding">
											<i class="fa fa-5x fa-bell-o"></i>
											<h3><?php echo lg('Yeah!') ?></h3>
											<p><?php echo lg('No Notification'); ?></p>
										</div>
										<?php 
										}else{ 
											// get data
											$tbns = new ElybinTable('elybin_notification');
											$notifs	= $tbns->SelectFullCustom("
												SELECT
												*
												FROM
												`elybin_notification` as `n`
												ORDER BY `notif_id` DESC
												LIMIT 0,30
											");
											foreach($notifs as $cn){
												//var_dump($cn);
												//check how much notif with same topic
												/*$cnotif = $tbns->GetRowAnd('notif_code', $lns->notif_code, 'status', 'unread');
												*/
												// give diferent color
												if($cn->status=='read'){
													$status = ' style="background:#efefef;"';
												}else{
													$status = "";
												}

										?>
											<div class="notification" id="notif"<?php echo $status?>>
												<div class="notification-title text-danger"><?php echo $cn->title?></div>
												<div class="notification-description"><?php echo substr($cn->value,0,1000) ?></div>
												<div class="notification-ago"><?php echo time_elapsed_string($cn->date)?> - <?php echo ucfirst($cn->status) ?> - <a href="?mod=<?php echo $cn->module ?>" style="line-height:0px;"><?php echo lg('Detail') ?></a></div>
												<div class="notification-icon fa <?php echo $cn->icon?> bg-<?php echo $cn->type?>"></div>
											</div> <!-- / .notification -->
										<?php
											}
										}
										?>
								</div>
							</div> <!-- / .panel-body -->
						</div> <!-- / .panel -->
					</div><!-- / . col-sm-8 -->

					<div class="col-sm-4">
						<div class="note note-info">
							<h1 class="fa fa-bell-o text-slg text-light-gray"></h1>
							<p><?php echo lg('Notification')?>.</p>
						</div>
					</div><!-- / . col-sm-4 -->
			  	</div> <!-- / .panel-body -->
			</div> <!-- / .panel -->
		</div> <!-- / .col -->
	</div> <!-- /.row -->

				<!-- Delete Modal -->
				<div id="delete" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<?php echo lg('Loading')?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal --> <!-- / Delete modal -->
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
<?php
			break;
		}
	}
}
?>
