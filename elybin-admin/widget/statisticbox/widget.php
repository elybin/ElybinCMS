<?php
if(!isset($_SESSION['login'])){
	header('location: ../../../404.html');
}else{
?>
				<!-- Statistic Box -->
				<div class="row">
<?php
// get user privilages
$tbus = new ElybinTable('elybin_users');
$tbus = $tbus->SelectWhere('session',$_SESSION['login'],'','');
$level = $tbus->current()->level; // getting level from curent user

$tbug = new ElybinTable('elybin_usergroup');
$tbug = $tbug->SelectWhere('usergroup_id', $level,'','')->current();
// get priv (11)
$ugp = $tbug->post;
$ugcom = $tbug->comment;
$ugct = $tbug->contact;
$ugal = $tbug->album;
$ugu = $tbug->user;
$ugca = $tbug->category;
$ugm = $tbug->media;
$ugs = $tbug->setting;
$ugt = $tbug->tag;
$ugg = $tbug->gallery;
$ugpa = $tbug->page;

$ugshow = 1;
$ugtotal = $ugp + $ugcom + $ugct + $ugal + $ugu + $ugca + $ugm + $ugs + $ugt + $ugg + $ugpa;


	// if have priv
	if($ugtotal < 3){
		// set col
		if($ugtotal == 2){
			$scol = 4;
		}
		elseif($ugtotal == 1){
			$scol = 8;
		}
		elseif($ugtotal == 0){
			$scol = 12;
		}
?>
					<div class="col-xs-12 col-sm-12 col-md-<?php echo $scol; ?>">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold">
									<i class="fa fa-inbox"></i>&nbsp;&nbsp;Why Should Elybin?
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t">
									<p>ElybinCMS hadir memberikan solusi untuk anda yang ingin membuat website professional untuk pribadi, perusahaan ataupun komunitas dengan mudah dan cepat. </p>
									<?php if($ugtotal == 0){ ?>
									<p>Dengan beberapa fitur unggulan yang mudah digunakan membuat berbagi informasi menjadi lebih cepat dan efisien. </p>
									<?php } ?>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php
	}

	// show post
	if($ugp == 1 AND $ugshow < 4){
		$tbp = new ElybinTable('elybin_posts'); 
		// get data
		$copost = $tbp->GetRow('',''); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-pencil"></i>&nbsp;&nbsp;<?php echo $lg_post; ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $copost; ?></span>
									<br><small><small><?php echo $lg_published ?></small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php 	} 

	// show media
	if($ugm == 1 AND $ugshow < 4){
		$tbm = new ElybinTable('elybin_media'); 
		// get data
		$comedia = $tbm->GetRow('',''); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-cloud"></i>&nbsp;&nbsp;<?php echo $lg_media; ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $comedia; ?></span>
									<br><small><small><?php echo $lg_stored ?></small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php 
		} 
		
	// show comment
	if($ugcom == 1 AND $ugshow < 4){
		$tbcom = new ElybinTable('elybin_comments'); 
		// get data
		$cocomment = $tbcom->GetRow('',''); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-comments"></i>&nbsp;&nbsp;<?php echo $lg_comment; ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $cocomment; ?></span>
									<br><small><small>Writed</small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php
		} 
		
		
	// show contact
	if($ugct == 1 AND $ugshow < 4){
		$tbct = new ElybinTable('elybin_contact'); 
		// get data
		$cocontact = $tbct->GetRow('',''); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-envelope"></i>&nbsp;&nbsp;<?php echo $lg_contact; ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $cocontact; ?></span>
									<br><small><small>Saved</small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php 
		} 
		
	// show album
	if($ugal == 1 AND $ugshow < 4){
		$tbal = new ElybinTable('elybin_album'); 
		// get data
		$coalbum = $tbal->GetRow('',''); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo $lg_album; ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $coalbum; ?></span>
									<br><small><small>Created</small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php 
		} 
		
	// show user
	if($ugu == 1 AND $ugshow < 4){
		$tbu = new ElybinTable('elybin_users'); 
		// get data
		$couser = $tbu->GetRow('',''); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo $lg_user; ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $couser; ?></span>
									<br><small><small>Registred</small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php 
		} 
		
	// show category
	if($ugca == 1 AND $ugshow < 4){
		$tbca = new ElybinTable('elybin_category'); 
		// get data
		$cocategory = $tbca->GetRow('',''); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-star"></i>&nbsp;&nbsp;<?php echo $lg_category; ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $cocategory; ?></span>
									<br><small><small>Saved</small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php 
		} 
		
	// show tag
	if($ugt == 1 AND $ugshow < 4){
		$tbt = new ElybinTable('elybin_tag'); 
		// get data
		$cotag = $tbt->GetRow('',''); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-tags"></i>&nbsp;&nbsp;<?php echo $lg_tag; ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $cotag; ?></span>
									<br><small><small>Used</small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php
		} 
		
	// show gallery
	if($ugg == 1 AND $ugshow < 4){
		$tbg = new ElybinTable('elybin_gallery'); 
		// get data
		$cogallery = $tbg->GetRow('',''); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-picture-o"></i>&nbsp;&nbsp;Photos
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $cogallery; ?></span>
									<br><small><small>Stored</small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php 
		} 
		
	// show page
	if($ugpa == 1 AND $ugshow < 4){
		$tbpa = new ElybinTable('elybin_pages'); 
		// get data
		$copage = $tbpa->GetRow('',''); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-file"></i>&nbsp;&nbsp;<?php echo $lg_page; ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $copage; ?></span>
									<br><small><small>Writed</small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php 	
		} 
		
	// show setting
	if($ugs == 1 AND $ugshow < 4){
		// get data
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-gear"></i>&nbsp;&nbsp;<?php echo $lg_setting; ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $lg_yes; ?></span>
									<br><small><small><?php echo $lg_fullcontrol; ?></small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php 
		} 
?>
				</div> <!-- /.row -->
				<!-- ./Statistic Box -->
<?php } ?>