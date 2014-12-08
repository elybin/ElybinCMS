<?php
if(!isset($_SESSION['login'])){
	header('location: ../../../404.html');
}else{
?>
				<!-- Welcome -->
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12">
						<div class="stat-panel lol">
							<div class="stat-row no-border" style="background-image: url('../elybin-file/system/ads_welcome.jpg'); background-repeat: no-repeat; background-size: auto auto; background-position: right top">

								<!-- Bordered, without top border, horizontally centered text, large text -->
								<div class="stat-cell bordered">
									<div class="col-sm-8 col-md-6">
										<div class="visible-xs hidden-sm" style="height: 170px;"></div>
										<h1>Selamat Datang</h1>
										<p class="text-slim text-bg">Jadilah yang terdepan dalam berbagi informasi lebih cepat dan mudah dengan Elybin CMS.</p>
									</div>
								</div>
							</div> <!-- /.stat-row -->
						</div> <!-- /.stat-panel -->
					</div><!-- /.col-xs-4 -->
				</div> <!-- /.row -->
				<!-- ./Welcome -->
<?php } ?>