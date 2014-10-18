<?php
defined('main') or die('Sorry, so aber nicht!');

class download {

    public $author = '2014 by <a href="http://balthazar3k.howald-design.ch/">angelo.b3k</a> & <a href="http://howald-design.ch/">howaldi</a>';
    public $description = 'Das Download Script erweitert das Standart Download Script von ilch!';

    public function folders(){
        return array(
            'include/images/download/',
            'include/images/downcats/'
        );
    }

    public function install(Install $install) {
        return db_query("
            ALTER TABLE `prefix_downcats` ADD `img` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
            ALTER TABLE `prefix_downloads` ADD `demo` VARCHAR( 255 ) CHARACTER SET latin1 COLLATE latin1_german2_ci NOT NULL AFTER `ssurl`;
            ALTER TABLE `prefix_downloads` ADD `drecht` TINYINT(4) NOT NULL DEFAULT '0';
        ");
    }
}
?>