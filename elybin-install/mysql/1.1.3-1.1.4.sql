--
-- Upgrade from 1.1.3 to version 1.1.4
--

-- Add New
-- Target table: elybin_options
INSERT INTO `elybin_options` (`name`, `value`, `active`) VALUES
('url_rewrite_style', 'dynamic', 'yes'),
('template', 'young-free', 'yes'),
('content_language', 'en-US', 'yes'),
('search_engine_visibility', 'index, follow', 'yes'),
('album_per_page', '1', 'yes'),
('photo_per_album', '2', 'yes'),
('global_option_replace', 'active', 'yes'),
('database_version', '1.1.4', 'yes');

-- Modify
-- Target table: elybin_media
ALTER TABLE  `elybin_media` ADD  `seotitle` VARCHAR( 300 ) NOT NULL AFTER  `title` ;

-- Remove
-- Target table: elybin_album
DROP TABLE `elybin_album`;
