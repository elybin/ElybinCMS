CREATE TABLE IF NOT EXISTS `com.elybin_subscribe` (
  `subscribe_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`subscribe_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `elybin_album` (
  `album_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


INSERT INTO `elybin_album` (`album_id`, `name`, `seotitle`, `date`, `status`) VALUES
(1, 'Nature', 'nature', '2014-07-17', 'active'),
(2, 'Travel', 'travel', '2014-09-03', 'active');


CREATE TABLE IF NOT EXISTS `elybin_category` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;


INSERT INTO `elybin_category` (`category_id`, `name`, `seotitle`, `status`) VALUES
(1, 'Umum', 'umum', 'active'),
(3, 'Travel', 'travel', 'active'),
(4, 'Kuliner', 'kuliner', 'active');



CREATE TABLE IF NOT EXISTS `elybin_comments` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `content` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'deactive',
  `post_id` int(10) NOT NULL,
  `gallery_id` int(10) NOT NULL,
  `user_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;



INSERT INTO `elybin_comments` (`comment_id`, `author`, `email`, `ip`, `date`, `time`, `content`, `status`, `post_id`, `gallery_id`, `user_id`) VALUES
(1, '', '', '127.0.0.1', '2014-11-18', '20:46:19', 'Indonesia memang punya berjuta juta kekayaan yang patut kita banggakan :)', 'active', 3, 0, 1);



CREATE TABLE IF NOT EXISTS `elybin_contact` (
  `contact_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


CREATE TABLE IF NOT EXISTS `elybin_gallery` (
  `gallery_id` int(10) NOT NULL AUTO_INCREMENT,
  `album_id` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;



INSERT INTO `elybin_gallery` (`gallery_id`, `album_id`, `image`, `date`, `name`, `description`) VALUES
(1, 1, 'pesona-gunung-prau-2565-elybin-cms-3171.jpg', '2014-11-18', 'Pesona Gunung Prau 2.565', 'Gunung Prau yang berada di Dataran Tinggi Dieng ini meliputi wilayah Kab. Banjarnegara, Kab. Wonosobo, Kab. Batang dan Kab. Kendal. Gunung Prau atau Prahu memang pendek, kadang hanya dilirik sebelah mata oleh pendaki Indonesia, tapi coba rasakan sensasi dalam pelukannya, gunung yang terkenal dengan sebutan Gunung Seribu Bukit. '),
(2, 2, 'the-sand-walker-elybin-cms-9884.jpg', '2014-11-18', 'The Sand Walker', '- Tanpa Deskripsi -');



CREATE TABLE IF NOT EXISTS `elybin_media` (
  `media_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `size` int(15) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;


INSERT INTO `elybin_media` (`media_id`, `filename`, `type`, `size`, `date`) VALUES
(1, 'promo2-elybin-cms-9382.png', 'image/png', 17057, '2014-11-14'),
(2, 'promo1-elybin-cms-1422.png', 'image/png', 42086, '2014-11-14'),
(3, 'promo3-elybin-cms-2402.png', 'image/png', 29979, '2014-11-14'),
(4, 'promo4-elybin-cms-8537.png', 'image/png', 44926, '2014-11-14'),
(5, 'promo5-elybin-cms-3807.png', 'image/png', 16794, '2014-11-14'),
(6, 'promo6-elybin-cms-8704.png', 'image/png', 32864, '2014-11-14'),
(7, 'promo7-elybin-cms-5573.png', 'image/png', 26775, '2014-11-14'),
(8, 'promo9-elybin-cms-3243.png', 'image/png', 225410, '2014-11-18');



CREATE TABLE IF NOT EXISTS `elybin_menu` (
  `menu_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) NOT NULL DEFAULT '0',
  `menu_title` varchar(50) NOT NULL,
  `menu_url` varchar(100) NOT NULL,
  `menu_class` varchar(50) NOT NULL,
  `menu_position` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;


INSERT INTO `elybin_menu` (`menu_id`, `parent_id`, `menu_title`, `menu_url`, `menu_class`, `menu_position`) VALUES
(1, 0, 'Beranda', './', '', 1),
(2, 0, 'Tentang Kami', 'page-1-tentang-kami.html', '', 2),
(3, 0, 'Contact', 'contact.html', '', 6),
(4, 0, 'Lainya', '#', '', 4),
(5, 4, 'Unduh', 'http://www.elybin.com', '', 1),
(6, 4, 'Fitur', 'page-2-fitur.html', '', 2),
(7, 0, 'Gallery', 'gallery.html', '', 3);



CREATE TABLE IF NOT EXISTS `elybin_notification` (
  `notif_id` int(10) NOT NULL AUTO_INCREMENT,
  `notif_code` varchar(100) NOT NULL,
  `module` varchar(100) NOT NULL DEFAULT 'general',
  `title` varchar(100) NOT NULL,
  `value` text NOT NULL,
  `date` date NOT NULL,
  `time` varchar(8) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'info',
  `icon` varchar(50) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'unread',
  PRIMARY KEY (`notif_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `elybin_options` (
  `option_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `active` varchar(10) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;

INSERT INTO `elybin_options` (`option_id`, `name`, `value`, `active`) VALUES
(1, 'site_url', '', 'yes'),
(2, 'site_name', '', 'yes'),
(3, 'site_description', 'Menulis dan Berbagi makin asyik dengan Elybin CMS.', 'yes'),
(4, 'site_keyword', 'cms, free, gratis, blogging, website', 'yes'),
(5, 'site_phone', '-', 'yes'),
(6, 'site_office_address', 'Banjarnegara, Jawa Tengah 53499 - Indonesia.', 'yes'),
(7, 'site_owner', 'Administrator', 'yes'),
(8, 'site_email', '', 'yes'),
(9, 'site_coordinate', '-7.39843938253808, 109.671065068203', 'yes'),
(10, 'site_logo', 'logo.png', 'yes'),
(11, 'site_favicon', 'favicon.png', 'yes'),
(12, 'users_can_register', 'deny', 'yes'),
(13, 'default_category', '1', 'yes'),
(14, 'default_comment_status', 'allow', 'yes'),
(15, 'posts_per_page', '3', 'yes'),
(16, 'timezone', '', 'yes'),
(17, 'language', 'id', 'yes'),
(18, 'maintenance_mode', 'deactive', 'yes'),
(19, 'developer_mode', 'deactive', 'yes'),
(20, 'short_name', 'first', 'yes'),
(21, 'text_editor', 'summernote', 'yes'),
(22, 'social_twitter', '@elybincms', 'yes'),
(23, 'social_facebook', 'elybincms', 'yes'),
(24, 'social_instagram', 'elybincms', 'yes'),
(25, 'site_owner_story', 'Elybin CMS hadir memberikan solusi untuk anda yang ingin membuat website professional, untuk pribadi, perusahaan ataupun komunitas dengan mudah dan cepat. Dengan beberapa fitur unggulan yang ada membuat berbagi informasi menjadi lebih cepat dan efisien. Bersiaplah merasakan cara baru berbagi informasi. ', 'yes'),
(26, 'site_hero', 'heroimg.jpg', 'yes'),
(27, 'site_hero_title', 'BECAUSE LIFE IS ADVENTURE', 'yes'),
(28, 'site_hero_subtitle', 'We will never know the real answer, before you try.', 'yes'),
(29, 'admin_theme', 'clean', 'yes'),
(30, 'installdate', '', 'yes'),
(31, 'seotoken', '', 'yes'),
(32, 'account_session', 'NULL', 'yes');

CREATE TABLE IF NOT EXISTS `elybin_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;


INSERT INTO `elybin_pages` (`page_id`, `title`, `content`, `seotitle`, `image`, `status`) VALUES
(1, 'Tentang Kami', ' &lt;h2 style=&quot;text-align: center;&quot; class=&quot;section-heading&quot;&gt;Elybin CMS&lt;/h2&gt;\r\n&lt;h3 style=&quot;text-align: center;&quot; class=&quot;section-subheading text-muted&quot;&gt;Modern, Powerful &amp; Beautiful.&lt;/h3&gt;\r\n&lt;hr&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-weight: bold;&quot;&gt;ElybinCMS&lt;/span&gt; hadir memberikan solusi untuk anda yang ingin membuat website professional untuk pribadi, perusahaan ataupun komunitas dengan mudah dan cepat. Dengan beberapa fitur unggulan yang mudah digunakan membuat berbagi informasi menjadi lebih cepat dan efisien.&lt;/p&gt;&lt;p&gt;Desain minimalis dipilih untuk lebih memudahkan pengguna dalam menggunakan sistem ini. &lt;span style=&quot;font-style: italic;&quot;&gt;ElybinCMS&lt;/span&gt; juga menggunakan &lt;span style=&quot;font-style: italic;&quot;&gt;Bootstrap&lt;/span&gt; sehingga mampu diakses dari semua perangkat termasuk &lt;span style=&quot;font-style: italic;&quot;&gt;Gadget&lt;/span&gt; kesayangan anda. &lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;img style=&quot;width: 100%&quot; src=&quot;elybin-file/media/promo2-elybin-cms-9382.png&quot;&gt;&lt;br&gt;&lt;/p&gt;', 'tentang-kami', '', 'active'),
(2, 'Fitur', ' &lt;h2 style=&quot;text-align: center;&quot; class=&quot;section-heading&quot;&gt;Fitur&lt;/h2&gt;\r\n&lt;h3 style=&quot;text-align: center;&quot; class=&quot;section-subheading text-muted&quot;&gt;Mengapa harus ElybinCMS?&lt;br&gt;&lt;/h3&gt;\r\n&lt;hr&gt;&lt;h3&gt;&lt;img style=&quot;width: 363px; float: right; height: 261.845px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo1-elybin-cms-1422.png&quot;&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;Satu tempat.&lt;/h3&gt;Dengan menyajikan informasi statistik secara jelas dan mudah dipahami dari pengunjung harian, komentar, tulisan, media. Membuat semua berada di satu tempat. &lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;&lt;img style=&quot;width: 445.677px; float: left; height: 270.267px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo3-elybin-cms-2402.png&quot;&gt;Ringan &amp; Cepat.&lt;/h3&gt;Menulis artikel atau cerita semakin asyik dengan &lt;span style=&quot;font-style: italic;&quot;&gt;Summernote Editor&lt;/span&gt; yang ringan, cepat dan mudah. Didukung dengan &lt;span style=&quot;font-style: italic;&quot;&gt;Sistem OOP&lt;/span&gt; semakin membuat proses data menjadi efisien.&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;img style=&quot;width: 429.333px; height: 260.356px; float: right;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo4-elybin-cms-8537.png&quot;&gt;Ubah suka suka!&lt;/h3&gt;Apa warna kesukaan anda? dengan 10 tema panel yang berbeda, ada bisa memilih yang pas untuk anda. Masih kurang? anda bisa mengunduh di gerai tema kami.&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;&lt;img style=&quot;width: 444.333px; float: left; height: 269.452px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo5-elybin-cms-3807.png&quot;&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;Atur hak akses.&lt;/h3&gt;Keamanan adalah hal yang sangat utama, pilih siapa saja yang bisa mengatur website anda. &lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;img style=&quot;width: 468.268px; float: right; height: 283.967px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo6-elybin-cms-8704.png&quot;&gt;&lt;br&gt;&lt;h3&gt;Ramah dengan mesin pencari.&lt;/h3&gt;&lt;span style=&quot;font-style: italic;&quot;&gt;ElybinCMS&lt;/span&gt; mengoptimalkan kata kunci, deskripsi, hingga konten agar mudah terjeajah mesin pencari atau biasa kami sebut SEO (&lt;span style=&quot;font-style: italic;&quot;&gt;Search Engine Optimization&lt;/span&gt;). &lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;&lt;img style=&quot;width: 492.069px; float: left; height: 298.4px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo7-elybin-cms-5573.png&quot;&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;Selalu ingat yang baru.&lt;/h3&gt;Panel &lt;span style=&quot;font-style: italic;&quot;&gt;Notifikasi Pintar&lt;/span&gt; akan mengingatkan anda semua yang terjadi di website anda. Dari komentar terbaru hingga&lt;span style=&quot;font-style: italic;&quot;&gt; Update&lt;/span&gt; sistem tidak akan terlewatkan.&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;img style=&quot;width: 452.932px; float: right; height: 274.667px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo9-elybin-cms-3243.png&quot;&gt;&lt;/h3&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;h3&gt;Temukan dangan mudah.&lt;/h3&gt;Buat pengunjung anda mudah menemukan yang mereka cari. Di integerasikan dengan &lt;span style=&quot;font-style: italic;&quot;&gt;Google Maps API v3.0 &lt;/span&gt;menentukan lokasi menjadi sangat akurat dan mudah.&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;Akses dari manapun.&lt;/h3&gt;Dipadukan dengan &lt;span style=&quot;font-style: italic;&quot;&gt;Bootstrap &amp; jQuery&lt;/span&gt; yang pas sehingga Elybin CMS bisa diaskses di semua perangkat kesayangan anda, dari mana saja.&lt;p&gt;&lt;img style=&quot;width: 100%; &quot; src=&quot;elybin-file/media/promo2-elybin-cms-9382.png&quot;&gt;&lt;/p&gt;\r\n&lt;hr&gt;\r\n&lt;p class=&quot;text-center&quot;&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://download.elybin.com&quot; class=&quot;btn btn-primary btn-lg&quot;&gt;Unduh Sekarang&lt;/a&gt;&lt;br&gt;versi 1.0.0 (Beta)&lt;/p&gt;\r\n', 'fitur', '', 'active');

CREATE TABLE IF NOT EXISTS `elybin_plugins` (
  `plugin_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `alias` varchar(100) NOT NULL,
  `icon` varchar(100) NOT NULL,
  `notification` int(10) NOT NULL DEFAULT '0',
  `version` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(50) NOT NULL,
  `url` varchar(100) NOT NULL,
  `usergroup` varchar(100) NOT NULL,
  `table_name` varchar(100) NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'plugin',
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`plugin_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `elybin_plugins` (`plugin_id`, `name`, `alias`, `icon`, `notification`, `version`, `description`, `author`, `url`, `usergroup`, `table_name`, `type`, `status`) VALUES
(1, 'Subscribe', 'com.subscribe', 'fa-rss', 0, 'v.1.0.1', 'Memperbolehkan user untuk berlangganan email.', 'Elybin CMS', 'http://elybincms.com/', '1,2', 'com.elybin_subscribe', 'apps', 'active');

CREATE TABLE IF NOT EXISTS `elybin_posts` (
  `post_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL DEFAULT '0000-00-00',
  `time` time NOT NULL,
  `author` int(10) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `tag` varchar(200) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'publish',
  `hits` int(10) NOT NULL DEFAULT '0',
  `comment` varchar(10) NOT NULL DEFAULT 'allow',
  `category_id` int(10) NOT NULL,
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


INSERT INTO `elybin_posts` (`post_id`, `title`, `content`, `date`, `time`, `author`, `seotitle`, `tag`, `image`, `status`, `hits`, `comment`, `category_id`) VALUES
(1, '6 Tips Untuk Menata Interior Rumah Minimalis', '&lt;p&gt;&lt;strong&gt;6 Tips Untuk Menata Interior Rumah Minimalis&lt;/strong&gt; - Menata sebuah ruangan rumah minimalis\r\n bisa di bilang susah susah gampang, meskipun hanya menata saja akan \r\ntetapi terdapat beberapa aspek yang perlu Anda diperhatikan untuk menata\r\n sebuah interior rumah. Dalam menata sebuah interior rumah Anda perlu \r\nmenata perabot,furnitur,atau yang lainnya sedemikian rupa sehingga rumah\r\n Anda tidak terlihat monoton itu-itu saja. Nah, berikut ini kami sajikan\r\n beberapa tips untuk Anda, untuk menata sebuah interior rumah minimalis Anda, seperti yang dilansir oleh &lt;em&gt;desaininterior.me&lt;/em&gt;. Baca juga Warna Dapur Cantik Minimalis Untuk Rumah Anda.&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;1. Dalam memilih konsep desain interior \r\nminimalis adalah konsep dengan mengedepankan pas dan tidak berlebihan. \r\nMaka dari itu pilihlah sebuah perabot/furniture dalam rumah yang \r\nbersih,tegas,bergaris lurus dan sebisa mungkin berbentuk geometris. &lt;br&gt;&lt;/p&gt;&lt;p&gt;2. Gunakan hanya 1 palet warna saja dalam ruangan. Jangan lupa \r\nberikan aksen warna yang berbeda sehingga tercipta kesan yang tenang \r\ntapi menghapus kemonotonan. &lt;br&gt;&lt;/p&gt;&lt;p&gt;3. Gunakan sistem pencahayaan yang menggunkan model lamp down light, \r\npendant berbentuk kotak-kotak yang simple dan indirect lighting. &lt;br&gt;&lt;/p&gt;&lt;p&gt;4. Hindarkan nuansa yang penuh pada ruangan dan hanya gunakan perabotan \r\nyang memiliki fungsi maksimal. Jika ingin menambahkan aksesoris \r\nboleh-boleh saja tapi pilih yang bentuk atau modelnya sederhana. &lt;br&gt;&lt;/p&gt;&lt;p&gt;5. Buat laci-laci atau kabinet tertutup yang seakan tersembunyi untuk \r\ntempat meletakkan barang-barang Anda sehingga ruangan tetap terlihat \r\nbersih dan lapang. &lt;br&gt;&lt;/p&gt;&lt;p&gt;6. Jika ingin menambahkan karpet pilih dengan warna yang solid tanpa motif.&lt;/p&gt;&lt;p style=&quot;text-align: left;&quot;&gt;Itulah dia beberapa tips dari kami yang bisa kami sajikan untuk Anda, semoga sedikit tips menata interior rumah minimalis di atas bisa bermanfaat, dan memudahkan Anda dalam mendesain interior rumah idaman Anda.&lt;/p&gt;&lt;p style=&quot;text-align: left;&quot;&gt;Sumber: www.idearumahidaman.com&lt;br&gt;&lt;/p&gt;', '2014-09-17', '09:13:30', 1, '6-tips-untuk-menata-interior-rumah-minimalis', '4', 'image-7823-6-tips-untuk-menata-interior-rumah-minimalis.jpg', 'publish', 14, 'allow', 1),
(2, 'Tips Menyimpan Rempah dan Bumbu Kering', '&lt;p&gt; Menyimpan bumbu masak dalam bentuk kering seperti \r\nmerica, jintan, kayu manis, cabai bubuk dan rempah-rempah lain \r\nmemerlukan penanganan khusus. Walaupun bahan masak kering jauh lebih \r\nawet dibandingkan bahan basah, Anda harus tetap memerhatikan kesegaran \r\ndan keawetannya saat proses penyimpanan.&lt;br&gt;&lt;br&gt;1. Simpan rempah-rempah \r\ndan bumbu kering di dalam wadah kaca/plastik yang bersih dan kering. \r\nLetakkan wadah tersebut di daerah yang gelap dan jauh dari panas. Rempah\r\n dan bumbu kering yang sering mendapat terpaan sinar matahari langsung \r\ndan panas akan mudah rusak.&lt;br&gt;&lt;br&gt;2. Saat akan mengambil rempah dan bumbu kering di dalam wadah, pastikan tangan Anda atau sendok untuk mengambilnya kering. &lt;br&gt;&lt;br&gt;3.\r\n Karena bumbu kering (apalagi dalam bentuk bubuk) sulit dibedakan satu \r\ndan yang lain, untuk menghemat waktu memasak, beri label pada setiap \r\nbotol sesuai dengan isinya. Anda bisa memakai kertas perekat yang banyak\r\n di jual di toko buku.&lt;br&gt;&lt;br&gt;4. Tips lain untuk memudahkan proses \r\nmemasak, urutkan rempah dan bumbu kering yang paling sering Anda gunakan\r\n di bagian luar atau sisi yang dekat dengan tempat memasak Anda. &lt;b&gt;(vem/wsw)&lt;br&gt;&lt;br&gt;&lt;/b&gt;Sumber : Vemale.com&lt;/p&gt;', '2014-10-31', '08:10:28', 1, 'tips-menyimpan-rempah-dan-bumbu-kering', '3', 'image-4667-tips-menyimpan-rempah-dan-bumbu-kering.jpg', 'publish', 12, 'allow', 4),
(3, 'Raja Ampat: Ekspedisi Bawah Laut Terbaik di Dunia ', '&lt;p class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Travel - &lt;/b&gt;Tak salah jika\r\nindonesia adalah surganya alam bawah laut kelas dunia. Selain mempunyai keindahan alam bawah laut di wakatobi, indonesia yang\r\nterdiri dari kepulauan mempunyai banyak tempat-tempat yang memiliki keindahan\r\nalam bawah laut salah satunya di raja ampat. Raja ampat di papua memiliki\r\nribuan jenis ikan, jadi tak heran jika Dr.G.R. Allen menyebutnya sebagai laut\r\nyang kaya akan ikannya.&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Raja ampat adalah sebuah nama yang diberikan oleh penduduk\r\nsetempat untuk 4 pulau besar yang terletak di barat bagian kepala burung\r\n(vogelkoop) pulau papua. Keempat pulau tersebut adalah Waigeo, salawati, batanta\r\ndan misool. Keindahan alam bawah laut di raja ampat ini termasuk 1 dari 10\r\nperairan di dunia untuk tempat diving terbaik. Hal ini dikarenakan di perairan\r\nraja ampat terdapat lebih dari 540 jenis karang keras, sehingga menjadikan 75%\r\nkarang di seluruh dunia berada di alam bawah laut raja ampat. &lt;br&gt;&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Tak hanya itu,\r\n1511 spesies ikan dan 700 jenis moluska menjadi penghuni alam bawah laut di\r\nraja ampat. Menyelami keindahan alam bawah laut raja ampat, sobat akan\r\nmenjelajahi dinding bawah laut yang vertical dengan diombang-ambingkan arus\r\nlaut. Mantaray dan wobbegong akan menyambut kedatangan sobat. Bahkan beberapa\r\njenis ikan seperti snapper, tuna, barracuda akan menjadi teman setia ketika\r\nsobat sedang menikmati keindahan\r\nalam bawah laut raja ampat.&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Cara menuju raja ampat dapat ditempuh dengan penerbangan\r\ndari jakarta menuju sorong dengan perjalanan sekitar 6 jam. Kemudian perjalanan\r\ndilanjutkan dari sorong menuju waisai menggunakan feri yang berangkat sekitar\r\npukul 13.00 WIT. Waisai merupakan ibukota raja ampat yang terletak di\r\npulau waigeo. Perjalanan dari sorong menuju waisai memakan waktu sekitar 2\r\njam. Selain di Raja Ampat dan Wakatobi, Indonesia masih memiliki keindahan alam\r\nbawah laut lainya yakni di Taman Laut Bunaken&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Sumber: www.sobatpetualang.com&lt;/p&gt;', '2014-11-07', '06:45:02', 1, 'raja-ampat-ekspedisi-bawah-laut-terbaik-di-dunia-', '2,1', 'image-4000-raja-ampat-ekspedisi-bawah-laut-terbaik-di-dunia-.jpg', 'publish', 43, 'allow', 3);

CREATE TABLE IF NOT EXISTS `elybin_tag` (
  `tag_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `count` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

INSERT INTO `elybin_tag` (`tag_id`, `name`, `seotitle`, `count`) VALUES
(1, 'holiday', 'holiday', 4),
(2, 'raja ampat', 'raja-ampat', 4),
(3, 'rempah', 'rempah', 2),
(4, 'interior', 'interior', 3);


CREATE TABLE IF NOT EXISTS `elybin_themes` (
  `theme_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'deactive',
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

INSERT INTO `elybin_themes` (`theme_id`, `name`, `description`, `author`, `url`, `folder`, `status`) VALUES
(1, 'Young Free', 'Simple flat themes that allow you to make your own expressions. For you that always Young and Growing!', 'Elybin CMS', 'http://www.elybin.com', 'young-free', 'active');

CREATE TABLE IF NOT EXISTS `elybin_usergroup` (
  `usergroup_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `post` tinyint(1) NOT NULL DEFAULT '0',
  `category` tinyint(1) NOT NULL DEFAULT '0',
  `tag` tinyint(1) NOT NULL DEFAULT '0',
  `comment` tinyint(1) NOT NULL DEFAULT '0',
  `contact` tinyint(1) NOT NULL DEFAULT '0',
  `media` tinyint(1) NOT NULL DEFAULT '0',
  `gallery` tinyint(1) NOT NULL DEFAULT '0',
  `album` tinyint(1) NOT NULL DEFAULT '0',
  `page` tinyint(1) NOT NULL DEFAULT '0',
  `user` tinyint(1) NOT NULL DEFAULT '0',
  `setting` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usergroup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;


INSERT INTO `elybin_usergroup` (`usergroup_id`, `name`, `alias`, `post`, `category`, `tag`, `comment`, `contact`, `media`, `gallery`, `album`, `page`, `user`, `setting`) VALUES
(1, 'Super Admin', 'root', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'Administrator', 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(3, 'User', 'user', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);


CREATE TABLE IF NOT EXISTS `elybin_users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_account_login` varchar(50) NOT NULL,
  `user_account_pass` varchar(50) NOT NULL,
  `user_account_email` varchar(50) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `bio` text NOT NULL,
  `avatar` varchar(100) NOT NULL DEFAULT 'default.jpg',
  `registered` date NOT NULL,
  `lastlogin` datetime NOT NULL,
  `user_account_forgetkey` varchar(100) DEFAULT NULL,
  `level` varchar(10) NOT NULL DEFAULT 'user',
  `session` varchar(100) NOT NULL DEFAULT 'offline',
  `status` varchar(50) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `elybin_visitor` (
  `visitor_ip` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `hits` int(10) NOT NULL DEFAULT '0',
  `online` datetime NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'allow'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `elybin_visitor` (`visitor_ip`, `date`, `hits`, `online`, `status`) VALUES
('127.0.0.1', '2014-12-29', 2, '2014-12-29 01:45:50', 'allow');


CREATE TABLE IF NOT EXISTS `elybin_widget` (
  `widget_id` int(5) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `position` int(5) NOT NULL,
  `sort` int(5) NOT NULL,
  `status` varchar(10) NOT NULL,
  `show` varchar(500) NOT NULL,
  PRIMARY KEY (`widget_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=12 ;

INSERT INTO `elybin_widget` (`widget_id`, `name`, `type`, `content`, `position`, `sort`, `status`, `show`) VALUES
(1, 'Social Media', 'include', './elybin-main/socialmedia/widget.php', 2, 1, 'active', '[''all'']'),
(2, 'Subscribe', 'include', './elybin-main/subscribe/widget.php', 2, 3, 'deactive', '[''index'']'),
(3, 'Recent Popular', 'include', './elybin-main/recentpopular/widget.php', 2, 2, 'active', '[''all'']'),
(4, 'HTML', 'code', '&lt;h1&gt;Test&lt;/h1&gt;', 1, 1, 'active', '[''all'']'),
(5, 'Statistic', 'admin-widget', './widget/statistic/widget.php', 1, 2, 'active', ''),
(6, 'Statistic Box', 'admin-widget', './widget/statisticbox/widget.php', 1, 3, 'active', ''),
(7, 'News & Tips', 'admin-widget', './widget/newstips/widget.php', 2, 2, 'active', ''),
(8, 'Quick Post', 'admin-widget', './widget/quickpost/widget.php', 2, 2, 'active', ''),
(9, 'Notification Widget', 'admin-widget', './widget/notification/widget.php', 3, 2, 'active', ''),
(10, 'Recent Widget', 'admin-widget', './widget/recent/widget.php', 3, 1, 'active', ''),
(11, 'Welcome', 'admin-widget', './widget/welcome/widget.php', 1, 1, 'active', '');