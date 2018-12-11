<?php
/**
 * Created by PhpStorm.
 * User: workstation
 * Date: 28.11.16
 * Time: 23:15
 */

namespace src\controller;


use src\core\Core;
use src\model\ForgotPWModel;

class ForgotPWController extends Core
{

    public $data;
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->run();
    }

    public function run()
    {
        if(isset($this->request["forgot"]["submit"])){
            $this->username = $this->request["forgot"]["username"];
            $this->email = $this->request["forgot"]["email"];

            $this->model = new ForgotPWModel();
            $this->model->generateResetLink($this->data);

        }
    }

    public function __get($k)
    {
        return $this->data[$k];
    }

    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }

}