<?php
if(empty($_SESSION['together'])){
	header('location: ../../404.html');
	exit;
}

// include widget language
include("lang.php");

// count data from table 
$tbp = new ElybinTable('elybin_posts');
$tbu = new ElybinTable('elybin_users');
$cpostrec = $tbp->GetRow('','');

?>
				<!-- .row -->
				<div class="row">
					<div class="col-sm-12">
						<?php
						//check first 
						if($cpostrec == 0){
							echo '<h3 class="text-center text-muted">'.$lg_nopost.'</h3>';
						}else{
						?>
						<!-- Tabs -->
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tabs-popular" data-toggle="tab"><?php echo strtoupper($lg_popular); ?></a>
							</li>
							<li class="">
								<a href="#tabs-recent" data-toggle="tab"><?php echo strtoupper($lg_recent); ?></a>
							</li>
						</ul>

						<div class="tab-content tab-content-bordered">
							<div class="tab-pane fade active in" id="tabs-popular">
								<?php
								// get post
								$post = $tbp->SelectWhereLimit('status','publish','hits','DESC',"0,5");
								
								foreach($post as $p){
									// user 
									$user = $tbu->SelectWhere('user_id',$p->author,'','')->current()->fullname;
								?>
								<!-- news row -->
								<div class="recent-tab row">
									<div class="col-xs-3 col-sm-4 col-md-3" style="max-width: 75px; min-width: 65px;">
										<?php
										// if image not empty
										if($p->image != ''){
										?>
										<img src="elybin-file/post/medium-<?php echo $p->image; ?>" class="img-circle">
										<?php }else{ ?>
										<div class="img-circle" style="border: 1px solid rgba(0,0,0,0.2); width: 60px; height: 60px; padding: 15px">
											<i class="fa fa-2x fa-pencil text-muted"></i>
										</div>
										<?php } ?>
									</div>
									<div class="col-xs-9 col-sm-8 col-md-9">
										<h4 style="margin-top: 0px; margin-bottom: 5px"><a href="post-<?php echo $p->post_id; ?>-<?php echo $p->seotitle; ?>.html"><?php echo $p->title; ?></a></h4>
										<p class="text-sm text-light-gray">
											<?php echo $lg_postedby; ?> <i><?php echo $user; ?></i>
											<?php echo $lg_read; ?> <i><?php echo $p->hits; ?> <?php echo $lg_times; ?></i>
										</p>
									</div>
								</div>
								<?php } ?>
							</div> <!-- / .tab-pane -->
							<div class="tab-pane fade" id="tabs-recent">
								<?php
								// get post
								$post = $tbp->SelectWhereLimit('status','publish','post_id','DESC',"0,5");
								
								foreach($post as $p){
									// user 
									$user = $tbu->SelectWhere('user_id',$p->author,'','')->current()->fullname;
								?>
								<!-- news row -->
								<div class="recent-tab row">
									<div class="col-xs-3 col-sm-4 col-md-3" style="max-width: 75px;">
										<?php
										// if image not empty
										if($p->image != ''){
										?>
										<img src="elybin-file/post/medium-<?php echo $p->image; ?>" class="img-circle">
										<?php }else{ ?>
										<div class="img-circle" style="border: 1px solid rgba(0,0,0,0.2); width: 60px; height: 60px; padding: 15px">
											<i class="fa fa-2x fa-pencil text-muted"></i>
										</div>
										<?php } ?>
									</div>
									<div class="col-xs-9 col-sm-8 col-md-9">
										<h4 style="margin-top: 0px; margin-bottom: 5px"><a href="post-<?php echo $p->post_id; ?>-<?php echo $p->seotitle; ?>.html"><?php echo $p->title; ?></a></h4>
										<p class="text-sm text-light-gray">
											<?php echo $lg_postedby; ?> <i><?php echo $user; ?></i><br/>
											<i><?php echo time_elapsed_string($p->date); ?></i>
										</p>
									</div>
								</div>
								<?php } ?>
								
							
							</div> <!-- / .tab-pane -->
						</div> <!-- / .tab-content -->
						<?php } ?>
					</div>
				</div>
				<!-- .row -->