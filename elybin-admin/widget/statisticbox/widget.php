<?php
if(!isset($_SESSION['login'])){
	header('location: ../../../404.html');
}else{
?>
				<!-- Statistic Box -->
				<div class="row">
<?php
$ug = _ug();

// get priv (11)
$ugp 	= $ug->post;
$ugcom	= $ug->comment;
$ugal 	= $ug->album;
$ugu 	= $ug->user;
$ugca 	= $ug->category;
$ugm 	= $ug->media;
$ugs 	= $ug->setting;
$ugt 	= $ug->tag;
$ugpa 	= $ug->page;

$ugshow = 1;
$ugtotal = $ugp + $ugcom  + $ugal + $ugu + $ugca + $ugm + $ugs + $ugt + $ugpa;

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
									<i class="fa fa-inbox"></i>&nbsp;&nbsp;<?php echo lg('Why Should Elybin?') ?>
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
	if($ugp == 1 && $ugshow < 4){
		$tbp = new ElybinTable('elybin_posts'); 
		// get data
		$copost = $tbp->GetRowAnd('status','publish','type','post'); 
		$ugshow++;
?>
					<div class="col-xs-12 col-sm-12 col-md-4">
						<div class="stat-panel lol">
							<div class="stat-row">
								<!-- Info background, without padding, horizontally centered text, super large text -->
								<div class="stat-cell bg-dark-gray padding-md text-md text-semibold text-center">
									<i class="fa fa-pencil"></i>&nbsp;&nbsp;<?php echo lg('Post'); ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $copost; ?></span>
									<br><small><small><?php echo lg('Published') ?></small></small>
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
									<i class="fa fa-cloud"></i>&nbsp;&nbsp;<?php echo lg('Media') ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $comedia; ?></span>
									<br><small><small><?php echo lg('Organized') ?></small></small>
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
									<i class="fa fa-comments"></i>&nbsp;&nbsp;<?php echo lg('Comment'); ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $cocomment; ?></span>
									<br><small><small><?php echo lg('Reached') ?></small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php
		} 
		
		
	// show album
	if($ugal == 1 && $ugshow < 4){
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
									<i class="fa fa-book"></i>&nbsp;&nbsp;<?php echo lg('Album'); ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $coalbum; ?></span>
									<br><small><small><?php echo lg('Created') ?></small></small>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
<?php 
		} 
		
	// show user
	if($ugu == 1 && $ugshow < 4){
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
									<i class="fa fa-users"></i>&nbsp;&nbsp;<?php echo lg('User'); ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $couser; ?></span>
									<br><small><small><?php echo lg('Registered') ?></small></small>
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
									<i class="fa fa-star"></i>&nbsp;&nbsp;<?php echo lg('Category') ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $cocategory; ?></span>
									<br><small><small><?php echo lg('Saved') ?></small></small>
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
									<i class="fa fa-tags"></i>&nbsp;&nbsp;<?php echo lg('Tag'); ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $cotag; ?></span>
									<br><small><small><?php lg('Used') ?></small></small>
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
									<i class="fa fa-file"></i>&nbsp;&nbsp;<?php echo lg('Page'); ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo $copage; ?></span>
									<br><small><small><?php echo lg('Created') ?></small></small>
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
									<i class="fa fa-gear"></i>&nbsp;&nbsp;<?php echo lg('Setting'); ?>
								</div>
							</div> <!-- /.stat-row -->
							<div class="stat-row">
								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered no-border-t text-center text-lg">
									<span class="text-slg"><?php echo lg('Yes'); ?></span>
									<br><small><small><?php echo lg('Full Control') ?></small></small>
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