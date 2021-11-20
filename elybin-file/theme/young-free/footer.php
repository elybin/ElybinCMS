<?php
/**
 * The template for displaying footer.
 *
 * @package Elybin
 * @subpackage YoungFree
 * @since YoungFree 2.0
 */
if ( is_active_sidebar( 'sidebar-3'  ) ) : ?>
		<!-- Widget Bottom (Pos 3) -->
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12">
				<?php dynamic_sidebar( 'sidebar-3' ); ?>
			</div>
		</div>
	<?php endif; ?>

	<!-- Footer -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-2 col-sm-12">
					<h4><i class="fa fa-home"></i>&nbsp;<?php _e('Site Links') ?></h4>
					<?php get_subnav(); ?>
				</div>
				<div class="clearfix visible-sm visible-xs form-group-margin" style="margin-top: 20px;"></div><!-- margin -->
				<div class="col-md-4 visible-md visible-lg">
					<h4><i class="fa fa-pencil"></i>&nbsp;<?php _e('Recent Post') ?></h4>
					<?php get_recent_post() ?>
				</div>
				<div class="col-md-3 visible-md visible-lg">
					<h4><i class="fa fa-comment"></i>&nbsp;<?php _e('Last Comments') ?></h4>
					<?php get_recent_comment() ?>
				</div>
				<div class="col-md-3 col-sm-12">
					<h4><?php bloginfo('name'); ?></h4>
					<div class="small">
						<?php get_site_information(array("site_description"), false); ?>
						<?php get_site_information(array("site_office_address","site_phone","site_email"), true, true); ?>
						<?php get_social_media() ?>
					</div>
				</div>
			</div>
		</div>

		<div class="clearfix form-group-margin" style="margin-top: 20px;"></div><!-- margin -->
	    <div class="row bg-dark">
				<div class="container">
	      	<div class="col-sm-12 visible-sm visible-xs text-center">
						<p class="copyright">
	            <a href="<?php home_url('/') ?>"><?php bloginfo('name'); ?></a> - <a href="<?php e(get_url('sitemap-xml')) ?>"><?php _e('Sitemap'); ?></a> <br/>
							<?php appreciation_link() ?>
						</p>
	        </div>
	        <div class="col-md-6 visible-lg visible-md col-sm-12 pull-left text-left">
	        	<p class="copyright">
	          	<a href="<?php home_url('/') ?>"><?php bloginfo('name'); ?></a> - <a href="<?php e(get_url('sitemap-xml')) ?>"><?php _e('Sitemap'); ?></a>
						</p>
	        </div>
					<div class="col-md-6 visible-lg visible-md pull-right text-right">
						<p class="copyright"><?php appreciation_link() ?></p>
					</div>
				</div>
			</div>
	</footer>
	<div class="gototop" id="gototop"><i class="fa fa-2x fa-angle-up"></i></div>

	<script src="<?php echo get_template_directory() ?>/js/jquery.min.js"></script>
	<script src="<?php echo get_template_directory() ?>/js/bootstrap.min.js"></script>
	<script src="<?php echo get_template_directory() ?>/js/young-free.js"></script>
	<script src="<?php echo get_template_directory() ?>/js/jquery.ui.ease.js"></script>
	<?php el_footer(); ?>
</body>
</html>
