<?php
/**
 * The template for displaying Comments.
 * The area of the page that contains comments and the comment form.
 *
 * @package Elybin
 * @subpackage YoungFree
 * @since YoungFree 2.0
 */

if (post_password_required()){
  return;
}  ?>
<div id="comments">
  <?php  if(have_comments()) : ?>
  <div class="row">
    <div class="col-md-offset-2 col-md-10">
      <h3><?php echo strtoupper(lg('Comments')) ?></h3>
      <?php
        printf( _n( 'One thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', get_comments_number() ),
          number_format_i18n( get_comments_number() ), get_the_title() );
      ?>
      <hr/>

      <ol class="comment-list">
        <?php
          el_list_comments( array(
            'style'       => 'ul',
            'avatar_size' => 56,
          ) );
        ?>
      </ol><!-- .comment-list -->
    </div>
  </div>
  <?php endif; // have_comments() ?>

  <?php
    // If comments are closed.
    if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type()) ) :
  ?>
    <p class="no-comments"><?php _e( 'Comments are closed.'); ?></p>
  <?php endif; ?>

  <div class="row">
    <div class="col-md-offset-2 col-md-10">
       <?php get_message(); ?>

	     <?php comment_form(); ?>
    </div>
  </div>
</div>
