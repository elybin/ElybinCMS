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
                <h2 class="section-heading"><?php echo lg('Maps') ?></h2>
				<h3 class="section-subheading text-muted"><?php echo lg('Find us') ?></h3>
				<hr/>
            </div>
            <div class="clearfix form-group-margin" style="margin-top: 50px"></div>
            <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                <!-- Contact Form - Enter your email address on line 19 of the mail/contact_me.php file to make this form work. -->
                <!-- WARNING: Some web hosts do not allow emails to be sent through forms to common mail hosts like Gmail or Yahoo. It's recommended that you use a private domain email address! -->
                <!-- NOTE: To use the contact form, your site must be on a live web host with PHP! The form will not work locally! -->
				<div class="text-center">
					<i class="fa fa-2x fa-map-marker"></i>
					<p><?php echo $op->site_office_address ?><br/><a href="https://www.google.co.id/maps/place/<?php echo $op->site_coordinate ?>" target="_blank"><?php echo $op->site_coordinate ?></a></p>
					<img src="https://maps.googleapis.com/maps/api/staticmap?zoom=15&size=800x400&markers=<?php echo $op->site_coordinate ?>" class="img-responsive img-rounded" style="width: 100%">
				</div>
            </div>
        </div>
		<!-- .row -->
    </div>
<?php
  include "footer.php";
?>
