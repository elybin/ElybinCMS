<?php
if(!isset($_SESSION['login'])){
	header('location: ../../../404.html');
}else{
	// get last name
	$u = _u();
	$op = _op();
	// explode
	$nick_t = @explode(' ', $u->fullname);
	// first or last
	if($op->short_name == 'first'){
		$u->nickname = $nick_t[0];
	}else{
		$u->nickname = $nick_t[count($nick_t)-1];
	}
?>
				<!-- Welcome -->
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="stat-panel lol">
							<div class="stat-row no-border">

								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered">
									<div class="col-sm-12 col-md-12">
										<div class="visible-xs hidden-sm" style="height: 170px;"></div>
										<h1><?php echo lg('Hi,').' '.$u->nickname?></h1>
										<p class="text-slim text-bg"><?php echo lg('Welcome to your dashboard, share your awesome story to the world!') ?></p>
									</div>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
				</div> <!-- /.row -->
				<!-- ./Welcome -->
<?php } ?>
