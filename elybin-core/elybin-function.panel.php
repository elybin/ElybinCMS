<?php
/**
 * Panel extended function
 *
 * @package Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @author Khakim <elybin.inc@gmail.com>
 * @since 1.1.4
 */

function add_panel_menu($arr = Array()){
  /**
   * add panel menu hook.
   * @since 1.1.4
   */
  global $hook_;
  // get slug
  $deb_bctr = dirname( debug_backtrace()[0]['file']	);
  preg_match('/(elybin-admin\/app\/)(.*)/', $deb_bctr, $m);
  $slug = @$m[2];
  // set to hook
  $hook_['panel_menu'][$slug] = $arr;
}
function get_panel_menu(){
  /**
   * Display additional script before html closing tag.
   * @since 1.1.4
   */
   // read data first
   include_plugin_meta();

   global $hook_;
   return $hook_['panel_menu'];
}
function include_plugin_meta(){
  /**
   * Checking plugin with their local files
   * @since 1.1.4
   */
  $tblpl = new ElybinTable('elybin_plugins');
  $lpl = $tblpl->SelectWhere('status', 1);
  $cpl = $tblpl->GetRow('status', 1);

  // if not empty
  if($cpl > 0){
    // check each plugin
    foreach ($lpl as $k => $v) {
      // check local directory
      if($cpl>0 && file_exists(root_uri().'elybin-admin/app/'.$v->alias.'/'.$v->alias.'.menu.php')){
        // include first
        include(	root_uri().'elybin-admin/app/'.$v->alias.'/'.$v->alias.'.menu.php'	);
      }
    }
  }
}
