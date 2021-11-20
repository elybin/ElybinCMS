<?php
/**
 * Main function of themes module.
 *
 * @package   Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @subpackage Elybin Apps: Settings
 * @author		Khakim <elybin.inc@gmail.com>
 * @since 		Elybin 1.1.4
 */

function get_available_plugin(){
  /**
   * Getting available plugin by reading /elybin-admin/app/ directory
   * @since 1.1.4
   */

  // debug
  $debug = false;

  // check directory existance
  if(file_exists(root_uri().'elybin-admin/app')){
    // check permission
    if(is_readable(root_uri().'elybin-admin/app/')){
      // read url plugin first
      $dir = scandir(root_uri().'elybin-admin/app/');
      // if not empty
      if(count($dir) > 0){
        for ($i=0; $i < count($dir); $i++) {
          if( preg_match("/[a-z]+/", $dir[$i]) && ($dir[$i] !== 'index.html')){
            ///slug
            $slug = $dir[$i];

            // check info exist or not
            if(file_exists(root_uri().'elybin-admin/app/'.$slug.'/'.$slug.'.php')){
              // try to get more info
              $o = null;
              // read
              $f = @fopen( root_uri().'elybin-admin/app/'.$slug.'/'.$slug.'.php'  , "r");
              while(!feof($f)) {
                $o .= fgets($f);
              }
              fclose($f);
              // remove header
              $extract_origin = preg_match('/\/\*(.*)\*\//s', $o, $match);
              $o = trim($match[1]);

              /* get information */
              // Plugin Name
              preg_match('/(Plugin Name:)(.*)\n/', $o, $m);
              $plugin_name = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
              // Version
              preg_match('/(Version:)(.*)\n/', $o, $m);
              $version = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
              // Author
              preg_match('/(Author:)(.*)\n/', $o, $m);
              $author = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );

              // only if has enough data
              if(!empty($plugin_name) && !empty($version) && !empty($author) ){
                /* getting info */
                // Plugin URI
                preg_match('/(Plugin URI:)(.*)\n/', $o, $m);
                $plugin_uri = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
                // Plugin Type
                preg_match('/(Plugin Type:)(.*)\n/', $o, $m);
                $plugin_type = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
                // Description
                preg_match('/(Description:)(.*)\n/', $o, $m);
                $description = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
                // Author URI
                preg_match('/(Author URI:)(.*)\n/', $o, $m);
                $author_uri = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
                // Text Domain:
                preg_match('/(Text Domain:)(.*)\n/', $o, $m);
                $text_domain = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
                // Domain Path:
                preg_match('/(Domain Path:)(.*)\n/', $o, $m);
                $domain_path = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
                // License:
                preg_match('/(License:)(.*)\n/', $o, $m);
                $license = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );

                // set info to output array
                $file_name[$i]['slug'] = $slug;
                $file_name[$i]['plugin_name'] = $plugin_name;
                $file_name[$i]['plugin_uri'] = $plugin_uri;
                $file_name[$i]['plugin_type'] = ( empty($plugin_type) ? 'plugin': $plugin_type );
                $file_name[$i]['description'] = strip_tags( $description, '<br><i><b>' );
                $file_name[$i]['version'] = $version;
                $file_name[$i]['author'] = $author;
                $file_name[$i]['author_uri'] = $author_uri;
                $file_name[$i]['text_domain'] = $text_domain;
                $file_name[$i]['domain_path'] = $domain_path;
                $file_name[$i]['license'] = $license;
                // installed ?
                $tb = new ElybinTable('elybin_plugins');
                if( $tb->GetRow('alias', $slug) > 0 ){
                  $file_name[$i]['installed'] = true;
                  // get status
                  if($tb->SelectWhere('alias', $slug)->current()->status){
                    $file_name[$i]['status'] = 1;
                  }else{
                    $file_name[$i]['status'] = 0;
                  }
                }else{
                  $file_name[$i]['installed'] = false;
                  $file_name[$i]['status'] = 0;
                }

              }

            }else{
              // failed to include url plugin
              // set error return
              $return = [
                "error" => [
                  "code"    => "failed_include_url_plugin",
                  "message" => __('Failed while including plugin file.')
                ]
              ];
            }

          }
        }
      }else{
        // url plugin not found
        // set error return
        $return = [
          "error" => [
            "code"    => "url_plugin_not_found",
            "message" => __('We cannot find any plugin files, maybe has removed.')
          ]
        ];
      }
    }else{
      // directory not readable
      // set error return
      $return = [
        "error" => [
          "code"    => "directory_not_readable",
          "message" => __('Unable to reading system directory, fix your directory permission and try again.')
        ]
      ];
    }
  }else{
    // directory not exist
    // set error return
    $return = [
      "error" => [
        "code"    => "directory_not_exist",
        "message" => __('System directory is missing.')
      ]
    ];
  }

  // return
  if(isset($return['error'])){
    return $return;
  }else{
    // success
    return [
      "ok"  => [
        "code"    => "information_received",
        "message" => __('Plugin information received.')
        ],
      "data"=> @$file_name
      ];
  }
}
function get_plugin_info($slug = null){
  /**
   * Getting plugin info
   * @since 1.1.4
   */

  // debug
  $debug = false;

  // slug not null
  if( !empty($slug) ){
    // check directory existance
    if(file_exists(root_uri().'elybin-admin/app/'.$slug)){
      // check permission
      if(is_readable(root_uri().'elybin-admin/app/'.$slug)){
        // read
        // try to get more info
        $o = null;
        // read
        $f = @fopen( root_uri().'elybin-admin/app/'.$slug.'/'.$slug.'.php'  , "r");
        while(!feof($f)) {
          $o .= fgets($f);
        }
        fclose($f);
        // remove header
        $extract_origin = preg_match('/\/\*(.*)\*\//s', $o, $match);
        $o = trim($match[1]);

        /* get information */
        // Plugin Name
        preg_match('/(Plugin Name:)(.*)\n/', $o, $m);
        $plugin_name = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
        // Version
        preg_match('/(Version:)(.*)\n/', $o, $m);
        $version = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
        // Author
        preg_match('/(Author:)(.*)\n/', $o, $m);
        $author = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );

        // only if has enough data
        if(!empty($plugin_name) && !empty($version) && !empty($author) ){
          /* getting info */
          // Plugin URI
          preg_match('/(Plugin URI:)(.*)\n/', $o, $m);
          $plugin_uri = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
          // Plugin Type
          preg_match('/(Plugin Type:)(.*)\n/', $o, $m);
          $plugin_type = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
          // Description
          preg_match('/(Description:)(.*)\n/', $o, $m);
          $description = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
          // Author URI
          preg_match('/(Author URI:)(.*)\n/', $o, $m);
          $author_uri = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
          // Text Domain:
          preg_match('/(Text Domain:)(.*)\n/', $o, $m);
          $text_domain = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
          // Domain Path:
          preg_match('/(Domain Path:)(.*)\n/', $o, $m);
          $domain_path = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );
          // License:
          preg_match('/(License:)(.*)\n/', $o, $m);
          $license = ( trim(  @$m[2] ) == null ? '': trim(  $m[2] ) );

          // set info to output array
          $file_name[0]['slug'] = $slug;
          $file_name[0]['plugin_name'] = $plugin_name;
          $file_name[0]['plugin_uri'] = $plugin_uri;
          $file_name[0]['plugin_type'] = ( empty($plugin_type) ? 'plugin': $plugin_type );
          $file_name[0]['description'] = strip_tags( $description, '<br><i><b>' );
          $file_name[0]['version'] = $version;
          $file_name[0]['author'] = $author;
          $file_name[0]['author_uri'] = $author_uri;
          $file_name[0]['text_domain'] = $text_domain;
          $file_name[0]['domain_path'] = $domain_path;
          $file_name[0]['license'] = $license;
          // installed ?
          $tb = new ElybinTable('elybin_plugins');
          if( $tb->GetRow('alias', $slug) > 0 ){
            $file_name[0]['installed'] = true;
            // get status
            if($tb->SelectWhere('alias', $slug)->current()->status){
              $file_name[0]['status'] = 1;
            }else{
              $file_name[0]['status'] = 0;
            }
          }else{
            $file_name[0]['installed'] = false;
            $file_name[0]['status'] = 0;
          }

        }
      }
      else{
        // directory not readable
        // set error return
        $return = [
          "error" => [
            "code"    => "directory_not_readable",
            "message" => __('Unable to read plugin directory, fix your directory permission and try again.')
          ]
        ];
      }
    }else{
      // directory not exist
      // set error return
      $return = [
        "error" => [
          "code"    => "plugin_not_found",
          "message" => __('Plugin not found.')
        ]
      ];
    }
  }else{
    // slug empty
    // set error return
    $return = [
      "error" => [
        "code"    => "missing_slug_parameters",
        "message" => __('Missing slug parameter.')
      ]
    ];
  }

  // return
  if(isset($return['error'])){
    return $return;
  }else{
    // success
    return [
      "ok"  => [
        "code"    => "information_received",
        "message" => __('Plugin information received.')
        ],
      "data"=> $file_name
      ];
  }
}

function get_readable_status($instaled = -1, $status = -1){
  /**
   * Getting human readable status from binary
   * @since 1.1.4
   */

  if($status == -1){
    return __('Status parameter (2) empty');
  }
  else if($status == -1 && $instaled == -1){
    return __('Parameter (1 & 2) empty');
  }
  else{
    // installed
    if($instaled && $status){
      return __('Enabled');
    }
    else if($instaled){
      return __('Disabled');
    }
    else{
      return __('Not Installed');
    }
  }
}
