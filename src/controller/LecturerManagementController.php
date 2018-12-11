<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 26.10.2016
 * Time: 22:39
 */

namespace src\controller;


use src\core\Core;
use src\model\LecturerManagementModel;
use src\model\User;

class LecturerManagementController extends Core
{

    public $lecturers;
    private $model;
    public $labels;

    public function __construct()
    {
        parent::__construct();
        $this->model = new LecturerManagementModel();
        $this->run();
    }

    private function run()
    {
        $this->lecturers = $this->model->getLecturers();
        $this->labels = $this->model->labels;
        $this->validateLecturer();
    }

    private function validateLecturer(){
        if(isset($this->request["user"]["submit"])){
            // TODO : Validate Inputs
            $this->model->saveLecturer($this->request["user"]);
            $this->redirect("manage-lecturers");
        }
    }



}