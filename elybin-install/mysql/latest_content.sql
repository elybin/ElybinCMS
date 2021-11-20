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

INSERT INTO `elybin_comments` (`comment_id`, `author`, `email`, `visitor_id`, `date`, `content`, `status`, `post_id`, `user_id`, `parent`, `reply`) VALUES
(1, 'BAYU GUNTUR V', 'bayu@emil.com', 1, '2015-06-20 09:26:00', 'Membuat website hanya beberapa klik!, website saya sudah jadi! keren! ', 'active', 4, 0, 0, 'yes'),
(2, 'ELYBIN CMS', 'elybin.inc@gmail.com', 1, '2015-06-20 09:26:00', 'Bantu kami mengembangkan produk buatan Indonesia! Ayo pakai Elybin CMS www.elybin.github.io Gratis!', 'active', 4, 0, 0, 'yes');

-- --------------------------------------------------------

--
-- Dumping data for table `elybin_media`
--

INSERT INTO `elybin_media` (`media_id`, `title`, `description`, `metadata`, `filename`, `hash`, `type`, `mime`, `size`, `date`, `share`, `download`, `media_password`) VALUES
(1, 'Candi-Plaosan-Klaten-David-Raka.jpg', '', '{"FileName":"candiplaosanklatendavidraka-2015-07-01_01-48-22-6539.jpg","FileDateTime":1435708102,"FileSize":307905,"FileType":2,"MimeType":"image\\/jpeg","SectionsFound":"ANY_TAG, IFD0, THUMBNAIL, EXIF, INTEROP","COMPUTED":{"html":"width=\\"4272\\" height=\\"1706\\"","Height":1706,"Width":4272,"IsColor":1,"ByteOrderMotorola":0,"CCDWidth":"22mm","ApertureFNumber":"f\\/5.0","UserComment":null,"UserCommentEncoding":"UNDEFINED","Thumbnail.FileType":2,"Thumbnail.MimeType":"image\\/jpeg"},"ImageWidth":4272,"ImageLength":2848,"BitsPerSample":[8,8,8],"PhotometricInterpretation":2,"Make":"Canon","Model":"Canon EOS 1100D","Orientation":1,"SamplesPerPixel":3,"XResolution":"720000\\/10000","YResolution":"720000\\/10000","ResolutionUnit":2,"Software":"Adobe Photoshop CS5 Windows","DateTime":"2015:07:01 06:37:07","YCbCrPositioning":2,"Exif_IFD_Pointer":288,"THUMBNAIL":{"Compression":6,"XResolution":"72\\/1","YResolution":"72\\/1","ResolutionUnit":2,"JPEGInterchangeFormat":1394,"JPEGInterchangeFormatLength":2712},"ExposureTime":"1\\/30","FNumber":"5\\/1","ExposureProgram":1,"ISOSpeedRatings":1600,"UndefinedTag:0x8830":2,"UndefinedTag:0x8832":1600,"ExifVersion":"0230","DateTimeOriginal":"2015:01:09 18:26:30","DateTimeDigitized":"2015:01:09 18:26:30","ComponentsConfiguration":"\\u0001\\u0002\\u0003\\u0000","ShutterSpeedValue":"327680\\/65536","ApertureValue":"303104\\/65536","ExposureBiasValue":"0\\/1","MeteringMode":5,"Flash":16,"FocalLength":"43\\/1","UserComment":"\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000\\u0000","SubSecTime":"90","SubSecTimeOriginal":"90","SubSecTimeDigitized":"90","FlashPixVersion":"0100","ColorSpace":1,"ExifImageWidth":4272,"ExifImageLength":1706,"InteroperabilityOffset":1268,"FocalPlaneXResolution":"4272000\\/905","FocalPlaneYResolution":"2848000\\/595","FocalPlaneResolutionUnit":2,"CustomRendered":0,"ExposureMode":1,"WhiteBalance":0,"SceneCaptureType":0,"UndefinedTag:0xA430":null,"UndefinedTag:0xA431":"268074047882","UndefinedTag:0xA432":["18\\/1","55\\/1","0\\/0","0\\/0"],"UndefinedTag:0xA434":"EF-S18-55mm f\\/3.5-5.6 IS II","UndefinedTag:0xA435":"0000331b67","InterOperabilityIndex":"R98","InterOperabilityVersion":"0100"}', 'candiplaosanklatendavidraka-2015-07-01_01-48-22-6539.jpg', '4c1255e28541fba04f67544d0ec23f0d', 'image', 'image/jpeg', 307905, '2015-07-01 01:48:27', 'yes', 0, '');

