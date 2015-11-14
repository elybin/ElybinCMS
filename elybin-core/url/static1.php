<?php
/**
 * This is url composer to produce static url.
 *
 * @package   Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @author		Khakim A <kim@elybin.com>
 * @since     1.1.4
 */

//////////////////////////////////
///         Detail Info       ////
//////////////////////////////////
$info = array(
  'style_id'        => 'static1',
  'style_name'      => __('Static 1'),
  'style_author'    => 'Elybin CMS <hi@elybin.com>',
  'style_version'   => '1.0',
  'htaccess'        => true,
  'htaccess_name'   => 'static1.php'
);

//////////////////////////////////
///         Style Start       ////
//////////////////////////////////
/**
 * Section  : Home
 * Identifer: home
 * require  : none
 * Return   : http://www.elybin.com/
 */
$url[] = array(
  'section'   => 'home',
  'template'  => '%site_url%',
  'paged'  => '%site_url%page/%paged%/',
  'preview'   => 'http://www.elybin.com/'

);

/**
 * Section  : Post
 * Identifer: post
 * require  : post_seo
 * Return   : http://www.elybin.com/article/the-post-seo-title/
 */
$url[] = array(
  'section'   => 'post',
  'template'  => '%site_url%article/%post_seo%/',
  'preview'   => 'http://www.elybin.com/article/the-post-seo-title/'
);

/**
 * Section  : Page
 * Identifer: page
 * require  : page_seo
 * Return   : http://www.elybin.com/the-page/
 */
$url[] = array(
  'section'   => 'page',
  'template'  => '%site_url%%page_seo%/',
  'preview'   => 'http://www.elybin.com/the-page-seo-title/'
);

/**
 * Section  : Category
 * Identifer: category
 * require  : cat_seo
 * Return   : http://www.elybin.com/category/technology/
 */
$url[] = array(
  'section'   => 'category',
  'template'  => '%site_url%category/%cat_seo%/',
  'paged'     => '%site_url%category/%cat_seo%/page/%paged%/',
  'preview'   => 'http://www.elybin.com/category/technology/'
);

/**
 * Section  : Tag
 * Identifer: tag
 * require  : tag_seo
 * Return   : http://www.elybin.com/tag/epic/
 */
$url[] = array(
  'section'   => 'tag',
  'template'  => '%site_url%tag/%tag_seo%/',
  'paged'     => '%site_url%tag/%tag_seo%/page/%paged%/',
  'preview'   => 'http://www.elybin.com/tag/epic/'
);

/**
 * Section  : Author
 * Identifer: author
 * require  : author_id, author_seo
 * Return   : http://www.elybin.com/author/tony-hawk-1/
 */
$url[] = array(
  'section'   => 'author',
  'template'  => '%site_url%author/%author_seo%-%author_id%/',
  'paged'     => '%site_url%author/%author_seo%-%author_id%/page/%paged%/',
  'preview'   => 'http://www.elybin.com/author/tony-hawk-1/'
);

/**
 * Section  : Gallery
 * Identifer: gallery
 * require  : none
 * Return   : http://www.elybin.com/gallery/
 */
$url[] = array(
  'section'   => 'gallery',
  'template'  => '%site_url%gallery/',
  'paged'     => '%site_url%gallery/page/%paged%/',
  'preview'   => 'http://www.elybin.com/gallery/'
);

/**
 * Section  : Album
 * Identifer: album
 * require  : album_seo
 * Return   : http://www.elybin.com/gallery/dieng-trip/
 */
$url[] = array(
  'section'   => 'album',
  'template'  => '%site_url%gallery/%album_seo%/',
  'paged'     => '%site_url%gallery/%album_seo%/page/%paged%/',
  'preview'   => 'http://www.elybin.com/gallery/dieng-trip/'
);

/**
 * Section  : Photo
 * Identifer: photo
 * require  : album_seo, photo_seo
 * Return   : http://www.elybin.com/gallery/dieng-trip/best-sunrise-spot-ever-sikunir//
 */
