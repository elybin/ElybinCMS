<?php
/**
 * The template for displaying photo.
 *
 * @package Elybin
 * @subpackage YoungFree
 * @since YoungFree 1.1
 */
get_header(); ?>
<!-- Main Content -->
<div class="container gallery" style="margin-top:45px">
  <div class="row">
    <div class="col-md-12">
      <div class="album-open">
        <a href="<?php prev_url() ?>" class="btn btn-default">&lt; <?php _e('Back') ?></a>
      </div>
      <div class="row gallery">
      <?php
      if( have_posts() ):
        while( have_posts() ) :  the_post();
          /*
    			* Include the Post-Format-specific template for the content.
    			*/
          ?>
          <div class="single-photo">
            <div class="col-md-8 col-sm-12">
              <a href="<?php echo get_permalink(); ?>">
                <?php the_thumbnail(); ?>
              </a>
            </div>
            <div class="col-md-4 col-sm-12">
              <div class="photo-caption">
                <?php the_title( '<h4>', '</h4>'); ?>
                <p class="text-justify"><?php the_description() ?></p>
                <p class="text-muted"><?php get_date(); ?></p>
              </div>
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
<?php get_footer();
