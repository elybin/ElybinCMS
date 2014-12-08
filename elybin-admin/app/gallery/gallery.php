<?php
/* Short description for file
 * [ Module: Gallery
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
if(empty($_SESSION['login'])){
	header('location:../../../403.php');
}else{
$modpath 	= "app/gallery/";
$action		= $modpath."proses.php";

// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
$level = $tbus->current()->level; // getting level from curent user

$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
$usergroup = $tbug->current()->gallery;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
}else{
	// start here
	$v 	= new ElybinValidasi();
	switch (@$_GET['act']) {
		case 'add':
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo $lg_media?> / <?php echo $lg_photogallery?> / </span><?php echo $lg_addnew?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;<?php echo $lg_addnewphoto?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_album?>*</label>
					      <div class="col-sm-4">
					        <select name="album_id" id="select-style" required>
					        <?php
					      		$tbl = new ElybinTable('elybin_album');
					      		$album = $tbl->SelectWhere('status','active','','');

					      		foreach($album as $a){
					      	?>
					       		<option value="<?php echo $a->album_id; ?>"><?php echo $a->name; ?></option>
					      	<?php
					      		}
					      	?>

				            </select>
						      </div>
						  </div> <!-- / .form-group -->
						<div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_photofile?>*</label>
					      <div class="col-sm-4">
					      	<input type="file" name="image" id="file-style" class="form-control" required/>
					      	<p class="help-block"><?php echo $lg_photogalleryhint?> <i>(jpg, jpeg, png, gif)</i></p>
					      </div>
						</div> <!-- / .form-group -->
					</div><!-- / .panel-body -->

					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savedata?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="act" value="add" />
						  <input type="hidden" name="mod" value="gallery" />
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
	$('#file-style').pixelFileInput({ placeholder: '<?php echo $lg_nofileselected?>...' });
	$("#select-style").select2();
	$('#tooltip a').tooltip();	


	$().ajaxStart(function() {
		$.growl({ title: "Loading", message: "Writing..." });
	}).ajaxStop(function() {
		$.growl({ title: "Success", message: "Success" });
	});


	$('#form').submit(function(e){
	    $.ajax({
	      url: $(this).attr('action'),
	      type: 'POST',
	      data: new FormData(this),
	      processData: false,
	      contentType: false,
	      success: function(data) {
	      		console.log(data);
				data = explode(",",data);

				if(data[0] == "ok"){
					$.growl.notice({ title: data[1], message: data[2] });
					window.location.href="?mod=gallery";
				}
				else if(data[0] == "error"){
					$.growl.warning({ title: data[1], message: data[2] });
				}
		   }
	    });
	    e.preventDefault();
	    return false;
  	});
});
</script>
<!-- / Javascript -->
<?php

			break;

		case 'edit';
		$id 	= $v->sql(@$_GET['id']);
		$id 	= $v->xss($id);
		
		// check id exist or not
		$tb 	= new ElybinTable('elybin_gallery');
		$cogallery = $tb->GetRow('gallery_id', $id);
		if(empty($id) OR ($cogallery == 0)){
			er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
			theme_foot();
			exit;
		}

		// get data
		$cgal	= $tb->SelectWhere('gallery_id',$id,'','');
		$cgal	= $cgal->current();

		$description = html_entity_decode($cgal->description);
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo $lg_media?> / <?php echo $lg_photogallery?> / </span><?php echo $lg_editphoto?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;<?php echo $lg_editcurrentphoto?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
						<?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
						<div class="form-group">
					      <label class="col-sm-2 control-label"></label>
					      <div class="col-sm-6">
					      	<img src="../elybin-file/gallery/<?php echo $cgal->image?>" alt="Foto" class="img-thumbnail"/>
					      </div>
						</div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_album?>*</label>
					      <div class="col-sm-4">
					        <select name="album_id" id="select-style">
					        <?php
					      		$tbl = new ElybinTable('elybin_album');
					      		$album = $tbl->Select('album_id','DESC');

					      		foreach($album as $a){
					      	?>
					        <option value="<?php echo $a->album_id; ?>"<?php if($cgal->album_id==$a->album_id){echo ' selected=selected';}?>><?php echo $a->name; ?></option>
					      	<?php
					      		}
					      	?>
				            </select>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_title?></label>
					      <div class="col-sm-4">
					      	<input type="text" name="name" class="form-control" placeholder="<?php echo $lg_title?>" value="<?php echo $cgal->name?>"/>
					      </div>
					  </div> <!-- / .form-group -->
						<div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_description?></label>
					      <div class="col-sm-10">
					      	<textarea name="description" cols="50" rows="5" class="form-control" placeholder="<?php echo $lg_description?>"><?php echo $description?></textarea>
					      </div>
						</div> <!-- / .form-group -->
					</div><!-- / .panel-body -->

					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savechanges?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="gallery_id" value="<?php echo $_GET['id']; ?>" />
						  <input type="hidden" name="act" value="edit" />
						  <input type="hidden" name="mod" value="gallery" />
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
		$("#select-style").select2();
		$('#tooltip a').tooltip();	
		$('#date-pick').datepicker();
		$("#date-input").mask("99/99/9999");

		$().ajaxStart(function() {
			$.growl({ title: "Loading", message: "Writing..." });
			$('#form').hide();
		}).ajaxStop(function() {
			$.growl({ title: "Success", message: "Success" });
		});

		//ajax
		$('#form').submit(function() {
			$.ajax({
				type: 'POST',
				url: $(this).attr('action'),
				data: $(this).serialize(),
				success: function(data) {
					data = explode(",",data);

					if(data[0] == "ok"){
						$.growl.notice({ title: data[1], message: data[2] });
						window.location.href="?mod=gallery";
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
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_cancel?></a>
									<input type="hidden" name="gallery_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="gallery" />
								</form>
							</div>
<?php
			break;

		case 'view':
		$id 	= $v->xss($_GET['id']);
		$id 	= $v->sql($id);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_gallery');
		$cogallery = $tb->GetRow('gallery_id', $id);
		if(empty($id) OR ($cogallery == 0)){
			er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
			theme_foot();
			exit;
		}
		
		$cgal	= $tb->SelectWhere('gallery_id',$id,'','');
		$cgal	= $cgal->current();

		$tbal 	= new ElybinTable('elybin_album');
		$calbum	= $tbal->SelectWhere('album_id',$cgal->album_id,'','');
		$calbum	= $calbum->current();
		$album = $calbum->name;

		$description = html_entity_decode($cgal->description);
?>

							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-external-link-square"></i>&nbsp;&nbsp;<?php echo $lg_detailtitle?></h4>
							</div>
							<div class="modal-body">
						      <div class="col-sm-12 text-center">
						      	<img src="../elybin-file/gallery/<?php echo $cgal->image?>" alt="<?php echo $lg_photo?>" class="img-thumbnail grid-gutter-margin-b"/>
						      </div>
								<table class="table">
									<tr>
										<td><i><?php echo $lg_album?></i></td>
										<td><?php echo $album?></td>
									</tr>	
									<tr>
										<td><i><?php echo $lg_title?></i></td>
										<td><?php echo $cgal->name?></td>
									</tr>		
									<tr>
										<td><i><?php echo $lg_uploaddate?></i></td>
										<td><?php echo $cgal->date?></td>
									</tr>
									<tr>
										<td><i><?php echo $lg_description?></i></td>
										<td><?php echo $description?></td>
									</tr>
								</table>
								<hr></hr>
								<div class="form-group no-margin-b">
									<button class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></button>
								</div>
							</div>

<?php
			break;
		
		default:
		$tb 	= new ElybinTable('elybin_gallery');
		$lgallery	= $tb->Select('gallery_id','DESC');
		$no = 1;
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-picture-o"></i>&nbsp;&nbsp;<?php echo $lg_photogallery?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo $lg_photogallery?> / </span><?php echo $lg_all?></span>
				</h1>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<div class="pull-right col-xs-12 col-sm-6 col-md-4">	
							<a href="?mod=<?php echo @$_GET['mod']?>&amp;act=add" class="pull-right btn btn-success btn-labeled" style="width: 100%">
							<span class="btn-label icon fa fa-plus"></span>&nbsp;&nbsp;<?php echo $lg_addnew?></a>
						</div>
						<!-- Margin -->
						<div class="visible-xs clearfix form-group-margin"></div>
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
					<input type="hidden" name="mod" value="gallery" />
					
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-picture-o hidden-xs">&nbsp;&nbsp;</i><?php echo $lg_allphoto?></span>
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
						    <th>#</th>
						    <th><i class="fa fa-check-square" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_checkall?>"></i></th>
						    <th><?php echo $lg_thumbnail?></th>
						    <th><?php echo $lg_title?></th>
						    <th><?php echo $lg_album?></th>
						    <th><?php echo $lg_action?></th>
						</thead>
						<tbody>
						<?php
						foreach($lgallery as $gal){
							$tbal = new ElybinTable('elybin_album');
							$album = $tbal->SelectWhere('album_id',$gal->album_id,'','');
							foreach ($album as $al) {
								$album = $al->name;
							}
							if(file_exists("../elybin-file/gallery/medium-$gal->image")){
								$image = "medium-$gal->image";
							}else{
								$image = $gal->image;
							}
						?>
						<tr>
						    <td><?php echo $no?></td>
						    <td><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo $gal->gallery_id?>|<?php echo $gal->name?>"><span class="lbl"></span></label></td>
						    <td><img src="../elybin-file/gallery/<?php echo $image?>" alt="<?php echo $lg_photo?>" class="rounded" style="width:30px;height:30px;"/></td>
						    <td><?php echo $gal->name?></td>
						    <td><?php echo $album?></td>
						    <td>
				    			<div id="tooltip">
						    		<a href="?mod=gallery&amp;act=view&amp;id=<?php echo $gal->gallery_id?>&amp;clear=yes" class="btn btn-success btn-outline btn-sm" data-toggle="modal" data-target="#view" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_view?>"><i class="fa fa-external-link-square"></i></a>
						    		<a href="?mod=gallery&amp;act=edit&amp;id=<?php echo $gal->gallery_id?>" class="btn btn-success btn-outline btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_edit?>"><i class="fa fa-pencil-square-o"></i></a>
						    		<a href="?mod=gallery&amp;act=del&amp;id=<?php echo $gal->gallery_id?>&amp;clear=yes" class="btn btn-danger btn-outline btn-sm" data-toggle="modal" data-target="#delete" data-placement="bottom" data-original-title="<?php echo $lg_delete?>"><i class="fa fa-times"></i></a>
						    	</div>
				    		</td>
				  		</tr>
						<?php
							$no++;
						}
						?>
						</tbody>
					  </table>
				  	</div>
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
				<!-- / Delete Modal -->
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
	$('#tooltip a, #tooltip-ck, #tooltip-foto').tooltip();	
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
