<?php
/* Short description for file
 * [ Module: Users
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
if(empty($_SESSION['login'])){
	header('location:../403.php');
}else{
$modpath 	= "app/user/";
$action		= $modpath."proses.php";

// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','')->current();
$level = $tbus->level; // getting level from curent user

$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
$usergroup = $tbug->current()->user;

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
			<h1><span class="text-light-gray"><?php echo $lg_user?> / </span><?php echo $lg_addnew?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo $lg_addnewuser?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_username?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="username" class="form-control" placeholder="<?php echo $lg_username?>" required/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_password?>*</label>
					      <div class="col-sm-10">
					      	<input type="password" name="password" class="form-control" placeholder="<?php echo $lg_password?>" required/>
					      	<p class="help-block"><?php echo $lg_passworduserhint?></p>
					      </div>
					  </div> <!-- / .form-group -->
					   <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_email?>*</label>
					      <div class="col-sm-10">
					      	<input type="email" name="email" class="form-control" placeholder="<?php echo $lg_email?>" required/>
					      </div>
					  </div> <!-- / .form-group -->
					   <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_fullname?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="fullname" class="form-control" placeholder="<?php echo $lg_fullname?>" required/>
					      </div>
					  </div> <!-- / .form-group -->
					   <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_phone?></label>
					      <div class="col-sm-10">
					      	<input type="text" name="phone" class="form-control" placeholder="<?php echo $lg_phone?>"/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_level?>*</label>
					      <div class="col-sm-2">
					      	<select name="level" id="multiselect-style">
					      	<?php
								$tblug = new ElybinTable('elybin_usergroup');
								if($tbus->user_id == 1){
									$tblug	= $tblug->Select('','');
								}else{
									$tblug	= $tblug->SelectCustom("SELECT * FROM", "WHERE `usergroup_id` != '1'");
								}
								foreach ($tblug as $f) {
					      	?>
						        <option value="<?php echo $f->usergroup_id?>"><?php echo $f->name?></option>
						    <?php } ?>
					      	</select>
						  </div>
					    </div> <!-- / .form-group -->
					  </div><!-- / .panel-body -->

					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savedata?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="act" value="add" />
						  <input type="hidden" name="mod" value="user" />
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
	$("#multiselect-style").select2({
		allowClear: false,
		placeholder: "<?php echo $lg_level?>"
	});
	$('#tooltip a').tooltip();	



	$().ajaxStart(function() {
		$.growl({ title: "Loading", message: "Writing..." });
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
					window.location.href="?mod=user";
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

		case 'active';
			$user_id = $v->sql(@$_GET['id']);
			$tblact = new ElybinTable('elybin_users');

			// check id exist or not or super user
			$tblact 	= new ElybinTable('elybin_users');
			$couser = $tblact->GetRow('user_id', $user_id);
			if(empty($user_id) OR ($couser == 0) OR ($user_id == 1)){
				er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
				theme_foot();
				exit;
			}
			
			// ambil data
			$status = $tblact->SelectWhere('user_id',$user_id,'','');
			$status = $status->current();

			if($status->level == 1){
				er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
				theme_foot();
				exit;
			}
			
			$status = $status->status;
			if($status == "active"){
				$data = array( 'status' => "deactive");
				$tblact->Update($data,'user_id',$user_id);
			}else{
				$data = array( 'status' => "active");
				$tblact->Update($data,'user_id',$user_id);
			}
			ElybinRedirect('./admin.php?mod='.$mod);
			break;

		case 'edit';
		$id 	= $v->xss(@$_GET['id']);
		$id 	= $v->sql($id);

		// check id exist or not or super user
		$tb 	= new ElybinTable('elybin_users');
		$couser = $tb->GetRow('user_id', $id);
		if(empty($id) OR ($couser == 0) OR ($id == 1)){
			er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
			theme_foot();
			exit;
		}

		// ambil data
		$cuser	= $tb->SelectWhere('user_id',$id,'','');
		$cuser	= $cuser->current();
		
		if($cuser->level == 1){
			er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
			theme_foot();
			exit;
		}
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo $lg_user?> / </span><?php echo $lg_edituser?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">

				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo $lg_editcurrentuser?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_username?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="username" value="<?php echo $cuser->user_account_login?>" class="form-control" placeholder="<?php echo $lg_username?>" required/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_password?>*</label>
					      <div class="col-sm-10">
					      	<input type="password" name="newpassword" class="form-control" placeholder="<?php echo $lg_password?>"/>
					      	<p class="help-block"><?php echo $lg_leftpasswordempty?></p>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_email?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="email" value="<?php echo $cuser->user_account_email?>" class="form-control" placeholder="<?php echo $lg_email?>" required/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_fullname?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="fullname" value="<?php echo $cuser->fullname?>" class="form-control" placeholder="<?php echo $lg_fullname?>" required/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_phone?></label>
					      <div class="col-sm-10">
					      	<input type="text" name="phone" value="<?php echo $cuser->phone?>" class="form-control" placeholder="<?php echo $lg_phone?>"/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_bio?></label>
					      <div class="col-sm-10">
					      	<textarea name="bio" cols="50" rows="5" class="form-control" placeholder="<?php echo $lg_bio?>"><?php echo html_entity_decode($cuser->bio)?></textarea>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_photo?></label>
					      <div class="col-sm-5">
					      	<img class="img-thumbnail" alt="<?php echo $lg_photo?>" src="../elybin-file/avatar/<?php echo $cuser->avatar?>">
					      </div>
					      <div class="col-sm-4">
					      	<input type="file" name="image" id="file-style" class="form-control"/>
					      	<p class="help-block"><?php echo $lg_leftphotoempty?> <i>(.jpg, .jpeg, .png, .gif)</i></p>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_level?>*</label>
					      <div class="col-sm-2">
					      	<select name="level" class="form-control" id="multiselect-style">
					      	<?php
								$tblug = new ElybinTable('elybin_usergroup');
								if($tbus->user_id == 1){
									$tblug	= $tblug->Select('','');
								}else{
									$tblug	= $tblug->SelectCustom("SELECT * FROM", "WHERE `usergroup_id` != '1'");
								}
								foreach ($tblug as $f) {
					      	?>
						        <option value="<?php echo $f->usergroup_id?>" <?php if($cuser->level==$f->usergroup_id){echo 'SELECTED';}?>><?php echo $f->name?></option>
						    <?php } ?>
	      					</select>			      
	      				</div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_status?></label>
					      <div class="col-sm-10">
					      	<input type="checkbox" name="status" class="form-control" id="switcher-style" <?php if($cuser->status=='active'){echo 'checked="checked"';}?>>
					      	<p class="help-block"><span class="fa fa-check"></span>&nbsp;<?php echo $lg_active?>&nbsp;<span class="fa fa-times"></span>&nbsp;<?php echo $lg_inactive?></p>
	      				</div>
					  </div> <!-- / .form-group -->
					</div><!-- / .panel-body -->

					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savechanges?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="user_id" value="<?php echo $cuser->user_id?>" />
						  <input type="hidden" name="act" value="edit" />
						  <input type="hidden" name="mod" value="user" />
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
	$("#multiselect-style").select2({
		allowClear: false,
		placeholder: "<?php echo $lg_level?>"
	});
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
					window.location.href="?mod=user";
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

		case 'del':
		if($_GET['id'] == 1){
			header('location: ../404.html');
			exit;
		}
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
									<input type="hidden" name="user_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="user" />
								</form>
							</div>
<?php
			break;
		
		default:
		$tb 	= new ElybinTable('elybin_users');
		if($tbus->user_id == 1){
			$luser	= $tb->SelectCustom("SELECT * FROM", "WHERE (`user_id` != '1') ORDER BY `user_id` DESC");
		}
		else{
			$luser	= $tb->SelectCustom("SELECT * FROM", "WHERE (`user_id` != '1') AND  (`user_id` != '".$tbus->user_id."') AND (`level` != '1') ORDER BY `user_id` DESC");
		}
		$no = 1;
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo $lg_user?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo $lg_user?> / </span><?php echo $lg_all?></span>
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
					<input type="hidden" name="mod" value="user" />
					
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-users hidden-xs">&nbsp;&nbsp;</i><?php echo $lg_alluser?></span>
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
						    <th><?php echo $lg_thumbnail?></th>
						    <th><?php echo $lg_username?></th>
						    <th><?php echo $lg_fullname?></th>
						    <th><?php echo $lg_level?></th>
						    <th><?php echo $lg_status?></th>
						    <th><?php echo $lg_action?></th>
						  </tr>
						</thead>
						<tbody>
						<?php
						foreach($luser as $usr){
							$tblug = new ElybinTable('elybin_usergroup');
							$tblug = $tblug->SelectWhere('usergroup_id',$usr->level,'','')->current();
							$level = $tblug->name;
							if($tblug->usergroup_id==1){
								$level = '<span class="text-danger">'.$level.'</span>';
							}
							elseif($tblug->usergroup_id==2){
								$level = '<span class="text-warning">'.$level.'</span>';
							}
							
							if($usr->session != 'offline'){
								$online = '<span class="text-success"><i class="fa fa-circle"></i></span>';
							}else{
								$online = '<span class="text-muted"><i class="fa fa-circle-o"></i></span>';
							}
							
							if($usr->status == "active"){
								$status = $lg_deactivate;
								$link = '<i class="fa fa-ban"></i>';
							}else{
								$status = $lg_activate;
								$link = '<i class="fa fa-check"></i>';
							}
							if(file_exists("../elybin-file/avatar/medium-$usr->avatar")){
								$avatar = "medium-$usr->avatar";
							}else{
								$avatar = $usr->avatar;
							}
						?>
						  <tr class="valign-middle">
						    <td><?php echo $no?></td>
						    <td><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo $usr->user_id?>|<?php echo $usr->fullname?>"><span class="lbl"></span></label></td>
						    <td><img src="../elybin-file/avatar/<?php echo $avatar?>" alt="<?php echo $lg_photo?>" class="rounded" style="width:30px;height:30px;"/></td>
						    <td><?php echo $online?>&nbsp;&nbsp;<?php echo $usr->user_account_login?></td>
						    <td><?php echo $usr->fullname?></td>
						    <td><?php echo $level?></td>
						    <td><?php echo $usr->status?></td>
						    <td>
						    	<div id="tooltip">
						    		<a href="?mod=user&amp;act=edit&amp;id=<?php echo $usr->user_id?>" class="btn btn-outline btn-success btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_edit?>"><i class="fa fa-pencil-square-o"></i></a>
						    		<a href="?mod=user&amp;act=active&amp;id=<?php echo $usr->user_id?>" class="btn btn-outline btn-success btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $status?>"><?php echo $link?></a>
						    		<a href="?mod=user&amp;act=del&amp;id=<?php echo $usr->user_id?>&amp;clear=yes" class="btn btn-outline btn-danger btn-sm" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo $lg_delete?>"><i class="fa fa-times"></i></a>
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
	$('#tooltip a, #tooltip-ck').tooltip();	
});
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
