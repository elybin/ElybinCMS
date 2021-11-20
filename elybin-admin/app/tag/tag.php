<?php
/* Short description for file
 * [ Module: Tag
 *	
 * Elybin CMS (www.elybin.github.io) - Open Source Content Management System 
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim. <elybin.inc@gmail.com>
 ---------------------------
 1.1.3
 - Redesign List
 - Clear unused tags
 - Removing add Tags (You can add tags in post module)
 - Add Mostly, Rare and Unused Data
 - Add Clear Unused Tags
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/tag/";
$action		= $modpath."proses.php";

// string validation for security
$v 	= new ElybinValidasi();

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->tag;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{

	// module start here 
	switch (@$_GET['act']) {
		// shut down since 1.1.3
/*		
		case 'add':
		exit;
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
				

		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" id="form">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-tags"></i>&nbsp;&nbsp;<?php echo $lg_addnewtag?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <div class="form-group">
					      <label class="col-sm-2 control-label"><?php echo $lg_title?>*</label>
					      <div class="col-sm-10">
					      	<input type="text" name="name" placeholder="<?php echo $lg_title?>" class="form-control" placeholder="<?php echo $langcategory6?>" required/>
					      	<p class="help-block"><?php echo $lg_titletaghint?></p>
					      </div>
					  </div> <!-- / .form-group -->
					</div><!-- / .panel-body -->

					  <div class="panel-footer">
						  <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_savedata?></button>
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="act" value="add" />
						  <input type="hidden" name="mod" value="tag" />
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

		// shutdown at 1.1.3
		case 'del':
		exit;
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?php echo $lg_deletetitle?></h4>
							</div>
							<div class="modal-body">
								<?php echo $lg_deletequestion ?>
								<hr></hr>
								<form action="<?php echo $action?>" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo $lg_yesdelete?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_cancel?></a>
									<input type="hidden" name="tag_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="tag" />
								</form>
							</div>
<?php
			break;*/

		// 1.1.3
		// clear unused tags
		case 'clear':
			// remove tags with (count=0);
			$tbt = new ElybinTable('elybin_tag');
			$tbt->Delete('count',0);
			_red('?mod=tag');
			exit;
			break;

		default:
		$tb 	= new ElybinTable('elybin_tag');
		$ltag	= $tb->Select('count','DESC');
		$ctag	= $tb->GetRow();
?>		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray"><?php echo lg('You are here') ?>:</div>
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li class="active"><a href="?mod=tag"><?php echo lg('Tags') ?></a></li>
			
			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<?php
			if($ctag > 0){
			?>
			<a href="?mod=tag&amp;act=clear&amp;clear=yes" class="btn btn-info pull-right"><i class="fa fa-trash-o"></i>&nbsp;&nbsp;<?php echo lg('Clear Unused Tags') ?></a>
			<?php } ?>
			<h1><?php echo lg('Tags')?></h1>
		</div> <!-- / .page-header -->
				
	
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">	
				<!-- Tabs -->
				<ul class="nav nav-tabs nav-tabs-xs">
					<li<?php if(!isset($_GET['filter'])){echo' class="active"'; }?>>
						<?php 
						// count all category
						$totallt = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_tag` as `t`
						");
						?>
						<a href="?mod=tag"><?php echo lg('All') ?> <span class="badge badge-default"><?php echo $totallt ?></span></a>
					</li>
				</ul> <!-- / .nav -->
				<!-- Panel -->
				<div class="panel">
					<!-- ./Panel Heading -->
					<div class="panel-body">
						<?php
						if($ctag == 0){
							echo '<div class="text-center text-light-gray panel-padding"><i class="fa fa-5x fa-tags"></i><br/>'.lg('You don\'t have any tag!').'</div>';
						
						}else{
							// convert to array
							// because i cant use this 
							$x = 0;
							foreach($ltag as $tg){
								$atag[$x] = $tg->count;
								$x++;
							}
							$Et = array_sum($atag);
							// little formulas
							$n1 = (80/100)*($Et/$x);
							
							foreach($ltag as $tg){
								if($tg->count == 0){
									echo '<a href="?mod=post&amp;search=tag:'.$tg->tag_id.'" class="btn btn-md btn-rounded btn-default disabled" style="margin-bottom: 5px;">'.$tg->name.'</a>&nbsp;';
								}
								elseif($tg->count > $n1){
									echo '<a href="?mod=post&amp;search=tag:'.$tg->tag_id.'" class="btn btn-md btn-rounded btn-danger" style="margin-bottom: 5px;">'.$tg->name.' ('.$tg->count.')</a>&nbsp;';
								}
								else{
									echo '<a href="?mod=post&amp;search=tag:'.$tg->tag_id.'" class="btn btn-md btn-rounded btn-primary" style="margin-bottom: 5px;">'.$tg->name.' ('.$tg->count.')</a>&nbsp;';
								}
							}
							echo '
							<hr/>
							<a class="btn btn-sm btn-rounded btn-danger"></a>'.lg('Mostly Used').'<br/>
							<a class="btn btn-sm btn-rounded btn-primary"></a>'.lg('Rare Used').'<br/>
							<a class="btn btn-sm btn-rounded btn-default disabled"></a>'.lg('Unused');
						
						}
						?>
					</div><!-- / .panel-body -->
				</div><!-- / .panel -->
			</div><!-- / .col -->
		</div><!-- / .row -->

<?php
		break;
		}
	}
}
?>
