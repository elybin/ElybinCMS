<?php
/* Short description for file
 * [ Module: Setting - Menu manager
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 Elybin.Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
if(empty($_SESSION['login'])){
	echo '403';
	header('location:../403.php');
}else{
$modpath 	= "app/menumanager/";
$action		= $modpath."proses.php";

// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
$level = $tbus->current()->level; // getting level from curent user

$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id',$level,'','');
$usergroup = $tbug->current()->setting;

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
			<h1><span class="text-light-gray"><?php echo $lg_setting?> / <?php echo $lg_menumanager?> / </span><?php echo $lg_addnew?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-bars"></i>&nbsp;&nbsp;<?php echo $lg_addnewmenu?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_title?>*</label>
					      <div class="col-sm-4">
							<input type="text" name="title"  class="form-control" placeholder="<?php echo $lg_title?>" required/></td>
					      </div>
					  </div> <!-- / .form-group -->

					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_address?>*</label>
					      <div class="col-sm-4">
							<input type="text" name="url"  class="form-control" placeholder="<?php echo $lg_address?>" required/></td>
					      </div>
					  </div> <!-- / .form-group -->

						<div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_parent?>*</label>
					      <div class="col-sm-4">
							<style><?php include("assets/stylesheets/select2.min.css"); ?></style>
							<select name="parent_id" id="multiselect-style">
								<option value="0"><?php echo $lg_noparent?></option>
					      	<?php
					      		$tblm = new ElybinTable('elybin_menu');
					      		$menu = $tblm->Select('','');
					      		foreach($menu as $m){
					      	?>
								<option value="<?php echo $m->menu_id; ?>"><?php echo $m->menu_title; ?></option>
					      	<?php
					      		}
					      	?>
							</select>
					      </div>
						</div> <!-- / .form-group -->

					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_class?></label>
					      <div class="col-sm-4">
							<input type="text" name="class"  class="form-control" placeholder="<?php echo $lg_class?>"/></td>
					      </div>
					  </div> <!-- / .form-group -->

					</div><!-- / .panel-body -->
					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savedata?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="act" value="add" />
						  <input type="hidden" name="mod" value="menumanager" />
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

		case 'edit':
		$id 	= $v->sql(@$_GET['id']);
		$id 	= $v->xss($id);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_menu');
		$comenu = $tb->GetRow('menu_id', $id);
		if(empty($id) OR ($comenu == 0)){
			er('<strong>'.$lg_ouch.'!</strong> '.$lg_notfound.' 404<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
			theme_foot();
			exit;
		}

		// get data
		$cmenu	= $tb->SelectWhere('menu_id',$id,'','');
		$cmenu	= $cmenu->current();
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo $lg_setting?> / <?php echo $lg_menumanager?> / </span><?php echo $lg_menuedit?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="menu" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-bars"></i>&nbsp;&nbsp;<?php echo $lg_editcurrentmenu?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_title?>*</label>
					      <div class="col-sm-4">
							<input type="text" name="title"  class="form-control" placeholder="<?php echo $lg_title?>" value="<?php echo $cmenu->menu_title?>" required/></td>
					      </div>
					  </div> <!-- / .form-group -->

					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_address?>*</label>
					      <div class="col-sm-4">
							<input type="text" name="url"  class="form-control" placeholder="<?php echo $lg_address?>" value="<?php echo $cmenu->menu_url?>" required/></td>
					      </div>
					  </div> <!-- / .form-group -->

						<div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_parent?>*</label>
					      <div class="col-sm-4">
							<select name="parent_id" id="multiselect-style">
								<option value="0"><?php echo $lg_noparent?></option>
					      	<?php
								$countchild = $tb->GetRow('parent_id',$id);
								if($countchild==0){
					      			$menu = $tb->SelectWhereAndNot('menu_id',$id,'parent_id',$id);
						      		foreach($menu as $m){
					      	?>
								<option value="<?php echo $m->menu_id; ?>"<?php if($cmenu->parent_id==$m->menu_id){echo ' selected=selected';}?>><?php echo $m->menu_title; ?></option>
					      	<?php
					      			}
					      		}
					      	?>
							</select>
					      </div>
						</div> <!-- / .form-group -->

					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_class?></label>
					      <div class="col-sm-4">
							<input type="text" name="class"  class="form-control" placeholder="<?php echo $lg_class?>"/></td>
					      </div>
					  </div> <!-- / .form-group -->

					  <?php
					  	$csubmenu = $tb->GetRow('parent_id',$id);
					  	if($csubmenu>0){

					  ?>
					  <br/>
		     	  	  <div class="col-sm-12">
						<div class="panel widget-tasks">
							<div class="panel-heading">
								<span class="panel-title"><i class="panel-title-icon fa fa-sort-amount-asc"></i><?php echo $lg_sortsubmenu?> - <?php echo $cmenu->menu_title?></span>
							</div> <!-- / .panel-heading -->
							<!-- Without vertical padding -->
							<style><?php include("assets/stylesheets/select2.min.css"); ?></style>
							<div class="panel-body no-padding-vr" id="sortable-list">
							<?php
							   $tblm = new ElybinTable('elybin_menu');
							   $tblm = $tblm->SelectWhere('parent_id',$cmenu->menu_id,'menu_position','ASC');
							   foreach($tblm as $f){
							   		$tblsub = new ElybinTable('elybin_menu');
							   		$tblsub = $tblsub->SelectWhere('parent_id',$f->menu_id,'menu_position','ASC');
							   		$submenu = "";
							   		foreach ($tblsub as $ff) {
							   			$submenu .= $ff->menu_title.", ";
							   		}
							   		$submenu = rtrim($submenu,", ");
							   		
							   		if(!empty($submenu)){
							   			$submenu = " <span>($submenu)</span>";
							   		}
							?>
								<div class="task">
									<div class="pull-right">
										<div id="tooltip">
											<a href="?mod=menumanager&amp;act=edit&amp;id=<?php echo $f->menu_id?>" class="btn btn-xs btn-outline btn-success" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_edit?>"><i class="fa fa-pencil-square-o"></i></a>
											<a href="?mod=menumanager&amp;act=del&amp;clear=yes&amp;back=<?php echo $id?>&amp;id=<?php echo $f->menu_id?>" class="btn btn-xs btn-outline btn-danger" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo $lg_delete?>"><i class="fa fa-times"></i></a>
										</div>
									</div>
									<div class="fa fa-arrows-v task-sort-icon"></div>
									<span class="task-title" id="<?php echo $f->menu_id?>"><?php echo $f->menu_title?><?php echo $submenu?></span>
								</div> <!-- / .task -->
							<?php } ?>
							</div> <!-- / .panel-body -->
						</div> <!-- / .panel -->
					</div><!-- / . col-sm-12 -->
					<?php } ?>
					</div><!-- / .panel-body -->
					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savechanges?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="id" value="<?php echo $cmenu->menu_id?>" />
						  <input type="hidden" name="act" value="edit" />
						  <input type="hidden" name="mod" value="menumanager" />
					  </div> <!-- / .form-footer -->
				</form><!-- / .form -->

 
				<!-- Delete Modal -->
				<div id="delete" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<?php echo $lg_loading?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal --> <!-- / Delete modal -->
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
								<?php
					   				$tblm = new ElybinTable('elybin_menu');
					   				$csubm = $tblm->GetRow('parent_id',$_GET['id']);
					   				if($csubm>0){
					   					$csubm = '<br/><br/><i class="text-danger">'.$lg_warningdeletesubmenu.'</i>';
					   				}else{
					   					$csubm = "";
					   				}
								?>
								<?php echo $lg_deletequestion?>
								<?php echo $csubm?>
								<hr></hr>
								<form action="<?php echo $action?>" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_yesdelete?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_cancel?></a>
									<input type="hidden" name="id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="back" value="<?php echo @$_GET['back']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="menumanager" />
								</form>
							</div>
<?php
			break;
		
		default:
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-bars"></i>&nbsp;&nbsp;<?php echo $lg_menumanager?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo $lg_setting?> / </span><?php echo $lg_menumanager?></span>
				</h1>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<div class="pull-right col-xs-12 col-sm-6 col-md-4">	
							<a href="?mod=<?php echo @$_GET['mod']?>&amp;act=add" class="pull-right btn btn-success btn-labeled" style="width: 100%">
							<span class="btn-label icon fa fa-plus"></span>&nbsp;&nbsp;<?php echo $lg_addnew?></a>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- ./Page Header -->

		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<div class="panel">
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-bars hidden-xs">&nbsp;&nbsp;</i><?php echo $lg_menumanager?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div> 
					<!-- ./Panel Heading -->
					
					<div class="panel-body">
						<?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
						<div class="col-sm-8">
							<div class="panel widget-tasks panel-dark-gray">
								<div class="panel-heading">
									<span class="panel-title"><i class="panel-title-icon fa fa-sort-amount-asc"></i><?php echo $lg_sortmenu?></span>
								</div> <!-- / .panel-heading -->
								<!-- Without vertical padding -->
								<div class="panel-body no-padding-vr" id="sortable-list">
								<?php
								   $tblm = new ElybinTable('elybin_menu');
								   $tblm = $tblm->SelectWhere('parent_id','0','menu_position','ASC');
								   foreach($tblm as $f){
										$tblsub = new ElybinTable('elybin_menu');
										$tblsub = $tblsub->SelectWhere('parent_id',$f->menu_id,'menu_position','ASC');
										$submenu = "";
										foreach ($tblsub as $ff) {
											//get sub sub menu
											$tblsubsub = new ElybinTable('elybin_menu');
											$csubsub = $tblsubsub->GetRow('parent_id',$ff->menu_id);
											if($csubsub>0){
												$csubsub = '<span class="text-light-gray">('.$csubsub.')</span> ';
											}else{
												$csubsub = "";
											}

											$submenu .= '- <a href="?mod=menumanager&amp;act=edit&amp;id='.$ff->menu_id.'">'.$ff->menu_title.$csubsub."</a><br/>";
											
										}
										$submenu = rtrim($submenu,"<br/>");
										
										if(!empty($submenu)){
											$submenu = " <span>$submenu</span>";

											
										}
								?>
									<div class="task">
										<div class="pull-right">
											<div id="tooltip">
												<a href="?mod=menumanager&amp;act=edit&amp;id=<?php echo $f->menu_id?>" class="btn btn-xs btn-outline btn-success" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_edit?>"><i class="fa fa-pencil-square-o"></i></a>
												<a href="?mod=menumanager&amp;act=del&amp;clear=yes&amp;id=<?php echo $f->menu_id?>" class="btn btn-xs btn-outline btn-danger" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo $lg_delete?>"><i class="fa fa-times"></i></a>
											</div>
										</div>
										<div class="fa fa-arrows-v task-sort-icon"></div>
										<span class="task-title" id="<?php echo $f->menu_id?>"><?php echo $f->menu_title?><br/><?php echo $submenu?></span>
									</div> <!-- / .task -->
									<hr style="margin: 0px -20px"/>
								<?php } ?>
								</div> <!-- / .panel-body -->
							</div> <!-- / .panel -->
						</div><!-- / . col-sm-8 -->
	
						<div class="col-sm-4">
							<div class="note note-info">
								<h1 class="fa fa-5x fa-sort-amount-asc text-default"></h1>
								<p><?php echo $lg_menumanagerhint?></p>
							</div>
						</div><!-- / . col-sm-4 -->
						
					</div> <!-- / .panel-body -->
				</div> <!-- / .panel -->
			</div><!-- / . col -->
		</div> <!-- /.row -->

				<!-- Delete Modal -->
				<div id="delete" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<?php echo $lg_loading?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal --> <!-- / Delete modal -->
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

<?php
			break;
		}
	}
}
?>
