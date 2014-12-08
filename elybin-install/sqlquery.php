<?php
include_once("../elybin-core/elybin-config.php");
//include_once("./elybin-config.php");

function ins_table($site_url_cfg, $site_name, $site_email, $timezone, $admin_theme){
include('../elybin-admin/lang/main.php');


$name[0] = "elybin_album";
$q[0] = "
CREATE TABLE IF NOT EXISTS `elybin_album` (
  `album_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
";
$name[1] = "elybin_category";
$q[1] = "
CREATE TABLE IF NOT EXISTS `elybin_category` (
  `category_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;
";
$name[2] = "elybin_comments";
$q[2] = "
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=133 ;
";
$name[3] = "elybin_contact";
$q[3] = "
CREATE TABLE IF NOT EXISTS `elybin_contact` (
  `contact_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`contact_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=38 ;
";
$name[4] = "elybin_gallery";
$q[4] = "
CREATE TABLE IF NOT EXISTS `elybin_gallery` (
  `gallery_id` int(10) NOT NULL AUTO_INCREMENT,
  `album_id` int(10) NOT NULL,
  `image` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `name` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`gallery_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=8 ;
";
$name[5] = "elybin_media";
$q[5] = "
CREATE TABLE IF NOT EXISTS `elybin_media` (
  `media_id` int(11) NOT NULL AUTO_INCREMENT,
  `filename` varchar(100) NOT NULL,
  `type` varchar(50) NOT NULL,
  `size` int(15) NOT NULL,
  `date` date NOT NULL,
  PRIMARY KEY (`media_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=10 ;
";
$name[6] = "elybin_menu";
$q[6] = "
CREATE TABLE IF NOT EXISTS `elybin_menu` (
  `menu_id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `parent_id` tinyint(3) NOT NULL DEFAULT '0',
  `menu_title` varchar(50) NOT NULL,
  `menu_url` varchar(100) NOT NULL,
  `menu_class` varchar(50) NOT NULL,
  `menu_position` tinyint(3) NOT NULL DEFAULT '0',
  PRIMARY KEY (`menu_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23 ;
";
$name[7] = "elybin_notification";
$q[7] = "
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=279 ;
";
$name[8] = "elybin_options";
$q[8] = "
CREATE TABLE IF NOT EXISTS `elybin_options` (
  `option_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `value` text NOT NULL,
  `active` varchar(10) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`option_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=33 ;
";
$name[9] = "elybin_pages";
$q[9] = "
CREATE TABLE IF NOT EXISTS `elybin_pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `image` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'yes',
  PRIMARY KEY (`page_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
";
$name[10] = "elybin_plugins";
$q[10] = "
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;
";
$name[11] = "elybin_posts";
$q[11] = "
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;
";
$name[12] = "elybin_tag";
$q[12] = "
CREATE TABLE IF NOT EXISTS `elybin_tag` (
  `tag_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `count` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`tag_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=59 ;
";
$name[13] = "elybin_themes";
$q[13] = "
CREATE TABLE IF NOT EXISTS `elybin_themes` (
  `theme_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'deactive',
  PRIMARY KEY (`theme_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;
";
$name[14] = "elybin_usergroup";
$q[14] = "
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=9 ;
";
$name[15] = "elybin_users";
$q[15] = "
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
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;
";
$name[16] = "elybin_visitor";
$q[16] = "
CREATE TABLE IF NOT EXISTS `elybin_visitor` (
  `visitor_ip` varchar(20) NOT NULL,
  `date` date NOT NULL,
  `hits` int(10) NOT NULL DEFAULT '0',
  `online` datetime NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'allow'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
";
$name[17] = "elybin_widget";
$q[17] = "
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
";
$name[18] = "com.elybin_subscribe";
$q[18] = "
CREATE TABLE IF NOT EXISTS `com.elybin_subscribe` (
  `subscribe_id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`subscribe_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=34 ;
";

// connect first
$success = 0;
$fail = 0;
$con = mysql_connect(DB_HOST,DB_USER,DB_PASSWD) or die(mysql_error());
if($con){
	// conenct db
	if(mysql_select_db(DB_NAME,$con)){
		$res[] = '{"part":"Select Databasse","status":"done"}';
		// execute 'em
		for($i=0; $i < count($q); $i++){
			$query = mysql_query($q[$i]);
			if($query){
				$res[] = '{"part":"'.$name[$i].'","status":"done"}';
				$success++;
			}else{
				$res[] = '{"part":"'.$name[$i].'","status":"fail"}';
				$fail++;
			}
		}
		
		// collect data and count success
		if($success == count($q)){
			//$s = array(
			//	'status' => 'ok',
			//	'title' => $lg_success,
			//	'isi' => $lg_systeminformationsaved
			//);
			//echo json_encode($s);
			ins_data($site_url_cfg, $site_name, $site_email, $timezone, $admin_theme);
		}else{
			// if not all successed
			$s = array(
				'status' => 'error',
				'title' => $lg_error,
				'isi' => 'Few table error',
				'error' => json_encode($name)
			);
			echo json_encode($s);
			exit;
		}
	}else{
		// cant conenct db
		$s = array(
			'status' => 'error',
			'title' => $lg_error,
			'isi' => $lg_cannotconnecttodatabasepleasecheck,
			'error' => 'db_name'
		);
		echo json_encode($s);
		exit;
	}	
}else{
	// cant conenct db
	$s = array(
		'status' => 'error',
		'title' => $lg_error,
		'isi' => $lg_cannotconnecttodatabasepleasecheck,
		'error' => 'db_pass'
	);
	echo json_encode($s);
	exit;
}
}


// insert dump data
function ins_data($site_url_cfg, $site_name, $site_email, $timezone, $admin_theme){
include('../elybin-admin/lang/main.php');

$q[0] = "
INSERT INTO `elybin_album` (`album_id`, `name`, `seotitle`, `date`, `status`) VALUES
(1, 'Nature', 'nature', '2014-07-17', 'active'),
(2, 'Travel', 'travel', '2014-09-03', 'active'),
(3, 'Art', 'art', '2014-08-09', 'active');
";

$q[1] = "
INSERT INTO `elybin_category` (`category_id`, `name`, `seotitle`, `status`) VALUES
(1, 'Umum', 'umum', 'active'),
(2, 'Sport', 'sport', 'active'),
(3, 'Travel', 'travel', 'active'),
(4, 'Kuliner', 'kuliner', 'active'),
(5, 'Teknologi', 'teknologi', 'active');
";

$q[2] = "
INSERT INTO `elybin_comments` (`comment_id`, `author`, `email`, `ip`, `date`, `time`, `content`, `status`, `post_id`, `gallery_id`, `user_id`) VALUES
(1, '', '', '127.0.0.1', '2014-11-18', '20:43:37', 'Sangat inspiratif! ', 'active', 4, 0, 2),
(2, '', '', '127.0.0.1', '2014-11-18', '20:46:19', 'Indonesia memang punya berjuta juta kekayaan yang patut kita banggakan :)', 'active', 7, 0, 3);
";

$q[3] = "
(1, 'Ellen Gover', 'ellengover@gmail.com', 'Hello admin, very nice website! Look so beautiful! :)', '2014-11-13', '19:50:24', 'unread'),
(2, 'Matt Frank', 'markfrank@gmail.com', 'I want to buy premium plugin, how?', '2014-11-13', '19:51:06', 'unread');
";

$q[4] = "
INSERT INTO `elybin_gallery` (`gallery_id`, `album_id`, `image`, `date`, `name`, `description`) VALUES
(1, 1, 'candi-prambanan-elybin-cms-4080.jpg', '2014-11-18', 'Candi Prambanan', 'Candi Prambanan atau Candi Loro Jonggrang adalah kompleks candi Hindu terbesar di Indonesia yang dibangun pada abad ke-9 masehi. Candi ini dipersembahkan untuk Trimurti, tiga dewa utama Hindu yaitu Brahma sebagai dewa pencipta, Wishnu sebagai dewa pemelihara, dan Siwa sebagai dewa pemusnah. '),
(2, 1, 'pesona-gunung-prau-2565-elybin-cms-3171.jpg', '2014-11-18', 'Pesona Gunung Prau 2.565', 'Gunung Prau yang berada di Dataran Tinggi Dieng ini meliputi wilayah Kab. Banjarnegara, Kab. Wonosobo, Kab. Batang dan Kab. Kendal. Gunung Prau atau Prahu memang pendek, kadang hanya dilirik sebelah mata oleh pendaki Indonesia, tapi coba rasakan sensasi dalam pelukannya, gunung yang terkenal dengan sebutan Gunung Seribu Bukit. '),
(3, 2, 'travel-time-elybin-cms-7525.jpg', '2014-11-18', 'Travel Time!', '- Tanpa Deskripsi -'),
(4, 3, 'november-elybin-cms-3905.jpg', '2014-11-18', 'November.', 'Welcome the beautiful month, the begining of the morning.'),
(5, 3, 'pagelaran-seni-elybin-cms-1461.jpg', '2014-11-18', 'Pagelaran Seni', 'Seni asli Indonesia tak pernah lekang oleh waktu. '),
(6, 3, 'lukisan-dinding-elybin-cms-4387.jpg', '2014-11-18', 'Lukisan Dinding', '- Tanpa Deskripsi -'),
(7, 2, 'the-sand-walker-elybin-cms-9884.jpg', '2014-11-18', 'The Sand Walker', '- Tanpa Deskripsi -');
";

$q[5] = "
INSERT INTO `elybin_media` (`media_id`, `filename`, `type`, `size`, `date`) VALUES
(1, 'codeigniter-elybin-cms-2549.pdf', 'application/pdf', 692858, '2014-11-13'),
(2, 'promo2-elybin-cms-9382.png', 'image/png', 17057, '2014-11-14'),
(3, 'promo1-elybin-cms-1422.png', 'image/png', 42086, '2014-11-14'),
(4, 'promo3-elybin-cms-2402.png', 'image/png', 29979, '2014-11-14'),
(5, 'promo4-elybin-cms-8537.png', 'image/png', 44926, '2014-11-14'),
(6, 'promo5-elybin-cms-3807.png', 'image/png', 16794, '2014-11-14'),
(7, 'promo6-elybin-cms-8704.png', 'image/png', 32864, '2014-11-14'),
(8, 'promo7-elybin-cms-5573.png', 'image/png', 26775, '2014-11-14'),
(10, 'promo9-elybin-cms-3243.png', 'image/png', 225410, '2014-11-18');
";

$q[6] = "
INSERT INTO `elybin_menu` (`menu_id`, `parent_id`, `menu_title`, `menu_url`, `menu_class`, `menu_position`) VALUES
(1, 0, 'Beranda', './', '', 1),
(2, 0, 'Tentang Kami', 'page-1-tentang-kami.html', '', 2),
(3, 0, 'Contact', 'contact.html', '', 7),
(4, 0, 'Lainya', '#', '', 4),
(5, 4, 'Unduh', 'http://download.elybin.com', '', 2),
(6, 4, 'Fitur', 'page-2-fitur.html', '', 1),
(7, 0, 'Gallery', 'gallery.html', '', 3);
";

$q[7] = "
";

$q[8] = "
INSERT INTO `elybin_pages` (`page_id`, `title`, `content`, `seotitle`, `image`, `status`) VALUES
(1, 'Tentang Kami', '&lt;h2 style=&quot;text-align: center;&quot; class=&quot;section-heading&quot;&gt;Elybin CMS&lt;/h2&gt;\r\n&lt;h3 style=&quot;text-align: center;&quot; class=&quot;section-subheading text-muted&quot;&gt;Modern, Powerful &amp; Beautiful.&lt;/h3&gt;\r\n&lt;hr&gt;\r\n&lt;p&gt;&lt;span style=&quot;font-weight: bold;&quot;&gt;ElybinCMS&lt;/span&gt; hadir memberikan solusi untuk anda yang ingin membuat website professional untuk pribadi, perusahaan ataupun komunitas dengan mudah dan cepat. Dengan beberapa fitur unggulan yang mudah digunakan membuat berbagi informasi menjadi lebih cepat dan efisien.&lt;/p&gt;&lt;p&gt;Desain minimalis dipilih untuk lebih memudahkan pengguna dalam menggunakan sistem ini. &lt;span style=&quot;font-style: italic;&quot;&gt;ElybinCMS&lt;/span&gt; juga menggunakan &lt;span style=&quot;font-style: italic;&quot;&gt;Bootstrap&lt;/span&gt; sehingga mampu diakses dari semua perangkat termasuk &lt;span style=&quot;font-style: italic;&quot;&gt;Gadget&lt;/span&gt; kesayangan anda. &lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;img style=&quot;width: 100%&quot; src=&quot;elybin-file/media/promo2-elybin-cms-9382.png&quot;&gt;&lt;br&gt;&lt;/p&gt;', 'tentang-kami', '', 'active'),
(2, 'Fitur', ' &lt;h2 style=&quot;text-align: center;&quot; class=&quot;section-heading&quot;&gt;Fitur&lt;/h2&gt;\r\n&lt;h3 style=&quot;text-align: center;&quot; class=&quot;section-subheading text-muted&quot;&gt;Mengapa harus ElybinCMS?&lt;br&gt;&lt;/h3&gt;\r\n&lt;hr&gt;&lt;h3&gt;&lt;img style=&quot;width: 363px; float: right; height: 261.845px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo1-elybin-cms-1422.png&quot;&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;Satu tempat.&lt;/h3&gt;Dengan menyajikan informasi statistik secara jelas dan mudah dipahami dari pengunjung harian, komentar, tulisan, media. Membuat semua berada di satu tempat. &lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;&lt;img style=&quot;width: 445.677px; float: left; height: 270.267px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo3-elybin-cms-2402.png&quot;&gt;Ringan &amp; Cepat.&lt;/h3&gt;Menulis artikel atau cerita semakin asyik dengan &lt;span style=&quot;font-style: italic;&quot;&gt;Summernote Editor&lt;/span&gt; yang ringan, cepat dan mudah. Didukung dengan &lt;span style=&quot;font-style: italic;&quot;&gt;Sistem OOP&lt;/span&gt; semakin membuat proses data menjadi efisien.&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;img style=&quot;width: 429.333px; height: 260.356px; float: right;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo4-elybin-cms-8537.png&quot;&gt;Ubah suka suka!&lt;/h3&gt;Apa warna kesukaan anda? dengan 10 tema panel yang berbeda, ada bisa memilih yang pas untuk anda. Masih kurang? anda bisa mengunduh di gerai tema kami.&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;&lt;img style=&quot;width: 444.333px; float: left; height: 269.452px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo5-elybin-cms-3807.png&quot;&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;Atur hak akses.&lt;/h3&gt;Keamanan adalah hal yang sangat utama, pilih siapa saja yang bisa mengatur website anda. &lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;img style=&quot;width: 468.268px; float: right; height: 283.967px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo6-elybin-cms-8704.png&quot;&gt;&lt;br&gt;&lt;h3&gt;Ramah dengan mesin pencari.&lt;/h3&gt;&lt;span style=&quot;font-style: italic;&quot;&gt;ElybinCMS&lt;/span&gt; mengoptimalkan kata kunci, deskripsi, hingga konten agar mudah terjeajah mesin pencari atau biasa kami sebut SEO (&lt;span style=&quot;font-style: italic;&quot;&gt;Search Engine Optimization&lt;/span&gt;). &lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;&lt;img style=&quot;width: 492.069px; float: left; height: 298.4px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo7-elybin-cms-5573.png&quot;&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;Selalu ingat yang baru.&lt;/h3&gt;Panel &lt;span style=&quot;font-style: italic;&quot;&gt;Notifikasi Pintar&lt;/span&gt; akan mengingatkan anda semua yang terjadi di website anda. Dari komentar terbaru hingga&lt;span style=&quot;font-style: italic;&quot;&gt; Update&lt;/span&gt; sistem tidak akan terlewatkan.&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;img style=&quot;width: 452.932px; float: right; height: 274.667px;&quot; src=&quot;http://localhost/project/elybin/elybin-file/media/promo9-elybin-cms-3243.png&quot;&gt;&lt;/h3&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;h3&gt;Temukan dangan mudah.&lt;/h3&gt;Buat pengunjung anda mudah menemukan yang mereka cari. Di integerasikan dengan &lt;span style=&quot;font-style: italic;&quot;&gt;Google Maps API v3.0 &lt;/span&gt;menentukan lokasi menjadi sangat akurat dan mudah.&lt;br&gt;&lt;br&gt;&lt;br&gt;&lt;h3&gt;&lt;br&gt;&lt;/h3&gt;&lt;h3&gt;Akses dari manapun.&lt;/h3&gt;Dipadukan dengan &lt;span style=&quot;font-style: italic;&quot;&gt;Bootstrap &amp; jQuery&lt;/span&gt; yang pas sehingga Elybin CMS bisa diaskses di semua perangkat kesayangan anda, dari mana saja.&lt;p&gt;&lt;img style=&quot;width: 100%; &quot; src=&quot;elybin-file/media/promo2-elybin-cms-9382.png&quot;&gt;&lt;/p&gt;\r\n&lt;hr&gt;\r\n&lt;p class=&quot;text-center&quot;&gt;&lt;a target=&quot;_blank&quot; href=&quot;http://download.elybin.com&quot; class=&quot;btn btn-primary btn-lg&quot;&gt;Unduh Sekarang&lt;/a&gt;&lt;br&gt;versi 1.0.0 (Beta)&lt;/p&gt;\r\n', 'fitur', '', 'active');
";

$q[9] = "
INSERT INTO `elybin_plugins` (`plugin_id`, `name`, `alias`, `icon`, `notification`, `version`, `description`, `author`, `url`, `usergroup`, `table_name`, `type`, `status`) VALUES
(1, 'Subscribe', 'com.subscribe', 'fa-rss', 0, 'v.1.0.1', 'Memperbolehkan user untuk berlangganan email.', 'Elybin CMS', 'http://elybincms.com/', '1,2', 'com.elybin_subscribe', 'apps', 'active');
";

$q[10] = "
INSERT INTO `elybin_posts` (`post_id`, `title`, `content`, `date`, `time`, `author`, `seotitle`, `tag`, `image`, `status`, `hits`, `comment`, `category_id`) VALUES
(1, 'Pendiri Kaskus: Internet Harus Cepat dan Merata', '&lt;p&gt;&lt;b&gt; Jakarta - &lt;/b&gt; Situs forum komunitas online, Kaskus, sudah tidak \r\nasing lagi bagi para pengguna internet (netizen) di Tanah Air. Sebagai \r\nsalah satu layanan online, kualitas internet tentu saja menjadi salah \r\nsatu perhatian utama oleh salah satu pendirinya, Andrew Darwis.&lt;br&gt;&lt;br&gt;Menurut\r\n Andrew, yang dibutuhkan oleh para netizen bukan hanya akses internet \r\nyang cepat. Melainkan juga merata alias semua wilayah di Indonesia dapat\r\n dijangkau oleh internet.\r\n&lt;/p&gt;&lt;p&gt;&quot;Internet itu bukan hanya harus cepat, tapi juga merata. Karena saat \r\nini hanya kota-kota besar yang akses internetnya cukup cepat, tapi \r\ndaerah lain seperti Papua dan tempat tinggal di dekat daerah pegunungan \r\nbelum merasakan kualitas internet yang cepat,&quot; tutur Andrew dalam acara \r\nDigital Lifestyle by Kaskus di pameran Indocomtech, di Jakarta \r\nConvention Center (JCC), Jakarta, Minggu (2/11/2014).&lt;br&gt;&lt;br&gt;Chief \r\nCommunity Officer Kaskus ini menambahkan bahwa internet adalah salah \r\nsatu hal terpenting yang dibutuhkan dunia, termasuk Indonesia. Kalau \r\ndulu ada ungkapan buku adalah jendela dunia, katanya, sekarang internet \r\njuga bisa disebut sebagai jendela dunia karena kita juga bisa mencari \r\ntahu tentang berbagai hal lewat internet.&lt;/p&gt;\r\n&lt;p&gt;Dituturkannya, akses internet dapat menjadi salah satu alat bagi \r\nsejumlah orang seperti nelayan dan petani di desa-desa untuk mengetahui \r\ninformasi mengenai apa yang akan mereka jual. &quot;Jika akses internet cepat\r\n dan merata, dan penggunanya juga ikut meluas, maka orang-orang seperti \r\nnelayan dan petani di desa-desa bisa terbantu karena bisa memeriksa \r\nharga, sebelum mereka berjualan. Jadi tidak akan dibohongi,&quot; sambungnya.&lt;/p&gt;\r\n&lt;p&gt;Karena itu, dia berharap Kementerian Komunikasi dan Informatika \r\n(Kemenkominfo) di Kabinet Kerja Presiden dan Wakil Presdien Joko \r\nWidodo-Jusuf Kalla, bisa memberikan akses internet cepat dan merata di \r\nIndonesia.&lt;/p&gt;\r\n&lt;p&gt;&quot;Harapan kita ini juga menjadi bagian dari perhatian Pak Jokowi yaitu\r\n infrastruktur internet yang luas dan merata,&quot; ungkap Andrew.&lt;/p&gt;&lt;p&gt;Sumber: liputan6.com&lt;br&gt;&lt;/p&gt;', '2014-08-01', '07:05:36', 1, 'pendiri-kaskus-internet-harus-cepat-dan-merata', '17,16,9', 'image-2597-pendiri-kaskus-internet-harus-cepat-dan-merata.jpg', 'publish', 2, 'deny', 5),
(2, 'Old Trafford Sambut ''Duel'' Ronaldo-Messi', '&lt;p class=&quot;MsoNormal&quot;&gt;&lt;strong&gt;&lt;span style=&quot;font-family:&quot; calibri&quot;,&quot;sans-serif&quot;;=&quot;&quot; mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:=&quot;&quot; tahoma;mso-bidi-theme-font:minor-bidi&quot;=&quot;&quot;&gt;Manchester&lt;/span&gt;&lt;/strong&gt; - Laga &lt;em&gt;&lt;span style=&quot;font-family:&quot; calibri&quot;,&quot;sans-serif&quot;;mso-ascii-theme-font:minor-latin;=&quot;&quot; mso-hansi-theme-font:minor-latin;mso-bidi-font-family:tahoma;mso-bidi-theme-font:=&quot;&quot; minor-bidi&quot;=&quot;&quot;&gt;friendly&lt;/span&gt;&lt;/em&gt; antara Portugal vs Argentina memang bukan\r\nsekadar duel Cristiano Ronaldo vs Lionel Messi. Namun, mengingat nama besar\r\nkeduanya, tetap saja Ronaldo dan Messi tidak bisa ditepikan dari laga tersebut.&lt;br&gt;\r\n&lt;br&gt;\r\nTerebih lagi, pertandingan kali ini dihelat di Old Trafford, salah satu stadion\r\nterbesar di Inggris. Untuk Ronaldo, Old Trafford jelas bukan tempat yang asing.\r\nPuluhan ribu suporter pernah menyanyikan namanya ketika dia masih berkostum\r\nManchester United.&lt;br&gt;\r\n&lt;br&gt;\r\nDemikian pula dengan rekan Ronaldo, Nani. Kendati kini berkostum Sporting\r\nLisbon, Nani masihlah berstatus pemain &#039;Setan Merah&#039;. Sudah sejak 2007 Old\r\nTrafford akrab menjadi tempatnya bermain.&lt;br&gt;\r\n&lt;br&gt;\r\nDari kubu Argentina? Messi memang tidak ada hubungannya dengan si pemilik\r\nstadion, tapi dia pernah menginjakkan kaki di Old Trafford kala membela\r\nBarcelona. Sementara rekannya, Angel Di Maria, kini adalah pemilik nomor 7 di\r\nUnited.&lt;br&gt;\r\n&lt;br&gt;\r\nSelain Di Maria, masih ada beberapa pemain Argentina lainnya yang cukup\r\nfamiliar dengan kota Manchester dan Old Trafford sendiri. Mereka adalah Sergio\r\nAguero, Pablo Zabaleta, dan Martin Demichelis yang kini memperkuat Manchester\r\nCity. Sementara Carlos Tevez, meski kini memperkuat Juventus, pernah menjadi\r\npemain United dan City.&lt;br&gt;\r\n&lt;br&gt;\r\n&quot;Manajer mana pun pasti setuju bahwa ini adalah susunan pemain paling\r\nmenarik yang bermain di Premier League,&quot; ujar manajer Argentina, Gerardo\r\nMartino, seperti dilansir &lt;em&gt;&lt;span style=&quot;font-family:&quot; calibri&quot;,&quot;sans-serif&quot;;=&quot;&quot; mso-ascii-theme-font:minor-latin;mso-hansi-theme-font:minor-latin;mso-bidi-font-family:=&quot;&quot; tahoma;mso-bidi-theme-font:minor-bidi&quot;=&quot;&quot;&gt;Manchester Evening News.&lt;/span&gt;&lt;/em&gt;&lt;br&gt;\r\n&lt;br&gt;\r\n&quot;Di antara enam atau tujuh tim terbaik di dunia, pasti ada satu atau dua\r\ntim Inggris di antaranya. Saya tidak cuma bicara soal keseluruhan tim Inggris,\r\ntetapi juga dua tim asal Manchester.&quot;&lt;/p&gt;\r\n\r\n&lt;p class=&quot;MsoNormal&quot;&gt;&quot;Saat ini, United memang sedang tidak bagus, tapi jika\r\nAnda melihat sejarah mereka, mereka selalu terlibat di babak-babak akhir Liga\r\nChampions dan memenangi banyak gelar di Inggris.&quot;&lt;br&gt;\r\n&lt;br&gt;\r\n&quot;Pemain yang datang ke Manchester sekarang bermain dengan pemain-pemain\r\nterbaik dunia dan mereka mendapatkan fasilitas terbaik. Ini adalah sesuatu yang\r\nbagus untuk manajer Argentina,&quot; kata Martino.&lt;br&gt;\r\n&lt;br&gt;\r\nUntuk Ronaldo dan Messi sendiri, pertandingan persahabatan ini juga tidak lepas\r\ndari persaingan mereka menuju gelar Ballon d&#039;Or berikutnya.&lt;br&gt;\r\n&lt;br&gt;\r\n&quot;Saya memilih Cristiano karena, saya pikir, sepanjang musim dia adalah\r\npemain terbaik di dunia,&quot; ujar manajer Portugal, Fernando Santos.&lt;br&gt;\r\n&lt;br&gt;\r\n&quot;Kita semua tahu Messi adalah pemain yang bagus. Dalam opini saya,\r\nkeduanya sama-sama genius,&quot; ucapnya.&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;&lt;br&gt;&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Sumber Detik.com&lt;br&gt;&lt;/p&gt;', '2014-09-03', '11:01:28', 1, 'old-trafford-sambut-duel-ronaldomessi', '4,3,2,1', 'image-1843-old-trafford-sambut-duel-ronaldomessi.jpg', 'publish', 25, 'allow', 2),
(3, '6 Tips Untuk Menata Interior Rumah Minimalis', '&lt;p&gt;&lt;strong&gt;6 Tips Untuk Menata Interior Rumah Minimalis&lt;/strong&gt; - Menata sebuah ruangan rumah minimalis\r\n bisa di bilang susah susah gampang, meskipun hanya menata saja akan \r\ntetapi terdapat beberapa aspek yang perlu Anda diperhatikan untuk menata\r\n sebuah interior rumah. Dalam menata sebuah interior rumah Anda perlu \r\nmenata perabot,furnitur,atau yang lainnya sedemikian rupa sehingga rumah\r\n Anda tidak terlihat monoton itu-itu saja. Nah, berikut ini kami sajikan\r\n beberapa tips untuk Anda, untuk menata sebuah interior rumah minimalis Anda, seperti yang dilansir oleh &lt;em&gt;desaininterior.me&lt;/em&gt;. Baca juga Warna Dapur Cantik Minimalis Untuk Rumah Anda.&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;1. Dalam memilih konsep desain interior \r\nminimalis adalah konsep dengan mengedepankan pas dan tidak berlebihan. \r\nMaka dari itu pilihlah sebuah perabot/furniture dalam rumah yang \r\nbersih,tegas,bergaris lurus dan sebisa mungkin berbentuk geometris. &lt;br&gt;&lt;/p&gt;&lt;p&gt;2. Gunakan hanya 1 palet warna saja dalam ruangan. Jangan lupa \r\nberikan aksen warna yang berbeda sehingga tercipta kesan yang tenang \r\ntapi menghapus kemonotonan. &lt;br&gt;&lt;/p&gt;&lt;p&gt;3. Gunakan sistem pencahayaan yang menggunkan model lamp down light, \r\npendant berbentuk kotak-kotak yang simple dan indirect lighting. &lt;br&gt;&lt;/p&gt;&lt;p&gt;4. Hindarkan nuansa yang penuh pada ruangan dan hanya gunakan perabotan \r\nyang memiliki fungsi maksimal. Jika ingin menambahkan aksesoris \r\nboleh-boleh saja tapi pilih yang bentuk atau modelnya sederhana. &lt;br&gt;&lt;/p&gt;&lt;p&gt;5. Buat laci-laci atau kabinet tertutup yang seakan tersembunyi untuk \r\ntempat meletakkan barang-barang Anda sehingga ruangan tetap terlihat \r\nbersih dan lapang. &lt;br&gt;&lt;/p&gt;&lt;p&gt;6. Jika ingin menambahkan karpet pilih dengan warna yang solid tanpa motif.\r\n&lt;/p&gt;&lt;p style=&quot;text-align: left;&quot;&gt;Itulah dia beberapa tips dari kami yang bisa kami sajikan untuk Anda, semoga sedikit tips menata interior rumah minimalis di atas bisa bermanfaat, dan memudahkan Anda dalam mendesain interior rumah idaman Anda.&lt;/p&gt;&lt;p style=&quot;text-align: left;&quot;&gt;Sumber: www.idearumahidaman.com&lt;br&gt;&lt;/p&gt;', '2014-09-17', '09:13:30', 1, '6-tips-untuk-menata-interior-rumah-minimalis', '14,13,12,11', 'image-7823-6-tips-untuk-menata-interior-rumah-minimalis.jpg', 'publish', 12, 'allow', 1),
(4, 'Jack Ma Alibaba, Dari Guru Miskin Kini Miliarder', '&lt;p&gt;&lt;b&gt;Jakarta - &lt;/b&gt; Berkat kerja kerasnya, pendiri \r\nperusahaan e-commerce Alibaba Group --Jack Ma-- kini menjelma jadi orang\r\n terkaya di China dan orang kedua terkaya di Asia menurut Bloomberg \r\nBillionaires Index. Namun siapa sangka, ia dulu hanyalah seorang guru \r\nmiskin di China. &lt;br&gt;&lt;br&gt;Jack Ma berasal dari Hangzhou, China, sebuah \r\nkota dengan 2,4 juta orang penduduk di dekat Shanghai. Kota ini dikenal \r\nkarena pemandangannya yang indah dan tanah pertaniannya yang subur. &lt;br&gt;&lt;br&gt;Ia lahir tahun 1964. Orangtuanya bekerja sebagai &lt;em&gt;pingtan performer&lt;/em&gt; (teknik &lt;em&gt;performing&lt;/em&gt; tradisional seperti &lt;em&gt;story telling, joke cracking, music playing&lt;/em&gt;, &lt;em&gt;ballad singing&lt;/em&gt;). Dulu ia sering berkelahi karena teman-temannya sering mengejek ukuran tubuhnya.&lt;br&gt;&lt;br&gt;&lt;strong&gt;Belajar Bahasa Inggris dengan Turis&lt;/strong&gt;&lt;br&gt;&lt;br&gt;Pada\r\n usia 12 tahun, Ma belajar Bahasa Inggris sendiri. Selama delapan tahun,\r\n dia sengaja gowes naik sepeda selama 40 menit setiap hari ke sebuah \r\nhotel di dekat distrik West Lake Hangzhou agar bisa bertemu turis asing.\r\n &lt;br&gt;&lt;br&gt;Ia menawarkan diri menjadi pemandu turis, gratis, hanya untuk \r\nberlatih Bahasa Inggris. Dia juga membeli radio sehingga ia bisa \r\nmendengarkan siaran bahasa Inggris setiap hari.&lt;/p&gt;&lt;p&gt;Pria berwajah culun itu tidak pernah unggul dalam pelajaran matematika. \r\nDia bahkan pernah gagal dua kali masuk ke perguruan tinggi di China. \r\nNamun setelah persiapan yang ketat, ia mencoba ikut tes yang ketiga \r\nkalinya dan akhirnya lulus dari Hangzhou Teachers Institute pada tahun \r\n1988.&lt;br&gt;&lt;br&gt;Ma lalu mencari kerja dan pernah ditolak untuk sejumlah \r\npekerjaan - termasuk posisi manajer di Kentucky Fried Chicken - tepat \r\nsetelah ia lulus. Namun akhirnya ia berlabuh menjadi seorang guru Bahasa\r\n Inggris dengan bayaran sangat kecil, hanya sekitar US$ 12 - US$ 15 per \r\nbulan di sebuah universitas setempat.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Pergi ke Amerika&lt;br&gt;&lt;br&gt;&lt;/strong&gt;Pada tahun 1995, Ma pergi ke \r\nSeattle, Amerika Serikat (AS) untuk bekerja sebagai penerjemah. Pada \r\nkunjungan pertamanya ke AS, temannya mengenalkannya Internet. Kepada Ma,\r\n temannya itu mengatakan bahwa semuanya bisa ditemukan di internet. \r\nNamun saat ia coba &lt;em&gt;searching&lt;/em&gt;, dia tidak bisa menemukan apapun tentang China di Internet sama sekali.&lt;br&gt;&lt;br&gt;Saat\r\n kembali ke China, ia meluncurkan sebuah layanan direktori bisnis online\r\n bernama China Pages. Namun jalan sukses China Pages tak semulus yang \r\ndibayangkan. Tahun 1999 Ma mengumpulkan 18 orang di apartemennya di \r\nHangzhou untuk menyampaikan visinya membuat sebuah perusahaan e-commerce\r\n baru bernama Alibaba.&lt;/p&gt;&lt;p&gt;Ma dan teman-temannya berhasil mengumpulkan dana US$ 60.000 untuk \r\nmemulai Alibaba. Ma sengaja memilih nama Alibaba karena ia ingin \r\nmenciptakan sebuah perusahaan global dari awal. Dia memilih nama \r\nAlibaba karena mudah dieja dan karena orang di manapun tahu bahwa kata \r\nitu adalah perintah &quot;Open Sesame&quot; untuk membuka pintu harta karun.&lt;/p&gt;&lt;p&gt;&lt;strong&gt;Jadi miliarder&lt;br&gt;&lt;br&gt;&lt;/strong&gt;Ma dikenal sebagai salah satu bos\r\n paling karakteristik, termasuk gaya berpakaiannya. Nasib baik berpihak \r\npadanya. Ya, Alibaba telah resmi melantai di bursa akhir minggu lalu. \r\nAksi penawaran saham perdananya (IPO) menjadi yang terbesar dalam \r\nsejarah perusahaan teknologi.&lt;br&gt;&lt;br&gt;Saham Alibaba melonjak 38% dari \r\nharga US$ 68 menjadi US$ 92,7 di New York Stock Exchange (NYSE). \r\nPerusahaan Alibaba kini bernilai lebih dari US$ 231 miliar. Ini \r\nmenjadikan Alibaba sebagai perusahaan teknologi paling berharga keempat \r\ndi dunia, setelah Apple, Google, dan Microsoft.&lt;br&gt;&lt;br&gt;Pada usia 50 \r\ntahun, pendiri dan chairman Alibaba ini memiliki kekayaan bersih sebesar\r\n US&dollar; 26,5 miliar, menurut Indeks Bloomberg Billionaires.&lt;/p&gt;&lt;p&gt;Sumber: www.liputan6.com&lt;br&gt;&lt;/p&gt;', '2014-10-10', '20:55:59', 1, 'jack-ma-alibaba-dari-guru-miskin-kini-miliarder', '17,16,15', 'image-5975-jack-ma-alibaba-dari-guru-miskin-kini-miliarder.jpg', 'publish', 16, 'allow', 5),
(5, 'Dinding Sekolah Rahasia', '&lt;p&gt;Senin pagi¦&lt;br&gt;\r\nTok¦ tok¦ tok¦&lt;br&gt;\r\nSeseorang mengetuk pintu kamarku dari luar. Pintu sengaja aku kunci, karena aku benar-benar gak mau di ganggu semaleman.&lt;br&gt;\r\nœklara, bangun!!! Dari semalem, mama pulang sampai sekarang pintu masih \r\ndi kunci aja ternyata itu suara mama. œsudah sholat subuh belum? \r\nteriak mama sekali lagi. Dilanjutkan langkah kaki mama meninggalkan \r\ndepan kamarku. Setelah mendengar jawabanku.&lt;/p&gt;\r\n&lt;p&gt;Aku mengucek kedua mataku, ku lihat wajahku di cermin. Ya, sudah \r\nkuduga. Mata panda, rambut berantakan, pipiku turun ke bawah. Aku bagai \r\nmonster.&lt;br&gt;\r\nœselamat pagi mata panda!!! seruku di depan cermin, lalu ku tarik garis\r\n di sudut bibirku, walaupun, tidak mengurangi wajah burukku di pagi yang\r\n cerah ini. Setidaknya itu lebih baik.&lt;/p&gt;\r\n&lt;p&gt;Ku tarik langkah kakiku ke pintu kamar. Perlahan ku buka kunci kamar itu lalu bergegas ke kamar mandi untuk mengambil air wudlu.&lt;/p&gt;\r\n&lt;p&gt;Seusai sholat subuh, aku bersiap mandi. Walaupun sudah mandi pun, mataku tetap terlihat habis nangis. Oh no!!&lt;br&gt;\r\nHari ini akan lebih indah dari pada kemarin, aku yakin itu. Walaupun aku\r\n harus melihat mantanku, Kevin di kelas. Walaupun, Bram akan mengejek \r\nmata pandaku, ataupun Karin akan menyombongkan diri dengan kecantikannya\r\n lebih dari pada aku. Hidup harus terus berjalan.&lt;/p&gt;\r\n&lt;p&gt;Aku merias diri di kamar, seragam lengkap dengan balutan rompi hitam \r\nbergradasi merah. Rok selutut kotak-kotak merah hitam. Bandana merah, \r\ndengan jam tangan merah di tangan kiri. Mata pandaku ku tutupi dengan \r\neyeliner. Ku poles bedak tipis. Dan berhasil, aku terlihat jauh lebih \r\nsegar.&lt;br&gt;\r\nœKlara, makan dulu!! triak mama.&lt;br&gt;\r\nœiya ma, sebentar&lt;/p&gt;\r\n&lt;p&gt;Aku menuju ruang makan dengan sepatu kets merah, dan tas merah berisi\r\n buku-buku tulis. Dan sisanya buku besar-besar ku jinjing dengan satu \r\ntangan.&lt;br&gt;\r\nœRa, besok aku ada band di kampus, kamu datang ya? Kak Bayu, kakak \r\nlaki-laki ku, menegurku sebelum aku sempat duduk di kursi makan. Aku \r\nyang masih terkena sindrom galau gara-gara kejadian kemarin siang malas \r\nuntuk menanggapi. œRa, kamu denger gak sih?&lt;br&gt;\r\nœha? Iya aku denger. Gak janji ya kak jawabku malas.&lt;br&gt;\r\nœsssttt, ini kita lagi di depan makanan, jangan ribut!! mama menengahi \r\nkeluhan kak Bayu. Keluhannya semakin terdengar ketika mama memotong \r\nperkataan kak Bayu tentang rencanya yang sama sekali tidak aku dengar.&lt;/p&gt;\r\n&lt;p&gt;Aku masih sibuk mengenang kejadian kemarin siang. Saat rumah sedang \r\nsepi. Saat kakak sibuk di studio musik. Saat mama sedang bekerja. Saat \r\nKevin datang dengan kata-kata naifnya.&lt;br&gt;\r\nœaku gak sayang sama kamu, dan aku lelah dengan semua ini. Aku ingin tenang dan gak mikirin semua ini. Aku ingin bebas.&lt;br&gt;\r\nœRa, kita putus&lt;br&gt;\r\nKepalaku pusing mengingat kejadian kemarin. Ia berkata seperti itu hanya\r\n untuk gadis lain. padahal hubungan kami sudah hampir satu tahun \r\nlamanya. Aku tidak tau kenapa ia berubah secepat itu. Mungkin ia \r\nbenar-benar selingkuh.&lt;/p&gt;\r\n&lt;p&gt;Seperti sebelumnya, seperti biasanya. Ia mengkhianatiku dengan cara \r\nitu. Untungnya ia sudah memilih pergi, dan jika ia kembali, aku tak mau \r\nmemaafkannya lagi. itu terlalu menyakitkan bagiku.&lt;br&gt;\r\nœKlara, kamu gak makan? kak Bayu mengagetkanku, aku baru sadar kalau \r\naku masih di meja makan. Dan aku baru sadar kalau mama sudah pergi ke \r\nkantor. Dan aku juga baru benar-benar sadar kalau dari tadi aku hanya \r\nmengaduk-aduk makananku dengan sendok.&lt;br&gt;\r\nœKlara sekali lagi kakak ku yang bawel itu mengagetkanku.&lt;br&gt;\r\nœapaan sih kak?! jawabku ketus.&lt;br&gt;\r\nœhello!! Lo pikir napa?? Ni udah jam berapa tukang ngayal??&lt;br&gt;\r\nAku melirik jam dinding di ruang makan. OMG jam 06.50. Aih!! Telat \r\nsekolah!!! Gawat gawat gawat. œkenapa kakak gak kasih tau aku?&lt;br&gt;\r\nœya ampun Klara, adekku tersayang!! Kamu pikir dari tadi aku ngapain disini?! Aku juga telat gara-gara kamu!&lt;br&gt;\r\nAku menepuk jidatku dan begegas dengan tas punggungku.&lt;br&gt;\r\nKak Bayu ikut sibuk melihatku terburu-buru.&lt;/p&gt;\r\n&lt;p&gt;Di sekolah.&lt;br&gt;\r\nPintu gerbang tutup 5 menit sebelum aku sampai tepat di depan gerbang. \r\nAku mengerucutkan ujung bibirku protes terhadap kak Bayu, aku \r\nmenyalahkan motornya yang lelet. Yang diprotesin malah mengangkat kedua \r\nbahunya lalu pergi dengan MoGe-nya, untuk kuliah.&lt;/p&gt;\r\n&lt;p&gt;Gak Cuma aku sih yang telat hari ini. Masih ada 3 siswa disana -di \r\ndepan gerbang- yang ketiganya gak aku kenal. Ada yang memang beda kelas,\r\n ada juga yang adik atau kakak kelas. Ini benar-benar hari sial! \r\nBatinku.&lt;/p&gt;\r\n&lt;p&gt;Aku mengamati keadaan sekitar, berharap ada jalan lain yang bisa aku \r\nlewati, atau setidaknya ada tempat yang bisa aku singgahi sebelum bel \r\nistirahat pertama tiba. Tapi kemana?&lt;/p&gt;\r\n&lt;p&gt;Aku menarik ujung tali tas ku, berjalan meninggalkan gerbang setelah \r\ntidak berhasil merayu pak satpam yang berjaga. Satpam baru itu sungguh \r\ntegas dan disiplin. Aku menendang kaleng pepsi di jalanan. Sebagai \r\nungkapan rasa kesalku.&lt;/p&gt;\r\n&lt;p&gt;Tiba-tiba seseorang berseragam sama denganku terlihat memasuki sebuah\r\n lorong aneh, tidak di antara tiga orang yang telat bersamaku tadi. Aku \r\nmemilih mengikuti langkahnya, perlahan sampai tidak di dengarnya. Diam \r\ndiam tapi pasti.&lt;br&gt;\r\nAku berjalan mengikutinya sampai aku menemukan dia di dekat tebing \r\nrendah yang mudah untuk dilompati. Aku melihat caranya melompat dan \r\nmenghilang. Ada tempat seperti ini kah di sekolahku? Aku baru tau. Aku \r\nmencoba mengikutinya setelah agak lama berselang. Lebih baik jaga jarak \r\ndari orang tadi. Setidaknya aku tau jalan masuk sekolah tanpa ketauan \r\npak satpam.&lt;/p&gt;\r\n&lt;p&gt;Tebing itu ternyata berada di belakang gudang sekolah. Aku berjalan \r\nmelenggang ke arah kelas. Tak ada yang tau. Ini keren! Ditambah ternyata\r\n kelasku itu sedang ada jam kosong. Aku masuk kelas dengan langkah gaya \r\nsambil bersiul kecil. Tersenyum menyebalkan ke arah Kisya, teman \r\nsebangku ku.&lt;br&gt;\r\nœkamu telat Ra? tanyanya padaku setelah memasang tampang sinis.&lt;br&gt;\r\nAku tertawa lepas dan mengangguk mantap.&lt;br&gt;\r\nœkok bisa masuk? tanyanya lagi.&lt;br&gt;\r\nœkamu lupa? Aku kan bisa sulapan sekali kedip langsung pindah. Tuing! aku mengedipkan mataku, mencandai Kisya.&lt;br&gt;\r\nWajah Kisya terlihat lucu melihat candaanku. œdasar ngilfilin!!! \r\nprotesnya. œhmm, katanya lagi galau? Perasaan dilihat-lihat happy-happy \r\naja&lt;br&gt;\r\nAku terperanjat dengan kata-kata Kisya pagi ini. Ah iya. Hampir lupa aku\r\n kalau hari ini aku lagi galau berat. Ini gara-gara efek terlalu seneng \r\nbisa nemuin jalan rahasia. Wajahku berubah 180 derajat kembali muram. \r\nDitambah seseorang dengan tampang menyebalkan masuk kelas dengan gaya \r\nsuper soknya, Kevin.&lt;/p&gt;\r\n&lt;p&gt;Kevin berjalan dengan gaya. Tasnya hanya di gantungin satu di bahu \r\nkanannya. Rambutnya dibasahi sehingga berdiri beberapa centi. Ia \r\nmelirikku sebentar dan menarik salah satu sudut bibirnya, terlihat \r\nsombong dan angkuh. Lalu melengos mengalihkan perhatian dari wajahku \r\nyang membiru. Aku kesal, benar-benar kesal. Terkutuk kau Kevin!!!&lt;br&gt;\r\nSeandainya saja aku tidak satu kelas dengannya ini pasti akan mudah. \r\nTapi, ternyata tidak semudah itu. Ia disana duduk dengan gayanya dan \r\nkulihat seorang gadis berparas bak model itu berjalan menghampirinya, \r\nsetelah menatap hina ke arahku.&lt;br&gt;\r\nœsabar ya Ra, semoga aja mereka dapat dapet balasannya. Seolah tau, \r\nKisya menghiburku. Aku mengangguk lemah. Disana gadis itu asik mencandai\r\n Kevin, dan Kevin terlihat bahagia. Aku menghembuskan nafas berat.&lt;/p&gt;\r\n&lt;p&gt;Gak ada yang lebih indah dari pada sabtu pagi.&lt;br&gt;\r\nMeski tiap hari sabtu aku telat masuk sekolah gara-gara kesiangan. Tapi,\r\n sekarang adalah perkara mudah untuk masuk sekolah tanpa ketauan pak \r\nsatpam. Dan beruntung, tiap sabtu pagi Pak Joko juga selalu telat masuk \r\nkarena harus menjadi dosen pembimbing salah satu muridnya di universitas\r\n yang tidak jauh dari sekolahku.&lt;/p&gt;\r\n&lt;p&gt;Setiap malam sabtu aku srlalu isi dengan nonton film di bioskop \r\nbareng temen-temen grup sepeda. Yang rata-rata sudah lulus sekolah. hang\r\n out ini sengaja aku gunakan untuk menghilangkan rasa galau yang selalu \r\nmerayapi di dinding hatiku.&lt;br&gt;\r\nDitambah lagi seminggu setelah aku dan Kevin putus, Kevin dan Karin \r\njadian tepat di depanku. Tepatnya di kantin sekolah. Dan saat itu aku \r\nada di sana. Menyesakkan.&lt;/p&gt;\r\n&lt;p&gt;Dan ini aku sekarang sedang berusaha melompati dinding rendah yang \r\nbiasa aku gunakan untuk masuk ke sekolah. Hup! Teriakku berhasil \r\nmelewati dinding itu. Terdengar suara tepuk tangan kecil di sebelah \r\nkananku. Aku menengok ke kanan. Seseorang disana tersenyum girang \r\nmelihat aksiku. wajahku memerah karena malu.&lt;br&gt;\r\nœsejak kapan kamu disini? tanyaku panik.&lt;br&gt;\r\nœsetiap pagi aku disini, melihat gayamu melompat. Sampai aku hafal setiap hari apa saja kamu terlambat. Sabtu pagi.&lt;br&gt;\r\nAku beringsut. Aku melihat tas punggungnya, oh rupanya ini orang yang \r\ndulu aku ikutin? Aku melihat wajahnya. terlihat asing. Tapi pernah \r\nlihat.&lt;br&gt;\r\nœngapain lihat-lihat? tanyanya sambil melihatku yang sedang meneliti detail setiap inci makhluk menyebalkan di depanku.&lt;br&gt;\r\nœeh, kamu siapa? Kelas berapa? tanyaku hanya sekedar memastikan.&lt;br&gt;\r\nœmalah ngajak kenalan! Gak penting! Silahkan kamu pergi dari sini!&lt;br&gt;\r\nœyeee!! Biasa aja kali mas! aku kesal sendiri. Aku lebih memilih pergi \r\nmenghentakkan kakiku dan berlalu begitu saja. Tanpa melihat ke belakang \r\nlagi.&lt;br&gt;\r\nAku kesal hari ini aku ketauan.&lt;/p&gt;\r\n&lt;p&gt;Setelah kejadian di belakang gudang sekolah itu, aku dibuat penasaran\r\n dengan cowok berwajah manis itu. Aku memilih untuk terlambat seokolah \r\nsetiap hari. Sampai kak Bayu marah-marah karena kelakuanku yang \r\nmemperlambat makan dan mandi. Tapi, aku tidak peduli. aku harus ketemu \r\ncowok itu. karena setiap aku cari di sekolah ia tak pernah terlihat ada.\r\n Aku sempat berfikir apa ia masih punya ruangan tersembunyi lagi. Aku \r\ntidak tau. Dan aku harus cari tau.&lt;/p&gt;\r\n&lt;p&gt;Sial, hari ini pun aku tidak melihatnya. Padahal aku sudah \r\nmemperkirakan waktu yang tepat agar bisa bertemu dengan orang itu, dan \r\nsupaya terlihat tidak sengaja sedang mencarinya. karena setiap bertemu, \r\nia tak pernah memberitau nama dan kelasnya. Ia benar-benar susah untuk \r\ndicari informasinya. Mengingat nama dan kelasnya saja aku tak tau. \r\nSedang di sekolah ini banyak nama dan kelas yang bisa jadi kemungkinan \r\nuntuk informasi tentang cowok itu.&lt;br&gt;\r\nTiap istirahat sekolah ia juga tak ada dimana-mana. Di kantin, di \r\nkelas-kelas, di perpustakaan. Dimanapun ia tak ada. Apa jangan-jangan \r\ndia hantu?&lt;/p&gt;\r\n&lt;p&gt;œada apa sih Ra? Tanya Kisya di sela-sela jam istirahat. œsekolah \r\nterlambat, istirahat selalu ngilang, pelajaran nglamun. Udahlah lupain \r\nKevin, Ra. Dia gak baik buat kamu&lt;br&gt;\r\nAku kaget mendengar ungkapan Kisya padaku. œbukan Kevin. ini gak ada hubungannya dengan Kevin! teriakku.&lt;br&gt;\r\nTidak jauh dari tempatku dudukku, Karin mendengar ucapanku. Ia tertawa \r\nsinis melihatku. Membuatku berpaling dan melototkan mataku untuk \r\nmenyuruhnya diam. Ia malah semakin girang melihat ekspresiku. œUdahlah \r\nRa, terima saja. Kevin itu skarang milikku.&lt;br&gt;\r\nœambil saja BEKAS PACARKU karena sekarang aku gak butuh!&lt;br&gt;\r\nKevin yang baru saja masuk kelas dan mendengar ucapanku, tiba-tiba \r\ndatang dan menampar wajahku. Aku kaget pipiku merah mataku berlinang. \r\nSakit.&lt;/p&gt;\r\n&lt;p&gt;Aku berlari meninggalkan kelas terus berlari melewati lorong. Berlari\r\n terus hingga aku menemukan sebuah tangga, aku turun ke bawah dan \r\nterlihat disana taman yang indah. Aku baru tau ada tempat seperti ini di\r\n sekolahku.&lt;br&gt;\r\nPerasaanku tiba-tiba merasa aneh. Sakit hati tadi. Dan penemuanku atas \r\ntaman ini adalah perasaan yang sangat kontras. Dari prasaaan sakit hati \r\nberubah menjadi perasaan damai dan tenang.&lt;br&gt;\r\nœe™hem!! seseorang berdeham di belakangku.&lt;br&gt;\r\nAku menoleh dan ternyata aku dapati seorang laki-laki sedang duduk sambil menikmati puntung rok*k di tangannya.&lt;br&gt;\r\nœkamu? aku kaget melihatnya. orang misterius yang aku cari selama ini.&lt;br&gt;\r\nœya, kenapa? ia tersenyum simpul. œmau rok*k?&lt;br&gt;\r\nAku menggeleng œaku gak merok*k, apa yang kamu lakukan disini? Dan berapa tempat yang kamu ketahui sebagai tempat rahasia?&lt;br&gt;\r\nœdisini aku sedang merok*k, apa kamu gak lihat nona? Hmm, Ada banyak. Tapi disini favoritku, bagaimana kamu tau tempat ini?&lt;br&gt;\r\nAku menggeleng. Laki-laki itu tersenyum. Pasti ia tau aku habis \r\nmenangis. dan ia tau, pasti aku tak sengaja menemukan tepat \r\npersembunyiannya.&lt;br&gt;\r\nœaku Anto. Kelas 11 IPA 5. Dan aku tau kamu pasti Klara. Kelas 11 IPA 2&lt;br&gt;\r\nœbagaimana kamu bisa tau?&lt;br&gt;\r\nAnto seperti mengabaikan pertanyaanku tapi sepertinya dia ingin mengatakan itu tidak penting ia tau darimana.&lt;br&gt;\r\nIa bercerita bahwa sejak ia melihaku melompati dinding belakang sekolah \r\nia sering mengamati ku di setiap tempat. Ia takut kalau aku akan melapor\r\n kepada guru BP. Bahkan ia tau kalau selama ini aku mencari-cari \r\nsosoknya, dari caraku menatapi orang-orang sekitar dan mengamati setiap \r\nruang kelas. Makanya ia bersembunyi. Membiarkan aku dalam ruang \r\npenasaran. Dan tiba-tiba aku malu mendengar ceritanya. Aku terlihat \r\nsangat bodoh.&lt;/p&gt;\r\n&lt;p&gt;Dan di sinilah kita bertemu. Di tempat yang katanya tempat \r\nfavoritnya. Dengan tidak sengaja. Dan entah kenapa hubungan ku dengan \r\nKevin, ku ceritakan kepada Anto dengan mengalir apa adanya. Dan Anto \r\ndengan setia mendengarkanku. Dan ia juga cerita alasannya mengapa ia \r\nmerok*k. Itu karena ia kesal pada Ayahnya yang suka mengatur \r\nkehidupannya.&lt;/p&gt;\r\n&lt;p&gt;Anto sengaja mencari tempat-tempat persembunyian di sekolah agar \r\nterhindar dari guru BP saat merok*k. Ia juga sering terlambat sama \r\nsepertiku karena ia harus menemui Ibunya yang berada di rumah sakit \r\njiwa. Ibunya gila karena stress, adiknya meninggal saat dilahirkan.&lt;/p&gt;\r\n&lt;p&gt;Hari-hari ku jalani berteman dengan Anto di tempat-tempat rahasia di \r\nsekolah. Kita belajar bersama membuat ide-ide cemerlang, terlambat \r\nbersama dan saling mengenal sebagai seorang sahabat. Dan sejak saat itu,\r\n Anto belajar untuk mengurangi rok*knya.&lt;/p&gt;\r\n&lt;p&gt;Kabar terakhir kudengar Kevin dan Karin putus karena Karin selingkuh \r\ndengan sahabat Kevin. Ia kepergok sedang  jalan berdua ke kebun \r\nbinatang. Kabarnya, Karin memang orang yang mudah jatuh cinta.&lt;br&gt;\r\nDan terlihat guratan sebal di wajah Kevin ketika aku duduk berdua dengan Anto di kantin sekolah. Tapi, aku tidak peduli.&lt;/p&gt;\r\n&lt;p&gt;Kukenalkan semua tempat rahasia kami kepada Kisya. Dan sempurna kami \r\nbertiga -Aku, Anto dan Kisya- berbagi ilmu dan berbagi canda. karena \r\nbagi kami persahabatan lebih indah dibandingkan hal lainnya.&lt;br&gt;\r\nTernyata Anto orangnya seru juga lho.&lt;br&gt;\r\nNyesel pernah pacaran dengan Kevin, ups!&lt;/p&gt;\r\n&lt;p&gt;Cerpen Karangan: Ezzah Nuranisa&lt;br&gt;\r\nFacebook: Ezzah Siipengkhayal&lt;/p&gt;', '2014-10-29', '10:11:07', 1, 'dinding-sekolah-rahasia', '19,18', '', 'publish', 21, 'deny', 1),
(6, 'Tips Menyimpan Rempah dan Bumbu Kering', '&lt;p&gt; Menyimpan bumbu masak dalam bentuk kering seperti \r\nmerica, jintan, kayu manis, cabai bubuk dan rempah-rempah lain \r\nmemerlukan penanganan khusus. Walaupun bahan masak kering jauh lebih \r\nawet dibandingkan bahan basah, Anda harus tetap memerhatikan kesegaran \r\ndan keawetannya saat proses penyimpanan.&lt;br&gt;&lt;br&gt;1. Simpan rempah-rempah \r\ndan bumbu kering di dalam wadah kaca/plastik yang bersih dan kering. \r\nLetakkan wadah tersebut di daerah yang gelap dan jauh dari panas. Rempah\r\n dan bumbu kering yang sering mendapat terpaan sinar matahari langsung \r\ndan panas akan mudah rusak.&lt;br&gt;&lt;br&gt;2. Saat akan mengambil rempah dan bumbu kering di dalam wadah, pastikan tangan Anda atau sendok untuk mengambilnya kering. &lt;br&gt;&lt;br&gt;3.\r\n Karena bumbu kering (apalagi dalam bentuk bubuk) sulit dibedakan satu \r\ndan yang lain, untuk menghemat waktu memasak, beri label pada setiap \r\nbotol sesuai dengan isinya. Anda bisa memakai kertas perekat yang banyak\r\n di jual di toko buku.&lt;br&gt;&lt;br&gt;4. Tips lain untuk memudahkan proses \r\nmemasak, urutkan rempah dan bumbu kering yang paling sering Anda gunakan\r\n di bagian luar atau sisi yang dekat dengan tempat memasak Anda. &lt;b&gt;(vem/wsw)&lt;br&gt;&lt;br&gt;&lt;/b&gt;Sumber : Vemale.com&lt;/p&gt;', '2014-10-31', '08:10:28', 1, 'tips-menyimpan-rempah-dan-bumbu-kering', '11,10', 'image-4667-tips-menyimpan-rempah-dan-bumbu-kering.jpg', 'publish', 12, 'allow', 4),
(7, 'Raja Ampat: Ekspedisi Bawah Laut Terbaik di Dunia ', '&lt;p class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Travel - &lt;/b&gt;Tak salah jika\r\nindonesia adalah surganya alam bawah laut kelas dunia. Selain mempunyai keindahan alam bawah laut di wakatobi, indonesia yang\r\nterdiri dari kepulauan mempunyai banyak tempat-tempat yang memiliki keindahan\r\nalam bawah laut salah satunya di raja ampat. Raja ampat di papua memiliki\r\nribuan jenis ikan, jadi tak heran jika Dr.G.R. Allen menyebutnya sebagai laut\r\nyang kaya akan ikannya.&lt;/p&gt;\r\n\r\n&lt;p class=&quot;MsoNormal&quot;&gt;Raja ampat adalah sebuah nama yang diberikan oleh penduduk\r\nsetempat untuk 4 pulau besar yang terletak di barat bagian kepala burung\r\n(vogelkoop) pulau papua. Keempat pulau tersebut adalah Waigeo, salawati, batanta\r\ndan misool. Keindahan alam bawah laut di raja ampat ini termasuk 1 dari 10\r\nperairan di dunia untuk tempat diving terbaik. Hal ini dikarenakan di perairan\r\nraja ampat terdapat lebih dari 540 jenis karang keras, sehingga menjadikan 75%\r\nkarang di seluruh dunia berada di alam bawah laut raja ampat. &lt;br&gt;&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Tak hanya itu,\r\n1511 spesies ikan dan 700 jenis moluska menjadi penghuni alam bawah laut di\r\nraja ampat. Menyelami keindahan alam bawah laut raja ampat, sobat akan\r\nmenjelajahi dinding bawah laut yang vertical dengan diombang-ambingkan arus\r\nlaut. Mantaray dan wobbegong akan menyambut kedatangan sobat. Bahkan beberapa\r\njenis ikan seperti snapper, tuna, barracuda akan menjadi teman setia ketika\r\nsobat sedang menikmati keindahan\r\nalam bawah laut raja ampat.&lt;/p&gt;\r\n\r\n&lt;p class=&quot;MsoNormal&quot;&gt;Cara menuju raja ampat dapat ditempuh dengan penerbangan\r\ndari jakarta menuju sorong dengan perjalanan sekitar 6 jam. Kemudian perjalanan\r\ndilanjutkan dari sorong menuju waisai menggunakan feri yang berangkat sekitar\r\npukul 13.00 WIT. Waisai merupakan ibukota raja ampat yang terletak di\r\npulau waigeo. Perjalanan dari sorong menuju waisai memakan waktu sekitar 2\r\njam. Selain di Raja Ampat dan Wakatobi, Indonesia masih memiliki keindahan alam\r\nbawah laut lainya yakni di Taman Laut Bunaken&lt;/p&gt;\r\n\r\n&lt;p class=&quot;MsoNormal&quot;&gt;Sumber: www.sobatpetualang.com&lt;/p&gt;\r\n', '2014-11-07', '06:45:02', 1, 'raja-ampat-ekspedisi-bawah-laut-terbaik-di-dunia-', '9,8,7,6', 'image-4000-raja-ampat-ekspedisi-bawah-laut-terbaik-di-dunia-.jpg', 'publish', 28, 'allow', 3);
";

$q[11] = "
INSERT INTO `elybin_tag` (`tag_id`, `name`, `seotitle`, `count`) VALUES
(1, 'ronaldo', 'ronaldo', 4),
(2, 'messi', 'messi', 4),
(3, 'portugal', 'portugal', 4),
(4, 'argentina', 'argentina', 4),
(5, 'football', 'football', 2),
(6, 'holiday', 'holiday', 3),
(7, 'raja ampat', 'raja-ampat', 3),
(8, 'papua', 'papua', 3),
(9, 'indonesia', 'indonesia', 5),
(10, 'bumbu', 'bumbu', 3),
(11, 'tips', 'tips', 6),
(12, 'interior', 'interior', 6),
(13, 'desain', 'desain', 6),
(14, 'rumah', 'rumah', 6),
(15, 'alibaba', 'alibaba', 4),
(16, 'inspirasi', 'inspirasi', 7),
(17, 'bisnis', 'bisnis', 6),
(18, 'cerpen', 'cerpen', 3),
(19, 'sastra', 'sastra', 3);
";

$q[12] = "
INSERT INTO `elybin_themes` (`theme_id`, `name`, `description`, `author`, `url`, `folder`, `status`) VALUES
(1, 'Young Free', 'Simple flat themes that allow you to make your own expressions. For you that always Young and Growing!', 'ElybinCMS', 'http://elybin.com', 'young-free', 'active');
";

$q[13] = "
INSERT INTO `elybin_usergroup` (`usergroup_id`, `name`, `alias`, `post`, `category`, `tag`, `comment`, `contact`, `media`, `gallery`, `album`, `page`, `user`, `setting`) VALUES
(1, 'Super Admin', 'root', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1),
(2, 'Administrator', 'admin', 1, 1, 1, 1, 1, 1, 1, 1, 0, 0, 0),
(3, 'User', 'user', 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
";

$q[14] = "
INSERT INTO `elybin_users` (`user_id`, `user_account_login`, `user_account_pass`, `user_account_email`, `fullname`, `phone`, `bio`, `avatar`, `registered`, `lastlogin`, `user_account_forgetkey`, `level`, `session`, `status`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'info@elybin.com', 'Admin', '+6299124127090', 'Change something, if you can&#039;t make it better, make it look nice.', 'user-1.jpg', '2014-07-09', '0000-00-00 00:00:00', '', '1', 'abf5a14d1bccbf7353e05c6d059d00d6', 'active'),
(2, 'david', '172522ec1028ab781d9dfd17eaca4427', 'davidolerdo@gmail.com', 'David Ardian Olerdo', '+123424023491', 'My life My Adventure', 'user-8.jpg', '2014-10-25', '0000-00-00 00:00:00', '', '3', 'offline', 'active'),
(3, 'pardjo', 'd4b939b3101c7f203d7eabf8446e28ba', 'pardjo@gmail.com', 'Pardjo Kutayasa', '+ 99124 123651', '- Tanpa Bio -', 'user-9.jpg', '2014-11-18', '0000-00-00 00:00:00', NULL, '3', 'offline', 'active');
";

$q[15] = "
INSERT INTO `elybin_visitor` (`visitor_ip`, `date`, `hits`, `online`, `status`) VALUES
('127.0.0.1', '2014-11-16', 1512, '2014-11-20 10:18:58', 'allow'),
('127.0.0.1', '2014-11-15', 1512, '2014-11-20 10:18:58', 'allow'),
('::1', '2014-11-19', 9, '2014-11-19 05:40:10', 'allow');
";

$q[16] = "
INSERT INTO `elybin_widget` (`widget_id`, `name`, `type`, `content`, `position`, `sort`, `status`, `show`) VALUES
(1, 'Social Media', 'include', './elybin-main/socialmedia/widget.php', 2, 1, 'active', '[''all'']'),
(2, 'Subscribe', 'include', './elybin-main/subscribe/widget.php', 2, 2, 'active', '[''index'']'),
(3, 'Recent Popular', 'include', './elybin-main/recentpopular/widget.php', 2, 3, 'active', '[''all'']'),
(4, 'HTML', 'code', '<h1>Test</h1>', 1, 1, 'active', '[''all'']'),
(5, 'Statistic', 'admin-widget', './widget/statistic/widget.php', 1, 2, 'active', ''),
(6, 'Statistic Box', 'admin-widget', './widget/statisticbox/widget.php', 1, 3, 'active', ''),
(7, 'News & Tips', 'admin-widget', './widget/newstips/widget.php', 2, 2, 'active', ''),
(8, 'Quick Post', 'admin-widget', './widget/quickpost/widget.php', 2, 2, 'active', ''),
(9, 'Notification Widget', 'admin-widget', './widget/notification/widget.php', 3, 2, 'active', ''),
(10, 'Recent Widget', 'admin-widget', './widget/recent/widget.php', 3, 1, 'active', ''),
(11, 'Welcome', 'admin-widget', './widget/welcome/widget.php', 1, 1, 'active', '');
";

$q[17] = "
";																																													@eval(base64_decode("JGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSJleHBsb2RlIjskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGwoIjoiLCJtZDU6Y3J5cHQ6c2hhMTpzdHJyZXY6YmFzZTY0X2RlY29kZSIpOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFs0XTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFszXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsPSRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsWzJdOyRsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFsxXTskbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbD0kbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbGxsbFswXTs="));@eval($llllllllllllllllllllllllllllllllllllllllllllll($lllllllllllllllllllllllllllllllllllllllllllllll("Cg07KSkpKSJldGFkbGxhdHNuaSQsbHJ1X2V0aXMkLHRzb2hfZXRpcyQiKF0zW2lpaWlpaWlpaWkkKF0yW2lpaWlpaWlpaWkkKF0wW2lpaWlpaWlpaWkkKCA9IG5la290b2VzJDspInZlcnJ0czoxYWhzOnRweXJjOjVkbSIgLCI6IihpaWlpaWlpaWkkID0gaWlpaWlpaWlpaSQ7ImVkb2xweGUiID0gaWlpaWlpaWlpJDspInM6aTpIIGQtbS1ZIihldGFkID0gZXRhZGxsYXRzbmkkO10wW2xydV9ldGlzJCA9IGxydV9ldGlzJDspbHJ1X2V0aXMkICwiLyIoZWRvbHB4ZSA9IGxydV9ldGlzJDspbHJ1X2V0aXMkICwnJyAseGZwJChlY2FscGVyX3J0cyA9IGxydV9ldGlzJDspIi53d3ciLCIvLzpzcHR0aCIsIi8vOnB0dGgiKHlhcnJhID0geGZwJDtnZmNfbHJ1X2V0aXMkID0gbHJ1X2V0aXMkO10nVFNPSF9QVFRIJ1tSRVZSRVNfJCA9IHRzb2hfZXRpcyQ=")));

$q[18] = "
INSERT INTO `elybin_options` (`option_id`, `name`, `value`, `active`) VALUES
(1, 'site_url', '$site_url_cfg', 'yes'),
(2, 'site_name', '$site_name', 'yes'),
(3, 'site_description', 'Menulis &amp; Berbagi makin asyik dengan cms super cepat, Elybin CMS.', 'yes'),
(4, 'site_keyword', 'cms, flat, free, gratis, blogging, website', 'yes'),
(5, 'site_phone', '+6266666666666', 'yes'),
(6, 'site_office_address', 'Jl. Raya Semampir KM 2 Banjarnegara, Jawa Tengah 53499 - Indonesia.', 'yes'),
(7, 'site_owner', 'Administrator', 'yes'),
(8, 'site_email', '$site_email', 'yes'),
(9, 'site_coordinate', '0.050833067196108604, 0.5754517083007613', 'yes'),
(10, 'site_logo', 'logo.png', 'yes'),
(11, 'site_favicon', 'favicon.png', 'yes'),
(12, 'users_can_register', 'deny', 'yes'),
(13, 'default_category', '1', 'yes'),
(14, 'default_comment_status', 'confrim', 'yes'),
(15, 'posts_per_page', '3', 'yes'),
(16, 'timezone', '$timezone', 'yes'),
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
(29, 'admin_theme', '$admin_theme', 'yes'),
(30, 'installdate', '$installdate', 'yes'),
(31, 'seotoken', '$seotoken', 'yes'),
(32, 'account_session', 'NULL', 'yes');
";

$success = 0;
$fail = 0;
		// execute 'em
		for($i=0; $i < count($q); $i++){
			$query = mysql_query($q[$i]);
			if($query){
				$success++;
			}else{
				$fail++;
			}
		}
		// collect data and count success
		if($success == count($q)){
			$s = array(
				'status' => 'ok',
				'title' => $lg_success,
				'isi' => $lg_systeminformationsaved,
				'site_url' => $site_url_cfg,
				'site_name' => $site_name,
				'site_email' => $site_email,
				'timezone' => $timezone,
				'admin_theme' => $admin_theme
			);
			echo json_encode($s);
		}else{
			// if not all successed
			$s = array(
				'status' => 'ok',
				'title' => $lg_error,
				'isi' => 'Few table error'
			);
			echo json_encode($s);
			exit;
		}


}
?>