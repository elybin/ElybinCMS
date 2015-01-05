<?php
/* Short description for file
 * [ Module: Tools
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
$modpath 	= "app/tools/";
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
	switch (@$_GET['act']) {
		default:
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-magic"></i>&nbsp;&nbsp;<?php echo $lg_tools?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo $lg_setting?> / </span><?php echo $lg_tools?></span>
				</h1>
			</div>
		</div> <!-- ./Page Header -->
		
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-6">
				<div class="panel">
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-upload"></i>&nbsp;&nbsp;<?php echo $lg_backupandrestore?></span>
					</div> <!-- / .panel-heading -->
					<div class="panel-body">
						<div class="form-group">
							<div class="col-sm-9">
								<input type="file" name="plugin_file" id="file-style" required/>
								<p><?php echo $lg_backuphint?> <a href="<?php echo $modpath?>export.php" target="_blank"><?php echo $lg_backup?></a></p>
							</div>
							<div class="col-sm-2">
								<button type="submit" class="btn btn-success"><i class="fa fa-upload"></i>&nbsp;<?php echo $lg_restore?></button>
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
