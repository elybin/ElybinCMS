<?php
if(!isset($_SESSION['login'])){
	header('location: ../../../404.html');
}else{
	$ug =_ug();
	if($ug->setting == 1){
?>
				<!-- Notification Widget -->
				<div class="row">
					<div class="col-sm-12">
						<div class="panel widget-notifications" id="dashboard-notification">
							<div class="panel-heading">
								<span class="panel-title"><i class="panel-title-icon fa fa-bell"></i><?php echo lg('Notification') ?></span>
							</div> <!-- / .panel-heading -->
							<div class="panel-body padding-sm">
								<div class="notifications-list">
										<?php 
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
													$status = ' style="background:#fafafa;"';
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