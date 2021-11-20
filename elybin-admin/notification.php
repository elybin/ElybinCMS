<?php
/* Short description for file
 * [ Notification 
 *	
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System 
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
if(!isset($_SESSION['login'])){
	header('location: ../404.html');
}else{
	// get user privilages
	$tbus = new ElybinTable('elybin_users');
	$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
	$level = $tbus->current()->level; // getting level from curent user

	$tbug = new ElybinTable('elybin_usergroup');
	$tbug = $tbug->SelectWhere('usergroup_id', $level,'','')->current();
	// get priv setting
	$ugv = $tbug->setting;
	if($ugv == 1){
?>
							<li class="nav-icon-btn nav-icon-btn-danger dropdown" id="notificon">
								<a href="#notifications" class="dropdown-toggle" data-toggle="dropdown">
									<?php
										$tbn = new ElybinTable('elybin_notification');
										$notif_count = $tbn->GetRow();
										$notif_unread = $tbn->GetRow('status','unread');

										if($notif_unread > 0){
											echo '<span class="label">'.$notif_unread.'</span>';
										}
									?>
									<i class="nav-icon fa fa-bell"></i>
									<span class="small-screen-text"><?php echo lg('Notification') ?></span>
								</a>
								<!-- NOTIFICATIONS -->
								<div class="dropdown-menu widget-notifications no-padding" style="width: 300px; min-height: 70px;">
									<div class="notifications-list" id="main-navbar-notifications">
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
												LIMIT 0,3
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

									</div> <!-- / .notifications-list -->
									<a href="?mod=notification" class="notifications-link"><?php echo lg('More Notification') ?></a>
								</div> <!-- / .dropdown-menu -->

							</li>
<?php } 
}
?>