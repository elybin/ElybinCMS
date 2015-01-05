<?php
/* Short description for file
 * [ Plugin: Subscribe
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
$modpath 	= "app/com.subscribe/";
$action		= $modpath."proses.php";

// get current active user
$s = $_SESSION['login'];
$tblu = new ElybinTable("elybin_users");
$tblu = $tblu->SelectWhere("session","$s","","");
$tblu = $tblu->current();
$level = $tblu->level; // getting level from curent user

// get user privilages
$tblpl = new ElybinTable('elybin_plugins');
$lpl = $tblpl->SelectWhereAnd('status','active','alias','com.subscribe','','')->current()->usergroup;


//explode usergroup and search
$plugin_priv = explode(",",$lpl);
// hide if privillage not found
if (array_search($level, $plugin_priv) !== false) {
	@$plavailable++;
}

if(@$plavailable == 0){
	er('<strong>'.$lg_ouch.'!</strong> '.$lg_accessdenied.' 403 <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.$lg_back.'</a>');
}else{
	// start here
	$v 	= new ElybinValidasi();
	//include self language library
	include_once('lang.php');

	switch (@$_GET['act']) {

		case 'edit';
		$id 	= $v->xss($_GET['id']);
		$id 	= $v->sql($id);

		$tb 	= new ElybinTable('com.elybin_subscribe');
		$ccon	= $tb->SelectWhere('subscribe_id',$id,'','');
		$ccon	= $ccon->current();
		$status = $ccon->status;
		if($status == 'active'){
			$data = array('status' => 'deactive');
			$tb->Update($data,'subscribe_id',$id);
		}else{
			$data = array('status' => 'active');
			$tb->Update($data,'subscribe_id',$id);
		}
		header('location: admin.php?mod='.$mod);
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
									<input type="hidden" name="subscribe_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="com.subscribe" />
								</form>
							</div>
<?php
			break;
		
		default:
		$tb 	= new ElybinTable('com.elybin_subscribe');
		$lsubscribe	= $tb->Select('subscribe_id','DESC');
		$no = 1;
?>


		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo $lg_apps?> / <?php echo $lg_subscriptions?> / </span><?php echo $lg_all?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<form action="<?php echo $action?>" method="post">
					<input type="hidden" name="act" value="multidel" />
					<input type="hidden" name="mod" value="page" />
					<div class="panel-heading">
						<span class="panel-title"><i class="fa fa-rss"></i>&nbsp;&nbsp;<?php echo $lg_allsubscriber?></span>
						<div class="panel-heading-controls text-right">
								<div class="input-group input-group" id="tooltip">
									<span class="input-group-btn">
										<div style="width:70%"><input type="text" class="form-control" id="search" placeholder="<?php echo $lg_search?>..."></div>
										<button class="btn disabled"><span class="fa fa-search"></span></button>
										<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
									</span>
								</div> <!-- / .input-group -->
						</div> <!-- / .panel-heading-controls -->
					</div> <!-- / .panel-heading -->
					<div class="panel-body">
					  <div class="table-responsive">
						<table class="table table-hover" id="results">
						 <thead>
						  <tr>
						    <th>#</th>
						    <th><i class="fa fa-check-square" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $lg_checkall?>"></i></th>
						    <th><?php echo $lg_email?></th>
						    <th><?php echo $lg_subscribe?></th>
						    <th><?php echo $lg_status?></th>
						    <th><?php echo $lg_action?></th>
						  </tr>
						</thead>
						<tbody>		

						<?php
						foreach($lsubscribe as $sub){
							if($sub->status == 'active'){
								$status = $lg_subscribe;
								$icon = '<span class="fa fa-circle"></span>';
							}else{
								$status = $lg_unsubscribe;
								$icon = '<span class="fa fa-circle-o"></span>';
							}
							$date = time_elapsed_string($sub->date." ".$sub->time);
						?> 
						<tr>
						    <td><?php echo $no?></td>
						    <td><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo $sub->subscribe_id?>|<?php echo $sub->email?>"><span class="lbl"></span></label></td>
						    <td><a href='mailto:<?php echo $sub->email?>'><?php echo $sub->email?></a></td>
						    <td><?php echo $date?></td>
						    <td><?php echo $status?></td>
						    <td>
								<div id="tooltip">
									<a href="?mod=com.subscribe&amp;act=edit&amp;id=<?php echo $sub->subscribe_id?>&amp;clear=yes" class="btn btn-success btn-outline btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo $status?>"><?php echo $icon?></a>
							    	<a href="?mod=com.subscribe&amp;act=del&amp;id=<?php echo $sub->subscribe_id?>&amp;clear=yes" class="btn btn-danger btn-outline btn-sm" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="<?php echo $lg_delete?>"><i class="fa fa-times"></i></a>
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
				<!-- View Modal -->
				<div id="view" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
					<div class="modal-dialog modal-md">
						<div class="modal-content">
							<?php echo $lg_loading?>...
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / View Modal -->
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
