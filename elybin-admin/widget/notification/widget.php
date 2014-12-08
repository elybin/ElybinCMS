<?php
if(!isset($_SESSION['login'])){
	header('location: ../../../404.html');
}else{
	// get user privilages
	$tbus = new ElybinTable('elybin_users');
	$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
	$level = $tbus->current()->level; // getting level from curent user

	$tbug = new ElybinTable('elybin_usergroup');
	$tbug = $tbug->SelectWhere('usergroup_id', $level,'','')->current();
	// get priv setting
	$ugs = $tbug->setting;
	if($ugs == 1){
?>
				<!-- Notification Widget -->
				<div class="row">
					<div class="col-sm-12">
						<div class="panel widget-notifications" id="dashboard-notification">
							<div class="panel-heading">
								<span class="panel-title"><i class="panel-title-icon fa fa-fire"></i><?php echo $lg_notification?></span>
							</div> <!-- / .panel-heading -->
							<div class="panel-body padding-sm">
								<div class="notifications-list">
									<?php 
										$tbn = new ElybinTable('elybin_notification');
										$notif	= $tbn->Select('notif_id','DESC');
										$no = 1;
										foreach($notif as $lns){
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
											if($lns->status=='read'){
												$status = ' style="background:#fafafa;"';
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
											$content = eval('return '.$value[0]->single.';')." <em>".$value[0]->content."</em>";
									?>
									<div class="notification">
										<div class="notification-title text-danger"><?php echo strtoupper($lns->title)?></div>
										<div class="notification-description"><?php echo html_entity_decode($content); ?></div>
										<div class="notification-ago"><?php echo time_elapsed_string($lns->date." ".$lns->time)?></div>
										<div class="notification-icon fa <?php echo $lns->icon?> bg-<?php echo $lns->type?>"></div>
									</div> <!-- / .notification -->
									<?php
										$no++;
										}
									?>
								</div>
							</div> <!-- / .panel-body -->
						</div> <!-- / .panel -->
						<!-- Javascript -->
						<script>
							init.push(function () {
								$('#dashboard-notification .panel-body > div').slimScroll({ height: 300, alwaysVisible: false, color: '#888',allowPageScroll: true });
							})
						</script>
						<!-- / Javascript -->
					</div><!-- col-12 -->
				</div> <!-- row -->
				<!-- ./Notification Widget -->
<?php 
	} 
}
?>