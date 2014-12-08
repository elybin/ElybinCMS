<?php
/* Short description for file
 * [ Notification 
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
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
										$notif_count = new ElybinTable('elybin_notification');
										$notif_total = 0;  
										$notif_total = $notif_count->GetRow('status', 'unread'); 
										if($notif_total==0){
											$notif_total = "";
										}
									?>
									<span class="label"><?php echo $notif_total?></span>
									<i class="nav-icon fa fa-bell"></i>
									<span class="small-screen-text"><?php echo $lg_notification?></span>
								</a>
								<!-- NOTIFICATIONS -->
								<div class="dropdown-menu widget-notifications no-padding" style="width: 300px; min-height: 70px;">
									<div class="notifications-list" id="main-navbar-notifications">
										<?php
										if($notif_total == ""){
										?>
										<div class="form-group-margin" style="margin-top: 30px;"></div>
										<div class="text-center text-muted panel-padding">
											<i class="fa fa-5x fa-bell-o"></i>
											<h3>Yay!</h3>
											<p><?php echo $lg_nonotification; ?></p>
										</div>
										<?php 
										}else{ 
											// get data
											$tbns = new ElybinTable('elybin_notification');
											$notifs	= $tbns->SelectCustom("SELECT * FROM","WHERE `status` = 'unread' GROUP BY `notif_code`");
										
											foreach($notifs as $lns){
												// include custom lang if exist
												//get current language
												$default_language = "en";
												$tbo = new ElybinTable('elybin_options');
												$clg = $tbo->SelectWhere('name','language','','')->current()->value;
												$cmod = $lns->module;
												
												$lgdir = "./app/$cmod/lang/$clg/$clg.php";										
												if(file_exists($lgdir)){
													@include($lgdir);
												}else{
													@include_once("./app/$cmod/lang/$default_language/$default_language.php");
												}
											
												//check how much notif with same topic
												$cnotif = $tbns->GetRowAnd('notif_code', $lns->notif_code, 'status', 'unread');
												
												// give diferent color
												if($lns->status=='read'){
													$status = ' style="background:#efefef;"';
												}else{
													$status = "";
												}
												
												// check string or variable
												if(substr($lns->title,0,1)=='$'){
													$lns->title = eval('return '.$lns->title.';');
												}
												
												// decode value
												if(json_decode($lns->value)){
													$value = json_decode($lns->value);
												}else{
													exit('failed to decode json');
												}
												
												//if more than one, group it
												if($cnotif > 1){
													$content = "$cnotif ".eval('return '.$value[0]->more.';');
												}else{
													
													$content = eval('return '.$value[0]->single.';')." <em>".$value[0]->content."</em>";
												}
												
										?>
											<div class="notification" id="notif"<?php echo $status?>>
												<div class="notification-title text-danger"><?php echo strtoupper($lns->title)?></div>
												<div class="notification-description"><?php echo html_entity_decode($content); ?></div>
												<div class="notification-ago"><?php echo time_elapsed_string($lns->date." ".$lns->time)?></div>
												<div class="notification-icon fa <?php echo $lns->icon?> bg-<?php echo $lns->type?>"></div>
											</div> <!-- / .notification -->
										<?php
											}
										}
										?>

									</div> <!-- / .notifications-list -->
									<a href="?mod=notification" class="notifications-link"><?php echo strtoupper($lg_morenotif)?></a>
								</div> <!-- / .dropdown-menu -->

							</li>
<?php } 
}
?>