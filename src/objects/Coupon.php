<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 03.05.17
 * Time: 14:34
 */

namespace src\objects;


class Coupon
{

    private $prefix = "coupon_";
    public $confirmed = false;
    public $data = [];


    public function __set($name, $value)
    {
        if (!preg_match("/coupon/", $name)) {
            $name = $this->prefix . $name;
        }
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        $name = $this->prefix . $name;

        if (isset($this->data[$name])) {
            return $this->data[$name];
        }
        return NULL;
    }

}
