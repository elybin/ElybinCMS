<?php
/* Short description for file
 * Module: Messager
 *	
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System 
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 ----------------
 1.1.3 
 - Module Contact changed to Messanger
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
// string validation for security
$v 	= new ElybinValidasi();

//start here
$v 	= new ElybinValidasi();
switch (@$_GET['act']) {
	case 'compose':
		$to = @$_SESSION['to'];
		$subject = @$_SESSION['subject'];
		$body = @$_SESSION['body'];
?>
		<!-- help -->
		<div class="page-header hide-light" id="help-panel">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=messager"><?php echo lg('Messanger') ?></a></li>
			<li class="active"><a href="?mod=messager&amp;act=compose"><?php echo lg('Compose') ?></a></li>
			
			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=messager" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to Messanger') ?></a>
			<h1><?php echo lg('Compose Message') ?></h1>
		</div> <!-- / .page-header -->
	
		<?php
			// 1.1.3
			// msg
			if(@$_GET['msg'] == 'sent'){
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Message Sent Successfully.') . '</div>';
			}
			else if(@$_GET['err'] == 'invalid_email'){
				echo '<div class="note note-danger depth-xs"><i class="fa fa-warning"></i> ' . lg('Invalid recipient. Please check again.') . '</div>';
			}
			else if(@$_GET['err'] == 'fill_body'){
				echo '<div class="note note-danger depth-xs"><i class="fa fa-warning"></i> ' . lg('You forgot the body message?') . '</div>';
			}
			else if(@$_GET['err'] == 'fill_recipient'){
				echo '<div class="note note-danger depth-xs"><i class="fa fa-warning"></i> ' . lg('Please enter the recipient.') . '</div>';
			}
		?>

		<style><?php include("assets/stylesheets/jquery-ui.css"); ?></style>
		<style><?php include("assets/stylesheets/jquery.tagsinput.min.css"); ?></style>
		<style>
.ui-menu-item{ font-size: 14px;padding: 5px;}
.ui-menu-item:before{ content: 'Send to: ';   border: 1px solid #5ebd5e; background-color: #f4faf2; color; #000; border-radius: 3px; padding: 3px 4px;margin: 5px 8px 5px -5px;}
.ui-autocomplete{position: relative; margin-top: 30px !important; margin-top: 10px;margin-left: 14px !important; width: 500px; box-shadow: 1px 1px 5px rgba(0,0,0,.2)}
.ui-autocomplete-input{width: 300px !important}
</style>
		<form action="app/messager/proses.php" method="post" enctype="multipart/form-data" id="form">
			<div class="row">
				<div class="col-sm-9">
					<div class="form-horizontal panel-wide" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.05); ">
						<div class="panel-body">
							<div class="form-group">
							  <div class="col-sm-12">
							  	<b><?php echo lg('To:') ?> <span id="tags_loading" class="hide-light"></span></b>
							  	
								<input type="text" name="to"  id="recipient_pick" class="form-control" placeholder="<?php echo lg('Type E-mail or Name...') ?>" value="<?php echo $to ?>"/>
							  </div>
							</div> <!-- / .form-group -->
							<div class="form-group">
							  <div class="col-sm-12">
							  	<b><?php echo lg('Subject:') ?></b>
								<input type="text" name="subject" class="form-control" placeholder="<?php echo lg('Subject') ?>" value="<?php echo $subject ?>"/>
							  </div>
							</div> <!-- / .form-group -->
							<div class="form-group">
							  <div class="col-sm-12">
							  	<b><?php echo lg('Message Body:') ?></b>
								<?php
								// getting text_editor
								if(op()->text_editor == 'summernote'){
									echo '<style>'; include("assets/stylesheets/summernote.css"); echo '</style>';
								}
								else if(op()->text_editor == 'bs-markdown'){
									echo '<style>';include("assets/stylesheets/markdown.css"); echo '</style>';
								} 
								?>	
								<div id="summernote-progress" class="hide-light">
									<p><?php echo lg('Uploading Images...') ?>  <span>1%</span></p>
									<div class="progress progress-striped">
										<div class="progress-bar progress-bar-success" style="width: 1%"></div>
									</div>
								 </div>
								<textarea name="body" cols="50" rows="20" class="form-control" id="text-editor" placeholder="<?php lg('Page content here...')?>"><?php echo $body ?></textarea>
							  </div>
							</div> <!-- / .form-group -->

						  </div><!-- / .panel-body -->
					</div>
				</div><!-- / .col -->				
				<div class="col-sm-3">
					<div class="panel-body text-center" style="box-shadow: 2px 1px 5px rgba(0,0,0,0.1); margin-bottom: 2px;">
						<button type="submit" value="Submit" class="btn btn-success btn-lg"><i class="fa fa-location-arrow"></i>&nbsp;<?php echo lg('Send Message') ?></button>

						<br/>						
						<!-- auto save -->
						<div id="autosave" class="text-sm text-light-gray hide-light">
							<i>  <?php echo lg('Saving...') ?></i>
						</div>
					</div>
				</div><!-- / .col -->
				
				<input type="hidden" name="act" value="compose" />
				<input type="hidden" name="mod" value="messager" />
			</form><!-- / .form -->
		</div><!-- / .row -->
<?php
			break;

		case 'view':

		$mid 	= $v->sql(epm_decode(@$_GET['hash']));

		// declare table
		$tb = new ElybinTable('elybin_message');

		// get current active user
		$u = _u();

		// get all data
		// single query
		$cm	= $tb->SelectFullCustom("
		SELECT
		*,
		COUNT(`mid`) as `row`
		FROM
		`elybin_message` as `m`
		WHERE
		(`m`.`to_uid` = '".$u->user_id."' || `m`.`from_uid` = '".$u->user_id."') &&
		`m`.`mid` = '$mid'
		LIMIT 0,1
		")->current();
		
		if($cm->row < 1){
			// show error
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}

		// change status_recp = 'read'
		if($cm->to_uid == $u->user_id){
			$d = array(
				'msg_status_recp' => 'read'
				);	
			$tb->Update($d, 'mid', $mid);
		}
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-envelope"></i>&nbsp;&nbsp;<?php echo lg('Message Detail')?></h4>
							</div>
							<div class="modal-body">
								<table class="table">
									<tr>
										<td width="15%"><i><?php echo lg('From')?></i></td>
										<td><?php echo $cm->from_name?><br/>
											<i class="text-xs text-light-gray">(<?php echo $cm->from_email?>)</i>
										</td>
									</tr>
									<tr>
										<td><i><?php echo lg('Date')?></i></td>
										<td><?php echo $cm->msg_date?>
											<br/>
											<i class="text-xs text-success">
											<?php 
											// resp status
											if($cm->from_uid == $u->user_id){
												// check read
												if($cm->msg_status_recp == 'received' || $cm->msg_status_recp == 'deleted'){
													$status =  '<i class="fa fa-check"></i> '.lg('Sent').' ';
												}
												else if($cm->msg_status_recp == 'read'){
													$status =  '<span class="badge badge-success">R</span> '.lg('Read').' ';
												}
											}else{
												// check read
												$status =  '<span class="badge badge-success">R</span> '.lg('Read').' ';
											}
											echo $status;
											?>
										</i>
											<i class="text-xs text-light-gray">(<?php echo time_elapsed_string($cm->msg_date)?>)</i>
										</td>
									</tr>
									<tr>
										<td><i><?php echo lg('Subject')?></i></td>
										<td><?php echo $cm->subject?></td>
									</tr>
									<tr>
										<td><i><?php echo lg('Message Body')?></i></td>
										<td><?php echo htmlspecialchars($cm->msg_body)?></td>
									</tr>
								</table>
								<hr/>
								<form class="" action="app/messager/proses.php" method="post" id="form-quick">
									<div class="form-group">
									  <div class="col-sm-12">	
									  	<?php
									  	// if comment have replied
									  	if($cm->from_uid !== _u()->user_id){
									  	?>	
									  	<br/>
									  	<a href="?mod=messager&amp;act=reply&amp;hash=<?php echo @$_GET['hash'] ?>" class="pull-right"><i class="fa fa-pencil"></i> <?php echo lg('Advanced Reply') ?></a>
									  	<h4><?php echo lg('Quick Reply') ?></h4>
										<textarea name="body" cols="50" rows="7" class="form-control" id="text-editor" placeholder="<?php echo lg('Your comment here...')?>"></textarea>
										<br/>
										<button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Send Reply')?></button>&nbsp;
										<a href="?mod=messager&amp;act=del&amp;hash=<?php echo @$_GET['hash'] ?>&amp;clear=yes" class="btn btn-danger" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo lg('Delete Permanently') ?>"><i class="fa fa-trash-o"></i><i class="fa fa-times"></i>&nbsp;<?php echo lg('Delete') ?></a>
										<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>
									 

										<input type="hidden" name="hash" value="<?php echo @$_GET['hash'] ?>" />
										<input type="hidden" name="act" value="reply" />
										<input type="hidden" name="mod" value="messager" />
										</div>
									  	<?php 
									  	} ?>
									</div> <!-- / .form-group -->
								</div>
							</div>
<script type="text/javascript">ElybinView();</script>
<?php

			break;
		case 'reply';
		$mid 	= $v->sql(epm_decode(@$_GET['hash']));
		
		// declare table
		$tb = new ElybinTable('elybin_message');
		
		// get current active user
		$u = _u();

		// single query
		// get all data
		$cm	= $tb->SelectFullCustom("
		SELECT
		*,
		COUNT(`mid`) as `row`
		FROM
		`elybin_message` as `m`
		WHERE
		`m`.`to_uid` = '".$u->user_id."' && 
		`m`.`from_uid` != '".$u->user_id."' &&
		`m`.`mid` = '$mid'
		LIMIT 0,1
		")->current();
		
		// check existance
		if($cm->row < 1){
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}

		
		// change status_recp = 'read'
		if($cm->to_uid == $u->user_id){
			$d = array(
				'msg_status_recp' => 'read'
				);	
			$tb->Update($d, 'mid', $mid);
		}
?>
		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=messager"><?php echo lg('Message') ?></a></li>
			<li class="active"><a href="?mod=messager&amp;act=reply&amp;hash=<?php echo @$_GET['hash']; ?>"><?php echo lg('Reply Message') ?></a></li>
			
			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=messager" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to Message') ?></a>
			<h1><?php echo lg('Reply Message') ?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<?php
			// 1.1.3
			if(@$_GET['msg'] == 'sent'){
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Your reply successfully sent.') . '</div>';
			}
		?>
				
		<form class="" action="app/messager/proses.php" method="post" id="form">
			<div class="row">
				<div class="col-sm-offset-1 col-sm-10">
					<div class="form-horizontal panel-wide depth-sm" style="margin-bottom: 5px">
						<div class="panel-body">
							<!-- comment block -->
							<div class="panel-body depth-md" style="margin-bottom: 10px">
								<p><b class="text-bg"><?php echo $cm->from_name ?></b> &nbsp;<i class="text-light-gray">(<?php echo $cm->from_email ?>)</i></b></p>
								<p><?php echo htmlspecialchars($cm->msg_body)?></p>
								<span class="text-right text-xs text-light-gray"><?php echo time_elapsed_string($cm->msg_date)?></span>
							</div>
							
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
								<textarea name="body" cols="50" rows="10" class="form-control" id="text-editor" placeholder="<?php echo $lg_content?>"></textarea>
								<br/>
								<button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Send Reply')?></button>
							 </div>
							  
							</div> <!-- / .form-group -->

						  </div><!-- / .panel-body -->
					</div>
				</div><!-- / .col -->

				<input type="hidden" name="hash" value="<?php echo @$_GET['hash']; ?>" />
				<input type="hidden" name="act" value="reply" />
				<input type="hidden" name="mod" value="messager" />
				
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
								<form action="app/messager/proses.php" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Delete')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									<input type="hidden" name="hash" value="<?php echo @$_GET['hash']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="messager" />
								</form>
							</div>
<?php
			break;
		
	default:
	$tb 	= new ElybinTable('elybin_message');

	$search = $v->sql(@$_GET['search']);	
		
	// search
	if(isset($_GET['search'])){
		$multiquery = @explode(":", @$search);
		if($multiquery[0] == 'tag'){
			$s_q = " && (`m`.`tag` LIKE '%".$multiquery[1]."%')";
		}else{
			$s_q = " && (`m`.`subject` LIKE '%$search%' || `m`.`msg_body` LIKE '%$search%' || `m`.`from_email` LIKE '%$search%' || `m`.`from_name` LIKE '%$search%')";
		}
	}else{
		$s_q = "";
	}
	
	// get current active user
	$u = _u();

	// 1.1.3
	if(isset($_GET['filter']) && @$_GET['filter'] == 'unread'){
		// unread query
		$que = "
		SELECT
		*
		FROM
		`elybin_message` as `m`
		WHERE
		`m`.`to_uid` = '".$u->user_id."' &&
		`m`.`msg_type` = 'message' &&
		`m`.`msg_status_recp` = 'received'
		$s_q
		";
	}
	else if(isset($_GET['filter']) && @$_GET['filter'] == 'sent'){
		// sent query (outbox)
		$que = "
		SELECT
		*
		FROM
		`elybin_message` as `m`
		WHERE
		`m`.`from_uid` = '".$u->user_id."'	&&
		`m`.`msg_status` != 'deleted'
		$s_q
		";
	}
	else if(isset($_GET['filter']) && @$_GET['filter'] == 'feedback' && $u->user_id == 1){
		// sent query
		$que = "
		SELECT
		*
		FROM
		`elybin_message` as `m`
		WHERE
		`m`.`to_uid` = '".$u->user_id."'  &&
		`m`.`msg_type` = 'feedback'
		$s_q
		";
	}
	else{
		// default query placed bottom, so the query will still execute whatever no paramater set
		// normal query (inbox)
		$que = "
		SELECT
		*
		FROM
		`elybin_message` as `m`
		WHERE
		`m`.`to_uid` = '".$u->user_id."' &&
		`m`.`msg_type` = 'message' &&
		(`m`.`msg_status_recp` = 'received' || `m`.`msg_status_recp` = 'read' || `m`.`msg_status_recp` = 'replied') && 
		`m`.`msg_status_recp` != 'deleted'
		$s_q
		";
	}

	
	$com = $tb->GetRowFullCustom($que);
	// modify query to pageable & shortable
	$oarr = array(
		'default' => '`m`.`mid` DESC',
		'priority' => '`m`.`msg_priority`',
		'status' => '`m`.`msg_status`',
		'date' => '`m`.`msg_date`'
	);
	$que = _PageOrder($oarr, $que);
	$lme	= $tb->SelectFullCustom($que);

	//echo '<pre>'.$que.'</pre>';
?>
		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray"><?php echo lg('You are here:') ?></div>
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li class="active"><a href="?mod=messager"><?php echo lg('Message') ?></a></li>
			
			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-envelope"></i>&nbsp;&nbsp;<?php echo lg('Message')?></span>
					<span class="hidden-xs"><?php echo lg('Message') ?></span>
					<?php if($search!==''){ echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-light-gray text-sm">'.lg('Search result for').' <i>&#34;'.$search.'&#34;</i>';} ?>
				</h1>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<div class="pull-right col-xs-12 col-sm-6 col-md-4">	
							<a href="?mod=messager&amp;act=compose" class="pull-right btn btn-success btn-labeled" style="width: 100%">
							<span class="btn-label icon fa fa-plus"></span>&nbsp;&nbsp;<?php echo lg('Compose')?></a>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- ./Page Header -->
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">	
				<!-- Tabs -->
				<ul class="nav nav-tabs nav-tabs-xs">
					<li<?php if(!isset($_GET['filter'])){echo' class="active"'; }?>>
						<?php 
						// count all post
						$totall = $tb->GetRowFullCustom("
						SELECT
						*
						FROM
						`elybin_message` as `m`
						WHERE
						`m`.`to_uid` = '".$u->user_id."' &&
						`m`.`msg_type` = 'message' &&
						(`m`.`msg_status_recp` = 'received' || `m`.`msg_status_recp` = 'read' || `m`.`msg_status_recp` = 'replied') && 
						`m`.`msg_status_recp` != 'deleted'
						");
						?>
						<a href="?mod=messager"><?php echo lg('Inbox') ?> <span class="badge badge-default"><?php echo $totall ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='unread'){echo' class="active"'; }?>>
						<?php 
						// count all page
						$toturm = $tb->GetRowFullCustom("
						SELECT
						*
						FROM
						`elybin_message` as `m`
						WHERE
						`m`.`to_uid` = '".$u->user_id."' &&
						`m`.`msg_type` = 'message' &&
						`m`.`msg_status_recp` = 'received'
						");
						?>
						<a href="?mod=messager&amp;filter=unread"><?php echo lg('Unread') ?> <span class="badge badge-info"><?php echo $toturm ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='sent'){echo' class="active"'; }?>>
						<?php 
						// count all post
						$totsm = $tb->GetRowFullCustom("
						SELECT
						*
						FROM
						`elybin_message` as `m`
						WHERE
						`m`.`from_uid` = '".$u->user_id."'	&&
						`m`.`msg_status` != 'deleted'
						");
						?>
						<a href="?mod=messager&amp;filter=sent"><?php echo lg('Outbox') ?> <span class="badge badge-success"><?php echo $totsm ?></span></a>
					</li>
					<?php
					// show only have access
					if($u->user_id == 1){
					?>
					<li<?php if(@$_GET['filter']=='feedback'){echo' class="active"'; }?>>
						<?php 
						// count all post
						$totfb = $tb->GetRowFullCustom("
						SELECT
						*
						FROM
						`elybin_message` as `m`
						WHERE
						`m`.`to_uid` = '".$u->user_id."'  &&
						`m`.`msg_type` = 'feedback'
						");
						?>
						<a href="?mod=messager&amp;filter=feedback"><?php echo lg('Feedback') ?> <span class="badge badge-warning"><?php echo $totfb ?></span></a>
					</li>
					<?php } ?>
				</ul> <!-- / .nav -->
				<!-- Panel -->
				<div class="panel">
					<!-- ./Panel Heading -->
					<div class="panel-body">
					  <div class="table-primary table-responsive">
						
						<?php
						// show sorting box
						showOrder(array(
							'priority' => lg('Priority'),
							'status' => lg('Status'),
							'date' => lg('Date')
							));
						showSearch();
						?>
						<!-- delate -->
						<form action="app/messager/proses.php" method="post">
						<input type="hidden" name="act" value="multidel" />
						<input type="hidden" name="mod" value="messager" />
						
						<table class="table table-bordered table-striped" id="results">
						 <thead>
						   <tr>
						    <th width="1%"><i class="fa fa-square" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo lg('Check All')?>"></i></th>
						    <th width="10%">
						    <?php 
						    // diiferent in diferent tab
						    if(@$_GET['filter'] == 'sent'){
						    	echo lg('To');
						    }else{
						    	echo lg('From');
						    }
						    ?>
							</th>
						    <th><?php echo lg('Subject') ?></th>
						    <th width="20%"><?php echo lg('Date') ?></th>
						    <th width="10%"><?php echo lg('Status') ?></th>
						    <th width="15%"><?php echo lg('Action')?></th>
						   </tr>
						 </thead>
						 <tbody>
						<?php

						$no = 0;
						foreach($lme as $cm){
						?>
						   <tr>
							<td><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo epm_encode($cm->mid)?>|<?php echo htmlspecialchars($cm->subject) ?>"><span class="lbl"></span></label></td>
							<td>
						    <?php 
						    // diiferent in diferent tab
						    if(@$_GET['filter'] == 'sent'){
						    	// get specific user
						    	$t = _u($cm->to_uid);
						    	echo $t->fullname.'<br/>';
								echo '<i class="text-xs text-light-gray">'.$t->user_account_email.'</i>';
							}else{
								echo $cm->from_name.'<br/>';
								echo '<i class="text-xs text-light-gray">'.$cm->from_email.'</i>';
							}
							?></td>
							<td><?php echo $cm->subject?></td>
							<td><?php echo friendly_date($cm->msg_date)?><br/>
								<i class="text-xs text-light-gray"><?php echo time_elapsed_string($cm->msg_date)?></i>
							</td>							
							<td>
							<i class="text-xs text-success">
							<?php 
							// resp status
							if(@$_GET['filter'] == 'sent'){
								// check read
								if($cm->msg_status_recp == 'received' || $cm->msg_status_recp == 'deleted'){
									$status =  '<i class="fa fa-check"></i> '.lg('Sent').' ';
								}
								else if($cm->msg_status_recp == 'read'){
									$status =  '<span class="badge badge-success">R</span> '.lg('Read').' ';
								}
							}else{
								// check read
								if($cm->msg_status_recp == 'received'){
									$status =  '<span class="badge badge-info">U</span> '.lg('Unread').' ';
								}
								else
								if($cm->msg_status_recp == 'replied'){
									$status =  '<span class="badge badge-default"><i class="fa fa-check"></i></span> <span class="text-light-gray">'.lg('Replied').'</span> ';
								}
								else{
									$status =  '<span class="badge badge-success">R</span> '.lg('Read').' ';
								}
							}
							echo @$status;
							?>
							</i></td>
							<td>
								<div id="tooltip">
						    		<?php 
						    		echo '<a href="?mod=messager&amp;act=view&amp;hash='.epm_encode($cm->mid).'&amp;clear=yes" class="btn btn-success btn-outline btn-sm" data-toggle="modal" data-target="#view" data-placement="bottom" data-toggle="tooltip" data-original-title="'.lg('Detail').'"><i class="fa fa-external-link"></i></a>&nbsp;';
									// reply only shown in inbox
						    		if((!isset($_GET['filter']) || @$_GET['filter'] == 'feedback') && $cm->from_uid !== $u->user_id){
										echo '<a href="?mod=messager&amp;act=reply&amp;hash='.epm_encode($cm->mid).'" class="btn btn-success btn-outline btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="'.lg('Reply').'"><i class="fa fa-mail-reply"></i></a>&nbsp;';
									}
									echo '<a href="?mod=messager&amp;act=del&amp;hash='.epm_encode($cm->mid).'&amp;clear=yes" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="'.lg('Delete Permanently').'"><i class="fa fa-trash-o"></i><i class="fa fa-times"></i></a>';
									?>
								</div>
							</td>
						   </tr>
						<?php
							$no++;
						}
						
						
						if($no < 1){
							echo '<tr><td colspan="6"><div class="text-center text-light-gray panel-padding"><i class="fa fa-5x fa-envelope"></i><br/>'. lg('Nothing can be shown.').'</div></td></tr>';
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
						
						
						
						<?php showPagging($com) ?>
						
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
?>
