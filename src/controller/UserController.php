<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 05.11.2016
 * Time: 11:49
 */

namespace src\controller;


use src\core\Core;
use src\model\User;

class UserController extends Core
{

    public $files;
    public $videos;
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new User();
        $this->run();
    }

    public function run()
    {
        switch ($this->request["p"]){
            case "dateien":
                $this->files = $this->model->getFiles();
                break;
            case "videos":
                $this->videos = $this->model->getVideos();
                break;
        }
    }

}