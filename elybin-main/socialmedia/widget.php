<?php
if(empty($_SESSION['together'])){
	header('location: ../../404.html');
	exit;
}

// include widget language
include("lang.php");
?>
				<!-- .row -->
				<div class="row">
					<div class="col-sm-12">
						<h3 class="text-center"><?php echo $lg_followus?></h3>
						<div class="clearfix"></div>
						<ul class="list-inline text-center">
							<li>
								<a href="https://twitter.com/<?php echo $op->social_twitter?>" target="_blank">
									<span class="fa-stack">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-twitter fa-stack-1x fa-inverse"></i>
									</span>
								</a>
							</li>
							<li>
								<a href="http://facebook.com/<?php echo $op->social_facebook?>" target="_blank">
									<span class="fa-stack">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-facebook fa-stack-1x fa-inverse"></i>
									</span>
								</a>
							</li>
							<li>
								<a href="http://instagram.com/<?php echo $op->social_instagram?>" target="_blank">
									<span class="fa-stack">
										<i class="fa fa-circle fa-stack-2x"></i>
										<i class="fa fa-instagram fa-stack-1x fa-inverse"></i>
									</span>
								</a>
							</li>
						</ul>
					</div>
				</div>
				<!-- .row -->