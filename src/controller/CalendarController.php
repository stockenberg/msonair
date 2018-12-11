<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 01.11.2016
 * Time: 20:22
 */

namespace src\controller;


use src\core\Core;
use src\model\CalendarModel;

class CalendarController extends Core 
{
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new CalendarModel();
        $this->run();
    }

    public function run()
    {
        $this->allTeachers = $this->model->getAllTeachers();
    }



}