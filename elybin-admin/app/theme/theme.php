<?php
/* Short description for file
 * [ Module: Theme
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/theme/";
$action		= $modpath."proses.php";

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->setting;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{

	// require
	require_once('inc/main.func.php');

	// start here
	switch (@$_GET['act']) {
		case 'add':
?>
<?php
		// check extended themes
		// scan `/elybin-file/ext/` directory
		$dir = scandir("../elybin-file/ext");
		$file_found = false;
		$file_name = array();
		foreach($dir as $d){
			if(substr($d, 0, 4) == "thm." && substr($d, -4) == ".zip"){
				array_push($file_name, array('file_name' => $d));
				$file_found = true;
			}
		}
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo lg('Setting')?> / <?php echo lg('Themes')?> / </span><?php echo lg('Add New')?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">

				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-tint"></i>&nbsp;&nbsp;<?php echo lg('Add New Themes')?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <div class="note note-info"><?php echo lg('Get more themes at our store.')?>&nbsp;<a href="http://store.elybin.com/theme" target="_blank">http://store.elybin.com/theme</a></div>
					<?php
						if($file_found){
							$fst = true;
					?>
					  <div class="form-group">
					      <label class="col-sm-2 control-label">Tema Terdeteksi</label>
					      <div class="col-sm-10">
							<p>
					<?php
						foreach($file_name as $f){
					?>
								<label class="radio">
									<input type="radio" name="file_name" value="<?php echo $f['file_name']?>" class="px" <?php if($fst){echo ' checked="checked"';}?>>
									<span class="lbl"><?php echo $f['file_name']?></span>
							</label>
					<?php
						$fst = false;
						}
					?>
							</p>
					      </div>
					  </div> <!-- / .form-group -->
					<?php

					}else{
					?>
					<div class="text-center panel-padding">
						<i class="fa fa-5x fa-tint"></i><br/>
						<b><?php echo lg('No Themes Detected.')?></b><br/>
					    <?php echo lg('Try to put downloaded plugin inside <code>elybin-file/ext/</code> directory.') ?>
					</div>
					<?php } ?>
					  	</div> <!-- / .panel-body -->

					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"<?php if(!$file_found){ echo ' disabled';} ?>><i class="fa fa-check"></i>&nbsp;<?php echo lg('Install')?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>
						  <input type="hidden" name="act" value="add" />
						  <input type="hidden" name="mod" value="theme" />
					  </div> <!-- / .form-footer -->
					</div> <!-- / .panel -->
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

		case 'active';
		$val 	= new ElybinValidasi();
		$id 	= $val->validasi($_GET['id'],'sql');
		$id 	= $val->validasi($id,'sql');

		$tb 	= new ElybinTable('elybin_themes');
		$ccon	= $tb->SelectWhere('status','deactive','','');
		foreach ($ccon as $c){
			$stat = "'active'";
			$data = array('status' => 'deactive');
			$tb->Update($data,'status',$stat);
		}

		$ccon	= $tb->SelectWhere('theme_id',$id,'','');
		$ccon	= $ccon->current();
		$status = $ccon->status;
		if($status == 'active'){
			$data = array('status' => 'deactive');
			$tb->Update($data,'theme_id',$id);
		}else{
			$data = array('status' => 'active');
			$tb->Update($data,'theme_id',$id);
		}
		header('location:./admin.php?mod='.$mod);
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
									<input type="hidden" name="theme_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="theme" />
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
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-tint"></i>&nbsp;&nbsp;<?php echo lg('Themes')?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo lg('Setting')?> / </span><?php echo lg('Themes')?></span>
				</h1>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<div class="pull-right col-xs-12 col-sm-6 col-md-4">
							<a href="?mod=<?php echo @$_GET['mod']?>&amp;act=add" class="hide pull-right btn btn-success btn-labeled" style="width: 100%">
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
						<span class="panel-title"><i class="fa fa-tint hidden-xs">&nbsp;&nbsp;</i><?php echo lg('All themes')?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div>
					<!-- ./Panel Heading -->

					<div class="panel-body">
						<div class="col-sm-12">
							<!-- Tabs for md -->
							<ul class="nav nav-tabs nav-tabs-simple hidden-xs hidden-sm">
								<li class="pull-right">
									<a href="#adminpanel-tabs" data-toggle="tab"><?php echo lg('Admin Panel'); ?> <span class="badge badge-info">1</span></a>
								</li>
								<li class="active pull-right">
									<a href="#frontend-tabs" data-toggle="tab"><?php echo lg('Front End'); ?> <span class="badge badge-info"><?php e(	count(	@get_available_template()['data']	)	) ?></span></a>
								</li>
							</ul> <!-- / .nav -->
							<!-- / Tabs for md -->

							<!-- Tabs for xs sm -->
							<ul class="nav nav-tabs nav-tabs-simple nav-justified visible-xs visible-sm">
								<li>
									<a href="#adminpanel-tabs" data-toggle="tab"><?php echo lg('Admin Panel'); ?> <span class="badge badge-info">1</span></a>
								</li>
								<li class="active">
									<a href="#frontend-tabs" data-toggle="tab"><?php echo lg('Front End'); ?> <span class="badge badge-info"><?php e(	count(	@get_available_template()['data']	)	) ?></span></a>
								</li>
							</ul> <!-- / .nav -->
							<!-- / Tabs xs sm -->

						</div>
						<div class="clearfix form-group-margin"></div> <!-- Margin -->

						<!-- Tab Content -->
						<div class="tab-content">
							<div class="tab-pane fade active in" id="frontend-tabs">
								<?php
								/** Getting available template **/
								if(!isset(get_available_template()['error'])){
									foreach(get_available_template()['data'] as $t){ ?>
								<div class="col-xs-12 col-sm-6 col-md-3">
									<div class="stat-panel">
										<div class="stat-row">
											<!-- Info background, without padding, horizontally centered text, super large text -->
											<div class="stat-cell bg-primary padding-sm text-left text-bg">
												<span class="pull-right">
													<?php
													/** If themes activated */
													if(	$t['active']	): ?>
													<?php _e('Active') ?> <span class="fa fa-check-circle" id="equal-height"></span>
													<?php else: ?>
													<form action="app/theme/proses.php" method="post">
														<div class="btn-group">
														<a href="?mod=theme&amp;act=del&amp;id=<?php e(	$t['theme_id']	) ?>&amp;clear=yes" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete"  data-placement="left" data-original-title="<?php _e('Delete') ?>"><i class="fa fa-trash-o"></i></a>
														<button class="btn btn-sm" data-placement="left" data-original-title="<?php _e('Activate') ?>"><span class="fa fa-eye"></span></button>
														</div>
														<input type="hidden" name="theme_id" value="<?php e(	$t['theme_id'] 	) ?>" />
														<input type="hidden" name="act" value="active" />
														<input type="hidden" name="mod" value="theme" />
													</form>
												<?php endif; ?>
												</span>
												<span class="">
													<?php e(	$t['theme_name']	) ?>
												</span>
											</div>
										</div> <!-- /.stat-row -->
										<div class="stat-row">
											<!-- Bordered, without top border, horizontally centered text, large text -->
											<div class="stat-cell bordered no-border-t text-center text-sm">
												<img src="<?php e($t['screenshoot']) ?>" class="img-thumbnail grid-gutter-margin-b">
												<p class="no-margin-hr">
													<?php e( $t['description'] ) ?><br/>
													<a href="<?php e(	$t['theme_uri']	) ?>" target="_blank"><?php _e('Detail') ?>&nbsp;<i class="fa fa-external-link"></i></a>
													<br><br>
													<?php printf( __('By %s'), (empty($t['author_uri']) ? $t['author'] : '<a href="'.$t['author_uri'].'">'.$t['author'].' <i class="fa fa-external-link"></i></a>'	) )?> <br>
												</p>
											</div>
										</div> <!-- /.stat-row -->
									</div> <!-- /.stat-panel -->
								</div> <!-- /.col-sm-3 -->
							<?php
								}
							}
							?>
							</div><!-- ./tab -->
							<div class="tab-pane fade" id="adminpanel-tabs">
								<style><?php include("assets/stylesheets/clean.min.css"); ?></style>
								<div class="demo-themes-row" id="demo-themes">
									<?php
									// get option
									$getoption1 = new ElybinTable('elybin_options');
									$admin_theme = $getoption1->SelectWhere('name','admin_theme','','')->current()->value;

									$theme_admin = json_decode('
									[
									  { "name": "clean",  "title": "Clean", "img": "assets/full/themes/clean.png" }
									]
									');
									for($i=0; $i < count($theme_admin); $i++){
									?>
									<div class="col-xs-4 col-sm-2 col-md-2 text-center" style="margin-bottom:20px">
										<a href="#" class="demo-theme<?php if($admin_theme == $theme_admin[$i]->name){ ?> text-success<?php } ?>" data-theme="<?php echo $theme_admin[$i]->name; ?>">
											<div class="theme-preview">
												<img src="<?php echo $theme_admin[$i]->img; ?>" alt="" class="rounded img-thumbnail" width="100%" >
											</div>
											<div class="overlay"></div>
											<span><?php echo $theme_admin[$i]->title; ?></span>
										</a>
									</div>
									<?php } ?>
								</div>
							</div>
						</div> <!-- / .tab-content -->
					</div>
				</div> <!-- /.panel -->
			</div> <!-- /.col -->
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
								<h4 class="modal-title"><?php echo lg('Help')?></h4>
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
