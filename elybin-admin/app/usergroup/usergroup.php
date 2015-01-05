<?php
/* Short description for file
 * [ Module: Usergroup
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
$modpath 	= "app/usergroup/";
$action		= $modpath."proses.php";

// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','')->current();
$level = $tbus->level; // getting level from curent user

// give error if no have privilage
if($tbus->user_id != 1){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
}else{
	// start here
	$v 	= new ElybinValidasi();
	switch (@$_GET['act']) {
		case 'add':
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo $lg_setting?> / <?php echo $lg_usergroup?> / </span><?php echo $lg_addnew?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo $lg_addnewusergroup?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_name?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="name" class="form-control" placeholder="<?php echo $lg_name?>" required/>
					      </div>
					  </div> <!-- / .form-group -->
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_alias?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="alias" class="form-control" placeholder="<?php echo $lg_alias?>" required/>
					      </div>
					  </div> <!-- / .form-group -->

					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_privilege?></label>
					      <div class="col-sm-10">
					      	<div class="table-responsive">
						      	<table class="table" id="results">
						      		<thead>
						      			<td colspan="4">
											<label class="checkbox-inline" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_checkall?>">
												<i class="fa fa-check-square"></i>
												<span class="lbl"><?php echo $lg_checkall?> / <?php echo $lg_uncheckall?></span>
											</label>
						      			</td>
						      		</thead>
						      		<tbody>
							      		<tr>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_post">
													<span class="lbl"><?php echo $lg_post?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_comment">
													<span class="lbl"><?php echo $lg_comment?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_contact">
													<span class="lbl"><?php echo $lg_contact?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_album">
													<span class="lbl"><?php echo $lg_album?></span>
												</label>
							      			</td>
							      		</tr>

							      		<tr>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_user">
													<span class="lbl"><?php echo $lg_user?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_category">
													<span class="lbl"><?php echo $lg_category?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_media">
													<span class="lbl"><?php echo $lg_media?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_setting">
													<span class="lbl"><?php echo $lg_setting?></span>
												</label>
							      			</td>
							      		</tr>

							      		<tr>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_tag">
													<span class="lbl"><?php echo $lg_tag?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_gallery">
													<span class="lbl"><?php echo $lg_photogallery?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_page">
													<span class="lbl"><?php echo $lg_page?></span>
												</label>
							      			</td>
							      			<td></td>
							      		</tr>
							      		<?php
							      			$tblpl = new ElybinTable('elybin_plugins');
							      			$cpl = $tblpl->GetRow('status','active');
							      			if($cpl>0){
							      		?>
							      		<tr>
							      			<td colspan="4"><strong><?php echo $lg_apps?></strong></td>
							      		</tr>

							      		<tr>
							      			<?php
							      				$lpl = $tblpl->SelectWhere('status','active','','');
							      				foreach($lpl as $pl){
							      			?>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="plugin_<?php echo $pl->plugin_id?>">
													<span class="lbl"><?php echo $pl->name?></span>
												</label>
							      			</td>
							      			<?php } ?>
							      		</tr>
							      		<?php } ?>
						      		</tbody>
						      	</table>
						      </div><!-- / .table-responisve -->
					      </div>
					  </div> <!-- / .form-group -->
					</div><!-- / .panel-body -->

					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savedata?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="act" value="add" />
						  <input type="hidden" name="mod" value="usergroup" />
					  </div> <!-- / .form-footer -->
				</form><!-- / .form -->

				<!-- Help modal -->
				<div id="help" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
								<h4 class="modal-title"><?php echo $lg_help?></h4>
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

		case 'edit';
		$id 	= $v->xss(@$_GET['id']);
		$id 	= $v->sql($id);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_usergroup');
		$cousergroup = $tb->GetRow('usergroup_id', $id);
		if(empty($id) OR ($cousergroup == 0) OR $id == 1){
			er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
			theme_foot();
			exit;
		}

		// get data
		$cusergroup	= $tb->SelectWhere('usergroup_id',$id,'','');
		$cusergroup	= $cusergroup->current();

		$access_name = array("Post","Category","Tag","Comment","Contact","Media","Gallery","Album","Page","User","Setting");
		foreach ($access_name as $an) {
			$an = strtolower($an);
			if(($cusergroup->$an)==1){
				$priv[$an] = 'checked="checked"';
			}else{
				$priv[$an] = "";
			}
		}
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo $lg_setting?> / <?php echo $lg_usergroup?> / </span><?php echo $lg_editusergroup?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">

				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo $lg_editcurrentusergroup?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_name?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="name" value="<?php echo $cusergroup->name?>" class="form-control" placeholder="<?php echo $lg_name?>"/>
					      </div>
					  </div> <!-- / .form-group -->

					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_alias?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="alias" value="<?php echo $cusergroup->alias?>" class="form-control" placeholder="<?php echo $lg_alias?>"/>
					      </div>
					  </div> <!-- / .form-group -->

					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_privilege?></label>
					      <div class="col-sm-10">
					      	<div class="table-responsive">
						      	<table class="table" id="results">
						      		<thead>
						      			<td colspan="4">
											<label class="checkbox-inline" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_checkall?>">
												<i class="fa fa-check-square"></i>
												<span class="lbl"><?php echo $lg_checkall?> / <?php echo $lg_uncheckall?></span>
											</label>
						      			</td>
						      		</thead>
						      		<tbody>
							      		<tr>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_post" <?php echo $priv['post']?>>
													<span class="lbl"><?php echo $lg_post?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_comment" <?php echo $priv['comment']?>>
													<span class="lbl"><?php echo $lg_comment?></span>
												</label>
							      			</td>
								      		<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_contact" <?php echo $priv['contact']?>>
													<span class="lbl"><?php echo $lg_contact?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_album" <?php echo $priv['album']?>>
													<span class="lbl"><?php echo $lg_album?></span>
												</label>
							      			</td>
							      		</tr>

							      		<tr>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_user" <?php echo $priv['user']?>>
													<span class="lbl"><?php echo $lg_user?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_category" <?php echo $priv['category']?>>
													<span class="lbl"><?php echo $lg_category?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_media" <?php echo $priv['media']?>>
													<span class="lbl"><?php echo $lg_media?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_setting" <?php echo $priv['setting']?>>
													<span class="lbl"><?php echo $lg_setting?></span>
												</label>
							      			</td>
							      		</tr>

							      		<tr>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_tag" <?php echo $priv['tag']?>>
													<span class="lbl"><?php echo $lg_tag?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_gallery" <?php echo $priv['gallery']?>>
													<span class="lbl"><?php echo $lg_photogallery?></span>
												</label>
							      			</td>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="privilege_page" <?php echo $priv['page']?>>
													<span class="lbl"><?php echo $lg_page?></span>
												</label>
							      			</td>
							      			<td>&nbsp;</td>
							      		</tr>

							      		<?php
							      			$tblpl = new ElybinTable('elybin_plugins');
							      			$cpl = $tblpl->GetRow('status','active');
							      			if($cpl>0){
							      		?><tr>
							      			<td colspan="4"><strong><?php echo $lg_apps?></strong></td>
							      		</tr>

							      		<tr>
							      			<?php
							      				$lpl = $tblpl->SelectWhere('status','active','','');
							      				foreach($lpl as $pl){
							      					// set empty value
							      					$plugin_checked = '';

							      					// get plugin usergroup
							      					// count array
							      					if(count(explode(",", $pl->usergroup)) > 1){
							      						// if data is array
														$plugin_usergroup = explode(",", $pl->usergroup);
														if (array_search($cusergroup->usergroup_id, $plugin_usergroup) !== false) {
														    $plugin_checked = 'checked="checked"';
														}
							      					}else{
							      						// if only one
							      						if($pl->usergroup == $cusergroup->usergroup_id){
							      							$plugin_checked = 'checked="checked"';
							      						}
							      					}
								      					

							      			?>
							      			<td>
												<label class="checkbox-inline">
													<input type="checkbox" class="px" name="plugin_<?php echo $pl->plugin_id?>" <?php echo $plugin_checked?>>
													<span class="lbl"><?php echo $pl->name?></span>
												</label>
							      			</td>
							      			<?php } ?>
							      		</tr>
							      		<?php } ?>

						      		</tbody>
						      	</table>
						      </div><!-- / .table-responisve -->
					      </div>
					  </div> <!-- / .form-group -->

					</div><!-- / .panel-body -->
					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savechanges?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="usergroup_id" value="<?php echo $cusergroup->usergroup_id?>" />
						  <input type="hidden" name="act" value="edit" />
						  <input type="hidden" name="mod" value="usergroup" />
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
									<input type="hidden" name="usergroup_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="usergroup" />
								</form>
							</div>
<?php
			break;

		default:
		$tb 	= new ElybinTable('elybin_usergroup');
		$lusergroup	= $tb->Select('usergroup_id','');
		$no = 1;
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo $lg_usergroup?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo $lg_setting?> / </span><?php echo $lg_usergroup?></span>
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
					<input type="hidden" name="mod" value="usergroup" />
		
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-users hidden-xs">&nbsp;&nbsp;</i><?php echo $lg_allusergroup?></span>
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
						    <th><?php echo $lg_name?></th>
						    <th><?php echo $lg_alias?></th>
						    <th><?php echo $lg_privilege?></th>
						    <th><span class="fa fa-user" id="tooltip-post" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_totaluser?>"></span></th>
						    <th><?php echo $lg_action?></th>
						  </tr>
						</thead>
						<tbody>
						<?php
						foreach($lusergroup as $cat){
							$tbluser = new ElybinTable('elybin_users');
							$banyak_user = 0;
							$banyak_user = $tbluser->GetRow('level',$cat->usergroup_id);
							
							$access_name = array("Post","Category","Tag","Comment","Contact","Media","Gallery","Album","Page","User","Setting");
							$access_id = "$cat->post,$cat->category,$cat->tag,$cat->comment,$cat->contact,$cat->media,$cat->gallery,$cat->album,$cat->page,$cat->user,$cat->setting";
							$access_id = explode(",", $access_id);
							$access_no = 0;
							$group_access = "";
							foreach ($access_id as $aid) {
								if($aid == 1){
									$group_access .= $access_name[$access_no].", ";
								}
								$access_no++;
							}
							$group_access = rtrim($group_access,", ");
							if(strlen($group_access) === 0){
								$group_access = "-";
							}


						?>
							<tr>
								<td><?php echo $no?></td>
								<td><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo $cat->usergroup_id?>|<?php echo $cat->name?>"><span class="lbl"></span></label></td>
								<td<?php if($cat->usergroup_id == 1){ echo ' class="text-danger"'; } ?>><?php echo $cat->name?></td>
								<td<?php if($cat->usergroup_id == 1){ echo ' class="text-danger"'; } ?>><?php echo $cat->alias?></td>
								<td<?php if($cat->usergroup_id == 1){ echo ' class="text-danger"'; } ?>><?php echo $group_access?></td>
								<td><?php echo $banyak_user?></td>
								<td>
									<div id="tooltip">
										<a href="?mod=usergroup&amp;act=edit&amp;id=<?php echo $cat->usergroup_id?>" class="btn btn-success btn-outline btn-sm<?php if($cat->usergroup_id == 1){ echo ' disabled'; } ?>" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_edit?>"><i class="fa fa-pencil-square-o"></i></a>
							    		<a href="?mod=usergroup&amp;act=del&amp;id=<?php echo $cat->usergroup_id?>&amp;clear=yes" class="btn btn-danger btn-outline btn-sm<?php if($cat->usergroup_id == 1){ echo ' disabled'; } ?>" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo $lg_delete?>"><i class="fa fa-times"></i></a>
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
<?php
		break;
		}
	}
}
?>
