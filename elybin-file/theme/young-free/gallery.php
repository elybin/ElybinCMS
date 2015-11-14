<?php
/**
 * The template for displaying gallery.
 *
 * @package Elybin
 * @subpackage YoungFree
 * @since YoungFree 1.1
 */

get_header(); ?>
<!-- Main Content -->
<div class="container" style="margin-top:45px">
  <div class="row">
    <div class="col-md-12">

      <div class="row">
          <div class="col-lg-12 text-center">
              <br/>
              <h1 class="section-heading"><?php echo strtoupper(__('Gallery')); ?></h1>
              <hr>
         </div>
      </div>

      <div class="row gallery">
      <?php
      if( have_posts() ):
        while( have_posts() ) :  the_post();
          /*
    			* Include the Post-Format-specific template for the content.
    			*/
          ?>
          <div class="col-md-4 col-sm-12 album-item">
            <a href="<?php echo get_permalink(); ?>">
              <?php the_thumbnail(); ?>
            </a>
            <div class="album-caption">
              <?php the_title( '<h4>', '</h4>'); ?>
              <p class="text-muted">
                <i class="fa fa-clock-o"></i> <?php get_date(); ?> &nbsp;&nbsp;
                <i class="fa fa-picture-o"></i> <?php get_total_photos(); ?>
              </p>
              <a href="<?php echo get_permalink(); ?>" class="btn btn-primary"><?php _e('View this Album') ?></a>
            </div>
          </div>
          <?php
        endwhile;
      else:
        get_template_part('content', 'none');
      endif;
     ?>
      </div>
    </div><!-- .col-md-9 / ./post-container-->
  </div><!-- ./row -->
</div><!-- ./container -->
<?php
the_posts_pagination(array(
  'before'      => sprintf('<div class="pager"><h3 class="hidden-xs">%s</h3>',strtoupper(__('Page'))),
  'after'       => '</div>'
));

get_footer();
