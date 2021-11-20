--
-- Latest database structure
-- Elybin 1.1.4
--

--
-- Table structure for table `elybin_category`
--

CREATE TABLE IF NOT EXISTS `elybin_category` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `elybin_comments`
--

CREATE TABLE IF NOT EXISTS `elybin_comments` (
  `comment_id` int(10) NOT NULL AUTO_INCREMENT,
  `author` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `visitor_id` int(50) NOT NULL,
  `date` datetime NOT NULL,
  `content` text NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'deactive',
  `post_id` int(10) NOT NULL DEFAULT '0',
  `user_id` int(10) NOT NULL DEFAULT '0',
  `parent` int(10) NOT NULL DEFAULT '0',
  `reply` varchar(10) NOT NULL DEFAULT 'no',
  PRIMARY KEY (`comment_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `elybin_media`
--

CREATE TABLE IF NOT EXISTS `elybin_media` (
  `media_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `seotitle` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `metadata` text NOT NULL,
  `filename` varchar(255) NOT NULL,
  `hash` varchar(100) NOT NULL,
  `type` varchar(300) NOT NULL,
  `mime` varchar(300) NOT NULL,
  `size` int(15) NOT NULL,
  `date` datetime NOT NULL,
  `share` varchar(20) NOT NULL DEFAULT 'yes',
  `download` int(10) NOT NULL DEFAULT '0',
  `media_password` varchar(100) NOT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `elybin_menu`
--

CREATE TABLE IF NOT EXISTS `elybin_menu` (
  `menu_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) NOT NULL DEFAULT '0',
  `menu_title` varchar(50) NOT NULL,
  `menu_url` varchar(100) NOT NULL,
  `menu_class` varchar(50) NOT NULL,
  `menu_position` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `elybin_message`
--

CREATE TABLE IF NOT EXISTS `elybin_message` (
  `mid` int(10) NOT NULL AUTO_INCREMENT,
  `subject` varchar(300) NOT NULL,
  `msg_body` text NOT NULL,
  `msg_date` datetime NOT NULL,
  `msg_type` varchar(20) NOT NULL DEFAULT 'message',
  `msg_priority` varchar(20) NOT NULL DEFAULT 'normal',
  `msg_status` varchar(20) NOT NULL DEFAULT 'sent',
  `msg_status_recp` varchar(10) NOT NULL DEFAULT 'received',
  `to_uid` int(10) NOT NULL DEFAULT '0',
  `from_uid` int(10) NOT NULL DEFAULT '0',
  `from_email` varchar(50) NOT NULL DEFAULT '0',
  `from_name` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`mid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `elybin_notification`
--

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

--
-- Table structure for table `elybin_options`
--

CREATE TABLE IF NOT EXISTS `elybin_options` (
  `option_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `active` varchar(10) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `elybin_plugins`
--

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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `elybin_posts`
--

CREATE TABLE IF NOT EXISTS `elybin_posts` (
  `post_id` int(10) NOT NULL AUTO_INCREMENT,
  `title` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `date` datetime NOT NULL,
  `author` int(10) NOT NULL,
  `seotitle` varchar(150) NOT NULL,
  `tag` varchar(200) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'publish',
  `parent` int(10) NOT NULL DEFAULT '0',
  `visibility` varchar(100) NOT NULL DEFAULT 'public',
  `hits` int(10) NOT NULL DEFAULT '0',
  `comment` varchar(10) NOT NULL DEFAULT 'allow',
  `post_password` varchar(40) NOT NULL,
  `post_meta` varchar(3000) NOT NULL DEFAULT '{"post_meta":"false"}',
  `category_id` int(10) NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'post',
  PRIMARY KEY (`post_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `elybin_relation`
--

CREATE TABLE IF NOT EXISTS `elybin_relation` (
  `rel_id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `target` varchar(100) NOT NULL,
  `first_id` int(10) NOT NULL,
  `second_id` int(10) NOT NULL,
  PRIMARY KEY (`rel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `elybin_statistic`
--

CREATE TABLE IF NOT EXISTS `elybin_statistic` (
  `sid` int(10) NOT NULL AUTO_INCREMENT,
  `stat_module` varchar(100) NOT NULL,
  `stat_type` varchar(100) NOT NULL,
  `stat_date` datetime NOT NULL,
  `stat_value1` int(10) NOT NULL DEFAULT '1',
  `stat_value2` int(10) NOT NULL DEFAULT '0',
  `stat_value3` int(10) NOT NULL DEFAULT '0',
  `stat_text1` varchar(255) NOT NULL,
  `stat_text2` varchar(255) NOT NULL,
  `stat_uid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`sid`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `elybin_tag`
--

CREATE TABLE IF NOT EXISTS `elybin_tag` (
  `tag_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `count` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `elybin_usergroup`
--

CREATE TABLE IF NOT EXISTS `elybin_usergroup` (
  `usergroup_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `alias` varchar(50) NOT NULL,
  `post` tinyint(1) NOT NULL DEFAULT '0',
  `category` tinyint(1) NOT NULL DEFAULT '0',
  `tag` tinyint(1) NOT NULL DEFAULT '0',
  `comment` tinyint(1) NOT NULL DEFAULT '0',
  `message` tinyint(1) NOT NULL DEFAULT '0',
  `media` tinyint(1) NOT NULL DEFAULT '0',
  `album` tinyint(1) NOT NULL DEFAULT '0',
  `page` tinyint(1) NOT NULL DEFAULT '0',
  `user` tinyint(1) NOT NULL DEFAULT '0',
  `setting` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`usergroup_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `elybin_users`
--

CREATE TABLE IF NOT EXISTS `elybin_users` (
  `user_id` int(10) NOT NULL AUTO_INCREMENT,
  `user_account_login` varchar(50) NOT NULL,
  `user_account_pass` varchar(255) NOT NULL,
  `user_account_email` varchar(50) NOT NULL,
  `email_status` varchar(15) NOT NULL DEFAULT 'notverified',
  `fullname` varchar(100) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `bio` text NOT NULL,
  `facebook_id` varchar(255) NOT NULL DEFAULT 'elybincms',
  `twitter_id` varchar(255) NOT NULL DEFAULT '@elybincms',
  `website` varchar(255) NOT NULL DEFAULT 'www.elybin.github.io',
  `avatar` varchar(100) NOT NULL DEFAULT 'default/no-ava.png',
  `registered` datetime NOT NULL,
  `lastlogin` datetime NOT NULL,
  `user_account_forgetkey` varchar(100) DEFAULT NULL,
  `forget_date` datetime NOT NULL,
  `level` varchar(10) NOT NULL DEFAULT 'user',
  `session` varchar(100) NOT NULL DEFAULT 'offline',
  `status` varchar(50) NOT NULL DEFAULT 'active',
  `user_meta` varchar(500) NOT NULL DEFAULT '{"user_meta":"null"}',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_account_login` (`user_account_login`),
  UNIQUE KEY `user_account_email` (`user_account_email`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;


--
-- Table structure for table `elybin_visitor`
--

CREATE TABLE IF NOT EXISTS `elybin_visitor` (
  `visitor_id` int(10) NOT NULL AUTO_INCREMENT,
  `visitor_ip` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `hits` int(10) NOT NULL DEFAULT '0',
  `online` datetime NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'allow',
  `user_id` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`visitor_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

--
-- Table structure for table `elybin_widget`
--

CREATE TABLE IF NOT EXISTS `elybin_widget` (
  `widget_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `content` text NOT NULL,
  `position` int(5) NOT NULL,
  `sort` int(5) NOT NULL,
  `status` varchar(10) NOT NULL,
  `show` varchar(500) NOT NULL,
  PRIMARY KEY (`widget_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;




-- CONTENT
--
-- Dumping data for table `elybin_category`
--

INSERT INTO `elybin_category` (`category_id`, `name`, `seotitle`, `status`) VALUES
(1, 'General', 'general', 'active'),
(2, 'Travel', 'travel', 'active'),
(3, 'Culinary', 'culinary', 'active');

-- --------------------------------------------------------

--
-- Dumping data for table `elybin_comments`
--

INSERT INTO `elybin_comments` (`author`, `email`, `visitor_id`, `date`, `content`, `status`, `post_id`, `user_id`, `parent`, `reply`) VALUES
('ELYBIN CMS', 'elybin.inc@gmail.com', 1, NOW(), 'Bantu kami mengembangkan produk buatan Indonesia! Ayo pakai Elybin CMS www.elybin.github.io Gratis!', 'active', 1, 0, 0, 'no');


-- --------------------------------------------------------
--
-- Dumping data for table `elybin_menu`
--

INSERT INTO `elybin_menu` (`menu_id`, `parent_id`, `menu_title`, `menu_url`, `menu_class`, `menu_position`) VALUES
(1, 0, 'Home', '{"home"}', '', 1),
(2, 0, 'About', '{"page":"2"}', '', 2),
(3, 0, 'Download', 'http://www.elybin.github.io', '', 5),
(4, 0, 'Maps', '{"page":"3"}', '', 3),
(5, 0, 'Gallery', '{"gallery"}', '', 4);
-- --------------------------------------------------------

--
-- Dumping data for table `elybin_media`
--

INSERT INTO `elybin_media` (`media_id`, `title`, `seotitle`, `description`, `metadata`, `filename`, `hash`, `type`, `mime`, `size`, `date`, `share`, `download`, `media_password`) VALUES
(1, 'Candi Plaosan - Klaten.jpg', 'candi-plaosan-klaten', 'Candi Plaosan, also known as the \'Plaosan Complex\', is one of the Buddhist temples located in Bugisan village, Prambanan district, Klaten Regency, Central Java, Indonesia, about a kilometer to the northwest of the renowned Hindu Prambanan Temple. [Wikipedia] - https://en.wikipedia.org/wiki/Plaosan<br/>Photo by : David Raka (Instagram: @davidrakafajri)', '{"FileName":"candiplaosanklaten-6539.jpg","FileDateTime":1435708102,"FileSize":307905,"FileType":2,"MimeType":"image\\/jpeg","SectionsFound":"ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP","COMPUTED":{"html":"width=\\"4272\\" height=\\"1706\\"","Height":1706,"Width":4272,"IsColor":1,"ByteOrderMotorola":0,"CCDWidth":"22mm","ApertureFNumber":"f\\/5.0","UserComment":null,"UserCommentEncoding":"UNDEFINED","Thumbnail.FileType":2,"Thumbnail.MimeType":"image\\/jpeg"},"ImageWidth":4272,"ImageLength":2848,"BitsPerSample":[8,8,8],"PhotometricInterpretation":2,"Make":"Canon","Model":"Canon EOS 1100D","Orientation":1,"SamplesPerPixel":3,"XResolution":"720000\\/10000","YResolution":"720000\\/10000","ResolutionUnit":2,"Software":"Adobe Photoshop CS5 Windows","DateTime":"2015:07:01 06:37:07","YCbCrPositioning":2,"Exif_IFD_Pointer":288,"THUMBNAIL":{"Compression":6,"XResolution":"72\\/1","YResolution":"72\\/1","ResolutionUnit":2,"JPEGInterchangeFormat":1394,"JPEGInterchangeFormatLength":2712},"ExposureTime":"1\\/30","FNumber":"5\\/1","ExposureProgram":1,"ISOSpeedRatings":1600,"UndefinedTag:0x8830":2,"UndefinedTag:0x8832":1600,"ExifVersion":"0230","DateTimeOriginal":"2015:01:09 18:26:30","DateTimeDigitized":"2015:01:09 18:26:30","ComponentsConfiguration":"\\u0001\\u0002\\u0003\\u0000","ShutterSpeedValue":"327680\\/65536","ApertureValue":"303104\\/65536","ExposureBiasValue":"0\\/1","MeteringMode":5,"Flash":16,"FocalLength":"43\\/1","UserComment":"\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000","SubSecTime":"90","SubSecTimeOriginal":"90","SubSecTimeDigitized":"90","FlashPixVersion":"0100","ColorSpace":1,"ExifImageWidth":4272,"ExifImageLength":1706,"InteroperabilityOffset":1268,"FocalPlaneXResolution":"4272000\\/905","FocalPlaneYResolution":"2848000\\/595","FocalPlaneResolutionUnit":2,"CustomRendered":0,"ExposureMode":1,"WhiteBalance":0,"SceneCaptureType":0,"UndefinedTag:0xA430":null,"UndefinedTag:0xA431":"268074047882","UndefinedTag:0xA432":["18\\/1","55\\/1","0\\/0","0\\/0"],"UndefinedTag:0xA434":"EF-S18-55mm f\\/3.5-5.6 IS II","UndefinedTag:0xA435":"0000331b67","InterOperabilityIndex":"R98","InterOperabilityVersion":"0100"}', 'candiplaosanklaten-6539.jpg', '4c1255e28541fba04f67544d0ec23f0d', 'image', 'image/jpeg', 307905, NOW(), 'yes', 0, '');


--
-- Dumping data for table `elybin_message`
--

INSERT INTO `elybin_message` (`mid`, `subject`, `msg_body`, `msg_date`, `msg_type`, `msg_priority`, `msg_status`, `msg_status_recp`, `to_uid`, `from_uid`, `from_email`, `from_name`) VALUES
(1, 'Selamat Datang', 'Selamat Datang, Terimakasih telah berkontribusi mengembangkan karya anak bangsa. Cinta produk Indonesia!  :)', NOW(), 'message', 'normal', 'sent', 'received', 1, 0, 'elybin.inc@gmail.com', 'Elybin CMS');

-- --------------------------------------------------------



INSERT INTO `elybin_options` (`option_id`, `name`, `value`, `active`) VALUES
(1, 'site_url', 'http://localhost/', 'yes'),
(2, 'site_name', 'Your Website', 'yes'),
(3, 'site_description', 'Menulis dan Berbagi makin asyik dengan Elybin CMS.', 'yes'),
(4, 'site_keyword', 'elybin, cms, indonesian, free, open source, gratis, blogging, website', 'yes'),
(5, 'site_phone', '-', 'yes'),
(6, 'site_office_address', 'Banjarnegara, Jawa Tengah 53499 - Indonesia.', 'yes'),
(7, 'site_owner', 'Administrator', 'yes'),
(8, 'site_email', 'elybin.inc@gmail.com', 'yes'),
(9, 'site_coordinate', '-7.39843, 109.6710', 'yes'),
(10, 'site_logo', 'default_logo.png', 'yes'),
(11, 'site_favicon', 'default_favicon.png', 'yes'),
(12, 'users_can_register', 'deny', 'yes'),
(13, 'default_category', '1', 'yes'),
(14, 'default_comment_status', 'allow', 'yes'),
(15, 'posts_per_page', '3', 'yes'),
(16, 'timezone', 'Asia/Jakarta', 'yes'),
(17, 'language', 'id-ID', 'yes'),
(18, 'maintenance_mode', 'deactive', 'yes'),
(19, 'developer_mode', 'deactive', 'yes'),
(20, 'short_name', 'first', 'yes'),
(21, 'text_editor', 'summernote', 'yes'),
(22, 'social_twitter', '@elybincms', 'yes'),
(23, 'social_facebook', 'elybincms', 'yes'),
(24, 'social_instagram', 'elybincms', 'yes'),
(25, 'site_owner_story', 'Elybin CMS hadir memberikan solusi untuk anda yang ingin membuat website professional, untuk pribadi, perusahaan ataupun komunitas dengan mudah dan cepat. Dengan beberapa fitur unggulan yang ada membuat berbagi informasi menjadi lebih cepat dan efisien. Bersiaplah merasakan cara baru berbagi informasi. ', 'yes'),
(26, 'site_hero', 'default_heroimg.jpg', 'yes'),
(27, 'site_hero_title', 'Jadikan Rumah Sendiri', 'yes'),
(28, 'site_hero_subtitle', 'sesuaikan dengan apa yang anda butuhkan', 'yes'),
(29, 'admin_theme', 'clean', 'yes'),
(30, 'installdate', '0000-00-00 00:00:00', 'yes'),
(31, 'seotoken', '', 'yes'),
(32, 'account_session', 'NULL', 'yes'),
(33, 'default_homepage', '1', 'yes'),
(34, 'pagging_row', '5', 'yes'),
(35, 'smtp_host', 'smtp.gmail.com', 'yes'),
(36, 'smtp_port', '587', 'yes'),
(37, 'smtp_user', 'username@gmail.com', 'yes'),
(38, 'smtp_pass', 'yourpassword', 'yes'),
(39, 'smtp_status', 'active', 'yes'),
(40, 'mail_daily_limit', '100', 'yes'),
(41, 'site_category', 'personal', 'yes'),
(42, 'fav_colour', 'none', 'yes'),
(43, 'url_rewrite_style', 'dynamic', 'yes'),
(44, 'template', 'young-free', 'yes'),
(45, 'content_language', 'en-US', 'yes'),
(46, 'search_engine_visibility', 'index, follow', 'yes'),
(47, 'album_per_page', '6', 'yes'),
(48, 'photo_per_album', '9', 'yes'),
(49, 'global_option_replace', 'active', 'yes'),
(50, 'database_version', '1.1.5', 'yes'),
(51, 'allow_upload_unknown', 1, 'yes');

-- --------------------------------------------------------

--
-- Dumping data for table `elybin_posts`
--
INSERT INTO `elybin_posts` (`title`, `content`, `date`, `author`, `seotitle`, `tag`, `image`, `status`, `parent`, `visibility`, `hits`, `comment`, `post_password`, `post_meta`, `category_id`, `type`) VALUES
('Buat website cepat dan mudah, pakai Elybin CMS', '<p><span style="font-weight: bold;">Teknolog i</span> - Informasi kini sudah menjadi hal yang mudah dan milik banyak orang. Banyak sekali media yang bisa digunakan untuk mendapatkan berbagai informasi, salah satunya adalah internet. Media yang satu ini, sering dianggap sebagai pangsa pasar terbaik dari media lain. </p>\n<p>Ya, benar adanya memang, mengingat 4 miliar orang, kini sudah terhubung ke internet. Memberikan 1/3 dari seluruh penduduk dunia untuk mengetahui bisnus anda. Atau anda juga punya kesempatan 100 juta pengguna yang mencari website anda setiap detik melalui mesin pencari. </p>\n<p>Internet sejatinya adalah sebuah jaringan (<span style="font-style: italic;">network)</span> yang menghubungkan miliaran perangkat - perangkat yang ada di dunia, dan untuk membuatnya mampu menampilkan beragam informasi yang bermanfaat, maka dibuatlah sebuah tatap muka (<span style="font-style: italic;">interface)</span> atau biasa disebut <span style="font-style: italic; font-weight: bold;">Website/Blog. </span></p>\n<p><span style="line-height: 18.5714282989502px;">Sayangnya... </span><span style="line-height: 1.42857143;">Untuk membuat sebuah website/blog banyak orang rela membayar ratusan ribu bahkan jutaan rupiah, hanya untuk sebuah website sederhana. Belum lagi menejemen dan perawatan yang terus menghantui website anda.  Taukah anda? Dengan menggunakan Elybin CMS, anda bisa membuat website atau profil perusahaan anda hanya dengan beberapa klik! Bahkan ada bisa membuatnya sendiri. Buktikanlah! </span></p>\n<p><span style="font-weight: bold;">Elybin CMS</span> adalah satu dari beberapa CMS (Content Management System) yang ada di dunia. Sistem ini menawarkan kemudahan dan kecepatan dalam membuat dan memenejemen website anda. Jadi anda tidak lagi kerepotan untuk mengelola website anda sendiri. Selain itu, Elybin CMS didukung tema dan plugin tambahan yang mampu menyulap website anda menjadi <span style="font-style: italic;">Toko Online, Jurnal Aktifitas, Aplikasi Prakerin, Aplikasi Kasir </span>bahkan sampai <span style="font-style: italic;">Pendaftaran Lomba Foto </span>bisa dibuat sendiri dengan Elybin CMS<span style="font-style: italic;">.</span></p>\n<p><span style="font-style: italic;"></span>Yang paling penting, sistem ini adalah gratis untuk semua orang, untuk kalangan apa saja. Untuk website apa saja, sehingga, cocok untuk membuat website tanpa biaya. (Baca: Daftar Hosing Website Gratis)<br></p>\n<p>Tunggu apa lagi, buat website kamu dengan Elybin CMS! Gratis!  </p>\n\n<p style="text-align: center; "><a href="http://www.elybin.github.io/" target="_blank" class="btn btn-lg btn-info">Download Elybin CMS - Buat Website Gratis</a></p>', NOW() - INTERVAL 4 DAY, 1, 'buat-website-cepat-dan-mudah-pakai-elybin-cms', '["1","2"]', '', 'publish', 0, 'public', 633, 'allow', '', '{"post_meta":"false"}', 1, 'post'),
('Tentang Elybin CMS', '<h3 style="text-align: center;" class="section-subheading text-muted">Modern, Powerful & Beautiful.</h3><hr><p><span style="font-weight: bold;">ElybinCMS</span> hadir memberikan solusi untuk anda yang ingin membuat website professional untuk pribadi, perusahaan ataupun komunitas dengan mudah dan cepat. Dengan beberapa fitur unggulan yang mudah digunakan membuat berbagi informasi menjadi lebih cepat dan efisien.</p><p>Desain minimalis dipilih untuk lebih memudahkan pengguna dalam menggunakan sistem ini. <span style="font-style: italic;">ElybinCMS</span> juga menggunakan <span style="font-style: italic;">Bootstrap</span> sehingga mampu diakses dari semua perangkat termasuk <span style="font-style: italic;">Gadget</span> kesayangan anda.</p><img src="{{site_url}}elybin-file/media/candiplaosanklaten-6539.jpg" style="width: 100%;"><p><br></p>', NOW() - INTERVAL 5 DAY, 1, 'tentang-elybin-cms--website-professional-tanpa-repot', '', '', 'active', 0, '', 0, 'allow', '', '', 0, 'page'),
('Lokasi', '<div class="text-center"><i class="fa fa-2x fa-map-marker"></i><p>{{site_office_address}}<br><a href="https://www.google.co.id/maps/place/{{site_coordinate}}" target="_blank">{{site_coordinate}}</a></p><img src="https://maps.googleapis.com/maps/api/staticmap?zoom=15&size=800x400&markers={{site_coordinate}}" class="img-responsive img-rounded" style="width: 100%"></div>', NOW() - INTERVAL 5 DAY, 1, 'temukan-kami', '', '', 'active', 0, '', 0, 'allow', '', '', 0, 'page'),
('My Album', 'This is my photo collection', NOW(), 1, 'my-album', '', '', 'active', 0, '', 0, '', '', '', 0, 'album');

-- --------------------------------------------------------

--
-- Dumping data for table `elybin_tag`
--

INSERT INTO `elybin_tag` (`tag_id`, `name`, `seotitle`, `count`) VALUES
(1, 'News', 'news', 1),
(2, 'Info', 'info', 1);

-- --------------------------------------------------------

--
-- Dumping data for table `elybin_notification`
--

INSERT INTO `elybin_notification` (`notif_code`, `module`, `title`, `value`, `date`, `time`, `type`, `icon`, `status`) VALUES
('welcome', 'general', 'Welcome!', 'Welcome to Elybin, enjoy! :)', CURDATE(), CURTIME(), 'info', 'fa-smile-o', 'unread');
--
-- Dumping data for table `elybin_themes`
--

INSERT INTO `elybin_themes` (`theme_id`, `name`, `description`, `author`, `url`, `folder`, `status`) VALUES
(1, 'Young Free', 'Simple flat, modern and cozy themes. Express your expressions. Suitable for Personal, Portfolio or Organization.', 'Elybin CMS', 'https://elybin.github.io/store/', 'young-free', 'active');

-- --------------------------------------------------------

--
-- Dumping data for table `elybin_usergroup`
--

INSERT INTO `elybin_usergroup` (`usergroup_id`, `name`, `alias`, `post`, `category`, `tag`, `comment`, `message`, `media`, `album`, `page`, `user`, `setting`) VALUES
(1, 'Super Admin', 'root', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'Contributor', 'writer', 1, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(3, 'User', 'user', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

-- --------------------------------------------------------

--
-- Dumping data for table `elybin_visitor`
--

INSERT INTO `elybin_visitor` (`visitor_id`, `visitor_ip`, `date`, `hits`, `online`, `status`, `user_id`) VALUES
(1, '127.0.0.1', CURDATE() - INTERVAL 1 DAY, 20, NOW() - INTERVAL 1 DAY, 'allow', 0);


--
-- Dumping data for table `elybin_widget`
--

INSERT INTO `elybin_widget` (`widget_id`, `name`, `type`, `content`, `position`, `sort`, `status`, `show`) VALUES
(1, 'Social Media', 'include', './elybin-main/socialmedia/widget.php', 2, 2, 'deactive', '[''all'']'),
(2, 'Subscribe', 'include', './elybin-main/subscribe/widget.php', 2, 4, 'deactive', '[''index'']'),
(3, 'Recent Popular', 'include', './elybin-main/recentpopular/widget.php', 2, 3, 'active', '[''all'']'),
(4, 'HTML', 'code', '&lt;h1&gt;Test&lt;/h1&gt;', 1, 1, 'deactive', '[''all'']'),
(5, 'Statistic', 'admin-widget', './widget/statistic/widget.php', 1, 2, 'active', ''),
(6, 'Statistic Box', 'admin-widget', './widget/statisticbox/widget.php', 1, 3, 'active', ''),
(7, 'News & Tips', 'admin-widget', './widget/newstips/widget.php', 2, 2, 'active', ''),
(8, 'Quick Post', 'admin-widget', './widget/quickpost/widget.php', 2, 2, 'deactive', ''),
(9, 'Notification Widget', 'admin-widget', './widget/notification/widget.php', 2, 2, 'active', ''),
(10, 'Recent Widget', 'admin-widget', './widget/recent/widget.php', 3, 1, 'active', ''),
(11, 'Welcome', 'admin-widget', './widget/welcome/widget.php', 1, 1, 'active', ''),
(14, 'Login Panel', 'include', './elybin-main/login/widget.php', 2, 1, 'deactive', '[''all'']');

--
-- Dumping data for table `elybin_relation`
--

INSERT INTO `elybin_relation` (`rel_id`, `type`, `target`, `first_id`, `second_id`) VALUES
(1, 'album', 'media', 4, 1);
