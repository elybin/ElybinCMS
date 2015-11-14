<?php
/**
 * This is url composer to produce standard url.
 *
 * @package   Elybin CMS (www.elybin.com) - Open Source Content Management System
 * @author		Khakim A <kim@elybin.com>
 * @since     1.1.4
 */

//////////////////////////////////
///         Detail Info       ////
//////////////////////////////////
$info = array(
  'style_id'        => 'dynamic',
  'style_name'      => __('Dynamic'),
  'style_author'    => 'Elybin CMS <hi@elybin.com>',
  'style_version'   => '1.0',
  'htaccess'        => false,
  'htaccess_name'   => ''
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
  'paged'     => '%site_url%?paged=%paged%',
  'preview'   => 'http://www.elybin.com/'
);

/**
 * Section  : Post
 * Identifer: post
 * require  : post_id
 * Return   : http://www.elybin.com/?p=1
 */
$url[] = array(
  'section'   => 'post',
  'template'  => '%site_url%?p=%post_id%',
  'preview'   => 'http://www.elybin.com/?p=1'
);

/**
 * Section  : Page
 * Identifer: page
 * require  : page_id
 * Return   : http://www.elybin.com/?page_id=1
 */
$url[] = array(
  'section'   => 'page',
  'template'  => '%site_url%?page_id=%page_id%',
  'preview'   => 'http://www.elybin.com/?page_id=1'
);

/**
 * Section  : Category
 * Identifer: category
 * require  : cat_id
 * Return   : http://www.elybin.com/?cat=1
 */
$url[] = array(
  'section'   => 'category',
  'template'  => '%site_url%?cat=%cat_id%',
  'paged'     => '%site_url%?cat=%cat_id%&paged=%paged%',
  'preview'   => 'http://www.elybin.com/?cat=1'
);

/**
 * Section  : Tag
 * Identifer: tag
 * require  : tag_seo
 * Return   : http://www.elybin.com/?tag=general
 */
$url[] = array(
  'section'   => 'tag',
  'template'  => '%site_url%?tag=%tag_seo%',
  'paged'     => '%site_url%?tag=%tag_seo%&paged=%paged%',
  'preview'   => 'http://www.elybin.com/?tag=general'
);

/**
 * Section  : Author
 * Identifer: author
 * require  : author_id
 * Return   : http://www.elybin.com/?author=1
 */
$url[] = array(
  'section'   => 'author',
  'template'  => '%site_url%?author=%author_id%',
  'paged'     => '%site_url%?author=%author_id%&paged=%paged%',
  'preview'   => 'http://www.elybin.com/?author=1'
);

/**
 * Section  : Gallery
 * Identifer: gallery
 * require  : none
 * Return   : http://www.elybin.com/?album
 */
$url[] = array(
  'section'   => 'gallery',
  'template'  => '%site_url%?album',
  'paged'     => '%site_url%?album&paged=%paged%',
  'preview'   => 'http://www.elybin.com/?album'
);

/**
 * Section  : Album
 * Identifer: album
 * require  : album_id
 * Return   : http://www.elybin.com/?album=1
 */
$url[] = array(
  'section'   => 'album',
  'template'  => '%site_url%?album=%album_id%',
  'paged'     => '%site_url%?album=%album_id%&paged=%paged%',
  'preview'   => 'http://www.elybin.com/?album=1'
);

/**
 * Section  : Photo
 * Identifer: photo
 * require  : album_id, photo_id
 * Return   : http://www.elybin.com/?album=1&photo=1
 */
$url[] = array(
  'section'   => 'photo',
  'template'  => '%site_url%?album=%album_id%&photo=%photo_id%',
  'preview'   => 'http://www.elybin.com/?album=1&photo=1'
);

/**
 * Section  : Archives
 * Identifer: archive
 * require  : year, month, day
 * Return   : http://www.elybin.com/?m=20151021
 *            http://www.elybin.com/?m=201510
 *            http://www.elybin.com/?m=2015
 */
$url[] = array(
  'section'   => 'archive',
  'template'  => '%site_url%?m=%year%%month%%day%',
  'template2' => '%site_url%?m=%year%%month%',
  'template3' => '%site_url%?m=%year%',
  'paged'     => '%site_url%?m=%year%%month%%day%&paged=%paged%',
  'paged2'    => '%site_url%?m=%year%%month%&paged=%paged%',
  'paged3'    => '%site_url%?m=%year%&paged=%paged%',
  'preview'   => 'http://www.elybin.com/?m=20151021'
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
  'paged'  => '%site_url%?s=%keywords%&paged=%paged%',
  'preview'   => 'http://www.elybin.com/?s=keywords'
);

/**
 * Section  : Sitemap
 * Identifer: sitemap
 * require  : none
 * Return   : http://www.elybin.com/?sitemap
 */
$url[] = array(
  'section'   => 'sitemap',
  'template'  => '%site_url%?sitemap',
  'preview'   => 'http://www.elybin.com/?sitemap'
);

/**
 * Section  : Sitemap XML
 * Identifer: sitemap-xml
 * require  : none
 * Return   : http://www.elybin.com/?sitemap-xml
 */
$url[] = array(
  'section'   => 'sitemap-xml',
  'template'  => '%site_url%?sitemap-xml',
  'preview'   => 'http://www.elybin.com/?sitemap-xml'
);

/**
 * Section  : 404 Not Found
 * Identifer: 404
 * require  : none
 * Return   : http://www.elybin.com/?404
 */
