<?php
/* Short description for file
 * [ Module: Comment
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
if(!isset($_SESSION['login'])){
	echo '403';
	header('location:../403.php');
}else{
$modpath 	= "app/comment/";
$action		= $modpath."proses.php";

// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
$level = $tbus->current()->level; // getting level from curent user

$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
$usergroup = $tbug->current()->comment;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
	echo '';
}else{
	//start here
	$v 	= new ElybinValidasi();
	switch (@$_GET['act']) {
		case 'view':

		$id 	= $v->xss($_GET['id']);
		$id 	= $v->sql($id);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_comments');
		$cocomment = $tb->GetRow('comment_id', $id);
		if(empty($id) OR ($cocomment == 0)){
			er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
			theme_foot();
			exit;
		}

		// get data
		$ccom	= $tb->SelectWhere('comment_id',$id,'','');
		$ccom	= $ccom->current();

		$tbluser 	= new ElybinTable('elybin_users');
		$cuser	= $tbluser->SelectWhere('user_id',$ccom->user_id,'','');
		$cuser	= $cuser->current();

		if($ccom->user_id > 0){
			$author = $cuser->fullname;
			$email = $cuser->user_account_email;
		}else{
			$author = $ccom->author;
			$email = $ccom->email;
		}

		$content = html_entity_decode($ccom->content);
		$date = time_elapsed_string($ccom->date." ".$ccom->time);

		if($ccom->post_id > 0){
			$di = $lg_post;
			$tbp 	= new ElybinTable('elybin_posts');
			$last	= $tbp->SelectWhere('post_id',$ccom->post_id,'','');
			$ptitle = $last->current();
			$ptitle = $ptitle->title;
		}
		elseif($ccom->gallery_id > 0){
			$di = $lg_photo;
			$tbp 	= new ElybinTable('elybin_gallery');
			$last	= $tbp->SelectWhere('gallery_id',$ccom->gallery_id,'','');
			$ptitle = $last->current();
			$ptitle = $ptitle->name;
		}
?>

							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-external-link-square"></i>&nbsp;&nbsp;<?php echo $lg_detailtitle?></h4>
							</div>
							<div class="modal-body">
								<table class="table">
									<tr>
										<td><i><?php echo $lg_commenton?></i></td>
										<td><?php echo $di?> - <?php echo $ptitle?></td>
									</tr>	
									<tr>
										<td><i><?php echo $lg_authorname?></i></td>
										<td><?php echo $author?></td>
									</tr>		
									<tr>
										<td><i><?php echo $lg_from?></i></td>
										<td><?php echo $email?></td>
									</tr>
									<tr>
										<td><i><?php echo $lg_date?></i></td>
										<td><?php echo $date?></td>
									</tr>
									<tr>
										<td><i><?php echo $lg_content?></i></td>
										<td><?php echo $content?></td>
									</tr>
								</table>
								<hr></hr>
								<div class="form-group no-margin-b">
									<button class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></button>
								</div>
							</div>

<?php

			break;

		case 'edit';
		$id 	= $v->xss(@$_GET['id']);
		$id 	= $v->sql($id);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_comments');
		$cocomment = $tb->GetRow('comment_id', $id);
		if(empty($id) OR ($cocomment == 0)){
			er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
			theme_foot();
			exit;
		}

		// get data
		$ccomment	= $tb->SelectWhere('comment_id',$id,'','');
		$ccomment	= $ccomment->current();

		$tbluser 	= new ElybinTable('elybin_users');
		$cuser	= $tbluser->SelectWhere('user_id',$ccomment->user_id,'','');
		$cuser	= $cuser->current();

		if($ccomment->user_id > 0){
			$author = $cuser->fullname;
			$email = $cuser->user_account_email;
			$disabled = ' disabled="disabled"';
			$infop = '<p class="help-block">'.$lg_dataautomaticfrom.'</p>';
		}else{
			$author = $ccomment->author;
			$email = $ccomment->email;
			$disabled = "";
			$infop = "";
		}
		$content = html_entity_decode($ccomment->content);
		if($ccomment->post_id){
			$di = $lg_post;
		}
		elseif($ccomment->gallery_id){
			$di = $lg_photo;
		}
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo $lg_interaction?> / <?php echo $lg_comment?> / </span><?php echo $lg_editcomment?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">

				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-comments"></i>&nbsp;&nbsp;<?php echo $lg_editcurrentcomment?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_commenton?></label>
					      <div class="col-sm-10">
					      	<input type="text" value="<?php echo $di?>" class="form-control" placeholder="<?php echo $lg_commenton?>" disabled="disabled"/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_authorname?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="author" value="<?php echo $author?>" class="form-control" placeholder="<?php echo $lg_authorname?>"<?php echo $disabled?>/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_email?>*</label>
					      <div class="col-sm-10">
					      	<input type="email" name="email" value="<?php echo $email?>" class="form-control" placeholder="<?php echo $lg_email?>"<?php echo $disabled?>/>
					      	<?php echo $infop?>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_content?>*</label>
					      <div class="col-sm-10">
					      	<textarea name="content" cols="50" rows="5" class="form-control" id="text-editor" placeholder="<?php echo $lg_content?>"><?php echo $content?></textarea>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_status?></label>
					      <div class="col-sm-10">
					      	<input type="checkbox" name="status" class="form-control" id="switcher-style" <?php if($ccomment->status=='active'){echo 'checked="checked"';}?>>
					      	<p class="help-block"><span class="fa fa-check"></span>&nbsp;<?php echo $lg_approve?>&nbsp;<span class="fa fa-times"></span>&nbsp;<?php echo $lg_decline?></p>
	      				</div>
					  </div> <!-- / .form-group -->
					</div><!-- / .panel-body -->


					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savechanges?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="comment_id" value="<?php echo $ccomment->comment_id?>" />
						  <input type="hidden" name="act" value="edit" />
						  <input type="hidden" name="mod" value="comment" />
					  </div> <!-- / .form-footer -->
				</form><!-- / .form -->
				<!-- Help modal -->
				<div id="help" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
								<h4 class="modal-title"><?php echo $lg_helptitle?></h4>
							</div>
							<div class="modal-body">...</div>
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / Help modal -->
			</div><!-- / .col -->
		</div><!-- / .row -->

<!-- Javascript -->
<script>
init.push(function () {
	$('#switcher-style').switcher({
		theme: 'square',
		on_state_content: '<span class="fa fa-check"></span>',
		off_state_content: '<span class="fa fa-times"></span>'
	});
	$('#tooltip a, #tooltipl').tooltip();

	$().ajaxStart(function() {
		$.growl({ title: "Loading", message: "Writing..." });
	}).ajaxStop(function() {
		$.growl({ title: "Success", message: "Success" });
	});

	<?php
		// getting text_editor
		$tblo = new ElybinTable('elybin_options');
		$editor_id = $tblo->SelectWhere('name','text_editor','','');
		foreach ($editor_id as $op) {
			$editor = $op->value;
		}
		if($editor=='summernote'){
	?>
	//summernote editor
	if (! $('html').hasClass('ie8')) {
		$('#text-editor').summernote({
			height: 200,
			tabsize: 2,
			codemirror: {
				theme: 'monokai'
			}
		});
	}
	<?php 
		}
		elseif($editor=='bs-markdown'){
	?>
	if (! $('html').hasClass('ie8')) {
		$("#text-editor").markdown({ iconlibrary: 'fa' });
	}
	<?php } ?>

	//ajax
	$('#form').submit(function() {
		$.ajax({
			type: 'POST',
			url: $(this).attr('action'),
			data: $(this).serialize(),
			success: function(data) {
				data = explode(",",data);
				console.log(data);
				if(data[0] == "ok"){
					$.growl.notice({ title: data[1], message: data[2] });
					window.location.href="?mod=comment";
				}
				else if(data[0] == "error"){
					$.growl.warning({ title: data[1], message: data[2] });
				}
				

			}
		})
		return false;
	});

});
</script>
<!-- / Javascript -->
<?php
		break;

	case 'del':
?>

							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?php echo $lg_deletetitle?></h4>
							</div>
							<div class="modal-body">
								<?php echo $lg_deletequestion?>
								<hr></hr>
								<form action="<?php echo $action?>" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_yesdelete?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal" onClick="hide_modal();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_cancel?></a>
									<input type="hidden" name="comment_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="comment" />
								</form>
							</div>
<?php
			break;

		case 'approve':
			$comment_id = $v->sql(@$_GET['id']);

			// check id exist or not
			$tbl 	= new ElybinTable('elybin_comments');
			$cocomment = $tbl->GetRow('comment_id', $comment_id);
			if(empty($comment_id) OR ($cocomment == 0)){
				er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
				theme_foot();
				exit;
			}

			$cstatus = $tbl->SelectWhere('comment_id',$comment_id,'','');
			$cstatus = $cstatus->current();
			if($cstatus->status == 'active'){
				$status = 'deactive';
			}else{
				$status = 'active';
			}
			
			$data = array(
				'status' => $status	
				);
			$tbl->Update($data,'comment_id',$comment_id);
			ElybinRedirect('./admin.php?mod='.$mod);
			break;

		//
		default:
		$tb 	= new ElybinTable('elybin_comments');
		$lcomment	= $tb->Select('comment_id','DESC');
		$no = 1;

?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-comments"></i>&nbsp;&nbsp;<?php echo $lg_comment?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo $lg_comment?> / </span><?php echo $lg_all?></span>
				</h1>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<!-- Search Bar -->
						<form action="#" class="pull-right col-xs-12 col-sm-6 col-md-8">
							<div class="input-group no-margin">
								<span class="input-group-addon" style="border:none;background: #fff;background: rgba(0,0,0,.05);"><i class="fa fa-search"></i></span>
								<input id="search" placeholder="<?php echo $lg_search?>..." class="form-control no-padding-hr" style="border:none;background: #fff;background: rgba(0,0,0,.05);" type="text">
							</div>
						</form>
					</div>
				</div>
			</div>
		</div> <!-- ./Page Header -->
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form action="<?php echo $action?>" method="post" class="panel">
					<input type="hidden" name="act" value="multidel" />
					<input type="hidden" name="mod" value="comment" />
					
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-comments hidden-xs">&nbsp;&nbsp;</i><?php echo $lg_allcomment?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div> 
					<!-- ./Panel Heading -->
					
					<div class="panel-body">
					  <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
					  <div class="table-responsive">
						<table class="table table-hover" id="results">
						 <thead>
						  <tr>
						    <th>#</th>
						    <th><i class="fa fa-check-square" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_checkall?>"></i></th>
						    <th><?php echo $lg_photo?></th>
						    <th><?php echo $lg_authorname?></th>
						    <th><?php echo $lg_commenton?></th>
						    <th><?php echo $lg_date?></th>
						    <th><?php echo $lg_status?></th>
						    <th><?php echo $lg_action?></th>
						  </tr>
						</thead>
						<tbody>
						<?php
						foreach($lcomment as $com){
							if($com->post_id > 0){
								$di = $lg_post;
								$tbp 	= new ElybinTable('elybin_posts');
								$last	= $tbp->SelectWhere('post_id',$com->post_id,'','');
								$ptitle = $last->current();
								$ptitle = @$ptitle->title;
							}
							elseif($com->gallery_id > 0){
								$di = $lg_photo;
								$tbp 	= new ElybinTable('elybin_gallery');
								$last	= $tbp->SelectWhere('gallery_id',$com->gallery_id,'','');
								$ptitle = $last->current();
								$ptitle = $ptitle->name;
							}
							
							if($com->status == 'active'){
								$status = $lg_decline;
								$link = '<i class="fa fa-ban"></i>';
							}else{
								$status = $lg_approve;
								$link = '<i class="fa fa-check"></i>';	
							}

							if($com->user_id > 0){
								$tbuser = new ElybinTable('elybin_users');
								$cuser	= $tbuser->SelectWhere('user_id',$com->user_id,'','');
								$cuser = $cuser->current();
								$avatar = $cuser->avatar;
								$author = $cuser->fullname;
								$email = $cuser->user_account_email;
							}else{
								$avatar = "default/medium-no-ava.png";
								$author = $com->author;
								$email = $com->email;
							}
							$date = time_elapsed_string($com->date." ".$com->time);
						?>
						<tr>
						    <td><?php echo $no?></td>
						    <td><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo $com->comment_id?>|<?php echo $author?>"><span class="lbl"></span></label></td>
						    <td><img src="../elybin-file/avatar/<?php echo $avatar?>" alt="Foto" class="rounded" style="width:30px;height:30px;"/></td>
						    <td><a href='mailto:<?php echo $email?>'><?php echo $author?></a></td>
						    <td><?php echo $di?> - <?php echo $ptitle?></td>
						    <td><?php echo $date?></td>
						    <td><?php echo $com->status?></td>
						    <td>
								<div id="tooltip">
									<a href="?mod=comment&amp;act=approve&amp;id=<?php echo $com->comment_id?>" class="btn btn-success btn-outline btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $status?>"><?php echo $link?></a>
									<a href="?mod=comment&amp;act=view&amp;id=<?php echo $com->comment_id?>&amp;clear=yes" class="btn btn-success btn-outline btn-sm" id="view-link" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_view?>"><i class="fa fa fa-external-link-square"></i></a>
									<a href="?mod=comment&amp;act=edit&amp;id=<?php echo $com->comment_id?>" class="btn btn-success btn-outline btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_edit?>"><i class="fa fa-pencil-square-o"></i></a>
							    	<a href="?mod=comment&amp;act=del&amp;id=<?php echo $com->comment_id?>&amp;clear=yes" class="btn btn-danger btn-outline btn-sm" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo $lg_delete?>"><i class="fa fa-times"></i></a>
								</div>
						    </td>
						</tr>
						<?php
							$no++;
						}
						?>
			
						 </tbody>
						</table>
					  </div> <!-- /.table-responsive -->
						<div class="alert" id="notfound"><strong><?php echo $lg_nodatafound?></strong></div>
						<hr/>
						<!-- Multi Delete Modal -->
						<div id="deleteall" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
							<div class="modal-dialog modal-sm">
								<div class="modal-content">
									<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
									<h4 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?php echo $lg_deletetitle?></h4>
									</div>
									<div class="modal-body">
										<?php echo $lg_deletequestion?>
										<div id="deltext"></div>
										<hr/>
										<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_yesdelete?></button>
										<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_cancel?></a>
									</div>
								</div> <!-- / .modal-content -->
							</div> <!-- / .modal-dialog -->
						</div> <!-- / .modal -->
						<!-- / Multi Delete Modal -->
						<div class="col-md-3">
							<button class="btn btn-danger btn-sm" id="delall" data-toggle="modal" data-target="#deleteall"><i class="fa fa-times"></i>&nbsp;&nbsp;<?php echo $lg_deleteselected?></button>
						</div>
						<div class="col-md-4 col-md-offset-5 text-right">
							<ul class="pagination pagination-xs" id="page-nav">
							</ul>
						</div>
					</div><!-- / .panel-body -->
				</form>
				<!-- Delete Modal -->
				<div id="delete" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<?php echo $lg_loading?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- View Modal -->
				<div id="view" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<?php echo $lg_loading?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / View Modal -->
				<!-- Help modal -->
				<div id="help" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
								<h4 class="modal-title"><?php echo $lg_helptitle?></h4>
							</div>
							<div class="modal-body">
								...
							</div>
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / Help modal -->
			</div><!-- / .col -->
		</div><!-- / .row -->
<!-- Javascript -->
<script>
init.push(function () {
	$('#tooltip a, #tooltipc, #tooltip-ck').tooltip();	
});

ElybinView();
ElybinPager();
ElybinSearch();
ElybinCheckAll();
countDelData();
</script>
<!-- / Javascript -->

<?php
		break;
		}
	}
}
?>
