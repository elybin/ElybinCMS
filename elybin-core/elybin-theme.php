<?php
/**
 * Contains many themes function.
 * Some function are inspired and named like WordPress own, so WP developer can easy to create
 * awesome themes with many documentation, just google it.
 *
 * @package   Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @author		Khakim A <kim@elybin.com>
 */
function whats_opened($section = ''){
  /**
   * Function to detect opened pages.
   *
   * without param  => whats_opened() => result: string
   * with param     => whats_opened('home') => result: true/false
   *
   * @param string $section = part of page (optional)
   * @since 1.1.4
   */
  // Main
  if(count($_GET) == 0 || (count($_GET) == 1 && isset($_GET['paged']))){
    // home
    $open = 'home';
  }
  else if(isset($_GET['p']) || isset($_GET['pt'])){
    // rss
    if(isset($_GET['feed']) && $_GET['feed'] == 'rss'){
      // post-rss
      $open = 'post-rss';
    }
    else if(isset($_GET['feed']) && $_GET['feed'] == 'atom'){
      // post-atom
      $open = 'post-atom';
    }
    else{
      // single post
      $open = 'post';
    }
  }
  else if(isset($_GET['page_id']) || isset($_GET['page_t'])){
    // page
    $open = 'page';
  }
  else if(isset($_GET['tag'])){
    // tag
    $open = 'tag';
  }
  else if(isset($_GET['cat']) || isset($_GET['cat_t'])){
    // category
    $open = 'category';
  }
  else if(isset($_GET['m'])){
    // archive
    $open = 'archive';
  }
  else if(isset($_GET['s'])){
    // search
    $open = 'search';
  }
  else if(isset($_GET['author'])){
    // author
    $open = 'author';
  }
  else if(isset($_GET['media'])){
    // media
    $open = 'media';
  }
  else if(isset($_GET['album']) || isset($_GET['album_t'])){
    // album
    if( @$_GET['album'] > 0 || !empty($_GET['album_t']) ){
      $open = 'album-single';
    }else{
      $open = 'album';
    }
    if(isset($_GET['photo']) || isset($_GET['photo_t'])){
      // photo
      $open = 'photo';
    }
  }
  else if(isset($_GET['apps'])){
    // apps
    $open = 'apps';
  }
  else if(count($_GET) < 1){
    // home
    $open = 'home';
  }
  // Misc
  else if(isset($_GET['sitemap'])){
    // sitemap
    $open = 'sitemap';
  }
  else if(isset($_GET['sitemap-xml'])){
    // sitemap-xml
    $open = 'sitemap-xml';
  }
  else if(isset($_GET['feed']) && $_GET['feed'] == 'rss'){
    // feed/rss
    $open = 'rss';
  }
  else if(isset($_GET['feed']) && $_GET['feed'] == 'atom'){
    // atom
    $open = 'atom';
  }
  else if(isset($_GET['blocked'])){
    // blocked
    $open = 'blocked';
  }
  else if(isset($_GET['maintenance'])){
    // maintenance
    $open = 'maintenance';
  }
  // Error
  else if(isset($_GET['500'])){
    // 501
    $open = '500';
  }
  else if(isset($_GET['403'])){
    // 403
    $open = '403';
  }
  else if(isset($_GET['404'])){
    // 404
    $open = '404';
  }
  else{
    // 404
    $open = '404';
  }

  // if $section set
  if(empty($section)){
    return $open;
  }else{
    if($open == $section){
      return true;
    }else{
      return false;
    }
  }

}
function get_query(){
  /**
   * Assemble select query.
   * @since 1.1.4
   */
  // collect params
  $p        = sqli_(to_int(@$_GET['p']));
  $pt       = sqli_(@$_GET['pt']);
  $page_id  = sqli_(to_int(@$_GET['page_id']));
  $page_t   = sqli_(@$_GET['page_t']);
  $tag      = sqli_(@$_GET['tag']);
  $cat      = sqli_(to_int(@$_GET['cat']));
  $cat_t    = sqli_(@$_GET['cat_t']);
  $m        = sqli_(@$_GET['m']);
  $author   = sqli_(to_int(@$_GET['author']));
  $s        = searchf_(xss_(strip_tags(htmlentities(@$_GET['s'], ENT_QUOTES))));
  $album    = sqli_(to_int(@$_GET['album']));
  $album_t  = sqli_(@$_GET['album_t']);
  $photo    = sqli_(to_int(@$_GET['photo']));
  $photo_t  = sqli_(@$_GET['photo_t']);
  $download = sqli_(@$_GET['download']);

  if(whats_opened() == 'post'){
    // normal query
    $query = "
    SELECT
    `p`.`post_id`,
    `p`.`title`,
    `p`.`content`,
    `p`.`date`,
    `p`.`seotitle`,
    `p`.`image`,
    `p`.`hits`,
    `p`.`comment`,
    `p`.`type`,
    `c`.`name` as `category_name`,
    `u`.`user_id` as `author_id`,
    `u`.`fullname` as `author_name`,
    `u`.`avatar` as `author_avatar`,
    `p`.`tag` as `tag_id`
    FROM
    `elybin_posts` as `p`
    LEFT JOIN
    `elybin_users` as `u`
    ON `u`.`user_id` = `p`.`author`
    LEFT JOIN
    `elybin_category` as `c`
    ON `c`.`category_id` = `p`.`category_id`
    WHERE
    `p`.`type` = 'post' &&
    `p`.`status` = 'publish' &&
    %s
    ORDER BY
    `p`.`post_id` DESC
    ";

    // branch of hybrid mode
    if(!empty($pt)){
      $query = sprintf($query, "`p`.`seotitle` = '$pt'");
    }else{
      $query = sprintf($query, "`p`.`post_id` = $p");
    }

  }
  else if(whats_opened() == 'page'){
    // normal query
    $query = "
    SELECT
    `p`.`post_id`,
    `p`.`title`,
    `p`.`content`,
    `p`.`date`,
    `p`.`seotitle`,
    `p`.`image`,
    `p`.`hits`,
    `p`.`comment`,
    `p`.`type`,
    `c`.`name` as `category_name`,
    `u`.`user_id` as `author_id`,
    `u`.`fullname` as `author_name`,
    `u`.`avatar` as `author_avatar`,
    `p`.`tag` as `tag_id`
    FROM
    `elybin_posts` as `p`
    LEFT JOIN
    `elybin_users` as `u`
    ON `u`.`user_id` = `p`.`author`
    LEFT JOIN
    `elybin_category` as `c`
    ON `c`.`category_id` = `p`.`category_id`
    WHERE
    `p`.`type` = 'page' &&
    `p`.`status` = 'active' &&
    %s
    ORDER BY
    `p`.`post_id` DESC
    ";
    // branch of hybrid mode
    if(!empty($page_t)){
      $query = sprintf($query, "`p`.`seotitle` = '$page_t'");
    }else{
      $query = sprintf($query, "`p`.`post_id` = $page_id");
    }
  }
  else if(whats_opened() == 'search'){
    // normal query
    $query = "
    SELECT
    `p`.`post_id`,
    `p`.`title`,
    `p`.`content`,
    `p`.`date`,
    `p`.`seotitle`,
    `p`.`image`,
    `p`.`hits`,
    `p`.`comment`,
    `p`.`type`,
    `c`.`name` as `category_name`,
    `u`.`user_id` as `author_id`,
    `u`.`fullname` as `author_name`,
    `u`.`avatar` as `author_avatar`,
    `p`.`tag` as `tag_id`
    FROM
    `elybin_posts` as `p`
    LEFT JOIN
    `elybin_users` as `u`
    ON `u`.`user_id` = `p`.`author`
    LEFT JOIN
    `elybin_category` as `c`
    ON `c`.`category_id` = `p`.`category_id`
    WHERE
    `p`.`type` = 'post' &&
    `p`.`status` = 'publish' &&
    ((`p`.`title` LIKE '%$s%') || (`p`.`content` LIKE '%$s%'))
    ORDER BY
    `p`.`post_id` DESC
    ";
  }
  else if(whats_opened() == 'tag'){
    $tag_name = $tag;
    // normal query
    $query = "
    SELECT
    `p`.`post_id`,
    `p`.`title`,
    `p`.`content`,
    `p`.`date`,
    `p`.`seotitle`,
    `p`.`image`,
    `p`.`hits`,
    `p`.`comment`,
    `p`.`type`,
    `c`.`name` as `category_name`,
    `u`.`user_id` as `author_id`,
    `u`.`fullname` as `author_name`,
    `u`.`avatar` as `author_avatar`,
    `p`.`tag` as `tag_id`
    FROM
    `elybin_tag` as `t`
    LEFT JOIN
    `elybin_posts` as `p`
    ON `p`.`tag` LIKE CONCAT('%',`t`.`tag_id`,'%')
    LEFT JOIN
    `elybin_users` as `u`
    ON `u`.`user_id` = `p`.`author`
    LEFT JOIN
    `elybin_category` as `c`
    ON `c`.`category_id` = `p`.`category_id`
    WHERE
    `p`.`type` = 'post' &&
    `p`.`status` = 'publish' &&
    `p`.`tag` != '' &&
    `t`.`seotitle` = '$tag_name'
    ORDER BY
    `p`.`post_id` DESC
    ";
  }
  else if(whats_opened() == 'category'){
    // normal query
    $query = "
    SELECT
    `p`.`post_id`,
    `p`.`title`,
    `p`.`content`,
    `p`.`date`,
    `p`.`seotitle`,
    `p`.`image`,
    `p`.`hits`,
    `p`.`comment`,
    `p`.`type`,
    `c`.`name` as `category_name`,
    `u`.`user_id` as `author_id`,
    `u`.`fullname` as `author_name`,
    `u`.`avatar` as `author_avatar`,
    `p`.`tag` as `tag_id`
    FROM
    `elybin_category` as `c`
    LEFT JOIN
    `elybin_posts` as `p`
    ON `p`.`category_id` = `c`.`category_id`
    LEFT JOIN
    `elybin_users` as `u`
    ON `u`.`user_id` = `p`.`author`
    WHERE
    %s &&
    `p`.`type` = 'post' &&
    `p`.`status` = 'publish' &&
    `p`.`category_id` != ''
    ORDER BY
    `p`.`post_id` DESC
    ";
    // branch of hybrid mode
    if(!empty($cat_t)){
      $query = sprintf($query, "`c`.`seotitle` = '$cat_t'");
    }else{
      $query = sprintf($query, "`c`.`category_id` = $cat");
    }
  }
  else if(whats_opened() == 'archive'){
    // sanitize query
    $m = rtrim(substr($m,0,4).'-'.substr($m,4,2).'-'.substr($m,6,2), "-");
    // normal query
    $query = "
    SELECT
    `p`.`post_id`,
    `p`.`title`,
    `p`.`content`,
    `p`.`date`,
    `p`.`seotitle`,
    `p`.`image`,
    `p`.`hits`,
    `p`.`comment`,
    `p`.`type`,
    `c`.`name` as `category_name`,
    `u`.`user_id` as `author_id`,
    `u`.`fullname` as `author_name`,
    `u`.`avatar` as `author_avatar`,
    `p`.`tag` as `tag_id`
    FROM
    `elybin_posts` as `p`
    LEFT JOIN
    `elybin_users` as `u`
    ON `u`.`user_id` = `p`.`author`
    LEFT JOIN
    `elybin_category` as `c`
    ON `c`.`category_id` = `p`.`category_id`
    WHERE
    `p`.`type` = 'post' &&
    `p`.`status` = 'publish' &&
    `p`.`date` LIKE '%$m%'
    ORDER BY
    `p`.`post_id` DESC
    ";
  }
  else if(whats_opened() == 'author'){
    // normal query
    $query = "
    SELECT
    `p`.`post_id`,
    `p`.`title`,
    `p`.`content`,
    `p`.`date`,
    `p`.`seotitle`,
    `p`.`image`,
    `p`.`hits`,
    `p`.`comment`,
    `p`.`type`,
    `c`.`name` as `category_name`,
    `u`.`user_id` as `author_id`,
    `u`.`fullname` as `author_name`,
    `u`.`avatar` as `author_avatar`,
    `p`.`tag` as `tag_id`
    FROM
    `elybin_posts` as `p`
    LEFT JOIN
    `elybin_users` as `u`
    ON `u`.`user_id` = `p`.`author`
    LEFT JOIN
    `elybin_category` as `c`
    ON `c`.`category_id` = `p`.`category_id`
    WHERE
    `p`.`type` = 'post' &&
    `p`.`status` = 'publish' &&
    `p`.`author` = $author
    ORDER BY
    `p`.`post_id` DESC
    ";
  }
  else if(whats_opened() == 'album'){
    // normal query
    $query = "
    SELECT
    `p`.`post_id` as `album_id`,
    `p`.`title` as `album_name`,
    `p`.`content` as `album_description`,
    `p`.`date` as `album_created`,
    `p`.`date` as `date`,
    `r`.`second_id`,
    `m`.`filename` as `thumbnail`
    FROM
    `elybin_posts` as `p`
    LEFT JOIN
    `elybin_relation` as `r`
    ON `r`.`first_id` = `p`.`post_id` && `r`.`type` = 'album'
    LEFT JOIN
    `elybin_media` as `m`
    ON `m`.`media_id` = `r`.`second_id`
    WHERE
    `p`.`status` = 'active' &&
    `p`.`type` = 'album'
    GROUP BY `p`.`post_id`
    ORDER BY
    `p`.`post_id` DESC,
    `r`.`second_id` DESC
    ";
  }
  else if(whats_opened() == 'album-single'){
    // normal query
    $query = "
    SELECT
    `m`.`media_id` as `media_id`,
    `m`.`filename`,
    `m`.`title` as `title`,
    `m`.`description` as `description`,
    `m`.`date` as `date`,
    `m`.`date` as `uploaded`,
    `m`.`download` as `download`,
    `m`.`download` as `downloaded`,
    `p`.`post_id` as `album_id`,
    `p`.`title` as `album_name`,
    `p`.`seotitle` as `album_seotitle`,
    `p`.`content` as `album_description`,
    `p`.`date` as `album_created`
    FROM
    `elybin_posts` as `p`
    LEFT JOIN
    `elybin_relation` as `r`
    ON `r`.`first_id` = `p`.`post_id` && `r`.`type` = 'album'
    LEFT JOIN
    `elybin_media` as `m`
    ON `m`.`media_id` = `r`.`second_id`
    WHERE
    `p`.`status` = 'active' &&
    %s
    ORDER BY
    `p`.`post_id` DESC,
    `r`.`second_id` DESC
    ";
    // branch of hybrid mode
    if(!empty($album_t)){
      $query = sprintf($query, "`p`.`seotitle` = '$album_t'");
    }else{
      $query = sprintf($query, "`p`.`post_id` = $album");
    }
  }
  else if(whats_opened() == 'photo'){
    // normal query
    $query = "
    SELECT
    `m`.`media_id` as `photo_id`,
    `m`.`filename`,
    `m`.`filename` as `thumbnail`,
    `m`.`title` as `title`,
    `m`.`description` as `description`,
    `m`.`date` as `date`,
    `m`.`date` as `uploaded`,
    `m`.`download` as `download`,
    `m`.`download` as `downloaded`,
    `p`.`post_id` as `album_id`,
    `p`.`post_id` as `post_id`,
    `p`.`title` as `album_name`,
    `p`.`seotitle` as `album_seotitle`,
    `p`.`content` as `album_description`,
    `p`.`date` as `album_created`
    FROM
    `elybin_posts` as `p`,
    `elybin_media` as `m`,
    `elybin_relation` as `r`
    WHERE
    `p`.`status` = 'active' &&
    `r`.`first_id` = `p`.`post_id` &&
    `r`.`type` = 'album' &&
    `m`.`media_id` = `r`.`second_id` &&
    %s
    ORDER BY
    `p`.`post_id` DESC,
    `r`.`second_id` DESC
    ";
    // branch of hybrid mode
    if(!empty($album_t) && !empty($photo_t)){
      $query = sprintf($query, "`p`.`seotitle` = '$album_t' && `m`.`seotitle` = '$photo_t'");
    }else{
      $query = sprintf($query, "`p`.`post_id` = $album && `m`.`media_id` = $photo");
    }
  }
  else if(whats_opened() == 'home'){
    // normal query
    $query = "
    SELECT
    `p`.`post_id`,
    `p`.`title`,
    `p`.`content`,
    `p`.`date`,
    `p`.`seotitle`,
    `p`.`image`,
    `p`.`hits`,
    `p`.`comment`,
    `p`.`type`,
    `c`.`name` as `category_name`,
    `u`.`fullname` as `author_name`,
    `u`.`user_id` as `author_id`,
    `u`.`avatar` as `author_avatar`,
    `p`.`tag` as `tag_id`
    FROM
    `elybin_posts` as `p`
    LEFT JOIN
    `elybin_users` as `u`
    ON `u`.`user_id` = `p`.`author`
    LEFT JOIN
    `elybin_category` as `c`
    ON `c`.`category_id` = `p`.`category_id`
    WHERE
    `p`.`type` = 'post' &&
    `p`.`status` = 'publish'
    ORDER BY
    `p`.`post_id` DESC
    ";
  }else{
    $query = '';
  }
  return $query;
}
function pagination_query($query = ''){
  /**
   * Append pagination query. I created new function to easy track when it goes wrong.
   * @since 1.1.4
   */
  // if query empty break;
  if(empty($query)){
    return $query;
    exit;
  }
  // catch url var
  $paged = sqli_(@$_GET['paged']);

  // make branch
  if(whats_opened() == 'album'){
    $post_pp = get_option('album_per_page');
  }
  else if(whats_opened() == 'album-single'){
    $post_pp = get_option('photo_per_album');
  }
  else{
    $post_pp = get_option('posts_per_page');
  }
  // filter it
  $post_pp = to_int($post_pp);
  if($post_pp < 1){
    $post_pp = 1;
  }

  // paging
  if(empty($paged) || $paged < 0){
    $page = 1;
    $query .= "
    LIMIT
    0, $post_pp
    ";
  }else{
    $page = $paged;
    // much page
    $muchpage = ceil(count_posts()/$post_pp);

    // if out or range
    if($page > $muchpage){
      $page = 1;
    }

    $postposition = ($page-1)*$post_pp;
    $query .= "
    LIMIT
    $postposition, $post_pp
    ";
  }
  return $query;
}
function get_all_post($mode = 'post', $args = array()){

  /**
   * Getting all post with detailed information.
   * @since 1.1.4
   */
  // get global option
  $op = _op();
  $v = new ElybinValidasi();

  // new code 1.1.4-3
  // compose SQL query
  $query = get_query();

  // if query empty
  if(empty($query)){
    return false;
    exit;
  }

  // check query execution result
  if(count_posts($query) < 0){
    // stop when its not found
    return false;
    exit;
  }
  // pagination_query
  $query = pagination_query($query);
  // execute query
  $tbp = new ElybinTable('elybin_posts');
  $tbc = new ElybinTable('elybin_comments');
  $tbt = new ElybinTable('elybin_tag');
  $cpt = $tbp->SelectFullCustom($query);
  // convert to array
  $result[] = array();
  $i = 0;
  foreach ($cpt as $p) {
    // inject all data into single variable
    $result[$i] = $p;
    // make dicision between post/gallery
    if(whats_opened() == 'album'){
      // gallery
      $defaults = array(
        'gallery_id' => 'gallery',
        'gallery_class' => '',
        'album_id' => 'album-{number}',
        'album_class' => 'album',
        'album_show' => 9,
        'album_link' => __('Detail'),
        'album_thumbnail' => 1,
        'album_thumbnail_quality' => 'md',
        'photo_id' => 'photo-{number}',
        'photo_class' => '',
        'photo_link' => __('Detail'),
        'photo_thumbnail_quality' => 'md',
        'photo_per_album' => 50
      );
      $args = el_parse_args($args, $defaults);

      // album
      $result[$i]->no = str_replace('{number}', $i+1, $args['album_id']);
      $result[$i]->album_id = $p->album_id;
      $result[$i]->title = $p->album_name;
      $result[$i]->date = friendly_date($p->date,'full');
      // thumbnail
      if(!empty($p->thumbnail)){
        $result[$i]->thumbnail = get_option('site_url').'elybin-file/media/'.photo_quality($args['photo_thumbnail_quality']).$p->thumbnail;
      }else{
        $result[$i]->thumbnail = get_option('site_url').'elybin-file/system/no-preview-default.png';
      }
    }
    else if(whats_opened() == 'album-single'){
      // gallery
      $defaults = array(
        'gallery_id' => 'gallery',
        'gallery_class' => '',
        'album_id' => 'album-{number}',
        'album_class' => 'album',
        'album_show' => 9,
        'album_link' => __('Detail'),
        'album_thumbnail' => 1,
        'album_thumbnail_quality' => 'md',
        'photo_id' => 'photo-{number}',
        'photo_class' => '',
        'photo_link' => __('Detail'),
        'photo_thumbnail_quality' => 'md',
        'photo_per_album' => 50
      );
      $args = el_parse_args($args, $defaults);

      // album
      $result[$i]->album_id = $p->album_id;
      $result[$i]->album_name = $p->album_name;
      $result[$i]->album_created = friendly_date($p->album_created,'full');
      // thumbnail
      if(!empty($p->thumbnail)){
        $result[$i]->thumbnail = get_option('site_url').'elybin-file/media/'.photo_quality($args['photo_thumbnail_quality']).$p->thumbnail;
      }else{
        $result[$i]->thumbnail = get_option('site_url').'elybin-file/system/no-preview-default.png';
      }
      // new
      $result[$i]->no = str_replace('{number}', $i+1, $args['photo_id']);
      $result[$i]->photo_id = $p->media_id;
      $result[$i]->title = $p->title;
      $result[$i]->description = $p->description;
      $result[$i]->date = friendly_date($p->date,'full');
      $result[$i]->viewed = $p->download;
      // rewrite style
      // $result[$i]->detail_url = url_rewrite(array(
      //   'dynamic' => get_option('site_url').'?album='.$p->album_id.'&photo='.$p->media_id,
      //   'static1' => get_option('site_url').'photo-'.$p->album_id.'-'.$p->media_id.'-'.seo_title($p->title).'.html'
      // ));
      $result[$i]->detail_url = get_url('photo', $p->album_id, $p->media_id);
      // photo quality
      $result[$i]->thumbnail = get_option('site_url').'elybin-file/media/'.photo_quality($args['photo_thumbnail_quality']).$p->filename;
    }
    else if(whats_opened() == 'photo'){
      // gallery
      $defaults = array(
        'gallery_id' => 'gallery',
        'gallery_class' => '',
        'album_id' => 'album-{number}',
        'album_class' => 'album',
        'album_show' => 9,
        'album_link' => __('Detail'),
        'album_thumbnail' => 1,
        'album_thumbnail_quality' => 'md',
        'photo_id' => 'photo-{number}',
        'photo_class' => '',
        'photo_link' => __('Detail'),
        'photo_thumbnail_quality' => 'md',
        'photo_per_album' => 50
      );
      $args = el_parse_args($args, $defaults);

      // photo
      $result[$i]->album_id = $p->album_id;
      $result[$i]->photo_id = $p->photo_id;
      $result[$i]->date = friendly_date($p->date,'full');
      // thumbnail
      if(!empty($p->thumbnail)){
        $result[$i]->thumbnail = get_option('site_url').'elybin-file/media/'.photo_quality($args['photo_thumbnail_quality']).$p->filename;
      }else{
        $result[$i]->thumbnail = get_option('site_url').'elybin-file/system/no-preview-default.png';
      }
    }
    else{
      // grab another information
      // 1. tag
      $tag_ar[] = array();
      if(!empty($p->tag_id)){
        $ti2 = @json_decode($p->tag_id);
        for ($j=0; $j < count($ti2); $j++) {
          $top = new stdClass();
          // check first, tag exist or not
          if($tbt->GetRow('tag_id', $ti2[$j]) > 0){
            // and start
            $tt = $tbt->SelectWhere('tag_id', $ti2[$j])->current();
            // add
            $top->tag_id = $tt->tag_id;
            $top->tag_name = $tt->name;
            $top->tag_seo = $tt->seotitle;
            // rewrite style
            // $top->tag_url = url_rewrite(array(
            //   'dynamic' => _op()->site_url.'?tag='.$tt->seotitle
            // ));
            $top->tag_url = get_url('tag', $tt->tag_id);
            // push to array
            $tag_ar[$j] = $top;
          }
        }

        // delete unecesarry/empty tag (new)
        for ($k=0; $k < count($tag_ar); $k++) {
          if($tag_ar[$k] == '' || empty($tag_ar[$k])){
            unset($tag_ar[$k]);
          }
        }

        $result[$i]->tag = $tag_ar;
        $result[$i]->tag_count =  count($tag_ar);
      }else{
        $result[$i]->tag_count =  0;
      }
      // unset useless object
      unset($result[$i]->tag_id);

      /**
       * Replace specifict string to allowed global variable.
       * Status: beta
       * @since 1.1.3
       */
      // content (allowed to get global site variable) = beta
      if(get_option('global_option_replace') == 'active'){
        $content_rep = $p->content;
        $op_allowed_array = array(
          'site_url',
          'site_name',
          'site_description',
          'site_keyword',
          'site_phone',
          'site_office_address',
          'site_owner',
          'site_email',
          'site_coordinate',
          'social_twitter',
          'social_facebook',
          'social_instagram',
          'site_owner_story',
          'site_hero_title',
          'site_hero_subtitle'
        );
        $count_str_inside = substr_count($content_rep, '{{');
        for($k=0; $k < $count_str_inside; $k++){
          // start finding
          $global_string_a = strpos($content_rep, '{{') + 2;
          $global_string_b = strpos($content_rep, '}}');
          $global_string_long = $global_string_b-$global_string_a;
          $global_string_extract = substr($content_rep, $global_string_a, $global_string_long);
          $global_string_extract_strip = strip_tags($global_string_extract);
          // get global variable from database
          // check matched options
          $tbop = new ElybinTable("elybin_options");
          $coop = $tbop->GetRow('name', $global_string_extract_strip);
          if($coop > 0){
            // exception
            if(in_array($global_string_extract_strip, $op_allowed_array)){
              // replace string inside content
              $content_rep = str_replace('{{'.$global_string_extract.'}}',get_option($global_string_extract_strip), $content_rep);
            }else{
              $content_rep = str_replace('{{'.$global_string_extract.'}}','&#123;&#123; '.$global_string_extract.'&#125;&#125;', $content_rep);
            }
          }
        }
        // push to content
        $result[$i]->content = $content_rep;
      }


      // comment
      $result[$i]->comment_count = $tbc->GetRow('post_id',$p->post_id);
      // adding more information
      // summary
      $summary = cutword(strip_tags(html_entity_decode($p->content)),500);
      if(strlen($summary) >= 500) $summary=$summary."...";
      $result[$i]->summary = $summary;
      // keyword
      $result[$i]->meta_desc = cutword(strip_tags(html_entity_decode($p->content)),200);
      $result[$i]->meta_keywords = keyword_filter(strip_tags($p->title));
      // human date
      $human_date_a = explode(" ",$p->date);
      $human_date = friendly_date($human_date_a[0],'full');
      $human_date = $human_date.' '.lg('at').' '.substr($human_date_a[1],0,5);
      $result[$i]->human_date = $human_date;
      // elapsed time
      $result[$i]->elapsed_time = time_elapsed_string($p->date);
      // image
      if($p->image == ''){
        $result[$i]->image_or = '';
        $result[$i]->image_hd = '';
        $result[$i]->image_md = '';
        $result[$i]->image_sm = '';
        $result[$i]->image_xs = '';
        $result[$i]->image = false;
      }else{
        $result[$i]->image_or = get_option('site_url').'elybin-file/'.$p->type.'/'.$p->image;
        $result[$i]->image_hd = get_option('site_url').'elybin-file/'.$p->type.'/hd-'.$p->image;
        $result[$i]->image_md = get_option('site_url').'elybin-file/'.$p->type.'/md-'.$p->image;
        $result[$i]->image_sm = get_option('site_url').'elybin-file/'.$p->type.'/sm-'.$p->image;
        $result[$i]->image_xs = get_option('site_url').'elybin-file/'.$p->type.'/xs-'.$p->image;
        $result[$i]->image = true;
      }
    }

    // detail url
    if(whats_opened() == 'post' || whats_opened() == 'search' || whats_opened() == 'category' || whats_opened() == 'tag' || whats_opened() == 'home') {
      // post
      // $result[$i]->detail_url = url_rewrite(array(
      //   'dynamic' => get_option('site_url').'?p='.$p->post_id,
      //   'static1' => get_option('site_url').'article/'.$p->seotitle.'-'.$p->post_id.'/'
      // ));
      $result[$i]->detail_url = get_url('post', $p->post_id);
    }
    else if(whats_opened() == 'page') {
      // post
      // $result[$i]->detail_url = url_rewrite(array(
      //   'dynamic' => get_option('site_url').'?p='.$p->post_id,
      //   'static1' => get_option('site_url').$p->seotitle.'-'.$p->post_id.'/'
      // ));
      $result[$i]->detail_url = get_url('page', $p->post_id);
    }
    else if(whats_opened() == 'album') {
      // gallery
      // $result[$i]->detail_url = url_rewrite(array(
      //   'dynamic' => get_option('site_url').'?album='.$p->album_id,
      //   'static1' => get_option('site_url').'gallery/'.$p->album_id.'-'.seo_title($p->name).'.html'
      // ));
      $result[$i]->detail_url = get_url('album', $p->album_id);
    }
    else if(whats_opened() == 'album-single') {
    }
    else if(whats_opened() == 'photo') {
      $result[$i]->detail_url = get_url('photo', $p->post_id, $p->photo_id);
    }
    else{
      $result[$i]->detail_url = get_url('post', $p->post_id);
    }
    // ++
    $i++;
  }

  //var_dump($result);

  // if empty result
  if(empty($result[0])){
    return false;
    exit;
  }else{
    return $result;
  }
}
function count_posts($query = null){
  /**
   * Count number of row.
   * @since 1.1.4
   */
  // def
  if(empty($query)){
    $query = get_query();
  }
  // check query execution result
  $tbp = new ElybinTable('');
  $coq = $tbp->GetRowFullCustom($query);
  return $coq;
}
// The Loop
function have_posts(){
  /**
   * I don't know exactly what this is will called, but this is to convert showing post
   * with foreach (that I was made) to showing with While (simpler way).
   *
   * @since 1.1.4
   */
  global $in_the_loop;
  global $in_the_loop_count;
  global $current_post;

  if(!isset($in_the_loop_count)){
   $in_the_loop_count = 0;
  }

  if(get_all_post() == false){
    //get_template_part('content', 'none');
    return false;
  }else{
    if($in_the_loop_count + 1 > count(get_all_post())){
      return false;
    }else{
      $current_post = get_all_post()[$in_the_loop_count];
      return true;
    }
  }
}
function the_post(){
  /**
   * Control while loop.
   * @since 1.1.4
   */
  global $current_post;
  global $in_the_loop_count;

  $in_the_loop_count++;
  return $current_post;
}
function get_post(){
  /**
   * All post data.
   * @since 1.1.4
   */
  global $current_post;
  return $current_post;
}
function get_post_type(){
  /**
   * Get the post type.
   * @since 1.1.4
   */
  return 'post';
}
function the_title($before = '', $after = ''){
  /**
   * The title of post data.
   * @since 1.1.4
   */
  global $current_post;
  echo $before.$current_post->title.$after;
}
function the_excerpt(){
  /**
   * The summary of post data.
   * @since 1.1.4
   */
  global $current_post;
  echo $current_post->summary;
}
function the_content($more_link_text = null, $strip_teaser = false){
  /**
   * The content of post data.
   * @since 1.1.4
   */
  global $current_post;

  if(if_show_album()){
    if($more_link_text == ''){
      $more_link_text = array();
    }
    $defaults = array(
      'gallery_id' => 'gallery',
      'gallery_class' => '',
      'album_id' => 'album-{number}',
      'album_class' => 'album',
      'album_show' => 9,
      'album_link' => __('Detail'),
      'album_thumbnail' => 1,
      'album_thumbnail_quality' => 'md',
      'photo_id' => 'photo-{number}',
      'photo_class' => '',
      'photo_link' => __('Detail'),
      'photo_thumbnail_quality' => 'md',
      'photo_per_album' => 50
    );
    $args = el_parse_args($more_link_text, $defaults);

    // fill prefix
    if(!empty($args['gallery_id'])){
      $args['gallery_id'] = ' id="'.$args['gallery_id'].'"';
    }
    if(!empty($args['gallery_class'])){
      $args['gallery_class'] = ' class="'.$args['gallery_class'].'"';
    }
    if(!empty($args['album_id'])){
      $args['album_id'] = ' id="'.$args['album_id'].'"';
    }
    if(!empty($args['album_class'])){
      $args['album_class'] = ' class="'.$args['album_class'].'"';
    }
    if(!empty($args['photo_id'])){
      $args['photo_id'] = ' id="'.$args['photo_id'].'"';
    }
    if(!empty($args['photo_class'])){
      $args['photo_class'] = ' class="'.$args['photo_class'].'"';
    }

    if($current_post->photo != false){
      // show album
      foreach ($current_post->photo as $g) {
        echo '
        <div'.$args['gallery_id'].$args['gallery_class'].'>
          <div'.$g->no.$args['album_class'].'>
            <h3>'.$g->title.'<h3>
            <p>'.__('Created').': '.$g->date.'</p>
            <img src="'.$g->thumbnail.'" alt="'.__('Failed while loading images').'">
            <a href="'.$g->detail_url.'">'.$args['album_link'].'</a>
          </div>
        </div>
        ';
      }
    }else{
      return false;
    }
  }else{
    echo $current_post->content;
  }
}
function the_category($before = '', $after = ''){
  /**
   * The category of post data.
   * @since 1.1.4
   */
  global $current_post;
  echo $before.$current_post->category.$after;
}
function the_author(){
  /**
   * The author of post data.
   * @since 1.1.4
   */
  echo get_the_author();
}
function get_the_author(){
  /**
   * The author of post data.
   * @since 1.1.4
   */
  return get_post()->author_name;
}
function get_the_author_meta($part = 'ID'){
  /**
   * The author meta of post data.
   * @since 1.1.4
   */
  if($part == 'ID'){
    return get_post()->author_id;
  }
  else if($part == 'Name'){
    return get_post()->author_name;
  }
  else{
    return get_post()->author_id;
  }
}
function the_date(){
  /**
   * The date of post.
   * @since 1.1.4
   */
  global $current_post;
  echo $current_post->date;
}
function the_description(){
  /**
   * display description (photo).
   * @since 1.1.4
   */
  global $current_post;
  echo $current_post->description;
}
function the_tags($args = array()){
  /**
   * Get permalink.
   * @since 1.1.4
   */

  $available_args = array('before','after','link_class');
  foreach ($available_args as $k) {
    if(!isset($args[$k])){
      $args[$k] = '';
    }
  }
  if(!empty($args['link_class'])){
    $args['link_class'] = ' class="'.$args['link_class'].'"';
  }

  if(get_post()->tag_count > 0){
    echo $args['before'];
    foreach (get_post()->tag as $t) {
      echo '<a href="'.$t->tag_url.'"'.$args['link_class'].'>'.$t->tag_name.'</a> ';
    }
    echo $args['after'];
  }
}
function the_thumbnail($args = array()){
  /**
   * Get thumbnail.
   * @since 1.1.4
   */
  echo get_thumbnail($args);
}
function get_thumbnail($args = array()){
  /**
   * Get thumbnail.
   * @since 1.1.4
   */

  // defaults value
  $defaults = array(
    'before' => '',
    'after' => '',
    'img_before' => '',
    'img_after' => '',
    'img_class' => '',
    'img_id' => '',
    'quality' => 'md'
  );
  $args = el_parse_args($args, $defaults);

  if(!empty($args['img_class'])){
    $args['img_class'] = ' class="'.$args['img_class'].'"';
  }

  if(!empty($args['img_id'])){
    $args['img_id'] = ' id="'.$args['img_id'].'"';
  }

  // check image existance
  if(  get_post()->thumbnail == null){
    $show = false;
  }
  else{
    $show = true;
  }

  // if show
  if( $show ){
    return '<img src="'.get_post()->thumbnail.'" alt="'.__('Failed while loading images  ').'" '.$args['img_id'].$args['img_class'].'>';
  }
}
function get_date($format = 'd F Y'){
  /**
   * The date of post.
   * @since 1.1.4
   */
  echo get_the_date($format);
}
function get_total_photos($single = '', $plural = ''){
  /**
   * The date of post.
   * @since 1.1.4
   */
  global $current_post;

  if(empty($single)){
    $single = __('Photo');
  }
  if(empty($plural)){
    $plural = __('Photos');
  }
  if(!empty($current_post->album_id)){
    //count
    $tb = new ElybinTable('elybin_relation');
    $tot = $tb->GetRowAnd('type','album','first_id',$current_post->album_id);
    echo $tot.' '._n($single, $plural, $tot);
  }else{
    echo false;
  }
}
function get_the_title($before = '', $after = ''){
  /**
   * the_title alias. (but using return method)
   * @since 1.1.4
   */
  global $current_post;
  return $before.$current_post->title.$after;
}
function get_permalink(){
  /**
   * Get permalink.
   * @since 1.1.4
   */
  global $current_post;
  return $current_post->detail_url;
}
function get_search_query(){
  /**
   * Showing search query.
   * @since 1.1.4
   */
  if(whats_opened() == 'search'){
    $s = searchf_(xss_(strip_tags(@$_GET['s'])));
    return $s;
  }
}
function is_single(){
  /**
   * Chceck the post is on list or single opened.
   * @since 1.1.4
   */
  // check id status available?
  if(isset($_GET['p']) || isset($_GET['pt']) || isset($_GET['photo']) ){
    return true;
  }else{
    return false;
  }
}
function is_home(){
  /**
   * Check home page or not.
   * @since 1.1.4
   */
  if(count($_GET) < 1){
    return true;
  }else{
    return false;
  }
}
function is_paged(){
  /**
   * Check paged or not.
   * @since 1.1.4
   */
  if(isset($_GET['paged'])){
    return true;
  }else{
    return false;
  }
}
function is_day(){
  /**
   * Check current parameter are daily archives.
   * @since 1.1.4
   */
  if(isset($_GET['m']) && strlen($_GET['m']) == 8){
    return true;
  }else{
    return false;
  }
}
function is_month(){
  /**
   * Check current parameter are monthly archives.
   * @since 1.1.4
   */
  if(isset($_GET['m']) && strlen($_GET['m']) == 6){
    return true;
  }else{
    return false;
  }
}
function is_year(){
  /**
   * Check current parameter are yearly archives.
   * @since 1.1.4
   */
  if(isset($_GET['m']) && strlen($_GET['m']) == 4){
    return true;
  }else{
    return false;
  }
}
function get_the_date($format = 'd F Y'){
  /**
   * The date of post.
   * @since 1.1.4
   */
  return date($format, strtotime(get_post()->date));
}
function get_post_format(){
  /**
   * Determine post type.
   * @since 1.1.4
   */

  $format = get_post_type();
  if($format == 'post'){
    return false;
  }else{
    return $format;
  }
}
function the_posts_pagination($args = array()){
  /**
   * Return a paginated navigation to next/previous set of posts,
   * when applicable.
   * @since 1.1.4
   */
  // defaults value
  $defaults = array(
    'before' => '',
    'after' => '',
    'link_before' => '',
    'link_after' => '',
    'link_class' => '',
    'pagelink' => '',
    'separator' => ''
  );
  $args = el_parse_args($args, $defaults);

  // make branch
  if(whats_opened() == 'album'){
    $post_pp = get_option('album_per_page');
  }
  else if(whats_opened() == 'album-single'){
    $post_pp = get_option('photo_per_album');
  }
  else{
    $post_pp = get_option('posts_per_page');
  }
  // filter it
  $post_pp = to_int($post_pp);
  if($post_pp < 1){
    $post_pp = 1;
  }

  if(count_posts() > 0){
    // calcuate muchpage
    $muchpage = ceil(count_posts()/$post_pp);

    // if $get not empty
    if(empty($_GET['paged']) || $_GET['paged'] < 0){
      $page = 1;
    }else{
      $page = @$_GET['paged'];
    }
    // if out or range
    if($page > $muchpage){
      $page = 1;
    }

    // collect url parameter
    if(whats_opened() == 'search'){
      $s = @$_GET['s'];
      $template_paged = get_url_paged('search', $s);
    }
    else if(whats_opened() == 'tag'){
      $tag = @$_GET['tag'];
      $template_paged = get_url_paged('tag', $tag);
    }
    else if(whats_opened() == 'post'){
      $p = so(@$_GET['p'], @$_GET['pt']);
      $template_paged = get_url_paged('post', $p);
    }
    else if(whats_opened() == 'category'){
      $cat = so(@$_GET['cat'], @$_GET['cat_t']);
      $template_paged = get_url_paged('category', $cat);
    }
    else if(whats_opened() == 'author'){
      $author = @$_GET['author'];
      $template_paged = get_url_paged('author', $author);
    }
    else if(whats_opened() == 'album'){
      $album = @$_GET['album'];
      $template_paged = get_url_paged('gallery', $album);
    }
    else if(whats_opened() == 'album-single'){
      $album = so(@$_GET['album'], @$_GET['album_t']);
      $template_paged = get_url_paged('album', $album);
    }
    else if(whats_opened() == 'home'){
      $template_paged = get_url_paged('home');
    }
    else{
      $template_paged = null;
    }

    // declare
    $o_pagg = $args['before'];
    $o_pagg .= '<ul>';
    // part per mod

    if($page > 1){
      // $o_pagg .= url_rewrite(array(
      //   'dynamic' => '<li><a href="'.$dynamic_url.'paged='.($page-1).'" alt="'.lg('Prev').'"><i class="fa fa-angle-left"></i></a></li>'
      // ));
      $o_pagg .= '<li>'.$args['link_before'].'<a href="'.str_replace('%paged%', ($page-1), $template_paged).'" alt="'.lg('Prev').'" class="'.$args['link_class'].'"><i class="fa fa-angle-left"></i></a>'.$args['link_after'].'</li>';
    }

    for($i=1; $i < $muchpage+1; $i++){
      // link class
      $ds = ' class="'.$args['link_class'].' %dis"';

      // if opening current page
      if($i == $page){
        $ds = str_replace('%dis','disabled', $ds);
      }else{
        $ds = str_replace('%dis','', $ds);
    	}

      // $o_pagg .= url_rewrite(array(
      //   'dynamic' => '<li'.$ds.'><a href="'.$dynamic_url.'paged='.($i).'" alt="'.lg('Page').' '.$i.' ">'.$i.'</a></li>'
      // ));
      $o_pagg .= '<li'.$ds.'>'.$args['link_before'].'<a href="'.str_replace('%paged%', ($i), $template_paged).'" alt="'.lg('Page').' '.$i.' ">'.$i.'</a>'.$args['link_after'].'</li>';
    }

    if($page < $muchpage){
      // $o_pagg .= url_rewrite(array(
      //   'dynamic' => '<li><a href="'.$dynamic_url.'paged='.($page+1).'" alt="'.lg('Next').'"><i class="fa fa-angle-right"></i></a></li>'
      // ));
      $o_pagg .= '<li>'.$args['link_before'].'<a href="'.str_replace('%paged%', ($page+1), $template_paged).'" alt="'.lg('Next').'" class="'.$args['link_class'].'"><i class="fa fa-angle-right"></i></a>'.$args['link_after'].'</li>';
    }

    $o_pagg .= '</ul>';
    $o_pagg .= $args['after'];

    // is not single post
    if(!is_single()){
      echo $o_pagg;
    }
  }
}
function single_tag_title($prefix = '', $b = false){
  /**
   * Returning tag title.
   * @since 1.1.4
   */
  $tag = $_GET['tag'];
  foreach (get_post()->tag as $t) {
    if($t->tag_seo == $tag){
      return $prefix.$t->tag_name;
    }
  }
}
function single_cat_title($prefix = '', $b = false){
  /**
   * Returning cat title.
   * @since 1.1.4
   */
  return $prefix.get_post()->category_name;
}
function post_type_supports($post_type, $feature = 'comment'){
  /**
   * Check are current post type supports the features.
   * Not used yet.
   * @since 1.1.4
   */
  return true;
}
function get_author_posts_url($author_id = 0){
  /**
   * Get author posts url.
   * @since 1.1.4
   */
  return get_url('author', $author_id);
}

