<?php
/**
 * Main Function
 *
 * @package Elybin
 * @subpackage RecentPopular
 * @since RecentPopular 1.2
 */
function get_popular_post(){
  /**
   * Get popular post.
   */

  // query
  $q = "
  SELECT
  `p`.`post_id`,
  `p`.`title`,
  `p`.`hits`,
  `p`.`image`,
  `u`.`fullname`
  FROM
  `elybin_posts` as `p`
  LEFT JOIN
  `elybin_users` as `u`
  ON `u`.`user_id` = `p`.`author`
  WHERE
  `p`.`status` = 'publish' &&
  `p`.`type` = 'post'
  ORDER BY
  `p`.`hits` DESC
  LIMIT 0,5
  ";

  $tb = new ElybinTable('elybin_posts');
  $cop = $tb->GetRowFullCustom($q);
  $cp = $tb->SelectFullCustom($q);

  // if 0
  if($cop > 0){
    for ($i=0; $i < $cop; $i++) {
      $posts[$i] = new stdClass();
      $posts[$i]->title = $cp->current()->title;
      $posts[$i]->hits = $cp->current()->hits;
      $posts[$i]->author = $cp->current()->fullname;
      $posts[$i]->url = get_url('post', $cp->current()->post_id);
      $posts[$i]->image = get_post_images($cp->current()->post_id);
      $cp->next();
    }
  }

  return @$posts;
}

function get_recent_post2(){
  /**
   * Get popular post.
   */

  // query
  $q = "
  SELECT
  `p`.`post_id`,
  `p`.`title`,
  `p`.`date`,
  `p`.`image`,
  `u`.`fullname`
  FROM
  `elybin_posts` as `p`
  LEFT JOIN
  `elybin_users` as `u`
  ON `u`.`user_id` = `p`.`author`
  WHERE
  `p`.`status` = 'publish' &&
  `p`.`type` = 'post'
  ORDER BY
  `p`.`post_id` DESC
  LIMIT 0,5
  ";

  $tb = new ElybinTable('elybin_posts');
  $cop = $tb->GetRowFullCustom($q);
  $cp = $tb->SelectFullCustom($q);

  // if 0
  if($cop > 0){
    for ($i=0; $i < $cop; $i++) {
      $posts[$i] = new stdClass();
      $posts[$i]->title = $cp->current()->title;
      $posts[$i]->date = $cp->current()->date;
      $posts[$i]->author = $cp->current()->fullname;
      $posts[$i]->url = get_url('post', $cp->current()->post_id);
      $posts[$i]->image = get_post_images($cp->current()->post_id);
      $cp->next();
    }
  }

  return $posts;
}
