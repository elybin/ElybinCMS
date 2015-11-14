<?php
/**
 * The default template for displaying page.
 *
 * @package Elybin CMS
 * @subpackage YoungFree
 * @since YoungFree 2.0
 */
?>
<!-- page -->
<div class="col-md-12">
  <div class="post-preview">
    <?php youngfree_thumbnail() ?>
    <p class="post-subtitle">
      <?php the_content() ?>
    </p>
  </div>
</div><!-- ./page -->
