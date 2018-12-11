<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 06.10.2016
 * Time: 23:11
 */

namespace src\core;


use src\helpers\Helper;

class Status extends Helper
{
    private static $status = array();

    public function __construct($key, $value)
    {
        parent::__construct();
        self::set($key, $value);
    }

    public static function set($key, $value)
    {
        self::$status[$key][] = $value;
    }

    public static function setD($key, $value)
    {
        self::$status[$key] = $value;
    }

    public static function read($key = false)
    {
        if (in_array($key, self::$status) && $key) {
            return self::$status[$key];
        } else {
            return self::$status;
        }
    }

    public static function get($key = false)
    {
        return self::$status[$key] ?? "";

    }
}