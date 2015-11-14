<?php
/* Short description for file
 * Module: Comment
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/comment/";
$action		= $modpath."proses.php";

// string validation for security
$v 	= new ElybinValidasi();

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->comment;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to access this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	//start here
	switch (@$_GET['act']) {
		case 'view':

		$cid 	= $v->sql(epm_decode(@$_GET['hash']));

		// declare table
		$tb = new ElybinTable('elybin_comments');

		// 1.1.3
		// (rsch) merge to only single query, will speed up php processing speed & simplify the code
		// get all data
		$cc	= $tb->SelectFullCustom("
		SELECT
		*,
		`c`.`content` as `ccontent`,
		`p`.`title` as `post_title`,
		`c`.`status` as `com_status`,
		`c`.`user_id` as `com_user_id`,
		COUNT(*) as `row`,	-- counting row
		CASE		-- check if user_id related to elybin_users
			WHEN `c`.`user_id` > 0
			THEN `u`.`fullname`
			ELSE `c`.`author`
		END as `realname`
		FROM
		`elybin_comments` as `c`
		LEFT JOIN
			`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
        LEFT JOIN
			`elybin_visitor` as `v` ON `c`.`visitor_id` = `v`.`visitor_id`
        LEFT JOIN
			`elybin_posts` as `p` ON `c`.`post_id` = `p`.`post_id`
		WHERE
		`c`.`comment_id` = '".$cid."'
		LIMIT 0,1
		")->current();

		if($cc->row < 1){
			// show error
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-comment"></i>&nbsp;&nbsp;<?php echo lg('Comment Detail')?></h4>
							</div>
							<div class="modal-body">
								<table class="table">
									<tr>
										<td><i><?php echo lg('Commenting')?></i></td>
										<td><?php
										if($cc->type  == 'post'){
											echo lg('Post');
										}
										else if($cc->type  == 'album'){
											echo lg('Album');
										}
										?> - <?php echo $cc->post_title?></td>
									</tr>
									<tr>
										<td><i><?php echo lg('Author')?></i></td>
										<td>
											<?php
											// if comment status is 'active'
											if($cc->com_status == 'active'){
												echo '<a href="?mod=comment&amp;act=block&amp;hash='.epm_encode($cc->comment_id).'&amp;clear=yes" class="btn btn-xs btn-danger pull-right" data-toggle="modal" data-target="#delete"><i class="fa fa-ban"></i> '.lg("Block future comment from").'"'.$cc->realname.'"</a>';
											}else{
												echo '<a href="?mod=comment&amp;act=unblock&amp;hash='.epm_encode($cc->comment_id).'&amp;clear=yes" class="btn btn-xs btn-default pull-right" data-toggle="modal" data-target="#delete"><i class="fa fa-ban"></i> '.lg("Unblock ").'"'.$cc->realname.'"</a>';
											}
											?>

											<?php echo $cc->realname?><br/>
											(<?php echo $cc->email ?>)
										</td>
									</tr>
									<tr>
										<td><i><?php echo lg('Date')?></i></td>
										<td><?php echo time_elapsed_string($cc->date)?></td>
									</tr>
									<tr>
										<td><i><?php echo lg('Content')?></i></td>
										<td><?php echo $cc->ccontent?></td>
									</tr>
								</table>
								<hr/>
								<form class="" action="app/comment/proses.php" method="post" id="form-quick">
									<div class="form-group">
									  <div class="col-sm-12">
										<?php
											// get child comment (reply)
											$lcr = $tb->SelectFullCustom("
											SELECT
											*,
											`c`.`content` as `ccontent`,
											CASE		-- check if user_id related to elybin_users
												WHEN `c`.`user_id` > 0
												THEN `u`.`fullname`
												ELSE `c`.`author`
											END as `realname`
											FROM
											`elybin_comments` as `c`
											LEFT JOIN
												`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
											WHERE
											`c`.`parent` = '".$cid."'
											");
											foreach($lcr as $ccr){
										?>
										<!-- comment block -->
										<div class="panel-body depth-xs" style="margin-bottom: 5px">
											<p><b class="text-bg"><?php echo $ccr->realname ?></b> &nbsp;<i class="text-light-gray">(<?php echo $ccr->email ?>)</i></b></p>
											<p><?php echo htmlspecialchars($ccr->ccontent)?></p>
											<span class="text-xs text-light-gray"><?php echo time_elapsed_string($ccr->date)?></span>
											<div class="pull-right">
												<a href="?mod=comment&amp;act=del&amp;hash=<?php echo epm_encode($ccr->comment_id) ?>&amp;clear=yes" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o"></i> <?php echo lg('Delete') ?></a>
											</div>
										</div>
										<?php
											}
										?>
									  	<?php
									  	// if comment have replied
									  	if($cc->com_user_id !== _u()->user_id){
									  	?>
									  	<br/>
									  	<a href="?mod=comment&amp;act=reply&amp;hash=<?php echo epm_encode($cid); ?>" class="pull-right"><i class="fa fa-pencil"></i> <?php echo lg('Advanced Reply') ?></a>
									  	<h4><?php echo lg('Quick Reply') ?></h4>
										<textarea name="content" cols="50" rows="7" class="form-control" id="text-editor" placeholder="<?php echo lg('Your comment here...')?>"></textarea>
										<br/>
										<button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Send Reply')?></button>&nbsp;
										<a href="?mod=comment&amp;act=del&amp;hash=<?php echo epm_encode($cc->comment_id) ?>&amp;clear=yes" class="btn btn-danger" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo lg('Delete Permanently') ?>"><i class="fa fa-trash-o"></i><i class="fa fa-times"></i>&nbsp;<?php echo lg('Delete') ?></a>
										<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>


										<input type="hidden" name="hash" value="<?php echo epm_encode($cid); ?>" />
										<input type="hidden" name="act" value="reply" />
										<input type="hidden" name="mod" value="comment" />
										</div>
									  	<?php
									  	} ?>
									</div> <!-- / .form-group -->
								</div>

								<div class="form-group no-margin-b">

								</div>
							</div>
<script type="text/javascript">ElybinView();</script>
<?php

			break;

		case 'reply';
		$cid 	= $v->sql(epm_decode(@$_GET['hash']));

		// declare table
		$tb = new ElybinTable('elybin_comments');

		// single query
		// get all data
		$cc	= $tb->SelectFullCustom("
		SELECT
		*,
		`c`.`content` as `ccontent`,
		`p`.`title` as `post_title`,
		COUNT(*) as `row`,	-- counting row
		CASE		-- check if user_id related to elybin_users
			WHEN `c`.`user_id` > 0
			THEN `u`.`fullname`
			ELSE `c`.`author`
		END as `realname`
		FROM
		`elybin_comments` as `c`
		LEFT JOIN
			`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
        LEFT JOIN
			`elybin_visitor` as `v` ON `c`.`visitor_id` = `v`.`visitor_id`
        LEFT JOIN
			`elybin_posts` as `p` ON `c`.`post_id` = `p`.`post_id`
		WHERE
		`c`.`comment_id` = '".$cid."'
		LIMIT 0,1
		")->current();

		// check existance
		if($cc->row < 1){
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}

?>
		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=comment"><?php echo lg('Comment') ?></a></li>
			<li class="active"><a href="?mod=comment&amp;act=reply&amp;hash=<?php echo epm_encode($id) ?>"><?php echo lg('Reply Comment') ?></a></li>

			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=comment" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to Comment') ?></a>
			<h1><?php echo lg('Reply Comment') ?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<?php
			// 1.1.3
			if(@$_GET['msg'] == 'posted'){
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Your reply successfully posted and it will inform via email.') . '</div>';
			}
			else if(@$_GET['msg'] == 'deleted'){
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Comment successfully deleted.') . '</div>';
			}
		?>

		<style><?php include("assets/stylesheets/select2.min.css"); ?></style>
		<style><?php include("assets/stylesheets/jquery-ui.css"); ?></style>
		<style><?php include("assets/stylesheets/jquery.tagsinput.min.css"); ?></style>
		<form class="" action="app/comment/proses.php" method="post" enctype="multipart/form-data" id="form">
			<div class="row">
				<div class="col-sm-8">
					<div class="form-horizontal panel-wide depth-sm" style="margin-bottom: 5px">
						<div class="panel-body">
							<!-- comment block -->
							<div class="panel-body depth-md" style="margin-bottom: 5px">
								<p><b class="text-bg"><?php echo $cc->realname ?></b> &nbsp;<i class="text-light-gray">(<?php echo $cc->email ?>)</i></b></p>
								<p><?php echo htmlspecialchars($cc->ccontent)?></p>
								<span class="text-right text-xs text-light-gray"><?php echo time_elapsed_string($cc->date)?> - <?php echo $cc->post_title ?></span>
							</div>

							<?php
							// get child comment (reply)
							$lcr = $tb->SelectFullCustom("
							SELECT
							*,
							`c`.`content` as `ccontent`,
							`p`.`title` as `post_title`,
							CASE		-- check if user_id related to elybin_users
								WHEN `c`.`user_id` > 0
								THEN `u`.`fullname`
								ELSE `c`.`author`
							END as `realname`
							FROM
							`elybin_comments` as `c`
							LEFT JOIN
								`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
							LEFT JOIN
								`elybin_posts` as `p` ON `c`.`post_id` = `p`.`post_id`
							WHERE
							`c`.`parent` = '".$cid."'
							");
							foreach($lcr as $ccr){
							?>
							<!-- comment block -->
							<div class="panel-body depth-xs" style="margin-bottom: 5px">
								<p><b class="text-bg"><?php echo $ccr->realname ?></b> &nbsp;<i class="text-light-gray">(<?php echo $ccr->email ?>)</i></b></p>
								<p><?php echo htmlspecialchars($ccr->ccontent)?></p>
								<span class="text-xs text-light-gray"><?php echo time_elapsed_string($ccr->date)?> - <?php echo $ccr->post_title ?></span>
								<div class="pull-right">
									<a href="?mod=comment&amp;act=del&amp;hash=<?php echo epm_encode($ccr->comment_id) ?>&amp;clear=yes" data-toggle="modal" data-target="#delete"><i class="fa fa-trash-o"></i> <?php echo lg('Delete') ?></a>
								</div>
							</div>
							<?php
							}
							?>
							<div class="form-group">
							  <div class="col-sm-12">
								<?php
								// getting text_editor
								if(op()->text_editor == 'summernote'){
									echo '<style>'; include("assets/stylesheets/summernote.css"); echo '</style>';
								}
								else if(op()->text_editor == 'bs-markdown'){
									echo '<style>';include("assets/stylesheets/markdown.css"); echo '</style>';
								}
								?>
								<div id="summernote-progress" style="display: none">
									<p><?php echo lg('Uploading Images...') ?> - <span>1%</span></p>
									<div class="progress progress-striped">
										<div class="progress-bar progress-bar-success" style="width: 1%"></div>
									</div>
								 </div>
								<textarea name="content" cols="50" rows="10" class="form-control" id="text-editor" placeholder="<?php echo lg('Write your reply...')?>"></textarea>
								<br/>
								<button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Send Reply')?></button>
							 </div>

							</div> <!-- / .form-group -->

						  </div><!-- / .panel-body -->
					</div>
				</div><!-- / .col -->


				<div class="col-sm-4">
					<div class="form-horizontal depth-sm" style="margin-bottom: 5px">
						<div class="panel-body">
							<h4><?php echo lg('Recent Comments') ?></h4>
							<?php
							// show recent comment (ajax)
							$lc = $tb->SelectFullCustom("
							SELECT
							*,
							`c`.`content` as `ccontent`,
							`p`.`title` as `post_title`,
							CASE		-- check if user_id related to elybin_users
								WHEN `c`.`user_id` > 0
								THEN `u`.`fullname`
								ELSE `c`.`author`
							END as `realname`
							FROM
							`elybin_comments` as `c`
							LEFT JOIN
								`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
							LEFT JOIN
								`elybin_posts` as `p` ON `c`.`post_id` = `p`.`post_id`
							WHERE
							`c`.`parent` = 0 &&
							`c`.`user_id` != '"._u()->user_id."'
							LIMIT 0,5
							");
							// show
							foreach($lc as $cc2){
							?>
								<div class="comment">
									<div class="comment-body">
										<div class="comment-by">
											<a href="?mod=users" title=""><?php echo $cc2->realname ?></a> commented on "<a href="<?php echo '../'.$cc2->type.'/'.$cc2->post_id.'/'.$cc2->seotitle.'.html'; ?>"><?php echo substr($cc2->post_title, 0,20) ?></a>..."
										</div>
										<div class="comment-text">
											<?php echo substr(strip_tags($cc2->ccontent), 0,200)?>
										</div>
										<div class="comment-actions">
											<a href="?mod=comment&amp;act=reply&amp;hash=<?php echo epm_encode($cc2->comment_id) ?>"><i class="fa fa-comment"></i> <?php echo lg('Reply') ?></a>
											<span class="pull-right"><?php echo time_elapsed_string($cc->date)?></span>
										</div>
									</div> <!-- / .comment-body -->
								</div> <!-- / .comment -->
								<br/>
							<?php } ?>

						</div><!-- / .panel-body -->
					</div>
				</div><!-- / .col -->

				<input type="hidden" name="hash" value="<?php echo epm_encode($cid); ?>" />
				<input type="hidden" name="act" value="reply" />
				<input type="hidden" name="mod" value="comment" />

			</div>
		</form><!-- / .form -->


		<!-- Modal 1 -->
		<div id="delete" class="modal fade hide-light" tabindex="-1" role="dialog" style="z-index:2000">
			<div class="modal-dialog modal-sm">
				<div class="modal-content">
					<?php echo lg('Loading')?>...
				</div> <!-- / .modal-content -->
			</div> <!-- / .modal-dialog -->
		</div> <!-- / .modal -->
<?php
		break;

	case 'del':
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?php echo lg('Delete Permanently') ?></h4>
							</div>
							<div class="modal-body">
								<p class="text-danger"><?php echo lg('Are you sure you want delete permanently this item. This action cannot be undone.')?></p>
								<hr></hr>
								<form action="app/comment/proses.php" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Delete')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									<input type="hidden" name="hash" value="<?php echo @$_GET['hash']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="comment" />
								</form>
							</div>
<?php
			break;

		case 'block':
			$cid = $v->sql(epm_decode(@$_GET['hash']));

			// declare table
			$tb = new ElybinTable('elybin_comments');

			// 1.1.3
			// (rsch) merge to only single query, will speed up php processing speed & simplify the code
			// get all data
			$cc	= $tb->SelectFullCustom("
			SELECT
			*,
			`c`.`content` as `ccontent`,
			`p`.`title` as `post_title`,
			`c`.`user_id` as `com_user_id`,
			`c`.`status` as `com_status`,
			COUNT(*) as `row`,	-- counting row
			CASE		-- check if user_id related to elybin_users
				WHEN `c`.`user_id` > 0
				THEN `u`.`fullname`
				ELSE `c`.`author`
			END as `realname`
			FROM
			`elybin_comments` as `c`
			LEFT JOIN
				`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
	        LEFT JOIN
				`elybin_visitor` as `v` ON `c`.`visitor_id` = `v`.`visitor_id`
	        LEFT JOIN
				`elybin_posts` as `p` ON `c`.`post_id` = `p`.`post_id`
			WHERE
			`c`.`comment_id` = '".$cid."'
			LIMIT 0,1
			")->current();

			// if data empty
			if($cc->row < 1){
				// show error
				er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
				theme_foot();
				exit;
			}

			// can`t block his self
			if($cc->com_user_id == _u()->user_id){
				// show error
				echo '<div class="note note-danger depth-xs no-margin"><i class="fa fa-exclamation-triangle"></i> ' . lg('Be careful, you just want to kill your self.') . '</div>';
				exit;
			}

			// system error found, requested data mismatch with our database
			if($cc->com_status == 'blocked'){
				// show error
				echo '<div class="note note-danger depth-xs no-margin"><i class="fa fa-exclamation-triangle"></i> ' . lg('Sorry, we had trouble. The requested data mismatch with our database, please refresh this page.') . '</div>';
				exit;
			}
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?php echo lg('Confrim Block') ?></h4>
							</div>
							<div class="modal-body">
								<p class="text-danger"><?php echo lg('Are you sure you want to block')?> <?php echo $cc->realname ?>?</p>
								<p class="text-danger">
								<?php echo lg('It also deny from:') ?>
									<ul>
										<li><?php echo lg('Commenting a post') ?></li>
									</ul>
								</p>
								<hr/>
								<form action="app/comment/proses.php" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Block')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									<input type="hidden" name="hash" value="<?php echo @$_GET['hash']?>" />
									<input type="hidden" name="act" value="block" />
									<input type="hidden" name="mod" value="comment" />
								</form>
							</div>
<?php
			break;

		case 'unblock':
			$cid = $v->sql(epm_decode(@$_GET['hash']));

			// declare table
			$tb = new ElybinTable('elybin_comments');

			// 1.1.3
			// (rsch) merge to only single query, will speed up php processing speed & simplify the code
			// get all data
			$cc	= $tb->SelectFullCustom("
			SELECT
			*,
			`c`.`content` as `ccontent`,
			`p`.`title` as `post_title`,
			`c`.`user_id` as `com_user_id`,
			`c`.`status` as `com_status`,
			COUNT(*) as `row`,	-- counting row
			CASE		-- check if user_id related to elybin_users
				WHEN `c`.`user_id` > 0
				THEN `u`.`fullname`
				ELSE `c`.`author`
			END as `realname`
			FROM
			`elybin_comments` as `c`
			LEFT JOIN
				`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
	        LEFT JOIN
				`elybin_visitor` as `v` ON `c`.`visitor_id` = `v`.`visitor_id`
	        LEFT JOIN
				`elybin_posts` as `p` ON `c`.`post_id` = `p`.`post_id`
			WHERE
			`c`.`comment_id` = '".$cid."'
			LIMIT 0,1
			")->current();

			// if data empty
			if($cc->row < 1){
				// show error
				er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
				theme_foot();
				exit;
			}

			// can`t block his self
			if($cc->com_user_id == _u()->user_id){
				// show error
				echo '<div class="note note-danger depth-xs no-margin"><i class="fa fa-exclamation-triangle"></i> ' . lg('Be careful, you just want to kill your self.') . '</div>';
				exit;
			}

			// system error found, requested data mismatch with our database
			if($cc->com_status == 'active'){
				// show error
				echo '<div class="note note-danger depth-xs no-margin"><i class="fa fa-exclamation-triangle"></i> ' . lg('Sorry, we had trouble. The requested data mismatch with our database, please refresh this page.') . '</div>';
				exit;
			}
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?php echo lg('Confrim Unblock') ?></h4>
							</div>
							<div class="modal-body">
								<p class="text-danger"><?php echo lg('Are you sure you want to unblock')?> <?php echo $cc->realname ?>?</p>
								<p class="text-danger">
								<?php echo lg('It will opening access to:') ?>
									<ul>
										<li><?php echo lg('Commenting a post') ?></li>
									</ul>
								</p>
								<hr/>
								<form action="app/comment/proses.php" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('It\'s okay, Unblock')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									<input type="hidden" name="hash" value="<?php echo @$_GET['hash']?>" />
									<input type="hidden" name="act" value="unblock" />
									<input type="hidden" name="mod" value="comment" />
								</form>
							</div>
<?php
			break;

		default:
			$tb 	= new ElybinTable('elybin_comments');

			$search = $v->sql(@$_GET['search']);

			// search
			if(isset($_GET['search'])){
				$s_q = " && (`c`.`author` LIKE '%$search%' || `c`.`email` LIKE '%$search%' || `c`.`status` LIKE '%$search%')";
			}else{
				$s_q = "";
			}

			// get current user
			$u = _u();

			// 1.1.3
			// with filter
			if(!isset($_GET['filter'])){
				// normal query
				// show all, exclude: blocked, my comments
				$que = "
				SELECT
				*,
				`c`.`content` as `ccontent`,
				`p`.`title` as `post_title`,
				`c`.`date` as `com_date`,
				`c`.`content` as `com_content`,
				`c`.`status` as `com_status`,
				CASE		-- check if user_id related to elybin_users
					WHEN `c`.`user_id` > 0
					THEN `u`.`fullname`
					ELSE `c`.`author`
				END as `realname`
				FROM
				`elybin_comments` as `c`
				LEFT JOIN
					`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
		        LEFT JOIN
					`elybin_posts` as `p` ON `c`.`post_id` = `p`.`post_id`
				WHERE
				`c`.`user_id` != ".$u->user_id." &&
				`c`.`status` != 'blocked'
				$s_q
				";
			}
			else if(isset($_GET['filter']) && @$_GET['filter'] == 'unread'){
				// show only: active (not blocked), replay no
				$que = "
				SELECT
				*,
				`c`.`content` as `ccontent`,
				`p`.`title` as `post_title`,
				`c`.`date` as `com_date`,
				`c`.`content` as `com_content`,
				`c`.`status` as `com_status`,
				CASE		-- check if user_id related to elybin_users
					WHEN `c`.`user_id` > 0
					THEN `u`.`fullname`
					ELSE `c`.`author`
				END as `realname`
				FROM
				`elybin_comments` as `c`
				LEFT JOIN
					`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
		        LEFT JOIN
					`elybin_posts` as `p` ON `c`.`post_id` = `p`.`post_id`
				WHERE
				`c`.`user_id` != ".$u->user_id." &&
				`c`.`status` = 'active' &&
				`c`.`reply` = 'no'
				$s_q
				";
			}
			else if(isset($_GET['filter']) && @$_GET['filter'] == 'mine'){
				// show only with current user_id
				$que = "
				SELECT
				*,
				`c`.`content` as `ccontent`,
				`p`.`title` as `post_title`,
				`c`.`date` as `com_date`,
				`c`.`content` as `com_content`,
				`c`.`status` as `com_status`,
				CASE		-- check if user_id related to elybin_users
					WHEN `c`.`user_id` > 0
					THEN `u`.`fullname`
					ELSE `c`.`author`
				END as `realname`
				FROM
				`elybin_comments` as `c`
				LEFT JOIN
					`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
		        LEFT JOIN
					`elybin_posts` as `p` ON `c`.`post_id` = `p`.`post_id`
				WHERE
				`c`.`user_id` = ".$u->user_id."
				$s_q
				";
			}
			else if(isset($_GET['filter']) && @$_GET['filter'] == 'blocked'){
				// show only blocked comment
				$que = "
				SELECT
				*,
				`c`.`content` as `ccontent`,
				`p`.`title` as `post_title`,
				`c`.`date` as `com_date`,
				`c`.`content` as `com_content`,
				`c`.`status` as `com_status`,
				CASE		-- check if user_id related to elybin_users
					WHEN `c`.`user_id` > 0
					THEN `u`.`fullname`
					ELSE `c`.`author`
				END as `realname`
				FROM
				`elybin_comments` as `c`
				LEFT JOIN
					`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
		        LEFT JOIN
					`elybin_posts` as `p` ON `c`.`post_id` = `p`.`post_id`
				WHERE
				`c`.`user_id` != ".$u->user_id." &&
				`c`.`status` = 'blocked'
				$s_q
				";
			}


			$coc = $tb->GetRowFullCustom($que);
			// modify query to pageable & shortable
			$oarr = array(
				'default' => '`c`.`comment_id` DESC',
				'author' => '`c`.`author`',
				'date' => '`c`.`date`'
			);
			$que = _PageOrder($oarr, $que);
			$lcom	= $tb->SelectFullCustom($que);

			// /echo '<pre>'.$que.'</pre>';
?>
		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray"><?php echo lg('You are here:') ?></div>
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li class="active"><a href="?mod=comment"><?php echo lg('Comment') ?></a></li>

			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-comment"></i>&nbsp;&nbsp;<?php echo lg('Comment')?></span>
					<span class="hidden-xs"><?php echo lg('Comment') ?></span>
					<?php if($search!==''){ echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-light-gray text-sm">'.lg('Search result for').' <i>&#34;'.$search.'&#34;</i>';} ?>
				</h1>
			</div>
		</div> <!-- ./Page Header -->

		<?php
			// 1.1.3
			if(@$_GET['msg'] == 'blocked'){
				$cbc = $tb->SelectFullCustom("
				SELECT
				CASE		-- check if user_id related to elybin_users
					WHEN `c`.`user_id` > 0
					THEN `u`.`fullname`
					ELSE `c`.`author`
				END as `realname`
				FROM
				`elybin_comments` as `c`
				LEFT JOIN
					`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
				WHERE
				`c`.`comment_id` = ".epm_decode(@$_GET['hash'])."
				")->current();
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('You\'ve blocked') . ' '. $cbc->realname. ', ' . lg('We\'re sorry that you\'ve had this experience.') . '</div>';
			}
			else if(@$_GET['msg'] == 'unblocked'){
				$cubc = $tb->SelectFullCustom("
				SELECT
				CASE		-- check if user_id related to elybin_users
					WHEN `c`.`user_id` > 0
					THEN `u`.`fullname`
					ELSE `c`.`author`
				END as `realname`
				FROM
				`elybin_comments` as `c`
				LEFT JOIN
					`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
				WHERE
				`c`.`comment_id` = ".epm_decode(@$_GET['hash'])."
				")->current();
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Successfully unblock') . ' '. $cubc->realname. ', ' . lg('That\'s kind of you.') . '</div>';
			}
			else if(@$_GET['msg'] == 'posted'){
				$cubc = $tb->SelectFullCustom("
				SELECT
				CASE		-- check if user_id related to elybin_users
					WHEN `c`.`user_id` > 0
					THEN `u`.`fullname`
					ELSE `c`.`author`
				END as `realname`
				FROM
				`elybin_comments` as `c`
				LEFT JOIN
					`elybin_users` as `u` ON `c`.`user_id` = `u`.`user_id`
				WHERE
				`c`.`comment_id` = ".epm_decode(@$_GET['hash'])."
				")->current();
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Your reply to ') . ' "'. $cubc->realname. '"  '. lg('successfully posted. There few comment you must reply too.') . '</div>';
			}
		?>

		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<!-- Tabs -->
				<ul class="nav nav-tabs nav-tabs-xs">
					<li<?php if(!isset($_GET['filter'])){echo' class="active"'; }?>>
						<?php
						// count all post
						$totallcom = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_comments` as `c`
							WHERE
							`c`.`user_id` != ".$u->user_id." &&
							`c`.`status` != 'blocked'
						");
						?>
						<a href="?mod=comment"><?php echo lg('All') ?> <span class="badge badge-default"><?php echo $totallcom ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='unread'){echo' class="active"'; }?>>
						<?php
						// count all page
						$toturcc = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_comments` as `c`
							WHERE
							`c`.`user_id` != ".$u->user_id." &&
							`c`.`status` != 'blocked' &&
							`c`.`reply` = 'no'
						");
						?>
						<a href="?mod=comment&amp;filter=unread"><?php echo lg('Unread') ?> <span class="badge badge-info"><?php echo $toturcc ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='mine'){echo' class="active"'; }?>>
						<?php
						// count all page
						$totmicc = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_comments` as `c`
							WHERE
							`c`.`user_id` = ".$u->user_id."
						");
						?>
						<a href="?mod=comment&amp;filter=mine"><?php echo lg('Mine') ?> <span class="badge badge-success"><?php echo $totmicc ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='blocked'){echo' class="active"'; }?>>
						<?php
						// count all post
						$totblcc = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_comments` as `c`
							WHERE
							`c`.`user_id` != ".$u->user_id." &&
							`c`.`status` = 'blocked'
						");
						?>
						<a href="?mod=comment&amp;filter=blocked"><?php echo lg('Blocked') ?> <span class="badge badge-danger"><?php echo $totblcc ?></span></a>
					</li>
				</ul> <!-- / .nav -->
				<!-- Panel -->
				<div class="panel">
					<!-- ./Panel Heading -->
					<div class="panel-body">
					  <div class="table-primary table-responsive">

						<?php
						$orb = array(
							'author' => lg('Author'),
							'date' => lg('Date')
						);
						showOrder($orb);
						showSearch();
						?>
						<!-- delate -->
						<form action="app/comment/proses.php" method="post">
						<input type="hidden" name="act" value="multidel" />
						<input type="hidden" name="mod" value="comment" />

						<table class="table table-bordered table-striped" id="results">
						 <thead>
						   <tr>
						    <th><i class="fa fa-square" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo lg('Check All')?>"></i></th>
						    <th><?php echo lg('Author') ?></th>
						    <th><?php echo lg('Preview') ?></th>
						    <th><?php echo lg('Comment on') ?></th>
						    <th><?php echo lg('Date') ?></th>
						    <th><?php echo lg('Reply')?></th>
						    <th><?php echo lg('Status')?></th>
						    <th><?php echo lg('Action')?></th>
						   </tr>
						 </thead>
						 <tbody>
						<?php

						$no = 0;
						foreach($lcom as $cc){
						?>
						   <tr>
							<td width="1%"><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo epm_encode($cc->comment_id)?>|<?php echo substr(strip_tags($cc->ccontent), 0, 200) ?>"><span class="lbl"></span></label></td>
							<td width="15%">
								<?php echo $cc->realname ?>
								<br/>
								<i class="text-xs text-light-gray">
								<?php
								// check status
								if($cc->user_id > 0){
									echo lg('User');
								}else{
									echo lg('Guest');
								}
								?>
								</i>
							</td>
							<td width="20%"><i class="text-sm"><?php echo substr(strip_tags($cc->com_content), 0, 80) ?>...</i></td>
							<td><?php
							if($cc->type == 'post'){
								echo lg('Post');
							}
							else if($cc->type == 'album'){
								echo lg('Album');
							}
							 ?><br/><a href="#"><i class="text-xs"><?php echo $cc->post_title ?></i></a></td>
							<td><?php echo friendly_date($cc->com_date)?>
								<br/><i class="text-light-gray text-xs"><?php echo time_elapsed_string($cc->com_date)?></i></td>
							<td><?php
							// status
							if($cc->reply == 'no'){
								echo lg('Not yet');
							}
							else{
								echo '<i class="text-light-gray">'.lg('Replied').'</i>';
							}
							?></td>
							<td><?php
							// status
							if($cc->com_status == 'active'){
								echo lg('Activate');
							}
							else if($cc->com_status == 'blocked'){
								echo '<i class="text-danger">'.lg('Blocked').'</i>';
							}
							?></td>
							<td>
								<div id="tooltip">

						    		<?php
										echo '<a href="?mod=comment&amp;act=view&amp;hash='.epm_encode($cc->comment_id).'&amp;clear=yes" class="btn btn-success btn-outline btn-sm" data-toggle="modal" data-target="#view" data-placement="bottom" data-toggle="tooltip" data-original-title="'.lg('Detail').'"><i class="fa fa-external-link"></i></a>&nbsp;';
										echo '<a href="?mod=comment&amp;act=reply&amp;hash='.epm_encode($cc->comment_id).'" class="btn btn-success btn-outline btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="'.lg('Reply').'"><i class="fa fa-comment"></i></a>&nbsp;';
										echo '<a href="?mod=comment&amp;act=del&amp;hash='.epm_encode($cc->comment_id).'&amp;clear=yes" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="'.lg('Delete Permanently').'"><i class="fa fa-trash-o"></i><i class="fa fa-times"></i></a>';
									?>

								</div>
							</td>
						   </tr>
						<?php
							$no++;
						}


						if($no < 1){
							echo '<tr><td colspan="8"><div class="text-center text-light-gray panel-padding"><i class="fa fa-5x fa-comment"></i><br/>'. lg('Nothing can be shown.').'</div></td></tr>';
						}
						?>
						 </tbody>
						</table>


						<!-- Multi Delete Modal -->
						<div id="deleteall" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
									<?php echo '<h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'.lg('Delete Permanently').'</h4>'; ?>
									</div>
									<div class="modal-body">
										<?php
										echo lg('Are you sure you want delete permanently this item?');
										?>
										<div id="deltext"></div>
										<hr/>
										<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Delete All')?></button>
										<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									</div>
								</div> <!-- / .modal-content -->
							</div> <!-- / .modal-dialog -->
						</div> <!-- / .modal -->
						<!-- / Multi Delete Modal -->
						<div class="col-md-3">
							<button class="btn btn-danger btn-sm" id="delall" data-toggle="modal" data-target="#deleteall" style="display:none"><i class="fa fa-times"></i>&nbsp;&nbsp;<?php echo lg('Delete Selected')?></button>
						</div>
						</form>



						<?php showPagging($coc) ?>

					  </div> <!-- /.table-responsive -->


					</div><!-- / .panel-body -->
				</div><!-- / .panel -->
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

			</div><!-- / .col -->
		</div><!-- / .row -->

<?php
		break;
		}
	}
}
?>
