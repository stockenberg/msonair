<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 22.10.2016
 * Time: 21:04
 */

namespace src\controller;


use src\core\Core;
use src\model\VideoManagementModel;

class VideoManagementController extends Core
{

    public $studentlist;
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new VideoManagementModel();
        $this->run();
    }

    public function run()
    {
        $this->studentlist = $this->model->getAllStudents("user_intrested_in ASC");
    }



}