<?php
	header('Content-Type: text/plain');
	if (isset($_SERVER['HTTP_USER_AGENT']) && preg_match('/google|bot|crawl|slurp|spider/i', $_SERVER['HTTP_USER_AGENT'])) {
		// ok
	}
	else {
		echo "# robots.txt";
		exit;
	}
?>
User-agent: baiduspider
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/


User-agent: Bingbot
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/


User-agent: Googlebot
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/

User-agent: ia_archiver
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/

User-agent: msnbot
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/

User-agent: Naverbot
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/

User-agent: seznambot
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/

User-agent: Slurp
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/

User-agent: teoma
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/

User-agent: Yandex
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/

User-agent: Yeti
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/

User-agent: *
Disallow: /elybin-install/
Disallow: /elybin-upgrade/
Disallow: /elybin-admin/
Disallow: /elybin-file/backup/
Disallow: /elybin-core/
Disallow: /elybin-main/
Allow: /
Allow: /feed/news
Allow: /feed/comment
Allow: /atom/news
Allow: /atom/comment

Sitemap: /sitemap.xml