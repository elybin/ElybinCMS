<?php
/* Short description for file
 * [ Module: Media
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
if(!isset($_SESSION['login'])){
	// new redirect
	header('location: ../../../403.html');
	exit;
}else{
// declare action
$modpath 	= "app/media/";
$action		= $modpath."proses.php";

// string validation for security
$v 	= new ElybinValidasi();

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->media;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	// start here
	switch (@$_GET['act']) {
		case 'add':
?>
		<!-- help -->
		<div class="page-header hide-light" id="help-panel">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=media"><?php echo lg('Library') ?></a></li>
			<li class="active"><a href="?mod=media&amp;act=add"><?php echo lg('Uplaod to Library') ?></a></li>

			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=media" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to Library') ?></a>
			<h1><?php echo lg('Upload to Library') ?></h1>
		</div> <!-- / .page-header -->

		<form action="<?php echo $action ?>" method="post" id="form" enctype="multipart/form-data">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-horizontal panel-wide depth-panel">
						<div class="panel-body">
							<div class="form-group">
							  <div class="col-sm-12 col-md-5">
								<input type="file" name="file" class="form-control" id="file-style" required/>
							  </div>
							  <div class="col-sm-12">
								<p class="help-block"><?php echo lg('Allowed file type:')?> (jpg, jpeg, png, svg, xls, xlsx, ppt, pptx, txt, doc, docx, pdf, rar, zip, mp3)</p>
							  </div>
							</div> <!-- / .form-group -->
						</div>
						<div class="panel-footer">
							<button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save Data')?></button>
							<a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>
							<input type="hidden" name="act" value="add" />
							<input type="hidden" name="mod" value="media" />
						</div> <!-- / .form-footer -->
					</div>
				</div><!-- / .col -->
			</div>
		</form>
<?php
			break;

		case 'addmulti':
?>
		<!-- help -->
		<div class="page-header hide-light" id="help-panel">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=media"><?php echo lg('Library') ?></a></li>
			<li class="active"><a href="?mod=media&amp;act=addmulti"><?php echo lg('Multiple Upload') ?></a></li>

			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=media" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to Library') ?></a>
			<h1><?php echo lg('Multiple Upload') ?></h1>
		</div> <!-- / .page-header -->

			<div class="row">
				<div class="col-sm-12">
					<div class="form-horizontal panel-wide depth-panel">
						<div class="panel-body">
							<style><?php include('assets/stylesheets/dropzone.min.css') ?>
							.dropzone {border: 2px dashed rgba(0,0,0,0.3);border-radius: 10px;}
							.dz-message span{font-size:20px;line-height:5;content:'dd'}
							</style>
							<form action="app/media/proses.php?addmulti" class="dropzone" id="my-dropzone"></form>

						</div>
					</div>
				</div><!-- / .col -->
			</div>
<?php
			break;

	case 'del':
		$id 	= $v->sql(epm_decode($_GET['hash']));

		// check id exist or not
		$tb = new ElybinTable('elybin_media');
		$com = $tb->GetRow('media_id', $id);
		if($com < 1){
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}

		$cm	= $tb->SelectWhere('media_id',$id)->current();
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?php echo lg('Delete Permanently') ?></h4>
							</div>
							<div class="modal-body">
								<p class="text-danger"><?php echo lg('Are you sure you want delete permanently this item. This action cannot be undone.')?></p>
								<br/>
								<table class="table">
									<tr>
										<td width="20%"><i><?php echo lg('File Name') ?></i></td>
										<td><?php echo $cm->title?></td>
									</tr>
									<tr>
										<td><i><?php echo lg('Size') ?></i></td>
										<td><?php echo human_filesize($cm->size)?></td>
									</tr>
								</table>
								<hr/>
								<form action="<?php echo $action?>" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Delete')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									<input type="hidden" name="media_id" value="<?php echo epm_encode($cm->media_id)?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="media" />
								</form>
							</div>
<?php
		break;

	// preview
	case 'preview':
		$hash 	= $v->sql($_GET['hash']);
		// if not clear
		if(!isset($_GET['clear'])){
			_red('../404.html');
			exit;
		}
		// check id exist or not
		$tb = new ElybinTable('elybin_media');
		$com = $tb->GetRow('hash', $hash);
		if($com < 1){
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			exit;
		}

		$cm	= $tb->SelectWhere('hash',$hash)->current();
		header('Content-Type: ');
		readfile('../elybin-file/media/'.$cm->filename);
		break;

	case 'view':
		$id 	= $v->sql(epm_decode($_GET['hash']));

		// check id exist or not
		$tb = new ElybinTable('elybin_media');
		$com = $tb->GetRow('media_id', $id);
		if($com < 1){
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}

		$cm	= $tb->SelectWhere('media_id',$id)->current();
?>

							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-external-link-square"></i>&nbsp;&nbsp;<?php echo lg('More Detail')?></h4>
							</div>
							<div class="modal-body">
								<?php
								// show diferent viewer for diferent mime type
								if($cm->type == 'office' || $cm->type == 'text' || $cm->type == 'archive' || $cm->type == 'audio' || $cm->type == 'video'){
								?>
								<div class="col-sm-12 text-center">
									<iframe src="http://docs.google.com/gview?url=<?php echo _op()->site_url ?>file/v/<?php echo $cm->hash?>&embedded=true" style="width: 100%; height:500px;" frameborder="0"></iframe>
								</div>
								<?php
								}
								elseif($cm->type == 'image'){
								?>
								<div class="col-sm-12 text-center">
									<img src="../elybin-file/media/hd-<?php echo $cm->filename?>" alt="<?php echo lg('Preview')?>" class="img-thumbnail grid-gutter-margin-b" style="max-height: 450px"/>
								</div>
								<?php
								}
								?>
								<table class="table">
									<tr>
										<td width="20%"><i><?php echo lg('File Name') ?></i></td>
										<td><?php
											echo $cm->title.' (<i>';


											//file icon
											if($cm->type=='image'){
												$cm->type = lg('Image');
											}
											elseif($cm->type=='office'){
												$cm->type = lg('Document');
											}
											else{
												$cm->type = lg('File');
											}
											echo $cm->type
											?></i>)</td>
									</tr>
									<tr>
										<td><i><?php echo lg('Size') ?></i></td>
										<td><?php echo human_filesize($cm->size)?></td>
									</tr>
									<tr>
										<td><i><?php echo lg('Uploaded Date') ?></i></td>
										<td><?php echo friendly_date($cm->date)?></td>
									</tr>
									<tr>
										<td><i><?php echo lg('Downloaded') ?></i></td>
										<td><?php echo $cm->download.' '.lg('Times')?></td>
									</tr>
									<tr>
										<td><i><?php echo lg('Sharing') ?></i></td>
										<td><?php
										if($cm->share == 'yes'){
											echo lg('Yes');
										}else{
											echo lg('No');
										}
										?>
										</td>
									</tr>
									<tr>
										<td><i><?php echo lg('Share to') ?></i></td>
										<td>
											<input type="text" value="<?php echo _op()->site_url ?>file/v/<?php echo $cm->hash?>" class="form-control"><br/>
											<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo _op()->site_url ?>file/v/<?php echo $cm->hash?>" class="btn btn-xs btn-info" target="_blank"><i class="fa fa-facebook-square"></i>&nbsp;<?php echo lg('Share to Facebook')?></a>&nbsp;
											<a href="https://twitter.com/intent/tweet?url=<?php echo _op()->site_url ?>file/v/<?php echo $cm->hash?>" class="btn btn-xs btn-info" target="_blank"><i class="fa fa-twitter"></i>&nbsp;<?php echo lg('Share to Twitter')?></a>&nbsp;
											<a href="https://plus.google.com/share?url=<?php echo _op()->site_url ?>file/v/<?php echo $cm->hash?>" class="btn btn-xs btn-info" target="_blank"><i class="fa fa-google-plus"></i>&nbsp;<?php echo lg('Share to Google+')?></a>&nbsp;
										</td>
									</tr>
								</table>
								<hr></hr>
								<div class="form-group no-margin-b">
									<a href="../file/d/<?php echo $cm->hash?>" class="btn btn-success"><i class="fa fa-download"></i>&nbsp;<?php echo lg('Download')?></a>&nbsp;
									<a href="?mod=media&amp;act=del&amp;hash=<?php echo epm_encode($cm->media_id) ?>&amp;clear=yes" class="btn btn-danger" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo lg('Delete Permanently') ?>"><i class="fa fa-trash-o"></i><i class="fa fa-times"></i>&nbsp;<?php echo lg('Delete') ?></a>
									<button class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></button>
								</div>
							</div>
<script>
ElybinView();
</script>
<?php
			break;

	default:
	$tb 	= new ElybinTable('elybin_media');

	$search = $v->sql(@$_GET['search']);

	// search
	if(isset($_GET['search'])){
		$s_q = " && (`m`.`filename` LIKE '%$search%')";
	}else{
		$s_q = "";
	}

	if(isset($_GET['filter']) && $_GET['filter'] == 'docs'){
		// normal query
		$que = "
		SELECT
		`m`.*
		FROM
		`elybin_media` as `m`
		WHERE
		`m`.`type` = 'office'
		$s_q
		";
	}
	elseif(isset($_GET['filter']) && $_GET['filter'] == 'image'){
		// normal query
		$que = "
		SELECT
		`m`.*
		FROM
		`elybin_media` as `m`
		WHERE
		`m`.`type` = 'image'
		$s_q
		";
	}
	elseif(isset($_GET['filter']) && $_GET['filter'] == 'multi'){
		// normal query
		$que = "
		SELECT
		`m`.*
		FROM
		`elybin_media` as `m`
		WHERE
		`m`.`type` = 'audio' ||  `m`.`type` = 'video'
		$s_q
		";
	}else{
		// normal query
		$que = "
		SELECT
		`m`.*
		FROM
		`elybin_media` as `m`
		WHERE
		1=1
		$s_q
		";
	}

	$com = $tb->GetRowFullCustom($que);
	// modify query to pageable & shortable
	$oarr = array(
		'default' => '`m`.`date` DESC',
		'type' => '`m`.`type`',
		'size' => '`m`.`size`',
		'filename' => '`m`.`filename`'
	);
	$que = _PageOrder($oarr, $que);
	$lm	= $tb->SelectFullCustom($que);

	//echo '<pre>'.$que.'</pre>';
?>		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray"><?php echo lg('You are here:') ?></div>
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li class="active"><a href="?mod=media"><?php echo lg('Library') ?></a></li>

			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-cloud"></i>&nbsp;&nbsp;<?php echo lg('Library')?></span>
					<span class="hidden-xs"><?php echo lg('Library') ?></span>
					<?php if($search!==''){ echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-light-gray text-sm">'.lg('Search result for').' <i>&#34;'.$search.'&#34;</i>';} ?>
				</h1>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<div class="pull-right col-xs-12 col-sm-6 col-md-4">
							<a href="?mod=media&amp;act=addmulti" class="pull-right btn btn-success btn-labeled" style="width: 100%">
							<span class="btn-label icon fa fa-upload"></span>&nbsp;&nbsp;<?php echo lg('Multiple Upload')?></a>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- ./Page Header -->

		<?php
			// 1.1.3
			// msg
			if(@$_GET['msg'] == 'uploaded'){
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Uploaded Successfully.') . '</div>';
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
						$totallmedia = $tb->GetRowFullCustom("
						SELECT
						`m`.*
						FROM
						`elybin_media` as `m`
						");
						?>
						<a href="?mod=media"><?php echo lg('All') ?> <span class="badge badge-default"><?php echo $totallmedia ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='docs'){echo' class="active"'; }?>>
						<?php
						// count all post
						$totdoc = $tb->GetRowFullCustom("
						SELECT
						`m`.*
						FROM
						`elybin_media` as `m`
						WHERE
						`m`.`type` = 'office'
						");
						?>
						<a href="?mod=media&amp;filter=docs"><?php echo lg('Documets') ?> <span class="badge badge-success"><?php echo $totdoc ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='image'){echo' class="active"'; }?>>
						<?php
						// count all post
						$totgrap = $tb->GetRowFullCustom("
						SELECT
						`m`.*
						FROM
						`elybin_media` as `m`
						WHERE
						`m`.`type` = 'image'
						");
						?>
						<a href="?mod=media&amp;filter=image"><?php echo lg('Image') ?> <span class="badge badge-info"><?php echo $totgrap ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='multi'){echo' class="active"'; }?>>
						<?php
						// count all post
						$totmulti = $tb->GetRowFullCustom("
						SELECT
						`m`.*
						FROM
						`elybin_media` as `m`
						WHERE
						`m`.`type` = 'audio' || `m`.`type` = 'video'
						");
						?>
						<a href="?mod=media&amp;filter=multi"><?php echo lg('Video & Music') ?> <span class="badge badge-danger"><?php echo $totmulti ?></span></a>
					</li>
				</ul> <!-- / .nav -->
				<!-- Panel -->
				<div class="panel">
					<!-- ./Panel Heading -->
					<div class="panel-body">
					  <div class="table-primary table-responsive">

						<?php
						$orb = array(
							'type' => lg('File Type'),
							'size' => lg('File Size'),
							'filename' => lg('File Name')
						);
						showOrder($orb);
						showSearch();
						?>
						<!-- delate -->
						<form action="<?php echo $action?>" method="post">
						<input type="hidden" name="act" value="multidel" />
						<input type="hidden" name="mod" value="media" />

						<table class="table table-bordered table-striped" id="results">
						 <thead>
						   <tr>
						    <th width="2%"><i class="fa fa-square" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo lg('Check All')?>"></i></th>
							<th width="35%"><?php echo lg('File Name') ?></th>
						    <th width="5%"><?php echo lg('Type') ?></th>
						    <th><?php echo lg('Size')?></th>
							<th><?php echo lg('Date') ?></th>
						    <th><?php echo lg('Action')?></th>
						   </tr>
						 </thead>
						 <tbody>
						<?php

						$no = 0;
						foreach($lm as $cm){
							//file icon
							if($cm->type=='image'){
								$cm->type = lg('Image');
								$cm->icon = "fa-picture-o";
							}
							elseif($cm->type=='office'){
								$cm->type = lg('Document');
								$cm->icon = "fa-file text-info";
							}
							else{
								$cm->type = lg('File');
								$cm->icon = "fa-file";
							}
						?>
						   <tr>
							<td width="1%"><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo epm_encode($cm->media_id)?>|<?php echo $cm->title?>"><span class="lbl"></span></label></td>
							<td width="40%"><?php echo $cm->title?></td>
							<td width="10%"><i class="fa <?php echo $cm->icon?>"></i>&nbsp;<?php echo $cm->type?></td>
							<td><?php echo human_filesize($cm->size)?></td>
							<td><?php echo friendly_date($cm->date)?></td>
							<td>
								<div id="tooltip">
									<?php
										echo '<a href="?mod=media&amp;act=view&amp;hash='.epm_encode($cm->media_id).'&amp;clear=yes" class="btn btn-success btn-outline btn-sm" data-toggle="modal" data-target="#view" id="view-link" data-placement="bottom" data-toggle="tooltip" data-original-title="'.lg('Mode Detail').'"><i class="fa fa-external-link-square"></i></a>&nbsp;';
										echo '<a href="?mod=media&amp;act=del&amp;hash='.epm_encode($cm->media_id).'&amp;clear=yes" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="'.lg('Delete Permanently').'"><i class="fa fa-trash-o"></i><i class="fa fa-times"></i></a>';
									?>

								</div>
							</td>
						   </tr>
						<?php
							$no++;
						}


						if($no < 1){
							echo '<tr><td colspan="6"><div class="text-center text-light-gray panel-padding"><i class="fa fa-5x fa-file"></i><br/>'. lg('Nothing can be shown.').'</div></td></tr>';
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
									<?php
									echo '<h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'.lg('Delete Permanently').'</h4>';
									?>

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
					<!-- start -->

					<form action="app/media/proses.php" method="post" id="form" enctype="multipart/form-data">
						<div class="row">
							<div class="col-sm-12">
								<hr/>
								<h4><?php echo lg('Quick Uplaod') ?></h4>
								<div class="form-group">
									<div class="col-sm-12 col-md-5">
										<input type="file" name="file" class="form-control" id="file-style" required/>
									</div>
									<div class="col-sm-12 col-md-5">
										<button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save Data')?></button>
									</div>
									<div class="col-sm-12">
										<p class="help-block"><?php echo lg('Allowed file type:')?> (jpg, jpeg, png, svg, xls, xlsx, ppt, pptx, txt, doc, docx, pdf, rar, zip, mp3)</p>
									</div>
								</div> <!-- / .form-group -->

								<input type="hidden" name="act" value="add" />
								<input type="hidden" name="mod" value="media" />
							</div><!-- / .col -->
						</div>
					</form>

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

				<!-- share Modal -->
				<div id="share" class="modal fade hide-light" tabindex="-1" role="dialog" style="z-index:3000">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<?php echo lg('Loading')?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / share Modal -->


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
