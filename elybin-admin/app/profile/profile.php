<?php
/* Short description for file
 * [ Module: Profile
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
$modpath 	= "app/profile/";
$action		= $modpath."proses.php";
$v 	= new ElybinValidasi();

switch (@$_GET['act']) {
	default;
	$s = $_SESSION['login'];
	$tblu = new ElybinTable("elybin_users");
	$tblu = $tblu->SelectWhere("session","$s","","");
	$tblu = $tblu->current();

	$id 	= $tblu->user_id;

	$tb 	= new ElybinTable('elybin_users');
	$cuser	= $tb->SelectWhere('user_id',$id,'','');
	$cuser	= $cuser->current();
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo $lg_profile?> / </span><?php echo $lg_editprofile?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">

				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo $lg_editmyprofile?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">

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
					      	<p class="help-block"><?php echo $lg_leftphotoempty?></p>
					      </div>
					  </div> <!-- / .form-group -->
					</div><!-- / .panel-body -->

					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savechanges?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="act" value="edit" />
						  <input type="hidden" name="mod" value="profile" />
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

<?php
		break;
}
}
?>
