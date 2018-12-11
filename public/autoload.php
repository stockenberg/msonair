<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 30.09.2016
 * Time: 11:49
 */

spl_autoload_register(function ($class) {
    $file = '../' . str_replace("\\", "/", $class) . '.php';
    if (file_exists($file)) {
        require $file;
        return true;
    }
});