-- --------------------------------------------------------
--
-- Dumping data for table `elybin_menu`
--

INSERT INTO `elybin_menu` (`menu_id`, `parent_id`, `menu_title`, `menu_url`, `menu_class`, `menu_position`) VALUES
(1, 0, 'Home', 'index.html', '', 1),
(2, 0, 'About', 'page-5-tentang-elybin-cms--website-professional-tanpa-repot.html', '', 2),
(3, 0, 'Contact', 'contact.html', '', 6),
(4, 0, 'Lainya', 'http://www.elybin.github.io', '', 4),
(5, 4, 'Unduh', 'http://www.elybin.github.io', '', 1),
(6, 4, 'Fitur', 'page-2-fitur.html', '', 2),
(7, 4, 'Peta', 'map.html', '', 3),
(8, 0, 'Gallery', 'gallery.html', '', 3);
-- --------------------------------------------------------



--
-- Dumping data for table `elybin_message`
--

INSERT INTO `elybin_message` (`mid`, `subject`, `msg_body`, `msg_date`, `msg_type`, `msg_priority`, `msg_status`, `msg_status_recp`, `to_uid`, `from_uid`, `from_email`, `from_name`) VALUES
(1, 'Selamat Datang', 'Selamat Datang, Terimakasih telah berkontribusi mengembangkan karya anak bangsa. I love Indonesia :)', '2015-06-18 07:31:26', 'message', 'normal', 'sent', 'received', 1, 0, 'elybin.inc@gmail.com', 'Elybin CMS');

-- --------------------------------------------------------



INSERT INTO `elybin_options` (`option_id`, `name`, `value`, `active`) VALUES
(1, 'site_url', 'http://localhost/', 'yes'),
(2, 'site_name', 'Your Website', 'yes'),
(3, 'site_description', 'Menulis dan Berbagi makin asyik dengan Elybin CMS.', 'yes'),
(4, 'site_keyword', 'elybin, cms, indonesian, free, open source, gratis, blogging, website', 'yes'),
(5, 'site_phone', '-', 'yes'),
(6, 'site_office_address', 'Banjarnegara, Jawa Tengah 53499 - Indonesia.', 'yes'),
(7, 'site_owner', 'Administrator', 'yes'),
(8, 'site_email', 'hi@yourwebsite.com', 'yes'),
(9, 'site_coordinate', '-7.398439382, 109.6710650', 'yes'),
(10, 'site_logo', 'logo.png', 'yes'),
(11, 'site_favicon', 'favicon.png', 'yes'),
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
(26, 'site_hero', 'heroimg.jpg', 'yes'),
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
(42, 'fav_colour', 'none', 'yes');

-- --------------------------------------------------------

