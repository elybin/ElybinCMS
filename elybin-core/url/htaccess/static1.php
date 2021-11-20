<?php
/**
 * Htaccess template.
 * content begin after character /* * *  ("slash with three stars") and without closing
 *
 * @package   Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @author		Khakim <elybin.inc@gmail.com>
 * @since     Elybin 1.1.4
 */

/***
# `.htaccess`
# If you see this error, copy paste script below and manually create this file.
# Directory: your_root_website/.htaccess
# After that, refresh this page
#
# @package   Elybin CMS (www.elybin.github.io) - Open Source Content Management System
# @author		Khakim <elybin.inc@gmail.com>

<IfModule mod_rewrite.c>
RewriteEngine on
# RewriteRule ^$ index.php [L]
RewriteRule ^rss/$ index.php?feed=rss [L]
RewriteRule ^atom/$ index.php?feed=atom [L]

RewriteRule ^page/([0-9]+)$ index.php?paged=$1 [L]
RewriteRule ^page/([0-9]+)/$ index.php?paged=$1 [L]

RewriteRule ^article/([a-z0-9-]+)$ index.php?pt=$1 [L]
RewriteRule ^article/([a-z0-9-]+)/$ index.php?pt=$1 [L]
RewriteRule ^article/([a-z0-9-]+)/rss/$ index.php?pt=$1&feed=rss [L]
RewriteRule ^article/([a-z0-9-]+)/atom/$ index.php?pt=$1&feed=atom [L]


RewriteRule ^category/([a-z0-9-]+)/$ index.php?cat_t=$1 [L]
RewriteRule ^category/([a-z0-9-]+)/page/([0-9]+)/$ index.php?cat_t=$1&paged=$2 [L]

RewriteRule ^tag/([a-z0-9-]+)/$ index.php?tag=$1 [L]
RewriteRule ^tag/([a-z0-9-]+)/page/([0-9]+)/$ index.php?tag=$1&paged=$2 [L]

RewriteRule ^author/([a-z0-9-]+)-([0-9]+)/$ index.php?author=$2 [L]
RewriteRule ^author/([a-z0-9-]+)-([0-9]+)/page/([0-9]+)/$ index.php?author=$2&paged=$3 [L]

RewriteRule ^gallery/$ index.php?album [L]
RewriteRule ^gallery/page/([0-9]+)/$ index.php?album&paged=$1 [L]
RewriteRule ^gallery/([a-z0-9-]+)/$ index.php?album_t=$1 [L]
RewriteRule ^gallery/([a-z0-9-]+)/page/([0-9]+)/$ index.php?album_t=$1&paged=$2 [L]

RewriteRule ^gallery/([a-z0-9-]+)/([a-z0-9-]+)/$ index.php?album_t=$1&photo_t=$2 [L]
RewriteRule ^gallery/([a-z0-9-]+)/([a-z0-9-]+)/download/$ index.php?album_t=$1&photo_t=$2&download [L]

RewriteRule ^apps/$ index.php [L]
RewriteRule ^apps/([a-z0-9-_]+)/$ index.php?apps=$1 [L]
RewriteRule ^apps/([a-z0-9-_]+)/([a-z0-9-_/]+)$ index.php?apps=$1&apps_page=$2 [L]
RewriteRule ^apps/([a-z0-9-_]+)/([a-z0-9-_/]+)&clear$ index.php?apps=$1&apps_page=$2&clear [L]

RewriteRule ^([0-9]{4})/$ index.php?m=$1 [L]
RewriteRule ^([0-9]{4})/page/([0-9]+)/$ index.php?m=$1&paged=$2 [L]
RewriteRule ^([0-9]{4})/([0-9]{2})/$ index.php?m=$1$2 [L]
RewriteRule ^([0-9]{4})/([0-9]{2})/page/([0-9]+)/$ index.php?m=$1$2&paged=$3 [L]
RewriteRule ^([0-9]{4})/([0-9]{2})/([0-9]{2})/$ index.php?m=$1$2$3 [L]
RewriteRule ^([0-9]{4})/([0-9]{2})/([0-9]{2})/page/([0-9]+)/$ index.php?m=$1$2$3&paged=$4 [L]

RewriteRule ^([a-z0-9]+)/$ index.php?media=$1 [L]
RewriteRule ^([a-z0-9]+)/([a-z]{1})/$ index.php?media=$1&mode=$2 [L]

RewriteRule ^([a-z0-9-]+)/$ index.php?page_t=$1 [L]

RewriteRule ^sitemap\.xml$ index.php?sitemap [L]
RewriteRule ^404/$ index.php?404 [L]
RewriteRule ^403/$ index.php?403 [L]

</IfModule>
