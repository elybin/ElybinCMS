<?php
/**
 * The template for displaying pages.
 *
 * @package Elybin
 * @subpackage YoungFree
 * @since YoungFree 1.1
 */

get_header(); ?>
<!-- Main Content -->
<div class="container" style="margin-top:90px">
  <div class="row">
    <div class="col-md-12">
      <?php
        // Start the loop.
        while( have_posts() ) :  the_post();

          // Include the page content template.
          get_template_part('content', 'page');

        // End the loop.
        endwhile;
     ?>
    </div><!-- .col-md-9 / ./post-container-->
  </div><!-- ./row -->
</div><!-- ./container -->
<?php get_footer();
