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
	$ugp = $tbug->post;
	$ugcom = $tbug->comment;
	if($ugp == 1 OR $ugcom == 1){
?>
				<!-- Recent Widget -->
				<div class="row">
					<div class="col-sm-12">
						<div class="panel panel-warning" id="dashboard-recent">
							<div class="panel-heading">
								<span class="panel-title"><i class="panel-title-icon fa fa-fire text-danger"></i><?php echo $lg_recent?></span>
								<ul class="nav nav-tabs nav-tabs-xs">
									<?php
									if($ugcom == 1){
									?>
									<li class="active">
										<a href="#dashboard-recent-comments" data-toggle="tab"><?php echo $lg_comment?></a>
									</li>
									<?php } ?>
									<?php
									if($ugp == 1){
									?>
									<li<?php if($ugcom == 0){?> class="active"<?php } ?>>
										<a href="#dashboard-recent-threads" data-toggle="tab"><?php echo $lg_post?></a>
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
													$getava = $getava->current();
													$avatar = $getava->avatar;
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
												elseif($cm->gallery_id > 0){
													$tblp = new ElybinTable('elybin_gallery');
													$getgallery = $tblp->SelectWhere('gallery_id', $cm->gallery_id, '', '');
													$getgallery = $getgallery->current();
													$ptitle = $getgallery->name; //
													$purl = $getgallery->image; //
													$ppart = "Foto"; //
												}
												elseif($cm->food_id > 0){
													$tblp = new ElybinTable('elybin_foodmenu');
													$getfood = $tblp->SelectWhere('food_id', $cm->food_id, '', '');
													$getfood = $getfood->current();
													$ptitle = $getfood->name; //
													$purl = $getfood->image; //
													$ppart = "Kuliner"; //
												}

												$content = html_entity_decode($cm->content);
												$date = time_elapsed_string($cm->date." ".$cm->time);
										?>
										<div class="comment">
											<img src="../elybin-file/avatar/<?php echo $avatar; ?>" alt="" class="comment-avatar">
											<div class="comment-body">
												<div class="comment-by">
													<a href="#" title=""><?php echo $cm->author; ?></a> <?php echo $lg_commenton?> <a href="../<?php echo $purl?>.html" title="" target="_blank">(<?php echo $ppart?>) <?php echo $ptitle?></a>
												</div>
												<div class="comment-text">
													<?php echo $content; ?>
												</div>
												<div class="comment-actions">
													<a href="?mod=comment&amp;act=edit&amp;id=<?php echo $cm->comment_id?>"><i class="fa fa-pencil"></i>Edit</a>
													<a href="?mod=comment&amp;act=view&amp;clear=yes&amp;id=<?php echo $cm->comment_id?>" data-toggle="modal" data-target="#view"><i class="fa fa-external-link"></i><?php echo $lg_detail?></a>
													<a href="?mod=comment&amp;act=del&amp;clear=yes&amp;id=<?php echo $cm->comment_id?>" data-toggle="modal" data-target="#delete"><i class="fa fa-times"></i><?php echo $lg_delete?></a>
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
											$post = $tbp->Select('post_id', 'DESC');
											$no = 1;
											foreach($post as $ps){

												//ambil avatar
												$tblu = new ElybinTable('elybin_users');
												$getava = $tblu->SelectWhere('user_id', $ps->author, '', '');
												$getava = $getava->current();
												$avatar = $getava->avatar;
												$author = $getava->fullname;

												//ambil category
												$tblu = new ElybinTable('elybin_category');
												$getcat = $tblu->SelectWhere('category_id', $ps->category_id, '', '');
												$getcat = $getcat->current();
												$category = $getcat->name;

												$date = time_elapsed_string($ps->date." ".$ps->time);
										?>
										<div class="thread">
											<img src="../elybin-file/avatar/<?php echo $avatar; ?>" alt="" class="thread-avatar">
											<div class="thread-body">
												<span class="thread-time"><?php echo $date?></span>
												<a class="thread-title"><?php echo $ps->title?></a>
												<div class="thread-info"><?php echo $lg_writedby?> <a title=""><?php echo $author?></a> in <a title=""><?php echo $category?></a></div>
											</div> <!-- / .thread-body -->
										</div> <!-- / .thread -->
										<?php
											$no++;
										}
										?>

									</div>
								</div> <!-- / .panel-body -->
								<?php } ?>
								
							</div>
						</div> <!-- / .widget-threads -->
						<!-- Javascript -->
						<script>
							init.push(function () {
								$('#dashboard-recent .panel-body > div').slimScroll({ height: 300, alwaysVisible: true, color: '#888',allowPageScroll: true });
							})
						</script>
						<!-- / Javascript -->
					</div><!-- col-12 -->
				</div> <!-- row -->
				<!-- ./Recent Widget -->
<?php 
	} 
}
?>