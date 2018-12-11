<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 06.11.2016
 * Time: 15:23
 */

namespace src\controller;


use src\ajax\model\RoomModel;
use src\core\Core;
use src\core\Session;

class RoomController extends Core
{
    public $rooms;
    public $data;
    private $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new RoomModel();
        $this->run();
    }

    public function run()
    {
        $this->lessonComplete();


        switch (Session::getStatus()){
            case __TEACHER__:
            case __ADMIN__:
                    $this->rooms = $this->model->getRoomForTeacher();
                break;

            case __STUDENT__ :
                    $this->rooms = $this->model->getRoomForStudent();
                break;
        }

    }

    private function lessonComplete()
    {
        if(isset($this->request["action"])){
            $this->roomHash = $this->request["raum"];
            $this->model->completeLesson($this->roomHash);
            $this->redirect("unterrichtsraum");
        }
    }

    public function __set($key, $value)
    {
        $this->data[$key] = $value;
    }

    public function __get($key)
    {
        return $this->data[$key];
    }
}