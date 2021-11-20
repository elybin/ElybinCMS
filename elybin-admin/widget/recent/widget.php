<?php
if(!isset($_SESSION['login'])){
	header('location: ../../../404.html');
}else{



	// get priv setting
	$ugp = _ug()->post;
	$ugcom = _ug()->comment;
	if($ugp == 1 || $ugcom == 1){
?>
				<!-- Recent Widget -->
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-warning" id="dashboard-recent">
							<div class="panel-heading">
								<span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i><?php echo lg('Recent')?></span>
								<ul class="nav nav-tabs nav-tabs-xs">
									<?php
									if($ugcom == 1){
									?>
									<li class="active">
										<a href="#dashboard-recent-comments" data-toggle="tab"><?php echo lg('Comment')?></a>
									</li>
									<?php } ?>
									<?php
									if($ugp == 1){
									?>
									<li<?php if($ugcom == 0){?> class="active"<?php } ?>>
										<a href="#dashboard-recent-threads" data-toggle="tab"><?php echo lg('Post')?></a>
									</li>
									<?php } ?>
								</ul>
							</div> <!-- / .panel-heading -->
							<div class="tab-content">

								<?php
								if($ugcom == 1){
								?>
								<!-- Comments widget -->

								<!-- Without padding -->
								<div class="widget-comments panel-body tab-pane no-padding fade active in" id="dashboard-recent-comments">
									<!-- Panel padding, without vertical padding -->
									<div class="panel-padding no-padding-vr">

										<?php
											//COMMENTS
											$tbc = new ElybinTable('elybin_comments');
											$comment = $tbc->SelectWhere('status', 'active', 'comment_id', 'DESC');
											$no = 1;
											foreach($comment as $cm){

												//ambil avatar
												if($cm->user_id > 0){
													$tblu = new ElybinTable('elybin_users');
													$getava = $tblu->SelectWhere('user_id', $cm->user_id, '', '');
													$avatar = $getava->current()->avatar;
													if($avatar == "default/no-ava.png"){
														$avatar = "default/medium-no-ava.png";
													}else{
														$avatar = "medium-$avatar";
													}

												}else{
													$avatar = "default/medium-no-ava.png";
												}

												//ambil post name
												if($cm->post_id > 0){
													$tblp = new ElybinTable('elybin_posts');
													$getpost = $tblp->SelectWhere('post_id', $cm->post_id, '', '');
													$getpost = $getpost->current();
													$ptitle = $getpost->title; //
													$purl = "post-$getpost->post_id-$getpost->seotitle"; //
													$ppart = "Tulisan"; //
												}
												$date = time_elapsed_string($cm->date);
										?>
										<div class="comment">
											<img src="../elybin-file/avatar/<?php echo $avatar; ?>" alt="" class="comment-avatar">
											<div class="comment-body">
												<div class="comment-by">
													<a href="#" title=""><?php echo $cm->author; ?></a> <?php echo lg('Comment')?> <a href="../<?php echo $purl?>.html" title="" target="_blank">(<?php echo $ppart?>) <?php echo $ptitle?></a>
												</div>
												<div class="comment-text">
													<?php echo substr($cm->content,0,500) ?>
												</div>
												<div class="comment-actions">
													<a href="?mod=comment&amp;act=view&amp;clear=yes&amp;hash=<?php echo epm_encode($cm->comment_id) ?>" data-toggle="modal" data-target="#view"><i class="fa fa-external-link"></i><?php echo lg('Detail')?></a>
													<a href="?mod=comment&amp;act=del&amp;clear=yes&amp;hash=<?php echo epm_encode($cm->comment_id) ?>" data-toggle="modal" data-target="#delete"><i class="fa fa-times"></i><?php echo lg('Delete')?></a>
													<span class="pull-right"><?php echo $date?></span>
												</div>
											</div> <!-- / .comment-body -->
										</div> <!-- / .comment -->
										<?php
											$no++;
										}
										?>
									</div>
								</div> <!-- / .widget-comments -->
								<!-- Threads widget -->
								<?php } ?>
								<?php
								if($ugp == 1){
								?>
								<!-- Without padding -->
								<div class="widget-threads panel-body tab-pane no-padding fade<?php if($ugcom == 0){?> active in<?php } ?>" id="dashboard-recent-threads">
									<div class="panel-padding no-padding-vr">

										<?php
											//POSTS
											$tbp = new ElybinTable('elybin_posts');
											$post = $tbp->SelectWhere('status','publish','post_id', 'DESC');
											$no = 1;
											foreach($post as $ps){

												//ambil avatar
												$tblu = new ElybinTable('elybin_users');
												$getava = $tblu->SelectWhere('user_id', $ps->author, '', '');
												$avatar = $getava->current()->avatar;
												if($avatar == "default/no-ava.png"){
													$avatar = "default/medium-no-ava.png";
												}else{
													$avatar = "medium-$avatar";
												}
												$author = $getava->current()->fullname;

												//ambil category
												$tblcc = new ElybinTable('elybin_category');
												$getcat = $tblcc->SelectWhere('category_id', $ps->category_id)->current();
												$category = $getcat->name;

												$date = time_elapsed_string($ps->date);
										?>
										<div class="thread">
											<img src="../elybin-file/avatar/<?php echo $avatar; ?>" alt="" class="thread-avatar">
											<div class="thread-body">
												<span class="thread-time"><?php echo $date?></span>
												<a class="thread-title"><?php echo $ps->title?></a>
												<div class="thread-info"><?php echo lg('Author')?> <a title=""><?php echo $author?></a> in <a title=""><?php echo $category?></a></div>
											</div> <!-- / .thread-body -->
										</div> <!-- / .thread -->
										<?php
											$no++;
										}
										?>

									</div>
								</div> <!-- / .panel-body -->
								<?php } ?>

				<!-- Delete Modal -->
				<div id="delete" class="modal fade hide-light" tabindex="-1" role="dialog" style="z-index:3000">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<?php echo lg('Loading')?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / Delete Modal -->


				<!-- Large modal -->
				<div id="view" class="modal fade hide-light" tabindex="-1" role="dialog" style="z-index:2000">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<?php echo lg('Loading')?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / Large modal -->

							</div>
						</div> <!-- / .widget-threads -->
						<!-- Javascript -->
						<script>
							init.push(function () {
								$('#dashboard-recent .panel-body > div').slimScroll({ height: 300, alwaysVisible: true, color: '#888',allowPageScroll: true });
							});
						</script>
						<!-- / Javascript -->
					</div><!-- col-12 -->
				</div> <!-- row -->
				<!-- ./Recent Widget -->
<?php
	}
}
?>
