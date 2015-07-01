<?php
if(empty($_SESSION['together'])){
	header('location: ../../404.html');
	exit;
}
?>
				<!-- .row -->
				<div class="row">
					<div class="col-sm-12 text-center">
						
						<a href="elybin-admin/?p=register" class="btn btn-lg btn-primary"><i class="fa fa-2x fa-user"></i><br/><?php echo lg('Register') ?></a>
						<br/>
						<br/>
						
						<div class="clearfix"></div>
						
						
						<form action="./elybin-admin/login-process.php?p=login" class="panel bordered form-horizontal" method="POST" style="box-shadow: 1px 1px 8px rgba(0,0,0,0.2); border: 1px solid rgba(0,0,0,0.2)">
							<div class="panel-heading">
								<span class="panel-title"><h3 class="text-center"><?php echo lg('Login') ?></h3></span>
							</div>
							<div class="panel-body">
								<div class="row form-group">
									<label class="col-sm-4 control-label text-sm">E-mail:</label>
									<div class="col-sm-8">
										<input type="text" name="u" class="form-control" placeholder="E-mail..">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 control-label text-sm">Password:</label>
									<div class="col-sm-8">
										<input type="password" name="p" class="form-control" placeholder="..">
									</div>
								</div>
								<div class="row form-group">
									<label class="col-sm-4 control-label text-sm">Code:</label>
									<div class="col-md-4 col-sm-12">
										<input type="text" name="c" class="form-control" placeholder="Kode..">
									</div>
									<img src="code.jpg" style="height: 33px">
								</div>
							</div>
							<div class="panel-footer text-right">
								<a href="elybin-admin/?p=forgot" class="text-sm"><?php echo lg('Forgot Password') ?></a>&nbsp;&nbsp;&nbsp;
								<button class="btn btn-primary"><?php echo lg('Signin') ?></button>
							</div>
						</form>
					</div>
				</div>
				<!-- .row -->