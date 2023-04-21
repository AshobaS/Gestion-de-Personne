<?php
define('BASE_PATH', realpath(dirname(__FILE__)));
class Autoloader {
    static public function loader($className) {
        $filename = BASE_PATH.DIRECTORY_SEPARATOR.str_replace("\\", DIRECTORY_SEPARATOR, $className).".php";
        if (file_exists($filename)) {
            require_once($filename);
        if (class_exists($className))
            return TRUE;
        return FALSE;
        }
    }
}
spl_autoload_register('Autoloader::loader');