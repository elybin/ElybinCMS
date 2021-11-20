<?php
/**
 * The template for displaying sidebar.
 *
 * @package Elybin
 * @subpackage YoungFree
 * @since YoungFree 2.0
 */
if ( is_active_sidebar( 'sidebar-1'  ) ) : ?>
  <!-- Sidebar -->
  <div class="col-xs-12  col-sm-12 col-md-3 pull-right">
    <!-- Widget Bottom (Pos 3) -->
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <?php dynamic_sidebar( 'sidebar-1' ); ?>
      </div>
    </div>
  </div>
  <!-- .Sidebar -->
  <hr/>
<?php endif;

if ( is_active_sidebar( 'sidebar-2'  ) ) : ?>
  <!-- Sidebar -->
  <div class="col-xs-12  col-sm-12 col-md-3 pull-right">
    <!-- Widget Bottom (Pos 3) -->
    <div class="row">
      <div class="col-xs-12 col-sm-12 col-md-12">
        <?php dynamic_sidebar( 'sidebar-2' ); ?>
      </div>
    </div>
  </div>
  <!-- .Sidebar -->
  <hr/>
<?php endif; ?>
