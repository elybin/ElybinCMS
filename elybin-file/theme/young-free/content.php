<?php
/**
 * The default template for displaying content.
 *
 * @package Elybin CMS
 * @subpackage YoungFree
 * @since YoungFree 2.0
 */
?>
<!-- post -->
<div class="col-md-2">
  <?php youngfree_time_circle() ?>
</div>
<div class="col-md-10">
  <div class="post-preview">
    <?php
    if ( is_single() ) :
      the_title( '<h1 class="post-title">', '</h1>');
    else:
      the_title( sprintf('<h1 class="post-title"><a href="%s">', get_permalink()), '</a></h1>');
    endif;
    ?>

    <p class="post-meta">
      <?php youngfree_entry_meta() ?>
    </p>
    <?php
      if(is_single() ) :

        the_content();
      else:
    ?>
    <?php youngfree_thumbnail() ?>
    <p class="post-subtitle">
      <?php the_excerpt(); ?>
    </p>
  <?php endif; ?>
    <?php
    the_tags(array(
        'before'    => '<p class="post-meta"><i class="fa fa-tag"></i>&nbsp;&nbsp;',
        'after'     => '</p>',
        'link_class' => 'label bg-light'
    ))
    ?>
    <?php youngfree_more_link() ?>
  </div>
</div><!-- ./post -->
