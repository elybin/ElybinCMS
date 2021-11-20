<?php
/**
 * The template for displaying single post.
 *
 * @package Elybin
 * @subpackage YoungFree
 * @since YoungFree 1.1
 */
get_header(); ?>

<!-- Main Content -->
<div class="container" style="margin-top:90px">
  <div class="row">
    <div class="col-md-9" style="border-right: 1px solid #eee">
      <?php

      if( have_posts() ):
        while( have_posts() ) :  the_post();
          /*
  				 * Include the Post-Format-specific template for the content.
  				 */
          get_template_part('content', get_post_format());
          // If comments are open or we have at least one comment, load up the comment template.
          if ( comments_open() || get_comments_number() ) {
            comments_template();
          }
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
