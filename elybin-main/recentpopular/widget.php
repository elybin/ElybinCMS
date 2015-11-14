<?php
/**
 * This is the main file of Recent & Popular Widget.
 * And some part of this plugin was changed due new function inside 1.1.5
 *
 * @package Elybin
 * @subpackage RecentPopular
 * @since RecentPopular 1.0
 */
// include
include('function.php');

?>
				<!-- .row -->
				<div class="row">
					<div class="col-sm-12">
						<?php
						//check first
						if(count(get_popular_post()) == 0){
						?>
							<h3 class="text-center text-muted"><?php _e('No Post') ?></h3>
						<?php
						}else{
						?>
						<!-- Tabs -->
						<ul class="nav nav-tabs">
							<li class="active">
								<a href="#tabs-popular" data-toggle="tab"><?php strtoupper(_e('Popular')) ?></a>
							</li>
							<li class="">
								<a href="#tabs-recent" data-toggle="tab"><?php strtoupper(_e('Recent')) ?></a>
							</li>
						</ul>

						<div class="tab-content tab-content-bordered">
							<div class="tab-pane fade active in" id="tabs-popular">
								<?php
								foreach(get_popular_post() as $p){
								?>
								<!-- news row -->
								<div class="recent-tab row">
									<div class="col-xs-3 col-sm-4 col-md-3" style="max-width: 75px; min-width: 65px;">
										<?php
										// if image not empty
										if(!$p->image): ?>
											<div class="img-circle" style="border: 1px solid rgba(0,0,0,0.2); width: 60px; height: 60px; padding: 15px">
												<i class="fa fa-2x fa-pencil text-muted"></i>
											</div>
										<?php else: ?>
											<img src="<?php e($p->image) ?>" class="img-circle">
										<?php endif; ?>
									</div>
									<div class="col-xs-9 col-sm-8 col-md-9">
										<h4 style="margin-top: 0px; margin-bottom: 5px"><a href="<?php e($p->url) ?>"><?php e($p->title) ?></a></h4>
										<p class="text-sm text-light-gray">
											<?php printf(_('Posted by: %s'), '<i>'.$p->author.'</i>') ?>
											<?php printf(_('Read %s times.'),  '<i>'.$p->hits.'</i>') ?>
										</p>
									</div>
								</div>
								<?php } ?>
							</div> <!-- / .tab-pane -->

							<div class="tab-pane fade" id="tabs-recent">
								<?php
								foreach(get_recent_post2() as $p){
								?>
								<!-- news row -->
								<div class="recent-tab row">
									<div class="col-xs-3 col-sm-4 col-md-3" style="max-width: 75px; min-width: 65px;">
										<?php
										// if image not empty
										if(!$p->image): ?>
											<div class="img-circle" style="border: 1px solid rgba(0,0,0,0.2); width: 60px; height: 60px; padding: 15px">
												<i class="fa fa-2x fa-pencil text-muted"></i>
											</div>
										<?php else: ?>
											<img src="<?php e($p->image) ?>" class="img-circle">
										<?php endif; ?>
									</div>
									<div class="col-xs-9 col-sm-8 col-md-9">
										<h4 style="margin-top: 0px; margin-bottom: 5px"><a href="<?php e($p->url) ?>"><?php e($p->title) ?></a></h4>
										<p class="text-sm text-light-gray">
											<?php printf(_('Posted by: %s'), '<i>'.$p->author.'</i>') ?>
											<?php e('<i>'.time_elapsed_string($p->date).'</i>') ?>
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
