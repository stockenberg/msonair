<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 22.10.2016
 * Time: 21:04
 */

namespace src\controller;


use src\core\Core;
use src\core\Session;
use src\model\DocumentManagementModel;

class DocumentManagementController extends Core
{

    public $studentlist;
    private $model;
    public $files;

    public function __construct()
    {
        parent::__construct();
        $this->model = new DocumentManagementModel();
        $this->run();
    }

    public function run()
    {
        $this->studentlist = $this->model->getAllStudents("user_intrested_in ASC");
        $this->validateUpload($this->request);
        $this->files = $this->model->getFiles(Session::get("logged_user", 0, "user_intrested_in"));
        switch ($this->request["action"]) {
            case "delete":
                $this->model->deleteFile($this->request["delete"]);
                $this->redirect("documentmanagement");
                break;
        }
    }

    private function validateUpload($data)
    {
        if (isset($this->request["upload"]["submit"])) {
            if ($_REQUEST["upload"]["error"]["file"] < 1) {
                $file = $_FILES["upload"]["tmp_name"]["file"];
                $filename = $_FILES["upload"]["name"]["file"];
                $dest = __ASSETS__ . "files/" . $filename;

                move_uploaded_file($file, $dest);
                $this->model->saveFile($filename, Session::get("logged_user", 0, "user_intrested_in"));
            } else {
                throw new \Exception("Fehler bei Dateiupload...");
            }
        }
    }

}