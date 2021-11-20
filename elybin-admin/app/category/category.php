<?php
/* Short description for file
 * [ Module: Category
 *	
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System 
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 ---------------------------
 1.1.3
 - Redesign List
 - Add More detailed information
 - Add Basic List Order, Search and New Pagging
 - Fixing No Category bug
 - Fixing Temp Delete/Permanent Delete
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
// set global variable
$modpath 	= "app/category/";
$action		= $modpath."proses.php";

// string validation for security
$v 	= new ElybinValidasi();

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->category;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	// start here
	switch (@$_GET['act']) {
		case 'add':
?>		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray"><?php echo lg('You are here') ?>:</div>
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=category"><?php echo lg('Category') ?></a></li>
			<li class="active"><a href="?mod=category&amp;act=add"><?php echo lg('New Category') ?></a></li>
			
			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=category" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to Category') ?></a>
			<h1><?php echo lg('New Category')?></h1>
		</div> <!-- / .page-header -->
				
		<form action="<?php echo $action ?>" method="post" id="form">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-horizontal panel-wide depth-panel">
						<div class="panel-body">
							<div class="form-group">
							  <div class="col-sm-12 col-md-5">
								<input type="text" name="name" class="form-control" placeholder="<?php echo lg('Type category title here')?>" required/>
							  </div>
							  <div class="col-sm-12">
								<p class="help-block"><?php echo lg('Tips: Best to use title of category that not too short or too long and not using much of numerical and symbol character.')?></p>
							  </div>
							</div> <!-- / .form-group -->
						</div>	
						<div class="panel-footer">
							<button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save Data')?></button>
							<a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>
							<input type="hidden" name="act" value="add" />
							<input type="hidden" name="mod" value="category" />
						</div> <!-- / .form-footer -->
					</div>
				</div><!-- / .col -->
			</div>
		</form>
<?php

		break;

	case 'edit';
	$id 	= $v->xss(@$_GET['id']);
	$id 	= $v->sql($id);
	
	// check id exist or not
	$tb 	= new ElybinTable('elybin_category');
	$cocat = $tb->GetRow('category_id', $id);
	if(empty($id) OR ($cocat == 0)){
		er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
		theme_foot();
		exit;
	}
	
	$tb 	= new ElybinTable('elybin_category');
	$ccategory	= $tb->SelectWhere('category_id',$id,'','');
	$ccategory	= $ccategory->current();
?>		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray"><?php echo lg('You are here') ?>:</div>
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=category"><?php echo lg('Category') ?></a></li>
			<li class="active"><a href="?mod=category&amp;act=edit&amp;id=<?php echo $id ?>"><?php echo lg('Edit Category') ?></a></li>
			
			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=category" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to Category') ?></a>
			<h1><?php echo lg('Edit Category') ?></h1>
		</div> <!-- / .page-header -->
		
		<form action="<?php echo $action; ?>" method="post" id="form">
			<div class="row">
				<div class="col-sm-12">
					<div class="form-horizontal panel-wide depth-panel">
						<div class="panel-body">
							<div class="form-group">
							  <label class="col-sm-1 control-label"><?php echo lg('Title')?>*</label>
							  <div class="col-sm-12 col-md-5">
								<input type="text" name="name" class="form-control" value="<?php echo $ccategory->name?>" placeholder="<?php echo lg('Type category title here')?>" required/>
							  </div>
							  <div class="col-sm-12 col-sm-offset-1">
								<p class="help-block"><?php echo lg('Tips: Best to use title of category that not too short or too long and not using much of numerical and symbol character.')?></p>
							  </div>
							</div> <!-- / .form-group -->
							
							<div class="form-group">
							  <label class="col-sm-1 control-label"><?php echo lg('Status')?>*</label>
							  <div class="col-sm-12 col-md-5">
								<input type="checkbox" name="status" class="form-control" id="switcher-style" <?php if($ccategory->status=='active'){echo 'checked="checked"';}?>>
							  </div>
							  <div class="col-sm-12 col-sm-offset-1">
								<p class="help-block"><span class="fa fa-check"></span>&nbsp;<?php echo lg('Active') ?>&nbsp;<span class="fa fa-times"></span>&nbsp;<?php echo lg('Inactive') ?></p>
							  </div>
							</div> <!-- / .form-group -->
						</div>	
						<div class="panel-footer">
							<button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save Changes')?></button>
							<a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Back')?></a>
						  <input type="hidden" name="category_id" value="<?php echo $ccategory->category_id?>" />
						  <input type="hidden" name="act" value="edit" />
						  <input type="hidden" name="mod" value="category" />
						</div> <!-- / .form-footer -->
					</div>
				</div><!-- / .col -->
			</div>
		</form>
<?php
		break;

	case 'del':
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title text-danger"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?php echo lg('Delete Permanently') ?></h4>
							</div>
							<div class="modal-body">
								<p><?php echo lg('Are you sure you want delete permanently this item?')?></p>
								<br/>
								<i class="text-danger"><?php echo lg('This category may contain few related post. Delete Permanently or Move all post to Default Category?')?> 
								<?php 
								// get default category
								$tbc = new ElybinTable('elybin_category');
								echo '<br/>(' .lg('Default Category is').' "'.$tbc->SelectWhere('category_id', _op()->default_category)->current()->name.'")';
								?>
								</i>
								<hr/>
								<form action="<?php echo $action?>" method="post">
									<button type="submit" name="delete" value="yes" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Delete')?></button>&nbsp;
									<button type="submit" name="move" value="yes" class="btn btn-warning"><i class="fa fa-exchange"></i>&nbsp;<?php echo lg('Move')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									<input type="hidden" name="category_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="category" />
								</form>
							</div>
<?php
		break;

	default:
	$tb 	= new ElybinTable('elybin_category');
	
	$search = $v->sql(@$_GET['search']);	
		
	// search
	if(isset($_GET['search'])){
		$s_q = " && (`c`.`name` LIKE '%$search%' || `c`.`status` LIKE '%$search%')";
	}else{
		$s_q = "";
	}
	
	//if(!isset($_GET['filter'])){
	// normal query
	$que = "
	SELECT
	`c`.*
	FROM
	`elybin_category` as `c`
	WHERE 
	1=1
	$s_q
	";
	//}
	
	$coc = $tb->GetRowFullCustom($que);
	// modify query to pageable & shortable
	$oarr = array(
		'default' => '`c`.`category_id` DESC',
		'title' => '`c`.`name`',
		'status' => '`c`.`status`'
	);
	$que = _PageOrder($oarr, $que);
	$lc	= $tb->SelectFullCustom($que);

	// echo '<pre>'.$que.'</pre>';
?>		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray"><?php echo lg('You are here:') ?></div>
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li class="active"><a href="?mod=category"><?php echo lg('Category') ?></a></li>
			
			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-star"></i>&nbsp;&nbsp;<?php echo lg('Category')?></span>
					<span class="hidden-xs"><?php echo lg('Category') ?></span>
					<?php if($search!==''){ echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-light-gray text-sm">'.lg('Search result for').' <i>&#34;'.$search.'&#34;</i>';} ?>
				</h1>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<div class="pull-right col-xs-12 col-sm-6 col-md-4">	
							<a href="?mod=category&amp;act=add" class="pull-right btn btn-success btn-labeled" style="width: 100%">
							<span class="btn-label icon fa fa-plus"></span>&nbsp;&nbsp;<?php echo lg('New Category')?></a>
						</div>

					</div>
				</div>
			</div>
		</div> <!-- ./Page Header -->
	
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">	
				<!-- Tabs -->
				<ul class="nav nav-tabs nav-tabs-xs">
					<li<?php if(!isset($_GET['filter'])){echo' class="active"'; }?>>
						<?php 
						// count all category
						$totallc = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_category` as `c`
						");
						?>
						<a href="?mod=category"><?php echo lg('All') ?> <span class="badge badge-default"><?php echo $totallc ?></span></a>
					</li>
				</ul> <!-- / .nav -->
				<!-- Panel -->
				<div class="panel">
					<!-- ./Panel Heading -->
					<div class="panel-body">
					  <div class="table-primary table-responsive">
						
						<?php
						$orb = array(
							'title' => lg('Title'),
							'status' => lg('Status')
						);
						showOrder($orb);
						showSearch();
						?>
						<!-- delate -->
						<form action="<?php echo $action?>" method="post">
						<input type="hidden" name="act" value="multidel" />
						<input type="hidden" name="mod" value="category" />
						
						<table class="table table-bordered table-striped" id="results">
						 <thead>
						   <tr>
						    <th><i class="fa fa-square" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo lg('Check All')?>"></i></th>
						    <th><?php echo lg('Title') ?></th>
						    <th><?php echo lg('Related Post') ?></th>
						    <th><?php echo lg('Post Count')?></th>
						    <th><?php echo lg('Status')?></th>
						    <th><?php echo lg('Action')?></th>
						   </tr>
						 </thead>
						 <tbody>
						<?php

						$no = 0;
						foreach($lc as $cc){
							//$tbc 	= new ElybinTable('elybin_comments');
							//$ccom	= $tbc->GetRow('post_id',$cc->post_id);

							$tbp = new ElybinTable('elybin_posts');
							// count much related post
							$banyak_post = $tbp->GetRowFullCustom("
							SELECT
							*
							FROM 
							`elybin_posts` as `p`
							WHERE
							`p`.`category_id` = ".$cc->category_id." && 
							(`p`.`status` = 'draft' || `p`.`status` = 'publish')
							");
							// get related post
							$cpost = $tbp->SelectFullCustom("
							SELECT
							*
							FROM 
							`elybin_posts` as `p`
							WHERE
							`p`.`category_id` = ".$cc->category_id." && 
							(`p`.`status` = 'draft' || `p`.`status` = 'publish')
							ORDER BY `p`.`post_id` DESC 
							LIMIT 0,3
							");
						?>
						   <tr>
							<td width="1%"><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo $cc->category_id?>|<?php echo $cc->name?>"><span class="lbl"></span></label></td>
							<td width="20%"><?php echo $cc->name?></td>
							<td width="40%"><?php 
							foreach($cpost as $cp){
							?>
								<li>
									<a href="?mod=post&amp;act=edit&amp;id=<?php echo $cp->post_id ?>"><i><?php echo $cp->title ?></i></a>&nbsp; <i class="fa fa-pencil"></i>
								</li>
								<?php
							}	
							// if related post more than 3
							if($banyak_post > 3){
								echo '<a href="?mod=post&amp;search='.$cc->name.'"><i>'.lg('More...').'</i></a>';
							}
							else if($banyak_post == 0){
								echo '-';
							}
							?></td>
							<td><?php echo $banyak_post . ' ' . lg('Posts') ?></td>
							<td><?php echo $cc->status?></td>
							<td>
								<div id="tooltip">
									<a href="?mod=category&amp;act=edit&amp;id=<?php echo $cc->category_id?>" class="btn btn-success btn-outline btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo lg('Edit') ?>"><i class="fa fa-pencil-square-o"></i></a>&nbsp;
							    	<a href="?mod=category&amp;act=del&amp;id=<?php echo $cc->category_id?>&amp;clear=yes" class="btn btn-danger btn-outline btn-sm" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo lg('Delete')?>"><i class="fa fa-times"></i></a>
								</div>
							</td>
						   </tr>
						<?php
							$no++;
						}
						
						
						if($no < 1){
							echo '<tr><td colspan="8">'. lg('Nothing can be shown.').'</td></tr>';
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
									<h4 class="modal-title text-danger"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?php echo lg('Delete Permanently') ?></h4>

									</div>
									<div class="modal-body">
										<p><?php echo lg('Are you sure you want delete permanently this item?')?></p>
										<div id="deltext"></div>
										<br/>
										<i class="text-danger"><?php echo lg('This category may contain few related post. Delete Permanently or Move all post to Default Category?')?> 
										<?php 
										// get default category
										$tbc = new ElybinTable('elybin_category');
										echo '<br/>(' .lg('Default Category is').' "'.$tbc->SelectWhere('category_id', _op()->default_category)->current()->name.'")';
										?>
										</i>
										<hr/>
										<button type="submit" name="delete" value="yes" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Delete')?></button>&nbsp;
										<button type="submit" name="move" value="yes" class="btn btn-warning"><i class="fa fa-exchange"></i>&nbsp;<?php echo lg('Move')?></button>
				
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
						
						
						
						<?php showPagging($coc) ?>
						
					  </div> <!-- /.table-responsive -->


					</div><!-- / .panel-body -->
				</div><!-- / .panel -->
				<!-- Delete Modal -->
				<div id="delete" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-sm">
						<div class="modal-content">
							<?php echo lg('Loading')?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / Delete Modal -->
			</div><!-- / .col -->
		</div><!-- / .row -->
<?php
		break;

		}
	}
}
?>