$url[] = array(
  'section'   => 'photo',
  'template'  => '%site_url%gallery/%album_seo%/%photo_seo%/',
  'preview'   => 'http://www.elybin.com/gallery/dieng-trip/best-sunrise-spot-ever-sikunir/'
);

/**
 * Section  : Archives
 * Identifer: archive
 * require  : year, month, day
 * Return   : http://www.elybin.com/2015/10/21/
 *            http://www.elybin.com/2015/10/
 *            http://www.elybin.com/2015/
 */
$url[] = array(
  'section'   => 'archive',
  'template'  => '%site_url%%year%/%month%/%day%/',
  'template2' => '%site_url%%year%/%month%/',
  'template3' => '%site_url%%year%/',
  'paged'     => '%site_url%%year%/%month%/%day%/page/%paged%/',
  'paged2'    => '%site_url%%year%/%month%/page/%paged%/',
  'paged3'    => '%site_url%%year%/page/%paged%/',
  'preview'   => 'http://www.elybin.com/2015/10/21/'
);

/**
 * Section  : Search
 * Identifer: search
 * require  : keywords
 * Return   : http://www.elybin.com/?s=keywords
 */
$url[] = array(
  'section'   => 'search',
  'template'  => '%site_url%?s=%keywords%',
  'paged'     => '%site_url%?s=%keywords%&paged=%paged%',
  'preview'   => 'http://www.elybin.com/?s=keywords'
);

/**
 * Section  : Sitemap
 * Identifer: sitemap
 * require  : none
 * Return   : http://www.elybin.com/sitemap/
 */
$url[] = array(
  'section'   => 'sitemap',
  'template'  => '%site_url%sitemap/',
  'preview'   => 'http://www.elybin.com/sitemap/'
);

/**
 * Section  : Sitemap XML
 * Identifer: sitemap-xml
 * require  : none
 * Return   : http://www.elybin.com/sitemap.xml
 */
$url[] = array(
  'section'   => 'sitemap-xml',
  'template'  => '%site_url%sitemap.xml',
  'preview'   => 'http://www.elybin.com/sitemap.xml'
);

/**
 * Section  : 404 Not Found
 * Identifer: 404
 * require  : none
 * Return   : http://www.elybin.com/404/
 */
$url[] = array(
  'section'   => '404',
  'template'  => '%site_url%404/',
  'preview'   => 'http://www.elybin.com/404/'
);

/**
 * Section  : 403 Access Denied
 * Identifer: 403
 * require  : none
 * Return   : http://www.elybin.com/403/
 */
$url[] = array(
  'section'   => '403',
  'template'  => '%site_url%403/',
  'preview'   => 'http://www.elybin.com/403/'
);

/**
 * Section  : 500 Internal Server Error
 * Identifer: 500
 * require  : none
 * Return   : http://www.elybin.com/500/
 */
$url[] = array(
  'section'   => '500',
  'template'  => '%site_url%500/',
  'preview'   => 'http://www.elybin.com/500/'
);

/**
 * Section  : Maintenance
 * Identifer: maintenance
 * require  : none
 * Return   : http://www.elybin.com/maintenance/
 */
$url[] = array(
  'section'   => 'maintenance',
  'template'  => '%site_url%maintenance/',
  'preview'   => 'http://www.elybin.com/maintenance/'
);

/**
 * Section  : Error
 * Identifer: error
 * require  : none
 * Return   : http://www.elybin.com/error/
 */
$url[] = array(
  'section'   => 'error',
  'template'  => '%site_url%error/',
  'preview'   => 'http://www.elybin.com/error/'
);

/**
 * Section  : Blocked
 * Identifer: blocked
 * require  : none
 * Return   : http://www.elybin.com/blocked/
 */
$url[] = array(
  'section'   => 'blocked',
  'template'  => '%site_url%blocked/',
  'preview'   => 'http://www.elybin.com/blocked/'
);

