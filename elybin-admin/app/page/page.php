<?php
/* Short description for file
 * Module: Page
 *
 * Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @copyright	Copyright (C) 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim A. <kim@elybin.com>
 ---------------------------
 1.1.3-1 (Release 1) - Edited by (@Kim)
 - Redesign List
 - Merge Table with Post
 1.1.4
 - Adding seotitle unique
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/page/";
$action		= $modpath."proses.php";

// string validation for security
$v 	= new ElybinValidasi();

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->page;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to access this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	// start here
	switch (@$_GET['act']) {
		case 'add':
		// cek dulu, minimal ada 1 kategori
		$tblc = new ElybinTable('elybin_category');
		$coc = $tblc->GetRow();
		if($coc < 1){
			// show error
			er('<strong>'.lg('Oops!').'</strong> '.lg('Please create at least one Category.').'&nbsp;<a class="btn btn-default btn-xs" href="?mod=category&amp;act=add">'.lg('Create New Category').'</a>&nbsp;<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}

		// buat auto draf
		$tbl = new ElybinTable('elybin_posts');
		$date = date("Y-m-d H:i:s");
		$data = array(
			'title' => '',
			'content' => '',
			'date' => $date,
			'author' => _u()->user_id,
			'category_id' => 0,
			'seotitle' => '',
			'tag' => '',
			'status' => 'prepost',
			'visibility' => '',
			'post_meta' => '',
			'post_password' => '',
			'comment' => '',
			'type' => 'page'
		);
		$tbl->Insert($data);
		// ambil id ini
		$cp = $tbl->SelectWhereAnd('status', 'prepost', 'date', $date, 'post_id', 'DESC')->current();

?>		<!-- help -->
		<div class="page-header hide-light" id="help-panel">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=page"><?php echo lg('Page') ?></a></li>
			<li class="active"><a href="?mod=page&amp;act=add"><?php echo lg('New Page') ?></a></li>

			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=page" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to Page') ?></a>
			<h1><?php echo lg('New Page') ?></h1>
		</div> <!-- / .page-header -->

		<style><?php include("assets/stylesheets/select2.min.css"); ?></style>
		<style><?php include("assets/stylesheets/jquery-ui.css"); ?></style>
		<style><?php include("assets/stylesheets/jquery.tagsinput.min.css"); ?></style>
		<form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="row">
				<div class="col-sm-9">
					<div class="form-horizontal panel-wide" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.05); ">
						<div class="panel-body">
							<div class="form-group">
							  <div class="col-sm-12">
								<input type="text" name="title" class="form-control input-lg" placeholder="<?php echo lg('Page Title') ?>"/>
							  </div>
							</div> <!-- / .form-group -->
							<div class="form-group">
							  <div class="col-sm-12">
<?php
// getting text_editor
if(op()->text_editor == 'summernote'){
	echo '<style>'; include("assets/stylesheets/summernote.css"); echo '</style>';
}
else if(op()->text_editor == 'bs-markdown'){
	echo '<style>';include("assets/stylesheets/markdown.css"); echo '</style>';
}
?>
								<div id="summernote-progress" style="display: none">
									<p><?php echo lg('Uploading Images...') ?> - <span>1%</span></p>
									<div class="progress progress-striped">
										<div class="progress-bar progress-bar-success" style="width: 1%"></div>
									</div>
								 </div>
								<textarea name="content" cols="50" rows="20" class="form-control" id="text-editor" placeholder="<?php lg('Page content here...')?>"></textarea>
							  </div>
							</div> <!-- / .form-group -->

						  </div><!-- / .panel-body -->
					</div>
				</div><!-- / .col -->

				<div class="col-sm-3">
					<div class="panel-body" style="box-shadow: 2px 1px 5px rgba(0,0,0,0.1); margin-bottom: 2px;">
						<button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save') ?></button>

						<br/>
						<!-- auto save -->
						<div id="autosave" class="text-sm text-light-gray hide-light">
							<i>  <?php echo lg('Saving...') ?></i>
						</div>
						<br/>
						<!-- 1.1.3 -->
						<!-- status -->
						<div id="hidden_toggle">
							<span class="text-sm"><b><?php echo lg('Status')?>:</b>&nbsp;<a href="#"><u><?php echo lg('Deactivate')?></u></a> </span>
							<div id="aform" style="display: none">
								<select name="status" class="form-control">
									<option value="active"><?php echo lg('Activate')?></option>
									<option value="deactive" selected="selected"><?php echo lg('Deactivate')?></option>
								</select>
								<div id="ok" class="btn btn-sm btn-default"><?php echo lg('Ok')?></div>
								<a href="#" class="text-xs" id="c">&nbsp;<u><?php echo lg('Cancel')?></u></a>
							</div>
						</div>
					</div>
					<div class="panel-body" style="box-shadow: 2px 1px 5px rgba(0,0,0,0.1); padding: 10px 2px;">

							<div class="form-group">
							  <label class="col-sm-2 control-label text-sm"><?php echo lg('Tags')?></label>
							  <i id="tags_loading" class="hide-light"></i>
							  <div class="col-sm-12">
									<input type="text" name="tag" class="form-control tags" placeholder="<?php echo lg('holiday, fun, family')?>" id="tags_pick"/>
							  </div>
							</div> <!-- / .form-group -->
							<div class="form-group">
							  <label class="col-sm-2 control-label text-sm"><?php echo lg('Photo')?></label>
							  <div class="col-sm-12">
								<input type="file" name="file" id="file-style" class="form-control"/>
								<p class="help-block"><?php echo lg('Allowed extension is')?> (<i>.jpg, .jpeg</i>)</p>
							  </div>
							</div> <!-- / .form-group -->
					</div>
				</div><!-- / .col -->


				<input type="hidden" name="pid" value="<?php echo epm_encode($cp->post_id) ?>" />
				<input type="hidden" name="act" value="add" />
				<input type="hidden" name="mod" value="page" />
			</form><!-- / .form -->
		</div><!-- / .row -->
<?php
		break;
		// 1.1.3
		// revision
		case 'revision':
			$id 	= $v->sql(@$_GET['id']);

			// check id exist or not
			$tb 	= new ElybinTable('elybin_posts');
			$copost = $tb->GetRow('parent', $id);
			if(empty($id) || $copost < 1){
				er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
				theme_foot();
				exit;
			}

			// get data
			$cp	 = $tb->SelectFullCustom("
			SELECT
			`p`.*,
			`u`.`fullname`
			FROM
			`elybin_posts` as `p`,
			`elybin_users` as `u`
			WHERE
			`p`.`post_id` = $id  &&
			`u`.`user_id` = `p`.`author`
			ORDER BY
			`p`.`post_id` DESC")->current();
			//$pr = $tb->SelectWhere('parent',$id,'post_id', 'DESC');
			$que = "
			SELECT
			`p`.*,
			`u`.`fullname`
			FROM
			`elybin_posts` as `p`,
			`elybin_users` as `u`
			WHERE
			`p`.`parent` = $id  &&
			`u`.`user_id` = `p`.`author`
			";


			// query for current state
			$crsque = "$que
			ORDER BY `p`.`post_id` DESC
			LIMIT 0,1
			";
			$crstate = $tb->SelectFullCustom($crsque)->current();

			$cop = $tb->GetRowFullCustom($que);
			// modify query to pageable & shortable
			$oarr = array(
				'default' => '`p`.`post_id` DESC'
			);
			$que = _PageOrder($oarr, $que, 1);
			$pr	= $tb->SelectFullCustom($que);

			//echo '<pre>'.$que.'</pre>';
?>		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray"><?php echo lg('You are here') ?>:</div>
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=page"><?php echo lg('Post') ?></a></li>
			<li><a href="?mod=page&amp;act=edit&amp;id=<?php echo $id ?>"><?php echo lg('Edit Post') ?></a></li>
			<li class="active"><a href="?mod=post&amp;act=revision&amp;id=<?php echo $id ?>"><?php echo lg('Revision History') ?></a></li>

			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<div class="page-header">
			<a href="?mod=page&amp;act=edit&amp;id=<?php echo $id ?>" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to Editing') ?></a>
			<h1><?php echo lg('Revision History of') ?> <i>"<?php echo $cp->title ?></i>"</h1>
			<p><?php echo $copost-1 . ' '. lg('revision') ?><p>
		</div> <!-- / .page-header -->
		<!-- Content here -->

		<style><?php include("assets/stylesheets/select2.min.css"); ?></style>
		<form class="" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="row">
				<div class="col-sm-12">
				<?php


				$no = 1;


				// post sekarang
				echo '<div class="form-horizontal depth-md">';
				echo '	<div class="panel-body">';
				// jika autosave
				if($crstate->type == 'autosave'){
					echo 		'<p><b>'. lg('Current State').'</b><i><span class="text-light-gray"> ('. lg('Edited'). ' '.time_elapsed_string($crstate->date).' '.lg('By').' '.$crstate->fullname.') </span></i>&nbsp;<span class="label label-warning">'. lg('Auto Save'). '</span></i></p>';
				}else{
					echo 		'<p><b>'. lg('Current State').'</b><i><span class="text-light-gray"> ('. lg('Edited'). ' '.time_elapsed_string($crstate->date).' '.lg('By').' '.$crstate->fullname.') </span></i></p>';
				}
				echo 		'<h4><b>'. $crstate->title.'</b></h4>';
				echo 		'<p>'. substr(htmlspecialchars($crstate->content),0,400).'</p>';
				echo '	</div><!-- / .panel-body -->';
				echo '</div>';

				// paggng
				if(isset($_GET['page'])){
					echo '<hr/>'.lg('Page').' '.@$_GET['page'];
				}else{
					echo '<hr/>'.lg('Page').' 1';
				}
				showPagging($copost-1, $id);

				echo '<div class="form-group-margin"></div>';


				// daftar revisi
				foreach($pr as $cpr){
					echo '<div class="form-horizontal depth-xs">';
					echo '	<div class="panel-body">';
					echo 		'<a href="?mod=page&amp;act=restore&amp;id='. $cpr->post_id.'&amp;clear=yes" class="btn btn-primary pull-right"><i class="fa fa-rotate-right"></i>&nbsp; '. lg('Restore from this Point'). '</a>';
					// jika autosave
					if($cpr->type == 'autosave'){
						echo 		'<p><i>'. $cpr->date.' <span class="text-light-gray">('.time_elapsed_string($cpr->date).' '.lg('By').' '.$cpr->fullname.') </span></i>&nbsp;<span class="label label-warning">'. lg('Auto Save'). '</span></p> ';
					}else{
						echo 		'<p><i>'. $cpr->date.' <span class="text-light-gray">('.time_elapsed_string($cpr->date).' '.lg('By').' '.$cpr->fullname.') </span></i></p>';
					}
					echo 		'<h4><b>'. $cpr->title.'</b></h4>';
					echo 		'<p>'. substr(htmlspecialchars($cpr->content),0,400).'</p>';
					echo '	</div><!-- / .panel-body -->';
					echo '</div>';
					echo '<div class="form-group-margin"></div>';
				}
				?>
				</div><!-- / .col -->
			</form><!-- / .form -->
		</div><!-- / .row -->
<?php

		break;

	case 'restore':
		// 1.1.3
		// restore post

		// jika tidak "clear=yes"
		if(!isset($_GET['clear'])){
			er(lg('The are some error in page you\'ve open, please contact administrator').'.<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}else{
			// ambil id nya
			$rid = $v->sql($_GET['id']);

			// check id exist or not
			$tbl = new ElybinTable('elybin_posts');
			$cop = $tbl->GetRow('post_id', $rid);
			if($cop < 1){
				header('location: ?mod=post');
				exit;
			}

			// restore post id ini ke post parent

			// get data
			$cpr = $tbl->SelectWhere('post_id',$rid,'','')->current();
			$cpp = $tbl->SelectWhere('post_id',$cpr->parent,'','')->current(); // parent


			// 1.1.3
			// post revision logic
			// ada perubahan?
			$revision = true;
			// jika ada revisi, lanjut
			// buat duplikat post lama
			if($revision){
				$d = array(
					'title' => $cpp->title,
					'content' => $cpp->content,
					'date' => $cpp->date,
					'author' => $cpp->author,
					'category_id' => $cpp->category_id,
					'seotitle' => $cpp->seotitle,
					'tag' => $cpp->tag,
					'status' => 'inherit',
					'visibility' => $cpp->visibility,
					'parent' => $cpp->post_id,
					'post_meta' => $cpp->post_meta,
					'image' => $cpp->image,
					'comment' => $cpp->comment
				);
				//$tbl->Insert($d);
			}
			// buat duplikat post yang sekarang
			$db = array(
				'title' => $cpr->title,
				'content' => $cpr->content,
				'date' => date("Y-m-d H:i:s"),
				'author' => _u()->user_id,
				'category_id' => $cpr->category_id,
				'seotitle' => $cpr->seotitle,
				'tag' => $cpr->tag,
				'status' => 'inherit',
				'visibility' => $cpr->visibility,
				'parent' => $cpr->parent,
				'post_meta' => $cpr->post_meta,
				'image' => $cpr->image,
				'comment' => $cpr->comment
			);
			$tbl->Insert($db); // buat copy lagi yang sama dg parent

			// update parent ke data baru (backup nya = `cpr`)
			$db = array(/*
				'title' => $cpr->title,
				'content' => $cpr->content,
				'date' => date("Y-m-d H:i:s"),
				'author' => $cpr->author,
				'category_id' => $cpr->category_id,
				'seotitle' => $cpr->seotitle,
				'tag' => $cpr->tag,
				'visibility' => $cpr->visibility,
				'post_meta' => $cpr->post_meta,
				'image' => $cpr->image,
				'comment' => $cpr->comment */
				'title' => $cpr->title,
				'content' => $cpr->content,
				'seotitle' => $cpr->seotitle,
				'image' => $cpr->image
			);
			$tbl->Update($db, 'post_id', $cpr->parent);

			// redirect ke edit post parent
			header('location: ?mod=post&act=edit&id='.$cpr->parent.'&msg=restored');
			exit;
			// restore done!
		}
		break;

	case 'edit';
	$id 	= $v->sql(epm_decode(@$_GET['hash']));
	// check id exist or not
	$tb 	= new ElybinTable('elybin_posts');
	$copost = $tb->GetRowAnd('post_id', $id,'type','page');
	if($copost < 1){
		er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
		theme_foot();
		exit;
	}

	// 1.1.3
	// only active & deactive that allowed to edit
	$costatus = $tb->GetRowFullCustom("
	SELECT *
	FROM
	`elybin_posts` as `p`
	WHERE
	(`p`.`status` = 'active' || `p`.`status` = 'deactive') &&
	`p`.`type` = 'page' &&
	`p`.`post_id` = $id
	");
	if($costatus < 1){
		er('<strong>'.lg('Oops!').'</strong> '.lg('Can\'t edit Deleted or Revision post. 403').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
		theme_foot();
		exit;
	}

	// get data
	$cp	= $tb->SelectWhere('post_id',$id)->current();

	$cp->content = html_entity_decode($cp->content);

	// custom status
	if($cp->status == 'active'){
		$cp->status_detail = lg('Activate');
	}else{
		$cp->status_detail = lg('Deactivate');
	}

	// tag
	$tbtag = new ElybinTable('elybin_tag');
	$tag_t = json_decode($cp->tag);
	$tag_t2 = [];
	for($i=0; $i < count($tag_t); $i++){
		// ambil dari tag
		$tag_t2[$i] = $tbtag->SelectWhere('tag_id', $tag_t[$i])->current()->name;
	}
	$cp->tag_detail = trim(implode(", ", $tag_t2));

	// cek revisi
	$corev = $tb->GetRowAnd('status', 'inherit', 'parent', $cp->post_id)-1;

	if($cp->status == 'inherit'){
		er('<strong>'. lg('Ouch!') .'</strong> '. lg('Page Not Found 404.') .' <a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'. lg('Back') .'</a>');
		theme_foot();
		exit;
	}
?>		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=page"><?php echo lg('Page') ?></a></li>
			<li class="active"><a href="?mod=page&amp;act=edit&amp;hash=<?php echo epm_encode($id) ?>"><?php echo lg('Edit Page') ?></a></li>

			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=page" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to Page') ?></a>
			<h1><?php echo lg('Edit Page') ?></h1>
		</div> <!-- / .page-header -->
		<!-- Content here -->
		<?php
			// 1.1.3
			// msg
			if(@$_GET['msg'] == 'published'){
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Page published successfully.') . '
				 <a href="'.get_url('page', $cp->post_id).'" target="_blank"><i><u>'.lg('View').'</u></i></a>
				 </div>
				';
			}
			else if(@$_GET['msg'] == 'updated'){
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Changes Saved.') . '</div>';
			}
			else if(@$_GET['msg'] == 'draft'){
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Page saved.') . '</div>';
			}
		?>

		<style><?php include("assets/stylesheets/select2.min.css"); ?></style>
		<style><?php include("assets/stylesheets/jquery-ui.css"); ?></style>
		<style><?php include("assets/stylesheets/jquery.tagsinput.min.css"); ?></style>
		<form class="" action="<?php echo $action; ?>" method="post" enctype="multipart/form-data" id="form">
			<div class="row">
				<div class="col-sm-9">
					<div class="form-horizontal panel-wide depth-sm">
						<div class="panel-body">
							<div class="form-group">
							  <div class="col-sm-12">
									<input type="text" name="title" value="<?php echo $cp->title ?>" class="form-control input-lg" placeholder="<?php echo lg('Page Title') ?>"/>
							  </div>
							</div> <!-- / .form-group -->
							<div class="form-group">
								<div class="col-md-4 text-right">
									<i><?php echo get_option('site_url'); ?></i>
								</div>
								<div class="col-md-7">
									<input type="hidden" id="check_seo_pid" value="<?php echo $cp->post_id ?>">
									<b id="check_seo_fix"><?php echo $cp->seotitle ?></b>
									<a href="#" id="check_seo_edit"><u><?php _e('Edit') ?></u></a>
									<input type="text" name="seotitle" id="check_seo_input" class="hide-light form-control input-xs" placeholder="<?php echo lg('your-page-url') ?>" value="<?php echo $cp->seotitle ?>"/>
								</div>
								<div class="col-md-1">
									<a class="btn btn-primary btn-xs hide-light" id="check_seo_btn"><?php _e('Ok') ?> <i class="fa fa-check"></i></a>
								</div>
							</div> <!-- / .form-group -->
							<div class="form-group">
							  <div class="col-sm-12">
								<?php
								// getting text_editor
								if(op()->text_editor == 'summernote'){
									echo '<style>'; include("assets/stylesheets/summernote.css"); echo '</style>';
								}
								else if(op()->text_editor == 'bs-markdown'){
									echo '<style>';include("assets/stylesheets/markdown.css"); echo '</style>';
								}
								?>
								<div id="summernote-progress" style="display: none">
									<p><?php echo lg('Uploading Images...') ?> - <span>1%</span></p>
									<div class="progress progress-striped">
										<div class="progress-bar progress-bar-success" style="width: 1%"></div>
									</div>
								 </div>
								<textarea name="content" cols="50" rows="20" class="form-control" id="text-editor" placeholder="<?php echo lg('Content') ?>"><?php echo $cp->content ?></textarea>
							  </div>
							</div> <!-- / .form-group -->

						  </div><!-- / .panel-body -->
					</div>
				</div><!-- / .col -->

				<div class="col-sm-3">
					<div class="panel-body" style="box-shadow: 2px 1px 5px rgba(0,0,0,0.1); margin-bottom: 2px;">
						 <button type="submit" value="Submit" class="btn btn-success"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save') ?></button>

						<br/>
						<!-- auto save -->
						<div id="autosave" class="text-sm text-light-gray hide-light">
							<i>  <?php echo lg('Saving...') ?></i>
						</div>
						<br/>
						<!-- 1.1.3 -->
						<!-- status -->
						<div id="hidden_toggle">
							<span class="text-sm"><b><?php echo lg('Status') ?>:</b>&nbsp;<a href="#"><u><?php echo $cp->status_detail ?></u></a> </span>
							<div id="aform" style="display: none">
								<select name="status" class="form-control">
									<option value="active"<?php if($cp->status == 'active'){ echo ' selected="selected"'; } ?>><?php echo lg('Activate') ?></option>
									<option value="deactive"<?php if($cp->status == 'deactive'){ echo ' selected="selected"'; } ?>><?php echo lg('Deactivate') ?></option>
								</select>
								<div id="ok" class="btn btn-sm btn-default"><?php echo lg('Ok') ?></div>
								<a href="#" class="text-xs" id="c">&nbsp;<u><?php echo lg('Cancel') ?></u></a>
							</div>
						</div>
					</div>
					<?php
					// tampil ketika ada revisi
					//if($corev > 0){
					if(0 > 0){
					?>
					<div class="panel-body depth-sm" style="padding: 15px; margin-bottom: 2px;">
						<div class="form-group">
							<p><b><?php echo $corev.lg(' Revisions') ?></b>&nbsp;<a href="?mod=post&act=revision&id=<?php echo $cp->post_id?>"><u><?php echo lg('View') ?></u></a></p>
							<?php
							// tampil daftar revisi
							$cr = $tb->SelectWhereLimit('parent', $cp->post_id, 'date', 'ASC','1,5');
							foreach($cr as $cr){
								echo '<i>' . lg('Changed') . ' ' . time_elapsed_string($cr->date) . '</i><br/>';
							}
							?>
						</div> <!-- / .form-group -->
					</div>
					<?php } ?>
					<div class="panel-body depth-sm" style="padding: 10px 2px;">

							<div class="form-group">
							  <label class="col-sm-2 control-label text-sm"><?php echo lg('Tags') ?></label>
							  <p id="tags_loading" class="hide-light"></p>
							  <div class="col-sm-12">
									<input type="text" name="tag" id="tags_pick" value="<?php echo $cp->tag_detail ?>" class="form-control" placeholder="<?php echo lg('holiday, fun, family') ?>"/>
							  </div>
							</div> <!-- / .form-group -->
							<div class="form-group">
							  <label class="col-sm-2 control-label text-sm"><?php echo lg('Image') ?></label>
							  <div class="col-sm-12">
							  <?php
								if(!empty($cp->image)){
									echo '<img class="img-thumbnail" src="../elybin-file/page/md-'. $cp->image .'" width="100%"/>';
								}
							  ?>
								<input type="file" name="file" id="file-style" class="form-control"/>
								<p class="help-block"><?php echo lg('Left empty if you are not changing the images. Maximum size of images is 1MB with allowed extensions (.jpg, .jpeg).') ?></p>
							  </div>
							</div> <!-- / .form-group -->
					</div>
				</div><!-- / .col -->

				<input type="hidden" name="pid" value="<?php echo epm_encode($cp->post_id); ?>" />
				<input type="hidden" name="act" value="edit" />
				<input type="hidden" name="mod" value="page" />
			</form><!-- / .form -->
		</div><!-- / .row -->

<?php
		break;

	case 'del':
?>

							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?php echo lg('Delete Permanently') ?></h4>
							</div>
							<div class="modal-body">
								<p class="text-danger"><?php echo lg('Are you sure you want delete permanently this item.')?></p>
								<hr/>
								<form action="<?php echo $action?>" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Delete')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									<input type="hidden" name="post_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="post" />
								</form>
							</div>
<?php
		break;

	case 'recycle_del':
?>

							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title"><i class="fa fa-exclamation-circle"></i>&nbsp;&nbsp;<?php echo lg('Delete Post')?></h4>
							</div>
							<div class="modal-body">
								<?php echo lg('Are you sure you want to move this post to Recycle Bin? you can also restore it back.')?>
								<hr/>
								<form action="<?php echo $action?>" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Delete')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									<input type="hidden" name="post_id" value="<?php echo $_GET['id']?>" />
									<input type="hidden" name="act" value="recycle_del" />
									<input type="hidden" name="mod" value="post" />
								</form>
							</div>
<?php
		break;

	// 1.1.3
	// restore deleted post
	case 'restore_del':
		$post_id = $v->sql(@$_GET['id']);

		// check id exist or not
		$tb 	= new ElybinTable('elybin_posts');
		$copost = $tb->GetRowAnd('post_id', $post_id,'status','deleted');
		if(empty($post_id) || ($copost == 0)){
			_red('../../../404.html');
			exit;
		}
		// just change parent post status to 'deleted'
		$par = array(
			'status' => 'draft'
		);

		//Done
		$tb->Update($par, 'post_id', $post_id);
		_red('admin.php?mod=post&act=edit&id='.$post_id.'&msg=delrestored');
		break;

	default:
	$tb 	= new ElybinTable('elybin_posts');

	$search = $v->sql(@$_GET['search']);

	// search
	if(isset($_GET['search'])){
		$multiquery = @explode(":", @$search);
		if($multiquery[0] == 'tag'){
			$s_q = " && (`p`.`tag` LIKE '%".$multiquery[1]."%')";
		}else{
			$s_q = " && (`p`.`title` LIKE '%$search%' || `u`.`fullname` LIKE '%$search%' || `c`.`name` LIKE '%$search%')";
		}
	}else{
		$s_q = "";
	}

	// 1.1.3
	// with filter
	if(!isset($_GET['filter'])){
		// exclude 'revision'
		// normal query
		$que = "
		SELECT
		*,
		`c`.`name` as `category_name`,
		`p`.`status` as `post_status`
		FROM
		`elybin_posts` as `p`,
		`elybin_category` as `c`,
		`elybin_users` as `u`
		WHERE
		(`p`.`status` = 'active' || `p`.`status` = 'deactive') &&
		`p`.`type` = 'page' &&
		`u`.`user_id` = `p`.`author`
		$s_q
		GROUP BY
		`p`.`post_id`
		";
	}
	else if(isset($_GET['filter']) && @$_GET['filter'] == 'active'){
		// exclude 'revision'
		// normal query
		$que = "
		SELECT
		*,
		`c`.`name` as `category_name`,
		`p`.`status` as `post_status`
		FROM
		`elybin_posts` as `p`,
		`elybin_category` as `c`,
		`elybin_users` as `u`
		WHERE
		`p`.`status` = 'active' &&
		`p`.`type` = 'page' &&
		`u`.`user_id` = `p`.`author`
		$s_q
		GROUP BY
		`p`.`post_id`
		";
	}
	else if(isset($_GET['filter']) && @$_GET['filter'] == 'deactive'){
		// exclude 'revision'
		// normal query
		$que = "
		SELECT
		*,
		`c`.`name` as `category_name`,
		`p`.`status` as `post_status`
		FROM
		`elybin_posts` as `p`,
		`elybin_category` as `c`,
		`elybin_users` as `u`
		WHERE
		`p`.`status` = 'deactive' &&
		`p`.`type` = 'page' &&
		`u`.`user_id` = `p`.`author`
		$s_q
		GROUP BY
		`p`.`post_id`
		";
	}


	$cop = $tb->GetRowFullCustom($que);
	// modify query to pageable & shortable
	$oarr = array(
		'default' => '`p`.`post_id` DESC',
		'title' => '`p`.`title`',
		'date' => '`p`.`date`'
	);
	$que = _PageOrder($oarr, $que);
	$lpost	= $tb->SelectFullCustom($que);

	//echo '<pre>'.$que.'</pre>';
?>
		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<div class="breadcrumb-label text-light-gray"><?php echo lg('You are here:') ?></div>
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li class="active"><a href="?mod=page"><?php echo lg('Page') ?></a></li>

			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-pencil"></i>&nbsp;&nbsp;<?php echo lg('Page')?></span>
					<span class="hidden-xs"><?php echo lg('Page') ?></span>
					<?php if($search!==''){ echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-light-gray text-sm">'.lg('Search result for').' <i>&#34;'.$search.'&#34;</i>';} ?>
				</h1>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<div class="pull-right col-xs-12 col-sm-6 col-md-4">
							<a href="?mod=page&amp;act=add" class="pull-right btn btn-success btn-labeled" style="width: 100%">
							<span class="btn-label icon fa fa-plus"></span>&nbsp;&nbsp;<?php echo lg('New Page')?></a>
						</div>

					</div>
				</div>
			</div>
		</div> <!-- ./Page Header -->

		<?php
			// 1.1.3
			// msg
			if(@$_GET['msg'] == 'deleted'){
				echo '<div class="note note-success depth-xs"><i class="fa fa-check"></i> ' . lg('Page deleted successfully.') . '</div>';
			}
		?>

		<!-- Content here -->
		<div class="row">
			<div class="col-sm-12">
				<!-- Tabs -->
				<ul class="nav nav-tabs nav-tabs-xs">
					<li<?php if(!isset($_GET['filter'])){echo' class="active"'; }?>>
						<?php
						// count all post
						$totallpage = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_posts` as `p`
							WHERE
							(`p`.`status` = 'active' || `p`.`status` = 'deactive') &&
							`p`.`type` = 'page'
							GROUP BY
							`p`.`post_id`
						");
						?>
						<a href="?mod=page"><?php echo lg('All') ?> <span class="badge badge-default"><?php echo $totallpage ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='active'){echo' class="active"'; }?>>
						<?php
						// count all page
						$totpbpage = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_posts` as `p`
							WHERE
							`p`.`status` = 'active' &&
							`p`.`type` = 'page'
							GROUP BY
							`p`.`post_id`
						");
						?>
						<a href="?mod=page&amp;filter=active"><?php echo lg('Activate') ?> <span class="badge badge-success"><?php echo $totpbpage ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='deactive'){echo' class="active"'; }?>>
						<?php
						// count all post
						$totdrpage = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_posts` as `p`
							WHERE
							`p`.`status` = 'deactive' &&
							`p`.`type` = 'page'
							GROUP BY
							`p`.`post_id`
						");
						?>
						<a href="?mod=page&amp;filter=deactive"><?php echo lg('Deactivate') ?> <span class="badge badge-info"><?php echo $totdrpage ?></span></a>
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
							'date' => lg('Date')
						);
						showOrder($orb);
						showSearch();
						?>
						<!-- delate -->
						<form action="<?php echo $action?>" method="post">
						<input type="hidden" name="act" value="multidel" />
						<input type="hidden" name="mod" value="page" />

						<table class="table table-bordered table-striped" id="results">
						 <thead>
						   <tr>
						    <th><i class="fa fa-square" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo lg('Check All')?>"></i></th>
						    <th><?php echo lg('Title') ?></th>
						    <th><?php echo lg('Author') ?></th>
						    <th><?php echo lg('Date') ?></th>
						    <th><?php echo lg('Status')?></th>
						    <th><?php echo lg('Action')?></th>
						   </tr>
						 </thead>
						 <tbody>
						<?php

						$no = 0;
						foreach($lpost as $cp){
							$tbc 	= new ElybinTable('elybin_comments');
							$ccom	= $tbc->GetRow('post_id',$cp->post_id);

						?>
						   <tr>
							<td width="1%"><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo epm_encode($cp->post_id)?>|<?php echo $cp->title?>"><span class="lbl"></span></label></td>
							<td width="40%"><?php echo $cp->title?>
							<?php
							// jika publish tammpil link
							if($cp->post_status == 'active'){
								echo ' - <a href="'.get_url('page', $cp->post_id).'" target="_blank">'.lg('View').'</a>';
							}?>
							</td>
							<td><?php echo $cp->fullname?></td>
							<td><?php echo friendly_date($cp->date)?></td>
							<td><?php
							// status
							if($cp->post_status == 'active'){
								echo lg('Activate');
							}
							else if($cp->post_status == 'deactive'){
								echo lg('Deactivate');
							}
							?></td>
							<td>
								<div id="tooltip">

						    		<?php
										echo '<a href="?mod=page&amp;act=edit&amp;hash='.epm_encode($cp->post_id).'" class="btn btn-success btn-outline btn-sm" data-placement="bottom" data-toggle="tooltip" data-original-title="'.lg('Edit').'"><i class="fa fa-pencil-square-o"></i></a>&nbsp;';
										echo '<a href="?mod=page&amp;act=del&amp;hash='.epm_encode($cp->post_id).'&amp;clear=yes" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="'.lg('Delete Permanently').'"><i class="fa fa-trash-o"></i><i class="fa fa-times"></i></a>';
									?>

								</div>
							</td>
						   </tr>
						<?php
							$no++;
						}


						if($no < 1){
							echo '<tr><td colspan="6"><div class="text-center text-light-gray panel-padding"><i class="fa fa-5x fa-desktop"></i><br/>'. lg('Nothing can be shown.').'</div></td></tr>';
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
									<?php echo '<h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;'.lg('Delete Permanently').'</h4>'; ?>
									</div>
									<div class="modal-body">
										<?php
										echo lg('Are you sure you want delete permanently this item?');
										?>
										<div id="deltext"></div>
										<hr/>
										<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Delete All')?></button>
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



						<?php showPagging($cop) ?>

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
