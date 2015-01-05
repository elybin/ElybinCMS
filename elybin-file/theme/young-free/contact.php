<?php
  include_once 'header.php';
  include_once 'menu.php';
?>


    <!-- Main Content -->
    <div class="container">
		<div class="clearfix" style="margin-top:90px"></div>
		<!-- search bar -->
		<div class="row">
            <div class="col-lg-8 col-lg-offset-2 text-center" id="contact-title">
                <h2 class="section-heading">CONTACT</h2>
                <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
				<hr/>
            </div>
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1" id="contact-form">
			
			
                <p class="post-subtitle">Want to get in touch with me? Fill out the form below to send me a message and I will try to get back to you within 24 hours!</p>
                <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
                <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
                <!-- NOTE: To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
                <form name="sentMessage" action="elybin-main/contact/contact.php">
                    <div class="row control-group">
                        <div class="form-group col-xs-12 controls">
                            <input type="text" class="form-control input-lg" placeholder="<?php echo $lg_yourname?>*" id="name" required data-validation-required-message="Please enter your name.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 controls">
                            <input type="email" class="form-control input-lg" placeholder="<?php echo $lg_youremail?>*" id="email" required data-validation-required-message="Please enter your email address.">
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-12 controls">
                            <textarea rows="5" class="form-control input-lg" placeholder="<?php echo $lg_yourmessage?>*" id="message" required data-validation-required-message="Please enter a message."></textarea>
                            <p class="help-block text-danger"></p>
                        </div>
                    </div>
                    <div class="row control-group">
                        <div class="form-group col-xs-6 col-md-3 controls">
                            <input type="text" class="form-control input-lg" placeholder="<?php echo $lg_insertcode?>*" id="code" required data-validation-required-message="Please enter code.">
                            <p class="help-block text-danger"></p>
                        </div>
						<div class="form-group col-xs-6 col-md-3 controls">
                            <img src="code.jpg" class="img-rounded img-thumbnail" style="height: 50px">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group col-xs-12">
                            <button type="submit" class="btn btn-default"><?php echo $lg_sendmessage?></button>
							<span id="loading" style="display: none">&nbsp;&nbsp; <i class="fa fa-spin fa-repeat"></i>&nbsp;&nbsp;<?php echo $lg_sending?>...</span>
                        </div>
                    </div>
                </form>
            </div>
			
			<div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
				<div class="text-center" id="success">
					<h2><?php echo $lg_sent?>!</h2>
					<i class="fa fa-6x fa-check-circle text-success"></i>
					<p></p>
				</div>

				<div class="text-center" id="error">
					<a href="#" class="close"><i class="fa fa-times"></i></a><br/>
					<h2><?php echo $lg_ouch?>!</h2>
					<i class="fa fa-6x fa-times-circle text-danger"></i>
					<p><?php echo $lg_failedtosendmessagepleaseresend?>.</p>
				</div>
                <div id="pleasefill" class="hidden"><?php echo $lg_pleasefillimportant?></div>
			</div>
        </div>
		<!-- .row -->
    </div>
<?php
  include "footer.php";
?>
