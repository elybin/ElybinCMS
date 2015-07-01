
--
-- Table structure for table `elybin_album`
--

CREATE TABLE IF NOT EXISTS `elybin_album` (
  `album_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `seotitle` varchar(100) NOT NULL,
  `date` datetime NOT NULL,
  `status` varchar(20) NOT NULL DEFAULT 'active',
  PRIMARY KEY (`album_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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
-- Table structure for table `elybin_themes`
--

CREATE TABLE IF NOT EXISTS `elybin_themes` (
  `theme_id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `author` varchar(100) NOT NULL,
  `url` varchar(100) NOT NULL,
  `folder` varchar(100) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'deactive',
  PRIMARY KEY (`theme_id`)
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
  `website` varchar(255) NOT NULL DEFAULT 'www.elybin.com',
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
