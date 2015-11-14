<?php
/* Short description for file
 * [ Module: Tools
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/tools/";
$action		= $modpath."proses.php";

$u = _u();

// give error if no have privilage
if($u->user_id != 1){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	// start here
	switch (@$_GET['act']) {
		default:
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-magic"></i>&nbsp;&nbsp;<?php echo lg('Tools')?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo lg('Setting')?> / </span><?php echo lg('Tools')?></span>
				</h1>
			</div>
		</div> <!-- ./Page Header -->
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-6">
				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-upload"></i>&nbsp;&nbsp;<?php echo lg('Backup and Restore')?></span>
					</div> <!-- / .panel-heading -->
					<div class="panel-body">
						<div class="form-group">
							<div class="col-sm-9">
								<input type="file" name="plugin_file" id="file-style" required/>
								<p><?php echo lg('To Restore database, upload (.sql) file. To Backup click link below.')?> <a href="<?php echo $modpath?>export.php" target="_blank"><?php echo lg('Backup')?></a></p>
							</div>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-success"><i class="fa fa-upload"></i>&nbsp;<?php echo lg('Restore')?></button>
							</div>
						</div> <!-- / .form-group -->
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