/**
 * Section  : Atom
 * Identifer: atom
 * require  : none
 * Return   : http://www.elybin.com/atom/
 */
$url[] = array(
  'section'   => 'atom',
  'template'  => '%site_url%atom/',
  'preview'   => 'http://www.elybin.com/atom/'
);

/**
 * Section  : Comment Atom
 * Identifer: comment-atom
 * require  : none
 * Return   : http://www.elybin.com/comment/atom/
 */
$url[] = array(
  'section'   => 'comment-atom',
  'template'  => '%site_url%comment/atom/',
  'preview'   => 'http://www.elybin.com/comment/atom/'
);

/**
 * Section  : Post Atom
 * Identifer: post-atom
 * require  : post_seo
 * Return   : http://www.elybin.com/article/10-magic-trick-for-akward-moment/atom/
 */
$url[] = array(
  'section'   => 'post-atom',
  'template'  => '%site_url%article/%post_seo%/atom/',
  'preview'   => 'http://www.elybin.com/article/10-magic-trick-for-akward-moment/atom/'
);

/**
 * Section  : RSS
 * Identifer: rss
 * require  : none
 * Return   : http://www.elybin.com/rss/
 */
$url[] = array(
  'section'   => 'rss',
  'template'  => '%site_url%rss/',
  'preview'   => 'http://www.elybin.com/rss/'
);

/**
 * Section  : Comment RSS
 * Identifer: comment-rss
 * require  : none
 * Return   : http://www.elybin.com/comment/rss/
 */
$url[] = array(
  'section'   => 'comment-rss',
  'template'  => '%site_url%comment/rss/',
  'preview'   => 'http://www.elybin.com/comment/rss/'
);

/**
 * Section  : Post RSS
 * Identifer: post-rss
 * require  : post_seo
 * Return   : http://www.elybin.com/article/10-magic-trick-for-akward-moment/rss/
 */
$url[] = array(
  'section'   => 'post-rss',
  'template'  => '%site_url%article/%post_seo%/rss/',
  'preview'   => 'http://www.elybin.com/article/10-magic-trick-for-akward-moment/rss/'
);

/**
 * Section  : Login
 * Identifer: login
 * require  : none
 * Return   : http://www.elybin.com/login/
 */
$url[] = array(
  'section'   => 'login',
  'template'  => '%site_url%login/',
  'preview'   => 'http://www.elybin.com/login/'
);

/**
 * Section  : Register
 * Identifer: register
 * require  : none
 * Return   : http://www.elybin.com/register/
 */
$url[] = array(
  'section'   => 'register',
  'template'  => '%site_url%register/',
  'preview'   => 'http://www.elybin.com/register/'
);

/**
 * Section  : Forgot
 * Identifer: forgot
 * require  : none
 * Return   : http://www.elybin.com/forgot/
 */
$url[] = array(
  'section'   => 'forgot',
  'template'  => '%site_url%forgot/',
  'preview'   => 'http://www.elybin.com/forgot/'
);

/**
 * Section  : Media
 * Identifer: media
 * require  : media_hash, media_mode
 * Return   : http://www.elybin.com/media/4c1255e28541fba04f67544d0ec23f0d/d/
 */
$url[] = array(
  'section'   => 'media',
  'template'  => '%site_url%media/%media_hash%/%media_mode%/',
  'preview'   => 'http://www.elybin.com/media/4c1255e28541fba04f67544d0ec23f0d/d/'
);

/**
 * Section  : Apps Page
 * Identifer: apps
 * require  : apps_slug, apps_page_slug
 * Return   : http://www.elybin.com/apps/photo_contest/register
 */
$url[] = array(
  'section'   => 'apps',
  'template'  => '%site_url%apps/%apps_slug%/%apps_page_slug%',
  'preview'   => 'http://www.elybin.com/apps/photo_contest/register'
);
