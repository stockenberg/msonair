<?php
/**
 * Created by PhpStorm.
 * User: mstoc
 * Date: 23.10.2016
 * Time: 19:31
 */

namespace src\ajax\model;


use src\model\Model;

class AjaxDocumentmanagementModel extends Model
{

    public function __construct($request)
    {
        parent::__construct();
        $this->run($request);
    }

    public function run($request)
    {
        switch ($request["action"]) {
            case "delete":
                $this->deleteAssociation($request);
                break;

            case "create":
                echo "test";
                $this->setAssociation($request);
                break;
        }
    }

    private function setAssociation($data)
    {
        $SQL = "INSERT INTO msonair_associate_files_to_users (associated_user_id, associated_file_id)
                VALUES (:user_id, :file_id)";

        $this->set($SQL, [":user_id" => $data["user_id"], ":file_id" => $data["file_id"]]);
        echo "Datei freigeschalten, ID: " . $data["file_id"];

    }

    private function deleteAssociation($data)
    {

        $SQL = "DELETE FROM msonair_associate_files_to_users 
                WHERE associated_user_id = :user_id 
                AND associated_file_id = :file_id";

        $this->set($SQL, [":user_id" => $data["user_id"], ":file_id" => $data["file_id"]]);
        echo "Datei gelöscht, ID: " . $data["file_id"];
    }

}