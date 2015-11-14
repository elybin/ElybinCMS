<?php
/**
 * The template for displaying homepage.
 *
 * @package Elybin
 * @subpackage YoungFree
 * @since YoungFree 2.0
 */
get_header();
if( is_home() && !is_paged()): ?>
<!-- Page Header -->
<header class="intro-header" style="background-image: url('<?php header_image() ?>')">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
        <div class="site-heading">
          <h1 class="heading"><?php bloginfo('heading'); ?></h1>
          <?php
          /** show only if subheading set */
          if(get_option('site_hero_subtitle') !== ''): ?>
			    <hr class="text-dashed" style="border: none; border-bottom: 1px dashed #fff;margin:0px; margin-top: -10px;">
          <span class="subheading"><?php bloginfo('subheading'); ?></span>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</header>
<?php else : ?>
<div class="clearfix form-group-margin" style="margin-top: 90px;"></div><!-- margin -->
<?php endif; ?>

<!-- Main Content -->
<div class="container">
  <div class="row">
    <div class="col-md-9" style="border-right: 1px solid #eee">
      <?php
      if( have_posts() ):
        while( have_posts() ) :  the_post();
          /*
  				 * Include the Post-Format-specific template for the content.
  				 */
          get_template_part('content', get_post_format());
        endwhile;
      else:
        get_template_part('content', 'none');
      endif;
     ?>
    </div><!-- .col-md-9 / ./post-container-->
    <div class="hidden-xs">
      <?php get_sidebar( 'content' ); ?>
    </div>
  </div><!-- ./row -->
</div><!-- ./container -->

<hr class="hidden-xs">
<!-- Pager -->
<?php
the_posts_pagination(array(
  'before'      => sprintf('<div class="pager"><h3 class="hidden-xs">%s</h3>',strtoupper(__('Page'))),
  'after'       => '</div>'
));

// Hook
function add_this_to_hook(){
?>
<!-- additional javascript to include -->
<?php
}
add_action('el_footer','add_this_to_hook');
get_footer();
