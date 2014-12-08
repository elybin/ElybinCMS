<?php
  $id = @$_GET['id'];

  // check post first
  $tbp = new ElybinTable('elybin_posts');
  $cpost = $tbp->GetRowAnd('status','publish','post_id',$id);
  if($cpost == 0){
  	header('location: 404.html');
  	exit;
  }

  // get information
  $post = $tbp->SelectWhereAnd('status','publish','post_id',$id,'','')->current();
  $subtitle = $post->title;
  $meta_desc = substr(strip_tags(html_entity_decode($post->content)),0,200);
  $meta_keyword = keyword_filter(strip_tags($post->title));

  //get author
  $tbu = new ElybinTable('elybin_users');
  $meta_author = $tbu->SelectWhere('user_id', $post->author,'','')->current()->fullname;

  include_once 'header.php';
  include_once 'menu.php';
?>


    <!-- Page Header -->
    <header class="intro-header intro-hide">
    </header>

    <!-- Main Content -->
    <div class="container">
    	<div class="clearfix form-group-margin" style="margin-top: 40px;"></div><!-- margin -->
        <div class="row">
			<div class="col-md-9">
				<?php
					// user 
					$user = $tbu->SelectWhere('user_id',$post->author,'','')->current()->fullname;
					$user_id = $tbu->SelectWhere('user_id',$post->author,'','')->current()->fullname;

					// category 
					$tbca = new ElybinTable('elybin_category');
					$category = $tbca->SelectWhere('category_id',$post->category_id,'','')->current();

					//comment
					$tbc = new ElybinTable('elybin_comments');
					$comment = $tbc->GetRow('post_id',$post->post_id,'','');

					// tag
					$tag = $post->tag;
					if($tag !== ''){
						$tag = explode(",", $tag);
						$ctag = count($tag);
					}else{
						$ctag = 0;
					}

					//content
					$content = html_entity_decode($post->content);

					// date 
					$date = explode("-", $post->date);
					$monthpfx = date("M", mktime(0,0,0,$date[1],1,2000));

					// Hits
					$hits = $post->hits+1;
					$data = array('hits' => $hits);
					$tbp->Update($data, 'post_id', $post->post_id);
				?>
				<!-- post -->
				<div class="col-md-2">
					<div class="circle-date">
					    <span class="day-prefix">Writed</span>
						<span class="day"><?php echo $date[2]?></span>
						<span class="slash"></span> 
						<span class="month"><?php echo $date[1]?></span>
						<span class="month-prefix"><?php echo $monthpfx?></span>
					</div>
				</div>
				<div class="col-md-10">
					<div class="post-preview">
						<h2 class="post-title">
							<?php echo $post->title?>
						</h2>
						<p class="post-meta">Posted by <em><?php echo $user?></em><?php if($comment>0){ ?> got <?php echo $comment?> comments<?php } ?><span class="pull-right hidden-xs"><?php echo time_elapsed_string($post->date.$post->time)?></span></p>
						<?php
							if($post->image !== ''){
						?>
						<img src="elybin-file/post/<?php echo $post->image?>" class="img-responsive img-rounded" alt="<?php echo $post->title?>" style="width: 100%">
						<?php } ?>
						<div class="post-subtitle text-justify">
							<?php echo $content ?>
						</div>
						<p class="post-meta">
							<i class="fa fa-star"></i>&nbsp;&nbsp;<?php echo $lg_category?>: <a href="category-<?php echo $category->category_id ?>-1-<?php echo $category->seotitle ?>.html"><?php echo $category->name?></a><br/>
							<?php
							if($ctag > 0){
							?>
							<i class="fa fa-tag"></i>&nbsp;&nbsp;
							<?php
								
								foreach ($tag as $t) {
									$tbt = new ElybinTable('elybin_tag');
									$tags = $tbt->SelectWhere('tag_id',$t,'','')->current();
							?>
							<a href="tag-<?php echo $t?>-1-<?php echo $tags->seotitle?>.html" class="label bg-light"><?php echo $tags->name?></a> 
							<?php
								}
							?>
							<?php } ?>
						</p>

					</div>
					<!-- .post-preview -->

					<?php
					// show if global setting coment allow
					if($op->default_comment_status=="allow" OR $op->default_comment_status=="confrim"){
					?>
					<div class="row">
						<div class="col-sm-9">
							<hr class="margin-md">
						</div>
						<div class="col-sm-3">
							<h3>COMMENTS</h3>
						</div>
					</div>
					
					<div id="all-comment">
						<?php
						$tbco = new ElybinTable('elybin_comments');
						$com = $tbco->SelectWhereAnd('status','active','post_id', $id, '', '');
						foreach ($com as $c) {
							if($c->user_id > 0){
								// collect user data
								$tbu = new ElybinTable('elybin_users');
								$u = $tbu->SelectWhere('user_id', $c->user_id,'','')->current();
								
								// check if avatar default
								if($u->avatar == "default/no-ava.png"){
									$ava = "default/medium-no-ava.png";
								}else{
									$ava = "medium-$u->avatar";
								}
								$fullname = $u->fullname;
								$email = $u->user_account_email;
							}else{
								$ava = "default/medium-no-ava.png";
								$fullname = $c->author;
								$email = $c->email;
							}
						?>
						<!-- commets row -->
						<div class="recent-tab row">
							<div class="col-xs-3 col-sm-2 col-md-2" style="max-width: 70px;">
								<img src="elybin-file/avatar/<?php echo $ava?>" class="img-circle">
							</div>
							<div class="col-xs-9 col-sm-10 col-md-10">
								<div class="hidden-sm hidden-xs" style="margin-top:10px"></div>
								<p class="text-default"><strong><?php echo $fullname?></strong> <?php echo $c->content?></p>
								<p class="text-sm text-light-gray"><?php echo time_elapsed_string($c->date.$c->time)?></p>
							</div>
						</div>
						<?php } ?>		
						<!-- commets row -->
						<div class="recent-tab row" id="comment-dummy" style="display:none">
							<div class="col-xs-3 col-sm-2 col-md-2" style="max-width: 70px;">
								<img src="elybin-file/avatar/default/medium-no-ava.png" class="img-circle">
							</div>
							<div class="col-xs-9 col-sm-10 col-md-10">
								<div class="hidden-sm hidden-xs" style="margin-top:10px"></div>
								<p class="text-default"><strong><?php echo $fullname?></strong> <span><?php echo $c->content?></span></p>
								<p class="text-sm text-light-gray">Just now</p>
							</div>
						</div>				
					</div>
					<!-- .all-comment -->

					<br/><br/>
					<?php
					// show if post allow commenting
					if($post->comment=="deny"){
					?>
					<h4 class="text-center"><?php echo $lg_commentalreadydisabled?></h4>
					<?php 
					}else{
					?>
					<div id="comment-form">
						<?php
						if(isset($_SESSION['login'])){
							$u = $tbu->SelectWhere('session', $_SESSION['login'],'','')->current();
						?>
						<div class="recent-tab row" id="comment-title">
							<div class="col-xs-3 col-sm-2 col-md-2" style="max-width: 70px;">
								<img src="elybin-file/avatar/<?php echo $u->avatar?>" class="img-circle">
							</div>
							<div class="col-xs-9 col-sm-10 col-md-10">
								<div style="height:10px"></div>
								<h4><?php echo $u->fullname?></h4>
								<p class="text-sm text-light-gray"><i><?php echo $lg_onlypublicinformationwillvisible?>.</i></p>
							</div>
						</div>
						<form id="comment-post" method="POST" action="elybin-main/comment/comment-post.php" style="margin-top: 10px;">
							<div class="row control-group">
								<div class="form-group col-xs-12 controls">
									<textarea name="message" rows="5" class="form-control input-lg" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
									<p class="help-block text-danger"></p>
								</div>
							</div>
							<div class="row control-group">
								<div class="form-group col-xs-6 col-md-3 controls">
									<input type="text" class="form-control input-lg" name="code" placeholder="<?php echo $lg_insertcode?>*" id="code" required data-validation-required-message="Please enter code.">
									<p class="help-block text-danger"></p>
								</div>
								<div class="form-group col-xs-6 col-md-3 controls">
									<img src="code.jpg" class="img-rounded img-thumbnail" style="height: 50px">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-xs-12">
									<button type="submit" class="btn btn-default"><?php echo $lg_leavecomment?></button>
									<input type="hidden" name="post_id" value="<?php echo $id?>"/>
									<span id="loading" style="display:none">&nbsp;&nbsp; <i class="fa fa-spin fa-repeat"></i>&nbsp;&nbsp;<?php echo $lg_sending?>...</span>
								</div>
							</div>
						</form>
						<?php }else{ ?>
						<form id="comment-post" method="POST" action="elybin-main/comment/comment-post.php">
							<div class="row control-group">
								<div class="form-group col-xs-12 controls">
									<input type="text" name="name" class="form-control input-lg" placeholder="Your Name *" id="name" required data-validation-required-message="Please enter your name.">
									<p class="help-block text-danger"></p>
								</div>
							</div>
							<div class="row control-group">
								<div class="form-group col-xs-12 controls">
									<input type="email" name="email" class="form-control input-lg" placeholder="Your Email *" id="email" required data-validation-required-message="Please enter your email address.">
									<p class="help-block text-danger"></p>
								</div>
							</div>
							<div class="row control-group">
								<div class="form-group col-xs-12 controls">
									<textarea name="message" rows="5" class="form-control input-lg" placeholder="Your Message *" id="message" required data-validation-required-message="Please enter a message."></textarea>
									<p class="help-block text-danger"></p>
								</div>
							</div>
							<div class="row control-group">
								<div class="form-group col-xs-6 col-md-3 controls">
									<input type="text" class="form-control input-lg" name="code" placeholder="<?php echo $lg_insertcode?>*" id="code" required data-validation-required-message="Please enter code.">
									<p class="help-block text-danger"></p>
								</div>
								<div class="form-group col-xs-6 col-md-3 controls">
									<img src="code.jpg" class="img-rounded img-thumbnail" style="height: 50px">
								</div>
							</div>
							<div class="row">
								<div class="form-group col-xs-12">
									<button type="submit" class="btn btn-default"><?php echo $lg_leavecomment?></button>
									<input type="hidden" name="post_id" value="<?php echo $id?>"/>
									<span id="loading" style="display: none">&nbsp;&nbsp; <i class="fa fa-spin fa-repeat"></i>&nbsp;&nbsp;<?php echo $lg_sending?>...</span>
								</div>
							</div>
						</form>
						<?php } ?>
						<div class="col-lg-12 col-md-12">
							<div class="text-center" id="success">
								<h4>
									<i class="fa fa-check-circle text-success"></i>
									<span></span>
								</h4>
							</div>

							<div class="text-center" id="error">
								<a href="#" class="close"><i class="fa fa-times"></i></a><br/>
								<h4>
									<i class="fa fa-times-circle text-danger"></i>
									<span><?php echo $lg_failedtosendmessagepleaseresend?></span>.
								</h4>
							</div>
			                <div id="pleasefill" class="hidden"><?php echo $lg_pleasefillimportant?></div>
						</div>
					</div>
					<?php } ?>
					<?php } ?>
				</div>
				<!-- ./post -->
			</div>
			<!-- .col-md-9 / ./post-container-->
			<div style="height: 90px;"></div>
<?php
  include 'sidebar.php';
?>
        </div>
        <!-- .row -->
    </div>
    <br/><br/>
<?php
  include "footer.php";
?>