$url[] = array(
  'section'   => '404',
  'template'  => '%site_url%?404',
  'preview'   => 'http://www.elybin.com/?404'
);

/**
 * Section  : 403 Access Denied
 * Identifer: 403
 * require  : none
 * Return   : http://www.elybin.com/?403
 */
$url[] = array(
  'section'   => '403',
  'template'  => '%site_url%?403',
  'preview'   => 'http://www.elybin.com/?403'
);

/**
 * Section  : 500 Internal Server Error
 * Identifer: 500
 * require  : none
 * Return   : http://www.elybin.com/?500
 */
$url[] = array(
  'section'   => '500',
  'template'  => '%site_url%?500',
  'preview'   => 'http://www.elybin.com/?500'
);

/**
 * Section  : Maintenance
 * Identifer: maintenance
 * require  : none
 * Return   : http://www.elybin.com/?maintenance
 */
$url[] = array(
  'section'   => 'maintenance',
  'template'  => '%site_url%?maintenance',
  'preview'   => 'http://www.elybin.com/?maintenance'
);

/**
 * Section  : Error
 * Identifer: error
 * require  : none
 * Return   : http://www.elybin.com/?error
 */
$url[] = array(
  'section'   => 'error',
  'template'  => '%site_url%?error',
  'preview'   => 'http://www.elybin.com/?error'
);

/**
 * Section  : Blocked
 * Identifer: blocked
 * require  : none
 * Return   : http://www.elybin.com/?blocked
 */
$url[] = array(
  'section'   => 'blocked',
  'template'  => '%site_url%?blocked',
  'preview'   => 'http://www.elybin.com/?blocked'
);

/**
 * Section  : Atom
 * Identifer: atom
 * require  : none
 * Return   : http://www.elybin.com/?feed=atom
 */
$url[] = array(
  'section'   => 'atom',
  'template'  => '%site_url%?feed=atom',
  'preview'   => 'http://www.elybin.com/?feed=atom'
);

/**
 * Section  : Comment Atom
 * Identifer: comment-atom
 * require  : none
 * Return   : http://www.elybin.com/?feed=comment-atom
 */
$url[] = array(
  'section'   => 'comment-atom',
  'template'  => '%site_url%?feed=comment-atom',
  'preview'   => 'http://www.elybin.com/?feed=comment-atom'
);

/**
 * Section  : Post Atom
 * Identifer: post-atom
 * require  : post_id
 * Return   : http://www.elybin.com/?feed=post-atom&p=1
 */
$url[] = array(
  'section'   => 'post-atom',
  'template'  => '%site_url%?feed=atom&p=%post_id%',
  'preview'   => 'http://www.elybin.com/?p=1&feed=post-atom'
);

/**
 * Section  : RSS
 * Identifer: rss
 * require  : none
 * Return   : http://www.elybin.com/?feed=rss
 */
$url[] = array(
  'section'   => 'rss',
  'template'  => '%site_url%?feed=rss',
  'preview'   => 'http://www.elybin.com/?feed=rss'
);

/**
 * Section  : Comment RSS
 * Identifer: comment-rss
 * require  : none
 * Return   : http://www.elybin.com/?feed=comment-rss
 */
$url[] = array(
  'section'   => 'comment-rss',
  'template'  => '%site_url%?feed=comment-rss',
  'preview'   => 'http://www.elybin.com/?feed=comment-rss'
);

/**
 * Section  : Post RSS
 * Identifer: post-rss
 * require  : post_id
 * Return   : http://www.elybin.com/?feed=post-rss
 */
$url[] = array(
  'section'   => 'post-rss',
  'template'  => '%site_url%?feed=rss&p=%post_id%',
  'preview'   => 'http://www.elybin.com/?p=1&feed=rss'
);

/**
 * Section  : Login
 * Identifer: login
 * require  : none
 * Return   : http://www.elybin.com/?login
 */
$url[] = array(
  'section'   => 'login',
  'template'  => '%site_url%?login',
  'preview'   => 'http://www.elybin.com/?login'
);

/**
 * Section  : Register
 * Identifer: register
 * require  : none
 * Return   : http://www.elybin.com/?register
 */
$url[] = array(
  'section'   => 'register',
  'template'  => '%site_url%?register',
  'preview'   => 'http://www.elybin.com/?register'
);

/**
 * Section  : Forgot
 * Identifer: forgot
 * require  : none
 * Return   : http://www.elybin.com/?forgot
 */
$url[] = array(
  'section'   => 'forgot',
  'template'  => '%site_url%?forgot',
  'preview'   => 'http://www.elybin.com/?forgot'
);
/**
 * Section  : Media
 * Identifer: media
 * require  : media_hash, media_mode
 * Return   : http://www.elybin.com/?media=4c1255e28541fba04f67544d0ec23f0d&mode=d
 */
$url[] = array(
  'section'   => 'media',
  'template'  => '%site_url%?media=%media_hash%&mode=%media_mode%',
  'preview'   => 'http://www.elybin.com/?media=4c1255e28541fba04f67544d0ec23f0d&mode=d'
);

/**
 * Section  : Apps Page
 * Identifer: apps
 * require  : apps_slug, apps_page_slug
 * Return   : http://www.elybin.com/?apps=photo_contest&apps_page=register
 */
$url[] = array(
  'section'   => 'apps',
  'template'  => '%site_url%?apps=%apps_slug%&apps_page=%apps_page_slug%',
  'preview'   => 'http://www.elybin.com/?apps=photo_contest&apps_page=register'
);
