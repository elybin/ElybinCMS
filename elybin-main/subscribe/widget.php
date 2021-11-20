<?php
if(empty($_SESSION['together'])){
	header('location: ../../404.html');
	exit;
}
if(@$_SESSION['donesubscribe']){
	
}else{
	// include widget language
	include("lang.php");
?>
				<div class="row">
					<div class="col-sm-12">
						<div id="subscribe">
							<h2><i class="fa fa-lg fa-check-square-o"></i> Subscribe</h2>
							
							<p class="small text-left text-md text-muted">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit.
							</p>
							
							<form id="subscribe-form" action="elybin-main/subscribe/subscribe.php" method="POST" class="text-center">
								<input type="email" name="email" id="emailinput" placeholder="<?php echo $lg_youremailhere; ?>..." class="form-control form-group-margin"/>
								<div class="row control-group" style="display: none" id="codecp">
									<div class="form-group col-xs-12 col-md-8 controls">
										<input type="text" class="form-control" name="code" placeholder="<?php echo $lg_insertcode?>*" id="code" required data-validation-required-message="Please enter code.">
										<p class="help-block text-danger"></p>
									</div>
									<div class="form-group col-xs-12 col-md-4 controls">
										<img src="code.jpg" class="img-rounded" style="height: 35px">
									</div>
								</div>
								<button type="submit" class="btn btn-default form-group-margin"><i class="fa fa-spin fa-repeat" style="display:none"></i>&nbsp;<span id="sub"><?php echo $lg_subscribe ?></span><span id="loading" style="display:none"><?php echo $lg_sending ?>...</span></button>
							</form>
						</div>
						
						<div class="text-center" id="subscribe-success" style="display: none">
							<a href="#" class="close"><i class="fa fa-times"></i></a><br/>
							<h2><?php echo $lg_ok?>!</h2>
							<i class="fa fa-6x fa-check-circle text-success"></i>
							<p></p>
						</div>
						
						<div class="text-center" id="subscribe-error" style="display: none">
							<a href="#" class="close"><i class="fa fa-times"></i></a><br/>
							<h2><?php echo $lg_ouch ?>!</h2>
							<i class="fa fa-6x fa-times-circle text-danger"></i>
							<p><?php echo $lg_failedtodotryagain ?></p>
						</div>
						<?php
						$footscriptinc .= 
						'<script src="elybin-main/subscribe/widget.js"></script>'; 
						?>
					</div>
				</div>
				<!-- .row -->
<?php } ?>