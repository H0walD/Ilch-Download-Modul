<?php
defined('main') or die('Sorry, so aber nicht!');

class download {

    public $author = '2014 by <a href="http://balthazar3k.howald-design.ch/">angelo.b3k</a> & <a href="http://howald-design.ch/">Howaldi</a>';
    public $description = 'Das Download Script erweitert das Standart Download Script von ilch!';

    public function folders(){
        $folders = array(
            'include/images/downloads/',
            'include/images/downcats/'
        );

        foreach( $folders as $folder ){
            @mkdir($folder);
        }

        return $folders;
    }

    public function install(Install $install) {
        $status = array();
        $status[] = db_query("ALTER TABLE `prefix_downcats` ADD `img` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;");
        $status[] = db_query("ALTER TABLE `prefix_downloads` ADD `demo` VARCHAR( 255 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL AFTER `ssurl`;"); 
        $status[] = db_query("ALTER TABLE `prefix_downloads` ADD `drecht` TINYINT(4) NOT NULL DEFAULT '0';");

        return !in_array(false, $status);
    }

    public function deinstall() {
        /* Deinstalliert nur die Datenbank einträge */
        $status = array();
        $status[] = db_query("ALTER TABLE `prefix_downcats` DROP `img`;");
        $status[] = db_query("ALTER TABLE `prefix_downloads` DROP `demo`;");
        $status[] = db_query("ALTER TABLE `prefix_downloads` DROP `drecht`;");

        return !in_array(false, $status);
    }
}
?>