--
-- Dumping data for table `elybin_posts`
--
INSERT INTO `elybin_posts` (`post_id`, `title`, `content`, `date`, `author`, `seotitle`, `tag`, `image`, `status`, `parent`, `visibility`, `hits`, `comment`, `post_password`, `post_meta`, `category_id`, `type`) VALUES
(1, '6 Tips Untuk Menata Interior Rumah Minimalis', '&lt;p&gt;&lt;strong&gt;6 Tips Untuk Menata Interior Rumah Minimalis &lt;/strong&gt; - Menata sebuah ruangan rumah minimalis  bisa di bilang susah susah gampang, meskipun hanya menata saja akan  tetapi terdapat beberapa aspek yang perlu Anda diperhatikan untuk menata  sebuah interior rumah. Dalam menata sebuah interior rumah Anda perlu  menata perabot,furnitur,atau yang lainnya sedemikian rupa sehingga rumah  Anda tidak terlihat monoton itu-itu saja. Nah, berikut ini kami sajikan  beberapa tips untuk Anda, untuk menata sebuah interior rumah minimalis Anda, seperti yang dilansir oleh &lt;em&gt;desaininterior.me&lt;/em&gt;. Baca juga Warna Dapur Cantik Minimalis Untuk Rumah Anda.&lt;/p&gt;&lt;p&gt;&lt;br&gt;&lt;/p&gt;&lt;p&gt;1. Dalam memilih konsep desain interior  minimalis adalah konsep dengan mengedepankan pas dan tidak berlebihan.  Maka dari itu pilihlah sebuah perabot/furniture dalam rumah yang  bersih,tegas,bergaris lurus dan sebisa mungkin berbentuk geometris. &lt;br&gt;&lt;/p&gt;&lt;p&gt;2. Gunakan hanya 1 palet warna saja dalam ruangan. Jangan lupa  berikan aksen warna yang berbeda sehingga tercipta kesan yang tenang  tapi menghapus kemonotonan. &lt;br&gt;&lt;/p&gt;&lt;p&gt;3. Gunakan sistem pencahayaan yang menggunkan model lamp down light,  pendant berbentuk kotak-kotak yang simple dan indirect lighting. &lt;br&gt;&lt;/p&gt;&lt;p&gt;4. Hindarkan nuansa yang penuh pada ruangan dan hanya gunakan perabotan  yang memiliki fungsi maksimal. Jika ingin menambahkan aksesoris  boleh-boleh saja tapi pilih yang bentuk atau modelnya sederhana. &lt;br&gt;&lt;/p&gt;&lt;p&gt;5. Buat laci-laci atau kabinet tertutup yang seakan tersembunyi untuk  tempat meletakkan barang-barang Anda sehingga ruangan tetap terlihat  bersih dan lapang. &lt;br&gt;&lt;/p&gt;&lt;p&gt;6. Jika ingin menambahkan karpet pilih dengan warna yang solid tanpa motif.&lt;/p&gt;&lt;p style=&quot;text-align: left;&quot;&gt;Itulah dia beberapa tips dari kami yang bisa kami sajikan untuk Anda, semoga sedikit tips menata interior rumah minimalis di atas bisa bermanfaat, dan memudahkan Anda dalam mendesain interior rumah idaman Anda.&lt;/p&gt;&lt;p style=&quot;text-align: left;&quot;&gt;Sumber: www.idearumahidaman.com&lt;br&gt;&lt;/p&gt;', '2015-06-30 23:14:22', 1, '6-tips-untuk-menata-interior-rumah-minimalis', '', 'image-7823-6-tips-untuk-menata-interior-rumah-minimalis.jpg', 'publish', 0, 'public', 0, 'allow', '', '{"post_meta":"false"}', 1, 'post'),
(2, 'Tips Menyimpan Rempah dan Bumbu Kering', ' &lt;p&gt; Menyimpan bumbu masak dalam bentuk kering seperti  merica, jintan, kayu manis, cabai bubuk dan rempah-rempah lain  memerlukan penanganan khusus. Walaupun bahan masak kering jauh lebih  awet dibandingkan bahan basah, Anda harus tetap memerhatikan kesegaran  dan keawetannya saat proses penyimpanan.&lt;br&gt;&lt;br&gt;1. Simpan rempah-rempah  dan bumbu kering di dalam wadah kaca/plastik yang bersih dan kering.  Letakkan wadah tersebut di daerah yang gelap dan jauh dari panas. Rempah  dan bumbu kering yang sering mendapat terpaan sinar matahari langsung  dan panas akan mudah rusak.&lt;br&gt;&lt;br&gt;2. Saat akan mengambil rempah dan bumbu kering di dalam wadah, pastikan tangan Anda atau sendok untuk mengambilnya kering. &lt;br&gt;&lt;br&gt;3.  Karena bumbu kering (apalagi dalam bentuk bubuk) sulit dibedakan satu  dan yang lain, untuk menghemat waktu memasak, beri label pada setiap  botol sesuai dengan isinya. Anda bisa memakai kertas perekat yang banyak  di jual di toko buku.&lt;br&gt;&lt;br&gt;4. Tips lain untuk memudahkan proses  memasak, urutkan rempah dan bumbu kering yang paling sering Anda gunakan  di bagian luar atau sisi yang dekat dengan tempat memasak Anda. &lt;b&gt;(vem/wsw)&lt;br&gt;&lt;br&gt;&lt;/b&gt;Sumber : Vemale.com&lt;/p&gt;', '2015-06-15 07:19:18', 1, 'tips-menyimpan-rempah-dan-bumbu-kering', '', 'image-4667-tips-menyimpan-rempah-dan-bumbu-kering.jpg', 'publish', 0, 'public', 1, 'allow', '', '{"post_meta":"false"}', 1, 'post'),
(3, 'Raja Ampat: Ekspedisi Bawah Laut Terbaik di Dunia', '&lt;p class=&quot;MsoNormal&quot;&gt;&lt;b&gt;Travel - &lt;/b&gt;Tak salah jika indonesia adalah surganya alam bawah laut kelas dunia. Selain mempunyai keindahan alam bawah laut di wakatobi, indonesia yang terdiri dari kepulauan mempunyai banyak tempat-tempat yang memiliki keindahan alam bawah laut salah satunya di raja ampat. Raja ampat di papua memiliki ribuan jenis ikan, jadi tak heran jika Dr.G.R. Allen menyebutnya sebagai laut yang kaya akan ikannya.&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Raja ampat adalah sebuah nama yang diberikan oleh penduduk setempat untuk 4 pulau besar yang terletak di barat bagian kepala burung (vogelkoop) pulau papua. Keempat pulau tersebut adalah Waigeo, salawati, batanta dan misool. Keindahan alam bawah laut di raja ampat ini termasuk 1 dari 10 perairan di dunia untuk tempat diving terbaik. Hal ini dikarenakan di perairan raja ampat terdapat lebih dari 540 jenis karang keras, sehingga menjadikan 75% karang di seluruh dunia berada di alam bawah laut raja ampat. &lt;br&gt;&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Tak hanya itu, 1511 spesies ikan dan 700 jenis moluska menjadi penghuni alam bawah laut di raja ampat. Menyelami keindahan alam bawah laut raja ampat, sobat akan menjelajahi dinding bawah laut yang vertical dengan diombang-ambingkan arus laut. Mantaray dan wobbegong akan menyambut kedatangan sobat. Bahkan beberapa jenis ikan seperti snapper, tuna, barracuda akan menjadi teman setia ketika sobat sedang menikmati keindahan alam bawah laut raja ampat.&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Cara menuju raja ampat dapat ditempuh dengan penerbangan dari jakarta menuju sorong dengan perjalanan sekitar 6 jam. Kemudian perjalanan dilanjutkan dari sorong menuju waisai menggunakan feri yang berangkat sekitar pukul 13.00 WIT. Waisai merupakan ibukota raja�ampat�yang terletak di pulau waigeo. Perjalanan dari�sorong menuju waisai memakan waktu sekitar 2 jam. Selain di Raja Ampat dan Wakatobi, Indonesia masih memiliki keindahan alam bawah laut lainya yakni di Taman Laut Bunaken&lt;/p&gt;&lt;p class=&quot;MsoNormal&quot;&gt;Sumber: www.sobatpetualang.com&lt;/p&gt;', '2015-06-30 23:33:26', 1, 'raja-ampat-ekspedisi-bawah-laut-terbaik-di-dunia', '', 'image-4000-raja-ampat-ekspedisi-bawah-laut-terbaik-di-dunia-.jpg', 'publish', 0, 'public', 1, 'allow', '', '{"post_meta":"false"}', 1, 'post'),
(4, 'Buat website cepat dan mudah, pakai Elybin CMS', '<p><span style="font-weight: bold;">Teknologi</span> - Informasi kini sudah menjadi hal yang mudah dan milik banyak orang. Banyak sekali media yang bisa digunakan untuk mendapatkan berbagai informasi, salah satunya adalah internet. Media yang satu ini, sering dianggap sebagai pangsa pasar terbaik dari media lain. </p>\n<p>Ya, benar adanya memang, mengingat 4 miliar orang, kini sudah terhubung ke internet. Memberikan 1/3 dari seluruh penduduk dunia untuk mengetahui bisnus anda. Atau anda juga punya kesempatan 100 juta pengguna yang mencari website anda setiap detik melalui mesin pencari. </p>\n<p>Internet sejatinya adalah sebuah jaringan (<span style="font-style: italic;">network)</span> yang menghubungkan miliaran perangkat - perangkat yang ada di dunia, dan untuk membuatnya mampu menampilkan beragam informasi yang bermanfaat, maka dibuatlah sebuah tatap muka (<span style="font-style: italic;">interface)</span> atau biasa disebut <span style="font-style: italic; font-weight: bold;">Website/Blog. </span></p>\n<p><span style="line-height: 18.5714282989502px;">Sayangnya... </span><span style="line-height: 1.42857143;">Untuk membuat sebuah website/blog banyak orang rela membayar ratusan ribu bahkan jutaan rupiah, hanya untuk sebuah website sederhana. Belum lagi menejemen dan perawatan yang terus menghantui website anda.  Taukah anda? Dengan menggunakan Elybin CMS, anda bisa membuat website atau profil perusahaan anda hanya dengan beberapa klik! Bahkan ada bisa membuatnya sendiri. Buktikanlah! </span></p>\n<p><span style="font-weight: bold;">Elybin CMS</span> adalah satu dari beberapa CMS (Content Management System) yang ada di dunia. Sistem ini menawarkan kemudahan dan kecepatan dalam membuat dan memenejemen website anda. Jadi anda tidak lagi kerepotan untuk mengelola website anda sendiri. Selain itu, Elybin CMS didukung tema dan plugin tambahan yang mampu menyulap website anda menjadi <span style="font-style: italic;">Toko Online, Jurnal Aktifitas, Aplikasi Prakerin, Aplikasi Kasir </span>bahkan sampai <span style="font-style: italic;">Pendaftaran Lomba Foto </span>bisa dibuat sendiri dengan Elybin CMS<span style="font-style: italic;">.</span></p>\n<p><span style="font-style: italic;"></span>Yang paling penting, sistem ini adalah gratis untuk semua orang, untuk kalangan apa saja. Untuk website apa saja, sehingga, cocok untuk membuat website tanpa biaya. (Baca: Daftar Hosing Website Gratis)<br></p>\n<p>Tunggu apa lagi, buat website kamu dengan Elybin CMS! Gratis!  </p>\n\n<p style="text-align: center; "><a href="http://www.elybin.github.io/" target="_blank" class="btn btn-lg btn-info">Download Elybin CMS - Buat Website Gratis</a></p>', '2015-07-01 00:26:41', 1, 'buat-website-cepat-dan-mudah-pakai-elybin-cms', '', 'image-1-elybin-cms-buat-website-cepat-mudah-gratis-buatan-indonesia.jpg', 'publish', 0, 'public', 633, 'allow', '', '{"post_meta":"false"}', 1, 'post'),
(5, 'Tentang Elybin CMS - Website Professional Tanpa Repot', '<h2 style="text-align: center;" class="section-heading">Elybin CMS</h2><h3 style="text-align: center;" class="section-subheading text-muted">Modern, Powerful & Beautiful.</h3><hr><p><span style="font-weight: bold;">ElybinCMS</span> hadir memberikan solusi untuk anda yang ingin membuat website professional untuk pribadi, perusahaan ataupun komunitas dengan mudah dan cepat. Dengan beberapa fitur unggulan yang mudah digunakan membuat berbagi informasi menjadi lebih cepat dan efisien.</p><p>Desain minimalis dipilih untuk lebih memudahkan pengguna dalam menggunakan sistem ini. <span style="font-style: italic;">ElybinCMS</span> juga menggunakan <span style="font-style: italic;">Bootstrap</span> sehingga mampu diakses dari semua perangkat termasuk <span style="font-style: italic;">Gadget</span> kesayangan anda.</p><img src="elybin-file/media/candiplaosanklatendavidraka-2015-07-01_01-48-22-6539.jpg" style="width: 100%;"><p><br></p>', '2015-07-01 09:50:52', 1, 'tentang-elybin-cms--website-professional-tanpa-repot', '', '', 'active', 0, '', 0, 'allow', '', '', 0, 'page');