// General Function
function get_meta(){
  /**
   * Compose meta tags for Search Engine Optimization.
   * @since 1.1.4
   */
  // get global variable
  $op = _op();
  //$meta[] = '';

  // set default meta
  $meta['charset'] = 'utf-8';
  $meta['generator'] = 'Elybin CMS';
  $meta['Content-Type'] = 'text/html; charset=utf-8';
  $meta['X-UA-Compatible'] = 'IE=edge';
  $meta['viewport'] = 'width=device-width, initial-scale=1';
  $meta['icon'] = get_option('site_url').'elybin-file/system/'.get_option('site_favicon');

  // loop available(?)
  if(have_posts()){
    if(whats_opened() == 'home'){
      // set
      $meta['description'] = trim(get_option('site_description'));
      $meta['keywords'] = keyword_filter(get_option('site_keyword'));
      $meta['author'] = get_option('site_owner');
      $meta['robots'] = get_option('search_engine_visibility');
      $meta['title'] = get_option('site_name');
    }
    else if(whats_opened() == 'post'){
      // make detail
      $cp = make_detail(get_all_post());
      // do hits
      do_hits($cp->post_id);
      // set
      $meta['description'] = trim($cp->meta_desc);
      $meta['keywords'] = $cp->meta_keywords;
      $meta['author'] = $cp->author_name;
      $meta['title'] = $cp->title.' - '.get_option('site_name');
      $meta['robots'] = 'index, follow';
      $meta['canonical'] = $cp->detail_url;
      // twitter
      if(get_option('social_twitter') !== NULL){
        $meta['twitter:site'] = get_option('social_twitter');
        $meta['twitter:title'] = $cp->title;
        $meta['twitter:description'] = trim($cp->meta_desc);
        $meta['twitter:creator'] = get_option('social_twitter');
        $meta['twitter:card'] = 'summary_large_image';
        $meta['twitter:image:src'] = $cp->image_hd;
      }
      // facebook
      if(get_option('social_facebook')  !== NULL){
        $meta['article:author'] = 'https://www.facebook.com/'.get_option('social_facebook');
        $meta['article:publisher'] = 'https://www.facebook.com/'.get_option('social_facebook');
      }
      // open graph
      $meta['og:url'] = $cp->detail_url;
      $meta['og:type'] = 'article';
      $meta['og:site_name'] = get_option('site_name');
      $meta['og:title'] = $cp->title;
      $meta['og:description'] = trim($cp->meta_desc);
      $meta['og:image'] = $cp->image_hd;
      $meta['og:locale'] = get_option('language');
      $meta['og:locale:alternate'] = 'en_US';
    }
    else if(whats_opened() == 'page'){
      // make detail
      $cp = make_detail(get_all_post());
      // set
      $meta['description'] = trim($cp->meta_desc);
      $meta['keywords'] = $cp->meta_keywords;
      $meta['author'] = get_option('site_owner');
      $meta['title'] = $cp->title;
      $meta['robots'] = 'index, follow';
      $meta['canonical'] = $cp->detail_url;
    }
    else if(whats_opened() == 'category'){
      // catch url
      $cat = sqli_(to_int(@$_GET['cat']));
      // set
      $meta['description'] = sprintf(__('Category Archives: %s'),single_cat_title()).' | '.get_option('site_name');
      $meta['keywords'] = keyword_filter(sprintf(__('Category Archives: %s'),single_cat_title()));
      $meta['title'] = sprintf(__('Category Archives: %s'),single_cat_title());
      $meta['robots'] = 'index, follow';
      // $meta['canonical'] = url_rewrite(array(
      //   'dynamic' => get_option('site_url')."?cat=$cat",
      //   'static1' => get_option('site_url')."topics/$cat/".seo_title(single_cat_title())
      // ));
    }
    else if(whats_opened() == 'author'){
      // catch url
      $author = sqli_(to_int(@$_GET['author']));
      // set
      $meta['description'] = sprintf(__('All posts by %s'),get_the_author()).' | '.get_option('site_name');
      $meta['keywords'] = keyword_filter(sprintf(__('All posts by %s'),get_the_author()));
      $meta['title'] = sprintf(__('All posts by %s'),get_the_author());
      $meta['robots'] = 'index, follow';
      // $meta['canonical'] = url_rewrite(array(
      //   'dynamic' => get_option('site_url')."?author=$author",
      //   'static1' => get_option('site_url')."author/$author"
      // ));
    }
    else if(whats_opened() == 'tag'){
      // catch url
      $tag = sqli_(@$_GET['tag']);
      // set
      $meta['description'] = sprintf(__('Tag Archives: %s'),$tag).' | '.get_option('site_name');
      $meta['keywords'] = keyword_filter(sprintf(__('Tag Archives: %s'),$tag));
      $meta['title'] = sprintf(__('Tag Archives: %s'),$tag);
      // $meta['robots'] = 'index, follow';
      // $meta['canonical'] = url_rewrite(array(
      //   'dynamic' => get_option('site_url')."?tag=$tag",
      //   'static1' => get_option('site_url')."tags/$tag"
      // ));
    }
    else if(whats_opened() == 'search'){
      // catch url
      $s = searchf_(xss_(strip_tags(htmlentities(@$_GET['s'], ENT_QUOTES))));
      // set
      $meta['description'] = sprintf(__('Search Results for "%s"'),$s).' | '.get_option('site_name');
      $meta['keywords'] = keyword_filter(sprintf(__('Search Results for "%s"'),$s));
      $meta['title'] = sprintf(__('Search Results for "%s"'),$s);
      $meta['robots'] = 'noindex, follow';
      $meta['document_type'] = 'Search Results';
      // $meta['canonical'] = url_rewrite(array(
      //   'dynamic' => get_option('site_url')."?s=$s",
      //   'static1' => get_option('site_url')."search/$s"
      // ));
    }
    else if(whats_opened() == 'archive'){
      // catch url
      $m = sqli_(@$_GET['m']);
      // set
      if(is_day()){
        $meta['title'] = sprintf( __( 'Daily Archives: %s'), get_the_date() );
        $meta['description'] = sprintf( __( 'Daily Archives: %s'), get_the_date() ).' | '.get_option('site_name');
        $meta['keywords'] = keyword_filter(sprintf( __( 'Daily Archives: %s'), get_the_date() ));
      }else if(is_month()){
        $meta['title'] = sprintf(__( 'Monthly Archives: %s'), get_the_date('F Y') );
        $meta['description'] = sprintf(__( 'Monthly Archives: %s'), get_the_date('F Y') ).' | '.get_option('site_name');
        $meta['keywords'] = keyword_filter(sprintf(__( 'Monthly Archives: %s'), get_the_date('F Y') ));
      }elseif(is_year()){
        $meta['title'] = sprintf( __( 'Yearly Archives: %s'), get_the_date('Y') );
        $meta['description'] = sprintf( __( 'Yearly Archives: %s'), get_the_date('Y') ).' | '.get_option('site_name');
        $meta['keywords'] = keyword_filter(sprintf( __( 'Yearly Archives: %s'), get_the_date('Y') ));
      }else{
        $meta['title'] = __('Archives');
        $meta['description'] = __('Archives').' | '.get_option('site_name');
        $meta['keywords'] = keyword_filter(__('Archives'));
      }
      $meta['robots'] = 'index, follow';
      // $meta['canonical'] = url_rewrite(array(
      //   'dynamic' => get_option('site_url')."?m=$m"
      // ));
    }
    else if(whats_opened() == 'album'){
      // set
      $meta['description'] = _('Photo Gallery').' | '.get_option('site_name');
      $meta['keywords'] = keyword_filter('photo gallery album '.get_option('site_name'));
      $meta['title'] = _('Photo Gallery').' | '.get_option('site_name');
      $meta['robots'] = 'index, follow';
      // $meta['canonical'] = url_rewrite(array(
      //   'dynamic' => get_option('site_url')."?album",
      //   'static1' => get_option('site_url')."gallery.html"
      // ));
    }
    else if(whats_opened() == 'album-single'){
      $cp = make_detail(get_all_post());
      // set
      $meta['description'] = trim($cp->album_name);
      $meta['keywords'] = keyword_filter('photo gallery album '.get_option('site_name').' '.$cp->album_name);
      $meta['title'] = $cp->album_name.' | '.get_option('site_name');
      $meta['robots'] = 'index, follow';
      // $meta['canonical'] = url_rewrite(array(
      //   'dynamic' => get_option('site_url').'?album='.$cp->album_id,
      //   'static1' => get_option('site_url').'album-'.$cp->album_id.'.html'
      // ));
    }
    else if(whats_opened() == 'photo'){
      // make detail
      $cp = make_detail(get_all_post());
      // set
      $meta['description'] = cutword(strip_tags($cp->description));
      $meta['keywords'] = 'photo, gallery, '.keyword_filter($cp->title);
      $meta['title'] = $cp->title." ".lg('In').' '.trim($cp->title);
      $meta['robots'] = 'index, follow';
      // $meta['canonical'] = url_rewrite(array(
      //   'dynamic' => get_option('site_url').'?album='.$cp->album_id.'&photo='.$cp->photo_id,
      //   'static1' => get_option('site_url').'photo-'.$cp->album_id.'-'.$cp->photo_id.'.html'
      // ));
      $meta['canonical'] = get_url('photo', $cp->album_id, $cp->photo_id);
    }
  }
  // special apps
  else if(whats_opened() == 'apps'){
    // get from global value
    global $param_;
    if( isset($param_['header']) ){
      $param = $param_['header'];
    }else{
      $param = array();
    }

    // set default options
    $defaults = array(
      'description' => null,
      'keywords' => null,
      'author' => get_option('site_owner'),
      'title' => null,
      'robots' => 'index, follow',
      'canonical' => null,
    );
    // set options
    $param = el_parse_args($param, $defaults);

    // set
    $meta['description'] = trim($param['description']);
    $meta['keywords'] = $param['keywords'];
    $meta['author'] = $param['author'];
    $meta['title'] = $param['title'];
    $meta['robots'] = $param['robots'];
    $meta['canonical'] = $param['canonical'];
  }
  else{
    // 404 Page
    $meta['title'] = _('404 Not Found');
    $meta['robots'] = 'noindex, follow';
  }


  // // post (post.php)
  // if(whats_opened() == 'category' || whats_opened() == 'post' || whats_opened() == 'page' || whats_opened() == 'archive' || whats_opened() == 'author'){
  //   // check post exist
  //   if(have_posts()){
  //     // get post detail
  //     // old
  //     // $cp = get_post_detail();
  //     $cp = get_all_post();
  //     // whhats opened
  //     if(whats_opened() == 'post'){
  //       // single post
  //       // make single
  //       $cp = make_detail($cp);
  //
  //       // set
  //       $meta_desc = trim($cp->meta_desc);
  //       $meta_keyword = $cp->meta_keywords;
  //       $meta_author = $cp->author_name;
  //       $page_title = $cp->title.' - '.get_option('site_name');
  //       $robots = 'index, follow';
  //       $canonical = $cp->detail_url;
  //       // more tags
  //       if(!empty(get_option('social_twitter'))){
  //         // twitter card & facebook open graph
  //         $more_tags = '
  //       <meta name="author" content="'.$cp->author_name.'">
  //
  //       <meta name="twitter:site" content="'.get_option('social_twitter').'">
  //       <meta name="twitter:title" content="'.$cp->title.'">
  //       <meta name="twitter:description" content="'.$meta_desc.'">
  //       <meta name="twitter:creator" content="'.get_option('social_twitter').'">
  //       <meta name="twitter:card" content="summary_large_image">
  //       <meta name="twitter:image:src" content="'.$cp->image_hd.'">
  //
  //       <meta property="og:url" content="'.$cp->detail_url.'">
  //       <meta property="og:type" content="article">
  //       <meta property="og:site_name" content="'.$op->site_name.'">
  //       <meta property="og:title" content="'.$cp->title.'">
  //       <meta property="og:description" content="'.$meta_desc.'">
  //       <meta property="og:image" content="'.$cp->image_hd.'">
  //       <meta property="og:locale" content="en_US">
  //       <meta property="og:locale:alternate" content="'.$op->language.'">
  //
  //       <meta property="article:author" content="https://www.facebook.com/'.$op->social_facebook.'" />
  //       <meta property="article:publisher" content="https://www.facebook.com/'.$op->social_facebook.'" />
  //       ';
  //       }
  //     }
  //     else if(whats_opened() == 'page'){
  //       // make single
  //       $cp = make_detail($cp);
  //       // set
  //       $meta_desc = $cp->meta_desc;
  //       $meta_keyword = $cp->meta_keywords;
  //       $meta_author = $op->site_owner;
  //       $page_title = $cp->title;
  //       $robots = 'index, follow';
  //       $canonical = $cp->detail_url;
  //     }
  //     else if(whats_opened() == 'category'){
  //       // get cat
  //       $v = new ElybinValidasi();
  //       $cat = $v->sql(@$_GET['cat']);
  //       // set
  //       $page_title = sprintf(__('Category Archives: %s'),single_cat_title());
  //       $meta_desc = sprintf(__('Category Archives: %s'),single_cat_title()).' | '.$op->site_name;
  //       $meta_keyword = keyword_filter(sprintf(__('Category Archives: %s'),single_cat_title()));
  //       $meta_author = '';
  //       // $canonical = url_rewrite(array(
  //       //   'dynamic' => $op->site_url."?cat=$cat",
  //       //   'static1' => $op->site_url."topics/$cat/".seo_title(single_cat_title())
  //       // ));
  //       $meta['canonical'] = get_url('category', $cat);
  //     }
  //     else if(whats_opened() == 'author'){
  //       // get cat
  //       $v = new ElybinValidasi();
  //       $author = $v->sql(@$_GET['author']);
  //       // set
  //       $page_title = sprintf(__('All posts by %s'),get_the_author());
  //       $meta_desc = sprintf(__('All posts by %s'),get_the_author()).' | '.get_option('site_name');
  //       $meta_keyword = keyword_filter(sprintf(__('All posts by %s'),get_the_author()));
  //       $meta_author = '';
  //       // $canonical = url_rewrite(array(
  //       //   'dynamic' => $op->site_url."?author=$author",
  //       //   'static1' => $op->site_url."author/$author"
  //       // ));
  //       $meta['canonical'] = get_url('author', $author);
  //     }
  //     else if(whats_opened() == 'archive'){
  //       // get cat
  //       $m = sqli_(@$_GET['m']);
  //       // set
  //       if(is_day()){
  //         $page_title = sprintf( __( 'Daily Archives: %s'), get_the_date() );
  //         $meta_desc = sprintf( __( 'Daily Archives: %s'), get_the_date() ).' | '.$op->site_name;
  //         $meta_keyword = keyword_filter(sprintf( __( 'Daily Archives: %s'), get_the_date() ));
  //       }else if(is_month()){
  //         $page_title = sprintf(__( 'Monthly Archives: %s'), get_the_date('F Y') );
  //         $meta_desc = sprintf(__( 'Monthly Archives: %s'), get_the_date('F Y') ).' | '.$op->site_name;
  //         $meta_keyword = keyword_filter(sprintf(__( 'Monthly Archives: %s'), get_the_date('F Y') ));
  //       }elseif(is_year()){
  //         $page_title = sprintf( __( 'Yearly Archives: %s'), get_the_date('Y') );
  //         $meta_desc = sprintf( __( 'Yearly Archives: %s'), get_the_date('Y') ).' | '.$op->site_name;
  //         $meta_keyword = keyword_filter(sprintf( __( 'Yearly Archives: %s'), get_the_date('Y') ));
  //       }else{
  //         $page_title = __('Archives');
  //         $meta_desc = __('Archives').' | '.$op->site_name;
  //         $meta_keyword = keyword_filter(__('Archives'));
  //       }
  //
  //       $meta_author = '';
  //       // $canonical = url_rewrite(array(
  //       //   'dynamic' => $op->site_url."?m=$m"
  //       // ));
  //       $canonical = get_url('archive', $m);
  //     }
  //     else{
  //       $page_title = $op->site_name;
  //     }
  //   }else{
  //     // 404 Page
  //     $page_title = lg('404 Not Found');
  //     $robots = 'noindex,follow';
  //   }
  // }
  //
  // else if(whats_opened() == 'photo'){
  //   // check post exist
  //   if(have_posts()){
  //     // get gallery
  //     $cp = get_all_post()[0];
  //     // var_dump($cp);
  //     // set
  //     $meta_desc = cutword(strip_tags($cp->description));
  //     $meta_keyword = 'photo, gallery, '.keyword_filter($cp->title);
  //     $page_title = $cp->title." ".lg('In').' '.trim($cp->title);
  //     $robots = 'index, follow';
  //     // $canonical = url_rewrite(array(
  //     //   'dynamic' => get_option('site_url').'?album='.$cp->album_id.'&photo='.$cp->photo_id,
  //     //   'static1' => get_option('site_url').'photo-'.$cp->album_id.'-'.$cp->photo_id.'.html'
  //     // ));
  //     $canonical = get_url('photo', $cp->album_id, $cp->photo_id);
  //
  //     $more_tags = '
  //     <meta name="twitter:site" content="'.$op->social_twitter.'">
  //     <meta name="twitter:title" content="'.$cp->title." ".lg('In').' '.trim($cp->title).'">
  //     <meta name="twitter:description" content="'.$meta_desc.'">
  //     <meta name="twitter:creator" content="'.$op->social_twitter.'">
  //     <meta name="twitter:card" content="summary_large_image">
  //     <meta name="twitter:image:src" content="'.$cp->thumbnail[0].'">
  //
  //     <meta property="og:url" content="'.$canonical.'">
  //     <meta property="og:type" content="article">
  //     <meta property="og:site_name" content="'.$op->site_name.'">
  //     <meta property="og:title" content="'.$cp->title.'">
  //     <meta property="og:description" content="'.$meta_desc.'">
  //     <meta property="og:image" content="'.$cp->thumbnail[0].'">
  //     <meta property="og:locale" content="en_US">
  //     <meta property="og:locale:alternate" content="'.$op->language.'">
  //     ';
  //   }else{
  //     // 404 Page
  //     $page_title = lg('404 Not Found');
  //     $robots = 'noindex,follow';
  //   }
  // }
  // else if(whats_opened() == 'album-single'){
  //   // check post exist
  //   if(have_posts()){
  //     // get gallery
  //     $cp = get_all_post()[0];
  //     // set
  //     $meta_desc = trim($cp->title);
  //     $meta_keyword = 'photo, gallery, album, '.keyword_filter($cp->title);
  //     $page_title = trim($cp->title);
  //     $robots = 'index, follow';
  //     // $canonical = url_rewrite(array(
  //     //   'dynamic' => get_option('site_url').'?album='.$cp->album_id,
  //     //   'static1' => get_option('site_url').'album-'.$cp->album_id.'.html'
  //     // ));
  //     $canonical = get_url('album', $cp->album_id);
  //     $more_tags = '
  //     <meta name="twitter:site" content="'.$op->social_twitter.'">
  //     <meta name="twitter:title" content="'.$page_title.'">
  //     <meta name="twitter:description" content="'.$meta_desc.'">
  //     <meta name="twitter:creator" content="'.$op->social_twitter.'">
  //     <meta name="twitter:card" content="summary_large_image">
  //     <meta name="twitter:image:src" content="'.$cp->thumbnail[0].'">
  //
  //     <meta property="og:url" content="'.$canonical.'">
  //     <meta property="og:type" content="article">
  //     <meta property="og:site_name" content="'.$op->site_name.'">
  //     <meta property="og:title" content="'.$page_title.'">
  //     <meta property="og:description" content="'.$meta_desc.'">
  //     <meta property="og:image" content="'.$cp->thumbnail[0].'">
  //     <meta property="og:locale" content="en_US">
  //     <meta property="og:locale:alternate" content="'.$op->language.'">
  //     ';
  //   }else{
  //     // 404 Page
  //     $page_title = lg('404 Not Found');
  //     $robots = 'noindex,follow';
  //   }
  // }
  // else if(whats_opened() == 'album'){
  //   // check post exist
  //   if(have_posts()){
  //     // set
  //     $meta_desc = '';
  //     $cp = get_all_post();
  //     foreach ($cp as $c) {
  //       $meta_desc .= $c->title." ";
  //     }
  //     $meta_keyword = 'photo, gallery, album, '.keyword_filter($op->site_name);
  //     $page_title = __('Photo Gallery');
  //     $robots = 'index, follow';
  //     // dynamic/static
  //     // $canonical = url_rewrite(array(
  //     //   'dynamic' => get_option('site_url').'?album',
  //     //   'static1' => get_option('site_url').'gallery.html'
  //     // ));
  //     $canonical = get_url('gallery');
  //   }else{
  //     // 404 Page
  //     $page_title = lg('404 Not Found');
  //     $robots = 'noindex,follow';
  //   }
  // }
  // // search (search.php)
  // elseif(whats_opened() == 'search'){
  //   // get q
  //   $v = new ElybinValidasi();
  //   $s = $v->sql(@$_GET['s']);
  //   // set
  //   $page_title = lg('Search Results for').' "'.$s.'"';
  //   $meta_desc = $op->site_name.' '.lg('Search').' '.$s;
  //   $meta_keyword = trim($s);
  //   $meta_author = '';
  //   $robots = 'noindex, follow';
  //   $more_tags = '<meta name="document_type" content="Search Results" />'."\n";
  // }
  // elseif(whats_opened() == 'tag'){
  //   // get tag
  //   $v = new ElybinValidasi();
  //   $tag = $v->sql(@$_GET['tag']);
  //   // set
  //   $page_title = sprintf(__('Tag Archives: %s'),$tag);
  //   $meta_desc = sprintf(__('Tag Archives: %s'),$tag).' | '.$op->site_name;
  //   $meta_keyword = keyword_filter(sprintf(__('Tag Archives: %s'),$tag));
  //   $meta_author = '';
  //   // $canonical = url_rewrite(array(
  //   //   'dynamic' => $op->site_url."?tag=$tag",
  //   //   'dynamic' => $op->site_url."tags/$tag"
  //   // ));
  //   $canonical = get_url('tag', $tag);
  // }

  // meta html dictionary
  $meta_html = array(
    'title'              => '<title>%s</title>',
    'charset'            => '<meta charset="%s">',
    'generator'          => '<meta name="generator" content="%s">',
    'viewport'           => '<meta name="viewport" content="%s">',

    'robots'             => '<meta name="robots" content="%s">',
    'description'        => '<meta name="description" content="%s">',
    'keywords'           => '<meta name="keywords" content="%s">',
    'headline'           => '<meta name="headline" content="%s">',
    'author'             => '<meta name="author" content="%s">',

    'twitter:site'       => '<meta name="twitter:site" content="%s">',
    'twitter:title'      => '<meta name="twitter:title" content="%s">',
    'twitter:description'=> '<meta name="twitter:description" content="%s">',
    'twitter:creator'    => '<meta name="twitter:creator" content="%s">',
    'twitter:card'       => '<meta name="twitter:card" content="%s">',
    'twitter:image:src'  => '<meta name="twitter:image:src" content="%s">',

    'document_type'      => '<meta name="document_type" content="%s">',

    'og:url'             => '<meta property="og:url" content="%s">',
    'og:type'            => '<meta property="og:type" content="%s">',
    'og:site_name'       => '<meta property="og:site_name" content="%s">',
    'og:title'           => '<meta property="og:title" content="%s">',
    'og:description'     => '<meta property="og:description" content="%s">',
    'og:image'           => '<meta property="og:image" content="%s">',
    'og:locale'          => '<meta property="og:locale" content="%s">',
    'og:locale:alternate'=> '<meta property="og:locale:alternate" content="%s">',

    'article:author'     => '<meta property="article:author" content="%s">',
    'article:publisher'  => '<meta property="article:publisher" content="%s">',

    'Content-Type'       => '<meta http-equiv="Content-Type" content="%s">',
    'X-UA-Compatible'    => '<meta http-equiv="X-UA-Compatible" content="%s">',

    'canonical'          => '<link rel="canonical" href="%s">',
    'icon'               => '<link rel="icon" href="%s">',

    'custom'             => '%s'
  );

  // check
  foreach ($meta_html as $key => $value) {
    if(isset($meta[$key]) && !empty($meta[$key])){
      $meta[$key] = sprintf($value, $meta[$key]);
    }
  }
  // print it out
  foreach ($meta as $key => $value) {
    echo "  $value\r\n";
  }

  // if(isset($robots)){
  //   $meta .= '<meta name="robots" content="'.$robots.'">'."\r\n  ";
  // }
  // if(isset($meta_desc)){
  //   $meta .= '<meta name="description" content="'.$meta_desc.'">'."\r\n  ";
  // }
  // if(isset($meta_keyword)){
  //   $meta .= '<meta name="keywords" content="'.$meta_keyword.'">'."\r\n  ";
  // }
  // if(isset($canonical)){
  //   $meta .= '<link rel="canonical" href="'.$canonical.'">'."\r\n  ";
  // }
  // if(isset($headline)){
  //   $meta .= '<meta name="headline" content="'.$headline.'" >'."\r\n  ";
  // }
  // if(isset($more_tags)){
  //   $meta .= $more_tags;
  // }

  // more more
  // $meta .= "\r\n  ".'<link rel="icon" href="'.$op->site_url.'elybin-file/system/'.$op->site_favicon.'" />';
  //
  // echo $meta;
}
function get_template_part($slug = 'content', $name = false){
  /**
   * Get template part.
   * @since 1.1.4
   */
   if(!$name){
     if(file_exists(get_template_directory_uri().'/'.$slug.'.php')){
       include(get_template_directory_uri().'/'.$slug.'.php');
     }
   }else{
     if(file_exists(get_template_directory_uri().'/'.$slug.'-'.$name.'.php')){
       include(get_template_directory_uri().'/'.$slug.'-'.$name.'.php');
     }
   }
}
function make_detail($input = ''){
  /**
   * Append additional detail information.
   * @since 1.1.4
   */
  // keyword
  $result = $input;

  return $result[0];
}
function do_hits($pid = 0){
  /**
   * +1 hits.
   * @since 1.1.4
   */
  $tbp = new ElybinTable('elybin_posts');
  $tbp->FullQuery("
  UPDATE
  `elybin_posts` as `p`
  SET
  `p`.`hits` = (`p`.`hits`+1)
  WHERE
  `p`.`post_id` = $pid;
  ");
  return true;
}
function get_template_directory(){
  // get active template
  return get_option('site_url').'elybin-file/theme/'.get_option('template');
}
function get_template_directory_uri(){
  /**
   * Retrieve theme directory URI.
   * @since 1.1.4
   */
  return getcwd().'/elybin-file/theme/'.get_option('template');
}
function get_site_logo(){
  /**
   * Full url of website logo.
   * @since 1.1.4
   */
  return get_option('site_url').'elybin-file/system/'.get_option('site_logo');
}
function site_logo(){
  /**
   * Full url of website logo.
   * @since 1.1.4
   */
  echo get_site_logo();
}
function header_image(){
  /**
   * Full url of website header/hero.
   * @since 1.1.4
   */
  echo get_header_image();
}
function get_header_image(){
  /**
   * Full url of website header/hero (with return method).
   * @since 1.1.4
   */
  global $op;
  return $op->site_url.'elybin-file/system/'.$op->site_hero;
}
function home_url($after = '/'){
  /**
   * Full url of website.
   * @since 1.1.4
   */
  global $op;
  echo rtrim($op->site_url, "/").$after;
}
function bloginfo($args = 'name'){
  /**
   * Get blog/website information.
   * @since 1.1.4
   */
  echo get_bloginfo($args);
}
function get_bloginfo($args = 'name', $args2 = ''){
  /**
   * Get blog/website information (with return method).
   * @since 1.1.4
   */
  global $op;
  switch ($args) {
    case 'name':
      return get_option('site_name');
      break;
    case 'heading':
      return get_option('site_hero_title');
      break;
    case 'hero_title':
      return get_option('site_hero_title');
      break;
    case 'subheading':
      return get_option('site_hero_subtitle');
      break;
    case 'hero_subtitle':
      return get_option('site_hero_subtitle');
      break;

    default:
      # code...
      break;
  }
}
function get_header($param = array()){
  /**
   * Get template header.
   * @since 1.1.4
   */
  // global variable
  global $param_;
  $param_['header'] = $param;

  // include
  include(get_template_directory_uri().'/header.php');
}function get_sidebar($args1 = none){
  /**
   * Get template sidebar.
   * @since 1.1.4
   */
  include(get_template_directory_uri().'/sidebar.php');
}
function get_menu(){
  /**
   * Get template menu/navigation.
   * @since 1.1.4
   */
  include_once(get_template_directory_uri().'/menu.php');
}
function get_footer(){
  /**
   * Get template footer.
   * @since 1.1.4
   */
  include_once(get_template_directory_uri().'/footer.php');
}
function add_action($arg0, $arg1){
  /**
   * Hook function.
   * @since 1.1.4
   * @param add_action('hook_name','function name');
   */
   global $hook_;
   if(!isset($hook_[$arg0])){
     $hook_[$arg0] = '';
   }
   $hook_[$arg0] .= $arg1;
}
function el_footer(){
  /**
   * Display additional script before html closing tag.
   * @since 1.1.4
   */
   global $hook_;
   if(isset($hook_['el_footer'])){

      $hook_['el_footer']();
   }
}
function wp_footer(){
  /**
   * Alternative of el_footer().
   * @since 1.1.4
   */
  el_footer();
}
function is_active_sidebar($args1 = ''){
  /**
   * Return widget active status.
   * @since 1.1.4
   */
   if($args1 != ''){
     $tb = new ElybinTable('elybin_widget');
     $pos = sidebar_pos_convert($args1);
     return $tb->GetRowCustom("(`position` = $pos && `status` = 'active') && (`type` = 'include' || `type` = 'code')");
   }else{
     return sprintf(lg('Missing argument 1.'));
   }
}
function sidebar_pos_convert($args1 = 'sidebar-1'){
  /**
   * Convert string to integer widget indentifer.
   */
  switch($args1){
    case 'sidebar-1':
    $pos = 1;
      break;
    case 'sidebar-2':
    $pos = 2;
      break;
    case 'sidebar-3':
    $pos = 3;
      break;
    default:
    $pos = 1;
      break;
  }
  return $pos;
}
function dynamic_sidebar($args1 = false){
  /**
   * Get active widget.
   * @since 1.1.4
   */
  if(!$args1){
    echo lg('Missing argument 1.');
  }else{
    $tb = new ElybinTable('elybin_widget');
    $pos = sidebar_pos_convert($args1);
    $lw = $tb->SelectWhereAnd('position', $pos, 'status', 'active', 'sort', 'ASC');
    foreach ($lw as $w) {
      if($w->type == 'include' || $w->type == 'code'){
        if($w->type == "include"){
          if(file_exists(get_template_directory_uri().'/../../.'.$w->content)){
            include(get_template_directory_uri().'/../../.'.$w->content);
          }else{
            echo sprintf(lg('Failed while including "%s", file not exsist.'), $w->name);
          }
        }
        elseif($w->type == "code"){
          echo html_entity_decode($w->content);
        }
        echo '<hr id="'.strtolower($w->name).'-hr"/>';
      }
    }
  }
}
function get_posts_url($p = 0){
  /**
   * Get posts url.
   * @since 1.1.4
   */
  return get_url('post', $p);
}

// Footer
function get_subnav(){
  /**
   * Display sub-navigation that as simple as posible.
   * @since 1.1.4
   */
  $tb = new ElybinTable('elybin_menu');
  $parent = $tb->SelectWhere('parent_id','0','menu_position','ASC');
  echo '<ul id="sitelink">';
  foreach ($parent as $pr) {
    // replace expressions
    $pr->menu_url = replace_nav_expression($pr->menu_url);
    //parent
    echo '<li class="dropdown"><a href="'.$pr->menu_url.'">'.$pr->menu_title.'</a>';
    // first child
    $countchild1 = $tb->GetRow('parent_id',$pr->menu_id);
    if($countchild1 > 0){
      $child1 = $tb->SelectWhere('parent_id',$pr->menu_id,'menu_position','ASC');
      echo '<ul class="dropdown-menu">';
      foreach ($child1 as $ch1) {
        // replace expressions
        $ch1->menu_url = replace_nav_expression($ch1->menu_url);
        echo '<li class="dropdown"><a href="'.$ch1->menu_url.'">'.$ch1->menu_title.'</a>';
        // second child
        $countchild2 = $tb->GetRow('parent_id',$ch1->menu_id);
        if($countchild2 > 0){
          $child2 = $tb->SelectWhere('parent_id',$ch1->menu_id,'menu_position','ASC');
          echo '<ul class="dropdown-menu">';
          foreach ($child2 as $ch2) {
            // replace expressions
            $ch2->menu_url = replace_nav_expression($ch2->menu_url);
            echo '<li class="dropdown"><a  href="'.$ch2->menu_url.'">'.$ch2->menu_title.'</a></li>';
          }
          echo '</ul>';
        }
        echo '</li>';
      }
      echo '</ul>';
    }
    echo '</li>';
  }
  echo '</ul>';
}
function get_recent_post($limit = 4){
  /**
   * Display recent post.
   * @since 1.1.4
   */
   // get post
   $tbp = new ElybinTable('elybin_posts');
   $post = $tbp->SelectWhereLimit('status','publish','post_id','DESC',"0,$limit");

   echo '<ul>';
   foreach($post as $p){
     echo '<li>';
     echo '<a href="'.get_posts_url($p->post_id).'" class="small">'.$p->title.'</a>';
     echo '</li>';
   }
   echo '</ul>';
}
function get_recent_comment($limit = 2){
  /**
   * Display recent comments.
   * @since 1.1.4
   */

   echo '<ul>';
   // get post
   $tbc = new ElybinTable('elybin_comments');
   $lc = $tbc->SelectFullCustom("
       SELECT
       *,
       `c`.`date` as `date_comment`,
       `c`.`author` as `author_comment`,
       `c`.`content` as `content_comment`
       FROM
       `elybin_comments` as `c`,
       `elybin_posts` as `p`
       WHERE
       `c`.`post_id` = `p`.`post_id` &&
       `c`.`status` = 'active'
       ORDER BY `c`.`date` DESC
       LIMIT 0,4
    ");

    foreach($lc as $cc){
      echo '<li>';
      echo '  <a href="'.get_posts_url($cc->post_id).'#comment-'.$cc->comment_id.'" class="small"><b>'.$cc->author_comment.'</b> <i>&#34;'.substr(strip_tags($cc->content_comment),0,100).'....&#34;</i> <span class="text-dash">'.time_elapsed_string($cc->date_comment).'</span></a>';
      echo '</li>';
    }
    echo '</ul>';
}
function get_social_media($withtext = false, $linkclass = 'btn btn-sm btn-primary'){
  /**
   * Display social media.
   * @since 1.1.4
   */
   $op = _op();
   $av = 0;
   echo '<div style="margin-top:10px"></div>';
   if(!empty($op->social_twitter)){
     if($withtext){
       echo '<a href="https://www.twitter.com/'.$op->social_twitter.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-twitter"></i>&nbsp;'.lg('Twitter').'</a>&nbsp;';
     }else{
       echo '<a href="https://www.twitter.com/'.$op->social_twitter.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-twitter"></i></a>&nbsp;';
     }
     $av++;
   }
   if(!empty($op->social_facebook)){
     if($withtext){
       echo '<a href="https://www.facebook.com/'.$op->social_facebook.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-facebook"></i>&nbsp;'.lg('Facebook').'</a>&nbsp;';
     }else{
       echo '<a href="https://www.facebook.com/'.$op->social_facebook.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-facebook"></i></a>&nbsp;';
     }
     $av++;
   }
   if(!empty($op->social_instagram)){
     if($withtext){
       echo '<a href="https://www.instagram.com/'.$op->social_instagram.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-instagram"></i>&nbsp;'.lg('Instagram').'</a>&nbsp;';
     }else{
       echo '<a href="https://www.instagram.com/'.$op->social_instagram.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-instagram"></i></a>&nbsp;';
     }
     $av++;
   }
   if(!empty($op->social_googleplus)){
     if($withtext){
       echo '<a href="https://plus.google.com/'.$op->social_googleplus.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-google-plus"></i>&nbsp;'.lg('Google+').'</a>&nbsp;';
     }else{
       echo '<a href="https://plus.google.com/'.$op->social_googleplus.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-google-plus"></i></a>&nbsp;';
     }
     $av++;
   }
   if(!empty($op->social_tumblr)){
     if($withtext){
       echo '<a href="https://www.tumblr.com/'.$op->social_tumblr.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-tumblr"></i>&nbsp;'.lg('Tumblr').'</a>&nbsp;';
     }else{
       echo '<a href="https://www.tumblr.com/'.$op->social_tumblr.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-tumblr"></i></a>&nbsp;';
     }
     $av++;
   }
   if(!empty($op->social_youtube)){
     if($withtext){
       echo '<a href="https://www.youtube.com/'.$op->social_youtube.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-youtube"></i>&nbsp;'.lg('YouTube').'</a>&nbsp;';
     }else{
       echo '<a href="https://www.youtube.com/'.$op->social_youtube.'" target="_blank" class="'.$linkclass.'"><i class="fa fa-youtube"></i></a>&nbsp;';
     }
     $av++;
   }
   if($av > 0){
     echo '<br/>';
   }
}
function get_site_information($show = array("site_owner","site_description"), $icon = false, $dash = false){
  /**
   * Display site basic information.
   * @since 1.1.4
   */
  $op = _op();
  if($dash){
    $spa = ' class="text-dash"';
  }else{
    $spa = '';
  }
  foreach ($show as $s) {
    if($icon){
      // sw icon
      switch($s){
        case 'site_name':
          $ic = 'fa-home';
          break;
        case 'site_description':
          $ic = 'fa-bars';
          break;
        case 'site_phone':
          $ic = 'fa-phone';
          break;
        case 'site_office_address':
          $ic = 'fa-map-marker';
          break;
        case 'site_email':
          $ic = 'fa-envelope';
          break;
        case 'site_owner':
          $ic = 'fa-user';
          break;
        case 'site_owner_story':
          $ic = 'fa-edit';
          break;
        default:
          $ic = '';
          break;
      }
      echo '<i class="fa '.$ic.'"></i>&nbsp;&nbsp;<span'.$spa.'>'.$op->$s.'</span><br/>';
    }else{
      echo '<span'.$spa.'>'.$op->$s.'</span><br/>';
    }
  }
}
function appreciation_link(){
  /**
   * Display appreciation link.
   * @since 1.1.4
   */
   echo lg('Powered by').' <a href="http://www.elybin.com/" alt="Elybin - '.lg('Modern, Powerful &amp; Beautiful for all you need').'" class="text-dash" style="background-color: transparent">Elybin CMS</a>';
   $_SESSION['$ThanksELybin'] = md5(rand(1,99999));
}

// Header
function replace_nav_expression($url_str = null){
  /**
   * Replace expressions into friendly url
   * @since 1.1.4
   */
  // debug
  $debug = false;
  // decode first
  $url_str = htmlspecialchars_decode(htmlspecialchars_decode($url_str, ENT_QUOTES));
  // detect braces
  preg_match('/\{(.*)\}/', $url_str, $match);
  if(!empty($match[1])){
    // decode json
    $djs = json_decode('{'.$match[1].'}', true);

    // check first to avoid error
    // if there are only one param
    if(!preg_match('/(.*)\:(.*)/', $url_str)){
      $get_url = get_url(str_replace('"','', $match[1]));
    }else{
      $get_url = get_url(array_keys($djs)[0], $djs[array_keys($djs)[0]]);
    }
    if($get_url == false){
      // is wrong
      $url_str = sprintf(__('(%s) is a wrong url expressions.'), @array_keys($djs)[0]);
    }else{
      // replace
      $url_str = $get_url;
    }
  }

  return $url_str;
}
function el_nav_menu($param = array()){
  /**
   * Display simple navigation bar.
   * @since 1.1.4
   *
   * @param array $args {
   *     Optional. Array of nav menu arguments.
   *
   *     @type string        $menu            Desired menu. Accepts (matching in order) id, slug, name. Default empty.
   *     @type string        $menu_class      CSS class to use for the ul element which forms the menu. Default 'menu'.
   *     @type string        $menu_id         The ID that is applied to the ul element which forms the menu.
   *                                          Default is the menu slug, incremented.
   *     @type string        $container       Whether to wrap the ul, and what to wrap it with. Default 'div'.
   *     @type string        $container_class Class that is applied to the container. Default 'menu-{menu slug}-container'.
   *     @type string        $container_id    The ID that is applied to the container. Default empty.
   *     @type callback|bool $fallback_cb     If the menu doesn't exists, a callback function will fire.
   *                                          Default is 'wp_page_menu'. Set to false for no fallback.
   *     @type string        $before          Text before the link text. Default empty.
   *     @type string        $after           Text after the link text. Default empty.
   *     @type string        $link_before     Text before the link. Default empty.
   *     @type string        $link_after      Text after the link. Default empty.
   *     @type bool          $echo            Whether to echo the menu or return it. Default true.
   *     @type int           $depth           How many levels of the hierarchy are to be included. 0 means all. Default 0.
   *     @type object        $walker          Instance of a custom walker class. Default empty.
   *     @type string        $theme_location  Theme location to be used. Must be registered with register_nav_menu()
   *                                          in order to be selectable by the user.
   *     @type string        $items_wrap      How the list items should be wrapped. Default is a ul with an id and class.
   *                                          Uses printf() format with numbered placeholders.
   * }
   * @return mixed Menu output if $echo is false, false if there are no items or no menu was found.
   */

  // set default options
  $defaults = array(
    'theme_location' => 'primary',
    'menu' => '',
    'menu_class' => 'nav-menu',
    'menu_id' => '',
    'container_classiner' => 'div',
    'container_class' => '',
    'container_id' => '',
    'dropdown_class' => 'dropdown',
    'dropdownmenu_class' => 'dropdown-menu',
    'before' => '',
    'after' => '',
    'link_before' => '',
    'link_after' => '',
    'depth' => 0,
    'walker' => ''
  );
  // set options
  $param = el_parse_args($param, $defaults);

  // fill custom prefix
  if(!empty($param['container_id'])){
    $param['container_id'] = ' id="'.$param['container_id'].'"';
  }
  if(!empty($param['container_class'])){
    $param['container_class'] = ' class="'.$param['container_class'].'"';
  }
  if(!empty($param['menu_id'])){
    $param['menu_id'] = ' id="'.$param['menu_id'].'"';
  }
  if(!empty($param['menu_class'])){
    $param['menu_class'] = ' class="'.$param['menu_class'].'"';
  }
  if(!empty($param['dropdown_class'])){
    $param['dropdown_class'] = ' class="'.$param['dropdown_class'].'"';
  }
  if(!empty($param['dropdownmenu_class'])){
    $param['dropdownmenu_class'] = ' class="'.$param['dropdownmenu_class'].'"';
  }

  // start kicking
  $ou = "<!-- Nav -->\n";
  $ou .= "\t\t".'<div'.$param['container_class'].$param['container_id'].'>'."\n";
  $ou .= "\t\t\t".'<ul'.$param['menu_class'].$param['menu_id'].'>'."\n";
  // getting data form database
  $tbm = new ElybinTable('elybin_menu');
  $parent = $tbm->SelectWhere('parent_id','0','menu_position','ASC');
  // loop it
  foreach ($parent as $pr) {
    /**
     * Replace expressions into friendly url
     * @since 1.1.4
     */
    $pr->menu_url = replace_nav_expression($pr->menu_url);

    //parent
    $ou .= "\t\t\t\t".'<li'.$param['dropdown_class'].'>'.$param['link_before'].'<a href="'.$pr->menu_url.'">'.$param['before'].$pr->menu_title.$param['after'].'</a>'.$param['link_after'];
    // first child
    $countchild1 = $tbm->GetRow('parent_id',$pr->menu_id);
    if($countchild1 > 0){
      $child1 = $tbm->SelectWhere('parent_id',$pr->menu_id,'menu_position','ASC');
      $ou .= "\n\t\t\t\t\t".'<ul'.$param['dropdownmenu_class'].'>'."\n";
      foreach ($child1 as $ch1) {
        // replace
        $ch1->menu_url = replace_nav_expression($ch1->menu_url);

        $ou .= "\t\t\t\t\t\t".'<li'.$param['dropdown_class'].'>'.$param['link_before'].'<a href="'.$ch1->menu_url.'">'.$param['before'].$ch1->menu_title.$param['after'].'</a>'.$param['link_after'];
        // second child
        $countchild2 = $tbm->GetRow('parent_id',$ch1->menu_id);
        if($countchild2 > 0){
          $child2 = $tbm->SelectWhere('parent_id',$ch1->menu_id,'menu_position','ASC');
          $ou .= '<ul'.$param['dropdownmenu_class'].'>';
          foreach ($child2 as $ch2) {
            // replace
            $ch2->menu_url = replace_nav_expression($ch2->menu_url);

            $ou .= '<li'.$param['dropdown_class'].'>'.$param['link_before'].'<a  href="'.$ch2->menu_url.'">'.$param['before'].$ch2->menu_title.$param['after'].'</a>'.$param['link_after'].'</li>';
          }
          $ou .= "\t\t\t\t\t</ul>\n";
        }
        $ou .= "</li>\n";
      }
      $ou .= "\t\t\t\t\t</ul>\n\t\t\t\t";
    }
    $ou .= "</li>\n";
  }
  $ou .= "\t\t\t</ul>\n";
  $ou .= "\t\t</div>\n";
  $ou .= "\t\t<!-- ./nav -->\n";

  echo $ou;
}
function wp_nav_menu($param = array()){
  /**
   * Alternative el_nav_menu().
   * @since 1.1.4
   */
  el_nav_menu($param);
}
function get_search_form($param = ''){
  /**
   * Displaying search form.
   * @since 1.1.4
   */
   $defaults = array(
     'input_id' => '',
     'input_class' => '',
     'input_style' => '',
     'container_id' => '',
     'container_class' => '',
     'before' => '',
     'after' => '',
     'button_text' => __('Search'),
     'button_class' => '',
     'button_style' => '',
     'button_before' => '',
     'button_after' => ''
  );

   $param = el_parse_args($param, $defaults);

   // fill prefix
   if(!empty($param['container_id'])){
     $param['container_id'] = ' id="'.$param['container_id'].'"';
   }
   if(!empty($param['container_class'])){
     $param['container_class'] = ' class="'.$param['container_class'].'"';
   }
   if(!empty($param['input_id'])){
     $param['input_id'] = ' id="'.$param['input_id'].'"';
   }
   if(!empty($param['input_class'])){
     $param['input_class'] = ' class="'.$param['input_class'].'"';
   }
   if(!empty($param['input_style'])){
     $param['input_style'] = ' style="'.$param['input_style'].'"';
   }
   if(!empty($param['button_class'])){
     $param['button_class'] = ' class="'.$param['button_class'].'"';
   }
   if(!empty($param['button_style'])){
     $param['button_style'] = ' style="'.$param['button_style'].'"';
   }

   e('
   <form action="" method="GET">
     '.$param['before'].'
     <div'.$param['container_class'].$param['container_id'].'>
      <input type="text" name="s" placeholder="'.lg('Search').'"'.$param['input_class'].$param['input_id'].$param['input_style'].'>
      '.$param['button_before'].'
      <button type="submit"'.$param['button_class'].$param['button_style'].'>'.$param['button_text'].'</button>
      '.$param['button_after'].'
     </div>
     '.$param['after'].'
   </form>
  ');
}


// Comments
function comments_open(){
  /**
   * Check current post are allowed to comment?.
   * @since 1.1.4
   */
   global $current_post;
   if($current_post->comment == 'allow'){
     return true;
   }else{
     return false;
   }
}
function get_comments_number(){
  /**
   * Get number of comment.
   * @since 1.1.4
   */
   return get_post()->comment_count;
}
function comments_template(){
  /**
   * Include comment form.
   * @since 1.1.4
   */
   if(is_single()){
     include_once(get_template_directory_uri().'/comments.php');
   }
}
function have_comments(){
  /**
   * Check if post have comment or not.
   * @since 1.1.4
   */
   if(get_comments_number() > 0){
     return true;
   }else{
     return false;
   }
}
function post_password_required(){
  /**
   * Are password required?
   * @since 1.1.4
   */
  return false;
}
function number_format_i18n($number, $decimals = 0){
  /**
   *
   * @since 1.1.4
   */
  return $number;
}
function get_comment_pages_count(){
  /**
   * Get comment pages, not available yet.
   * @since 1.1.4
   */
  return 1;
}
function el_list_comments($args = array()){
  /**
   * Display comment list.
   * @since 1.1.4
   */

  $defaults = array(
    'style'             => 'ul',
    'avatar_size'       => 32,
  );

  $args2 = el_parse_args($args, $defaults);

  // show
  $ret = json_decode(get_comment())->comment_detail;
  // write it
  for($i=0; $i < count($ret); $i++){
    echo '
    <'.$args2['style'].' class="comment-list">
      <li id="comment-'.$ret[$i]->comment_id.'" name="comment-'.$ret[$i]->comment_id.'" class="comment even thread-even depth-'.($i+1).'">
        <article id="div-comment-'.($i+1).'" class="comment-body">
          <footer class="comment-meta">
            <div class="comment-author vcard">
              <img alt="" src="'.$ret[$i]->avatar_md.'" class="avatar" height="'.$args2['avatar_size'].'" width="'.$args2['avatar_size'].'" />
              <b class="fn"><a href="'.$ret[$i]->author.'" rel="external nofollow" class="url">'.$ret[$i]->author.'</a></b>
              <span class="says">'.lg('Says:').'</span>
            </div>
            <!-- .comment-author -->

            <div class="comment-metadata">
              <a href="'.$ret[$i]->parent_url.'#comment-'.($i+1).'">
                <time datetime="'.$ret[$i]->atom_date.'">
                  '.$ret[$i]->human_date.'
                </time>
              </a>
            </div><!-- .comment-metadata -->
          </footer><!-- .comment-meta -->
        <div class="comment-content">
          <p>'.$ret[$i]->content.'</p>
        </div><!-- .comment-content -->
      </li><!-- #comment-## -->
    </'.$args2['style'].'><!-- .comment-list -->
    ';
  }
}
function wp_list_comments($args = array()){
  /**
   * Alternative of el_list_comments().
   * @since 1.1.4
   */
  el_list_comments($args);
}
function get_comment(){
  /**
   * Get commnet returned as object with json encoded.
   * @since 1.1.4
   */
  global $current_post;
  global $op;
  $result = new stdClass();
  // comment
  $tbc = new ElybinTable('elybin_comments');
  $cocom = $tbc->GetRow('post_id',$current_post->post_id);
  $result->comment_count = $cocom;
  // add comment detail
  $com[] = '';
  $i = 0;
  if($cocom > 0){
    // get comment
    $lcom = $tbc->SelectWhereAnd('post_id', $current_post->post_id,'status','active');
    foreach ($lcom as $lc) {
      // convert user id to name
      if($lc->user_id > 0){
        $uu = _u($lc->user_id);
        $lc->author = $uu->fullname;
        $lc->email = $uu->user_account_email;

        // if avatar default
        if($uu->avatar !== 'default/no-ava.png'){
          $lc->avatar_md = $op->site_url.'elybin-file/avatar/md-'.$uu->avatar;
          $lc->avatar_hd = $op->site_url.'elybin-file/avatar/'.$uu->avatar;
        }else{
          $lc->avatar_md = $op->site_url.'elybin-file/avatar/default/medium-no-ava.png';
          $lc->avatar_hd = $op->site_url.'elybin-file/avatar/default/no-ava.png';
        }
      }else{
        $lc->avatar_md = $op->site_url.'elybin-file/avatar/default/medium-no-ava.png';
        $lc->avatar_hd = $op->site_url.'elybin-file/avatar/default/no-ava.png';
      }


      // human date
      $c_human_date_a = explode(" ",$lc->date);
      $c_human_date = friendly_date($c_human_date_a[0],'full');
      $c_human_date = $c_human_date.' '.lg('at').' '.substr($c_human_date_a[1],0,5);
      $lc->human_date = $c_human_date;
      // elapsed time
      $lc->elapsed_time = time_elapsed_string($lc->date);
      // ATOM DATE
      $lc->atom_date = date("Y-m-d\TH:i:s\Z", strtotime($lc->date));
      // get post detail
      $lc->parent_url = $current_post->detail_url;

      // compile
      $com[$i] = $lc;
      $i++;
    }
    // make json
    $result->comment_detail = $com;
  }

  return json_encode($result);
}
function comment_form(){
  /**
   * Displaying comment form.
   * @since 1.1.4
   */
  global $op;
  $p = get_post();

  echo '<div id="respond" class="comment-respond" name="respond">
  <h3 id="reply-title" class="comment-reply-title">'.lg('Leave a Reply').'</h3>
  <form action="'.get_option('site_url').'elybin-main/comment/comment-post.php" method="post" id="commentform" class="comment-form" novalidate>
    <p class="comment-notes">
      <span id="email-notes">'.lg('Your email address will not be published.').'</span> '.lg('Required fields are marked.').'
      <span class="required">*</span>
    </p>
    <p class="comment-form-author">
      <label for="author">'.lg('Name').' <span class="required">*</span></label><br/>
      <input id="author" name="name" type="text" value="'.@$_SESSION['comment_name'].'" size="30" aria-required="true" required/>
    </p>
    <p class="comment-form-email">
      <label for="email">'.lg('Email').' <span class="required">*</span></label><br/>
      <input id="email" name="email" type="email" value="'.@$_SESSION['comment_email'].'" size="30" aria-describedby="email-notes" aria-required="true" required/>
    </p>
    <p class="comment-form-url">
      <label for="url">'.lg('Website').'</label><br/>
      <input id="url" name="url" type="url" value="'.@$_SESSION['comment_url'].'" size="30" />
    </p>
    <p class="comment-form-comment">
      <label for="comment">'.lg('Comment').'</label><br/>
      <textarea id="comment" name="message" cols="45" rows="8" aria-describedby="form-allowed-tags" aria-required="true" required>'.@$_SESSION['comment_content'].'</textarea>
    </p>
    <p class="comment-form-code">
      <label for="url">'.lg('Code').' *</label><br/>
      <img src="'.$op->site_url.'elybin-core/elybin-captcha.php'.'">
      <input id="code" name="code" type="text" value="" size="5" />
    </p>
    <p class="form-submit">
      <input type="hidden" name="post_id" value="'.epm_encode($p->post_id).'"/>
      <input name="submit" type="submit" id="submit" class="btn submit" value="'.lg('Post Comment').'" />
    </p>
  </form>
 </div><!-- #respond -->';
  /*not used yet
  <p class="form-allowed-tags" id="form-allowed-tags">
    '.sprintf(lg('You may use these %s tags and attributes:'),'<abbr title="HyperText Markup Language">HTML</abbr>').'
    <code>
      &lt;a href=&quot;&quot; title=&quot;&quot;&gt;
      &lt;abbr title=&quot;&quot;&gt;
      &lt;acronym title=&quot;&quot;&gt;
      &lt;b&gt; &lt;blockquote cite=&quot;&quot;&gt;
      &lt;cite&gt; &lt;code&gt;
      &lt;del datetime=&quot;&quot;&gt;
      &lt;em&gt; &lt;i&gt;
      &lt;q cite=&quot;&quot;&gt;
      &lt;strike&gt;
      &lt;strong&gt;
    </code>
  </p>
  */
}
function get_message_old(){
  /**
   * Display proccess reslt Message
   * @since 1.1.4
   */
  if(!empty($_SESSION['msg_code'])) {
     $msg = @$_SESSION['msg_content'];
     $msg_ses = @$_SESSION['msg_ses'];
     $status = @$_SESSION['msg_type'];
     @$_SESSION['msg_content'] = '';
     @$_SESSION['msg_ses'] = '';
     @$_SESSION['msg_type'] = '';

     if($status == 'success'){
        echo '<div id="message"><p class="alert alert-success"><i class="fa fa-check"></i> '.$msg.'</p></div>';
     }
     else if($status == 'warning'){
        echo '<div id="message"><p class="alert alert-warning"><i class="fa fa-warning"></i> '.$msg.'</p></div>';
     }else if($status == 'danger'){
        echo '<div id="danger"><p class="alert alert-danger"><i class="fa fa-times"></i> '.$msg.'</p></div>';
     }
  }
}

// Photo
function the_album_title($before = '', $after = ''){
  /**
   * The title of post data.
   * @since 1.1.4
   */
  global $current_post;
  echo $before.$current_post->album_name.$after;
}
function the_album_description($cut = 400){
  /**
   * The description of post data.
   * @since 1.1.4
   */
  global $current_post;
  echo cutword($current_post->album_description, $cut);
}
function get_album_date($format = 'd F Y'){
  /**
   * The date of post.
   * @since 1.1.4
   */
  echo get_the_album_date($format);
}
function get_the_album_date($format = 'd F Y'){
  /**
   * The date of post.
   * @since 1.1.4
   */
  return date($format, strtotime(get_post()->album_created));
}
function photo_quality($primary = 'md'){
  /**
   * Checking photo quality.
   * @since 1.1.4
   */
   switch ($primary) {
     case 'or':
       $pquality = '';
       break;
     case 'hd':
       $pquality = 'hd-';
       break;
     case 'md':
       $pquality = 'md-';
       break;
     case 'sm':
       $pquality = 'sm-';
       break;
     case 'xs':
       $pquality = 'xs-';
       break;
     default:
       $pquality = '';
       break;
   }
   return $pquality;
}
function get_photo_gallery($args = array()){
  /**
   * Display gallery.
   * @since 1.1.4
   */
  $defaults = array(
    'gallery_id' => 'gallery',
    'gallery_class' => '',
    'album_id' => 'album-{number}',
    'album_class' => 'album',
    'album_show' => 9,
    'album_link' => __('Detail'),
    'album_thumbnail' => 1,
    'album_thumbnail_quality' => 'md',
    'photo_id' => 'photo-{number}',
    'photo_class' => '',
    'photo_link' => __('Detail'),
    'photo_thumbnail_quality' => 'md',
    'photo_per_album' => 50
  );
  $args = el_parse_args($args, $defaults);

  // fill prefix
  if(!empty($args['gallery_id'])){
    $args['gallery_id'] = ' id="'.$args['gallery_id'].'"';
  }
  if(!empty($args['gallery_class'])){
    $args['gallery_class'] = ' class="'.$args['gallery_class'].'"';
  }
  if(!empty($args['album_id'])){
    $args['album_id'] = ' id="'.$args['album_id'].'"';
  }
  if(!empty($args['album_class'])){
    $args['album_class'] = ' class="'.$args['album_class'].'"';
  }
  if(!empty($args['photo_id'])){
    $args['photo_id'] = ' id="'.$args['photo_id'].'"';
  }
  if(!empty($args['photo_class'])){
    $args['photo_class'] = ' class="'.$args['photo_class'].'"';
  }



  $gallery = get_gallery_data($args);
  if($gallery != false){
    if(if_show_photos()){
      echo 'photos';
    }
    else if(if_show_album()){
      // show album
      foreach ($gallery as $g) {
        echo '
        <div'.$args['gallery_id'].$args['gallery_class'].'>
          <div'.$g->no.$args['album_class'].'>
            <h3>'.$g->title.'<h3>
            <p>'.__('Created').': '.$g->created.'</p>';
        foreach ($g->thumbnail as $thum) {
          echo '
            <img src="'.$thum.'" alt="'.__('Failed while loading images').'">';
        }
        echo'
            <a href="'.$g->detail_url.'">'.$args['album_link'].'</a>
          </div>
        </div>
        ';
      }
    }else{
      foreach ($gallery as $g) {
        echo '
        <div'.$args['gallery_id'].$args['gallery_class'].'>
          <div'.$g->no.$args['album_class'].'>
            <h3>'.$g->title.'<h3>
            <p>'.__('Created').': '.$g->created.'</p>';
        foreach ($g->thumbnail as $thum) {
          echo '
            <img src="'.$thum.'" alt="'.__('Failed while loading images').'">';
        }
        echo'
            <a href="'.$g->detail_url.'">'.$args['album_link'].'</a>
          </div>
        </div>
        ';
      }
    }

  }
}
function if_show_album(){
  /**
   * Check showing album or not.
   * @since 1.1.4
   */
  if(whats_opened() == 'album'){
    return true;
  }else{
    return false;
  }
}
function if_show_photos(){
  /**
   * Check showing photo or not.
   * @since 1.1.4
   */
  if(whats_opened() == 'photo'){
    return true;
  }else{
    return false;
  }
}
function have_photos(){
  /**
   * Show photos inside album.
   * @since 1.1.4
   */
   global $in_the_loop2;
   global $in_the_loop_count2;
   global $current_post;

   if(!isset($in_the_loop_count2)){
     $in_the_loop_count2 = 0;
   }
     //var_dump($current_post->photo[1]);
   //var_dump(get_gallery_data()[0]->photo);
   $ll = get_all_post()[0]->photo;
   //var_dump(count($ll));

   if($ll == false){
     return false;
   }else{
     if($in_the_loop_count2 + 1 > count($ll)){
          return false;
     }else{
       $current_post = $ll[$in_the_loop_count2];
          return true;
     }
   }
}
function the_photo(){
  /**
   * Control while loop (2).
   * @since 1.1.4
   */
  global $current_post;
  global $in_the_loop_count2;
  $in_the_loop_count2++;

  return $current_post;
}
function prev_url(){
  /**
   * Previous url of current page.
   * @since 1.1.4
   */

  if( whats_opened('photo') ){
    e( get_url('album', (isset($_GET['album']) ? $_GET['album']: $_GET['album_t']) ) );
  }
  else  if( whats_opened('album-single') ){
    e( get_url('gallery') );
  }

}
function is_photo_single(){
  /**
   * Chceck the post is on list or single opened.
   * @since 1.1.4
   */
   if(whats_opened() == 'gallery'){
     if(isset($_GET['album']) && isset($_GET['photo_id'])){
       return true;
     }
     else{
       return false;
     }
   }else{
     return false;
   }
}

// Old
function count_posts_old(){
  echo "deleted count_post_old()";
  exit;
  /**
   * Counting much posts.
   * @since 1.1.4
   */

   // get post from database
   $tbp = new ElybinTable('elybin_posts');
   // make dicision for search
   $md = @$_GET['mod'];
   if($md == 'search'){
     $v = new ElybinValidasi();
     $q = htmlentities($v->xss($_GET['q']), ENT_QUOTES);

     // get post from database
     $query = "
     SELECT
     `p`.`post_id`,
     `p`.`title`,
     `p`.`content`,
     `p`.`date`,
     `p`.`seotitle`,
     `p`.`image`,
     `p`.`hits`,
     `p`.`comment`,
     `c`.`name` as `category_name`,
     `u`.`fullname` as `author_name`,
     `u`.`avatar` as `author_avatar`,
     `p`.`tag` as `tag_id`
     FROM
     `elybin_posts` as `p`,
     `elybin_users` as `u`,
     `elybin_category` as `c`
     WHERE
     `p`.`type` = 'post' &&
     `p`.`status` = 'publish' &&
     `u`.`user_id` = `p`.`author` &&
     `c`.`category_id` = `p`.`category_id` &&
     ((`p`.`title` LIKE '%$q%') OR (`p`.`content` LIKE '%$q%'))
     ORDER BY
     `p`.`post_id` DESC
     ";
   }else{
     $query = "
     SELECT
     `p`.`post_id`,
     `p`.`title`,
     `p`.`content`,
     `p`.`date`,
     `p`.`seotitle`,
     `p`.`image`,
     `p`.`hits`,
     `p`.`comment`,
     `c`.`name` as `category_name`,
     `u`.`fullname` as `author_name`,
     `u`.`avatar` as `author_avatar`,
     `p`.`tag` as `tag_id`
     FROM
     `elybin_posts` as `p`,
     `elybin_users` as `u`,
     `elybin_category` as `c`
     WHERE
     `p`.`type` = 'post' &&
     `p`.`status` = 'publish' &&
     `u`.`user_id` = `p`.`author` &&
     `c`.`category_id` = `p`.`category_id`
     ORDER BY
     `p`.`post_id` DESC
     ";
   }
   $copt = $tbp->GetRowFullCustom($query);

   // result
  return $copt;
}
function get_post_detail_old($pid = 0, $type = 'post'){
  // get variable
  $v = new ElybinValidasi();
  $id = $v->sql(@$_GET['id']);

  // check post exist or not
  $tbp = new ElybinTable('elybin_posts');
  // if Page
  if($type == 'post'){
    $cop = $tbp->GetRowAnd('status','publish','post_id',$id);
    $que = "
    `p`.`type` = 'post' &&
    `p`.`status` = 'publish' &&
    ";
  }else{
    $cop = $tbp->GetRowAnd('status','active','post_id',$id);
    $que = "
    `p`.`type` = 'page' &&
    `p`.`status` = 'active' &&
    ";
  }

  if($cop == 0){
    $err = new stdClass();
  	$err->error = true;
  	$err->error_msg = lg('404 Not Found');
    return $err;
  	exit;
  }

  // get global option
  $op = _op();

  // get post from database
  $query = "
  SELECT
  `p`.`post_id`,
  `p`.`title`,
  `p`.`content`,
  `p`.`date`,
  `p`.`seotitle`,
  `p`.`image`,
  `p`.`hits`,
  `p`.`comment`,
  `c`.`name` as `category_name`,
  `u`.`fullname` as `author_name`,
  `u`.`avatar` as `author_avatar`,
  `p`.`tag` as `tag_id`
  FROM
  `elybin_posts` as `p`
  LEFT JOIN
  `elybin_users` as `u`
  ON `u`.`user_id` = `p`.`author`
  LEFT JOIN
  `elybin_category` as `c`
  ON `c`.`category_id` = `p`.`category_id`
  WHERE
  $que
  `p`.`post_id` = $id
  ORDER BY
  `p`.`post_id` DESC
  ";

  // execute query
  $p = $tbp->SelectFullCustom($query)->current();

  $tbc = new ElybinTable('elybin_comments');
  $tbt = new ElybinTable('elybin_tag');

  // convert to array
  $result = new stdClass();
  $result = $p;
  // grab another information
  // tag
  $tag_ar[] = '';
  $x = 0;
  if(!empty($p->tag_id)){
    $tag_id_2 = @json_decode($p->tag_id);
    foreach($tag_id_2 as $tid){
      $top = new stdClass();
      // check first, tag exist or not
      if($tbt->GetRow('tag_id', $tid) > 0){
        // and start
        $tt = $tbt->SelectWhere('tag_id', $tid)->current();
        // add
        $top->tag_id = $tt->tag_id;
        $top->tag_name = $tt->name;
        // rewrite style
        if($op->url_rewrite_style == 'static'){
          // static
          $top->tag_url = $op->site_url.'index.php?mod=post&q=tag:'.$tt->tag_id;
        }else{
          $top->tag_url = $op->site_url.'tag-'.$tt->tag_id.'-1-'.$tt->seotitle.'.html';
        }
        // push to array
        $tag_ar[$x] = $top;
        // incre
        $x++;
      }
    }

    // delete empty tag
    $g = 0;
    foreach($tag_ar as $ta){
      if($ta == ''){
        unset($tag_ar[$g]);
      }
      $g++;
    }

    $result->tag = $tag_ar;
    $result->tag_count =  count($tag_ar);
  }else{
    $result->tag_count =  0;
  }
  // unset useless object
  unset($result->tag_id);

  // comment
  $cocom = $tbc->GetRow('post_id',$p->post_id);
  $result->comment_count = $cocom;
  // add comment detail
  $com[] = '';
  $i = 0;
  if($cocom > 0){
    // get comment
    $lcom = $tbc->SelectWhereAnd('post_id', $p->post_id,'status','active');
    foreach ($lcom as $lc) {
      // convert user id to name
      if($lc->user_id > 0){
        $uu = _u($lc->user_id);
        $lc->author = $uu->fullname;
        $lc->email = $uu->user_account_email;

        // if avatar default
        if($uu->avatar !== 'default/no-ava.png'){
          $lc->avatar_md = $op->site_url.'elybin-file/avatar/md-'.$uu->avatar;
          $lc->avatar_hd = $op->site_url.'elybin-file/avatar/'.$uu->avatar;
        }else{
          $lc->avatar_md = $op->site_url.'elybin-file/avatar/default/medium-no-ava.png';
          $lc->avatar_hd = $op->site_url.'elybin-file/avatar/default/no-ava.png';
        }
      }else{
        $lc->avatar_md = $op->site_url.'elybin-file/avatar/default/medium-no-ava.png';
        $lc->avatar_hd = $op->site_url.'elybin-file/avatar/default/no-ava.png';
      }


      // human date
      $c_human_date_a = explode(" ",$lc->date);
      $c_human_date = friendly_date($c_human_date_a[0],'full');
      $c_human_date = $c_human_date.' '.lg('at').' '.substr($c_human_date_a[1],0,5);
      $lc->human_date = $c_human_date;
      // elapsed time
      $lc->elapsed_time = time_elapsed_string($lc->date);


      // compile
      $com[$i] = $lc;
      $i++;
    }
    // make json
    $result->comment_detail = $com;
  }

  // adding more information
  // summary
  $summary = substr(strip_tags(html_entity_decode($p->content)),0,500);
  if(strlen($summary) >= 500) $summary=$summary."...";
  $result->summary = $summary;
  // human date
  $human_date_a = explode(" ",$p->date);
  $human_date = friendly_date($human_date_a[0],'full');
  $human_date = $human_date.' '.lg('at').' '.substr($human_date_a[1],0,5);
  $result->human_date = $human_date;
  // elapsed time
  $result->elapsed_time = time_elapsed_string($p->date);
  // image
  if($p->image == ''){
    $result->image = false;
  }else{
    $result->image_or = $op->site_url.'elybin-file/post/'.$p->image;
    $result->image_hd = $op->site_url.'elybin-file/post/hd-'.$p->image;
    $result->image_md = $op->site_url.'elybin-file/post/md-'.$p->image;
    $result->image_sm = $op->site_url.'elybin-file/post/sm-'.$p->image;
    $result->image_xs = $op->site_url.'elybin-file/post/xs-'.$p->image;
    $result->image = true;
  }
  // keyword
  $result->meta_desc = substr(strip_tags(html_entity_decode($p->content)),0,200);
  $result->meta_keywords = keyword_filter(strip_tags($p->title));
  // post url rewrite style
  if($op->url_rewrite_style == 'static'){
    // static
    $result->detail_url = $op->site_url.'index.php?mod=post&id='.$p->post_id;
  }else{
    $result->detail_url = $op->site_url.'post-'.$p->post_id.'-'.$p->seotitle.'.html';
  }

  // do hits
  do_hits($p->post_id);

  //success
  $result->error = false;

  return $result;
}
function _gettag_old(){
  //geting all post with related tag
  // get variable
  $v = new ElybinValidasi();
  $id = $v->sql(@$_GET['id']);

  // if non numerical
  if(!preg_match("/^[0-9]+$/", $id)){
    $id = 0;
  }

  // get global option
  $op = _op();

  // get post from database
  $query = "
  SELECT
  `p`.`post_id`,
  `p`.`title`,
  `p`.`content`,
  `p`.`date`,
  `p`.`seotitle`,
  `p`.`image`,
  `p`.`hits`,
  `p`.`comment`,
  `c`.`name` as `category_name`,
  `u`.`fullname` as `author_name`,
  `u`.`avatar` as `author_avatar`,
  `p`.`tag` as `tag_id`,
  `t`.`name` as `tag_name`
  FROM
  `elybin_posts` as `p`,
  `elybin_users` as `u`,
  `elybin_category` as `c`,
  `elybin_tag` as `t`
  WHERE
  `p`.`type` = 'post' &&
  `p`.`status` = 'publish' &&
  `p`.`tag` LIKE '%$id%' &&
  `t`.`tag_id` = $id &&
  `u`.`user_id` = `p`.`author` &&
  `c`.`category_id` = `p`.`category_id`
  ORDER BY
  `p`.`post_id` DESC
  ";
  // pagging
  if(empty($_GET['paged']) || $_GET['paged'] < 0){
    $page = 1;
    $query .= "
    LIMIT
    0, ".$op->posts_per_page."
    ";
  }else{
    $page = $_GET['paged'];
    // calculate
    $muchpage = ceil(_counttag()/$op->posts_per_page);

    // if out or range
    if($page > $muchpage){
      $page = 1;
    }

    $postposition = ($page-1)*$op->posts_per_page;
    $query .= "
    LIMIT
    $postposition, ".$op->posts_per_page."
    ";
  }

  // execute query
  $tbp = new ElybinTable('elybin_posts');
  $cpt = $tbp->SelectFullCustom($query);

  $tbc = new ElybinTable('elybin_comments');
  $tbt = new ElybinTable('elybin_tag');

  // convert to array
  $result[] = '';
  $i = 0;
  foreach ($cpt as $p) {
    $result[$i] = $p;

    // grab another information
    // tag
    $tag_ar[] = '';
    $x = 0;
    if(!empty($p->tag_id)){
      $tag_id_2 = @json_decode($p->tag_id);
      foreach($tag_id_2 as $tid){
        $top = new stdClass();
        // check first, tag exist or not
        if($tbt->GetRow('tag_id', $tid) > 0){
          // and start
          $tt = $tbt->SelectWhere('tag_id', $tid)->current();
          // add
          $top->tag_id = $tt->tag_id;
          $top->tag_name = $tt->name;
          // rewrite style
          if($op->url_rewrite_style == 'static'){
            // static
            $top->tag_url = $op->site_url.'index.php?mod=tag&id='.$tt->tag_id;
          }else{
            $top->tag_url = $op->site_url.'tag-'.$tt->tag_id.'-1-'.$tt->seotitle.'.html';
          }
          // push to array
          $tag_ar[$x] = $top;
          // incre
          $x++;
        }
      }

      // delete empty tag
      $g = 0;
      foreach($tag_ar as $ta){
        if($ta == ''){
          unset($tag_ar[$g]);
        }
        $g++;
      }

      $result[$i]->tag = $tag_ar;
      $result[$i]->tag_count =  count($tag_ar);
    }else{
      $result[$i]->tag_count =  0;
    }
    // unset useless object
    unset($result[$i]->tag_id);

    // comment
    $result[$i]->comment_count = $tbc->GetRow('post_id',$p->post_id);
    // adding more information
    // summary
    $summary = substr(strip_tags(html_entity_decode($p->content)),0,500);
    if(strlen($summary) >= 500) $summary=$summary."...";
    $result[$i]->summary = $summary;
    // human date
    $human_date_a = explode(" ",$p->date);
    $human_date = friendly_date($human_date_a[0],'full');
    $human_date = $human_date.' '.lg('at').' '.substr($human_date_a[1],0,5);
    $result[$i]->human_date = $human_date;
    // elapsed time
    $result[$i]->elapsed_time = time_elapsed_string($p->date);
    // image
    if($p->image == ''){
      $result[$i]->image = false;
    }else{
      $result[$i]->image_or = $op->site_url.'elybin-file/post/'.$p->image;
      $result[$i]->image_hd = $op->site_url.'elybin-file/post/hd-'.$p->image;
      $result[$i]->image_md = $op->site_url.'elybin-file/post/md-'.$p->image;
      $result[$i]->image_sm = $op->site_url.'elybin-file/post/sm-'.$p->image;
      $result[$i]->image_xs = $op->site_url.'elybin-file/post/xs-'.$p->image;
      $result[$i]->image = true;
    }
    // post url rewrite style
    if($op->url_rewrite_style == 'static'){
      // static
      $result[$i]->detail_url = $op->site_url.'index.php?mod=post&id='.$p->post_id;
    }else{
      $result[$i]->detail_url = $op->site_url.'post-'.$p->post_id.'-'.$p->seotitle.'.html';
    }
    // ++
    $i++;
  }

  return $result;
}
function _counttag_ld(){
  // get variable
  $v = new ElybinValidasi();
  $id = $v->sql(@$_GET['id']);

  // if non numerical
  if(!preg_match("/^[0-9]+$/", $id)){
    $id = 0;
  }

  // get global option
  $op = _op();

  // get post from database
  $tbp = new ElybinTable('elybin_posts');
  $copt = $tbp->GetRowFullCustom("
  SELECT
  `p`.`post_id`,
  `p`.`title`,
  `p`.`content`,
  `p`.`date`,
  `p`.`seotitle`,
  `p`.`image`,
  `p`.`hits`,
  `p`.`comment`,
  `c`.`name` as `category_name`,
  `u`.`fullname` as `author_name`,
  `u`.`avatar` as `author_avatar`,
  `p`.`tag` as `tag_id`,
  `t`.`name` as `tag_name`
  FROM
  `elybin_posts` as `p`,
  `elybin_users` as `u`,
  `elybin_category` as `c`,
  `elybin_tag` as `t`
  WHERE
  `p`.`type` = 'post' &&
  `p`.`status` = 'publish' &&
  `p`.`tag` LIKE '%$id%' &&
  `t`.`tag_id` = $id &&
  `u`.`user_id` = `p`.`author` &&
  `c`.`category_id` = `p`.`category_id`
  ORDER BY
  `p`.`post_id` DESC
  ");

  return $copt;
}
function get_gallery_data_old($args = array()){
  /**
   * Getting photos from database.
   * @since 1.1.4
   */
  global $op;

  $defaults = array(
    'gallery_id' => 'gallery',
    'gallery_class' => '',
    'album_id' => 'album-{number}',
    'album_class' => 'album',
    'album_show' => 9,
    'album_link' => __('Detail'),
    'album_thumbnail' => 1,
    'album_thumbnail_quality' => 'md',
    'photo_id' => 'photo-{number}',
    'photo_class' => '',
    'photo_link' => __('Detail'),
    'photo_thumbnail_quality' => 'md',
    'photo_per_album' => 50
  );
  $args = el_parse_args($args, $defaults);
  // single photo
  $v = new ElybinValidasi();
  if(is_photo_single()){
    $pid = $v->sql(@$_GET['photo_id']);
    $single_photo = "&& `r`.`second_id` = $pid";
  }else{
    $single_photo = "";
  }
  $tb = new ElybinTable('elybin_posts');
  if(is_single()){
    $aid = $v->sql(@$_GET['album_id']);
    $coa = $tb->GetRowAnd('status','active','post_id', $aid);
  }else {
    $coa = $tb->GetRow('status','active');
  }

  if($coa > 0){
    // get list of album
    if(if_show_album()){
      $v = new ElybinValidasi();
      $aid = $v->sql(@$_GET['album_id']);
      $cal = $tb->SelectFullCustom("
      SELECT
      *
      FROM
      `elybin_album` as `a`
      WHERE
      `a`.`status` = 'active' &&
      `a`.`album_id` = $aid
      ");
    }else{
      $cal = $tb->SelectFullCustom("
      SELECT
      *
      FROM
      `elybin_album` as `a`
      WHERE
      `a`.`status` = 'active'
      ");
    }
    $i = 0;
    foreach ($cal as $a) {
      // put them inside obj
      $album[$i] = new stdClass();
      $album[$i]->no = str_replace('{number}', $i+1, $args['album_id']);
      $album[$i]->album_id = $a->album_id;
      $album[$i]->title = $a->name;
      $album[$i]->date = friendly_date($a->date,'full');
      // rewrite style
      if($op->url_rewrite_style == 'static'){
        // static
        $album[$i]->detail_url = $op->site_url.'index.php?mod=gallery&album_id='.$a->album_id;
      }else{
        $album[$i]->detail_url = $op->site_url.'gallery-'.$a->album_id.'-'.$a->seotitle.'.html';
      }
      // related photos
      $tb = new ElybinTable('elybin_relation');
      $coph = $tb->GetRowAnd('type','album','first_id', $a->album_id);
      if($coph > 0){
        //quet
        $que = "
        SELECT
        *
        FROM
        `elybin_relation` as `r`
        LEFT JOIN
        `elybin_media` as `m`
        ON `m`.`media_id` = `r`.`second_id`
        WHERE
        `r`.`first_id` = ".$a->album_id." &&
        `r`.`type` = 'album'  &&
        `r`.`target` = 'media'
        $single_photo
        ";
        // check existance
        $coph = $tb->GetRowFullCustom($que);
        if($coph < 1){
          return false;
          exit;
        }
        $cph = $tb->SelectFullCustom($que);
        $j = 0;
        foreach($cph as $cp) {
          $photo[$j] = new stdClass();
          $photo[$j]->no = str_replace('{number}', $j+1, $args['photo_id']);
          $photo[$j]->photo_id = $cp->media_id;
          $photo[$j]->title = $cp->title;
          $photo[$j]->description = $cp->description;
          $photo[$j]->date = friendly_date($cp->date,'full');
          $photo[$j]->viewed = $cp->download;
          // rewrite style
          if($op->url_rewrite_style == 'static'){
            // static
            $photo[$j]->detail_url = $op->site_url.'index.php?mod=gallery&album_id='.$a->album_id.'&photo_id='.$cp->media_id;
          }else{
            $photo[$j]->detail_url = $op->site_url.'photo-'.$a->album_id.'-'.$cp->media_id.'-'.seo_title($cp->title).'.html';
          }
          // photo quality
          $photo[$j]->thumbnail[] = $op->site_url.'elybin-file/media/'.photo_quality($args['photo_thumbnail_quality']).$cp->filename;
          if($j < $args['album_thumbnail']){
            $album[$i]->thumbnail[] = $op->site_url.'elybin-file/media/'.photo_quality($args['album_thumbnail_quality']).$cp->filename;
          }
          $j++;
        }
        // put those into $album
        $album[$i]->photo = $photo;
      }else{
        $album[$i]->photo = false;
        $album[$i]->thumbnail[] = $op->site_url.'elybin-file/system/no-preview-default.png';
      }
      $i++;
    }
    return($album);
  }else{
    return false;
  }
}


// This script must be here
function include_custom_tags(){
  /**
   * Additional custom function tags.
   * @since 1.1.4
   */
  if(file_exists(get_template_directory_uri().'/function.php')){
    include(get_template_directory_uri().'/function.php');
  }
  if(file_exists(get_template_directory_uri().'/inc/template-tags.php')){
    include(get_template_directory_uri().'/inc/template-tags.php');
  }
} include_custom_tags(); // run it
