<?php
/* Short description for file
 * [ Module: Setting - Plugin
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/plugin/";
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
	$next = @$_GET['next'];
	
	switch (@$_GET['act']) {
		case 'add':
		

		// check exteded plugin
		// scan `/elybin-file/ext/` directory
		$dir = scandir("../elybin-file/ext");
		$file_found = false;
		$file_name = array();
		foreach($dir as $d){
			if(substr($d, 0, 4) == "com." && substr($d, -4) == ".zip"){
				array_push($file_name, array('file_name' => $d));
				$file_found = true;
			}
		}
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo lg('Setting')?> / <?php echo lg('Plugin')?> / </span><?php echo lg('Add New')?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">

				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-puzzle-piece"></i>&nbsp;&nbsp;<?php echo lg('Add New Plugin')?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <div class="note note-info"><?php echo lg('Get more plugin.')?>&nbsp;<a href="http://store.elybin.com/plugin" target="_blank">http://store.elybin.com/plugin</a></div>
					<?php
						if($file_found){
							$fst = true;
					?>
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo lg('Plugin Detected') ?></label>
					      <div class="col-sm-10">
							<p>
							<?php
								foreach($file_name as $f){
							?>
								<label class="radio">
									<input type="radio" name="file_name" value="<?php echo $f['file_name']?>" class="px"<?php if($fst){echo ' checked="checked"';}?>>
									<span class="lbl"><?php echo $f['file_name']?></span>
							</label>
					<?php 
						$fst = false;
						} 
					?>
							</p>
					      </div>
					  </div> 
					<?php
						
					}else{
					?>
					<div class="text-center panel-padding">
						<i class="fa fa-5x fa-puzzle-piece"></i><br/>
						<b><?php echo lg('No Plugin Detected.')?></b><br/>
					    <?php echo lg('Try to put downloaded plugin inside <code>elybin-file/ext/</code> directory.') ?>
					</div>
					<?php } ?>
					</div><!-- / .panel-body -->
					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"<?php if(!$file_found){ echo ' disabled';} ?>><i class="fa fa-check"></i>&nbsp;<?php echo lg('Install')?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>
						  <input type="hidden" name="act" value="add" />
						  <input type="hidden" name="mod" value="plugin" />
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
		case 'view':
		
		$id 	= $v->sql($_GET['id']);
		$id 	= $v->sql($id);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_plugins');
		$coplugin = $tb->GetRow('plugin_id', $id);
		if(empty($id) OR ($coplugin == 0)){
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}

		// get data
		$cplug	= $tb->SelectWhere('plugin_id',$id,'','');
		$cplug	= $cplug->current();

		$description = html_entity_decode($cplug->description);
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-external-link-square"></i>&nbsp;&nbsp;<?php echo lg('Plugin Detail')?></h4>
							</div>
							<div class="modal-body">
								<table class="table">
									<tr>
										<td class="no-border-t"><i><?php echo lg('Plugin Name') ?></i></td>
										<td class="no-border-t"><?php echo $cplug->name?></td>
									</tr>	
									<tr>
										<td><i><?php echo lg('Version') ?></i></td>
										<td><?php echo $cplug->version?></td>
									</tr>		
									<tr>
										<td><i><?php echo lg('Developer')?></i></td>
										<td><?php echo $cplug->author?> - <?php echo $cplug->url?></td>
									</tr>
									<tr>
										<td><i><?php echo lg('Plugin Type')?></i></td>
										<td><?php echo $cplug->type?> (<?php echo $cplug->status?>)</td>
									</tr>
									<tr>
										<td><i><?php echo lg('Description') ?></i></td>
										<td><?php echo $description?></td>
									</tr>
								</table>
								<hr></hr>
								<div class="form-group no-margin-b">
									<button class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></button>
								</div>
							</div>
<?php
			break;

		case 'install':
		$id 	= $v->sql(@$_GET['id']);
		$id 	= $v->sql($id);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_plugins');
		$coplugin = $tb->GetRow('plugin_id', $id);
		if(empty($id) OR ($coplugin == 0)){
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}

		// get data
		$cplug	= $tb->SelectWhere('plugin_id',$id,'','');
		$cplug	= $cplug->current();

		$description = html_entity_decode($cplug->description);
		if($cplug->status !== 'install'){
			echo lg('Plugin already installed.');
		}else{
?>	
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;<?php echo lg('Install Confirmation')?></h4>
							</div>
							<div class="modal-body">
								<p class="alert"><?php echo lg('Do you want to install this plugin?')?></p>
								<table class="table">
									<tr>
										<td><i><?php echo lg('Plugin Name')?></i></td>
										<td><?php echo $cplug->name?></td>
									</tr>	
									<tr>
										<td><i><?php echo lg('Version') ?></i></td>
										<td><?php echo $cplug->version?></td>
									</tr>		
									<tr>
										<td><i><?php echo lg('Developer')?></i></td>
										<td><?php echo $cplug->author?> - <?php echo $cplug->url?></td>
									</tr>
									<tr>
										<td><i><?php echo lg('Plugin Type')?></i></td>
										<td><?php echo $cplug->type?> (<?php echo $cplug->status?>)</td>
									</tr>
									<tr>
										<td><i><?php echo lg('Description') ?></i></td>
										<td><?php echo $description?></td>
									</tr>
								</table>
								<hr></hr>
								<div class="form-group no-margin-b">
									<form action="<?php echo $action?>" method="post" id="form">
										<button type="submit" class="btn btn-success"><i class="fa fa-sign-in"></i>&nbsp;<?php echo lg('Yes, Install')?></button>
										<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>
										<input type="hidden" name="plugin_id" value="<?php echo $_GET["id"]?>" />
										<input type="hidden" name="act" value="install" />
										<input type="hidden" name="mod" value="plugin" />
									</form>
								</div>
							</div>
<?php
	}
			break;

		case 'del':
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?php echo lg('Uninstall Plugin')?></h4>
							</div>
							<div class="modal-body">
								<?php echo lg('Are you sure to uninstall this plugin?')?>
								<hr></hr>
								<form action="<?php echo $action?>" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Delete')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal" onClick="hide_modal();"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									<input type="hidden" name="plugin_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="plugin" />
								</form>
							</div>


<?php
			break;
		
		default:
		$tb 	= new ElybinTable('elybin_plugins');
		$lplugin	= $tb->Select('plugin_id','DESC');
		$no = 1;
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-puzzle-piece"></i>&nbsp;&nbsp;<?php echo lg('Plugin')?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo lg('Setting')?> / </span><?php echo lg('Plugin')?></span>
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
				<form action="<?php echo $action?>" method="post" class="panel">
					<input type="hidden" name="act" value="multidel"/>
					<input type="hidden" name="mod" value="page" />
					
					<!-- Panel Heading -->
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-puzzle-piece hidden-xs">&nbsp;&nbsp;</i><?php echo lg('All plugins')?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo lg('Help')?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div> 
					<!-- ./Panel Heading -->
					
					<div class="panel-body">
					  <div class="table-responsive">
						<table class="table table-hover" id="results">
						 <thead>
						  <tr>
						    <th>#</th>
						    <th><?php echo lg('Plugin Name')?></th>
							<th><?php echo lg('Developer')?></th>
							<th><?php echo lg('Plugin Type')?></th>
							<th><?php echo lg('Status')?></th>
							<th><?php echo lg('Action')?></th>
						  </tr>
						</thead>
						<tbody>
<?php
		foreach($lplugin as $cat){
			if($cat->status !== 'install'){
				$link = '<a href="?mod='.$cat->alias.'&amp;act=option" class="btn btn-success btn-outline btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="'.lg('Setting').'"><i class="fa fa-pencil-square-o"></i></a>';
			}else{
				$link = '<a href="?mod=plugin&amp;act=install&amp;id='.$cat->plugin_id.'&amp;clear=yes" class="btn btn-success btn-outline btn-sm" data-toggle="modal" data-target="#install" data-placement="bottom" data-toggle="tooltip" data-original-title="'.lg('Install').'"><i class="fa fa-sign-in"></i></a>';
			}
?>
						  <tr>
					 		<td><?php echo $no?></td>
							<td><?php echo $cat->name?> (<?php echo $cat->version?>)</td>
							<td><?php echo $cat->author?></td>
							<td><?php echo $cat->type?></td>
							<td><?php echo $cat->status?></td>
							<td>
								<div id="tooltip">
									<?php echo $link?> 
									<a href="?mod=plugin&amp;act=view&amp;id=<?php echo $cat->plugin_id?>&amp;clear=yes" class="btn btn-success btn-outline btn-sm" data-toggle="modal" data-target="#view" data-original-title="<?php echo lg('View')?>"><i class="fa fa fa-external-link-square"></i></a>
								    <a href="?mod=plugin&amp;act=del&amp;id=<?php echo $cat->plugin_id?>&amp;clear=yes" class="btn btn-danger btn-outline btn-sm" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo lg('Delete')?>"><i class="fa fa-times"></i></a>
								</div>
							</td>
				  		  </tr>
<?php

			$no++;
		}
?>	
						 </tbody>
						</table>
					  </div> <!-- /.table-responsive -->
						<div class="alert" id="notfound"><strong><?php echo lg('Nothing can be shown.')?></strong></div>
						<hr/>
						<div class="col-md-4 col-md-offset-8 text-right">
							<ul class="pagination pagination-xs" id="page-nav">
							</ul>
						</div>
					</div><!-- / .panel-body -->
				</form>
				<!-- Delete Modal -->
				<div id="delete" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<?php echo lg('Loading') ?>
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- View Modal -->
				<div id="view" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<?php echo lg('Loading') ?>
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / View Modal -->
				<!-- Install Modal -->
				<div id="install" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<?php echo lg('Loading') ?>
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / Install Modal -->
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
			</div><!-- / .col -->
		</div><!-- / .row -->
<?php

		break;
		}
	}
}
?>
