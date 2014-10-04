ALTER TABLE `prefix_downcats` ADD `img` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
ALTER TABLE `prefix_downloads` ADD `demo` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL AFTER `ssurl`;
ALTER TABLE `prefix_downloads` ADD `drecht` TINYINT(4) NOT NULL DEFAULT '0',