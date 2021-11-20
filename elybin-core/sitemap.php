<?php
/**
 * Generating full xml sitemap.
 *
 * @package   Elybin CMS (www.elybin.github.io) - Open Source Content Management System
 * @author		Khakim <elybin.inc@gmail.com>
 */
 
header('Content-Type: application/xml');
echo '<?xml version="1.0" encoding="UTF-8"?>'."\n";
?>
<urlset
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<?php foreach (get_sitemap_xml() as $key => $value) { ?>
  <url>
    <loc><?php e($value->loc) ?></loc>
    <lastmod><?php e($value->lastmod) ?></lastmod>
    <changefreq><?php e($value->changefreq) ?></changefreq>
    <priority><?php e($value->priority) ?></priority>
  </url>
<?php } ?>
</urlset>
