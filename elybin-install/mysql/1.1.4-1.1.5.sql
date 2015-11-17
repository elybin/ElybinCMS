--
-- Upgrade from 1.1.4 to version 1.1.5
--

-- Add New
-- Target table: elybin_options
INSERT INTO `elybin_options` (`name`, `value`, `active`) VALUES
('allow_upload_unknown', 1, 'yes');

-- Modify
-- Target table: elybin_media
UPDATE  `elybin_options` SET  `value` =  '1.1.5' WHERE  `name` =  'database_version';

-- Remove
-- Target table: elybin_themes
DROP TABLE `elybin_themes`;
