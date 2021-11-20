<?php
/**
 * The template for displaying category.
 *
 * @package Elybin
 * @subpackage YoungFree
 * @since YoungFree 2.0
 */
get_header(); ?>
<div class="clearfix form-group-margin" style="margin-top: 90px;"></div><!-- margin -->

<!-- Main Content -->
<div class="container">
  <div class="row">
    <div class="col-md-9" style="border-right: 1px solid #eee">
      <?php if( have_posts() ): ?>
        <header class="archive-header">
          <h1 class="archive-title"><i><?php printf(__( 'Category Archives: %s'), single_cat_title()); ?></i></h1>
          <h4><?php printf(__( _n('%s post found.','%s posts found.',count_posts()) ), count_posts())?></h4>
          <hr/>
        </header><!-- .archive-header -->
      <?php
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

get_footer();
