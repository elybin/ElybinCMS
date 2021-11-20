-- 
-- Upgrade to version 1.1.3-dev
--

-- Add Table
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

CREATE TABLE IF NOT EXISTS `elybin_relation` (
  `rel_id` int(10) NOT NULL AUTO_INCREMENT,
  `type` varchar(100) NOT NULL,
  `target` varchar(100) NOT NULL,
  `first_id` int(10) NOT NULL,
  `second_id` int(10) NOT NULL,
  PRIMARY KEY (`rel_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

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

-- Delete Table 
DROP TABLE `elybin_gallery`,`elybin_contact`,`elybin_pages`,`elybin_album`,`com.elybin_subscribe`;


-- Edit Table
ALTER TABLE `elybin_notification` 
  CHANGE `type` `type` VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'info', 
  CHANGE `icon` `icon` VARCHAR(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL

ALTER TABLE `elybin_notification` 
  DROP `gambar`