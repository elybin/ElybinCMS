<?php
/* Short description for file
 * [ Module: Setting - Menu manager
 *
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 */
if(empty($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/menumanager/";
$action		= $modpath."proses.php";


// get usergroup privilage/access from current user to this module
$usergroup = _ug()->setting;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	// start here
	$v 	= new ElybinValidasi();
	switch (@$_GET['act']) {
		case 'add':
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo lg('Setting')?> / <?php echo lg('Menu Manager')?> / </span><?php echo lg('Add New')?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-bars"></i>&nbsp;&nbsp;<?php echo lg('Add new menu')?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
						<div class="col-sm-8">
							<div class="form-group">
									<label class="col-sm-2 control-label"><?php echo lg('Title')?>*</label>
									<div class="col-sm-6">
								<input type="text" name="title"  class="form-control" placeholder="<?php echo lg('Title')?>" required/></td>
									</div>
							</div> <!-- / .form-group -->

							<div class="form-group">
									<label class="col-sm-2 control-label"><?php echo lg('Address')?>*</label>
									<div class="col-sm-6">
								<input type="text" name="url"  class="form-control" placeholder="<?php echo lg('Address')?>" required/></td>
									</div>
							</div> <!-- / .form-group -->

							<div class="form-group">
									<label class="col-sm-2 control-label"><?php echo lg('Parent')?>*</label>
									<div class="col-sm-6">
								<style><?php include("assets/stylesheets/select2.min.css"); ?></style>
								<select name="parent_id" id="multiselect-style" class="from-control">
									<option value="0"><?php echo lg('No Parent')?></option>
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
									<label class="col-sm-2 control-label"><?php echo lg('CSS Class')?></label>
									<div class="col-sm-6">
								<input type="text" name="class"  class="form-control" placeholder="<?php echo lg('CSS Class')?>"/></td>
									</div>
							</div> <!-- / .form-group -->
						</div>
						<div class="col-sm-4">
							<div class="panel panel-dark panel-success">
								<div class="panel-heading">
									<i class="fa fa-info-circle pull-right"></i><?php _e('Tips') ?>
								</div>
								<div class="panel-body">
									<?php _e('You can also using <b>URL Address Dynamic Expression</b> (<i>Address that changed automatically every updating content</i>). Follow this step:') ?>
									<ol>
										<li><b><?php _e('Section Name') ?></b>: <?php _e('Determine the section, available section names: <i>post, page, category, tag, archive, gallery, album.</i>') ?></li>
										<li><b><?php _e('Content ID') ?></b>: <?php _e('Also put your content id. <i>(You can check it while using Dynamic URL).</i> For example: <code>https://elybin.github.io/?page_id=<b>this_is_content_id</b></code>') ?></li>
										<li><b><?php _e('Put it together') ?></b>: <?php _e('Basicly URL Dynnamic Expression using this formula. <b>{&quot;section_name&quot;:&quot;content_id&quot;}</b> for example: <code>{&quot;post&quot;:&quot;1&quot;}</code>') ?></li>
									</ol>
								</div>
							</div>
						</div>
					</div><!-- / .panel-body -->
					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save')?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>
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
								<h4 class="modal-title"><?php echo lg('Help Title')?></h4>
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
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}

		// get data
		$cmenu	= $tb->SelectWhere('menu_id',$id,'','');
		$cmenu	= $cmenu->current();
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo lg('Setting')?> / <?php echo lg('Menu Manager')?> / </span><?php echo lg('Menu edit')?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="menu" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-bars"></i>&nbsp;&nbsp;<?php echo lg('Edit current menu')?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
						<div class="col-sm-8">
						  <div class="form-group">
						      <label class="col-sm-2 control-label"><?php echo lg('Title')?>*</label>
						      <div class="col-sm-6">
								<input type="text" name="title"  class="form-control" placeholder="<?php echo lg('Title')?>" value="<?php echo $cmenu->menu_title?>" required/></td>
						      </div>
						  </div> <!-- / .form-group -->

						  <div class="form-group">
						      <label class="col-sm-2 control-label"><?php echo lg('Address')?>*</label>
						      <div class="col-sm-6">
								<input type="text" name="url"  class="form-control" placeholder="<?php echo lg('Address')?>" value="<?php _e( htmlspecialchars( $cmenu->menu_url) )?>" required/></td>
						      </div>
						  </div> <!-- / .form-group -->

							<div class="form-group">
						      <label class="col-sm-2 control-label"><?php echo lg('Parent')?>*</label>
						      <div class="col-sm-6">
								<style><?php include("assets/stylesheets/select2.min.css"); ?></style>
								<select name="parent_id" id="multiselect-style" class="form-control">
									<option value="0"><?php echo lg('No Parent')?></option>
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
						      <label class="col-sm-2 control-label"><?php echo lg('CSS Class')?></label>
						      <div class="col-sm-6">
								<input type="text" name="class"  class="form-control" placeholder="<?php echo lg('CSS Class')?>"/></td>
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
									<span class="panel-title"><i class="panel-title-icon fa fa-sort-amount-asc"></i><?php echo lg('Sort Submenu')?> - <?php echo $cmenu->menu_title?></span>
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
												<a href="?mod=menumanager&amp;act=edit&amp;id=<?php echo $f->menu_id?>" class="btn btn-xs btn-outline btn-success" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo lg('Edit')?>"><i class="fa fa-pencil-square-o"></i></a>
												<a href="?mod=menumanager&amp;act=del&amp;clear=yes&amp;back=<?php echo $id?>&amp;id=<?php echo $f->menu_id?>" class="btn btn-xs btn-outline btn-danger" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo lg('Delete')?>"><i class="fa fa-times"></i></a>
											</div>
										</div>
										<div class="fa fa-arrows-v task-sort-icon"></div>
										<span class="task-title" id="<?php echo $f->menu_id?>"><?php echo $f->menu_title?><?php echo $submenu?></span>
									</div> <!-- / .task -->
								<?php } ?>
								</div> <!-- / .panel-body -->
							</div> <!-- / .panel -->
						</div><!-- / . col-sm-1  -->
					<?php } ?>
					</div>
					<div class="col-sm-4">
						<div class="panel panel-dark panel-success">
							<div class="panel-heading">
								<i class="fa fa-info-circle pull-right"></i><?php _e('Tips') ?>
							</div>
							<div class="panel-body">
								<?php _e('You can also using <b>URL Address Dynamic Expression</b> (<i>Address that changed automatically every updating content</i>). Follow this step:') ?>
								<ol>
									<li><b><?php _e('Section Name') ?></b>: <?php _e('Determine the section, available section names: <i>post, page, category, tag, archive, gallery, album.</i>') ?></li>
									<li><b><?php _e('Content ID') ?></b>: <?php _e('Also put your content id. <i>(You can check it while using Dynamic URL).</i> For example: <code>https://elybin.github.io/?page_id=<b>this_is_content_id</b></code>') ?></li>
									<li><b><?php _e('Put it together') ?></b>: <?php _e('Basicly URL Dynnamic Expression using this formula. <b>{&quot;section_name&quot;:&quot;content_id&quot;}</b> for example: <code>{&quot;post&quot;:&quot;1&quot;}</code>') ?></li>
								</ol>
							</div>
						</div>
					</div>
					</div><!-- / .panel-body -->
					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save Changes')?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>
						  <input type="hidden" name="id" value="<?php echo $cmenu->menu_id?>" />
						  <input type="hidden" name="act" value="edit" />
						  <input type="hidden" name="mod" value="menumanager" />
					  </div> <!-- / .form-footer -->
				</form><!-- / .form -->


				<!-- Delete Modal -->
				<div id="delete" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<?php echo lg('Loading')?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal --> <!-- / Delete modal -->
				<!-- Help modal -->
				<div id="help" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
								<h4 class="modal-title"><?php echo lg('Help Title')?></h4>
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
							<h4 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?php echo lg('Delete Permanently')?></h4>
							</div>
							<div class="modal-body">
								<?php echo lg('Are you sure you want delete permanently this item. This action cannot be undone.')?>
								<?php
					   				$tblm = new ElybinTable('elybin_menu');
					   				$csubm = $tblm->GetRow('parent_id',$_GET['id']);
					   				if($csubm>0){
					   					$csubm = '<br/><br/><i class="text-danger">'.lg('Related sub menu will also deleted.').'</i>';
					   				}else{
					   					$csubm = "";
					   				}
								?>
								<?php echo $csubm?>
								<hr></hr>
								<form action="<?php echo $action?>" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Delete')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
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
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-bars"></i>&nbsp;&nbsp;<?php echo lg('Menu Manager')?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo lg('Setting')?> / </span><?php echo lg('Menu Manager')?></span>
				</h1>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<div class="pull-right col-xs-12 col-sm-6 col-md-4">
							<a href="?mod=<?php echo @$_GET['mod']?>&amp;act=add" class="pull-right btn btn-success btn-labeled" style="width: 100%">
							<span class="btn-label icon fa fa-plus"></span>&nbsp;&nbsp;<?php echo lg('Add New')?></a>
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
						<span class="panel-title"><i class="fa fa-bars hidden-xs">&nbsp;&nbsp;</i><?php echo lg('Menu Manager')?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div>
					<!-- ./Panel Heading -->

					<div class="panel-body">
						<div class="col-sm-8">
							<div class="panel widget-tasks panel-dark-gray">
								<div class="panel-heading">
									<span class="panel-title"><i class="panel-title-icon fa fa-sort-amount-asc"></i><?php echo lg('Sort Menu')?></span>
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
												<a href="?mod=menumanager&amp;act=edit&amp;id=<?php echo $f->menu_id?>" class="btn btn-xs btn-outline btn-success" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo lg('Edit')?>"><i class="fa fa-pencil-square-o"></i></a>
												<a href="?mod=menumanager&amp;act=del&amp;clear=yes&amp;id=<?php echo $f->menu_id?>" class="btn btn-xs btn-outline btn-danger" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo lg('Delete')?>"><i class="fa fa-times"></i></a>
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
								<p><?php echo lg('Menu Manager')?></p>
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
							<?php echo lg('Loading')?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal --> <!-- / Delete modal -->
				<!-- Help modal -->
				<div id="help" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-lg">
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
								<h4 class="modal-title"><?php echo lg('Help Title')?></h4>
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
