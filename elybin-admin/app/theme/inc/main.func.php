<?php
/**
 * Main function of themes module.
 *
 * @package   Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @subpackage Elybin Apps: Settings
 * @author		Khakim <elybin.inc@gmail.com>
 * @since 		Elybin 1.1.4
 */

// require first
include_once('../elybin-core/elybin-function.php');
include_once('../elybin-core/elybin-oop.php');

function get_available_template(){
  /**
   * Getting available template by reading /elybin-file/theme/ directory
   * @since 1.1.4
   */

  // debug
  $debug = false;

  // check directory existance
  if(file_exists(root_uri().'elybin-file/theme')){
    // check permission
    if(is_readable(root_uri().'elybin-file/theme/')){
      // read url template first
      $dir = scandir(root_uri().'elybin-file/theme/');
      // if not empty
      if(count($dir) > 0){
        for ($i=0; $i < count($dir); $i++) {
          if( preg_match("/[a-z]+/", $dir[$i]) && ($dir[$i] !== 'index.html')){
            //$file_name[$i]['filename'] = $dir[$i];

            // try to include file to get more info
            if(include(root_uri().'elybin-file/theme/'.$dir[$i].'/function.php')){
              // check info exist or not
              if(!empty($info)){
                // set info to output array
                $file_name[$i]['theme_id'] = $dir[$i];
                $file_name[$i]['theme_name'] = $info['theme_name'];
                $file_name[$i]['theme_uri'] = $info['theme_uri'];
                $file_name[$i]['author'] = $info['author'];
                $file_name[$i]['author_uri'] = $info['author_uri'];
                $file_name[$i]['description'] = strip_tags( $info['description'] );
                $file_name[$i]['version'] = $info['version'];
                $file_name[$i]['tags'] = $info['tags'];
                $file_name[$i]['screenshoot'] = (file_exists(root_uri().'elybin-file/theme/'.$dir[$i].'/screenshot.jpg') ? get_url('home').'elybin-file/theme/'.$dir[$i].'/screenshot.jpg' : get_url('home').'elybin-file/system/no-preview-default.png');
                // active
                if($dir[$i] == get_option('template')){
                  $file_name[$i]['active'] = true;
                }else{
                  $file_name[$i]['active'] = false;
                }

              }else{
                // directory not readable
                // set error return
                $return = [
                  "error" => [
                    "code"    => "url_template_info_error",
                    "message" => __('Failed while getting information variable of template, template corrupt.')
                  ]
                ];
              }

            }else{
              // failed to include url template
              // set error return
              $return = [
                "error" => [
                  "code"    => "failed_include_url_template",
                  "message" => __('Failed while including template file.')
                ]
              ];
            }

          }
        }
      }else{
        // url template not found
        // set error return
        $return = [
          "error" => [
            "code"    => "url_template_not_found",
            "message" => __('We cannot find any template files, maybe has removed.')
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
        "message" => __('URL Template information received.')
        ],
      "data"=> $file_name
      ];
  }
}
