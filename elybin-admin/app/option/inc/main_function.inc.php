<?php
/**
 * Main function of option module.
 *
 * @package   Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @subpackage Elybin Apps: Settings
 * @author		Khakim A <kim@elybin.com>
 * @since 		Elybin 1.1.4
 */

// require first
include_once('../elybin-core/elybin-function.php');
include_once('../elybin-core/elybin-oop.php');

function get_permalink_style(){
  /**
   * Getting available permalink style by reading /elybin-core/url/ directory
   * @since 1.1.4
   */

  // debug
  $debug = false;

  // check directory existance
  if(file_exists(root_uri().'elybin-core/url')){
    // check permission
    if(is_readable(root_uri().'elybin-core/url/')){
      // read url template first
      $dir = scandir(root_uri().'elybin-core/url/');
      // if not empty
      if(count($dir) > 0){
        for ($i=0; $i < count($dir); $i++) {
          if(substr($dir[$i], -4) == ".php"){
            $file_name[$i]['filename'] = $dir[$i];
            // try to include file to get more info
            if(include(root_uri().'elybin-core/url/'.$dir[$i])){
              // check info exist or not
              if(!empty($info)){
                // set info to output array
                $file_name[$i]['style_id'] = $info['style_id'];
                $file_name[$i]['style_name'] = $info['style_name'];
                $file_name[$i]['style_author'] = $info['style_author'];
                $file_name[$i]['style_version'] = $info['style_version'];
                $file_name[$i]['htaccess'] = $info['htaccess'];
                $file_name[$i]['htaccess_name'] = $info['htaccess_name'];
                // active
                if($info['style_id'] == get_option('url_rewrite_style')){
                  $file_name[$i]['active'] = true;
                }else{
                  $file_name[$i]['active'] = false;
                }
                // check htaccess existance
                if(!file_exists(root_uri().'.htaccess') && $file_name[$i]['active'] && $file_name[$i]['htaccess']){
                  // try to read htaccess first
                  $url_template = null;
                  $f = fopen(root_uri()."elybin-core/url/htaccess/{$info['style_id']}.php", "r");
                  while(!feof($f)) {
                    $url_template .= fgets($f);
                  }
                  fclose($f);

                  // remove header
                  $extract_origin = preg_match('/\/\*\*\*(.*)/s', $url_template, $match);
                  $url_template = $match[1];
                  // push
                  $file_name[$i]['htaccess_template'] = $url_template;
                  // error result
                  result(array(
                    'status' => 'danger',
                    'title' => __('Error'),
                    'msg' => __('Permission denied, cannot write .htaccess. Fix yout directory permission and try again or write manually.'),
                    'msg_ses' => 'permission_denied',
                    'msg_icon' => 'fa fa-ban'
                  ), @$_GET['r']);
                }
              }else{
                // directory not readable
                // set error return
                $return = [
                  "error" => [
                    "code"    => "url_template_info_error",
                    "message" => __('Failed while getting information variable of URL template, template corrupt.')
                  ]
                ];
              }
              // check $url exist or not
              if(!empty($url)){
                // preview key list
                $pkl = ['post','page','archive','album','404'];
                // loop it
                for ($j=0; $j < count($url); $j++) {
                  // loop the key list
                  for ($k=0; $k < count($pkl); $k++) {
                    // find in array
                    if($url[$j]['section'] == $pkl[$k] && !empty($url[$j]['preview'])){
                      // set preview url to output array
                      $file_name[$i]['preview_'.$pkl[$k]] = $url[$j]['preview'];
                    }
                  }
                }
              }else{
                // directory not readable
                // set error return
                $return = [
                  "error" => [
                    "code"    => "url_template_error",
                    "message" => __('Failed while matching url variable, URL template corrupt.')
                  ]
                ];
              }
            }else{
              // failed to include url template
              // set error return
              $return = [
                "error" => [
                  "code"    => "failed_include_url_template",
                  "message" => __('Failed while including URL template file.')
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
            "message" => __('We cannot find any URL template files, maybe has removed.')
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