-- --------------------------------------------------------

--
-- Dumping data for table `elybin_relation`
--

INSERT INTO `elybin_relation` (`rel_id`, `type`, `target`, `first_id`, `second_id`) VALUES
(1, 'album', 'media', 1, 1);


--
-- Dumping data for table `elybin_tag`
--

INSERT INTO `elybin_tag` (`tag_id`, `name`, `seotitle`, `count`) VALUES
(1, 'Share', 'share', 1),
(2, 'Tutorial', 'tutorial', 1),
(3, 'Story', 'story', 1),
(4, 'Tips', 'Tips', 1);

-- --------------------------------------------------------


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
(1, '127.0.0.1', '2014-12-29', 1, '2015-06-14 10:58:52', 'allow', 0);


--
-- Dumping data for table `elybin_widget`
--

INSERT INTO `elybin_widget` (`widget_id`, `name`, `type`, `content`, `position`, `sort`, `status`, `show`) VALUES
(1, 'Social Media', 'include', './elybin-main/socialmedia/widget.php', 2, 2, 'active', '[''all'']'),
(2, 'Subscribe', 'include', './elybin-main/subscribe/widget.php', 2, 4, 'active', '[''index'']'),
(3, 'Recent Popular', 'include', './elybin-main/recentpopular/widget.php', 2, 3, 'active', '[''all'']'),
(4, 'HTML', 'code', '&lt;h1&gt;Test&lt;/h1&gt;', 1, 1, 'active', '[''all'']'),
(5, 'Statistic', 'admin-widget', './widget/statistic/widget.php', 1, 2, 'active', ''),
(6, 'Statistic Box', 'admin-widget', './widget/statisticbox/widget.php', 1, 3, 'active', ''),
(7, 'News & Tips', 'admin-widget', './widget/newstips/widget.php', 2, 2, 'active', ''),
(8, 'Quick Post', 'admin-widget', './widget/quickpost/widget.php', 2, 2, 'deactive', ''),
(9, 'Notification Widget', 'admin-widget', './widget/notification/widget.php', 2, 2, 'active', ''),
(10, 'Recent Widget', 'admin-widget', './widget/recent/widget.php', 3, 1, 'active', ''),
(11, 'Welcome', 'admin-widget', './widget/welcome/widget.php', 1, 1, 'active', ''),
(14, 'Login Panel', 'include', './elybin-main/login/widget.php', 2, 1, 'active', '[''all'']');

