<?php
/* Short description for file
 * [ Module: Profile
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{

$v 	= new ElybinValidasi();

switch (@$_GET['act']) {
	default:
	// get users information
	$cuser	= _u();
?>
		<div class="page-header">
			<h1><?php echo lg('Edit Profile')?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<?php
				// if msg set
				if(isset($_GET['msg']) && @$_GET['msg'] == "saved"){
				?>
				<div class="note note-success">
					<i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo lg('Data saved successfully.') ?>.
				</div>
				<?php
				}
				// email confrimed
				if(isset($_GET['msg']) && @$_GET['msg'] == "email-confrimed"){
				?>
				<div class="note note-success">
					<i class="fa fa-check"></i>&nbsp;&nbsp;<?php echo lg('A confirmation link has been sent to your email.') ?>
				</div>
				<?php
				}
				?>
				<?php
					// show messages alert (effective way)
					showAlert();
				?>
				<form class="panel form-horizontal" action="app/profile/proses.php" method="post" enctype="multipart/form-data" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-user"></i>&nbsp;&nbsp;<?php echo lg('Edit My Profile')?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">

					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo lg('Username')?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="username" value="<?php echo $cuser->user_account_login?>" class="form-control" placeholder="<?php echo lg('Username')?>" required/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo lg('Password')?></label>
					      <div class="col-sm-10">
					      	<input type="password" name="newpassword" class="form-control" placeholder="<?php echo lg('Password')?>"/>
					      	<p class="help-block"><?php echo lg('Left empty if you don\'t want to change your password.')?></p>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo lg('Confirm Password')?></label>
					      <div class="col-sm-10">
					      	<input type="password" name="newconfirmpassword" class="form-control" placeholder="<?php echo lg('Type your password again.')?>"/>
					      	<p class="help-block"><?php echo lg('Type your password again. Left empty if you don\'t want to change your password.')?></p>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo lg('E-mail')?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="email" value="<?php echo $cuser->user_account_email?>" class="form-control" placeholder="<?php echo lg('E-mail')?>" required/>
							<?php
							// update v1.1.3
							// show resend link, if email not verified yet
							if($cuser->email_status == "notverified"){
							?>
							<p class="help-block"><span class="text-warning"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?php echo lg('Please verify your email')?>, </span><a href="?mod=profile&amp;act=resend&amp;clear=yes"><?php echo lg('Resend E-mail Confirmation.') ?></a>.</p>
							<?php
							}else{ ?>
							<p class="help-block"><span class="text-success"><i class="fa fa-check-circle"></i>&nbsp;&nbsp;<?php echo lg('Email verified.')?></span></p>
							<?php } ?>
						  </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo lg('Name')?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="fullname" value="<?php echo $cuser->fullname?>" class="form-control" placeholder="<?php echo lg('Your Name')?>" required/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo lg('Phone')?></label>
					      <div class="col-sm-10">
					      	<input type="text" name="phone" value="<?php echo $cuser->phone?>" class="form-control" placeholder="<?php echo lg('Phone')?>"/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo lg('Bio')?></label>
					      <div class="col-sm-10">
					      	<textarea name="bio" cols="50" rows="5" class="form-control" placeholder="<?php echo lg('Bio')?>"><?php echo html_entity_decode($cuser->bio)?></textarea>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo lg('Photo')?></label>
					      <div class="col-sm-3">
									<?php
										// avatar
										if($cuser->avatar == "default/no-ava.png"){
											echo  '<img src="../elybin-file/avatar/default/no-ava.png" class="img-thumbnail" width="100%">';
										}else{
											echo  '<img src="../elybin-file/avatar/md-'.$cuser->avatar.' " class="img-thumbnail" width="100%">';
										}
									?>
					      </div>
					      <div class="col-sm-4">
					      	<input type="file" name="file" id="file-style" class="form-control"/>
					      	<p class="help-block"><?php echo lg('Left empty if you don\'t want to change your avatar.')?></p>
					      </div>
					  </div> <!-- / .form-group -->
					</div><!-- / .panel-body -->

					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save Changes')?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>
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
								<h4 class="modal-title"><?php echo lg('Help')?></h4>
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

	// update 1.1.3
	// resend email
	case "resend":

		// redirect
		redirect('?mod=profile&msg=email-sent');
		break;
}
}
?>
