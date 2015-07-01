<?php
/* Short description for file
 * Module: User
 *	
 * Elybin CMS (www.elybin.com) - Open Source Content Management System 
 * @copyright	Copyright (C) 2014 - 2015 Elybin .Inc, All rights reserved.
 * @license		GNU General Public License version 2 or later; see LICENSE.txt
 * @author		Khakim Assidiqi <hamas182@gmail.com>
 ---------------
 1.1.3
	- Redesign List
 */
if(!isset($_SESSION['login'])){
	header('location: index.php');
}else{
$modpath 	= "app/page/";
$action		= $modpath."proses.php";

// string validation for security
$v 	= new ElybinValidasi();

// get usergroup privilage/access from current user to this module
$usergroup = _ug()->user;

// give error if no have privilage
if($usergroup == 0){
	er('<strong>'.lg('Ouch!').'</strong> '.lg('You don\'t have access to this page. Access Desied 403.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
	theme_foot();
	exit;
}else{
	switch (@$_GET['act']) {
		case 'add':
		$tb = new ElybinTable('elybin_usergroup');

		// get current active user
		$u = _u();

		// get session if exist 
		$s_un = @$_SESSION['s_username'];
		$s_em = @$_SESSION['s_email'];
		$s_lv = @$_SESSION['s_level'];
?>		<!-- help -->
		<div class="page-header hide-light" id="help-panel">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=user"><?php echo lg('Users Management') ?></a></li>
			<li class="active"><a href="?mod=user&amp;act=add"><?php echo lg('New User') ?></a></li>
			
			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=user" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to User Management') ?></a>
			<h1><?php echo lg('New User') ?></h1>
		</div> <!-- / .page-header -->
		
		<style><?php include("assets/stylesheets/select2.min.css"); ?></style>
		<form action="app/user/proses.php" method="post" id="form">
			<div class="row">
				<div class="col-sm-9">
					<div class="form-horizontal panel-wide" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.05); ">
						<div class="panel-body">
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Username') ?>*</label>
								<div class="col-sm-10">
									<input type="text" name="username" class="form-control" placeholder="<?php echo lg('Example:') ?> kabayan808" value="<?php echo $s_un ?>" required/>
									<p class="help-block"><?php echo lg('Allowed character for username is small letter (a-z) and number (0-9). This field must filled, it\'s very important.')?></p>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Password') ?>*</label>
								<div class="col-sm-10">
									<input type="password" name="password" class="form-control" placeholder="<?php echo lg('Example:') ?> p@nj1m1l3n1um" required/>
									<p class="help-block"><?php echo lg('To get perfect data protection, use mixed combination of letter, number and symbol.')?></p>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Confrim Password') ?>*</label>
								<div class="col-sm-10">
									<input type="password" name="password_confrim" class="form-control" placeholder="<?php echo lg('Example:')?> p@nj1m1l3n1um" required/>
									<p class="help-block"><?php echo lg('Type password again, it will keep you remember the phrase.')?></p>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('E-mail')?>*</label>
								<div class="col-sm-10">
									<input type="email" name="email" class="form-control" placeholder="<?php echo lg('Example:')?> kabayan_808@mail.com"  value="<?php echo $s_em ?>" required/>
									<p class="help-block"><?php echo lg('E-mail used to many thing, such as reseting password, sending message, etc.')?></p>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Level')?>*</label>
								<div class="col-sm-10">
					      			<select name="level" id="multiselect-style" class="form-control">
								    <?php
									    // 1.1.1
									    // only root admin can creating administrator
								    	// since 1.1.3
								    	// no body can create su user
										$lug	= $tb->SelectCustom("SELECT * FROM", "WHERE `usergroup_id` != '1'");
										foreach ($lug as $cug) {
											$out = '';

											// display privilage
											if($cug->post == 1){
												$out .= lg('Post').', ';
											}
											if($cug->category == 1){
												$out .= lg('Category').', ';
											}
											if($cug->tag == 1){
												$out .= lg('Tag').', ';
											}
											if($cug->comment == 1){
												$out .= lg('Comment').', ';
											}
											if($cug->media == 1){
												$out .= lg('Media').', ';
											}
											if($cug->page == 1){
												$out .= lg('Page').', ';
											}
											// since 1.1.3, gallery had removed, coz it merged to album & media
											if($cug->album == 1){
												$out .= lg('Album').', ';
											}
											// everyone have message access, but not everyone have full access.
											// since 1.1.3, contact changed to messager
											if($cug->message == 1){
												$out .= lg('Message').', ';
											}
											if($cug->user == 1){
												$out .= lg('User').', ';
											}
											if($cug->setting == 1){
												$out .= lg('Settings');
											}

											// if no have privilage
											if(empty($out)){
												$out .= $cug->name.' ('.lg('Basic Access').')';
											}else{
												// remove coma
												$out = $cug->name.' ('.rtrim($out, ", ").')';
											}
											echo '<option value="'.$cug->usergroup_id.'">'.$out.'</option>';
								    	} 
								    ?>
					   				</select>
					   				<p class="help-block"><?php echo lg('Select user privilage, make them keep ordered.')?></p>
								</div>
					    	</div> <!-- / .form-group -->
						  </div><!-- / .panel-body -->
					</div>
				</div><!-- / .col -->
				
				<div class="col-sm-3">
					<div class="panel-body text-center" style="box-shadow: 2px 1px 5px rgba(0,0,0,0.1); margin-bottom: 2px;">
						<button type="submit" value="Submit" class="btn btn-success" style="width: 100%"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save Data') ?></button>
					</div>
				</div><!-- / .col -->

				<input type="hidden" name="act" value="add" />
				<input type="hidden" name="mod" value="user" />
			</form><!-- / .form -->
		</div><!-- / .row -->
<?php
			break;

		case 'edit';
		$uid = $v->sql(epm_decode(@$_GET['hash']));

		// change to single query
		$tb = new ElybinTable('elybin_users');
		$cu = $tb->SelectFullCustom("
			SELECT
			*,
			COUNT(`user_id`) as `row`
			FROM
			`elybin_users` as `u`
			WHERE
			`u`.`user_id` = $uid &&
			`u`.`user_id` != 1 
			")->current();

		// check id exist or not or super user
		if($cu->row < 1){
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Page Not Found 404.').'<a class="btn btn-default btn-xs pull-right" onClick="history.back();"><i class="fa fa-share"></i>&nbsp;'.lg('Back').'</a>');
			theme_foot();
			exit;
		}

		// get current user session
		$u = _u();

		// declare tb ug
		$tbug = new ElybinTable('elybin_usergroup');

?>		<!-- help -->
		<div class="page-header hide-light" id="help-panel">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li><a href="?mod=user"><?php echo lg('Users Management') ?></a></li>
			<li class="active"><a href="?mod=user&amp;act=edit"><?php echo lg('Edit User') ?></a></li>
			
			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Content here -->
		<div class="page-header">
			<a href="?mod=user" class="btn btn-default pull-right"><i class="fa fa-long-arrow-left"></i>&nbsp;&nbsp;<?php echo lg('Back to User Management') ?></a>
			<h1><?php echo lg('Edit User') ?></h1>
		</div> <!-- / .page-header -->
		
		<style><?php include("assets/stylesheets/select2.min.css"); ?></style>
		<form action="app/user/proses.php" method="post" id="form">
			<div class="row">
				<div class="col-sm-9">
					<div class="form-horizontal panel-wide" style="box-shadow: 1px 1px 5px rgba(0,0,0,0.05); ">
						<div class="panel-body">
						<?php
						// 1.1.3
						// sparate edit form
						if(!isset($_GET['sub']) || @$_GET['sub'] == 'account'){
						?>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Username') ?>*</label>
								<div class="col-sm-10">
									<input type="text" name="username" class="form-control" placeholder="<?php echo lg('Example:') ?> kabayan808" value="<?php echo $cu->user_account_login ?>" required/>
									<p class="help-block"><?php echo lg('Allowed character for username is small letter (a-z) and number (0-9). This field must filled, it\'s very important.')?></p>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Password') ?>*</label>
								<div class="col-sm-10">
									<input type="password" name="password" class="form-control" placeholder="<?php echo lg('Example:') ?> p@nj1m1l3n1um"/>
									<p class="help-block"><?php echo lg('To get perfect data protection, use mixed combination of letter, number and symbol.')?></p>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Confrim Password') ?>*</label>
								<div class="col-sm-10">
									<input type="password" name="password_c" class="form-control" placeholder="<?php echo lg('Example:')?> p@nj1m1l3n1um"/>
									<p class="help-block"><?php echo lg('Type password again, it will keep you remember the phrase.')?></p>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('E-mail')?>*</label>
								<div class="col-sm-10">
									<input type="email" name="email" class="form-control" placeholder="<?php echo lg('Example:')?> kabayan_808@mail.com"  value="<?php echo $cu->user_account_email ?>" required/>
									<p class="help-block"><?php echo lg('E-mail used to many thing, such as reseting password, sending message, etc.')?></p>
								</div>
							</div> <!-- / .form-group -->
							<hr/>

							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Level')?>*</label>
								<div class="col-sm-10">
							      	<select name="level" class="form-control" id="multiselect-style" required>
								    <?php
									    // 1.1.3
								    	// nobody can create user with level su/1
										$lug	= $tbug->SelectCustom("SELECT * FROM", "WHERE `usergroup_id` != 1");
										foreach ($lug as $cug) {
											$out = '';

											// display privilage
											if($cug->post == 1){
												$out .= lg('Post').', ';
											}
											if($cug->category == 1){
												$out .= lg('Category').', ';
											}
											if($cug->tag == 1){
												$out .= lg('Tag').', ';
											}
											if($cug->comment == 1){
												$out .= lg('Comment').', ';
											}
											if($cug->media == 1){
												$out .= lg('Media').', ';
											}
											if($cug->page == 1){
												$out .= lg('Page').', ';
											}
											// since 1.1.3, gallery had removed, coz it merged to album & media
											if($cug->album == 1){
												$out .= lg('Album').', ';
											}
											// everyone have message access, but not everyone have full access.
											// since 1.1.3, contact changed to messager
											if($cug->message == 1){
												$out .= lg('Message').', ';
											}
											if($cug->user == 1){
												$out .= lg('User').', ';
											}
											if($cug->setting == 1){
												$out .= lg('Settings');
											}

											// if no have privilage
											if(empty($out)){
												$out .= $cug->name.' ('.lg('Basic Access').')';
											}else{
												// remove coma
												$out = $cug->name.' ('.rtrim($out, ", ").')';
											}

											if($cu->level == $cug->usergroup_id){
												echo '<option value="'.$cug->usergroup_id.'" selected="selected">'.$out.'</option>';
								    		}else{
								    			echo '<option value="'.$cug->usergroup_id.'">'.$out.'</option>';
								    		}
								    	} 
								    ?>
					   				</select>
					   				<p class="help-block"><?php echo lg('Select user privilage, make them keep ordered.')?></p>
								</div>
					    	</div> <!-- / .form-group -->
					    	<!-- hidden -->
					    	<input type="hidden" name="sub" value="account"/>
							<?php
							}

							else if(@$_GET['sub'] == 'personal'){
							?>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Fullname')?>*</label>
								<div class="col-sm-10">
									<input type="text" name="fullname" class="form-control" placeholder="<?php echo lg('Example:')?> Kabayan S"  value="<?php echo $cu->fullname ?>" required/>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Bio')?></label>
								<div class="col-sm-10">
									<textarea rows="4" class="form-control" name="bio" placeholder="<?php echo lg('Example:')?> Simple person, best in farming and eating."><?php echo $cu->bio ?></textarea>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Phone')?></label>
								<div class="col-sm-10">
									<input type="text" name="phone" class="form-control" placeholder="<?php echo lg('Example:')?> +6286000000000"  value="<?php echo $cu->phone ?>"/>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Facebook')?></label>
								<div class="col-sm-2">
									https://facebook.com/
								</div>
								<div class="col-sm-8">
									<input type="text" name="facebook_id" class="form-control" placeholder="<?php echo lg('Example:')?> elybincms"  value="<?php echo $cu->facebook_id ?>"/>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Twitter')?></label>
								<div class="col-sm-2">
									https://twitter.com/
								</div>
								<div class="col-sm-8">
									<input type="text" name="twitter_id" class="form-control" placeholder="<?php echo lg('Example:')?> @elybincms"  value="<?php echo $cu->twitter_id ?>"/>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Website/Blog')?></label>
								<div class="col-sm-10">
									<input type="text" name="website" class="form-control" placeholder="<?php echo lg('Example:')?> www.elybin.com"  value="<?php echo $cu->website ?>"/>
								</div>
							</div> <!-- / .form-group -->
					    	<!-- hidden -->
					    	<input type="hidden" name="sub" value="personal"/>
							<?php
							}
							else if(@$_GET['sub'] == 'avatar'){	
							?>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Current Avatar')?></label>
								<div class="col-sm-10">
									<?php
									// set no img
									if($cu->avatar == 'default/no-ava.png'){
									?>
									<div class="pull-left">
										<i><?php echo lg('Medium - 300') ?></i><br/>
										<img src="../elybin-file/avatar/default/no-ava.png" width="300px" height="auto" class="img-thumbnail"><br/>
									</div>
									<div class="pull-left">
										<i><?php echo lg('Small - 100') ?></i><br/>
										<img src="../elybin-file/avatar/default/no-ava.png" width="100px" height="auto" class="img-thumbnail"><br/>
									</div>
									<div class="pull-left">
										<i><?php echo lg('Extra Small - 50') ?></i><br/>
										<img src="../elybin-file/avatar/default/no-ava.png" width="50px" height="auto" class="img-thumbnail"><br/>
									</div>
									<?php
									}else{
									?>
									<div class="pull-left">
										<i><?php echo lg('Medium - 300') ?></i><br/>
										<img src="../elybin-file/avatar/md-<?php echo $cu->avatar ?>" width="300px" height="auto" class="img-thumbnail"><br/>
									</div>
									<div class="pull-left">
										<i><?php echo lg('Small - 100') ?></i><br/>
										<img src="../elybin-file/avatar/sm-<?php echo $cu->avatar ?>" width="100px" height="auto" class="img-thumbnail"><br/>
									</div>
									<div class="pull-left">
										<i><?php echo lg('Extra Small - 50') ?></i><br/>
										<img src="../elybin-file/avatar/xs-<?php echo $cu->avatar ?>" width="50px" height="auto" class="img-thumbnail"><br/>
									</div>
									<?php } ?>
								</div>
							</div> <!-- / .form-group -->
							<hr/>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Upload')?>*</label>
								<div class="col-sm-10">
									<input type="file" name="file" class="form-control" placeholder="<?php echo lg('Select file') ?>" id="file-style"/>
									<p class="help-block"><?php echo lg('Allowed images extension is (jpg, jpeg, png and gif).')?></p>
								</div>
							</div> <!-- / .form-group -->
					    	<!-- hidden -->
					    	<input type="hidden" name="sub" value="avatar"/>
					    	<?php
						    }
						    else if(@$_GET['sub'] == 'misc'){
						    ?>
							<div class="form-group">
								<label class="col-sm-2 control-label"><?php echo lg('Status')?>*</label>
								<div class="col-sm-5">
									<select name="status" class="form-control" id="multiselect-style" required>
								    	<option value="active"<?php if($cu->status=='active'){echo ' selected="selected"'; }?>><?php echo lg('Active') ?></option>
								    	<option value="deactive"<?php if($cu->status=='deactive'){echo ' selected="selected"'; }?>><?php echo lg('Blocked') ?></option>
					   				</select>
					   				<p class="help-block"><?php echo lg('If user blocked, they can\'t login into your website.')?></p>
								</div>
							</div> <!-- / .form-group -->
							
					    	<!-- hidden -->
					    	<input type="hidden" name="sub" value="misc"/>
						    <?php
						    }
						    ?>
						  </div><!-- / .panel-body -->
					</div>
				</div><!-- / .col -->
				
				<div class="col-sm-3">
					<div class="panel-body text-center" style="box-shadow: 2px 1px 5px rgba(0,0,0,0.1); margin-bottom: 2px;">
						<button type="submit" value="Submit" class="btn btn-success" style="width: 100%"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Save Changes') ?></button>
					</div>
				</div><!-- / .col -->
				
				<div class="col-sm-3">
					<div class="panel-body text-left" style="box-shadow: 2px 1px 5px rgba(0,0,0,0.1); margin-bottom: 2px;">
						<h4><?php echo lg('Edit Menu') ?></h4>
						<a href="?mod=user&amp;act=edit&amp;hash=<?php echo @$_GET['hash'] ?>&amp;sub=account" class="btn btn-default<?php if(!isset($_GET['sub']) || @$_GET['sub'] == 'account'){ echo ' btn-primary'; } ?> pull-left text-left" style="width: 100%"><i class="fa  fa-chevron-left"></i> <i class="fa fa-key pull-right" ></i> <?php echo lg('Account Detail') ?></a>
						<a href="?mod=user&amp;act=edit&amp;hash=<?php echo @$_GET['hash'] ?>&amp;sub=personal" class="btn btn-default<?php if(isset($_GET['sub']) && @$_GET['sub'] == 'personal'){ echo ' btn-primary'; } ?> pull-left text-left" style="width: 100%"><i class="fa  fa-chevron-left"></i><i class="fa fa-male pull-right"></i> <?php echo lg('Personal Info') ?></a>
						<a href="?mod=user&amp;act=edit&amp;hash=<?php echo @$_GET['hash'] ?>&amp;sub=avatar" class="btn btn-default<?php if(isset($_GET['sub']) && @$_GET['sub'] == 'avatar'){ echo ' btn-primary'; } ?> pull-left text-left" style="width: 100%"><i class="fa  fa-chevron-left"></i><i class="fa fa-camera pull-right"></i> <?php echo lg('Avatar') ?></a>
						<a href="?mod=user&amp;act=edit&amp;hash=<?php echo @$_GET['hash'] ?>&amp;sub=misc" class="btn btn-default<?php if(isset($_GET['sub']) && @$_GET['sub'] == 'misc'){ echo ' btn-primary'; } ?> pull-left text-left" style="width: 100%"><i class="fa  fa-chevron-left"></i><i class="fa fa-wrench pull-right"></i> <?php echo lg('Misc') ?></a>
					</div>
				</div><!-- / .col -->

				<input type="hidden" name="hash" value="<?php echo @$_GET['hash'] ?>" />
				<input type="hidden" name="act" value="edit" />
				<input type="hidden" name="mod" value="user" />
			</form><!-- / .form -->
		</div><!-- / .row -->
<?php
			break;

		case 'del':
		$uid = $v->sql(epm_decode(@$_GET['hash']));

		// can`t delete admin
		if($uid == 1){
			header('location: ../404.html');
			exit;
		}

		// check exsistance
		$tb = new ElybinTable('elybin_users');
		$cou = $tb->GetRow('user_id', $uid);
		if($cou < 1){
			er('<strong>'.lg('Ouch!').'</strong> '.lg('Can\'t perform this action, maybe this is internal system error.').'<a class="btn btn-default btn-xs pull-right" data-dismiss="modal"><i class="fa fa-times"></i>&nbsp;'.lg('Close').'</a>');
			exit;
		}
?>
							<div class="modal-header">
							<button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i></button>
							<h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?php echo lg('Delete Permanently') ?></h4>
							</div>
							<div class="modal-body">
								<p class="text-danger"><?php echo lg('Are you sure you want delete permanently this item. This action cannot be undone.')?></p>
								<hr></hr>
								<form action="app/messager/proses.php" method="post">
									<button type="submit" class="btn btn-danger"><i class="fa fa-check"></i>&nbsp;<?php echo lg('Yes, Delete')?></button>
									<a class="btn btn-default pull-right" data-dismiss="modal"><i class="fa fa-share"></i>&nbsp;<?php echo lg('Cancel')?></a>
									<input type="hidden" name="hash" value="<?php echo @$_GET['hash']?>" />
									<input type="hidden" name="act" value="del" />
									<input type="hidden" name="mod" value="user" />
								</form>
							</div>
<?php
			break;
		
	default:
		$tb = new ElybinTable('elybin_posts');

		$search = $v->sql(@$_GET['search']);	
			
		// search
		if(isset($_GET['search'])){
			$multiquery = @explode(":", @$search);
			if($multiquery[0] == 'uid'){
				$s_q = " && (`u`.`user_id` LIKE '%".$multiquery[1]."%')";
			}else{
				$s_q = " && (`u`.`user_account_email` LIKE '%$search%' || `u`.`user_account_login` LIKE '%$search%' || `u`.`fullname` LIKE '%$search%' || `u`.`phone` LIKE '%$search%')";
			}
		}else{
			$s_q = "";
		}
		

		// get current user session
		$u = _u();

		// 1.1.3
		if(isset($_GET['filter']) && @$_GET['filter'] == 'online'){
			// already online
			$que = "
			SELECT
			*
			FROM
			`elybin_users` as `u`,
			`elybin_usergroup` as `ug`
			WHERE
			`ug`.`usergroup_id` = `u`.`level` &&
			`u`.`session` != 'offline' &&
			`u`.`user_id` != ".$u->user_id."
			$s_q
			";
		}
		else if(isset($_GET['filter']) && @$_GET['filter'] == 'blocked'){
			// blocked user
			$que = "
			SELECT
			*
			FROM
			`elybin_users` as `u`,
			`elybin_usergroup` as `ug`
			WHERE
			`ug`.`usergroup_id` = `u`.`level` &&
			`u`.`status` = 'deactive' &&
			`u`.`user_id` != ".$u->user_id."
			$s_q
			";
		}
		else{
			// normal query
			$que = "
			SELECT
			*
			FROM
			`elybin_users` as `u`,
			`elybin_usergroup` as `ug`
			WHERE
			`ug`.`usergroup_id` = `u`.`level` &&
			`u`.`user_id` != ".$u->user_id." &&
			`u`.`status` = 'active'
			$s_q
			";
		}

		
		$cou = $tb->GetRowFullCustom($que);
		// modify query to pageable & shortable
		$oarr = array(
			'default' => '`u`.`user_id` DESC',
			'username' => '`u`.`user_account_login`',
			'fullname' => '`u`.`fullname`',
			'registered' => '`u`.`registered`',
			'level' => '`u`.`level`',
			'lastlogin' => '`u`.`lastlogin`'
		);
		$que = _PageOrder($oarr, $que);
		$luser = $tb->SelectFullCustom($que);

		//echo '<pre>'.$que.'</pre>';
?>		<!-- help -->
		<div class="page-header" id="help-panel" style="display: none">
			<p><?php echo lg('...') ?></p>
		</div>
		<!-- breadcrumb -->
		<ul class="breadcrumb breadcrumb-page">
			<li><a href="?mod=home"><?php echo lg('Home') ?></a></li>
			<li class="active"><a href="?mod=user"><?php echo lg('User Management') ?></a></li>
			
			<div class="pull-right">
				<a class="btn btn-xs" id="help-button"><i class="fa fa-question-circle"></i> <?php echo lg('Help') ?></a>
			</div>
		</ul>
		<!-- Page Header -->
		<div class="page-header">
			<div class="row">
				<h1 class="col-xs-12 col-sm-6 col-md-6 text-center text-left-sm">
					<span class="hidden-sm hidden-md hidden-lg"><i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo lg('User Management')?></span>
					<span class="hidden-xs"><?php echo lg('User Management') ?></span>
					<?php if($search!==''){ echo '&nbsp;&nbsp;&nbsp;&nbsp;<span class="text-light-gray text-sm">'.lg('Search result for').' <i>&#34;'.$search.'&#34;</i>';} ?>
				</h1>
				<div class="col-xs-12 col-sm-6 col-md-6">
					<div class="row">
						<hr class="visible-xs no-grid-gutter-h">
						<div class="pull-right col-xs-12 col-sm-9 col-md-5">	
							<a href="?mod=user&amp;act=add" class="pull-right btn btn-success btn-labeled" style="width: 100%">
							<span class="btn-label icon fa fa-plus"></span>&nbsp;&nbsp;<?php echo lg('Register New User')?></a>
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
						// count all
						$tot = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_users` as `u`,
							`elybin_usergroup` as `ug`
							WHERE
							`ug`.`usergroup_id` = `u`.`level` &&
							`u`.`user_id` != '".$u->user_id."' &&
							`u`.`status` = 'active'
						");
						?>
						<a href="?mod=user"><?php echo lg('All') ?> <span class="badge badge-default"><?php echo $tot ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='online'){echo' class="active"'; }?>>
						<?php 
						// count all post
						$toton = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_users` as `u`,
							`elybin_usergroup` as `ug`
							WHERE
							`ug`.`usergroup_id` = `u`.`level` &&
							`u`.`session` != 'offline' &&
							`u`.`user_id` != '".$u->user_id."'
						");
						?>
						<a href="?mod=user&amp;filter=online"><?php echo lg('Online') ?> <span class="badge badge-success"><?php echo $toton ?></span></a>
					</li>
					<li<?php if(@$_GET['filter']=='blocked'){echo' class="active"'; }?>>
						<?php 
						// count all post
						$totblck = $tb->GetRowFullCustom("
							SELECT
							*
							FROM
							`elybin_users` as `u`,
							`elybin_usergroup` as `ug`
							WHERE
							`ug`.`usergroup_id` = `u`.`level` &&
							`u`.`status` = 'deactive' &&
							`u`.`user_id` != '".$u->user_id."'
						");
						?>
						<a href="?mod=user&amp;filter=blocked"><?php echo lg('Blocked') ?> <span class="badge badge-danger"><?php echo $totblck ?></span></a>
					</li>
				</ul> <!-- / .nav -->
				<!-- Panel -->
				<div class="panel">
					<!-- ./Panel Heading -->
					<div class="panel-body">
					  <div class="table-primary table-responsive">
						
						<?php
						showOrder(array(
							'username' => lg('Username'),
							'fullname' => lg('Fullname'),
							'registered' => lg('Registered Date'),
							'level' => lg('Access Level'),
							'lastlogin' => lg('Last Login')
						));
						showSearch();
						?>
						<!-- delate -->
						<form action="app/user/proses.php" method="post">
						<input type="hidden" name="act" value="multidel" />
						<input type="hidden" name="mod" value="user" />
						
						<table class="table table-bordered table-striped" id="results">
						 <thead>
						   <tr>
						    <th width="1%"><i class="fa fa-square" id="tooltip-ck" data-placement="bottom" data-toggle="tooltip" data-original-title="<?php echo lg('Check All')?>"></i></th>
						    <th width="50px"><?php echo lg('Avatar') ?></th>
						    <th width="40%"><?php echo lg('Name') ?></th>
						    <th><?php echo lg('Registred/Last Login')?></th>
						    <th><?php echo lg('Level') ?></th>
						    <th><?php echo lg('Status')?></th>
						    <th><?php echo lg('Action')?></th>
						   </tr>
						 </thead>
						 <tbody>
						<?php

						$no = 0;
						foreach($luser as $cu){
							// avatar 
							if($cu->avatar == 'default/no-ava.png'){
								$cu->avatar = 'default/medium-no-ava.png';
							}else{
								$cu->avatar = 'sm-'.$cu->avatar;
							}

							// online status
							if($cu->session == 'offline'){
								$cu->session_icon = '<i class="fa fa-circle-o"></i>&nbsp;';
							}else{
								$cu->session_icon = '<i class="fa fa-circle text-success"></i>&nbsp;';
							}
						?>
						   <tr>
							<td><label class="px-single"><input type="checkbox" class="px" name="del[]" value="<?php echo $cu->user_id?>|<?php echo $cu->fullname?>"><span class="lbl"></span></label></td>
							<td><img src="../elybin-file/avatar/<?php echo $cu->avatar ?>" width="50px" height="50px"></td>
							<td><?php echo $cu->session_icon.$cu->fullname?> <i class="text-xs text-light-gray">@<?php echo $cu->user_account_login?><br/>
								<a href="?mod=messager&amp;act=compose&amp;hash=<?php echo epm_encode($cu->user_id) ?> "><i class="fa fa-envelope"></i> <?php echo lg('Send Message')?></a> </i>
							</td>
							<td><?php echo time_elapsed_string($cu->registered)?><br/>
								<i class="text-xs text-light-gray"><?php echo time_elapsed_string($cu->lastlogin)?></i>
							</td>
							<td><?php echo $cu->name?></td>
							<td><?php 
							// status
							if($cu->status == 'active'){
								echo lg('Active');
							}
							else if($cu->status == 'deactive'){
								echo '<i class="text-danger">'.lg('Blocked').'</i>';
							}
							?></td>
							<td>
								<div id="tooltip">
						    		<?php 
									echo '<a href="?mod=user&amp;act=edit&amp;hash='.epm_encode($cu->user_id).'" class="btn btn-default btn-sm"  data-placement="bottom" data-original-title="'.lg('Edit').'"><i class="fa fa-pencil"></i></a>&nbsp;';
									echo '<a href="?mod=user&amp;act=del&amp;hash='.epm_encode($cu->user_id).'&amp;clear=yes" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete"  data-placement="bottom" data-original-title="'.lg('Delete Permanently').'"><i class="fa fa-trash-o"></i><i class="fa fa-times"></i></a>';
									?>
									
								</div>
							</td>
						   </tr>
						<?php
							$no++;
						}
						
						
						if($no < 1){
							echo '<tr><td colspan="7"><div class="text-center text-light-gray panel-padding"><i class="fa fa-5x fa-users"></i><br/>'. lg('Nothing can be shown.').'</div></td></tr>';
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
									<h4 class="modal-title text-danger"><i class="fa fa-exclamation-triangle"></i>&nbsp;&nbsp;<?php echo lg('Delete Permanently') ?></h4>
									
									</div>
									<div class="modal-body">
										<?php echo lg('Are you sure you want delete permanently this item?') ?>
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
						
						
						
						<?php showPagging($cou) ?>
						
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
