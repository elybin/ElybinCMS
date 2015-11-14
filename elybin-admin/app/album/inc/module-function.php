<?php
/**
 * Function library.
 *
 * @package   Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @author		Khakim A <kim@elybin.com>
 */
function seo_input($inp){
  /**
   * Filtering input.
   */
  return sqli_($inp);
}
function check_seotitle($str, $id){
  /**
  * Checking seo tags.
  * 1 = available, 0 = not available
  */
  $str = sqli_($str);
  $id = sqli_($id);

  // if id gone
  if(empty($id)){
    echo json_encode("missing id");
    exit;
  }

  $tb = new ElybinTable("");
  $co = $tb->GetRowFullCustom("
  SELECT
  *
  FROM
  `elybin_posts` as `p`
  WHERE
  `p`.`seotitle` = '$str' &&
  `p`.`post_id` != $id &&
  `p`.`type` = 'album' &&
  `p`.`status` != 'inherit'
  ");
  // if str contain forbiden words
  $forb_w = array(
    "index","page","category","tag","author",
    "feed","atom","login","logout","profile",
    "setting","search","register","forgot",
    "gallery","404","403","501","maintenance",
    "blocked","sitemap","comment","api",
    "article","error","home",
    "elybin-admin","m","en","validation"
  );
  $min_c = 5;
  foreach ($forb_w as $f) {
    if($str == $f){ return false; exit; }
  }
  // and shorter than... and is integer
  if(strlen($str) < $min_c && is_numeric($str)){
    return false; exit;
  }
  if(strlen($str) < 1){
    return false; exit;
  }

  // result
  if($co < 1){
    return true;
  }else{
    return false;
  }
}

// loop until die!! eh, no no, loop until seo available
function suggest_unique($str, $id){
  $str = sqli_($str);
  $id = sqli_($id);
  // if false get suggestion
  $app = 2;
  while (!check_seotitle($str, $id)) {
    // check last char
    while(preg_match("/^([a-z0-9-])+(\-[0-9]+)$/", $str)){
      // delete last char
      $str = substr($str, 0, strlen($str)-1);
    }
    $str = rtrim($str, '-');
    $str .= "-$app";
    $app++;
  }
  // return suggestion
  return $str;
}
