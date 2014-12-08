<?php
/* Short description for file
 * [ Module: Theme
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
$modpath 	= "app/theme/";
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
	switch (@$_GET['act']) {
		case 'add':
?>
		<div class="page-header">
			<h1><span class="text-light-gray"><?php echo $lg_setting?> / <?php echo $lg_theme?> / </span><?php echo $lg_addnew?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">

				<form class="panel form-horizontal" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
					<div class="panel-heading" id="tooltip">
						<span class="panel-title"><i class="fa fa-tint"></i>&nbsp;&nbsp;<?php echo $lg_addnewtheme?></span>
						<a class="btn btn-default btn-xs pull-right" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
					</div>
					<div class="panel-body">
					  <?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
					  <div class="note note-info"><?php echo $lg_getmorethemehint?>&nbsp;<a href="http://theme.elybin.com/" target="_blank">http://theme.elybin.com/</a></div>
					  <div class="form-group">
					      <label class="col-sm-3 control-label"></label>
					      <div class="col-sm-4">
					      	<input type="file" name="theme_file" id="file-style" required/>
					      	<p><?php echo $lg_filethemehint?></p>
					      </div>
					      <div class="col-sm-2">
					      	<button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-upload"></i>&nbsp;<?php echo $lg_upload?></button>
					      </div>
					  </div> <!-- / .form-group -->

					  <div class="panel-footer">
						  <a class="btn btn-default pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;<?php echo $lg_back?></a>
						  <input type="hidden" name="act" value="add" />
						  <input type="hidden" name="mod" value="theme" />
					  </div> <!-- / .form-footer -->
					</div> <!-- / .panel-body -->
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

<!-- Javascript -->
<script>
	init.push(function () {
		$('#file-style').pixelFileInput({ placeholder: '<?php echo $lg_nofileselected?>...' });
		$('#tooltip a').tooltip();	
	});
</script>
<!-- / Javascript -->
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
		$tb 	= new ElybinTable('elybin_themes');
		
		// count total themes
		$cotheme = $tb->GetRow('', '');
		
		// get data
		$ltheme	= $tb->Select('theme_id','DESC');
		$no = 1;
?>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-tint"></i>&nbsp;&nbsp;<?php echo $lg_theme?></span>
					<span class="hidden-xs"><span class="text-light-gray"><?php echo $lg_setting?> / </span><?php echo $lg_theme?></span>
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
						<span class="panel-title"><i class="fa fa-tint hidden-xs">&nbsp;&nbsp;</i><?php echo $lg_alltheme?></span>
						<div class="panel-heading-controls" id="tooltip">
							<a class="btn btn-default btn-xs" data-toggle="modal" data-target="#help" data-placement="bottom" data-original-title="<?php echo $lg_help?>"><i class="fa fa-question-circle"></i></a>
						</div> <!-- / .panel-heading-controls -->
					</div> 
					<!-- ./Panel Heading -->
					
					<div class="panel-body">
						<?php @eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("fTt0aXhlOykodG9vZl9lbWVodCBwaHA/PAkJCQkJCg0+LS0gd29yLiAvIC0tITw+dmlkLzwJCQoNPi0tIGxvYy4gLyAtLSE8PnZpZC88CQkJCg0+LS0gbXJvZi4gLyAtLSE8Pm1yb2YvPAkJCQkKDT4tLSBsZW5hcC4gLyAtLSE8ID52aWQvPAkJCQkJCg0+dmlkLzw+YS88bG10aC5lZG9tLWtjYWxiL2NpcG90L21vYy5uaWJ5bGUucGxlaC8vOnB0dGg+ImtuYWxiXyI9dGVncmF0ICJsbXRoLmVkb20ta2NhbGIvY2lwb3QvbW9jLnNtY25pYnlsZS5wbGVoLy86cHR0aCI9ZmVyaCBhPDtwc2JuJj4/ZGVrY29sZXJ1dGFlZmVkb21rY2FsYm5pbWV0c3lzX2dsJCBvaGNlIHBocD88PiJyZWduYWQtZXRvbiBldG9uIj1zc2FsYyB2aWQ8ICAJCQkJCQoNPj8geyllc2xhZiA9PSApKG9lc2VuaWduZWhjcmFlcyhmaQ=="))); ?>
						<div class="col-sm-12">	
							<!-- Tabs for md -->
							<ul class="nav nav-tabs nav-tabs-simple hidden-xs hidden-sm">
								<li class="pull-right">
									<a href="#adminpanel-tabs" data-toggle="tab"><?php echo $lg_adminpanel; ?> <span class="badge badge-info">10</span></a>
								</li>
								<li class="active pull-right">
									<a href="#frontend-tabs" data-toggle="tab"><?php echo $lg_frontend; ?> <span class="badge badge-info"><?php echo $cotheme; ?></span></a>
								</li>
							</ul> <!-- / .nav -->
							<!-- / Tabs for md -->
							
							<!-- Tabs for xs sm -->
							<ul class="nav nav-tabs nav-tabs-simple nav-justified visible-xs visible-sm">
								<li>
									<a href="#adminpanel-tabs" data-toggle="tab"><?php echo $lg_adminpanel; ?> <span class="badge badge-info">10</span></a>
								</li>
								<li class="active">
									<a href="#frontend-tabs" data-toggle="tab"><?php echo $lg_frontend; ?> <span class="badge badge-info"><?php echo $cotheme; ?></span></a>
								</li>
							</ul> <!-- / .nav -->
							<!-- / Tabs xs sm -->

						</div>
						<div class="clearfix form-group-margin"></div> <!-- Margin -->
						
						<!-- Tab Content -->
						<div class="tab-content">
							<div class="tab-pane fade active in" id="frontend-tabs">
					<?php		
					foreach($ltheme as $cat){
						$preview_file = "../elybin-main/{$cat->folder}/preview.jpg";
						if(file_exists($preview_file)){
							$preview = $preview_file;
						}else{
							$preview = "../elybin-file/system/no-preview-default.png";
						}
						if($cat->status !== 'active'){
							$status = '
							
								<form action="'.$action.'" method="post">
									<div class="btn-group">
									<a href="?mod=theme&amp;act=del&amp;id='.$cat->theme_id.'&amp;clear=yes" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete"  data-placement="left" data-original-title="'.$lg_delete.'"><i class="fa fa-trash-o"></i></a>
									<button class="btn btn-sm" data-placement="left" data-original-title="'.$lg_activate.'"><span class="fa fa-eye"></span></button>
									</div>
									<input type="hidden" name="theme_id" value="'.$cat->theme_id.'" />
									<input type="hidden" name="act" value="active" />
									<input type="hidden" name="mod" value="theme" />
								</form>
							';
						}else{
							$status = $lg_active.' <span class="fa fa-check-circle" id="equal-height"></span>';
						}
						?>
						<div class="col-xs-12 col-sm-6 col-md-3">	
							<div class="stat-panel">
								<div class="stat-row">
									<!-- Info background, without padding, horizontally centered text, super large text -->
									<div class="stat-cell bg-primary padding-sm text-left text-bg">
										<span class="pull-right">
											<?php echo $status?>
										</span>
										<span class="">
											<?php echo $cat->name?>
										</span>
									</div>
								</div> <!-- /.stat-row -->
								<div class="stat-row">
									<!-- Bordered, without top border, horizontally centered text, large text -->
									<div class="stat-cell bordered no-border-t text-center text-sm">
										<img src="<?php echo $preview?>" class="img-thumbnail grid-gutter-margin-b">	
										<p class="no-margin-hr">
											<?php echo $cat->description?><br>
											<?php echo $lg_by?> <i><?php echo $cat->author?></i><br>
											<a href="<?php echo $cat->url?>" target="_blank"><?php echo $cat->url?>&nbsp;<i class="fa fa-external-link"></i></a>
										</p>
									</div>
								</div> <!-- /.stat-row -->
							</div> <!-- /.stat-panel -->
						</div> <!-- /.col-sm-3 -->
						<?php
							$no++;
						}
						?>
							</div><!-- ./tab -->
							<div class="tab-pane fade" id="adminpanel-tabs">
								<div class="demo-themes-row" id="demo-themes">
									<?php
									// get option
									$getoption1 = new ElybinTable('elybin_options'); 
									$admin_theme = $getoption1->SelectWhere('name','admin_theme','','')->current()->value; 
									
									$theme_admin = json_decode('
									[
									  { "name": "default", "title": "Default", "img": "assets/full/themes/default.png" },
									  { "name": "asphalt", "title": "Asphalt", "img": "assets/full/themes/asphalt.png" },
									  { "name": "purple-hills", "title": "Purple Hills", "img": "assets/full/themes/purple-hills.png" },
									  { "name": "adminflare",  "title": "Adminflare", "img": "assets/full/themes/adminflare.png" },
									  { "name": "dust",  "title": "Dust", "img": "assets/full/themes/dust.png" },
									  { "name": "frost",  "title": "Frost", "img": "assets/full/themes/frost.png" },
									  { "name": "fresh",  "title": "Fresh", "img": "assets/full/themes/fresh.png" },
									  { "name": "silver",  "title": "Silver", "img": "assets/full/themes/silver.png" },
									  { "name": "clean",  "title": "Clean", "img": "assets/full/themes/clean.png" },
									  { "name": "white",  "title": "White", "img": "assets/full/themes/white.png" }
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
								<h4 class="modal-title"><?php echo $lg_helptitle?></h4>
							</div>
							<div class="modal-body">
								...
							</div>
						</div> <!-- / .modal-content -->
					</div> <!-- / .modal-dialog -->
				</div> <!-- / .modal -->
				<!-- / Help modal -->
<script type="text/javascript">
	init.push(function () {
		var setEqHeight = function () {
			$('#content-wrapper .row').each(function () {
				var $p = $(this).find('.stat-panel');
				if (! $p.length) return;
				$p.attr('style', '');
				var h = $p.first().height(), max_h = h;
				$p.each(function () {
					h = $(this).height();
					if (max_h < h) max_h = h;
				});
				$p.css('height', max_h);
			});
		};
		
			if ($(this).hasClass('disabled')) return;
			$(this).addClass('disabled');
			setEqHeight();
			$(window).on('pa.resize', setEqHeight);
			$(window).resize();
	});
	window.PixelAdmin.start(init);
	
</script>
<script>
init.push(function () {
	$('.stat-cell a, .stat-cell button, #tooltip-ck, #tooltip a').tooltip();
	var demo_settings = {
    fixed_navbar: true,
    fixed_menu:   false,
    rtl:          false,
    menu_right:   false,
    theme:        'clean'
  };
	
	// Change theme
	$('#demo-themes .demo-theme').on('click', function () {
		if ($(this).hasClass('text-success')) return;
		$('#demo-themes .text-success').removeClass('text-success');
		$(this).addClass('text-success');
		demo_settings.theme = $(this).attr('data-theme');
		activateTheme($('#main-menu .btn-outline'));
		saveDemoSettings();
		return false;
	});
	
	var activateTheme = function (btns) {
	  document.body.className = document.body.className.replace(/theme\-[a-z0-9\-\_]+/ig, 'theme-' + demo_settings.theme);
	  
	  if (! btns) return;
	  btns.removeClass('dark');
	  if (demo_settings.theme != 'clean' && demo_settings.theme != 'white') {
		btns.addClass('dark');
	  }
	}
	
	function saveDemoSettings(){
		$().ajaxStart(function() {
			$.growl.notice({ title: "Loading", message: "Writing..." });
			$('#form').hide();
		}).ajaxStop(function() {
			$.growl.notice({ title: "Success", message: "Success" });
		});	

		
		$.ajax({
		url: 'app/theme/proses.php',
		type: 'POST',
		data: "mod=theme&act=admin_theme&id=" + demo_settings.theme,
			  success: function(data) {
					console.log(data);
					var data = $.parseJSON(data);
					if(data.status == "ok"){
						$.growl.notice({ title: data.title, message: data.isi });
					}
					else if(data.status == "error"){
						$.growl.warning({ title: data.title, message: data.isi });
					}
			   }
			});
		//e.preventDefault();
		return false;
	}
});

ElybinView();
ElybinPager();
ElybinSearch();
ElybinCheckAll();
countDelData();
</script>
<?php
			break;
		}
	}
}
?>
