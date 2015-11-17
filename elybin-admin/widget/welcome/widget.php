<?php
if(!isset($_SESSION['login'])){
	// get last name
	$u = _u();
	// explode
	$nick_t = @explode(' ', $u->fullname);
	// first or last
	if(get_option('short_name') == 'first'){
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
										<h1><?php printf(	__('Hi, %s'), $u->nickname	) ?></h1>
										<p class="text-slim text-bg"><?php _e('Welcome to your dashboard, share your awesome story to the world!') ?></p>
									</div>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
				</div> <!-- /.row -->
				<!-- ./Welcome -->
<?php } ?>
